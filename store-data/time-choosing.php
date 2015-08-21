<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO timeToChooseGame (`id_user`, `date`, `time`, `game`) VALUES ('" . $_POST["userId"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["time"] . "', '" . $_POST["game"] . "')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("ok" => true));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();
