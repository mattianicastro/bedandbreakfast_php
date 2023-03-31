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

$query = "SELECT * FROM prenotazioni
INNER JOIN camere ON prenotazioni.camera = camere.numero
INNER JOIN clienti ON prenotazioni.cliente = clienti.codice
";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<script>alert('Nessuna prenotazione trovata')
    location.href = 'admin.php'
    </script> 
    ";
    exit();
} else {
    $prenotazioni = $result->fetch_all(MYSQLI_ASSOC);
}

?>

<body>
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-6 font-bold text-center ">Tutte le prenotazioni</h1>

    <div class="flex flex-row justify-center gap-x-5 gap-y-2 flex-wrap">
        <?php foreach ($prenotazioni as $prenotazione) : ?>
            <div class="card w-96 bg-base-100 shadow-xl">
                <figure><img src="../assets/<?= $prenotazione["foto"] ?? "No_image_preview.png"  ?>" /></figure>
                <div class="card-body">
                    <h2 class="card-title"><?= $prenotazione["descrizione"] ?></h2>
                    <p>Cliente: <?= $prenotazione['nome'] . ' ' . $prenotazione['cognome'] ?></p>
                    <p>Indirizzo: <?= $prenotazione['indirizzo'] ?></p>
                    <p>Telefono: <?= $prenotazione['telefono'] ?></p>
                    <p>Data arrivo: <?= $prenotazione['dataArrivo'] ?></p>
                    <p>Data partenza: <?= $prenotazione['dataPartenza'] ?></p>
                    <p>Camera: <?= $prenotazione['camera'] ?></p>
                    <form class="card-actions justify-end" action="elimina.php" method="post">
                        <input type="hidden" name="id" value="<?= $prenotazione['id'] ?>">
                        <button class="btn btn-error">Elimina</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    </div>

</body>

</html>