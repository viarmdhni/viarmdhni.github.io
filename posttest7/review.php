<?php
require 'db_connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

if (is_admin()) {
    $base_query = "SELECT * FROM reviews";
} else {
    $base_query = "SELECT * FROM reviews WHERE id_user = ?";
}

if (isset($_GET['query'])) {
    if (is_admin()) {
        $stmt = $db_connect->prepare($base_query . " WHERE produk LIKE ? ORDER BY created_at DESC");
        $search_query = "%{$_GET['query']}%";
        $stmt->bind_param("s", $search_query);
    } else {
        $stmt = $db_connect->prepare($base_query . " AND produk LIKE ? ORDER BY created_at DESC");
        $search_query = "%{$_GET['query']}%";
        $stmt->bind_param("is", $_SESSION['id_user'], $search_query);
    }
} else {
    if (is_admin()) {
        $stmt = $db_connect->prepare($base_query . " ORDER BY created_at DESC");
    } else {
        $stmt = $db_connect->prepare($base_query . " ORDER BY created_at DESC");
        $stmt->bind_param("i", $_SESSION['id_user']);
    }
}

$stmt->execute();
$reviews = $stmt->get_result();
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
            
            <h2><center>Review Produk</center></h2><br>
            
            <form method="GET" action="review.php">
                <input type="text" name="query" placeholder="Cari berdasarkan produk..." value="<?php echo htmlspecialchars($_GET['query'] ?? ''); ?>">
                <button type="submit">Cari</button>
            </form>

            <?php if (isset($_SESSION['message'])): ?>
                <p class="message"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
                <?php endif; ?>
                
            <?php foreach ($reviews as $review): ?>
                <br>
                <p><strong>Email: </strong><?php echo htmlspecialchars($review['email']); ?></p>
                <p><strong>Usia: </strong><?php echo htmlspecialchars($review['usia']); ?></p>
                <p><strong>Produk: </strong><?php echo htmlspecialchars($review['produk']); ?></p>
                <p><strong>Rating: </strong><?php echo htmlspecialchars($review['rating']); ?></p>
                <p><strong>Review: </strong><?php echo htmlspecialchars($review['review']); ?></p>
                <p><strong>Tanggal: </strong><?php echo htmlspecialchars($review['created_at']); ?></p>
                
                <?php if (!empty($review['foto'])): ?>
                    <p><strong>Foto: </strong><br><img src="uploads/<?php echo htmlspecialchars($review['foto']); ?>" width="200px"></p>
                <?php endif; ?>
                <br><hr>
            <?php endforeach; ?>
            
            <button type="button" onclick="location.href='tambah.php?id=<?php echo htmlspecialchars($review['id']); ?>'" class="buttontambah">+ Tambah</button>
        </div>
    </main>
    <?php require_once 'footer.php'; ?>
</body>
</html>
