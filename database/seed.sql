USE mini_bookstore_lab05;

INSERT INTO users (name, email, password_hash, role) VALUES
('Bookstore Admin', 'admin@bookstore.test', '$2y$10$examplehashadmin', 'admin'),
('Sales Librarian', 'sales@bookstore.test', '$2y$10$examplehashstaff', 'staff')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO bookstore_prospects (full_name, email, phone, interested_genre, status, note) VALUES
('An Nguyen', 'an.nguyen@example.com', '0901000001', 'Technology', 'new', 'Interested in PHP and database books'),
('Binh Tran', 'binh.tran@example.com', '0901000002', 'Business', 'contacted', 'Asked for bulk discount'),
('Chi Le', 'chi.le@example.com', '0901000003', 'Children', 'qualified', 'Needs reading list for school'),
('Dung Pham', 'dung.pham@example.com', '0901000004', 'Fiction', 'lost', 'Price-sensitive customer'),
('Hoa Vu', 'hoa.vu@example.com', '0901000005', 'Self-help', 'new', 'Subscribed through landing page'),
('Khanh Do', 'khanh.do@example.com', '0901000006', 'Technology', 'contacted', 'Requested Laravel titles'),
('Lan Huynh', 'lan.huynh@example.com', '0901000007', 'History', 'qualified', 'Wants Vietnamese history set'),
('Minh Ho', 'minh.ho@example.com', '0901000008', 'Comics', 'new', 'Asked for manga release updates'),
('Nga Bui', 'nga.bui@example.com', '0901000009', 'Education', 'contacted', 'Teacher buying class materials'),
('Phong Vo', 'phong.vo@example.com', '0901000010', 'Science', 'qualified', 'Interested in astronomy books'),
('Quynh Mai', 'quynh.mai@example.com', '0901000011', 'Fiction', 'new', 'Found us on social media'),
('Son Dang', 'son.dang@example.com', '0901000012', 'Business', 'contacted', 'Needs invoice support'),
('Trang Cao', 'trang.cao@example.com', '0901000013', 'Language', 'qualified', 'Looking for IELTS books'),
('Uy Nguyen', 'uy.nguyen@example.com', '0901000014', 'Technology', 'new', 'Asked about clean code titles'),
('Vy Phan', 'vy.phan@example.com', '0901000015', 'Cookbook', 'lost', 'No longer needs purchase'),
('Yen Truong', 'yen.truong@example.com', '0901000016', 'Children', 'new', 'Requested birthday gift advice')
ON DUPLICATE KEY UPDATE full_name = VALUES(full_name);

INSERT INTO book_orders (order_code, customer_name, customer_email, book_title, quantity, total_amount, status, note) VALUES
('BOOK-2026-0001', 'An Nguyen', 'an.nguyen@example.com', 'PHP and MySQL Web Development', 1, 450000, 'pending', 'Pay on delivery'),
('BOOK-2026-0002', 'Binh Tran', 'binh.tran@example.com', 'The Lean Startup', 2, 620000, 'confirmed', 'Company purchase'),
('BOOK-2026-0003', 'Chi Le', 'chi.le@example.com', 'Matilda', 3, 360000, 'packed', 'Gift wrap requested'),
('BOOK-2026-0004', 'Hoa Vu', 'hoa.vu@example.com', 'Atomic Habits', 1, 220000, 'shipped', 'Standard shipping'),
('BOOK-2026-0005', 'Khanh Do', 'khanh.do@example.com', 'Laravel Up and Running', 1, 520000, 'pending', 'Needs VAT invoice'),
('BOOK-2026-0006', 'Lan Huynh', 'lan.huynh@example.com', 'A Brief History of Vietnam', 2, 510000, 'confirmed', 'Pickup at store'),
('BOOK-2026-0007', 'Minh Ho', 'minh.ho@example.com', 'One Piece Vol. 1', 5, 375000, 'packed', 'Manga shelf order'),
('BOOK-2026-0008', 'Nga Bui', 'nga.bui@example.com', 'Classroom Management', 4, 880000, 'shipped', 'School delivery'),
('BOOK-2026-0009', 'Phong Vo', 'phong.vo@example.com', 'Cosmos', 1, 330000, 'pending', 'Customer asked for call'),
('BOOK-2026-0010', 'Quynh Mai', 'quynh.mai@example.com', 'The Midnight Library', 1, 185000, 'confirmed', 'Paid by transfer'),
('BOOK-2026-0011', 'Son Dang', 'son.dang@example.com', 'Good to Great', 2, 490000, 'cancelled', 'Cancelled before packing'),
('BOOK-2026-0012', 'Trang Cao', 'trang.cao@example.com', 'Cambridge IELTS 18', 1, 310000, 'packed', 'Exam prep'),
('BOOK-2026-0013', 'Uy Nguyen', 'uy.nguyen@example.com', 'Clean Code', 1, 610000, 'pending', 'Backorder check'),
('BOOK-2026-0014', 'Vy Phan', 'vy.phan@example.com', 'Vietnamese Home Cooking', 1, 280000, 'confirmed', 'Gift note'),
('BOOK-2026-0015', 'Yen Truong', 'yen.truong@example.com', 'The Little Prince', 2, 210000, 'shipped', 'Birthday gift'),
('BOOK-2026-0016', 'An Nguyen', 'an.nguyen@example.com', 'Designing Data-Intensive Applications', 1, 790000, 'pending', 'Notify when ready')
ON DUPLICATE KEY UPDATE customer_name = VALUES(customer_name);
