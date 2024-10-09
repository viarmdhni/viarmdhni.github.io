<?php
session_start();
require "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $usia = $_POST['usia'];
    $produk = $_POST['produk'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    if (empty($produk)) {
        $_SESSION['error'] = "Silakan pilih produk yang di-review.";
        header('Location: review.php');
        exit;
    }

    if ($usia < 13 || $usia > 100) {
        $_SESSION['error'] = "Usia harus antara 13 dan 100.";
        header('Location: review.php');
        exit;
    }

    $stmt = $db_connect->prepare("INSERT INTO reviews (nama, email, usia, produk, rating, review) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $nama, $email, $usia, $produk, $rating, $review);
    if ($stmt->execute()) {
        echo "
        <script>
            alert('Data berhasil ditambah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal ditambah!');
            document.location.href = 'review.php';
        </script>";
    }
    
    $stmt->close();
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Skincare</title>
    <link rel="stylesheet" href="katalog.css">
</head>
<body>
    <form action="tambah.php" method="POST">
        <center><h3 id="review">Review Produk Skincare</h3></center>
        
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="usia">Usia:</label>
        <input type="number" id="usia" name="usia" min="13" max="100" required>
        <label for="produk">Produk yang di-review:</label>
        <select id="produk" name="produk" required>
            <option value="">Pilih produk</option>
            <option value="Serum">Serum</option>
            <option value="Moisturizer">Moisturizer</option>
            <option value="Toner">Toner</option>
            <option value="Sunscreen">Sunscreen</option>
            <option value="Facial Wash">Facial Wash</option>
        </select>
        <label for="rating">Rating (1-5):</label>
        <input type="range" id="rating" name="rating" min="1" max="5" step="1" required>
        <label for="review">Review Anda:</label>
        <textarea id="review" name="review" rows="5" required></textarea>
        <input type="submit" value="Kirim Review">
    </form>
</body>
</html>

