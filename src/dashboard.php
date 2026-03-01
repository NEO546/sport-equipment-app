<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dashboard - Sports Borrow System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(31, 41, 55, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(75, 85, 99, 0.3);
        }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-200 min-h-screen">

    <nav class="glass-card sticky top-0 z-50 px-6 py-4 mb-8 border-b border-slate-700">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-blue-600 p-2 rounded-lg shadow-lg shadow-blue-500/20">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-white">SportSync <span class="text-blue-500 text-sm font-normal">Pro</span></span>
            </div>
            <div class="flex items-center space-x-6">
                <span class="text-slate-400 text-sm hidden md:block">ผู้ดูแลระบบ: <span class="text-slate-200 font-semibold">Admin</span></span>
                <button onclick="window.location.href='index.php'" class="bg-slate-700 hover:bg-red-500/20 hover:text-red-400 px-4 py-2 rounded-lg text-sm font-medium transition-all border border-slate-600">ออกจากระบบ</button>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass-card p-6 rounded-2xl">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">อุปกรณ์ทั้งหมด</p>
                <h3 id="totalCount" class="text-3xl font-bold">--</h3>
            </div>
            <div class="glass-card p-6 rounded-2xl border-l-4 border-green-500">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">สถานะปกติ</p>
                <h3 class="text-3xl font-bold text-green-400">พร้อมใช้งาน</h3>
            </div>
            <div class="glass-card p-6 rounded-2xl border-l-4 border-blue-500">
                <p class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">การทำรายการวันนี้</p>
                <h3 class="text-3xl font-bold text-blue-400">Active</h3>
            </div>
        </div>

        <div class="glass-card rounded-2xl overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-slate-700 flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-xl font-bold">คลังอุปกรณ์กีฬา</h2>
                <button onclick="openForm('add')" class="w-full md:w-auto bg-blue-600 hover:bg-blue-500 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg shadow-blue-600/20 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    เพิ่มอุปกรณ์
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-800/50 text-slate-400 text-sm uppercase">
                            <th class="px-6 py-4 font-semibold">ID</th>
                            <th class="px-6 py-4 font-semibold text-left">รายละเอียดอุปกรณ์</th>
                            <th class="px-6 py-4 font-semibold">หมวดหมู่</th>
                            <th class="px-6 py-4 font-semibold">จำนวน</th>
                            <th class="px-6 py-4 font-semibold text-right">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody id="equipmentTableBody" class="divide-y divide-slate-700">
                        </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() { loadData(); });

        function loadData() {
            $.get('api/get_equipment.php', function(response) {
                let html = '';
                if(response.status === 'success') {
                    $('#totalCount').text(response.data.length);
                    response.data.forEach(function(item) {
                        html += `
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 text-center text-slate-500 font-mono text-xs">#${item.id}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-100">${item.name}</div>
                                <div class="text-xs text-slate-500 italic">อัปเดตล่าสุด: ${new Date(item.updated_at).toLocaleDateString()}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-blue-500/10 text-blue-400 px-3 py-1 rounded-full text-xs font-bold border border-blue-500/20">${item.category}</span>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-slate-300">${item.total_quantity}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button onclick="openForm('edit', ${item.id}, '${item.name}', '${item.category}', ${item.total_quantity})" class="text-amber-400 hover:bg-amber-400/10 p-2 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button onclick="deleteEquipment(${item.id})" class="text-red-400 hover:bg-red-400/10 p-2 rounded-lg transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>`;
                    });
                }
                $('#equipmentTableBody').html(html);
            });
        }

        function openForm(action, id = '', name = '', category = '', total = '') {
            $.confirm({
                title: `<span class="text-slate-800 font-bold">${action === 'add' ? '✨ เพิ่มอุปกรณ์ใหม่' : '📝 แก้ไขรายละเอียด'}</span>`,
                content: `
                    <div class="mt-4 space-y-4">
                        <input type="text" id="eq_name" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="ชื่ออุปกรณ์ (เช่น ไม้แบดมินตัน)" value="${name}" />
                        <input type="text" id="eq_category" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="หมวดหมู่" value="${category}" />
                        <input type="number" id="eq_total" class="w-full border p-3 rounded-xl focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="จำนวนคงคลัง" value="${total}" />
                    </div>`,
                buttons: {
                    confirm: {
                        text: 'ยืนยัน',
                        btnClass: 'btn-blue',
                        action: function () {
                            let n = this.$content.find('#eq_name').val();
                            let c = this.$content.find('#eq_category').val();
                            let t = this.$content.find('#eq_total').val();
                            if(!n || !c || !t) return false;
                            $.post('api/manage_equipment.php', {action: action, id: id, name: n, category: c, total_quantity: t}, function() { loadData(); });
                        }
                    },
                    cancel: { text: 'ยกเลิก' }
                }
            });
        }

        function deleteEquipment(id) {
            $.confirm({
                title: 'ยืนยันการลบ?',
                content: 'ข้อมูลนี้จะหายไปจากระบบทันที',
                type: 'red',
                buttons: {
                    confirm: { text: 'ลบเลย', btnClass: 'btn-red', action: function() {
                        $.post('api/manage_equipment.php', {action: 'delete', id: id}, function() { loadData(); });
                    }},
                    cancel: { text: 'ยกเลิก' }
                }
            });
        }
    </script>
</body>
</html>