<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registro de nuevo usuario </title>
</head>
<body>
    
        <form action='index.php' method='POST'>
        <?php
        echo "<input type='hidden' name='usuario' value='$UsuarioS'>";
        echo "<input type='hidden' name='clave' value='$ClaveS'>";
        ?>
        <input type='email' name='Email' placeholder='Email' required>
        <button type='submit' name='recClave'> Recibir Codigo para recuperar la contraseña </button>
        </form>

        <Div>
        <a href='index.php'> Regresar </a>
        </Div>


</body>
</html>

