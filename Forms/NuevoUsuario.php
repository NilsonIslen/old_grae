<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registro de nuevo usuario </title>
</head>
<body>
    
        <form action='Index.php' method='POST'>
        <input type='text' name='Usuario' placeholder='Nombre de usuario' required>
        <input type='email' name='Email' placeholder='Email' required>
        <input type='email' name='ConfEmail' placeholder='Confirmar Email'required>
        <input type='number' name='Telefono' placeholder='Telefono'required>
        <button type='submit' name='NuevoUsuario'> Registrarme </button>
        </form>

        <Div>
        <a href='Index.php'> Regresar </a>
        </Div>


</body>
</html>