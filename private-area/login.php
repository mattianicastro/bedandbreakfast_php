<!DOCTYPE html>
<html lang="en">
<?php require("../components/head.php");
require "../db.php";
// check if the user is already logged in
if (isset($_SESSION['tipo_utente'])) {
    if ($_SESSION['tipo_utente'] == 'admin') {
        header("Location: admin.php");
        exit();
    }else if ($_SESSION['tipo_utente'] == 'user') {
        header("Location: area-clienti.php");
        exit();
    }
}
// handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!(isset($_POST['username']) && isset($_POST['password']))){
        header("Location: login.php");
        exit();
    }
    $query = "SELECT utenti.password, utenti.tipo_utente, utenti.id_cliente FROM utenti WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        echo "<script>alert('Username o password errati')
        location.href = 'login.php'
        </script> 
        ";
        exit();
    }
    $row = $result->fetch_assoc();
    if (password_verify($_POST['password'], $row['password'])) {
        $_SESSION['tipo_utente'] = $row['tipo_utente'];
        $_SESSION['id_cliente'] = $row['id_cliente'];
        $_SESSION['username'] = $_POST['username'];
        if ($_SESSION['tipo_utente'] == 'admin') {
            header("Location: admin.php");
            exit();
        }else if ($_SESSION['tipo_utente'] == 'user') {
            header("Location: area-clienti.php");
            exit();
        }
    } else {
        echo "<script>alert('Username o password errati')
        location.href = 'login.php'
        </script> 
        ";
        exit();       
    }


    exit();
}
?>
<body>
    <?php require("../components/navbar.php") ?>
    <div class="flex h-screen w-screen bg-primary justify-center items-center">
    <form class="card shadow-2xl bg-base-100" method="POST">
      <div class="card-body">
        <div class="form-control">
          <label class="label">
            <span class="label-text">Username</span>
          </label>
          <input type="text" name="username" placeholder="username" class="input input-bordered" />
        </div>
        <div class="form-control">
          <label class="label">
            <span class="label-text">Password</span>
          </label>
          <input type="password" name="password" placeholder="password" class="input input-bordered" />

        </div>
        <div class="form-control mt-6">
          <button class="btn btn-primary">Login</button>
        </div>
      </div>
</form>
</body>
</html>