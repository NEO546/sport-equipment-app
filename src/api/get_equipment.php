<?php
require_once '../config/db.php';
header('Content-Type: application/json');

try {
    // ดึงข้อมูลอุปกรณ์ทั้งหมด เรียงจากล่าสุดไปเก่าสุด
    $stmt = $pdo->query("SELECT * FROM equipment ORDER BY id DESC");
    $equipment = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['status' => 'success', 'data' => $equipment]);
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>