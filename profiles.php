<?php
$opens_list="<ul>";
$new_client="<li><a id='a_menu' href='index.php?usuario=$id_us&seccion=nuevoCliente'> Nuevo Cliente &nbsp; &nbsp; &nbsp; &nbsp; NC</a></li>";
$list_clients="<li><a id='a_menu' href='index.php?usuario=$id_us&seccion=listarClientes'> Listar Clientes &nbsp; &nbsp; &nbsp; &nbsp; LC</a></li>";
$list_delivery_men="<li><a id='a_menu' href='index.php?usuario=$id_us&seccion=listarRepartidores'> Listar Repartidores &nbsp; &nbsp; &nbsp; &nbsp; LR</a></li>";
$dispatch_history="<li><a id='a_menu' href='index.php?usuario=$id_us&seccion=HDespachos'> Historial de despachos &nbsp; &nbsp; &nbsp; &nbsp; HD</a></li>";
$sales_history="<li><a id='a_menu' href='index.php?usuario=$id_us&seccion=HVentas'> Historial de ventas &nbsp; &nbsp; &nbsp; &nbsp; HV</a></li>";
$close_session="<li><a id='a_menu' href='sesion.php'> Cerrar Sesion &nbsp; &nbsp; &nbsp; &nbsp; CS</a></li>";  
$closes_list="</ul>";

function admin($opens_list,$new_client,$list_clients,$list_delivery_men,$dispatch_history,$sales_history,$close_session,$closes_list)
{
echo $opens_list;
echo $new_client;
echo $list_clients;
echo $list_delivery_men;
echo $dispatch_history;
echo $sales_history;
echo $close_session;
echo $closes_list;
}

function rep($opens_list,$new_client,$close_session,$closes_list)
{
echo $opens_list;
echo $new_client;
echo $close_session;
echo $closes_list;
}

// para insertar en el index: admin($opens_list,$new_client,$list_clients,$list_delivery_men,$dispatch_history,$sales_history,$close_session,$closes_list);

// para insertar en el index: rep($opens_list,$new_client,$close_session,$closes_list);



?>