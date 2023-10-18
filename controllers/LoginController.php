<?php
namespace Controllers;

use Model\Usuario;
use MVC\Router; 
use Classes\Email;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuario;
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                //Comprobar que el usuario existe en la base de datos
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    if($usuario->comprobarPassAndVerificado($auth->password)){
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        }else{
                           header('Location: /cita');
                        }
                    }
                }else{
                    Usuario::setAlerta('error', "Usuario no encontrado");
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout(){
        $_SESSION = [];

        header("Location: /");
    }

    public static function olvide(Router $router){
        $alertas =[];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth= new Usuario($_POST);
            $alertas = $auth->validarEmail();
            
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado === "1"){
                    //Generar nuevo token
                    $usuario->crearToken();
                    $usuario->guardar();
                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', "Instrucciones enviadas a tu email");
                }else{
                    Usuario::setAlerta('error', "Usuario no existe o no esta confirmado");
                   
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router){
        $alertas = [];
        $error= false;
        $token = s($_GET['token']);

        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', "Token no valido");
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $password = new Usuario($_POST);
            $alertas = $password->validarPass();

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
        $router->render('auth/reestablecer',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router){
        $usuario = new Usuario;

        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            //Revisar arreglo alerta este vacio
            if(empty($alertas)){
               $resultado = $usuario->existeUsuario();
                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    //No registrado
                    $usuario->hashPassword();

                    //Generar un token unico
                    $usuario->crearToken();

                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario'=>$usuario,
            'alertas'=>$alertas
        ]);
    }

    public static function mensaje(Router $router){    
        $router->render('auth/mensaje');
    }
    
    public static function confirmar(Router $router){   
        $alertas = []; 
        $token = s($_GET['token']);
        $usuario = Usuario::where("token", $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
        }else{
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', "Cuenta comprobada correctamente");
        }

        $alertas=Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}