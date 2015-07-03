<?php

$data = array(
    "time" => $_POST["time"],
    "selected" => $_POST["selected"],
    "winner" => $_POST["winner"],
    "sticksNumber" => $_POST["sticksNumber"]
);
echo json_encode($data);
?>