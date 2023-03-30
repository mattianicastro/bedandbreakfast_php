<!DOCTYPE html>
<html lang="en">
<?php require("../components/head.php");
if (!isset($_SESSION['tipo_utente'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['tipo_utente'] == 'admin') {
    header("Location: admin.php");
    exit();
}
require "../db.php";
$query = "SELECT * FROM clienti WHERE codice=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['id_cliente']);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

$query = "SELECT * FROM prenotazioni
INNER JOIN camere ON prenotazioni.camera = camere.numero
WHERE cliente=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['id_cliente']);
$stmt->execute();
$result = $stmt->get_result();
$prenotazioni = $result->fetch_all(MYSQLI_ASSOC);
?>

<body>
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Le tue prenotazioni</h1>
    <div class="flex flex-row justify-center items-center gap-x-5">
        <?php if ($result->num_rows === 0) : ?>
            <div class="hero min-h-screen bg-base-200">
                <div class="hero-content text-center">
                    <form class="max-w-md" action="prenota.php">
                        <h1 class="text-5xl font-bold">Benvenuto <?= $cliente['nome'] ?></h1>
                        <p class="py-6">Non hai effettuato nessuna prenotazione. Inserisci il numero di adulti per prenotare una camera </p>
                        <input type="number" name="adulti" class="input input-sm"  value="1" placeholder="Adulti">
                        <button type="submit" class="btn background-primary">Prenota ora</button>
                    </form>
                </div>
            </div>
        <?php else : ?>
            <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Prenota la tua prossima visita, inserisci il numero di adulti per continuare</h2>
                        <form class="card-actions justify-end" action="prenota.php">
                        <input type="number" name="adulti" class="input input-sm"  value="1" placeholder="Adulti">
                        <button class="btn">Prenota ora</button>
                        </form>
                    </div>
                </div>
            <?php foreach ($prenotazioni as $prenotazione) : ?>
                <div class="card w-96 bg-base-100 shadow-xl">
                    <figure><img src="../assets/interior-bedroom.jpg" alt="bedroom" /></figure>
                    <div class="card-body">
                        <h2 class="card-title"><?= $prenotazione['descrizione'] ?></h2>
                        <p>Camera numero <?= $prenotazione['camera'] ?></p>
                        <p>Numero di posti <?= $prenotazione['posti'] ?></p>
                        <p>Data di arrivo <?= $prenotazione['dataArrivo'] ?></p>
                        <p>Data di partenza <?= $prenotazione['dataPartenza'] ?></p>
                        <form class="card-actions justify-end" method="post" action="elimina.php">
                            <input type="hidden" name="id" value="<?= $prenotazione['id'] ?>">
                            <input class="btn bg-warning" value="Annulla" ></input>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</body>

</html>