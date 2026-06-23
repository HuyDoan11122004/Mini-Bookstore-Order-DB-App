<?php

class BookOrderController
{
    private BookOrderRepository $orders;

    public function __construct()
    {
        $this->orders = new BookOrderRepository(Database::connection());
    }

    public function index(): void
    {
        $keyword = trim((string) ($_GET['q'] ?? ''));
        $sort = (string) ($_GET['sort'] ?? 'created_at');
        $direction = (string) ($_GET['direction'] ?? 'desc');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 8;

        $total = $this->orders->countAll($keyword);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;

        render('orders/index', [
            'title' => 'Book Orders',
            'orders' => $this->orders->getPaginated($keyword, $perPage, $offset, $sort, $direction),
            'keyword' => $keyword,
            'sort' => $sort,
            'direction' => strtolower($direction),
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
        ]);
    }

    public function create(): void
    {
        render('orders/create', [
            'title' => 'Create Book Order',
            'order' => [],
            'errors' => [],
        ]);
    }

    public function store(): void
    {
        $data = $this->validatedData();
        if ($data['errors'] !== []) {
            render('orders/create', [
                'title' => 'Create Book Order',
                'order' => $_POST,
                'errors' => $data['errors'],
            ], 422);
            return;
        }

        try {
            $this->orders->create($data['values']);
            flash_set('success', 'Book order was created successfully.');
            redirect('/book-orders');
        } catch (DuplicateRecordException) {
            render('orders/create', [
                'title' => 'Create Book Order',
                'order' => $_POST,
                'errors' => ['order_code' => 'This order code already exists. Use a unique bookstore order code.'],
            ], 422);
        }
    }

    public function edit(): void
    {
        $order = $this->orders->findById((int) ($_GET['id'] ?? 0));
        if (!$order) {
            render('errors/404', ['title' => 'Order Not Found'], 404);
            return;
        }

        render('orders/edit', [
            'title' => 'Edit Book Order',
            'order' => $order,
            'errors' => [],
        ]);
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $existing = $this->orders->findById($id);
        if (!$existing) {
            render('errors/404', ['title' => 'Order Not Found'], 404);
            return;
        }

        $data = $this->validatedData();
        if ($data['errors'] !== []) {
            render('orders/edit', [
                'title' => 'Edit Book Order',
                'order' => array_merge($existing, $_POST),
                'errors' => $data['errors'],
            ], 422);
            return;
        }

        try {
            $this->orders->update($id, $data['values']);
            flash_set('success', 'Book order was updated successfully.');
            redirect('/book-orders');
        } catch (DuplicateRecordException) {
            render('orders/edit', [
                'title' => 'Edit Book Order',
                'order' => array_merge($existing, $_POST),
                'errors' => ['order_code' => 'This order code is already used by another order.'],
            ], 422);
        }
    }

    public function delete(): void
    {
        $this->orders->delete((int) ($_POST['id'] ?? 0));
        flash_set('success', 'Book order was deleted successfully.');
        redirect('/book-orders');
    }

    private function validatedData(): array
    {
        $values = [
            'order_code' => strtoupper(trim((string) ($_POST['order_code'] ?? ''))),
            'customer_name' => trim((string) ($_POST['customer_name'] ?? '')),
            'customer_email' => strtolower(trim((string) ($_POST['customer_email'] ?? ''))),
            'book_title' => trim((string) ($_POST['book_title'] ?? '')),
            'quantity' => max(1, (int) ($_POST['quantity'] ?? 1)),
            'total_amount' => max(0, (float) ($_POST['total_amount'] ?? 0)),
            'status' => trim((string) ($_POST['status'] ?? 'pending')),
            'note' => trim((string) ($_POST['note'] ?? '')),
        ];

        $errors = [];
        if ($values['order_code'] === '') {
            $errors['order_code'] = 'Order code is required.';
        }
        if ($values['customer_name'] === '') {
            $errors['customer_name'] = 'Customer name is required.';
        }
        if ($values['customer_email'] !== '' && !filter_var($values['customer_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['customer_email'] = 'Customer email must be valid when provided.';
        }
        if ($values['book_title'] === '') {
            $errors['book_title'] = 'Book title is required.';
        }
        if (!in_array($values['status'], ['pending', 'confirmed', 'packed', 'shipped', 'cancelled'], true)) {
            $errors['status'] = 'Please choose a valid order status.';
        }

        return ['values' => $values, 'errors' => $errors];
    }
}
