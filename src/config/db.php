<?php
// src/config/db.php
$host = 'db'; // ชี้ไปที่ชื่อ service ของ database ใน docker-compose.yml
$dbname = 'sport_db';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // ตั้งค่าให้ PDO โยน Exception ออกมาเมื่อเกิด Error (ช่วยเรื่องความปลอดภัยและการ Debug)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>