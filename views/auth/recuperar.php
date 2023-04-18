<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña a continuacion</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>
<?php if($error) return null; ?>
<form method="POST" class="formulario">
<div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu password" name="password">
    </div>
    
    <input type="submit" value="Guardar nueva Contraseña" class="boton">

</form>

<div class="acciones">
    <a href="/">¿Tienes cuenta? Inicia sesion</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta?</a>
</div>
