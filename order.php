<?php

$host = "localhost";  
$user = "root";       
$pass = "";           
$dbname = "toko_novel"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$name = isset($_POST['name']) ? $_POST['name'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$book_title = isset($_POST['book_title']) ? $_POST['book_title'] : '';

$sql = "INSERT INTO orders (name, phone, adress, email, book_title) 
        VALUES ('$name', '$phone', '$address', '$email', '$book_title')";

if ($conn->query($sql) === TRUE) {
    echo "Pemesanan berhasil!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
