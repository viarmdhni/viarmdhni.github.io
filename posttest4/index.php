<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $usia = $_POST['usia'];
    $produk = $_POST['produk'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    if ($usia >= 13 && $usia <= 100) {
        $_SESSION['current_review'] = [
            'nama' => $nama,
            'email' => $email,
            'usia' => $usia,
            'produk' => $produk,
            'rating' => $rating,
            'review' => $review,
        ];
        

    } elseif (empty($produk)) {
        $_SESSION['error'] = "Silakan pilih produk yang di-review.";
    } else {
        $_SESSION['error'] = "Usia harus antara 13 dan 100.";
    }
    header('Location: review.php');
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
    <header>
        <img src="skincare.jpg" alt="skincare" class="cover">
        <h1 class="skinhaven">SkinHaven</h1>
    </header>

    <nav>
        <ul>
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#review">Review</a></li>
            <li><a href="#tentangsaya">Tentang Saya</a></li>
        </ul>
    </nav>

    <main id="beranda">
        <h2>Produk</h2>
        <p><br></p>
        <div class="kotak">
            <div class="produk">
                <img src="serum.jpeg" alt="Produk serum">
                <h3>Serum</h3>
                <button onclick="showPopup('Serum')">Detail</button>
            </div>
            <div class="produk">
                <img src="moisturizer.jpg" alt="Produk moisturizer">
                <h3>Moisturizer</h3>
                <button onclick="showPopup('Moisturizer')">Detail</button>
            </div>
            <div class="produk">
                <img src="Toner.jpg" alt="Produk toner">
                <h3>Toner</h3>
                <button onclick="showPopup('Toner')">Detail</button>
            </div>
            <div class="produk">
                <img src="sunscreen.jpg" alt="Produk sunscreen">
                <h3>Sunscreen</h3>
                <button onclick="showPopup('Sunscreen')">Detail</button>
            </div>
            <div class="produk">
                <img src="facialwash.avif" alt="Produk facial wash">
                <h3>Facial Wash</h3>
                <button onclick="showPopup('Facial Wash')">Detail</button>
            </div>
        </div>


        <form action="index.php" method="POST">
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
    </main>

    <section id="tentangsaya">
        <h2>Tentang Saya</h2>
        <p>Halo! Saya pecinta skincare yang ingin membantu orang menemukan produk terbaik buat kulit mereka. Dengan pengalaman di dunia kecantikan, saya senang sekali bisa berbagi tips, pengetahuan, dan rekomendasi produk yang efektif dan aman untuk kamu coba.</p>
        <p>Nama : Octavia Ramadhani</p>
        <p>NIM : 2309106064</p>
        <p>IG : <a href="https://instagram.com/viarmdhnii" target="_blank">@viarmdhnii</a></p>
        <p>Email : <a href="mailto:via@gmail.com">via@gmail.com</a></p>
    </section>

    <?php require_once 'footer.php'; ?>

    <div class="overlay" id="overlay" onclick="closePopup()"></div>
    <div class="popup" id="popup">
        <h3 id="popupTitle"></h3>
        <p id="popupContent"></p>
        <button onclick="closePopup()">Tutup</button>
    </div>

    <script>
        function showPopup(produk) {
            let title = produk;

            switch(produk) {
                case 'Serum':
                    content = 'Serum ini mengandung vitamin C yang membantu mencerahkan kulit.';
                    break;
                case 'Moisturizer':
                    content = 'Moisturizer ini memberikan kelembapan tahan lama untuk kulit Anda.';
                    break;
                case 'Toner':
                    content = 'Toner ini membantu menyegarkan kulit dan menyeimbangkan pH.';
                    break;
                case 'Sunscreen':
                    content = 'Sunscreen ini melindungi kulit dari sinar UV berbahaya.';
                    break;
                case 'Facial Wash':
                    content = 'Facial Wash ini membersihkan kulit secara mendalam tanpa membuat kering.';
                    break;
                default:
                    content = 'Detail produk tidak tersedia.';
            }

            document.getElementById('popupTitle').innerText = title;
            document.getElementById('popupContent').innerText = content;
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }
    </script>
</body>
</html>