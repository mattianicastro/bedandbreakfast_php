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
require "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $query = "INSERT INTO soggiorni VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $_POST['prenotazione'], $_POST['cliente'], $_POST['documento']);
    $stmt->execute();
    header("Location: soggiorni.php");
    exit();
}

$query = "SELECT prenotazioni.id, prenotazioni.dataarrivo, prenotazioni.camera, prenotazioni.cliente from prenotazioni";
$res = $conn->query($query);
$prenotazioni = $res->fetch_all(MYSQLI_ASSOC);

$query = "SELECT clienti.nome, clienti.cognome, clienti.codice from clienti";
$res = $conn->query($query);
$clienti = $res->fetch_all(MYSQLI_ASSOC);

$query = "SELECT * from soggiorni
INNER join clienti on soggiorni.cliente = clienti.codice
";
$res = $conn->query($query);
$soggiorni = $res->fetch_all(MYSQLI_ASSOC);
?>



<body>
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Gestione soggiorni</h1>

    <div class="flex flex-col justify-center items-center gap-y-5">
        <form class="card w-96 bg-base-100 shadow-xl" method="post">
            <div class="card-body">
                <h2 class="card-title">Gestione soggiorni</h2>
                <p>Seleziona cliente e prenotazione e inserisci il tipo di documento presentato</p>
                <select name="cliente" class="form-select">
                    <option value="" disabled selected>Seleziona cliente</option>
                    <?php foreach($clienti as $cliente): ?>
                    <option value="<?= $cliente['codice'] ?>"><?= $cliente['nome'].' '.$cliente['cognome'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="prenotazione" class="form-select">
                    <option value="" disabled selected>Seleziona prenotazione</option>
                    <?php foreach($prenotazioni as $prenotazione): ?>
                    <option value="<?= $prenotazione['id'] ?>"><?= $prenotazione['dataarrivo'].' '.$prenotazione['camera'].' '.$prenotazione['cliente'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="documento" class="form-select">
                    <option value="" disabled selected>Seleziona documento</option>
                    <option value="1">Carta d'identità</option>
                    <option value="2">Patente</option>
                    <option value="3">Passaporto</option>
                </select>

                <div class="card-actions justify-end">
                    <button type="submit" class="btn btn-primary">Conferma</button>
                </div>
            </div>
        </form>
        <?php foreach($soggiorni as $soggiorno): ?>
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Soggiorno</h2>
                <p>Cliente: <?= $soggiorno['nome'].' '.$soggiorno['cognome'] ?></p>
                <p>Prenotazione: <?= $soggiorno['prenotazione'] ?></p>
                <p>Documento: <?= $soggiorno['documento'] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    </div>

</body>

</html>