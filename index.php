<?php
$host = "localhost";  
$user = "root";       
$pass = "";           
$dbname = "toko_novel"; 

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$year = isset($_GET['year']) ? $_GET['year'] : '';


$sql = "SELECT * FROM books";
$conditions = [];

if ($category) {
    $conditions[] = "category = '$category'";
}
if ($year) {
    $conditions[] = "year = '$year'"; 
}
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Novel Online</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <header>
        <div class="header-content">
            <h1>Toko Novel Online</h1>
            <div class="center-menu">
                <ul>
                    <li><strong><a href="index.php">Home</a></strong></li>
                    <li><strong><a href="javascript:void(0);" onclick="toggleGenre()">Genre</a></strong>
                        <ul id="genre-options" class="submenu" style="display: none">
                            <li><a href="index.php?category=Romantis">Novel Romantis</a></li>
                            <li><a href="index.php?category=Horor">Novel Horor</a></li>
                            <li><a href="index.php?category=Komedi">Novel Komedi</a></li>
                        </ul>
                    </li>
                    <li><strong><a href="javascript:void(0);" onclick="toggleYear()">Tahun</a></strong>
                        <ul id="year-options" class="submenu" style="display: none">
                            <li><a href="index.php?year=2021">2021</a></li>
                            <li><a href="index.php?year=2022">2022</a></li>
                            <li><a href="index.php?year=2023">2023</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <div class="search-container">
            <input type="text" id="search-input" placeholder="Cari novel..." oninput="searchNovel()" />
            <button>Cari</button>
        </div>
    </header>

    <main>
        <section id="category-display">
            <h2>Novel Kategori: <?php echo htmlspecialchars($category ?: 'Semua'); ?></h2>
        </section>

        <section id="product-list" class="product-list">
            <h2>Daftar Buku</h2>
            <div class="product-grid">
                <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="product" data-genre="<?php echo htmlspecialchars($row['category']); ?>"
                    data-year="<?php echo htmlspecialchars($row['year']); ?>">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($row['title']); ?>" />
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>Rp<?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p>Tidak ada buku ditemukan.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Toko Novel Online</p>
    </footer>

    <script src="script.js"></script>

</body>
<section id="contact" class="contact">
        <h2 class="contact-title">Hubungi Kami</h2>
        <form id="contactForm" class="contact-form" onsubmit="sendMessage(event)">
            <label for="contactName" class="contact-label">Nama:</label>
            <input type="text" id="contactName" name="name" required class="contact-input" />
    
            <label for="contactTelpon" class="contact-label">Telpon:</label>
            <input type="text" id="contactTelpon" name="telpon" required class="contact-input" />
    
            <label for="contactEmail" class="contact-label">Email:</label>
            <input type="email" id="contactEmail" name="email" required class="contact-input" />
    
            <label for="contactMessage" class="contact-label">Pesan:</label>
            <textarea id="contactMessage" name="pesan" required class="contact-textarea"></textarea>
    
            <button type="submit" class="contact-button">Kirim</button>
        </form>
    </section>
    
</html>

<?php
$conn->close();
?>