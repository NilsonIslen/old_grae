<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Nuevo Cliente </title>
</head>
<body>

        <form action='index.php' method='POST'>
        <?php echo "<input type='hidden' name='Usuario' Value='$IdUsuario'>"; ?>
        <?php echo "<input type='hidden' name='NumAl' Value='$Al'>"; ?>
        <input type='text' name='Cliente' placeholder='Nombre del cliente o negocio' required>
                 <select name='Barrio'>
                 <option value='Color'> Barrio </option>
                 <option value='Avanzada'> Avanzada </option>
                 <option value='La Galeria'> La Galeria </option>
                 <option value='La Pelusa'> La Pelusa </option>
                 <option value='Lleras'> Lleras </option>
                 <option value='San Jose'> San Jose </option>
                 <option value='Santos'> Santos </option>
                 </select>
                 <input type='text' name='Direccion' placeholder='Direccion'required>
                 <input type='text' name='Telefono' placeholder='Telefono'required>
                 <?php echo "<select id='Sel$NumColor' name='Color'>"; ?>
                 <option value=0> De que color es esta casilla? </option>
                 <option value=1> Amarillo </option>
                 <option value=2> Azul </option>
                 <option value=3> Rojo </option>
                 <option value=4> Verde </option>
                 </select>

                 <button type='submit' name='nuevoCliente'> Registrar nuevo cliente </button>
        </form>
    
</body>
</html>