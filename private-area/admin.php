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
    <div class="flex flex-col justify-center items-center gap-y-5">
        <h1 class="p-5 text-xl mb-6 font-bold">Gestione B&B</h1>
            <div class="card w-[75vh] bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Gestione prenotazioni</h2>
                    <p>Gestisci le prenotazioni del Bed And Breakfast</p>
                    <div class="card-actions justify-end">
                        <a class="btn btn-primary" href="prenotazioni.php">Vedi tutto</a>
                        <a class="btn btn-primary" href="ricerca-prenotazioni-data.php">Cerca per data</a>
                        <a class="btn btn-primary" href="ricerca-prenotazioni-cliente.php">Cerca per cliente</a>
                    </div>
                </div>
            </div>
            <div class="card w-[75vh] bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Gestione soggiorni</h2>
                    <p>Operazioni di check-in</p>
                    <div class="card-actions justify-end">
                        <a class="btn btn-primary" href="soggiorni.php">Accedi</a>
                    </div>
                </div>
            </div>

    </div>
</body>

</html>