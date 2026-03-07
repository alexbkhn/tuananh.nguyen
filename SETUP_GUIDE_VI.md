# 🚀 Hướng Dẫn Chạy Ứng Dụng Quản Lý Danh Mục Đầu Tư

## ✅ Cấu Hình Đã Hoàn Tất
- ✓ Cài đặt Composer PHP dependencies
- ✓ Tạo file .env với cấu hình MySQL
- ✓ Generate APP_KEY (mã mã hóa)
- ✓ Tạo database: `tuananh_nguyen`
- ✓ Chạy database migrations (tạo bảng)
- ✓ Cài đặt npm JavaScript dependencies

---

## 🚀 Cách Chạy Ứng Dụng

### **Phương Pháp 1: Dùng Script Batch (Đơn Giản Nhất)**
1. Đôi click vào file `start-app.bat` trong thư mục project
2. Cửa sổ Terminal sẽ mở ra, server khởi động
3. Mở trình duyệt và vào: **http://localhost:8000**
4. Đăng nhập với tài khoản (nếu đã có dữ liệu)

### **Phương Pháp 2: Dùng PowerShell (Chi Tiết Hơn)**
1. Mở PowerShell hoặc cmd
2. Chuyển về thư mục project:
   ```
   cd c:\xampp\htdocs\tuananh.nguyen
   ```
3. Khởi động server Laravel:
   ```
   C:\xampp\php\php.exe artisan serve
   ```
4. Server sẽ chạy tại: **http://localhost:8000**

### **Phương Pháp 3: Sử Dụng Apache (XAMPP)**
1. Mở XAMPP Control Panel
2. Click `Start` cạnh Apache
3. Click `Start` cạnh MySQL
4. Vào trình duyệt: **http://localhost/tuananh.nguyen**

---

## 🔑 Thông Tin Cấu Hình

| Thành Phần | Chi Tiết |
|-----------|---------|
| **URL** | http://localhost:8000 |
| **Database** | tuananh_nguyen (MySQL) |
| **Tài khoản DB** | root (không có mật khẩu) |
| **Laravel Version** | 11.9 |
| **PHP Version** | 8.2.12 |

---

## 📝 Các Lệnh Artisan Hữu Ích

### **Quản lý Database**
```bash
# Xem trạng thái migrations
C:\xampp\php\php.exe artisan migrate:status

# Rollback (quay lại) migrations
C:\xampp\php\php.exe artisan migrate:rollback

# Seed dữ liệu mẫu (nếu có)
C:\xampp\php\php.exe artisan db:seed
```

### **Build Assets (CSS/JS)**
```bash
# Build assets (production)
npm run build

# Watch assets (development - tự động rebuild khi file thay đổi)
npm run dev
```

### **Khác**
```bash
# Xóa cache
C:\xampp\php\php.exe artisan cache:clear

# Xóa config cache
C:\xampp\php\php.exe artisan config:clear

# Xem Tinker console (interactive shell)
C:\xampp\php\php.exe artisan tinker
```

---

## ⚠️ Ghi Chú Quan Trọng

### **Nếu lỗi "MySQL connection refused"**
1. Mở XAMPP Control Panel
2. Chắc chắn rằng MySQL đã được `Start`
3. Kiểm tra cấu hình trong file `.env`:
   - `DB_HOST=127.0.0.1`
   - `DB_PORT=3306`
   - `DB_DATABASE=tuananh_nguyen`
   - `DB_USERNAME=root`
   - `DB_PASSWORD` (để trống nếu chưa đặt mật khẩu)

### **Nếu lỗi "Port 8000 đang bị sử dụng"**
Chỉ định port khác:
```bash
C:\xampp\php\php.exe artisan serve --port=8001
```

### **Nếu lỗi "Method not allowed"**
Chắc chắn bạn đang dùng `php artisan serve` (không phải Apache đơn thuần)

---

## 🗂️ Cấu Trúc Project

```
tuananh.nguyen/
├── app/                    # Mã ứng dụng
│   ├── Http/               # Controllers, Middleware
│   ├── Mail/               # Email classes
│   └── Models/             # Database models
├── config/                 # Cấu hình ứng dụng
├── database/               # Migrations, Seeders
├── public/                 # Web root (CSS, JS, hình ảnh)
├── resources/              # Templates, view files
├── routes/                 # Định tuyến URLs
├── storage/                # Cache, logs, uploads
└── tests/                  # Test files
```

---

## 🔐 Bảo Mật

⚠️ **MỤC HỎA!** File `.env` chứa thông tin nhạy cảm:
- Chỉ chia sẻ nó hơi những người trusted
- Không commit `.env` vào Git
- Sử dụng `.env.example` cho production

---

## 📞 Ghi Chú Thêm

- Hệ thống email hiện được cấu hình để log đến file (không gửi thực)
- Nếu muốn gửi email thực, cập nhật cấu hình mail trong `.env`
- Assets (CSS/JS) cần được build qua Vite trước khi deploy

---

**Chúc bạn sử dụng ứng dụng vui vẻ! 🎉**
