<?php
session_start();
include 'head.php';
$Fecha = date('d-m-Y');
include "arrays/visit_frequency.php";

if(isset($_GET['seccion'])){
    $seccion = $_GET['seccion'];
        if($seccion == "nuevoUsuario"){
            include "Forms/nuevoUsuario.php";
            exit();
        }

        if($seccion == "recuperarClave"){
            include "Forms/recClave.php";
            exit();
        }

    }

    if(isset($_POST['recClave'])){
        $Email = $_POST['Email'];
        include "arrays/letters.php";
        
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
    $Contenido = "Para cambiar tu contraseña utiliza el codigo: $Cod \nArepas El Grano Dorado (AGD) \nhttps://elgranodorado.com";

    mail($To, $Asunto, $Contenido);
    echo "<div>";
    echo "<p> Hemos enviado un codigo a tu correo para actualizar tu contraseña </p>";
    echo "<p> Si no lo encuentras en la bandeja de entrada no olvides revisar en spam </p>";
    include "Forms/camClave.php";
    echo "</div>";
        exit();
    }


    if(isset($_POST['camClave'])){
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
            include "Class/user.php";
                        if("$Email"=="$email_us"){
                         $query ="UPDATE users SET key_us='$ClaveEnc'
                         WHERE email_us='$Email'";
                        $result=$connect->query($query);
                    }}}

            unlink($Arc);

    echo "<p> La contraseña se ha actualizado correctamente. </p>";
    echo "<p> Ahora puedes ingresar a la plataforma de repartos. </p>";
    echo "<div>";
    echo " <a href='index.php'> Ir a la pagina principal para iniciar sesion </a>";
    echo "</div>";

    exit();

            }
            }else{
                echo "<p> El codigo no es correcto o las claves no coinciden </p>";
                echo "<div>";
                echo " <a href='index.php'> Regresar </a>";
                echo "</div>";
                 exit();
                    
        }
    }
    
    

    if(isset($_POST['nuevoUsuario'])){
        include "arrays/letters.php";
        $LetA = rand(1,26);
        $LetterA = $Letter["$LetA"];
        $NumA = rand(00,99);
        $LetB = rand(1,26);
        $LetterB = $Letter["$LetB"];
        $NumB = rand(00,99);
        $Cod = "$LetterA$NumA$LetterB$NumB";
        
        $NUsuario = $_POST['usuario'];
        $Email = $_POST['email'];
        $ConfEmail = $_POST['conf_email'];
        $NTelefono = $_POST['telefono'];
        $CodEnc = md5($Cod);
        $profile='rep';
        $customer=0;
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

                $email_us=$result->email_us;
                
                if($Email==$email_us){
                echo "<p> El Correo ingresado ya existe en nuestro sistema </p>"; 
                echo "<p> Por favor intenta con otro o recupera la contraseña </p>";
                   echo "<Div>";
                   echo "<a href='index.php?seccion=nuevoUsuario'> Regresar </a>";
                   echo "</Div>"; 
                exit();
                 } 
        }}
        
        if($Email==$ConfEmail){
        $sql="insert into usuarios(name_us,email_us,tel_us,key_us,profile,customer,OD14x5,OD16x5,OMinx20) values(:name_us,:email_us,:tel_us,:key_us,:profile,:customer,:OD14x5,:OD16x5,:OMinx20)";

        $sql=$connect->prepare($sql);

        $sql->bindParam(':name_us',$NUsuario,PDO::PARAM_STR, 25);
        $sql->bindParam(':email_us',$Email,PDO::PARAM_STR, 25);
        $sql->bindParam(':tel_us',$NTelefono,PDO::PARAM_STR,25);
        $sql->bindParam(':key_us',$CodEnc,PDO::PARAM_STR,25);
        $sql->bindParam(':profile',$profile,PDO::PARAM_STR,25);
        $sql->bindParam(':customer',$customer,PDO::PARAM_STR,25);
        $sql->bindParam(':OD14x5',$OD14x5,PDO::PARAM_STR,25);
        $sql->bindParam(':OD16x5',$OD16x5,PDO::PARAM_STR,25);
        $sql->bindParam(':OMinx20',$OMinx20,PDO::PARAM_STR);

        $sql->execute();
        $lastInsertId=$connect->lastInsertId();


    $fp = fopen("Temp/$CodEnc.php","w");
    fputs($fp, "<?php \n");
    fputs($fp, "$"."Code = '$CodEnc'; \n");
    fputs($fp, "?> \n");
    fclose($fp);


    $To = "$Email";
    $Asunto =  "Confirmar correo Repartidores AGD";
    $Contenido = "Bienvenido $NUsuario \n
    Para crear tu contraseña en elgranodorado.com/GRAP utiliza el codigo: $Cod \n
    Gracias por tu apoyo, esperamos que tengas buenas experiencias.\n";
    mail($To, $Asunto, $Contenido);

    echo "<div>";
    echo "<p> Por favor utiliza el codigo que enviamos al correo $Email  </p>";
    echo "<p> para crear tu clave de acceso </p>";
    echo "</div>";
        echo "$Cod";
   include "Forms/camClave.php";

    exit();
        }else{
            echo "<p> Los dos correops ingresados deben ser iguales</p>";
            echo "<p> </p>";
            echo "<p> </p>";
            echo "<a href='index.php?seccion=nuevoUsuario'> Intentar de nuevo </a>";
            exit();
        }
    
    }

        if(isset($_POST['nuevoCliente'])){
            $UsuarioS=$_SESSION['usuario'];
            $ClaveS=$_SESSION['clave'];
            $NCliente=$_POST['Cliente'];
            $NBarrio=$_POST['Barrio'];
            $NDireccion=$_POST['Direccion'];
            $NTelefono = $_POST['Telefono'];
            $NColor=$_POST['Color'];
            $NumAl=$_POST['NumAl'];
            $NFrecuencia=1;
            $NVisita="$Fecha";
            $Nhour=date('H:i');
            $NDD14x5=0;
            $NDD16x5=0;
            $NDMinx20=0;
            $NIdVendedor=0;
            $NNameVendedor='0';
            $NPedido='0';
            $NObservations='0';


            include "dbRepAGD.php";

            if($queryClients -> rowCount() > 0){
            foreach($resultsClients as $result) {
            include "Class/client.php";
                
                if($NCliente==$NameCli or $NDireccion==$Direccion or $NTelefono==$TelCli){
                    echo "<p> Este Cliente ya existe en nuestro sistema </p>";

                    include 'Forms/but_return.php';
                    exit();
                 } 
        }}
    
    if($NColor==$NumAl){

        $sql="insert into clients(NameCli,Barrio,Direccion,TelCli,Frecuencia,Visita,hour,DD14x5,DD16x5,DMinx20,IdVendedor,NameVendedor,Pedido,observations) values(:NameCli,:Barrio,:Direccion,:TelCli,:Frecuencia,:Visita,:hour,:DD14x5,:DD16x5,:DMinx20,:IdVendedor,:NameVendedor,:Pedido,:observations)";

        $sql=$connect->prepare($sql);

        $sql->bindParam(':NameCli',$NCliente,PDO::PARAM_STR, 25);
        $sql->bindParam(':Barrio',$NBarrio,PDO::PARAM_STR, 25);
        $sql->bindParam(':Direccion',$NDireccion,PDO::PARAM_STR,25);
        $sql->bindParam(':TelCli',$NTelefono,PDO::PARAM_STR,25);
        $sql->bindParam(':Frecuencia',$NFrecuencia,PDO::PARAM_STR,25);
        $sql->bindParam(':Visita',$NVisita,PDO::PARAM_STR,25);
        $sql->bindParam(':hour',$Nhour,PDO::PARAM_STR,25);
        $sql->bindParam(':DD14x5',$NDD14x5,PDO::PARAM_STR,25);
        $sql->bindParam(':DD16x5',$NDD16x5,PDO::PARAM_STR,25);
        $sql->bindParam(':DMinx20',$NDMinx20,PDO::PARAM_STR, 25);
        $sql->bindParam(':IdVendedor',$NIdVendedor,PDO::PARAM_STR,25);
        $sql->bindParam(':NameVendedor',$NNameVendedor,PDO::PARAM_STR,25);
        $sql->bindParam(':Pedido',$NPedido,PDO::PARAM_STR, 25);
        $sql->bindParam(':observations',$NObservations,PDO::PARAM_STR, 25);

        $sql->execute();
        $lastInsertId=$connect->lastInsertId();

    echo "<p> Proceso exitoso, gracias por tu registro </p>";

            include 'Forms/but_return.php';

    exit();
    }}


if(isset($_GET['usuario'])&&isset($_GET['seccion']) or (isset($_GET['usuario'])&&isset($_GET['seccion'])&&isset($_GET['client']))){

    $seccion = $_GET['seccion'];
    $id_usuario = $_GET['usuario'];

            include "dbRepAGD.php";
        
        if($queryUsers -> rowCount() > 0){
            foreach($resultsUsers as $result) {

                $id_us=$result->id_us;
                
                if($id_us==$id_usuario){        

    if($seccion == 'nuevoCliente'){
           include "var_session.php";

        $Al = rand(1,4);
        $NumColor = "Color$Al";
       
        echo "<div>";
        include "Forms/nuevoCliente.php";
        include 'Forms/but_return.php';
        echo "</div>";
            
        exit();

    }

    if($seccion == 'listarClientes'){
        include "var_session.php";
        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> ID </td> <td> Cliente </td> <td> Barrio </td> <td> Direccion </td>  <td> Telefono </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td> <td> Frecuencia </td> <td> Proxima Visita </td> <td> Vendedor actual </td><td> Pedido </td>";
        echo "</tr>";

        if($queryClients -> rowCount() > 0){
            foreach($resultsClients as $result) {
            include "Class/client.php";

            echo "<tr align='center'>";
                echo "<td> $IdCli </td> <td> $NameCli </td> <td> $Barrio </td> <td> $Direccion </td> <td> $TelCli </td> <td> $DD14x5 </td> <td> $DD16x5 </td> <td> $DMinx20 </td> <td><a href='index.php?usuario=$id_us&seccion=frecuencia_visita&client=$IdCli'> $Frec </a> </td> <td> $Visita </td> <td> $NameVendedor </td> <td> <a href='index.php?usuario=$id_us&seccion=Pedidos&client=$IdCli'> $Pedido </a> </td>";
                echo "</tr>";
        
        }}
        echo "</table>";          
            include "var_session.php";
            echo "<form action='index.php' method='POST'>";
            echo "<input type='hidden' name='usuario' Value='$UsuarioS'>";
            echo "<input type='hidden' name='clave' Value='$ClaveS'>";
            echo "<button type='submit' name='Entrar'> Regresar </button>";
            echo "</form>";
            exit();
        }


        if($seccion == 'listarRepartidores'){
            include "var_session.php";
            echo "<table align='center'>";
            echo "<tr align='center'>";
            echo "<td> ID </td> <td> Repartidor </td> <td> Email </td> <td> Telefono </td>  <td> profile </td> <td> Cliente actual </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
            echo "</tr>";

        if($queryUsers -> rowCount() > 0){
        foreach($resultsUsers as $result) {
        include "Class/user.php";

        echo "<tr align='center'>";
                    echo "<td> $id_us </td> <td> $name_us </td> <td> $email_us </td> <td> $tel_us </td> <td> $profile </td> <td> $customer </td> <td> <a href='index.php?usuario=$id_us&seccion=despacho'> $OD14x5 </a> </td> <td> <a href='index.php?usuario=$id_us&seccion=despacho'> $OD16x5 </a> </td> <td> <a href='index.php?usuario=$id_us&seccion=despacho'> $OMinx20 </a> </td>";
        echo "</tr>";
    
    
    
    
    }}

              echo "</table>";

                include 'Forms/but_return.php';
                
                exit();
            }

    if($seccion == 'despacho'){
            include "var_session.php";
            $id_rep=$_GET['usuario'];
            echo "<Div>";
            echo "<h2> Despachar repartidor id: $id_rep </h2>";
            include "Forms/despacho.php";
            include 'Forms/but_return.php';
            echo "<a href='sesion.php'> Cerrar sesion </a>";
            echo "</Div>";
           
            exit();
        }

        if($seccion=='Pedidos'){
            include "var_session.php";
            $IdCli=$_GET['client'];
            echo "<Div>";
            echo "<h2> Pedido de cliente id: $IdCli </h2>";
             echo "<form action='index.php' method='POST'>";
             echo "<input type='hidden' name='Responsable' Value='$id_usuario'>";
             echo "<input type='hidden' name='IdCli' Value='$IdCli'>";
             echo "<p> <input type='text' name='D14x5' placeholder='D14x5' required> </p>";
             echo "<p> <input type='text' name='D16x5' placeholder='D16x5'required> </p>";
             echo "<p> <input type='text' name='Minx20' placeholder='Minx20' required> </p>";
             echo "<p> <input type='textarea' name='Observations' placeholder='Observaciones'> </p>";
             echo "<p><button type='submit' name='Pedido'> Registrar pedido </button> </p>";
             echo "</form>";

                include 'Forms/but_return.php';
                echo "<p> <a href='sesion.php'> Cerrar sesion </a></p>";
                echo "</Div>";
                exit();
            }


            if($seccion=='frecuencia_visita'){
                include "var_session.php";
                $IdCli=$_GET['client'];
                echo "<Div>";
                echo "<h2> frecuencia de visita cliente id: $IdCli </h2>";
                 echo "<form action='index.php' method='POST'>";
                 echo "<input type='hidden' name='IdCli' Value='$IdCli'>";
                 echo "<p> <input type='number' name='fdias' placeholder='dias' required> </p>";
                 echo "<p><button type='submit' name='frecuencia_visita'> Cambiar Frecuencia </button> </p>";
                 echo "</form>";
    
                    include 'Forms/but_return.php';
                    echo "<p> <a href='sesion.php'> Cerrar sesion </a></p>";
                    echo "</Div>";
                    exit();
                }



            if($seccion=='HDespachos'){
                $UsuarioS=$_SESSION['usuario'];
                $ClaveS=$_SESSION['clave'];

                 echo "<div>";
                 echo "<form action='index.php' method='POST'>";
                 echo "<p> Historial de despachos :</p>";
                 echo "<input type='hidden' name='usuario' Value='$UsuarioS'>";
                 echo "<input type='hidden' name='clave' Value='$ClaveS'>";
                 echo "<p> <input type='Text' name='Fecha' placeholder='Fecha (DD-MM-AAAA)'> </p>";
                 echo "<p> <input type='Text' name='Responsable' placeholder='Responsable'> </p>";
                 echo "<p> <input type='Text' name='Vendedor' placeholder='Vendedor'> </p>";
                 echo "<p><button type='submit' name='HDespachos'> Consultar Historial </button> </p>";
                 echo "</form>";
                    include 'Forms/but_return.php';
                    echo "</div>";
                    exit();
                }


                if($seccion=='HVentas'){
                $UsuarioS=$_SESSION['usuario'];
                $ClaveS=$_SESSION['clave'];

                 echo "<Div>";
                 echo "<form action='index.php' method='POST'>";
                 echo "<p> Historial de Ventas :</p>";
                 echo "<input type='hidden' name='usuario' Value='$UsuarioS'>";
                 echo "<input type='hidden' name='clave' Value='$ClaveS'>";
                 echo "<input type='Text' name='FechaHV' placeholder='Fecha (DD-MM-AAAA)'>";
                 echo "<input type='Text' name='VendedorV' placeholder='Vendedor'>";
                 echo "<input type='Text' name='ClienteV' placeholder='Cliente'>";
                 echo "<button type='submit' name='HVentas'> Consultar </button>";
                 echo "</form>";

                 include 'Forms/but_return.php';
                    echo "</Div>";
                    exit();
                }
            }}}}


    if(isset($_GET['Cliente'])&&isset($_GET['usuario'])){ 
    include "var_session.php";
    $id_user = $_GET['usuario'];
    $IdClient = $_GET['Cliente'];

    include "dbRepAGD.php";

    if($queryUsers -> rowCount() > 0){
    foreach($resultsUsers as $result) {
    include "Class/user.php";

    if($queryClients -> rowCount() > 0){
    foreach($resultsClients as $result) {
    include "Class/client.php";
    
   if($IdVendedor==0 && $customer==0 && $id_user==$id_us){ 
        include "var_session.php";
        $query = "UPDATE users SET customer='$IdClient' WHERE id_us=$id_user";
        $result=$connect->query($query);

        $query2 = "UPDATE clients SET IdVendedor='$id_user', NameVendedor='$name_us' WHERE IdCli=$IdClient";
        $result2=$connect->query($query2);
        echo "<div>";
        include "Listas/prot.php";
        echo "<form action='index.php' method='POST'>";
        echo "<input type='hidden' name='usuario' value='$UsuarioS'>";
        echo "<input type='hidden' name='clave' value='$ClaveS'>";
        echo "<button type='submit' name='Entrar'> CONTINUAR </button>";
        echo "</form>";
        echo "</div>";
        exit();
            }
        }}}}

    if($IdVendedor<>0 && $customer==0){
        echo "<p> Lo sentimos, este Cliente lo acaba de seleccionar otro usuario </p>";
        echo "<p> Pero no te preocupes, hay mas opciones disponibles </p>";
        echo "<p> <a href='index.php'> Por favor seleccione esta linea para continuar </a> </p>";
    }
    }

    if(isset($_POST['despacho'])){
        include "var_session.php";
        $Fecha = date('d-m-Y');
        $Hora = date('H:i:s');
        $Responsable = $UsuarioS;
        $IdVendedor = $_POST['IdVendedor'];
        $D14x5 = $_POST['D14x5'];
        $D16x5 = $_POST['D16x5'];
        $Minx20 = $_POST['Minx20'];

        include "dbRepAGD.php";
        if($queryUsers -> rowCount() > 0){
            foreach($resultsUsers as $result) {
            include "Class/user.php";
                        if($IdVendedor==$id_us){
                            $RD14x5=($OD14x5+$D14x5);
                            $RD16x5=($OD16x5+$D16x5);
                            $RMinx20=($OMinx20+$Minx20);
             
                         $query ="UPDATE users SET OD14x5=$RD14x5, OD16x5=$RD16x5, OMinx20=$RMinx20
                         WHERE id_us=$IdVendedor";
                        $result=$connect->query($query);
                    

        $sql="insert into deliveries2021(FechaD,HoraD,Responsable,Vendedor,D14x5,D16x5,Minx20)
        values(:FechaD,:HoraD,:Responsable,:Vendedor,:D14x5,:D16x5,:Minx20)";
        $sql=$connect->prepare($sql);
        $sql->bindParam(':FechaD',$Fecha,PDO::PARAM_STR, 25);
        $sql->bindParam(':HoraD',$Hora,PDO::PARAM_STR,25);
        $sql->bindParam(':Responsable',$Responsable,PDO::PARAM_STR,25);
        $sql->bindParam(':Vendedor',$name_us,PDO::PARAM_STR,25);
        $sql->bindParam(':D14x5',$D14x5,PDO::PARAM_STR,25);
        $sql->bindParam(':D16x5',$D16x5,PDO::PARAM_STR,25);
        $sql->bindParam(':Minx20',$Minx20,PDO::PARAM_STR, 25);
        $sql->execute();
        $lastInsertId=$connect->lastInsertId();

echo "<p> Se acaba de registrar nuevo despacho para el repartidor $name_us</p>";
}}}
            include 'Forms/but_return.php';
            echo "<p> <a href='sesion.php'> Cerrar sesion </a></p>";

exit();
}

if(isset($_POST['Pedido'])){ 
    include "var_session.php";
    $IdClient = $_POST['IdCli'];
    $D14x5 = $_POST['D14x5'];
    $D16x5 = $_POST['D16x5'];
    $Minx20 = $_POST['Minx20'];
    $Observ = $_POST['Observations'];

    include "dbRepAGD.php";
    if($queryClients -> rowCount() > 0){
        foreach($resultsClients as $result) {
        include "Class/client.php";
                    if($IdClient==$IdCli){
                    $query ="UPDATE clients SET Pedido='D14x5:$D14x5 - D16x5: $D16x5 - Minx20: $Minx20', observations='$Observ' WHERE IdCli=$IdClient";
                    $result=$connect->query($query);

                    echo "<p> Hemos registrado el nuevo pedido para el Cliente $NameCli </p>";
                    echo "<p> Gracias por tu gestion </p>";

                    include 'Forms/but_return.php';
                    echo "<p> <a href='sesion.php'> Cerrar sesion </a></p>";

                    exit();

                }}}}

                if(isset($_POST['frecuencia_visita'])){ 
                    include "var_session.php";
                    $IdClient = $_POST['IdCli'];
                    $fdias = $_POST['fdias'];
                    
                    include "dbRepAGD.php";
                    if($queryClients -> rowCount() > 0){
                        foreach($resultsClients as $result) {
                        include "Class/client.php";
                                    if($IdClient==$IdCli){
                                    $query ="UPDATE clients SET Frecuencia='$fdias' WHERE IdCli=$IdClient";
                                    $result=$connect->query($query);
                
                                    echo "<p> Hemos actualizado la frecuencia de visita para el Cliente $NameCli </p>";
                                    echo "<p> Gracias por tu gestion </p>";
                
                                    include 'Forms/but_return.php';
                                    echo "<p> <a href='sesion.php'> Cerrar sesion </a></p>";
                
                                    exit();
                
                                }}}}


    if(isset($_POST['venta'])){ // ----------------------------------------------------------------
    include "var_session.php";
                    $FechaV = date('d-m-Y');
                    $HoraV = date('H:i:s');
                    $hora = date('H:i');
                    $IdClient = $_POST['IdCli'];
                    $id_user = $_POST['id_us'];
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
        include "Class/user.php";
                    if($id_user==$id_us){
                    $RD14x5=$OD14x5-$D14x5;
                    $RD16x5=$OD16x5-$D16x5;
                    $RMinx20=$OMinx20-$Minx20;

                    $query ="UPDATE users SET customer=0, OD14x5=$RD14x5, OD16x5=$RD16x5, OMinx20=$RMinx20 WHERE id_us=$id_user";
                    $result=$connect->query($query);
                }}}

                if($queryClients -> rowCount() > 0){
                    foreach($resultsClients as $result) {
                    include "Class/client.php";

                        if($IdCli==$IdClient){
                        $neighborhood=$Barrio;
                        if($D14x5==0 && $DD14x5==0){$DemD14x5=0;}
                        if($D14x5>0 or $DD14x5>0){$DemD14x5=($D14x5+$DD14x5)/2;}
                        if($D16x5==0 && $DD16x5==0){$DemD16x5=0;}
                        if($D16x5>0 or $DD16x5>0){$DemD16x5=($D16x5+$DD16x5)/2;}
                        if($Minx20==0 && $DMinx20==0){$DemMinx20=0;}
                        if($Minx20>0 or $DMinx20>0){$DemMinx20=($Minx20+$DMinx20)/2;}
                    
                            $query ="UPDATE clients SET Visita='$Visit[$Frec]',hour='$hora',IdVendedor=0, NameVendedor=0, Pedido=0, DD14x5=$DemD14x5, DD16x5=$DemD16x5, DMinx20=$DemMinx20, Pedido='0', observations='0' WHERE IdCli=$IdClient";
                                $result=$connect->query($query);
                                
                            }}}
                            $tD14x5=$D14x5*700;
                            $tD16x5=$D16x5*1000;
                            $tMinx20=$Minx20*1800;
                            $ValTot=$tD14x5+$tD16x5+$tMinx20;
                            echo "<div>";
                            echo "<table>";
                            echo "<tr>";
                            echo "<td colspan='2'> $Cliente </td>";
                            echo "<td colspan='2'> $neighborhood  </td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td> Referencia </td>";
                            echo "<td> Cantidad </td>";
                            echo "<td> Valor Unitario </td>";
                            echo "<td> Valor Total </td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td> D14x5 </td>";
                            echo "<td> $D14x5 </td>";
                            echo "<td> 700 </td>";
                            echo "<td> $tD14x5 </td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td> D16x5 </td>";
                            echo "<td> $D16x5 </td>";
                            echo "<td> 1000 </td>";
                            echo "<td> $tD16x5 </td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td> DMinx20 </td>";
                            echo "<td> $Minx20 </td>";
                            echo "<td> 1800 </td>";
                            echo "<td> $tMinx20 </td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan='3'> Valor total: </td>";
                            echo "<td> $ValTot </td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "<P> Registro exitoso </P>";
                         include 'Forms/but_return.php';
                         echo "<div>";
                        

    exit();
    }

    if(isset($_POST['Cancelar'])){
        $UsuarioS = $_SESSION['usuario'];
        $ClaveS = $_SESSION['clave'];

           include "dbRepAGD.php";

            if($queryUsers -> rowCount() > 0){
            foreach($resultsUsers as $result) {
            include "Class/user.php";
                           
                        $query ="UPDATE users SET customer=0 WHERE name_us='$UsuarioS'";
                        $result=$connect->query($query);
                    }}
    
            if($queryClients -> rowCount() > 0){
            foreach($resultsClients as $result) {
            include "Class/client.php";
                                               
                        $query ="UPDATE clients SET IdVendedor=0, NameVendedor=0 WHERE NameVendedor='$UsuarioS'";
                        $result=$connect->query($query);
                     }}

            echo "<div>";
            echo "<p> Acabas de cancelar la atencion con este Cliente </p>";
            include 'Forms/but_return.php';
            echo "</div>";
            exit();

    }

    
    if(isset($_POST['HDespachos'])){
        $UsuarioS = $_SESSION['usuario'];
        $ClaveS = $_SESSION['clave'];

        $FechaHD = $_POST['Fecha'];
        $Resp= $_POST['Responsable'];
        $Vend = $_POST['Vendedor'];

        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> Fecha </td> <td> Hora </td> <td> Responsable </td> <td> Vendedor </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
        echo "</tr>";

        $SumD14x5=0;
        $SumD16x5=0;
        $SumMinx20=0;
        include "dbRepAGD.php";
        if($queryDel -> rowCount() > 0){
        foreach($resultsDel as $result) {
        include "Class/delivery.php";
        
        if("$FechaHD"=="$FechaD" && "$Resp"=="$Responsable" && "$Vend"=="$Vendedor"){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }

        
        if("$FechaHD"=="" && "$Resp"=="$Responsable" && "$Vend"=="$Vendedor"){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHD"=="$FechaD" && "$Resp"=="" && "$Vend"=="$Vendedor"){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHD"=="$FechaD" && "$Resp"=="$Responsable" && "$Vend"==""){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHD"=="$FechaD" && "$Resp"=="" && "$Vend"==""){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHD"=="" && "$Resp"=="$Responsable" && "$Vend"==""){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHD"=="" && "$Resp"=="" && "$Vend"=="$Vendedor"){
            echo "<tr align='center'>";
            echo "<td> $FechaD </td> <td> $HoraD </td> <td> $Responsable </td> <td> $Vendedor </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        }
        }
        echo "<td Colspan='4'> Total <td> $SumD14x5 </td> <td> $SumD16x5 </td> <td> $SumMinx20 </td>";

          echo "</table>";
            

            include 'Forms/but_return.php';
            echo "<p> <a href='sesion.php'> Cerrar sesion </a></p>";
            echo "</Div>";
            exit();
                       
                        }



        if(isset($_POST['HVentas'])){
        $UsuarioS = $_SESSION['usuario'];
        $ClaveS = $_SESSION['clave'];

        $FechaHV = $_POST['FechaHV'];
        $VendedorV = $_POST['VendedorV'];
        $ClienteV = $_POST['ClienteV'];
        
        
        echo "<table align='center'>";
        echo "<tr align='center'>";
        echo "<td> Fecha </td> <td> Hora </td> <td> Vendedor </td> <td> Cliente </td> <td> Barrio </td> <td> D14x5 </td> <td> D16x5 </td> <td> Minx20 </td>";
        echo "</tr>";


        $SumD14x5=0;
        $SumD16x5=0;
        $SumMinx20=0;
        include "dbRepAGD.php";
        if($queryVent -> rowCount() > 0){
        foreach($resultsVent as $result) {
        include "Class/vent.php";

        if("$FechaHV"=="$FechaV" && "$VendedorV"=="$Vendedor" && "$ClienteV"=="$Cliente"){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHV"=="$FechaV" && "$VendedorV"=="$Vendedor" && "$ClienteV"==""){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHV"=="$FechaV" && "$VendedorV"=="" && "$ClienteV"=="$Cliente"){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHV"=="" && "$VendedorV"=="$Vendedor" && "$ClienteV"=="$Cliente"){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHV"=="$FechaV" && "$VendedorV"=="" && "$ClienteV"==""){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHV"=="" && "$VendedorV"=="$Vendedor" && "$ClienteV"==""){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }
        if("$FechaHV"=="" && "$VendedorV"=="" && "$ClienteV"=="$Cliente"){
            echo "<tr align='center'>";
            echo "<td> $FechaV </td> <td> $HoraV </td> <td> $Vendedor </td> <td> $Cliente </td> <td> $Barrio </td> <td> $D14x5 </td> <td> $D16x5 </td> <td> $Minx20 </td>";
            echo "</tr>";
            $SumD14x5+=$D14x5;
            $SumD16x5+=$D16x5;
            $SumMinx20+=$Minx20;
        }        

        }}
        echo "<td Colspan='5'> Total <td> $SumD14x5 </td> <td> $SumD16x5 </td> <td> $SumMinx20 </td>";

           echo "</table>";
            

            include 'Forms/but_return.php';
            echo "<p> <a href='sesion.php'> Cerrar sesion </a></p>";
            echo "</Div>";
            exit();
                       
            }
            
    if(isset($_POST['Entrar'])){

        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['clave'] = $_POST['clave'];  
        
        if(session_status() == PHP_SESSION_ACTIVE){
        $UsuarioS = $_SESSION['usuario'];
        $ClaveS = $_SESSION['clave'];
        $ClaveEnc=md5($ClaveS);
        }

        include "dbRepAGD.php";
        if($queryUsers -> rowCount() > 0){
        foreach($resultsUsers as $result) {
        include "Class/user.php";
            
            if($UsuarioS==$name_us&&$ClaveEnc==$key_us){

                echo "<table>";
                echo "<tr>";
                echo "<td colspan='3'><p> ¡ Bienvenido $name_us ! </p></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> <p> D14x5 </p></td><td> <p> D16x5 </p> </td><td> <p> Minx20 </p> </td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td> <p> $OD14x5 </p> </td><td> <p> $OD16x5 </p> </td><td> <p> $OMinx20 </p> </td>";
                echo "</tr>";
                echo "</table>";
            

                    if($profile=='admin'){
                        include "Menus/admin.php";
                        }

                    if($profile=='rep'){
                        include "Menus/rep.php";
                        }
                    
                    if($customer<>0){

                        if($queryClients -> rowCount() > 0){
                        foreach($resultsClients as $result) {
                        include "Class/client.php";

                        if($customer==$IdCli){

                        echo "<Div>";
                        echo "<p> $NameCli </p>";
                        echo "<p class='p_br'> $Barrio </p> ";
                        echo "<p> $Direccion </p>";
                        echo "<p> $TelCli </p> ";
                        if($Pedido<>'0'){
                            echo "<p class='Pedido'> Pedido: $Pedido <br> ";
                            echo "Observacion: $Observation </p> ";
                        }
                           
                        include "Forms/regVenta.php";
                        
                        echo "<form action='index.php' method='POST'>";
                        echo "<button type='submit' name='Cancelar'> Cancelar </button>";
                        echo "</form>";
                        echo "</Div>";
                        exit();
                        
                        }}}}     

        
            $cola_h = 0;
            while($cola_h <= 23){
               $colahh = $cola_h++; 

               $cola_m=0;
               while($cola_m<=60){
                $colamm = $cola_m++; 
                
                $cola="$colahh:$colamm";
                    
             if($queryClients -> rowCount() > 0){
             foreach($resultsClients as $result) {
             include "Class/client.php";

                    if($Fecha>=$Visita && $customer==0 && "$cola"=="$hour"){

                    if($OD14x5>$DD14x5 && $OD16x5>$DD16x5 && $OMinx20>$DMinx20){
                    echo "<div>";
                    echo "<p> $NameCli </p>";
                    echo "<p class='p_br'> $Barrio </p> ";
                    echo "<p> $Direccion </p>";
                    echo "<p> $TelCli </p> ";
                    
                                                         
                    if($Pedido<>'0'){   
                            echo "<p class='Pedido'> Pedido: $Pedido <br> ";
                            echo "Observacion: $Observation </p> ";
                            }

                    if($IdVendedor==0){   
                    echo "<p> <a href='index.php?Cliente=$IdCli&usuario=$id_us'> Gestionar Cliente </a> </p>";
                    echo "</div>";
                    }

                    if($IdVendedor<>0){
                    echo "<p>  Asignado a $NameVendedor </p>";
                    echo "</div>";
                    }
                    }}}}}}
                   

                    if($OD14x5<=0 && $OD16x5<=0 && $OMinx20<=0){

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

        echo "<Div>";
        echo'<form action="index.php" method="POST">';
        echo '<input type="text" name="usuario" placeholder="usuario" required>';
        echo '<input type="password" name="clave" placeholder="clave" required>';
        echo '<button type="submit" name="Entrar"> Entrar </button>';     
        echo '</form>';
        
        echo "<a href='index.php?seccion=nuevoUsuario'> Registrarme </a>";
        
        echo "<a href='index.php?seccion=recuperarClave'> No recuerdo mi contraseña </a>";
        echo "</Div>";
       
        
    
    ?>
    
</body>
</html>