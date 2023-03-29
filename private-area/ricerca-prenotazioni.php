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
require "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') :
    $query = "SELECT * FROM prenotazioni
    INNER JOIN camere ON prenotazioni.camera = camere.numero
    INNER JOIN clienti ON prenotazioni.cliente = clienti.codice
    WHERE ? BETWEEN dataarrivo AND datapartenza
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_POST['data']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        header("Location: ricerca-prenotazioni.php?error=no-results");
        exit();
    }else{
        $prenotazioni = $result->fetch_all(MYSQLI_ASSOC);
    }

?>

<body>
    <?php require("../components/navbar.html") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Risultati di ricerca</h1>

    <div class="flex flex-row justify-center gap-x-5">
        <?php foreach($prenotazioni as $prenotazione): ?>
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title"><?= $prenotazione["descrizione"]?></h2>
                <p>Cliente: <?= $prenotazione['nome'].' '.$prenotazione['cognome']?></p>
                <p>Indirizzo: <?= $prenotazione['indirizzo']?></p>
                <p>Telefono: <?= $prenotazione['telefono']?></p>
                <p>Data arrivo: <?= $prenotazione['dataArrivo']?></p>
                <p>Data partenza: <?= $prenotazione['dataPartenza']?></p>
                <p>Camera: <?= $prenotazione['camera']?></p>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
    </div>

</body>


<?php else: ?>
<body>
    <?php require("../components/navbar.html") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Ricerca prenotazioni</h1>

    <div class="flex flex-row justify-center items-center gap-x-5">
        <form class="card w-96 bg-base-100 shadow-xl" method="post">
            <div class="card-body">
                <h2 class="card-title">Ricerca per data</h2>
                <p>Inserisci una data per cercare la prenotazione desiderata</p>
                <input type="date" class="form-control" name="data" id="data">
                <div class="card-actions justify-end">
                    <button type="submit" class="btn btn-primary">Cerca</button>
                </div>
        </form>
    </div>
    </div>

</body>
<?php endif; ?>

</html>