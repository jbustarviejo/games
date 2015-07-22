<?php

/*
  $data = array(
  "idUser" => "1",
  "time" => $_POST["time"],
  "selected" => $_POST["selected"],
  "winner" => $_POST["winner"],
  "sticksNumber" => $_POST["sticksNumber"]
  );
 */

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}

$sql = "INSERT INTO sticksGameRecords (`id_user`, `time`, `selected`, `winner`, `sticksNumber`) VALUES ('" . $_POST["userId"] . "', '" . $_POST["time"] . "', '" . $_POST["selected"] . "', '" . $_POST["winner"] . "', '" . $_POST["sticksNumber"] . "')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array("ok" => true));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();


