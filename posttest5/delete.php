<?php
require "db_connect.php";

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];

    $stmt = $db_connect->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Data berhasil dihapus!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal dihapus!');
            document.location.href = 'review.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "
    <script>
        alert('ID tidak valid!');
        document.location.href = 'review.php';
    </script>";
}
?>
