<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;
class Email{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){
        $this->email = $email;    
        $this->nombre = $nombre;    
        $this->token = $token;    
    }
    public function enviarConfirmacion(){
        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = "Confirma tu cuenta";

        $mail->isHTML(true);
        $mail->CharSet= "UTF-8";
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        $mail->send();
    }
    public function enviarInstrucciones(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = "Reestablecer password";

        $mail->isHTML(true);
        $mail->CharSet= "UTF-8";
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong>, has solicitado reestablecer tu password, sigue el siguiente enlace para reestablecer tu password</p>";
        $contenido .= "<p>Presiona aqui: <a href='" . $_ENV['APP_URL'] . "/reestablecer?token=" . $this->token . "'>Reestablecer password</a></p>";
        $contenido .= "<p>Si no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        $mail->send();
    }
}