# 🏀 Sports Equipment Management System

ระบบจัดการยืม-คืนอุปกรณ์กีฬา พัฒนาด้วยสถาปัตยกรรมที่เน้นความปลอดภัยและความลื่นไหลในการใช้งาน 

## 🛠️ Tech Stack
* **Backend:** PHP 8.2
* **Database:** MySQL (เชื่อมต่อผ่าน PHP PDO เพื่อป้องกัน SQL Injection)
* **Frontend:** Tailwind CSS (ออกแบบในสไตล์ Dark Mode)
* **Interactive:** jQuery & AJAX (ทำงานแบบ Asynchronous) + jQuery Confirm (แจ้งเตือน UI สวยงาม)
* **Infrastructure:** Docker & Docker Compose

## 🚀 วิธีการติดตั้งและรันโปรเจกต์ (How to run)
1. ติดตั้ง Docker และ Docker Desktop ในเครื่อง
2. เปิด Terminal ในโฟลเดอร์โปรเจกต์นี้
3. รันคำสั่งเพื่อสตาร์ท Server:
   ```bash
   docker-compose up -d