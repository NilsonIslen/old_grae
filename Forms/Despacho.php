<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Despacho </title>
</head>
<body>
        <form action='index.php' method='POST'>
        <?php echo "<input type='hidden' name='Responsable' Value='$UsuarioS'>"; ?>
        <input type='number' name='IdVendedor' placeholder='Id del vendedor' required>
        <input type='text' name='D14x5' placeholder='D14x5' required>
        <input type='text' name='D16x5' placeholder='D16x5'required>
        <input type='text' name='Minx20' placeholder='Minx20' required>
        <button type='submit' name='despacho'> Despachar </button>
        </form>
</body>
</html>