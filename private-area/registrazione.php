<!DOCTYPE html>
<html lang="en">
<?php require("../components/head.php");
if (isset($_SESSION['tipo_utente'])) {
    if ($_SESSION['tipo_utente'] == 'admin') {
        header("Location: admin.php");
        exit();
    }
    else if($_SESSION['tipo_utente'] == 'user'){
        header("Location: area-clienti.php");
        exit();
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require "../db.php";
    $conn->begin_transaction();

    $query = "INSERT INTO clienti (cognome, nome, indirizzo, telefono) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $_POST['cognome'], $_POST['nome'], $_POST['indirizzo'], $_POST['telefono']);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt = $conn->prepare("SELECT Codice from clienti WHERE nome=? and cognome=? and indirizzo=? and telefono=?");
    $stmt->bind_param("ssss", $_POST['nome'], $_POST['cognome'], $_POST['indirizzo'], $_POST['telefono']);
    $stmt->execute();
    $result = $stmt->get_result();
    $res = $result->fetch_assoc();
    $user_id = &$res["Codice"];
    $query = "INSERT INTO utenti (username, password, tipo_utente, id_cliente) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $user_type = "user";
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $username = $_POST['nome'].".".$_POST['cognome'].rand(0,10);
    $stmt->bind_param("sssi", $username, $password , $user_type, $user_id);
    $stmt->execute();
    $conn->commit();
    echo "<script>alert('username: $username')
    location.href = 'login.php'
    </script> 
    ";

    exit();

}

?>

<body>
    <?php require("../components/navbar.php") ?>
    <h1 class="p-5 text-3xl mb-4 font-bold text-center ">Registrati ora</h1>
    <form class="flex flex-col justify-center items-center" method="post">
            <label class="label">
                <span class="label-text">Nome</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4" placeholder="Nome" name="nome" >
            <label class="label">
                <span class="label-text">Cognome</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4" placeholder="Cognome" name="cognome">
            <label class="label">
                <span class="label-text">Indirizzo</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4" placeholder="Indirizzo" name="indirizzo">
            <label class="label">
                <span class="label-text">Telefono</span>
            </label>
            <input type="text" required class="input input-bordered w-1/2 mb-4"placeholder="Telefono" name="telefono">
            <label class="label">
                <span class="label-text">Password</span>
            </label>
            <input type="password" required class="input input-bordered w-1/2 mb-4"placeholder="Telefono" name="password">
        <button class="btn btn-primary btn-lg  mb-6">Registrati</button>
    </form>
</body>

</html>