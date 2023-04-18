<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{

    public $nombre;
    public $email;
    public $token;
public function __construct($nombre, $email, $token){
   
    $this->nombre = $nombre;
    $this->email = $email;
    $this->token = $token;
}
public function enviarConfirmacion(){
    // Crear objeto Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '13b74c651a4e12';
    $mail->Password = 'ff887b7576bdd9';

    $mail->setFrom('cueSpa-Francorchampnt@.com');
    $mail->addAddress('cuenta@circuitbelgium.com', 'Spa-Francorchamp.com');
    $mail->Subject = 'Confirma tu cuenta';


    // SET HTML
    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';


    $contenido = "<html>";
    $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Dentist, confirma tu cuenta en el siguiente enlace</p>";
    $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
    $contenido .= "<p>Si no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
    $contenido .= "<html>";

    $mail->Body = $contenido;

     // Enviar el Mail
     $mail->send();

    }
    public function enviarInstrucciones(){

        // Crear objeto Email
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '13b74c651a4e12';
    $mail->Password = 'ff887b7576bdd9';

    $mail->setFrom('cuenta@appsalon.com');
    $mail->addAddress('cuenta@appsalon.com', 'AppSalon.com');
    $mail->Subject = 'Reestablecer contraseña';


    // SET HTML
    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';


    $contenido = "<html>";
    $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu contraseña, cambia tu contraseña en el siguiente enlace</p>";
    $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
    $contenido .= "<p>Si no solicitaste cambiar la contraseña, puedes ignorar el mensaje</p>";
    $contenido .= "<html>";

    $mail->Body = $contenido;

     // Enviar el Mail
     $mail->send();
    }
}

?>