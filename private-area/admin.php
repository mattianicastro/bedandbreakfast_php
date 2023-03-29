<!DOCTYPE html>
<html lang="en">
<?php require("../components/head.html");
session_start();
if (!isset($_SESSION['tipo_utente'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo_utente'] == 'user') {
    header("Location: area-clienti.php");
    exit();
}
?>

<body>
    <?php require("../components/navbar.html") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Benvenuto <?= $_SESSION['username'] ?></h1>
    <div class="flex flex-col justify-center items-center">
        <h1 class="p-5 text-xl mb-6 font-bold">Gestione B&B</h1>
        <div class="flex flex-col justify-center items-center">
            <a href="ricerca-prenotazioni.php" class="btn btn-primary">Prenotazioni</a>
            <a href="soggiorni.php" class="btn btn-secondary">Soggiorni</a>
        </div>
    </div>
</body>

</html>