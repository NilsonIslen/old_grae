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
        <input type='text' name='usuario' placeholder='Nombre de usuario' required>
        <input type='email' name='email' placeholder='Email' required>
        <input type='email' name='conf_email' placeholder='Confirmar Email'required>
        <input type='number' name='telefono' placeholder='Telefono'required>
        <button type='submit' name='nuevoUsuario'> Registrarme </button>
        </form>

        <Div>
        <a href='index.php'> Regresar </a>
        </Div>


</body>
</html>