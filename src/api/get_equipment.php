<?php
// src/api/get_equipment.php
require_once '../config/db.php'; // ดึงไฟล์เชื่อมต่อฐานข้อมูลมาใช้
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM equipment ORDER BY id DESC");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $items]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>