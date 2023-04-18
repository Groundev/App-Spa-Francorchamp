<?php
namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;


class APIController{
    public static function index (){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }
    public static function guardar(){

        // ALmacena la Cita y Devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena la Cita y el Servicio

        // ALmacena los Servicios con el id de la cita 
        $idServicios = explode(',', $_POST['servicios']);

        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        // Retornamos una respuesta
        
        echo json_encode(['resultado' => $resultado]);

    }

    public static function eliminar(){
       if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $cita = Cita::find($_POST['id']);
        $cita->eliminar();
        header('Location:' . $_SERVER['HTTP_REFERER']);
       }
    }


}