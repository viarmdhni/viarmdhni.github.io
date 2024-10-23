<?php
require 'db_connect.php';

define('USERNAME_EXISTS', 'Akun sudah ada');
define('REGISTRATION_SUCCESS', 'Pendaftaran berhasil');
define('REGISTRATION_FAILED', 'Gagal mendaftar');
define('PASSWORD_MISMATCH', 'Password tidak cocok');

if(isset($_POST['regis'])){
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    
    if(strlen($username) < 3 || strlen($password) < 5) {
        $error = "Username harus lebih dari 3 karakter dan password minimal 5 karakter.";
    } elseif($password !== $cpassword) {
        $error = PASSWORD_MISMATCH;
    } else {
        $stmt = $db_connect->prepare("SELECT username FROM user WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0){
            $error = USERNAME_EXISTS;
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $db_connect->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, 'user')");
            $stmt->bind_param("ss", $username, $hashed_password);
            
            if($stmt->execute()){
                $success = REGISTRATION_SUCCESS;
            } else {
                $error = REGISTRATION_FAILED;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="katalog.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="form">
        <div class="form-container">
            <h1>Sign Up</h1><br><hr>
            
            <?php if(isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <?php if(isset($success)): ?>
                <p class="success"><?php echo $success; ?></p>
                <script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                </script>
            <?php endif; ?>
            
            <form action="" method="POST">
                <input type="text" name="username" placeholder="Username" class="textfield" required>
                <input type="password" name="password" placeholder="Password" class="textfield" required>
                <input type="password" name="cpassword" placeholder="Confirm Password" class="textfield" required>
                <h5>Already have an account? <a href="login.php">Log In</a></h5>
                <br>
                <p>
                    <a href="index.php">Kembali ke beranda</a>
                    <button type="submit" name="regis" class="buttontambah">Register</button><br>
                </p>
            </form>
        </div>
    </div>
</body>
</html>