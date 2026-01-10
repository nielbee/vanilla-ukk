<?php
include("./connection.php");

header('Content-Type: application/json');  


if (isset($_POST["user"]) && isset($_POST["password"])) {
    // echo generate_token($_POST["user"],$_POST["password"]);
    echo (generate_token($_POST["user"],$_POST["password"]));
}

else {
    echo json_encode(array("status"=> "error", "message"=> "user / password cant be empty"));
}



?>