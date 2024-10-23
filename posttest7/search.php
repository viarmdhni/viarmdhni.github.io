<?php
session_start();
require 'db_connect.php';


$query = $_GET['query'] ?? '';

$search_query = "SELECT * FROM reviews WHERE produk LIKE ?";
$stmt = $db_connect->prepare($search_query);
$like_query = "%" . $query . "%";
$stmt->bind_param("s", $like_query);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Review</title>
    <link rel="stylesheet" href="katalog.css">
</head>
<body>
    <h1>Hasil Pencarian untuk "<?php echo htmlspecialchars($query); ?>"</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review-item">
                <p><strong>Produk: </strong><?php echo $row['produk']; ?></p>
                <p><strong>Review: </strong><?php echo $row['review']; ?></p>
                <p><strong>Rating: </strong><?php echo $row['rating']; ?></p>
                <?php if (!empty($row['foto'])): ?>
                    <p><strong>Foto: </strong><br>
                    <img src="uploads/<?php echo htmlspecialchars($row['foto']); ?>" width="200"></p>
                <?php endif; ?>
                <hr>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada hasil ditemukan untuk "<?php echo htmlspecialchars($query); ?>".</p>
    <?php endif; ?>

    <button type="button" onclick="location.href='index.php'">Kembali</button>
</body>
</html>

<?php
$stmt->close();
$db_connect->close();
?>
