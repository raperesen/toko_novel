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
                    <li><strong><a href="index.php">home</a></strong></li>
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
                    data-year="<?php echo htmlspecialchars($row['year']); ?>" onclick="openOrderForm('<?php echo htmlspecialchars($row['title']); ?>')">
                    <img src="<?php echo htmlspecialchars($row['image_url']); ?>"
                        alt="<?php echo htmlspecialchars($row['title']); ?>" />
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>Rp<?php echo number_format($row['price'], 0, ',', '.'); ?></p>
                    <button class="order-button">Pesan</button>
                </div>
                <?php endwhile; ?>
                <?php else: ?>
                <p>Tidak ada buku ditemukan.</p>
                <?php endif; ?>
            </div>

            
            <div id="order-form" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); z-index: 1000; width: 400px;">
                <h3>Form Pemesanan</h3>
                <form id="order-form-table" method="POST" action="order.php">
                    <table>
                        <tr>
                            <td><label for="name">Nama:</label></td>
                            <td><input type="text" id="name" name="name" required /></td>
                        </tr>
                        <tr>
                            <td><label for="phone">No HP:</label></td>
                            <td><input type="text" id="phone" name="phone" required /></td>
                        </tr>
                        <tr>
                            <td><label for="address">Alamat:</label></td>
                            <td><input type="text" id="address" name="address" required /></td>
                        </tr>
                        <tr>
                            <td><label for="email">Email:</label></td>
                            <td><input type="email" id="email" name="email" required /></td>
                        </tr>
                        <tr>
                            <td><label for="book-title">Judul Buku:</label></td>
                            <td><input type="text" id="book-title" name="book_title" required readonly /></td>
                        </tr>
                    </table>
                    <button type="submit">Kirim Pemesanan</button>
                </form>
                <button id="close-order-form">Tutup</button>
            </div>

        </section>
    </main>

    <footer>
        <p>&copy; 2025 Toko Novel Online</p>
    </footer>

    <script src="script.js"></script>

</body>
</html>

<?php
$conn->close();
?>
