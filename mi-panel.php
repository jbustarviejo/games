<?php
/******************************************
/* Página de panel de usuario
******************************************/

//Título de página
$title = "Mis puntos - Telefónica";
//Comprobar usuario logado y obtener panel de usuario
include("store-data/check-user-login.php");

//Creación del contenido de página

//Conectar a BBDD
include("store-data/db_connection.php");

//Coger historial de usuario
$data=getUserPointsHistory($conn, $userName, $idGoal);

$table=$data["table"];
$jsdata=$data["jsdata"];

//Obtener nombre de la oferta
$goalName = getGoalName($idGoal);

//Encuesta de usuario
$surveyHTML=<<<HTML
<div id="games-survey">
    <h2>Encuesta: Indica con qué juego te identificas más</h2>
    <form>
        <input type="radio" name="survey" selected="selected" value="Poker" />Poker<br/>
        <input type="radio" name="survey" value="Ajedrez" />Ajedrez<br/>
        <input type="radio" name="survey" value="Parchis" />Parchís<br/><br/>
    </form><textarea id="survey-textarea" placeholder="Escribe ¿Cuáles son tus dos juegos favoritos?"></textarea>
</div>
<script>
  //Una vez se haya cargado la página, señalar en la encuesta si hay algo prefijado
  $(document).ready(function () {
    $("#games-survey [type=radio][value='$surveyAnswer']").prop('checked', 'checked');
    //En caso de elegir una nueva respuesta, registrarla
    $("#games-survey [type=radio]").click(function(){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/survey-answer",
            data: {
                userId: login.userId,
                answer: $("#games-survey [type=radio]:checked").val(),
                text_answer: $("#games-survey #survey-textarea").val()
            }
        });
    });
    //Rellenar texto de encuesta
    $("#games-survey #survey-textarea").text($surveyText);
    //En caso de que cambie el texto, se actualiza
    $("#games-survey #survey-textarea").change(function(){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "/store-data/survey-answer",
            data: {
                userId: login.userId,
                answer: $("#games-survey [type=radio]:checked").val(),
                text_answer: $("#games-survey #survey-textarea").val()
            }
        });
    });
  });
</script>
HTML;


if($table==""){
$content=<<<HTML
  <h3 class="fake-title">Mi panel de usuario</h3>
  <!--Contentedor principal-->    
  <div id="points-container">
    <p>Tu objetivo actual: <a href="/tienda">$goalName</a></p>
    <p>Historial de Movipuntos: Tienes $userPoints Movipuntos</p>
    <h2 style="color: rgb(0, 81, 122);">¡Aún no has ganado Movipuntos! Empieza a jugar <a href="/juegos">aquí</a></h2>
    $surveyHTML
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
      if($item["canReturn"]==true){
        //Si puede devolver el artículo
        $canReturn=" - <a href='/tienda'> Artículo con posibilidad de devolución en tienda</a>";
      }else{
        $canReturn="";
      }
      $itemId=substr($item["itemId"], 4);
      $userPurchases.="<li>".getGoalName($itemId).$howMany.$canReturn."</li>";
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
		<p>Historial de Movipuntos: Tienes $userPoints Movipuntos$gifts</p>
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
          ['Fecha', 'Puntos','Objetivo actual'],
          $jsdata
        ]);

        var options = {
          title: 'Variaciones de Movipuntos por días',
          legend: { position: 'bottom' },
          series: {
            0: { pointSize: 5},
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
    $surveyHTML
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