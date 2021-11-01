<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Stl.css" rel="stylesheet" type="text/css"> 
    <title> Rutas AGD </title>
</head>
<body>
    
    <?php

$Fecha = date('d-m-Y');
$Fecha1D = date('d-m-Y',strtotime($Fecha.'+1 days'));

if(isset($_GET['Seccion'])){
    $Seccion = $_GET['Seccion'];
        if($Seccion == "NuevoUsuario"){
            include "Forms/NuevoUsuario.php";
            exit();
        }
    }

    if(isset($_POST['NuevoUsuario'])){
        include "Cont.php";
        $NUsuario = $_POST['Usuario'];
        $NEmail = $_POST['Email'];
        $NTelefono = $_POST['Telefono'];
        $NClave = $_POST['Clave'];
        $ConfClave = $_POST['ConfClave'];

        $Cons = 1;
            while($Cons <= $Usuarios){
                $Res = $Cons++; 
                include "Usuarios/$Res.php";
                if($NUsuario==$Usuario){
                   echo "<p> Este nombre de usuario ya existe, porfavor intenta con otro </p>";
                   echo "<Div>";
                   echo "<a href='Index.php?Seccion=NuevoUsuario'> Regresar </a>";
                   echo "</Div>";
                   exit();
                }
                }

                if($NClave==$ConfClave){

                    $IdUs = $Usuarios+1;

    $fp = fopen("Usuarios/$IdUs.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdUs = $IdUs; \n");
    fputs($fp, "$"."Usuario = '$NUsuario'; \n");
    fputs($fp, "$"."Email = '$NEmail'; \n");
    fputs($fp, "$"."Telefono = '$NTelefono'; \n");
    fputs($fp, "$"."Clave = '$NClave'; \n");
    fputs($fp, "$"."Perfil = 'Repartidor'; \n");
    fputs($fp, "$"."ClienteActual=0; \n");
    fputs($fp, "$"."OD14x5=0; \n");
    fputs($fp, "$"."OD16x5=0; \n");
    fputs($fp, "$"."OMinx20=0; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    $fp = fopen("Cont.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."Usuarios = $IdUs; \n");
    fputs($fp, "$"."Clientes = $Clientes; \n");
    fputs($fp, "$"."Despachos = $Despachos; \n");
    fputs($fp, "$"."Ventas =$Ventas; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    echo "<p> Gracias por tu registro </p>";
    echo "<p> Ahora puedes ingresar a la plataforma de repartos </p>";
    echo "<div>";
    echo " <a href='Index.php'> Ir a la pagina principal para iniciar sesion </a>";
    echo "</div>";


    exit();
        }}


        if(isset($_POST['NuevoCliente'])){
            include "Cont.php";
            $NCliente=$_POST['Cliente'];
            $NBarrio=$_POST['Barrio'];
            $NDireccion=$_POST['Direccion'];
            $NTelefono = $_POST['Telefono'];
            $Color=$_POST['Color'];
            $NumAl=$_POST['NumAl'];
    
            $Cons=1;
                while($Cons<=$Clientes){
                    $Res=$Cons++; 
                    include "Clientes/$Res.php";
                    if($NCliente==$Cliente){
                       echo "<p> Este Cliente ya existe en nuestro sistema </p>";

            session_start();
            $Usuario=$_SESSION['Usuario'];
            $Clave=$_SESSION['Clave'];
            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<button type='submit' name='Entrar'> Regresar </button>";
            echo "</form>";
                       exit();
                    }}


            if($Color==$NumAl){

    include "Cont.php";
    $IdCli = $Clientes+1;
    $fp = fopen("Cont.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."Usuarios = $Usuarios; \n");
    fputs($fp, "$"."Clientes = $IdCli; \n");
    fputs($fp, "$"."Despachos = $Despachos; \n");
    fputs($fp, "$"."Ventas =$Ventas; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    $fp = fopen("Clientes/$IdCli.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdCli=$IdCli; \n");
    fputs($fp, "$"."Cliente='$NCliente'; \n");
    fputs($fp, "$"."Barrio='$NBarrio'; \n");
    fputs($fp, "$"."Direccion='$NDireccion'; \n");
    fputs($fp, "$"."Telefono='$NTelefono'; \n");
    fputs($fp, "$"."DD14x5=0; \n");
    fputs($fp, "$"."DD16x5=0; \n");
    fputs($fp, "$"."DMinx20=0; \n");
    fputs($fp, "$"."Frec=1; \n");
    fputs($fp, "$"."Visita='$Fecha'; \n");
    fputs($fp, "$"."IdVendedor=0; \n");
    fputs($fp, "$"."NomVendedor='0'; \n");
    fputs($fp, "$"."Pedido='0'; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    echo "<p> Gracias por tu registro </p>";
    echo "<p> El nuevo cliente ya esta en la lista </p>";

             session_start();
            $Usuario=$_SESSION['Usuario'];
            $Clave=$_SESSION['Clave'];
            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<button type='submit' name='Entrar'> Regresar </button>";
            echo "</form>";

    exit();
    }}


if(isset($_GET['Usuario'])&&isset($_GET['Seccion'])){

    $Seccion = $_GET['Seccion'];
    $IdUsuario = $_GET['Usuario'];

    include "Usuarios/$IdUsuario.php";

    if($Seccion == 'NuevoCliente'){

        $Al = rand(1,4);
        $NumColor = "Color$Al";
       
        include "Forms/NuevoCliente.php";

         session_start();
            $Usuario=$_SESSION['Usuario'];
            $Clave=$_SESSION['Clave'];
            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<button type='submit' name='Entrar'> Regresar </button>";
            echo "</form>";
        exit();

    }

    if($Seccion == 'ListarClientes'){

        include "Cont.php";

        echo "<Div> <a href='Index.php?Usuario=$IdUs&Seccion=Pedidos'> Nuevo pedido </a> </Div>";
        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> ID </td> <td> Cliente </td> <td> Barrio </td> <td> Direccion </td>  <td> Telefono </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td> <td> Frecuencia </td> <td> Proxima Visita </td> <td> Vendedor actual </td><td> Pedido </td>";
        echo "</tr>";

        $Cons = 1;
            while($Cons <= $Clientes){
                $Resp = $Cons++; 

                include "Clientes/$Resp.php";        

                echo "<tr align='center'>";
                echo "<td> $IdCli </td> <td> $Cliente </td> <td> $Barrio </td> <td> $Direccion </td> <td> $Telefono </td> <td> $DD14x5 </td> <td> $DD16x5 </td> <td> $DMinx20 </td> <td> $Frec </td> <td> $Visita </td> <td> $NomVendedor </td> <td> $Pedido </td>";
                echo "</tr>";
            
        }
          echo "</table>";

          
            
            session_start();
            $Usuario=$_SESSION['Usuario'];
            $Clave=$_SESSION['Clave'];
            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<button type='submit' name='Entrar'> Regresar </button>";
            echo "</form>";
            exit();
        }


        if($Seccion == 'ListarRepartidores'){

            include "Cont.php";
    
            echo "<Div> <a href='Index.php?Usuario=$IdUs&Seccion=Despacho'> Despachar Repartidor </a> </Div>";
            echo "<table align='center'>";
            echo "<tr align='center'>";
            echo "<td> ID </td> <td> Repartidor </td> <td> Email </td> <td> Telefono </td>  <td> Perfil </td> <td> Cliente actual </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
            echo "</tr>";
    
            $Cons = 1;
                while($Cons <= $Usuarios){
                    $Resp = $Cons++; 
    
                    include "Usuarios/$Resp.php";        
    
                    echo "<tr align='center'>";
                    echo "<td> $IdUs </td> <td> $Usuario </td> <td> $Email </td> <td> $Telefono </td> <td> $Perfil </td> <td> $ClienteActual </td> <td> $OD14x5 </td> <td> $OD16x5 </td> <td> $OMinx20 </td>";
                    echo "</tr>";
                
            }
              echo "</table>";

              
                
                session_start();
                $Usuario=$_SESSION['Usuario'];
                $Clave=$_SESSION['Clave'];
                echo "<form action='Index.php' method='POST'>";
                echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                echo "<input type='hidden' name='Clave' Value='$Clave'>";
                echo "<button type='submit' name='Entrar'> Regresar </button>";
                echo "</form>";
                exit();
            }





    if($Seccion == 'Despacho'){
 
        include "Forms/Despacho.php";

            session_start();
            $Usuario=$_SESSION['Usuario'];
            $Clave=$_SESSION['Clave'];
            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<button type='submit' name='Entrar'> Regresar </button>";
            echo "</form>";

            echo "<Div>";
            echo "<a href='Sesion.php'> Cerrar Sesion </a>";
            echo "</Div>";
           
            exit();
        }

        if($Seccion=='Pedidos'){
            echo "<Div>";
             echo "<form action='Index.php' method='POST'>";
             echo "<input type='hidden' name='Responsable' Value='$Usuario'>";
             echo "<p><input type='number' name='IdCli' placeholder='Id del Cliente' required> </p>";
             echo "<p> <input type='text' name='D14x5' placeholder='D14x5' required> </p>";
             echo "<p> <input type='text' name='D16x5' placeholder='D16x5'required> </p>";
             echo "<p> <input type='text' name='Minx20' placeholder='Minx20' required> </p>";
             echo "<p><button type='submit' name='Pedido'> Registrar pedido </button> </p>";
             echo "</form>";
                session_start();
                $Usuario=$_SESSION['Usuario'];
                $Clave=$_SESSION['Clave'];
                echo "<form action='Index.php' method='POST'>";
                echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                echo "<input type='hidden' name='Clave' Value='$Clave'>";
                echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
                echo "</form>";
                echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";
                echo "</Div>";
                exit();
            }

            if($Seccion=='HDespachos'){

                    session_start();
                    $Usuario=$_SESSION['Usuario'];
                    $Clave=$_SESSION['Clave'];

                 echo "<Div>";
                 echo "<form action='Index.php' method='POST'>";
                 echo "<p> Historial de despachos :</p>";
                 echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                 echo "<input type='hidden' name='Clave' Value='$Clave'>";
                 echo "<select name='CriterioDeB'>";
                 echo "<option value='Fecha'> Fecha (DD-MM-AAAA)</option>";
                 echo "<option value='Responsable'> Responsable </option>";
                 echo "<option value='Vendedor'> Vendedor </option>";
                 echo "</select>";
                 echo "<p> <input type='Text' name='Palabra' placeholder='Busqueda'> </p>";
                 echo "<p><button type='submit' name='HDespachos'> Consultar Historial </button> </p>";
                 echo "</form>";

                    
                    echo "<form action='Index.php' method='POST'>";
                    echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                    echo "<input type='hidden' name='Clave' Value='$Clave'>";
                    echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
                    echo "</form>";
                    echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";
                    echo "</Div>";
                    exit();
                }


                if($Seccion=='HVentas'){

                    session_start();
                    $Usuario=$_SESSION['Usuario'];
                    $Clave=$_SESSION['Clave'];

                 echo "<form action='Index.php' method='POST'>";
                 echo "<p> Historial de Ventas :</p>";
                 echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                 echo "<input type='hidden' name='Clave' Value='$Clave'>";
                 echo "<p>";
                 echo "<select name='CriterioDeB'>";
                 echo "<option value='Fecha'> Fecha (DD-MM-AAAA)</option>";
                 echo "<option value='Vendedor'> Vendedor </option>";
                 echo "<option value='Cliente'> Cliente </option>";
                 echo "</select>";
                 echo "<p>";
                 echo "<input type='Text' name='Palabra' placeholder='Busqueda'>";
                 echo "<button type='submit' name='HVentas'> Consultar </button>";
                 echo "</form>";

                    
                    echo "<form action='Index.php' method='POST'>";
                    echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                    echo "<input type='hidden' name='Clave' Value='$Clave'>";
                    echo "<button type='submit' name='Entrar'> Regresar </button>";
                    echo "</form>";

                    echo "<Div>";
                    echo "<a href='Sesion.php'> Cerrar Sesion </a>";
                    echo "</Div>";
                   
                    exit();
                }
            }


    if(isset($_GET['Cliente'])&&isset($_GET['Usuario'])){ // -------------------------------------------------
    $IdUs = $_GET['Usuario'];
    $IdCli = $_GET['Cliente'];

    include "Usuarios/$IdUs.php";
    include "Clientes/$IdCli.php";

    if($IdVendedor==0 && $ClienteActual==0){ 

    $fp = fopen("Usuarios/$IdUs.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdUs = $IdUs; \n");
    fputs($fp, "$"."Usuario = '$Usuario'; \n");
    fputs($fp, "$"."Email = '$Email'; \n");
    fputs($fp, "$"."Telefono = '$Telefono'; \n");
    fputs($fp, "$"."Clave = '$Clave'; \n");
    fputs($fp, "$"."Perfil = '$Perfil'; \n");
    fputs($fp, "$"."ClienteActual = $IdCli; \n");
    fputs($fp, "$"."OD14x5 = $OD14x5; \n");
    fputs($fp, "$"."OD16x5 = $OD16x5; \n");
    fputs($fp, "$"."OMinx20 = $OMinx20; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    $fp = fopen("Clientes/$IdCli.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdCli = $IdCli; \n");
    fputs($fp, "$"."Cliente = '$Cliente'; \n");
    fputs($fp, "$"."Barrio = '$Barrio'; \n");
    fputs($fp, "$"."Direccion = '$Direccion'; \n");
    fputs($fp, "$"."Telefono = '$Telefono'; \n");
    fputs($fp, "$"."DD14x5= $DD14x5; \n");
    fputs($fp, "$"."DD16x5 = $DD16x5; \n");
    fputs($fp, "$"."DMinx20 = $DMinx20; \n");
    fputs($fp, "$"."Frec = $Frec; \n");
    fputs($fp, "$"."Visita = '$Fecha'; \n");
    fputs($fp, "$"."IdVendedor = $IdUs; \n");
    fputs($fp, "$"."NomVendedor = '$Usuario'; \n");
    fputs($fp, "$"."Pedido = '$Pedido'; \n");
    fputs($fp, "?> \n");
    fclose($fp);

        echo "<Div>";
        echo "<p> Cliente: $Cliente </p>";
        echo "<p> Barrio: $Barrio </p> ";
        echo "<p> Direccion: $Direccion </p>";
        echo "<p> Telefono: $Telefono </p> ";
        if($Pedido<>'0'){echo "<p> Pedido: $Pedido </p> ";}
        echo "</Div>";

        echo "<form action='Index.php' method='POST'>";
        echo "<input type='hidden' name='IdCli' Value='$IdCli'>";
        echo "<input type='hidden' name='IdUs' Value='$IdUs'>";
        echo "<input type='hidden' name='Fecha' Value='$Fecha'>";
        echo "<input type='hidden' name='Vendedor' Value='$Usuario'>";
        echo "<input type='hidden' name='Cliente' Value='$Cliente'>";
        echo "<input type='hidden' name='Barrio' Value='$Barrio'>";
        echo "<p><input type='text' name='D14x5' placeholder='D14x5' required /> </p>";
        echo "<p><input type='text' name='D16x5' placeholder='D16x5' required></p>";
        echo "<p><input type='text' name='Minx20' placeholder='Minx20' required> </p>";
        echo "<p><button type='submit' name='Venta'> Enviar </button> </p>";
        echo "</form>";

        session_start();
            $Usuario=$_SESSION['Usuario'];
            $Clave=$_SESSION['Clave'];
            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<p> <button type='submit' name='Cancelar'> Cancelar </button> </p>";
            echo "</form>";
            echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";
            echo "</Div>";
            exit();
    }

    if($IdVendedor<>0 && $ClienteActual==0){
        echo "<p> Lo sentimos, este cliente lo acaba de seleccionar otro usuario </p>";
        echo "<p> Pero no te preocupes, hay mas opciones disponibles </p>";
        echo "<p> <a href='index.php'> Por favor seleccione esta linea para continuar </a> </p>";
    }
    }

    


    if(isset($_POST['Despacho'])){

        $Fecha = date('d-m-Y');
        $Hora = date('H:i:s');
        $Responsable = $_POST['Responsable'];
        $IdVendedor = $_POST['IdVendedor'];
        $D14x5 = $_POST['D14x5'];
        $D16x5 = $_POST['D16x5'];
        $Minx20 = $_POST['Minx20'];

        include "Usuarios/$IdVendedor.php";
        include "Cont.php";

$RD14x5=($OD14x5+$D14x5);
$RD16x5=($OD16x5+$D16x5);
$RMinx20=($OMinx20+$Minx20);
    
$fp = fopen("Registros/Despachos/$Despachos.php","a");
fputs($fp, "<?php \n");
fputs($fp, "$"."Fecha = '$Fecha'; \n");
fputs($fp, "$"."Hora = '$Hora'; \n");
fputs($fp, "$"."Responsable = '$Responsable'; \n");
fputs($fp, "$"."Vendedor = '$Usuario'; \n");
fputs($fp, "$"."D14x5 = $D14x5; \n");
fputs($fp, "$"."D16x5 = $D16x5; \n");
fputs($fp, "$"."Minx20 = $Minx20; \n");
fputs($fp, "?> \n");
fclose($fp);

$fp = fopen("Usuarios/$IdUs.php","w");
fputs($fp, "<?php \n");
fputs($fp, "$"."IdUs = $IdUs; \n");
fputs($fp, "$"."Usuario = '$Usuario'; \n");
fputs($fp, "$"."Email = '$Email'; \n");
fputs($fp, "$"."Telefono = '$Telefono'; \n");
fputs($fp, "$"."Clave = '$Clave'; \n");
fputs($fp, "$"."Perfil = '$Perfil'; \n");
fputs($fp, "$"."ClienteActual = $ClienteActual; \n");
fputs($fp, "$"."OD14x5 = $RD14x5; \n");
fputs($fp, "$"."OD16x5 = $RD16x5; \n");
fputs($fp, "$"."OMinx20 = $RMinx20; \n");
fputs($fp, "?> \n");
fclose($fp);

$Desp = $Despachos+1;

$fp = fopen("Cont.php","w");
fputs($fp, "<?php \n");
fputs($fp, "$"."Usuarios = $Usuarios; \n");
fputs($fp, "$"."Clientes = $Clientes; \n");
fputs($fp, "$"."Despachos = $Desp; \n");
fputs($fp, "$"."Ventas =$Ventas; \n");
fputs($fp, "?> \n");
fclose($fp);

echo "<p> Gracias por tu registro </p>";
echo "<p> Se acaba de registrar nuevo despacho para el repartidor $Usuario</p>";
session_start();
$Usuario=$_SESSION['Usuario'];
$Clave=$_SESSION['Clave'];
            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
            echo "</form>";
            echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";

exit();
}

if(isset($_POST['Pedido'])){ //----------------------------------------------------------------------

    $IdCli = $_POST['IdCli'];
    $D14x5 = $_POST['D14x5'];
    $D16x5 = $_POST['D16x5'];
    $Minx20 = $_POST['Minx20'];

    include "Clientes/$IdCli.php";

$fp = fopen("Clientes/$IdCli.php","w");
fputs($fp, "<?php \n");
fputs($fp, "$"."IdCli = $IdCli; \n");
fputs($fp, "$"."Cliente = '$Cliente'; \n");
fputs($fp, "$"."Barrio = '$Barrio'; \n");
fputs($fp, "$"."Direccion = '$Direccion'; \n");
fputs($fp, "$"."Telefono = '$Telefono'; \n");
fputs($fp, "$"."DD14x5= $DD14x5; \n");
fputs($fp, "$"."DD16x5 = $DD16x5; \n");
fputs($fp, "$"."DMinx20 = $DMinx20; \n");
fputs($fp, "$"."Frec = $Frec; \n");
fputs($fp, "$"."Visita = '$Fecha'; \n");
fputs($fp, "$"."IdVendedor = 0; \n");
fputs($fp, "$"."NomVendedor = 0; \n");
fputs($fp, "$"."Pedido = '($D14x5 D14x5)($D16x5 D16x5)($Minx20 Minx20)'; \n");
fputs($fp, "?> \n");
fclose($fp);


echo "<p> Hemos registrado el nuevo pedido para el cliente $Cliente </p>";
echo "<p> Gracias por tu gestion </p>";

session_start();
$Usuario=$_SESSION['Usuario'];
$Clave=$_SESSION['Clave'];
        echo "<form action='Index.php' method='POST'>";
        echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
        echo "<input type='hidden' name='Clave' Value='$Clave'>";
        echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
        echo "</form>";
        echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";

exit();
}





    if(isset($_POST['Venta'])){ // ----------------------------------------------------------------

                    $Fecha = date('d-m-Y');
                    $Hora = date('H:i:s');
                    $IdCli = $_POST['IdCli'];
                    $IdUs = $_POST['IdUs'];
                    $Vendedor = $_POST['Vendedor'];
                    $Cliente = $_POST['Cliente'];
                    $Barrio = $_POST['Barrio'];
                    $D14x5 = $_POST['D14x5'];
                    $D16x5 = $_POST['D16x5'];
                    $Minx20 = $_POST['Minx20'];

                    include "Usuarios/$IdUs.php";
                    include "Cont.php";

    $fp = fopen("Registros/Ventas/$Ventas.php","a");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."Fecha = '$Fecha'; \n");
    fputs($fp, "$"."Hora = '$Hora'; \n");
    fputs($fp, "$"."Vendedor = '$Usuario'; \n");
    fputs($fp, "$"."Cliente = '$Cliente'; \n");
    fputs($fp, "$"."Barrio = '$Barrio'; \n");
    fputs($fp, "$"."D14x5 = $D14x5; \n");
    fputs($fp, "$"."D16x5 = $D16x5; \n");
    fputs($fp, "$"."Minx20 = $Minx20; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    $RD14x5=($OD14x5-$D14x5);
    $RD16x5=($OD16x5-$D16x5);
    $RMinx20=($OMinx20-$Minx20);

    $fp = fopen("Usuarios/$IdUs.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdUs = $IdUs; \n");
    fputs($fp, "$"."Usuario = '$Usuario'; \n");
    fputs($fp, "$"."Email = '$Email'; \n");
    fputs($fp, "$"."Telefono = '$Telefono'; \n");
    fputs($fp, "$"."Clave = '$Clave'; \n");
    fputs($fp, "$"."Perfil = '$Perfil'; \n");
    fputs($fp, "$"."ClienteActual = 0; \n");
    fputs($fp, "$"."OD14x5 = $RD14x5; \n");
    fputs($fp, "$"."OD16x5 = $RD16x5; \n");
    fputs($fp, "$"."OMinx20 = $RMinx20; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    include "Clientes/$IdCli.php";
    if($Frec == 1){
    $fp = fopen("Clientes/$IdCli.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdCli = $IdCli; \n");
    fputs($fp, "$"."Cliente = '$Cliente'; \n");
    fputs($fp, "$"."Barrio = '$Barrio'; \n");
    fputs($fp, "$"."Direccion = '$Direccion'; \n");
    fputs($fp, "$"."Telefono = '$Telefono'; \n");
    fputs($fp, "$"."DD14x5= $DD14x5; \n");
    fputs($fp, "$"."DD16x5 = $DD16x5; \n");
    fputs($fp, "$"."DMinx20 = $DMinx20; \n");
    fputs($fp, "$"."Frec = $Frec; \n");
    fputs($fp, "$"."Visita = '$Fecha1D'; \n");
    fputs($fp, "$"."IdVendedor = 0; \n");
    fputs($fp, "$"."NomVendedor = '0'; \n");
    fputs($fp, "$"."Pedido = '0' ; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    $Vent = $Ventas+1;
    $fp = fopen("Cont.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."Usuarios = $Usuarios; \n");
    fputs($fp, "$"."Clientes = $Clientes; \n");
    fputs($fp, "$"."Despachos = $Despachos; \n");
    fputs($fp, "$"."Ventas =$Vent; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    }

    echo "<p> Gracias por tu registro </p>";
    session_start();
    $Usuario=$_SESSION['Usuario'];
    $Clave=$_SESSION['Clave'];
                        echo "<form action='Index.php' method='POST'>";
                        echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                        echo "<input type='hidden' name='Clave' Value='$Clave'>";
                        echo "<p> <button type='submit' name='Entrar'> Continuar atendiendo mas clientes </button> </p>";
                        echo "</form>";
                        echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";

    exit();
    }

    if(isset($_POST['Cancelar'])){

        session_start();
        $_SESSION['Usuario'] = $_POST['Usuario'];
        $_SESSION['Clave'] = $_POST['Clave'];
        $UsuarioS = $_SESSION['Usuario'];
        $ClaveS = $_SESSION['Clave'];


        $IdUs2 = 1;
            while($IdUs2<=2){
                $IdUs3=$IdUs2++; 
                include "Usuarios/$IdUs3.php";
                if ($UsuarioS==$Usuario && $ClaveS==$Clave){

                    include "Usuarios/$IdUs.php";
                    include "Clientes/$ClienteActual.php";

    $fp = fopen("Usuarios/$IdUs.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdUs = $IdUs; \n");
    fputs($fp, "$"."Usuario = '$Usuario'; \n");
    fputs($fp, "$"."Email = '$Email'; \n");
    fputs($fp, "$"."Telefono = '$Telefono'; \n");
    fputs($fp, "$"."Clave = '$Clave'; \n");
    fputs($fp, "$"."Perfil = '$Perfil'; \n");
    fputs($fp, "$"."ClienteActual = 0; \n");
    fputs($fp, "$"."OD14x5 = $OD14x5; \n");
    fputs($fp, "$"."OD16x5 = $OD16x5; \n");
    fputs($fp, "$"."OMinx20 = $OMinx20; \n");
    fputs($fp, "?> \n");
    fclose($fp);

    $fp = fopen("Clientes/$IdCli.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."IdCli = $IdCli; \n");
    fputs($fp, "$"."Cliente = '$Cliente'; \n");
    fputs($fp, "$"."Barrio = '$Barrio'; \n");
    fputs($fp, "$"."Direccion = '$Direccion'; \n");
    fputs($fp, "$"."Telefono = '$Telefono'; \n");
    fputs($fp, "$"."DD14x5= $DD14x5; \n");
    fputs($fp, "$"."DD16x5 = $DD16x5; \n");
    fputs($fp, "$"."DMinx20 = $DMinx20; \n");
    fputs($fp, "$"."Frec = $Frec; \n");
    fputs($fp, "$"."Visita = '$Fecha'; \n");
    fputs($fp, "$"."IdVendedor = 0; \n");
    fputs($fp, "$"."NomVendedor = '0'; \n");
    fputs($fp, "$"."Pedido = '$Pedido'; \n");
    fputs($fp, "?> \n");
    fclose($fp);

        echo "<p> Acabas de cancelar la atencion con este cliente </p>";

            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
            echo "<input type='hidden' name='Clave' Value='$Clave'>";
            echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
            echo "</form>";
            echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";

        }}
            exit();

    }

    if(isset($_POST['HDespachos'])){
        session_start();
        $_SESSION['Usuario'] = $_POST['Usuario'];
        $_SESSION['Clave'] = $_POST['Clave'];
        $UsuarioS = $_SESSION['Usuario'];
        $ClaveS = $_SESSION['Clave'];

        $CriterioDeB = $_POST['CriterioDeB'];
        $Palabra = $_POST['Palabra'];
        

        include "Cont.php";

        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> Fecha </td> <td> Hora </td> <td> Responsable </td> <td> Vendedor </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
        echo "</tr>";

           $Cont = 1;
            while($Cont<=$Despachos){

                $Reg=$Cont++; 

                include "Registros/Despachos/$Reg.php";

            if("$CriterioDeB"=="Fecha" && "$Palabra"=="$Fecha" ){
                echo "<tr align='center'>";
                echo "<td> $Fecha </td> <td> $Hora </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
                echo "</tr>";
                
            }
            if("$CriterioDeB"=="Responsable" && "$Palabra"=="$Responsable" ){
                echo "<tr align='center'>";
                echo "<td> $Fecha </td> <td> $Hora </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
                echo "</tr>";
                
            }
            if("$CriterioDeB"=="Vendedor" && "$Palabra"=="$Vendedor" ){
                echo "<tr align='center'>";
                echo "<td> $Fecha </td> <td> $Hora </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
                echo "</tr>";
               
            }
            
        }
          echo "</table>";
            

            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$UsuarioS'>";
            echo "<input type='hidden' name='Clave' Value='$ClaveS'>";
            echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
            echo "</form>";
            echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";
            echo "</Div>";
            exit();
                       
                        }



        if(isset($_POST['HVentas'])){
        session_start();
        $_SESSION['Usuario'] = $_POST['Usuario'];
        $_SESSION['Clave'] = $_POST['Clave'];
        $UsuarioS = $_SESSION['Usuario'];
        $ClaveS = $_SESSION['Clave'];

        $CriterioDeB = $_POST['CriterioDeB'];
        $Palabra = $_POST['Palabra'];
        
        include "Cont.php";

        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> Fecha </td> <td> Hora </td> <td> Vendedor </td> <td> Cliente </td> <td> Barrio </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
        echo "</tr>";

           $Cont = 0;
            while($Cont<=$Ventas){

                $Reg=$Cont++; 

                include "Registros/Ventas/$Reg.php";

            if("$CriterioDeB"=="Fecha" && "$Palabra"=="$Fecha" ){
                echo "<tr align='center'>";
                echo "<td> $Fecha </td> <td> $Hora </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
                echo "</tr>";
                
            }
            if("$CriterioDeB"=="Vendedor" && "$Palabra"=="$Vendedor" ){
                echo "<tr align='center'>";
                echo "<td> $Fecha </td> <td> $Hora </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
                echo "</tr>";
                
            }
            if("$CriterioDeB"=="Cliente" && "$Palabra"=="$Cliente" ){
                echo "<tr align='center'>";
                echo "<td> $Fecha </td> <td> $Hora </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
                echo "</tr>";
               
            }
            
        }
          echo "</table>";
            

            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$UsuarioS'>";
            echo "<input type='hidden' name='Clave' Value='$ClaveS'>";
            echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
            echo "</form>";
            echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";
            echo "</Div>";
            exit();
                       
                        }





            
//--------------------------------------------------------------------------------------------------------
    if(isset($_POST['Entrar'])){
        session_start();
        $_SESSION['Usuario'] = $_POST['Usuario'];
        $_SESSION['Clave'] = $_POST['Clave'];
        $UsuarioS = $_SESSION['Usuario'];
        $ClaveS = $_SESSION['Clave'];

        include "Cont.php";

           $IdUs2 = 1;
            while($IdUs2<=$Usuarios){
                $IdUs3=$IdUs2++; 

                include "Usuarios/$IdUs3.php";

                if ($UsuarioS==$Usuario && $ClaveS==$Clave){

                    include "Usuarios/$IdUs.php";

                    echo "<p>¡Bienvenido $Usuario";

                    if($Perfil=='Admin'){
                        include "Menus/Admin.php";
                        }

                        if($Perfil=='Repartidor'){
                        include "Menus/Rep.php";
                        }

                    // Inicio cliente asignado --------------------------
                    
                    if($ClienteActual<>0){
                        include "Clientes/$ClienteActual.php";
                        echo "<Div>";
                        echo "<p> Cliente: $Cliente </p>";
                        echo "<p> Barrio: $Barrio </p> ";
                        echo "<p> Direccion: $Direccion </p>";
                        echo "<p> Telefono: $Telefono </p> ";
                        if($Pedido<>'0'){echo "<p> Pedido: $Pedido </p> ";}
                        echo "</Div>";
                                
                        echo "<form action='Index.php' method='POST'>";
                        echo "<input type='hidden' name='IdCli' Value='$IdCli'>";
                        echo "<input type='hidden' name='IdUs' Value='$IdVendedor'>";
                        echo "<input type='hidden' name='Vendedor' Value='$Usuario'>";
                        echo "<input type='hidden' name='Cliente' Value='$Cliente'>";
                        echo "<input type='hidden' name='Barrio' Value='$Barrio'>";
                        echo "<input type='text' name='D14x5' placeholder='D14x5' required>";
                        echo "<input type='text' name='D16x5' placeholder='D16x5'required>";
                        echo "<input type='text' name='Minx20' placeholder='Minx20' required>";
                        echo "<button type='submit' name='Venta'> Enviar </button>";
                        echo "</form>";
                        

                        echo "<form action='Index.php' method='POST'>";
                        echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
                        echo "<input type='hidden' name='Clave' Value='$Clave'>";
                        echo "<button type='submit' name='Cancelar'> Cancelar </button>";
                        echo "</form>";
                        echo "<Div> <a href='Sesion.php'> Cerrar Sesion </a></Div>";
                        exit();
                        }
                    // Final cliente asignado --------------------------
                    
                   
                    

                    

        // Inicio lista de clientes------------------------------------------------
        $Barrs=array(
            1=>"La Galeria",
            2=>"Lleras",
            3=>"Santos",
        );
            $Br = 1;
            while($Br <= 3){
                $Barr = $Br++; 
               $Barrios = $Barrs[$Barr];
            
            $Id2 = 1;
            while($Id2 <= 4){
                $Id3 = $Id2++; 

                include "Clientes/$Id3.php";
    
                    if($Fecha==$Visita && $ClienteActual==0 && $Barrios==$Barrio){

                    if($OD14x5>=$DD14x5 && $OD16x5>=$DD16x5 && $OMinx20>=$DMinx20){
                    echo "<div>";
                    echo "<p> Cliente: $Cliente </p>";
                    echo "<p> Barrio: $Barrio </p> ";
                    echo "<p> Direccion: $Direccion </p>";
                    echo "<p> Telefono: $Telefono </p> ";
                    
                                                         
                    if($Pedido<>'0'){   
                        echo "<p> Pedido: $Pedido </p> ";
                        }

                    if($IdVendedor==0){   
                    echo "<p> <a href='Index.php?Cliente=$IdCli&Usuario=$IdUs'> Gestionar Cliente </a> </p>";
                    echo "</div>";
                    }

                    if($IdVendedor<>0){
                    echo "<p>  Asignado a $NomVendedor </p>";
                    echo "</div>";
                    }}}}}

                    if($OD14x5==0 && $OD16x5==0 && $OMinx20==0){

                        echo "<div>";
                        echo "<p> Para ver los clientes que actuelmente estan esparendo visita </p>";
                        echo "<p> debes contar con producto disponible.</p>";
                        echo "<p> lo puedes adquirir en l direccion:</p>";
                        echo "<p> Carrera 30a # 50a 65 Barrio Eucaliptus (Manizales - Caldas)</p>";
                        echo "</div>";
                        }
                
                

              exit();
         // Final lista de clientes --------------------------                    

                  }
                  }
                  }
        

        echo'<form action="Index.php" method="POST">';
        echo '<input type="text" name="Usuario" placeholder="Usuario" required>';
        echo '<input type="password" name="Clave" placeholder="Clave" required>';
        echo '<button type="submit" name="Entrar"> Entrar </button>';     
        echo '</form>';
        
        echo "<Div>";
        echo "<a href='Index.php?Seccion=NuevoUsuario'> Registrarme </a>";
        echo "</Div>";
       
        
    
    ?>
    
</body>
</html>