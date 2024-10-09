<?php
session_start();
require 'db_connect.php';


$id = (int)$_GET['id'];

$stmt = $db_connect->prepare("SELECT * FROM reviews WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Review tidak ditemukan!";
    header("Location: review.php");
    exit;
}

$review = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $usia = $_POST['usia'];
    $produk = $_POST['produk'];
    $rating = $_POST['rating'];
    $review_text = $_POST['review'];

    $update_stmt = $db_connect->prepare("UPDATE reviews SET nama = ?, email = ?, usia = ?, produk = ?, rating = ?, review = ? WHERE id = ?");
    $update_stmt->bind_param("ssiissi", $nama, $email, $usia, $produk, $rating, $review_text, $id);

    if ($update_stmt->execute()) { 
        echo "
        <script>
            alert('Data berhasil diedit!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal diedit!');
            document.location.href = 'review.php';
        </script>";
    }

    $update_stmt->close();
}

$stmt->close();
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
    <form action="update.php" method="POST">
        <center><h3 id="review">Edit Review</h3></center>
        <label for="nama">Nama:</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($review['nama']); ?>" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($review['email']); ?>" required><br>
        
        <label for="usia">Usia:</label>
        <input type="number" name="usia" value="<?php echo htmlspecialchars($review['usia']); ?>" required><br>
        
        <label for="produk">Produk:</label>
        <input type="text" name="produk" value="<?php echo htmlspecialchars($review['produk']); ?>" required><br>
        
        <label for="rating">Rating:</label>
        <input type="number" name="rating" value="<?php echo htmlspecialchars($review['rating']); ?>" required><br>
        
        <label for="review">Review:</label>
        <textarea name="review" required><?php echo htmlspecialchars($review['review']); ?></textarea><br>
        
        <button type="submit" class="buttonedit">Edit Review</button>
            
    </form>
        <button onclick="location.href='index.php'" class="back-button">Kembali</button>
</body>
</html>