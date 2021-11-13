<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Menu Repartidor </title>
</head>
<body>
    <?php
                        echo "<ul>";
                        echo "<li> <a id='a_menu' href='index.php?usuario=$IdUs&seccion=NuevoCliente'> Nuevo Cliente &nbsp; &nbsp; &nbsp; &nbsp; NC</a> </li>";                    
                        echo "<li> <a id='a_menu'href='sesion.php'> Cerrar Sesion &nbsp; &nbsp; &nbsp; &nbsp; CS </a></li>";  
                        echo "</ul>";   
    ?>
</body>
</html>