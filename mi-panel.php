<?php
/******************************************
/* Página de panel de usuario
******************************************/

//Título de página
$title = "Mis puntos - Telefónica";
//Comprobar usuario logado y obtener panel de usuario
include("store-data/check-user-login.php");
//Funciones auxiliares
include("functions.php");

//Creación del contenido de página

//Conectar a BBDD
include("store-data/db_connection.php");

//Coger historial de usuario
$data=getUserPointsHistory($conn, $userName, $idGoal);

$table=$data["table"];
$jsdata=$data["jsdata"];

//Obtener nombre de la oferta
$goalName = getGoalName($idGoal);

if($table==""){
$content=<<<HTML
  <h3 class="fake-title">Mi panel de usuario</h3>
  <!--Contentedor principal-->    
  <div id="points-container">
    <p>Tu objetivo actual: <a href="/tienda">$goalName</a></p>
    <p>Historial de Movipuntos: Tienes $userPoints Movipuntos</p>
    <h2 style="color: rgb(0, 81, 122);">¡Aún no tienes Movipuntos! Empieza a jugar <a href="/juegos">aquí</a></h2>
  </div>
HTML;
}else{
  //Obtener compras del usuario
  $purchases=getUserPurchases($conn, $row["id_user"]);

  if(!empty($purchases)){
    //Rellenar lista de productos adquiridos
    $userPurchases="<p>Tus produtos adquiridos:</p><ul>";
    foreach ($purchases as $item) {
      if($item["howMany"]>1){
        //Especificar si tiene más de uno
        $howMany=" (Tienes ".$item["howMany"].")";
      }else{
        $howMany="";
      }
      $itemId=substr($item["itemId"], 4);
      $userPurchases.="<li>".getGoalName($itemId).$howMany."</li>";
    }
    $userPurchases.="</ul>";
  }else{
    $userPurchases="";
  }

//Contenido de página principal
$content = <<<HTML
	<h1 class="fake-title">Mi panel de usuario</h1>
	<!--Contentedor principal-->    
	<div id="points-container">
    <p>Tu objetivo actual: <a href="/tienda">$goalName</a></p>
    $userPurchases
		<p>Historial de Movipuntos: Tienes $userPoints Movipuntos</p>
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }">
        </script>

	<script type="text/javascript">
      google.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Fecha', 'Puntos', 'Objetivo actual'],
          $jsdata
        ]);

        var options = {
          title: 'Historial de Movipuntos',
          curveType: 'function',
          legend: { position: 'bottom' },
          series: {
            1: { lineDashStyle: [5, 5] },
           }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
      $(window).resize(function(){
  			drawChart();
	  });
    </script>
	<div id="curve_chart" style="width: 100%; height: 500px; text-align: center;">Cargando datos...</div><br/><br/>
		<table style="width:100%">
			 <thead>
			 <td>Concepto</td><td>Fecha</td><td>Variación</td><td>Resultado</td>
			 </thead>
			 <tbody>
				$table
			</tbody>
		</table> 
	</div>
HTML;
}

//Layout de página
include("pages/layout.php");  