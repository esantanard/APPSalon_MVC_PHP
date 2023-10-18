<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{
    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){
        // $respuesta = [
        //     'datos' => $_POST
        // ];
            /*Almacena la cita y devuelve el ID*/
        $cita = new Cita($_POST);
        $resultado = $cita ->guardar();
        $id = $resultado['id'];

            // $respuesta =[
            //     'cita' => $cita
            // ];
        
            $idServicios = explode(",", $_POST['servicios']);
                /*Almacena los servicios con el ID de la cita*/
            foreach($idServicios as $idServicio){
                $args = [
                    'citaId' => $id,
                    'servicioId' => $idServicio
                ];
                $citaServicio = new CitaServicio($args);
                $citaServicio->guardar();
            }

        // $respuesta = [
        //     'resultado' => $resultado
        // ];
        
        echo json_encode(['resultado' => $resultado ]);
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $cita->eliminar();
            
            header("Location:" . $_SERVER['HTTP_REFERER']);
        }
    }
}