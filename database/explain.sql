USE mini_bookstore_lab05;

EXPLAIN
SELECT id, full_name, email, phone, interested_genre, status, created_at
FROM bookstore_prospects
WHERE status = 'new'
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;

EXPLAIN
SELECT id, order_code, customer_name, customer_email, book_title, quantity, total_amount, status, created_at
FROM book_orders
WHERE status = 'pending'
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;
