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

    if (!empty($_FILES['foto']['name'])) {
        $timestamp = date("Y-m-d H.i.s");
        $ekstensi = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $nama_file = $timestamp . '.' . $ekstensi;
        $target_file = 'uploads/' . $nama_file;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            if (!empty($review['foto']) && file_exists('uploads/' . $review['foto'])) {
                unlink('uploads/' . $review['foto']);
            }
        } else {
            $_SESSION['error'] = "Gagal meng-upload foto.";
            header("Location: update.php?id=" . $id);
            exit;
        }
    } else {
        $nama_file = $review['foto'];
    }

    $update_stmt = $db_connect->prepare("UPDATE reviews SET nama = ?, email = ?, usia = ?, produk = ?, rating = ?, review = ?, foto = ? WHERE id = ?");
    $update_stmt->bind_param("ssiisssi", $nama, $email, $usia, $produk, $rating, $review_text, $nama_file, $id);

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
    <form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <center><h3 id="review">Edit Review</h3></center>
        
        <label for="nama">Nama:</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($review['nama']); ?>" required><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($review['email']); ?>" required><br>
        
        <label for="usia">Usia:</label>
        <input type="number" name="usia" value="<?php echo htmlspecialchars($review['usia']); ?>" required><br>
        
        <label for="produk">Produk:</label>
        <select name="produk" required>
            <option value="Serum" <?php if($review['produk'] == 'Serum') echo 'selected'; ?>>Serum</option>
            <option value="Moisturizer" <?php if($review['produk'] == 'Moisturizer') echo 'selected'; ?>>Moisturizer</option>
            <option value="Toner" <?php if($review['produk'] == 'Toner') echo 'selected'; ?>>Toner</option>
            <option value="Sunscreen" <?php if($review['produk'] == 'Sunscreen') echo 'selected'; ?>>Sunscreen</option>
            <option value="Facial Wash" <?php if($review['produk'] == 'Facial Wash') echo 'selected'; ?>>Facial Wash</option>
        </select><br>
        
        <label for="rating">Rating (1-5):</label>
        <input type="range" id="rating" name="rating" min="1" max="5" step="1" value="<?php echo htmlspecialchars($review['rating']); ?>" required>

        
        <label for="review">Review:</label>
        <textarea name="review" required><?php echo htmlspecialchars($review['review']); ?></textarea><br>

        <?php if (!empty($review['foto'])): ?>
            <p>Foto saat ini: <br><img src="uploads/<?php echo htmlspecialchars($review['foto']); ?>" width="200px"></p>
        <?php endif; ?>

        <label for="foto">Ganti Foto (opsional):</label>
        <input type="file" name="foto"><br>

        <button type="submit" class="buttonedit">Edit Review</button>
        <button type="button" onclick="location.href='index.php'" class="back-button">Kembali</button>
    </form>
</body>
</html>
