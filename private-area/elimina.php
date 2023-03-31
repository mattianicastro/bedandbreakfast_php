<?php
session_start();
require '../db.php';

if(!isset($_SESSION['tipo_utente'])){
    return header("Location: login.php");
}

$query = $_SESSION['tipo_utente'] === 'admin' ? "DELETE FROM prenotazioni WHERE id=?" : "DELETE FROM prenotazioni WHERE id=? AND cliente=?";
$stmt = $conn->prepare($query);
if($_SESSION['tipo_utente'] === 'admin'){
    $stmt->bind_param("i", $_POST['id']);
}else{
    $stmt->bind_param("ii", $_POST['id'], $_SESSION['id_cliente']);
}
$stmt->execute();
header("Location: area-clienti.php")
?>