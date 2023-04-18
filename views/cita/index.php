<?php 
    $script = "
        <script src='build/js/app.js'</script'>
        " 
?>

<?php
include_once __DIR__ . "/../templates/barra.php";
?>

<h1 class="nombre-pagina">Reservar hora</h1>
<p class="descripcion-pagina">Elige los servicios y escriba sus datos</p>



<div class="app">

<nav class="tabs">
    <button class="actual" type="button" data-paso="1">Servicios</button>
    <button type="button" data-paso="2">Datos y fecha de cita</button>
    <button type="button" data-paso="3">Resumen</button>
</nav>

    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige los servicios</p>
    <div id="servicios" class="listado-servicios"></div>
</div>
<div id="paso-2" class="seccion">
    <h2>Datos y fecha de cita</h2>
    <p class="text-center">Coloque sus datos y confirme la fecha y hora </p>
    <form class="formulario">
        <div class="campo">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" placeholder="Tu Nombre" value="<?php echo $nombre; ?>" disabled>
        </div>
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
        </div>
        <div class="campo">
            <label for="hora">Hora</label>
            <input type="time" id="hora" >
        </div>
        <input type="hidden" id="id" value="<?php echo $id; ?>" >
    </form>
</div>
    <div id="paso-3" class="seccion contenido-resumen">
    <h2>Resumen</h2>
    <p class="text-center">Verfica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo;</button>
    </div>
</div>

<?php 
    $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script defer src='build/js/app.js'></script>
        " 
?>