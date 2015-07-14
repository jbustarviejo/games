<?php

$host_name = "db483958052.db.1and1.com";
$database = "db483958052";
$user_name = "dbo483958052";
$password = "database";

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO cardsGameRecords (`time_memory`, `time_decission`, `displayed_side`, `winner_side`, `selected_side`, `cards_number`, `cards_array`) VALUES ('" . $_POST["time_memory"] . "', '" . $_POST["time_decission"] . "', '" . $_POST["displayed_side"] . "', '" . $_POST["winner_side"] . "', '" . $_POST["selected_side"] . "', '" . $_POST["cards_number"] . "', '" . $_POST["cards_array"] . "')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("ok" => true));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();


