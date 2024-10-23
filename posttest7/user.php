<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$id_user = $_SESSION['id_user'];
$reviews_query = "SELECT * FROM reviews WHERE username = ? AND id_user = ? ORDER BY created_at DESC";
$stmt = $db_connect->prepare($reviews_query);
$stmt->bind_param("si", $username, $id_user);
$stmt->execute();
$reviews = $stmt->get_result();

if (!$reviews) {
    die("Error fetching reviews: " . mysqli_error($db_connect));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="katalog.css">
</head>
<body>
    <div class="container">
        <header>
            <nav>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="tambah.php">Tambah Review</a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section id="reviews-saya">
                <div class="review">
                <h2>Review Saya</h2><br>
                <?php if (mysqli_num_rows($reviews) > 0): ?>
                    <?php while ($review = mysqli_fetch_assoc($reviews)): ?>
                        <div class="review-item">
                            <br>
                            <p><strong>Username: </strong><?php echo htmlspecialchars($review['username']); ?></p>
                            <p><strong>Email: </strong><?php echo htmlspecialchars($review['email']); ?></p>
                            <p><strong>Usia: </strong><?php echo htmlspecialchars($review['usia']); ?></p>
                            <p><strong>Produk: </strong><?php echo htmlspecialchars($review['produk']); ?></p>
                            <p><strong>Rating: </strong><?php echo htmlspecialchars($review['rating']); ?></p>
                            <p><strong>Review: </strong><?php echo nl2br(htmlspecialchars($review['review'])); ?></p>
                            <p><strong>Tanggal: </strong><?php echo htmlspecialchars($review['created_at']); ?></p>
                            
                            <?php if (!empty($review['foto'])): ?>
                            <p><strong>Foto: </strong><br><img src="uploads/<?php echo htmlspecialchars($review['foto']); ?>" width="200px"></p>
                            <?php endif; ?>
                            
                            <button type="button" onclick="location.href='update.php?id=<?php echo htmlspecialchars($review['id']); ?>'" class="buttonedit">Edit</button>
                            <button type="button" onclick="location.href='delete.php?id=<?php echo htmlspecialchars($review['id']); ?>'" class="buttonhapus">Hapus</button>
                            <br><hr>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php else: ?>
                    <p>Anda belum memiliki review. Silakan tambah review baru.</p>
                <?php endif; ?>
            </section>
        </main>
    </div>

    <script>
    function confirmDelete(id) {
        if (confirm('Apakah Anda yakin ingin menghapus review ini?')) {
            location.href = 'delete.php?id=' + id;
        }
    }
    </script>
</body>
</html>