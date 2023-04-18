<?php

namespace Controllers;

use Model\Usuario;
use Model\ActiveRecord;
use MVC\Router;
use Classes\Email;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];
        $auth = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
           $auth = new Usuario($_POST);

           $alertas = $auth->validarLogin();

            if(empty($alertas)){
            // Comprobar que exita el usuario
                $usuario = Usuario::where('email', $auth->email);

                 if($usuario){
                     // Verificar el password
                    if( $usuario->checkFunctionAndVerified($auth->password)){
                     // Autenticar el usuario
                      session_start();
                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;

                    //Redireccionamiento
                    if($usuario->admin === "1"){
                        $_SESSION['admin'] = $usuario->admin ?? null;

                        header('Location: /admin ');
                    }else{
                        header('Location: /cita ');
                    }
                }

                }else{
                Usuario::setAlerta('error', 'Usuario No Encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
    
        // $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: / ');
    }
    public static function olvide(Router $router)
    {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1"){
                    // Generar un token de un solo uso
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enviar email de con las instrucciones
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Email enviado para el cambio de contraseña');
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
        // Buscar usuario por token
            Usuario::setAlerta('error', 'Token No Válido');
            $error = true;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Leer el nuevo password y cambiarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();

                $usuario->token = null;

               $resultado = $usuario->guardar();

                if($resultado){
                    header('Location: /');

                }

            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }
    public static function crear(Router $router)
    {
        $usuario = new Usuario($_POST);

        // Alertas vacias
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
        
        // Revisar que alertas este vacio

            if(empty($alertas)){
            // Verificar que el usuario no este registrado
               $resultado = $usuario->existeUsuario();

               if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
               }else{
                // HAsehar el Password
                $usuario->hashPassword();

                // Generar un token Unico
                $usuario->crearToken();

                // Enviar el Email
                $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                $email->enviarConfirmacion();

                // Crear usuario
                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /mensaje');
                }
               }

            }
        }
        
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario, 
            'alertas' => $alertas
        ]);
    }
    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token No Válido');
        }else{
            // Modificar a usuario confirmado
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada Correctamente');
            
        }

        // Obtener Alerta
        $alertas = Usuario::getAlertas();
        // Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);

    }
}
