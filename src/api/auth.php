<?php
// src/api/auth.php
session_start();
require_once '../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // ดึงข้อมูล User จากฐานข้อมูล
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // ตรวจสอบว่ามีชื่อผู้ใช้นี้ไหม และรหัสผ่านตรงกันไหม
        if ($user && $user['password_hash'] === $password) {
            // ถ้ารหัสถูก ให้สร้าง Session เพื่อจดจำการล็อกอิน
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            
            echo json_encode(['status' => 'success', 'message' => 'เข้าสู่ระบบสำเร็จ!']);
        } else {
            // ถ้ารหัสผิด
            echo json_encode(['status' => 'error', 'message' => 'ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>