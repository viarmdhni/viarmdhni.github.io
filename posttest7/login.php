<?php
session_start();
require 'db_connect.php';

if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($db_connect, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($db_connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if ($username === 'admin' && $password === 'admin123') {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'admin';
            header("Location: admin.php");
            exit;
        }
        else {
            if (password_verify($password, $user['password'])) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'user';
                
                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="katalog.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="POST" class="formlogin">
            <h2>Login</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required maxlength="255">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required maxlength="10">
            </div>

            <div class="form-group">
                <button type="submit" name="login" class="buttontambah">Login</button>
            </div>

            <p>Belum punya akun? <a href="regis.php">Daftar di sini</a></p>
            <p><a href="index.php">Kembali ke beranda</a></p>
        </form>
    </div>
</body>
</html>