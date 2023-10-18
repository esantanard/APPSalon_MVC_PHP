<h1 class="nombre-pagina">Reestablecer Password</h1>
<p class="descripcion-pagina">Ingresa tu nuevo password</p>
<?php 
    include_once __DIR__ . '/../templates/alertas.php';
?>

<?php if($error) return; ?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="Tu nuevo password">
    </div>
    <input type="submit" value="Enviar password" class="boton">
</form>

<div class="acciones">
    <a href="/">Iniciar sesión</a>
    <a href="/crear-cuenta">Crear cuenta</a>
</div>