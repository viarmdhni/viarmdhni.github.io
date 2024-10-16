<?php
require 'db_connect.php';

$reviews = mysqli_query($db_connect, "SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Produk Skincare</title>
    <link rel="stylesheet" href="katalog.css">
</head>
<body>
    <main>
        <div class="review">
            <h2><center>Review Produk</center></h2>
            <button type="button" onclick="location.href='tambah.php'" class="buttontambah">+ Tambah</button>
        
            <?php if (isset($_SESSION['message'])): ?>
                <p class="message"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
            <?php endif; ?>

            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <p><strong>Nama: </strong><?php echo htmlspecialchars($review['nama']); ?></p>
                    <p><strong>Email: </strong><?php echo htmlspecialchars($review['email']); ?></p>
                    <p><strong>Usia: </strong><?php echo htmlspecialchars($review['usia']); ?></p>
                    <p><strong>Produk: </strong><?php echo htmlspecialchars($review['produk']); ?></p>
                    <p><strong>Rating: </strong><?php echo htmlspecialchars($review['rating']); ?></p>
                    <p><strong>Review: </strong><?php echo htmlspecialchars($review['review']); ?></p>
                    <p><strong>Tanggal: </strong><?php echo htmlspecialchars($review['created_at']); ?></p>
                    
                    <?php if (!empty($review['foto'])): ?>
                        <p><strong>Foto: </strong><br><img src="uploads/<?php echo htmlspecialchars($review['foto']); ?>" width="200px"></p>
                    <?php endif; ?>
                    
                    <button type="button" onclick="location.href='update.php?id=<?php echo htmlspecialchars($review['id']); ?>'" class="buttonedit">Edit</button>
                    <button type="button" onclick="location.href='delete.php?id=<?php echo htmlspecialchars($review['id']); ?>'" class="buttonhapus">Hapus</button>
                </div>
            <?php endforeach; ?>
            
        </div>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>
