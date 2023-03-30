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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if($_POST['dataarrivo']>$_POST['datapartenza']){
        echo "<script>alert('Data invalida')
        location.href = 'login.php'
        </script> 
        ";
        exit();        
    }

    $conn->begin_transaction();

    $stmt = $conn->prepare("SELECT * FROM prenotazioni
    WHERE (? BETWEEN dataarrivo and datapartenza
    OR ? BETWEEN dataarrivo and datapartenza)
    AND camera=?");
    $stmt->bind_param("ssi",$_POST['dataarrivo'], $_POST['datapartenza'], $_POST['camera']);
    $stmt->execute();
    $res = $stmt->get_result();

    echo var_dump($res);
    $occupato = $res->num_rows===0 ? false : true;
    echo $occupato;

    if($occupato){
        echo "<script>alert('Camera occupata durante il periodo selezionato')
        location.href = 'login.php'
        </script> 
        ";
        exit();
    }

    $query = "INSERT INTO prenotazioni (cliente, camera, dataarrivo, datapartenza) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $_SESSION['id_cliente'], $_POST['camera'], $_POST['dataarrivo'], $_POST['datapartenza']);
    $stmt->execute();
    
    $query = "SELECT id from prenotazioni WHERE cliente=? AND camera=? AND dataarrivo=? AND datapartenza=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $_SESSION['id_cliente'], $_POST['camera'], $_POST['dataarrivo'], $_POST['datapartenza']);
    $stmt->execute();
    $res = $stmt->get_result();
    $res2 = $res->fetch_assoc();
    $codice_prenotazione = $res2["id"];

    if(isset($_POST['utenti'])){
        for($i = 1; $i < count($_POST['utenti']); $i++){
            $query = "INSERT INTO clienti (nome, cognome, indirizzo, telefono) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $_POST['utenti'][$i]['nome'], $_POST['utenti'][$i]['cognome'], $_POST['utenti'][$i]['indirizzo'], $_POST['utenti'][$i]['telefono']);
            $stmt->execute();

            $query = "INSERT INTO soggiorni (Prenotazione, Cliente) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii",$codice_prenotazione, $_SESSION['id_cliente']);
            $stmt->execute();
        }
    }

    $conn->commit();
    header("Location: area-clienti.php");
    exit();

}


$query = "SELECT * FROM clienti WHERE codice=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['id_cliente']);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

$query = "SELECT * FROM camere";
$res = $conn->query($query);
$camere = $res->fetch_all(MYSQLI_ASSOC);
?>

<body>
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-4 font-bold text-center ">Nuova prenotazione</h1>
    <form class="flex flex-col justify-center items-center" method="post">
        <h1 class="p-5 text-xl mb-6 font-bold">Scegli una camera</h1>

        <div class="form-control w-full max-w-xs">
            <select required name="camera" class="select select-bordered">
                <option disabled selected>Camera...</option>
                <?php foreach ($camere as $camera) : 
                $posti_insufficienti = $_GET["adulti"]>$camera["posti"] ? 'disabled' : ''
                ?>
                    <?php if($posti_insufficienti) : ?>
                        <option disabled>⚠️ Posti insufficienti ⚠️</option>
                    <?php endif ?>
                    <option <?= $posti_insufficienti ? 'disabled' : '' ?> value="<?= $camera['numero'] ?>"><?= $camera['descrizione'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <h1 class="p-5 text-xl mb-6 font-bold">Durata soggiorno</h1>
        <label class="label">
            <span class="label-text">Data inizio</span>
        </label>
        <input type="date" required class="input input-bordered w-1/2 mb-4" name="dataarrivo">
        <label class="label">
            <span class="label-text">Data fine</span>
        </label>
        <input type="date" required class="input input-bordered w-1/2 mb-4" name="datapartenza">
        
        <h1 class="p-5 text-xl mb-6 font-bold">Anagrafica</h1>
        <?php for ($i = 0; $i < $_GET['adulti']; $i++) : ?>
            <h2 class="text-xl mb-6">Utente <?php echo $i + 1 ?></h2>
            <label class="label">
                <span class="label-text">Nome</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4" <?= $i === 0 ? 'disabled' : '' ?> placeholder="Nome" name="utenti[<?=$i?>][nome]" value="<?= $i === 0 ? $cliente['nome'] : '' ?>">
            <label class="label">
                <span class="label-text">Cognome</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4" <?= $i === 0 ? 'disabled' : '' ?> placeholder="Cognome" name="utenti[<?=$i?>][cognome]" value="<?= $i === 0 ? $cliente['cognome'] : '' ?>">
            <label class="label">
                <span class="label-text">Indirizzo</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4" <?= $i === 0 ? 'disabled' : '' ?> placeholder="Indirizzo" name="utenti[<?=$i?>][indirizzo]" value="<?= $i === 0 ? $cliente['indirizzo'] : '' ?>">
            <label class="label">
                <span class="label-text">Telefono</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4" <?= $i === 0 ? 'disabled' : '' ?> placeholder="Telefono" name="utenti[<?=$i?>][telefono]" value="<?= $i === 0 ? $cliente['telefono'] : '' ?>">
        <?php endfor; ?>
        <button class="btn background-primary btn-lg  mb-6">Prenota</button>
    </form>
</body>

</html>