<?php
session_start();
require '../db.php';

if(!isset($_SESSION['tipo_utente'])){
    return header("Location: login.php");
}

$query = "DELETE FROM prenotazioni WHERE id=? AND cliente=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $_POST['id'], $_SESSION['id_cliente']);
$stmt->execute();
header("Location: area-clienti.php")
?>