<?php
//Título de página
$title = "Mis puntos - Telefónica";
//Comprobar usuario logado y obtener panel de usuario
include("store-data/check-user-login.php");

//Creación del contenido de página

//Conectar a BBDD
include("store-data/db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

//Coger historial de usuario
$sql='(SELECT s.date as date, s.id_user as id_user, s.item_id as concept, s.points_variation as points_variation, s.points_result as points_result FROM shoppingHistory s WHERE id_user = "'.$userName.'") UNION (SELECT h.date as date, h.id_user as id_user, h.game as concept, h.points_variation as points_variation, h.points_result as points_result FROM gamesHistory h WHERE id_user = "'.$userName.'") order by date DESC';

$result = $conn->query($sql);

$table="";
$jsdata="";

if ($result->num_rows > 0) {
    //Datos encontrados
    while($row = $result->fetch_assoc()) {
    	//Si el usuario es correcto, coger todos los datos e ir rellenándolos
    	if($_COOKIE["games-username"]===$row["id_user"]){
        $concept=getGoalName(substr($row["concept"],4,strlen($row["concept"])));
        if(!$concept){
          $concept=$row["concept"];
        }
        $table.="<tr><td>".$concept."</td>"."<td>".$row["date"]."</td><td>".$row["points_variation"]."</td><td>".$row["points_result"]."</td></tr>";
    		$jsdata.="[new Date('".str_replace(" ", "T", $row["date"])."'),  ".($row["points_result"] == 0 ? "0":$row["points_result"]).", ".-getPointsCost($idGoal)."],";
    	}else{
          $table.="";
          $jsdata.="";
      }
    }

} else {
	$conn->close();
  $table="--";
}
//Obtener nombre de la oferta
$goalName = getGoalName($idGoal);

/**
* Función getGoalName: Obtener nomnre de la oferta
* @returns {int} | Devuelve el nombre de la oferta
*/
function getGoalName($id){
  switch ($id) {
    case 1:
      return "Línea Movimovil: 30Mpts";
    case 2:
      return "Movinternet fijo: 30Mpts";
    case 3:
      return "MoviNubico y Movinternet: 35Mpts";
    case 4:
      return "Movimovil y Movisure: 35Mpts";
    case 5:
      return "Movifusión 1: 40Mpts";
    case 6:
      return "Movifusión 2: 40Mpts";
    default:
      return null;
  }
}

/**
* Función getPointsCost: Obtener puntos por id de item
* @returns {int} | Devuelve el coste de la oferta
*/
function getPointsCost($itemId){
  switch ($itemId) {
    case '1':
    case '2':
      return -30;
    case '3':
    case '4':
      return -35;
    case '5':
    case '6':
      return -40;
    default:
      die(json_encode(array("ok" => false, "msg" => "Oferta no encontrada")));
  }
}


if($table=="--"){
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
//Contenido de página principal
$content = <<<HTML
	<h1 class="fake-title">Mi panel de usuario</h1>
	<!--Contentedor principal-->    
	<div id="points-container">
    <p>Tu objetivo actual: <a href="/tienda">$goalName</a></p>
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
          ['Fecha', 'Puntos', 'Objetivo'],
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
	<div id="curve_chart" style="width: 100%; height: 500px">cargando datos...</div><br/><br/>
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