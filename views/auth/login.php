<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Incia sesion con tus datos</p>
<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>


<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Tu email" value="<?php echo s($auth->email);?>" require>
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu password" require>
    </div>

    <input type="submit" value="Ingresar" class="boton">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Crear cuenta</a>
    <a href="/olvide">Olvide Password</a>
</div>