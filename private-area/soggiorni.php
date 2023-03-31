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

// if ($_SERVER['REQUEST_METHOD'] === 'POST'){
//     $query = "INSERT INTO soggiorni VALUES (?,?,?)";
//     $stmt = $conn->prepare($query);
//     $stmt->bind_param("iii", $_POST['prenotazione'], $_POST['cliente'], $_POST['documento']);
//     $stmt->execute();
//     header("Location: soggiorni.php");
//     exit();
// }

$query = "SELECT prenotazioni.id, prenotazioni.dataarrivo, prenotazioni.camera, clienti.nome, clienti.cognome from prenotazioni
INNER JOIN clienti ON prenotazioni.cliente=clienti.codice
";
$res = $conn->query($query);
$prenotazioni = $res->fetch_all(MYSQLI_ASSOC);
?>

<!-- $query = "SELECT clienti.nome, clienti.cognome, soggiorni.documento, prenotazioni.id from soggiorni
INNER JOIN clienti ON soggiorni.cliente=clienti.codice
INNER JOIN prenotazioni ON prenotazioni.id=soggiorni.prenotazione
";
$res = $conn->query($query);
$soggiorni = $res->fetch_all(MYSQLI_ASSOC); -->

<body>
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Gestione soggiorni</h1>

    <div class="flex flex-col justify-center items-center gap-y-5">
        <form class="card w-96 bg-base-100 shadow-xl" action="gestisci-soggiorni.php">
            <div class="card-body">
                <h2 class="card-title">Gestione soggiorni</h2>
                <select name="prenotazione" class="select">
                    <option value="" disabled selected>Seleziona prenotazione</option>
                    <?php foreach($prenotazioni as $prenotazione): ?>
                    <option value="<?= $prenotazione['id'] ?>"><?= 'Numero'.' '.$prenotazione['id'].', Camera '.$prenotazione['camera'].' '.$prenotazione['nome'].' '.$prenotazione['cognome'] ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="card-actions justify-end">
                    <button class="btn">Conferma</button>
                </div>
            </div>
        </form>

    </div>
    </div>

</body>

</html>