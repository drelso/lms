<?php
// Checa si la sesión ya existe
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

require_once('config/config.php');
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aprendizaje adaptativo</title>
</head>

<body>