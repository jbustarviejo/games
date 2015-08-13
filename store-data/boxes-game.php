<?php

include("db_connection.php");

$conn = mysqli_connect($host_name, $user_name, $password, $database);
if (mysqli_connect_errno()) {
    echo "Error al conectar con servidor MySQL: " . mysqli_connect_error();
}


$sql = "INSERT INTO boxesGameRecords(`id_user`, `date`, `boxes_number`, `winner_box`, `first_box_choose`, `first_available_boxes_to_change`, `first_time_choosing`, `second_box_choose`, `second_available_boxes_to_change`, `second_time_choosing`, `third_box_choose`, `third_available_boxes_to_change`, `third_time_choosing`, `fourth_box_choose`, `fourth_available_boxes_to_change`, `fourth_time_choosing`) VALUES ('" . $_POST["id_user"] . "', '" . date('Y-m-d H:i:s') . "', '" . $_POST["boxes_number"] . "', '" . $_POST["winner_box"] . "', '" . $_POST["first_box_choose"] . "', '" . $_POST["first_available_boxes_to_change"] . "', '" . $_POST["first_time_choosing"] . "', '" . $_POST["second_box_choose"] . "', '" . $_POST["second_available_boxes_to_change"] . "', '" . $_POST["second_time_choosing"]. "', " . $_POST["third_box_choose"] . ", " . $_POST["third_available_boxes_to_change"] . ", " . $_POST["third_time_choosing"]. ", " . $_POST["fourth_box_choose"] . ", " . $_POST["fourth_available_boxes_to_change"] . ", " . $_POST["fourth_time_choosing"] . ")";


if ($conn->query($sql) === TRUE) {
    echo json_encode(array("ok" => true));
} else {
    echo json_encode(array("ok" => false, "msg" => "Error: " . $sql . "<br>" . $conn->error . ". The executed query was" . $sql));
}

$conn->close();


