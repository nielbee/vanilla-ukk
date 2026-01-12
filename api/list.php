<?php
header('Content-Type: application/json');  

 header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');

include("./connection.php");

define('LIMIT', 10);

$page  = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = isset($_GET['limit']) ? max(1, intval($_GET['limit'])) : LIMIT;
$offset = ($page - 1) * $limit;
$search = '%' . (isset($_GET['search']) ? $_GET['search'] : '') . '%';

$query = "SELECT * FROM music WHERE id LIKE ? LIMIT ? OFFSET ?;";
$pdo = connection();
$stmt = $pdo->prepare($query);

$stmt->bindValue(1, $search, PDO::PARAM_STR);
$stmt->bindValue(2, $limit, PDO::PARAM_INT);
$stmt->bindValue(3, $offset, PDO::PARAM_INT);

$stmt->execute();

$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($res,JSON_PRETTY_PRINT);