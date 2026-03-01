<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ - ระบบยืม-คืนอุปกรณ์กีฬา</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
</head>
<body class="bg-gray-900 flex items-center justify-center h-screen">

    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md border border-gray-700">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">⚽ Sport Sync</h1>
            <p class="text-gray-400">ระบบจัดการยืม-คืนอุปกรณ์กีฬา</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div>
                <label class="block text-gray-300 mb-2" for="username">ชื่อผู้ใช้งาน (Username)</label>
                <input type="text" id="username" name="username" class="w-full p-3 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-blue-500" required>
            </div>
            
            <div>
                <label class="block text-gray-300 mb-2" for="password">รหัสผ่าน (Password)</label>
                <input type="password" id="password" name="password" class="w-full p-3 rounded bg-gray-700 text-white border border-gray-600 focus:outline-none focus:border-blue-500" required>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition duration-200">
                เข้าสู่ระบบ
            </button>
        </form>
    </div>

   <script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault(); // ป้องกันเว็บรีเฟรช
            
            let username = $('#username').val();
            let password = $('#password').val();

            // ส่งข้อมูลไปที่ auth.php ผ่าน AJAX
            $.ajax({
                url: 'api/auth.php',
                type: 'POST',
                data: { username: username, password: password },
                dataType: 'json',
                success: function(response) {
                    if(response.status === 'success') {
                        // ถ้าล็อกอินผ่าน ให้โชว์ Popup สีเขียว แล้วเด้งไปหน้า Dashboard
                        $.alert({
                            title: 'สำเร็จ!',
                            content: response.message,
                            type: 'green',
                            buttons: {
                                ok: {
                                    text: 'เข้าสู่หน้าหลัก',
                                    btnClass: 'btn-green',
                                    action: function() {
                                        window.location.href = 'dashboard.php';
                                    }
                                }
                            }
                        });
                    } else {
                        // ถ้ารหัสผิด ให้โชว์ Popup สีแดง
                        $.alert({
                            title: 'ผิดพลาด!',
                            content: response.message,
                            type: 'red'
                        });
                    }
                },
                error: function() {
                    $.alert({
                        title: 'ระบบขัดข้อง!',
                        content: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้',
                        type: 'red'
                    });
                }
            });
        });
    });
</script>
</body>
</html>