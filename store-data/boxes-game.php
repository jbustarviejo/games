<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}
$sql = "INSERT INTO boxesGameRecords(`id_user`, `boxes_number`, `winner_box`, `first_box_choose`, `available_box_to_change`, `final_box_choose`, `time_to_first_choose`, `time_to_change_box`) VALUES ('" . $_POST["userId"] . "', '" . $_POST["boxes_number"] . "', '" . $_POST["winner_box"] . "', '" . $_POST["first_box_choose"] . "', '" . $_POST["available_box_to_change"] . "', '" . $_POST["final_box_choose"] . "', '" . $_POST["time_to_first_choose"] . "', '" . $_POST["time_to_change_box"] . "')";


if ($conn->query($sql) === TRUE) {
    echo json_encode(array("ok" => true));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();


