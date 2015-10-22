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
$sql="(SELECT u.id_user as id_user, 10 as points, 'Juego de las cañas' as game, s.date as 'date', (s.selected=s.winner) as won FROM users u LEFT JOIN `strawsGameRecords` s ON u.id_user = s.id_user WHERE u.id_user='".$_COOKIE["games-username"]."') UNION (SELECT u.id_user as id_user, 10 as points, 'Juego de las cartas' as game, c.date as 'date', (c.winner_side = c.displayed_side) as won FROM users u LEFT JOIN `cardsGameRecords` c ON u.id_user = c.id_user WHERE u.id_user='".$_COOKIE["games-username"]."') UNION (SELECT u.id_user as id_user, 10 as points, 'Juego de las cajas' as game, b.date as 'date', (b.winner_box = b.last_box_selected) as won FROM users u LEFT JOIN `boxesGameRecords` b ON u.id_user = b.id_user WHERE u.id_user='".$_COOKIE["games-username"]."') ORDER BY date ASC";

$result = $conn->query($sql);

$table="";
$jsdata="";
$accumulated_points=0;

if ($result->num_rows > 0) {
    //Datos encontrados
    while($row = $result->fetch_assoc()) {
    	//Si el usuario es correcto, coger todos los datos e ir rellenándolos
    	if($_COOKIE["games-username"]===$row["id_user"]){
    		if($row["won"]==1){
    			$won_table="Ganaste";
    		}else{
    			$won_table="Perdiste";
    		}
    		$table.="<tr><td>".$row["game"]."</td>"."<td>".$row["date"]."</td>"."<td>".$won_table."</td></tr>";
    		$accumulated_points+=$row["points"];
    		$jsdata.="[new Date('".str_replace(" ", "T", $row["date"])."'),  ".($accumulated_points == 0 ? "0":$accumulated_points).", 100],";
    	}else{
            $table.="";
            $jsdata.="";
        }
    }
} else {
	$conn->close();
    $table="--";
}

//Contenido de página principal
$content = <<<HTML
	<h1 class="fake-title">Mis Movipuntos</h1>

	<!--Contentedor principal-->    
	<div id="points-container">
		<p>Historial de Movipuntos: $points</p>
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
	<div id="curve_chart" style="width: 100%; height: 500px"></div><br/><br/>
		<table style="width:100%">
			 <thead>
			 <td>Juego</td><td>Fecha</td><td>Resultado</td>
			 </thead>
			 <tbody>
				$table
			</tbody>
		</table> 
	</div>
HTML;



//Layout de página
include("pages/layout.php");