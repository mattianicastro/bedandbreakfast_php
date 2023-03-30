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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "INSERT INTO soggiorni VALUES (?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $_POST['prenotazione'], $_POST['cliente'], $_POST['documento']);
    $stmt->execute();
    header("Location: soggiorni.php");
    exit();
}

$query = "SELECT clienti.nome, clienti.cognome, clienti.telefono, clienti.indirizzo,soggiorni.documento, prenotazioni.id, clienti.codice from soggiorni
INNER JOIN clienti ON soggiorni.cliente=clienti.codice
INNER JOIN prenotazioni ON prenotazioni.id=soggiorni.prenotazione
WHERE prenotazioni.id=?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_GET['prenotazione']);
$stmt->execute();
$res = $stmt->get_result();
$soggiorni = $res->fetch_all(MYSQLI_ASSOC);
?>

<!-- $query = "SELECT clienti.nome, clienti.cognome, soggiorni.documento, prenotazioni.id from soggiorni
INNER JOIN clienti ON soggiorni.cliente=clienti.codice
INNER JOIN prenotazioni ON prenotazioni.id=soggiorni.prenotazione
";
$res = $conn->query($query);
$soggiorni = $res->fetch_all(MYSQLI_ASSOC); -->

<body>
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Prenotazione <?= $_GET['prenotazione'] ?></h1>

    <form class="flex flex-col justify-center items-center gap-y-5">
        <button class="btn"\>Aggiorna</button>
        <?php foreach ($soggiorni as $soggiorno) : ?>
            <div class="card w-96 bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title">Soggiorno</h2>
                    <p>Cliente: <?= $soggiorno["nome"] . ' ' . $soggiorno['cognome'] ?></p>
                    <p>Telefono: <?= $soggiorno['telefono'] ?></p>
                    <p>Indirizzo: <?= $soggiorno['indirizzo'] ?></p>

                    <select name="<?= $soggiorno['codice'] ?>[documento]" required class="select">
                        <option disabled selected>Seleziona documento..</option>
                        <?php foreach (array('Carta identità', 'Patente', 'Passaporto') as $documento) : ?>
                            <option value="<?= $documento ?>"><?= $documento ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </form>

</body>

</html>