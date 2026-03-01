<?php
// src/config/db.php
$host = 'db'; 
$dbname = 'sports_borrow_db'; // 📌 เปลี่ยนชื่อฐานข้อมูลให้ตรงกับ Docker
$username = 'root';
$password = 'rootpassword'; // 📌 เปลี่ยนรหัสผ่าน Root ให้ตรงกับ Docker

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>