<?php

include("./connection.php");

$id = $_POST["id"];

$query = "delete from music where id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $id);

$stmt->execute();
