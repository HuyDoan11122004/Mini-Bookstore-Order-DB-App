<?php

class BookOrderRepository
{
    private const SORT_COLUMNS = ['id', 'order_code', 'customer_name', 'customer_email', 'book_title', 'quantity', 'total_amount', 'status', 'created_at'];
    private const DIRECTIONS = ['asc', 'desc'];

    public function __construct(private PDO $db)
    {
    }

    public function countAll(string $keyword = ''): int
    {
        $sql = 'SELECT COUNT(*) AS total FROM book_orders';
        $params = [];

        if ($keyword !== '') {
            $sql .= ' WHERE order_code LIKE :keyword OR customer_name LIKE :keyword OR customer_email LIKE :keyword OR book_title LIKE :keyword';
            $params['keyword'] = '%' . $keyword . '%';
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (int) ($stmt->fetch()['total'] ?? 0);
    }

    public function getPaginated(string $keyword, int $limit, int $offset, string $sort, string $direction): array
    {
        $sort = in_array($sort, self::SORT_COLUMNS, true) ? $sort : 'created_at';
        $direction = in_array(strtolower($direction), self::DIRECTIONS, true) ? strtolower($direction) : 'desc';

        $sql = 'SELECT id, order_code, customer_name, customer_email, book_title, quantity, total_amount, status, created_at FROM book_orders';
        $params = [];

        if ($keyword !== '') {
            $sql .= ' WHERE order_code LIKE :keyword OR customer_name LIKE :keyword OR customer_email LIKE :keyword OR book_title LIKE :keyword';
            $params['keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY {$sort} {$direction} LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value, PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM book_orders WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO book_orders (order_code, customer_name, customer_email, book_title, quantity, total_amount, status, note)
                VALUES (:order_code, :customer_name, :customer_email, :book_title, :quantity, :total_amount, :status, :note)';

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'order_code' => $data['order_code'],
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'] ?: null,
                'book_title' => $data['book_title'],
                'quantity' => $data['quantity'],
                'total_amount' => $data['total_amount'],
                'status' => $data['status'],
                'note' => $data['note'] ?: null,
            ]);
        } catch (PDOException $exception) {
            if (($exception->errorInfo[1] ?? null) === 1062 || $exception->getCode() === '23000') {
                throw new DuplicateRecordException('Book order code already exists.');
            }

            throw $exception;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE book_orders
                SET order_code = :order_code,
                    customer_name = :customer_name,
                    customer_email = :customer_email,
                    book_title = :book_title,
                    quantity = :quantity,
                    total_amount = :total_amount,
                    status = :status,
                    note = :note,
                    updated_at = NOW()
                WHERE id = :id';

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'order_code' => $data['order_code'],
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'] ?: null,
                'book_title' => $data['book_title'],
                'quantity' => $data['quantity'],
                'total_amount' => $data['total_amount'],
                'status' => $data['status'],
                'note' => $data['note'] ?: null,
            ]);
        } catch (PDOException $exception) {
            if (($exception->errorInfo[1] ?? null) === 1062 || $exception->getCode() === '23000') {
                throw new DuplicateRecordException('Book order code already exists.');
            }

            throw $exception;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM book_orders WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
