<?php

session_start();
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
    <header>
        <h1><center>Ulasan Produk Skincare</center></h1>
    </header>

    <main>
        <div class="review" >
        <h2><center>Ulasan Terbaru</center></h2>
        <p><br></p>
        <?php if (isset($_SESSION['current_review'])): ?>
            <p>
                <p><strong>Nama: </strong><?php echo ($_SESSION['current_review']['nama']); ?></p>
                <p><strong>Email: </strong><?php echo ($_SESSION['current_review']['email']); ?></p>
                <p><strong>Usia: </strong><?php echo ($_SESSION['current_review']['usia']); ?></p>
                <p><strong>Produk: </strong><?php echo ($_SESSION['current_review']['produk']); ?></p>
                <p><strong>Rating: </strong><?php echo ($_SESSION['current_review']['rating']); ?></p>
                <p><strong>Review: </strong><?php echo (($_SESSION['current_review']['review'])); ?></p>
            </p>
        <?php else: ?>
            <p>Tidak ada ulasan untuk ditampilkan.</p>
        <?php endif; ?>

        <button class="back-button" onclick="location.href='index.php'">Kembali</button>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>