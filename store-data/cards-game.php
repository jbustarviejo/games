<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO cardsGameRecords (`id_user`, `date`, `time_memory`, `time_decission`, `displayed_side`, `winner_side`, `selected_side`, `cards_number`, `cards_array`, `cards_clicks`) VALUES ('" . $_POST["userId"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["time_memory"] . "', '" . $_POST["time_decission"] . "', '" . $_POST["displayed_side"] . "', '" . $_POST["winner_side"] . "', '" . $_POST["selected_side"] . "', '" . $_POST["cards_number"] . "', '" . $_POST["cards_array"] . "', '" . $_POST["cards_clicks"] . "')";

if ($conn->query($sql) === TRUE) {
	if($_POST["winner_side"]== $_POST["selected_side"] ){
		$userPoints = "10";
	}else{
		$userPoints = "-5";
	}
	$newSql="UPDATE users SET points = points + ".$userPoints." WHERE id_user = '".$_POST["userId"]."'";
	$conn->query($newSql);
	if ($conn->query($sql) !== TRUE) {
		echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
	}
    echo json_encode(array("ok" => true, "points" => $userPoints));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();


