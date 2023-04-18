<h1 class="nombre-pagina">Olvidé la contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form method="POST" action="/olvide" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Tu email" name="email">
    </div>
    <input type="submit" value="Enviar Verificacion" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Tienes cuenta? Inicia sesion</a>
    <a href="/crear-cuenta">Crea tu cuenta</a>
</div>