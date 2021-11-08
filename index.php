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

        if($Seccion == "RecuperarClave"){
            include "Forms/RecClave.php";
            exit();
        }

    }

    if(isset($_POST['RecClave'])){

        $Email = $_POST['Email'];
        
        $Letter = array(
            1=>'A',
            2=>'B',
            3=>'C',
            4=>'D',
            5=>'E',
            6=>'F',
            7=>'G',
            8=>'H',
            9=>'I',
            10=>'J',
            11=>'K',
            12=>'L',
            13=>'M',
            14=>'N',
            15=>'O',
            16=>'P',
            17=>'Q',
            18=>'R',
            19=>'S',
            20=>'T',
            21=>'U',
            22=>'V',
            23=>'W',
            24=>'X',
            25=>'Y',
            26=>'Z',
        );


        $LetA = rand(1,26);
        $LetterA = $Letter["$LetA"];
        $NumA = rand(00,99);
        $LetB = rand(1,26);
        $LetterB = $Letter["$LetB"];
        $NumB = rand(00,99);
        
        $Cod = "$LetterA$NumA$LetterB$NumB";
        $CodEnc = md5($Cod);

    $fp = fopen("Temp/$CodEnc.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."Code = '$CodEnc'; \n");
    fputs($fp, "?> \n");
    fclose($fp);


    $To = "$Email";
    $Asunto =  "Solucitud cambio de contraseña Repartidores AGD";
    $Contenido = " Para cambiar tu contraseña utiliza el codigo: $Cod \n";

    mail($To, $Asunto, $Contenido);

        echo "$Cod";
        echo "$Email";

        include "Forms/CamClave.php";

    }


    if(isset($_POST['CamClave'])){

        $Email = $_POST['Email'];
        $Codigo = $_POST['Codigo'];
        $Clave = $_POST['Clave'];
        $ConfClave = $_POST['ConfClave'];
        $ClaveEnc=md5($Clave);
        $CodEnc=md5($Codigo);


        $Arc = "Temp/$CodEnc.php";
        

        if(file_exists($Arc)){
            include "$Arc";
            if("$Code"=="$CodEnc" && "$Clave"=="$ConfClave"){
 
            include "dbRepAGD.php";
            if($queryUsers -> rowCount() > 0){
            foreach($resultsUsers as $result) {
            include "Class/User.php";
                        if("$Email"=="$EmailUs"){
                         $query ="UPDATE usuarios SET ClaveUs='$ClaveEnc'
                         WHERE EmailUs='$Email'";
                        $result=$connect->query($query);
                    }}}

            unlink($Arc);

    echo "<p> La contraseña se ha cambiado correctamente. </p>";
    echo "<p> Ahora puedes ingresar a la plataforma de repartos. </p>";
    echo "<div>";
    echo " <a href='Index.php'> Ir a la pagina principal para iniciar sesion </a>";
    echo "</div>";

    exit();

            }
            }else{
                echo "<p> El codigo no es correcto o las claves no coinciden </p>";
                echo "<div>";
                echo " <a href='Index.php'> Regresar </a>";
                echo "</div>";
                 exit();
                    
        }
    }
    
    

    if(isset($_POST['NuevoUsuario'])){
        
        $NUsuario = $_POST['Usuario'];
        $NEmail = $_POST['Email'];
        $NTelefono = $_POST['Telefono'];
        $NClave = $_POST['Clave'];
        $ConfClave = $_POST['ConfClave'];
        $ClaveEnc = md5($NClave);
        $Perfil='Rep';
        $ClienteActual=0;
        $OD14x5=0;
        $OD16x5=0;
        $OMinx20=0;


        include "dbRepAGD.php";
        $sql = "SELECT * FROM usuarios"; 
        $query = $connect -> prepare($sql); 
        $query -> execute(); 
        $results = $query -> fetchAll(PDO::FETCH_OBJ); 
        
        if($query -> rowCount() > 0){
            foreach($results as $result) {

                $EmailUs=$result->EmailUs;
                
                if($NEmail==$EmailUs){
                echo "<p> El Correo ingresado ya existe en nuestro sistema </p>"; 
                echo "<p> Por favor intenta con otro o recupera la contraseña </p>";
                   echo "<Div>";
                   echo "<a href='Index.php?Seccion=NuevoUsuario'> Regresar </a>";
                   echo "</Div>"; 
                exit();
                 } 
        }}
        
        if($NClave==$ConfClave){
        $sql="insert into usuarios(NameUs,EmailUs,TelUs,ClaveUs,Perfil,ClienteActual,OD14x5,OD16x5,OMinx20) values(:NameUs,:EmailUs,:TelUs,:ClaveUs,:Perfil,:ClienteActual,:OD14x5,:OD16x5,:OMinx20)";

        $sql=$connect->prepare($sql);

        $sql->bindParam(':NameUs',$NUsuario,PDO::PARAM_STR, 25);
        $sql->bindParam(':EmailUs',$NEmail,PDO::PARAM_STR, 25);
        $sql->bindParam(':TelUs',$NTelefono,PDO::PARAM_STR,25);
        $sql->bindParam(':ClaveUs',$ClaveEnc,PDO::PARAM_STR,25);
        $sql->bindParam(':Perfil',$Perfil,PDO::PARAM_STR,25);
        $sql->bindParam(':ClienteActual',$ClienteActual,PDO::PARAM_STR,25);
        $sql->bindParam(':OD14x5',$OD14x5,PDO::PARAM_STR,25);
        $sql->bindParam(':OD16x5',$OD16x5,PDO::PARAM_STR,25);
        $sql->bindParam(':OMinx20',$OMinx20,PDO::PARAM_STR);

        $sql->execute();
        $lastInsertId=$connect->lastInsertId();

    echo "<p> Gracias por tu registro </p>";
    echo "<p> Ahora puedes ingresar a la plataforma de repartos </p>";
    echo "<div>";
    echo " <a href='Index.php'> Ir a la pagina principal para iniciar sesion </a>";
    echo "</div>";

    exit();
        }}


        if(isset($_POST['NuevoCliente'])){
            $NCliente=$_POST['Cliente'];
            $NBarrio=$_POST['Barrio'];
            $NDireccion=$_POST['Direccion'];
            $NTelefono = $_POST['Telefono'];
            $Color=$_POST['Color'];
            $NumAl=$_POST['NumAl'];
            $Frecuencia=1;
            $Visita="$Fecha";
            $DD14x5=0;
            $DD16x5=0;
            $DMinx20=0;
            $IdVendedor=0;
            $NameVendedor='0';
            $Pedido='0';


            include "dbRepAGD.php";

            if($queryClients -> rowCount() > 0){
            foreach($resultsClients as $result) {
            include "Class/Client.php";
                
                if($NCliente==$NameCli or $NDireccion==$Direccion or $NTelefono==$TelCli){
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
                 } 
        }}
    
    if($Color==$NumAl){

        $sql="insert into clients(NameCli,Barrio,Direccion,TelCli,Frecuencia,Visita,DD14x5,DD16x5,DMinx20,IdVendedor,NameVendedor,Pedido) values(:NameCli,:Barrio,:Direccion,:TelCli,:Frecuencia,:Visita,:DD14x5,:DD16x5,:DMinx20,:IdVendedor,:NameVendedor,:Pedido)";

        $sql=$connect->prepare($sql);

        $sql->bindParam(':NameCli',$NCliente,PDO::PARAM_STR, 25);
        $sql->bindParam(':Barrio',$NBarrio,PDO::PARAM_STR, 25);
        $sql->bindParam(':Direccion',$NDireccion,PDO::PARAM_STR,25);
        $sql->bindParam(':TelCli',$NTelefono,PDO::PARAM_STR,25);
        $sql->bindParam(':Frecuencia',$Frecuencia,PDO::PARAM_STR,25);
        $sql->bindParam(':Visita',$Visita,PDO::PARAM_STR,25);
        $sql->bindParam(':DD14x5',$DD14x5,PDO::PARAM_STR,25);
        $sql->bindParam(':DD16x5',$DD16x5,PDO::PARAM_STR,25);
        $sql->bindParam(':DMinx20',$DMinx20,PDO::PARAM_STR, 25);
        $sql->bindParam(':IdVendedor',$IdVendedor,PDO::PARAM_STR,25);
        $sql->bindParam(':NameVendedor',$NameVendedor,PDO::PARAM_STR,25);
        $sql->bindParam(':Pedido',$Pedido,PDO::PARAM_STR, 25);

        $sql->execute();
        $lastInsertId=$connect->lastInsertId();

    echo "<p> Proceso exitoso, gracias por tu registro </p>";

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

            include "dbRepAGD.php";
        
        if($queryUsers -> rowCount() > 0){
            foreach($resultsUsers as $result) {

                $IdUs=$result->IdUs;
                
                if($IdUs==$IdUsuario){        

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

        echo "<Div> <a href='Index.php?Usuario=$IdUs&Seccion=Pedidos'> Nuevo pedido </a> </Div>";
        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> ID </td> <td> Cliente </td> <td> Barrio </td> <td> Direccion </td>  <td> Telefono </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td> <td> Frecuencia </td> <td> Proxima Visita </td> <td> Vendedor actual </td><td> Pedido </td>";
        echo "</tr>";

        if($queryClients -> rowCount() > 0){
            foreach($resultsClients as $result) {
            include "Class/Client.php";

            echo "<tr align='center'>";
                echo "<td> $IdCli </td> <td> $NameCli </td> <td> $Barrio </td> <td> $Direccion </td> <td> $TelCli </td> <td> $DD14x5 </td> <td> $DD16x5 </td> <td> $DMinx20 </td> <td> $Frec </td> <td> $Visita </td> <td> $NameVendedor </td> <td> $Pedido </td>";
                echo "</tr>";
        
        }}
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

            echo "<Div> <a href='Index.php?Usuario=$IdUs&Seccion=Despacho'> Despachar Repartidor </a> </Div>";
            echo "<table align='center'>";
            echo "<tr align='center'>";
            echo "<td> ID </td> <td> Repartidor </td> <td> Email </td> <td> Telefono </td>  <td> Perfil </td> <td> Cliente actual </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
            echo "</tr>";

        if($queryUsers -> rowCount() > 0){
        foreach($resultsUsers as $result) {
        include "Class/User.php";

        echo "<tr align='center'>";
                    echo "<td> $IdUs </td> <td> $NameUs </td> <td> $EmailUs </td> <td> $TelUs </td> <td> $Perfil </td> <td> $ClienteActual </td> <td> $OD14x5 </td> <td> $OD16x5 </td> <td> $OMinx20 </td>";
        echo "</tr>";
    
    
    
    
    }}

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
            
            session_start();
            $Usuario=$_SESSION['Usuario'];
            $Clave=$_SESSION['Clave'];
            
            include "Forms/Despacho.php";

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
             echo "<input type='hidden' name='Responsable' Value='$IdUsuario'>";
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
            }}}}


    if(isset($_GET['Cliente'])&&isset($_GET['Usuario'])){ // -------------------------------------------------
    $IdUser = $_GET['Usuario'];
    $IdClient = $_GET['Cliente'];

    include "dbRepAGD.php";

    if($queryUsers -> rowCount() > 0){
    foreach($resultsUsers as $result) {
    include "Class/User.php";

    if($queryClients -> rowCount() > 0){
    foreach($resultsClients as $result) {
    include "Class/Client.php";
    
   if($IdVendedor==0 && $ClienteActual==0 && $IdUser==$IdUs){ 

        $query = "UPDATE usuarios SET ClienteActual='$IdClient' WHERE IdUs=$IdUser";
        $result=$connect->query($query);

        $query2 = "UPDATE clients SET IdVendedor='$IdUser', NameVendedor='$NameUs' WHERE IdCli=$IdClient";
        $result2=$connect->query($query2);

        include "Listas/Prot.php";

        session_start();
        $Usuario=$_SESSION['Usuario'];
        $Clave=$_SESSION['Clave'];
        echo "<form action='Index.php' method='POST'>";
        echo "<input type='hidden' name='Usuario' Value='$Usuario'>";
        echo "<input type='hidden' name='Clave' Value='$Clave'>";
        echo "<button type='submit' name='Entrar'> CONTINUAR </button>";
        echo "</form>";
        exit();
            }
        }}}}


        

        


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

        include "dbRepAGD.php";
        if($queryUsers -> rowCount() > 0){
            foreach($resultsUsers as $result) {
            include "Class/User.php";
                        if($IdVendedor==$IdUs){
                            $RD14x5=($OD14x5+$D14x5);
                            $RD16x5=($OD16x5+$D16x5);
                            $RMinx20=($OMinx20+$Minx20);
             
                         $query ="UPDATE usuarios SET OD14x5=$RD14x5, OD16x5=$RD16x5, OMinx20=$RMinx20
                         WHERE IdUs=$IdVendedor";
                        $result=$connect->query($query);
                    }}}

        $sql="insert into deliveries2021(FechaD,HoraD,Responsable,Vendedor,D14x5,D16x5,Minx20)
        values(:FechaD,:HoraD,:Responsable,:Vendedor,:D14x5,:D16x5,:Minx20)";
        $sql=$connect->prepare($sql);
        $sql->bindParam(':FechaD',$Fecha,PDO::PARAM_STR, 25);
        $sql->bindParam(':HoraD',$Hora,PDO::PARAM_STR,25);
        $sql->bindParam(':Responsable',$Responsable,PDO::PARAM_STR,25);
        $sql->bindParam(':Vendedor',$NameUs,PDO::PARAM_STR,25);
        $sql->bindParam(':D14x5',$D14x5,PDO::PARAM_STR,25);
        $sql->bindParam(':D16x5',$D16x5,PDO::PARAM_STR,25);
        $sql->bindParam(':Minx20',$Minx20,PDO::PARAM_STR, 25);
        $sql->execute();
        $lastInsertId=$connect->lastInsertId();

echo "<p> Gracias por tu registro </p>";
echo "<p> Se acaba de registrar nuevo despacho para el repartidor $NameUs</p>";
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

    $IdClient = $_POST['IdCli'];
    $D14x5 = $_POST['D14x5'];
    $D16x5 = $_POST['D16x5'];
    $Minx20 = $_POST['Minx20'];

    include "dbRepAGD.php";
    if($queryClients -> rowCount() > 0){
        foreach($resultsClients as $result) {
        include "Class/Client.php";
                    if($IdClient==$IdCli){
                    $query ="UPDATE clients SET Pedido='D14x5:$D14x5 - D16x5: $D16x5 - Minx20: $Minx20' WHERE IdCli=$IdClient";
                    $result=$connect->query($query);

                    echo "<p> Hemos registrado el nuevo pedido para el cliente $NameCli </p>";
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

                }}}}


    if(isset($_POST['Venta'])){ // ----------------------------------------------------------------

                    $FechaV = date('d-m-Y');
                    $HoraV = date('H:i:s');
                    $IdClient = $_POST['IdCli'];
                    $IdUser = $_POST['IdUs'];
                    $Vendedor = $_POST['Vendedor'];
                    $Cliente = $_POST['Cliente'];
                    $Barrio = $_POST['Barrio'];
                    $D14x5 = $_POST['D14x5'];
                    $D16x5 = $_POST['D16x5'];
                    $Minx20 = $_POST['Minx20'];
                    if($D14x5==''){$D14x5=0;}
                    if($D16x5==''){$D16x5=0;}
                    if($Minx20==''){$Minx20=0;}

        include "dbRepAGD.php";

        $sql="insert into ventas2021(FechaV,HoraV,Vendedor,Cliente,Barrio,D14x5,D16x5,Minx20) values(:FechaV,:HoraV,:Vendedor,:Cliente,:Barrio,:D14x5,:D16x5,:Minx20)";

        $sql=$connect->prepare($sql);
        $sql->bindParam(':FechaV',$FechaV,PDO::PARAM_STR, 25);
        $sql->bindParam(':HoraV',$HoraV,PDO::PARAM_STR, 25);
        $sql->bindParam(':Vendedor',$Vendedor,PDO::PARAM_STR,25);
        $sql->bindParam(':Cliente',$Cliente,PDO::PARAM_STR,25);
        $sql->bindParam(':Barrio',$Barrio,PDO::PARAM_STR,25);
        $sql->bindParam(':D14x5',$D14x5,PDO::PARAM_STR,25);
        $sql->bindParam(':D16x5',$D16x5,PDO::PARAM_STR,25);
        $sql->bindParam(':Minx20',$Minx20,PDO::PARAM_STR, 25);
        $sql->execute();
        $lastInsertId=$connect->lastInsertId();

        if($queryUsers -> rowCount() > 0){
        foreach($resultsUsers as $result) {
        include "Class/User.php";
                    if($IdUser==$IdUs){
                    $RD14x5=$OD14x5-$D14x5;
                    $RD16x5=$OD16x5-$D16x5;
                    $RMinx20=$OMinx20-$Minx20;

                    $query ="UPDATE usuarios SET ClienteActual=0, OD14x5=$RD14x5, OD16x5=$RD16x5, OMinx20=$RMinx20 WHERE IdUs=$IdUser";
                    $result=$connect->query($query);
                }}}

                if($queryClients -> rowCount() > 0){
                    foreach($resultsClients as $result) {
                    include "Class/Client.php";
                                           
                            $query ="UPDATE clients SET Visita='$Fecha1D', IdVendedor=0, NameVendedor=0, Pedido=0 WHERE IdCli=$IdClient";
                                $result=$connect->query($query);
                            }}

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

           include "dbRepAGD.php";

            if($queryUsers -> rowCount() > 0){
            foreach($resultsUsers as $result) {
            include "Class/User.php";
                           
                        $query ="UPDATE usuarios SET ClienteActual=0 WHERE NameUs='$UsuarioS'";
                        $result=$connect->query($query);
                    }}
    
            if($queryClients -> rowCount() > 0){
            foreach($resultsClients as $result) {
            include "Class/Client.php";
                                               
                        $query ="UPDATE clients SET IdVendedor=0, NameVendedor=0 WHERE NameVendedor='$UsuarioS'";
                        $result=$connect->query($query);
                     }}

        echo "<p> Acabas de cancelar la atencion con este cliente </p>";

            echo "<form action='Index.php' method='POST'>";
            echo "<input type='hidden' name='Usuario' Value='$UsuarioS'>";
            echo "<input type='hidden' name='Clave' Value='$ClaveS'>";
            echo "<p> <button type='submit' name='Entrar'> Regresar </button> </p>";
            echo "</form>";
            echo "<p> <a href='Sesion.php'> Cerrar Sesion </a></p>";

        
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

        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> Fecha </td> <td> Hora </td> <td> Responsable </td> <td> Vendedor </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
        echo "</tr>";

        include "dbRepAGD.php";
        if($queryDel -> rowCount() > 0){
        foreach($resultsDel as $result) {
        include "Class/Delivery.php";

        if("$CriterioDeB"=="Fecha" && "$Palabra"=="$Fecha" ){
            echo "<tr align='center'>";
            echo "<td> $Fecha </td> <td> $Hora </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
        }

        if("$CriterioDeB"=="Responsable" && "$Palabra"=="$Responsable" ){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
        }

        if("$CriterioDeB"=="Vendedor" && "$Palabra"=="$Vendedor" ){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
           
        }

        }}

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
        
        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> Fecha </td> <td> Hora </td> <td> Vendedor </td> <td> Cliente </td> <td> Barrio </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
        echo "</tr>";



        include "dbRepAGD.php";
        if($queryVent -> rowCount() > 0){
        foreach($resultsVent as $result) {
        include "Class/Vent.php";

        if("$CriterioDeB"=="Fecha" && "$Palabra"=="$FechaV" ){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
        }

        if("$CriterioDeB"=="Vendedor" && "$Palabra"=="$Vendedor" ){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
        }

        if("$CriterioDeB"=="Cliente" && "$Palabra"=="$Cliente" ){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
           
        }

        }}

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
        $ClaveEnc=md5($ClaveS);


        include "dbRepAGD.php";
        if($queryUsers -> rowCount() > 0){
        foreach($resultsUsers as $result) {
        include "Class/User.php";
            
            if($UsuarioS==$NameUs&&$ClaveEnc==$ClaveUs){

                echo "<p>¡ Bienvenido $NameUs !";
                echo "<table>";
                echo "<tr>";
                echo "<td colspan='3'> Exitencias </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> D14x5 </td><td> D16x5 </td><td> Minx20 </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> $OD14x5 </td><td> $OD16x5 </td><td> $OMinx20 </td>";
                echo "</tr>";
                echo "</table>";
            

                    if($Perfil=='Admin'){
                        include "Menus/Admin.php";
                        }

                    if($Perfil=='Rep'){
                        include "Menus/Rep.php";
                        }
                    
                    if($ClienteActual<>0){

                        if($queryClients -> rowCount() > 0){
                        foreach($resultsClients as $result) {
                        include "Class/Client.php";

                        if($ClienteActual==$IdCli){

                        echo "<Div>";
                        echo "<p> Cliente: $NameCli </p>";
                        echo "<p> Barrio: $Barrio </p> ";
                        echo "<p> Direccion: $Direccion </p>";
                        echo "<p> Telefono: $TelCli </p> ";
                        if($Pedido<>'0'){echo "<p class='Pedido'> Pedido: $Pedido </p> ";}
                        echo "</Div>";
                                
                        include "Forms/RegVenta.php";
                        
                        echo "<form action='Index.php' method='POST'>";
                        echo "<input type='hidden' name='Usuario' Value='$UsuarioS'>";
                        echo "<input type='hidden' name='Clave' Value='$ClaveS'>";
                        echo "<button type='submit' name='Cancelar'> Cancelar </button>";
                        echo "</form>";
                        echo "<Div> <a href='Sesion.php'> Cerrar Sesion </a></Div>";
                        exit();
                        }}}}
                    // Final cliente asignado --------------------------
                    

        // Inicio lista de clients------------------------------------------------
        
        
        
        
        $Barrs=array(
            1=>"La Galeria",
            2=>"Lleras",
            3=>"Santos",
        );
        

            
            $Br = 1;
            while($Br <= 3){
               $Barr = $Br++; 
               $Barrios = $Barrs[$Barr]; 
    
             if($queryClients -> rowCount() > 0){
             foreach($resultsClients as $result) {
             include "Class/Client.php";

    
                    if($Fecha==$Visita && $ClienteActual==0 && $Barrios==$Barrio){

                    if($OD14x5>=$DD14x5 && $OD16x5>=$DD16x5 && $OMinx20>=$DMinx20){
                    echo "<div>";
                    echo "<p> Cliente: $NameCli </p>";
                    echo "<p> Barrio: $Barrio </p> ";
                    echo "<p> Direccion: $Direccion </p>";
                    echo "<p> Telefono: $TelCli </p> ";
                    
                                                         
                    if($Pedido<>'0'){   
                        echo "<p class='Pedido'> Pedido: $Pedido </p> ";
                        }

                    if($IdVendedor==0){   
                    echo "<p> <a href='Index.php?Cliente=$IdCli&Usuario=$IdUs'> Gestionar Cliente </a> </p>";
                    echo "</div>";
                    }

                    if($IdVendedor<>0){
                    echo "<p>  Asignado a $NomVendedor </p>";
                    echo "</div>";
                    }
                    }}}}}
                   

                    if($OD14x5==0 && $OD16x5==0 && $OMinx20==0){

                        echo "<div>";
                        echo "<p> Para ver los clients que actualmente estan esparendo visita </p>";
                        echo "<p> debes contar con producto disponible.</p>";
                        echo "<p> lo puedes adquirir en la direccion:</p>";
                        echo "<p> Carrera 30a # 50a 65 Barrio Eucaliptus (Manizales - Caldas)</p>";
                        echo "</div>";
                        exit();
                        }
                        exit();
                    }}}}
                
                        
                    
         // Final lista de clients --------------------------                    

        

        echo'<form action="Index.php" method="POST">';
        echo '<input type="text" name="Usuario" placeholder="Usuario" required>';
        echo '<input type="password" name="Clave" placeholder="Clave" required>';
        echo '<button type="submit" name="Entrar"> Entrar </button>';     
        echo '</form>';
        
        echo "<Div>";
        echo "<a href='Index.php?Seccion=NuevoUsuario'> Registrarme </a>";
        echo "</Div>";

        echo "<Div>";
        echo "<a href='Index.php?Seccion=RecuperarClave'> No recuerdo mi contraseña </a>";
        echo "</Div>";
       
        
    
    ?>
    
</body>
</html>