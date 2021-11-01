<?php
session_start();

session_destroy();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Stl.css" rel="stylesheet" type="text/css"> 
    <title> Cerrar Sesion </title>
</head>
<body>

<div>
<p> Acabas de cerrar session correctamente </p>
<p> Gracias por usar nuestros servicios </p>
<p> <a href="Index.php"> Ir a la pagina principal </a> </p>
</div>

</body>
</html>