<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$reviews = mysqli_query($db_connect, "SELECT * FROM reviews ORDER BY created_at DESC");
$users = mysqli_query($db_connect, "SELECT * FROM user ORDER BY username");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="katalog.css">
</head>
<body>
    <br><h1>Admin Dashboard</h1>   
    <nav>
        <ul>
            <li><a href="logout.php" class="login">Logout</a></li>
        </ul>
    </nav>

    <main>
        <div class="dashboard-stats">
            <div class="review">
                <h3>Total Reviews</h3>
                <div class="review"><?php echo mysqli_num_rows($reviews); ?></div>
            </div>
        </div>
        
        <section id="reviews" class = "review">
            <h2> Manage Reviews</n><br>
            <?php while ($review = mysqli_fetch_assoc($reviews)): ?>
                <form>
                <div>
                    <p><strong>Username: </strong><?php echo htmlspecialchars($review['username'] ?? 'Anonymous'); ?></p>
                    <p><strong>Produk: </strong><?php echo htmlspecialchars($review['produk']); ?></p>
                    <p><strong>Rating: </strong><?php echo htmlspecialchars($review['rating']); ?></p>
                    <p><strong>Review: </strong><?php echo htmlspecialchars($review['review']); ?></p>
                    <p><strong>Tanggal: </strong><?php echo htmlspecialchars($review['created_at']); ?></p>
                    <?php if (!empty($review['foto'])): ?>
                        <p><strong>Foto: </strong><br><img src="uploads/<?php echo htmlspecialchars($review['foto']); ?>" width="200px"></p>
                    <?php endif; ?>
                    <br>
                    <div class="review-actions">
                        <button type="button" onclick="location.href='delete.php?id=<?php echo htmlspecialchars($review['id']); ?>'" class="buttonhapus">Delete</button>
                    </div></form>
           </div>
                </div>
            <?php endwhile; ?>
        </section>
    </main>
        
    
</body>
</html>