<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - ระบบยืม-คืนอุปกรณ์กีฬา</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
</head>
<body class="bg-gray-900 text-white font-sans antialiased p-6">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center bg-gray-800 p-6 rounded-lg shadow-lg mb-6 border border-gray-700">
            <div>
                <h1 class="text-3xl font-bold text-blue-400">🏀 Sport Equipment Dashboard</h1>
                <p class="text-gray-400 mt-1">จัดการระบบยืม-คืนอุปกรณ์กีฬา</p>
            </div>
            <button onclick="window.location.href='index.php'" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                ออกจากระบบ
            </button>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">รายการอุปกรณ์ทั้งหมด</h2>
            <button onclick="openForm('add')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition">
                + เพิ่มอุปกรณ์ใหม่
            </button>
        </div>

        <div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-700 text-gray-300">
                        <th class="p-4 border-b border-gray-600">ID</th>
                        <th class="p-4 border-b border-gray-600">ชื่ออุปกรณ์</th>
                        <th class="p-4 border-b border-gray-600">หมวดหมู่</th>
                        <th class="p-4 border-b border-gray-600">จำนวนทั้งหมด</th>
                        <th class="p-4 border-b border-gray-600 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody id="equipmentTableBody">
                    <tr><td colspan="5" class="p-4 text-center text-gray-400">กำลังโหลดข้อมูล...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadData(); // โหลดข้อมูลทันทีที่เปิดหน้าเว็บ
        });

        // ฟังก์ชันดึงข้อมูลจาก API มาแสดงในตาราง (AJAX)
        function loadData() {
            $.get('api/get_equipment.php', function(response) {
                let html = '';
                if(response.status === 'success') {
                    if(response.data.length === 0) {
                        html = '<tr><td colspan="5" class="p-4 text-center text-gray-400">ยังไม่มีข้อมูลอุปกรณ์</td></tr>';
                    } else {
                        response.data.forEach(function(item) {
                            html += `<tr class="hover:bg-gray-700 transition">
                                <td class="p-4 border-b border-gray-700">${item.id}</td>
                                <td class="p-4 border-b border-gray-700 font-semibold text-blue-300">${item.name}</td>
                                <td class="p-4 border-b border-gray-700">
                                    <span class="bg-gray-600 px-2 py-1 rounded text-sm">${item.category}</span>
                                </td>
                                <td class="p-4 border-b border-gray-700">${item.total_quantity}</td>
                                <td class="p-4 border-b border-gray-700 text-center space-x-2">
                                    <button onclick="openForm('edit', ${item.id}, '${item.name}', '${item.category}', ${item.total_quantity})" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-1 px-3 rounded text-sm">แก้ไข</button>
                                    <button onclick="deleteEquipment(${item.id})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-sm">ลบ</button>
                                </td>
                            </tr>`;
                        });
                    }
                }
                $('#equipmentTableBody').html(html);
            });
        }

        // ฟังก์ชันเปิด Popup ฟอร์ม (เพิ่ม/แก้ไข) ด้วย jQuery Confirm
        function openForm(action, id = '', name = '', category = '', total = '') {
            let titleText = action === 'add' ? '➕ เพิ่มอุปกรณ์ใหม่' : '✏️ แก้ไขอุปกรณ์';
            
            $.confirm({
                title: `<span class="text-gray-800 font-bold">${titleText}</span>`,
                content: `
                    <form action="" class="formName space-y-4 mt-2">
                        <div><label class="text-gray-700 font-semibold block mb-1">ชื่ออุปกรณ์</label><input type="text" id="eq_name" class="w-full border border-gray-300 p-2 rounded text-gray-800 focus:outline-none focus:border-blue-500" value="${name}" required /></div>
                        <div><label class="text-gray-700 font-semibold block mb-1">หมวดหมู่</label><input type="text" id="eq_category" class="w-full border border-gray-300 p-2 rounded text-gray-800 focus:outline-none focus:border-blue-500" value="${category}" required /></div>
                        <div><label class="text-gray-700 font-semibold block mb-1">จำนวน</label><input type="number" id="eq_total" class="w-full border border-gray-300 p-2 rounded text-gray-800 focus:outline-none focus:border-blue-500" value="${total}" required /></div>
                    </form>
                `,
                type: 'blue',
                columnClass: 'medium',
                buttons: {
                    formSubmit: {
                        text: 'บันทึกข้อมูล',
                        btnClass: 'btn-blue',
                        action: function () {
                            let n = this.$content.find('#eq_name').val();
                            let c = this.$content.find('#eq_category').val();
                            let t = this.$content.find('#eq_total').val();
                            
                            if(!n || !c || !t){
                                $.alert({title: 'แจ้งเตือน!', content: 'กรุณากรอกข้อมูลให้ครบถ้วน', type: 'red'});
                                return false;
                            }
                            
                            // ส่งข้อมูลไปบันทึกด้วย AJAX
                            $.post('api/manage_equipment.php', {
                                action: action, id: id, name: n, category: c, total_quantity: t
                            }, function(res) {
                                if(res.status === 'success') {
                                    $.alert({title: 'สำเร็จ!', content: res.message, type: 'green'});
                                    loadData(); // รีเฟรชตารางใหม่
                                } else {
                                    $.alert({title: 'ผิดพลาด!', content: res.message, type: 'red'});
                                }
                            });
                        }
                    },
                    cancel: { text: 'ยกเลิก', btnClass: 'btn-default' }
                }
            });
        }

        // ฟังก์ชันลบข้อมูล
        function deleteEquipment(id) {
            $.confirm({
                title: 'ยืนยันการลบ!',
                content: 'คุณแน่ใจหรือไม่ว่าต้องการลบอุปกรณ์นี้?',
                type: 'red',
                buttons: {
                    confirm: {
                        text: 'ลบทิ้ง',
                        btnClass: 'btn-red',
                        action: function () {
                            $.post('api/manage_equipment.php', { action: 'delete', id: id }, function(res) {
                                if(res.status === 'success') {
                                    loadData(); // รีเฟรชตาราง
                                }
                            });
                        }
                    },
                    cancel: { text: 'ยกเลิก' }
                }
            });
        }
    </script>
</body>
</html>