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
    $id_prenotazione = $_POST['prenotazione'];
    foreach ($_POST['documento'] as $key => $value) {
        $query = "UPDATE soggiorni SET documento=? WHERE cliente=? AND prenotazione=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sii", $value, $key, $id_prenotazione);
        $stmt->execute();
    }
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

    <form class="flex flex-col justify-center items-center gap-y-5" method="post">
        <input type="hidden" name="prenotazione" value="<?= $_GET['prenotazione'] ?>">
        <button class="btn" \>Aggiorna</button>
        <?php foreach ($soggiorni as $soggiorno) : ?>
            <div class="group <?= $soggiorno['documento'] ? 'is-ok' : '' ?>">
                <div class="card w-96  bg-red-100 group-[.is-ok]:bg-green-100 shadow-xl" style>
                    <div class="card-body">
                        <p><?= $soggiorno['documento'] ? "Check in già effettuato ✔️" : "Documento mancante ⚠️" ?></p>
                        <h2 class="card-title">Soggiorno</h2>
                        <p>Cliente: <?= $soggiorno["nome"] . ' ' . $soggiorno['cognome'] ?></p>
                        <p>Telefono: <?= $soggiorno['telefono'] ?></p>
                        <p>Indirizzo: <?= $soggiorno['indirizzo'] ?></p>

                        <select name="documento[<?= $soggiorno['codice'] ?>]" value=<?= $soggiorno['documento'] ?> class="select">
                            <?php if (!$soggiorno['documento']) : ?>
                                <option selected value="">Seleziona un documento...</option>
                            <?php endif; ?>
                            <?php foreach (array('CI', 'Patente', 'Passaporto') as $documento) : ?>
                                <option <?= $documento === $soggiorno['documento'] ? 'selected' : '' ?> value="<?= $documento ?>"><?= $documento ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
        </div>
    </form>

</body>

</html>