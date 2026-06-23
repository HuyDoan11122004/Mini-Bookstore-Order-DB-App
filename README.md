# PHP Lab05 - Mini Bookstore Order DB App

**Sinh viên:** Đoàn Nguyễn Minh Huy
**MSSV:** 22110073
**Môn học:** PHP Web Development
**Bài lab:** Lab05 - PHP Database CRUD, PDO Repository, Pagination, Unique & Index

---

## 1. Giới thiệu project

Đây là project thực hiện Lab05 theo hướng **Mini Bookstore Order DB App**.
Ứng dụng dùng để quản lý khách hàng tiềm năng mua sách và các đơn đặt sách trong một hệ thống nhà sách nhỏ.

Project không giữ nguyên bài mẫu Lead/Order mà đã được chuyển đổi sang bài toán mới phù hợp hơn với yêu cầu Lab05. Các tên route, database, bảng, controller, repository, view, field, dữ liệu mẫu và nội dung giao diện đều đã được đổi theo hệ thống Bookstore.

---

## 2. Mục tiêu chính

Project được xây dựng nhằm thực hành các nội dung chính của Lab05:

* Kết nối PHP với MySQL bằng PDO.
* Tách cấu hình database ra khỏi Controller/View.
* Áp dụng kiến trúc Front Controller.
* Sử dụng Router để điều hướng request.
* Sử dụng Controller để xử lý request.
* Sử dụng Repository để gom toàn bộ SQL.
* Dùng prepared statements để tránh SQL Injection.
* Xây dựng CRUD đầy đủ cho 2 module nghiệp vụ.
* Có search, pagination và sort an toàn.
* Dùng unique constraint để chặn dữ liệu trùng.
* Bắt lỗi duplicate key và hiển thị lỗi thân thiện.
* Dùng PRG Pattern sau POST thành công.
* Có trang lỗi 404, 405, 500 an toàn.
* Có health check kiểm tra kết nối database.
* Có EXPLAIN query để kiểm tra index.

---

## 3. Kiến trúc project

Luồng xử lý chính của project:

```text
Browser
-> public/index.php
-> Router
-> Controller
-> Repository
-> PDO
-> MySQL
-> View/Redirect
-> Browser
```

Toàn bộ SQL được đặt trong Repository, không viết SQL trực tiếp trong View hoặc Controller.

---

## 4. Cấu trúc thư mục

```text
php-web-lab05-bookstore/
|
├── public/
│   ├── index.php
│   └── assets/
│       └── style.css
│
├── config/
│   ├── app.php
│   └── database.php
│
├── app/
│   ├── Core/
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── helpers.php
│   │   └── DuplicateRecordException.php
│   │
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── HealthController.php
│   │   ├── ProspectController.php
│   │   └── BookOrderController.php
│   │
│   ├── Repositories/
│   │   ├── ProspectRepository.php
│   │   └── BookOrderRepository.php
│   │
│   └── Views/
│       ├── layout.php
│       ├── dashboard.php
│       ├── errors/
│       ├── prospects/
│       └── book_orders/
│
├── database/
│   ├── schema.sql
│   ├── seed.sql
│   ├── explain.sql
│   └── seed_data.php
│
└── storage/
    └── logs/
```

---

## 5. Database

Database sử dụng trong project:

```text
bookstore_lab05_db
```

Các bảng chính:

```text
users
prospects
book_orders
```

### Bảng users

Dùng để lưu thông tin người dùng hệ thống.

### Bảng prospects

Dùng để quản lý khách hàng tiềm năng mua sách.

Một số field chính:

```text
id
full_name
email
phone
interest_book
status
note
created_at
updated_at
```

Ràng buộc quan trọng:

```text
UNIQUE email
```

Mục đích: chặn trùng email khách hàng tiềm năng.

### Bảng book_orders

Dùng để quản lý đơn đặt sách.

Một số field chính:

```text
id
order_code
customer_name
customer_email
book_title
quantity
total_amount
status
created_at
updated_at
```

Ràng buộc quan trọng:

```text
UNIQUE order_code
```

Mục đích: chặn trùng mã đơn sách.

---

## 6. Các route chính

### Dashboard và Health Check

| Method | URL       | Chức năng                 |
| ------ | --------- | ------------------------- |
| GET    | `/`       | Hiển thị dashboard        |
| GET    | `/health` | Kiểm tra kết nối database |

### Module Prospects

| Method | URL                    | Chức năng                      |
| ------ | ---------------------- | ------------------------------ |
| GET    | `/prospects`           | Danh sách khách hàng tiềm năng |
| GET    | `/prospects/create`    | Form tạo prospect              |
| POST   | `/prospects/store`     | Lưu prospect mới               |
| GET    | `/prospects/edit?id=1` | Form sửa prospect              |
| POST   | `/prospects/update`    | Cập nhật prospect              |
| POST   | `/prospects/delete`    | Xóa prospect bằng POST         |

### Module Book Orders

| Method | URL                      | Chức năng              |
| ------ | ------------------------ | ---------------------- |
| GET    | `/book-orders`           | Danh sách đơn sách     |
| GET    | `/book-orders/create`    | Form tạo đơn sách      |
| POST   | `/book-orders/store`     | Lưu đơn sách mới       |
| GET    | `/book-orders/edit?id=1` | Form sửa đơn sách      |
| POST   | `/book-orders/update`    | Cập nhật đơn sách      |
| POST   | `/book-orders/delete`    | Xóa đơn sách bằng POST |

---

## 7. Chức năng đã hoàn thành

Project đã hoàn thành các chức năng bắt buộc của Lab05:

* Dashboard giới thiệu hệ thống.
* Health check database bằng JSON.
* CRUD đầy đủ cho Prospects.
* CRUD đầy đủ cho Book Orders.
* Validate form create/update.
* Giữ lại dữ liệu cũ khi form lỗi.
* Bắt lỗi email prospect trùng.
* Bắt lỗi order_code trùng.
* Search theo keyword.
* Pagination.
* Sort an toàn bằng whitelist.
* Xử lý sort nguy hiểm qua URL.
* Xử lý page âm và page vượt giới hạn.
* Delete bằng form POST.
* PRG Pattern sau POST thành công.
* Flash message sau create/update/delete.
* Error page 404 Not Found.
* Error page 405 Method Not Allowed.
* Error page 500 safe message.
* Ghi log lỗi database vào `storage/logs/app.log`.
* Có SQL kiểm tra duplicate và EXPLAIN query.

---

## 8. Phần làm thêm so với bài mẫu

Ngoài yêu cầu bắt buộc, project có thêm:

* Chuyển bài toán sang Mini Bookstore Order DB App.
* Đổi toàn bộ route, controller, repository, view, field và dữ liệu mẫu theo bài toán Bookstore.
* Thêm filter theo trạng thái ở trang danh sách.
* Thêm toggle sort direction asc/desc.
* Thêm `seed_data.php` để sinh dữ liệu test pagination.
* Thêm logging lỗi vào `storage/logs/app.log`.
* Thiết kế giao diện frontend rõ ràng hơn với dashboard, card, badge trạng thái, form và bảng dữ liệu.
* Có báo cáo Word kèm ảnh minh chứng test case thực thi.

---

## 9. Hướng dẫn chạy project

### Bước 1: Import database

Mở phpMyAdmin hoặc MySQL Workbench, chạy file:

```text
database/schema.sql
```

Sau đó chạy tiếp:

```text
database/seed.sql
```

Có thể chạy thêm file sinh dữ liệu test:

```bash
php database/seed_data.php
```

### Bước 2: Cấu hình database

Mở file:

```text
config/database.php
```

Cấu hình lại thông tin kết nối nếu cần:

```php
return [
    'host' => 'localhost',
    'database' => 'bookstore_lab05_db',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];
```

### Bước 3: Chạy server PHP

```bash
php -S localhost:8000 -t public
```

### Bước 4: Truy cập ứng dụng

```text
http://localhost:8000/
```

---

## 10. Test cases

### TC01 - GET /health

**Cách test:**

```text
GET http://localhost:8000/health
```

**Kết quả mong đợi:**

```json
{
  "status": "ok",
  "database": "connected"
}
```

**Kết quả thực tế:**
Hệ thống trả JSON thông báo database connected.

**Trạng thái:** Pass

---

### TC02 - GET /prospects

**Cách test:**

```text
GET http://localhost:8000/prospects
```

**Kết quả mong đợi:**
Hiển thị danh sách prospects, có search, filter, pagination và sort.

**Kết quả thực tế:**
Trang Prospects hiển thị danh sách khách hàng tiềm năng đúng.

**Trạng thái:** Pass

---

### TC03 - POST create prospect hợp lệ

**Cách test:**
Vào `/prospects/create`, nhập dữ liệu hợp lệ và submit.

**Kết quả mong đợi:**
Redirect về `/prospects`, hiện flash success và DB có dữ liệu mới.

**Kết quả thực tế:**
Tạo prospect thành công và quay về danh sách.

**Trạng thái:** Pass

---

### TC04 - POST create prospect thiếu required field

**Cách test:**
Vào `/prospects/create`, bỏ trống các field bắt buộc rồi submit.

**Kết quả mong đợi:**
Form hiển thị lỗi đúng field và không insert DB.

**Kết quả thực tế:**
Hệ thống báo lỗi required field.

**Trạng thái:** Pass

---

### TC05 - POST create prospect trùng email

**Cách test:**
Tạo prospect với email đã tồn tại trong database.

**Kết quả mong đợi:**
Hệ thống báo lỗi email đã tồn tại và giữ dữ liệu cũ trên form.

**Kết quả thực tế:**
Unique constraint chặn email trùng và form hiển thị lỗi thân thiện.

**Trạng thái:** Pass

---

### TC06 - GET edit prospect với id hợp lệ

**Cách test:**

```text
GET http://localhost:8000/prospects/edit?id=1
```

**Kết quả mong đợi:**
Form edit hiển thị dữ liệu cũ của prospect.

**Kết quả thực tế:**
Form edit load đúng dữ liệu từ DB.

**Trạng thái:** Pass

---

### TC07 - POST update prospect hợp lệ

**Cách test:**
Mở form edit prospect, thay đổi dữ liệu và submit.

**Kết quả mong đợi:**
Redirect về list, dữ liệu được cập nhật và hiện flash success.

**Kết quả thực tế:**
Cập nhật prospect thành công.

**Trạng thái:** Pass

---

### TC08 - POST delete prospect

**Cách test:**
Bấm nút Delete trong danh sách prospects.

**Kết quả mong đợi:**
Xóa bằng form POST, có confirm và redirect về list.

**Kết quả thực tế:**
Prospect được xóa bằng POST và quay lại danh sách.

**Trạng thái:** Pass

---

### TC09 - GET /book-orders

**Cách test:**

```text
GET http://localhost:8000/book-orders
```

**Kết quả mong đợi:**
Hiển thị danh sách đơn sách, có search, pagination và sort.

**Kết quả thực tế:**
Trang Book Orders hiển thị danh sách đơn sách đúng.

**Trạng thái:** Pass

---

### TC10 - POST create book order trùng order_code

**Cách test:**
Tạo đơn sách với order_code đã tồn tại.

**Kết quả mong đợi:**
Hệ thống báo lỗi mã đơn sách đã tồn tại.

**Kết quả thực tế:**
Unique constraint chặn order_code trùng và báo lỗi đúng field.

**Trạng thái:** Pass

---

### TC11 - URL không tồn tại

**Cách test:**

```text
GET http://localhost:8000/not-found-url
```

**Kết quả mong đợi:**
Router trả trang 404 Not Found.

**Kết quả thực tế:**
Hệ thống hiển thị trang 404.

**Trạng thái:** Pass

---

### TC12 - Sai method với route có tồn tại

**Cách test:**
Gọi sai method với route đã khai báo, ví dụ gửi GET vào route POST.

```text
GET http://localhost:8000/prospects/delete
```

**Kết quả mong đợi:**
Router trả trang 405 Method Not Allowed.

**Kết quả thực tế:**
Hệ thống hiển thị trang 405.

**Trạng thái:** Pass

---

### TC13 - Sort nguy hiểm qua URL

**Cách test:**

```text
GET http://localhost:8000/prospects?sort=id%20DESC;%20DROP%20TABLE%20prospects&direction=asc
```

**Kết quả mong đợi:**
Không thực thi SQL nguy hiểm; hệ thống dùng sort mặc định.

**Kết quả thực tế:**
Whitelist sort đã chặn input nguy hiểm và danh sách vẫn hiển thị bình thường.

**Trạng thái:** Pass

---

### TC14 - Page âm hoặc page quá lớn

**Cách test:**

```text
GET http://localhost:8000/prospects?page=-5
```

hoặc:

```text
GET http://localhost:8000/prospects?page=9999
```

**Kết quả mong đợi:**
Page được chuẩn hóa về giới hạn hợp lệ.

**Kết quả thực tế:**
Hệ thống không lỗi và đưa page về giới hạn hợp lệ.

**Trạng thái:** Pass

---

### TC15 - DB lỗi ở production

**Cách test:**
Tạm sửa sai password database và đặt production/debug=false.

**Kết quả mong đợi:**
Không hiển thị SQLSTATE hoặc lỗi kỹ thuật thô ra giao diện.

**Kết quả thực tế:**
Hệ thống hiển thị trang 500 an toàn và ghi log lỗi vào `storage/logs/app.log`.

**Trạng thái:** Pass

---

## 11. Kiểm tra Git commit

Project được commit theo 5 mốc:

```text
setup: initialize bookstore Lab05 project structure
schema: add bookstore database schema seed and explain queries
repository: implement PDO repositories with prepared statements
crud: implement prospects and book orders modules
tests: document test cases and explain checks
```

Kiểm tra bằng lệnh:

```bash
git log --oneline
```

---

## 12. Tác giả

**Đoàn Nguyễn Minh Huy**
**MSSV:** 22110073
