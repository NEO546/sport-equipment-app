<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

try {
    if ($action === 'add') {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $total = $_POST['total_quantity'];
        
        $stmt = $pdo->prepare("INSERT INTO equipment (name, category, total_quantity, available_quantity) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $category, $total, $total]);
        echo json_encode(['status' => 'success', 'message' => 'เพิ่มอุปกรณ์กีฬาสำเร็จ!']);
    } 
    elseif ($action === 'edit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $category = $_POST['category'];
        $total = $_POST['total_quantity'];
        
        $stmt = $pdo->prepare("UPDATE equipment SET name=?, category=?, total_quantity=? WHERE id=?");
        $stmt->execute([$name, $category, $total, $id]);
        echo json_encode(['status' => 'success', 'message' => 'อัปเดตข้อมูลสำเร็จ!']);
    }
    elseif ($action === 'delete') {
        $id = $_POST['id'];
        $stmt = $pdo->prepare("DELETE FROM equipment WHERE id=?");
        $stmt->execute([$id]);
        echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลอุปกรณ์สำเร็จ!']);
    }
} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>