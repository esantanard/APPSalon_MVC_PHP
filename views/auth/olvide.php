<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablece tu contraseña </p>
<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>


<form action="/olvide" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Ingrea tu email">
    </div>
    <input type="submit" value="Recuperar contraseña" class="boton">
</form>

<div class="acciones">
    <a href="/">Iniciar sesion</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>