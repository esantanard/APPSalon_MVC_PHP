<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administracion Servicios</p>

<?php
include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">
    <?php include_once __DIR__ . "/formulario.php" ; ?>

    <input type="submit" value="Guardar" class="boton">
</form>