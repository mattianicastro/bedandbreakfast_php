<!DOCTYPE html>
<html lang="en">
<?php require("../components/head.php");
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
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Benvenuto <?= $_SESSION['username'] ?></h1>
    <div class="flex flex-col justify-center items-center">
        <h1 class="p-5 text-xl mb-6 font-bold">Gestione B&B</h1>
        <div class="flex flex-col justify-center items-center">
            <div class="card w-[75vh] bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Gestione prenotazioni</h2>
                    <p>Gestisci le prenotazioni del Bed And Breakfast</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary">Vedi tutto</button>
                        <button class="btn btn-primary">Cerca per data</button>
                        <button class="btn btn-primary">Cerca per cliente</button>
                    </div>
                </div>
            </div> <a href="soggiorni.php" class="btn btn-secondary">Soggiorni</a>
        </div>

    </div>
</body>

</html>