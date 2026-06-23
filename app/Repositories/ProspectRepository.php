<?php

class ProspectRepository
{
    private const SORT_COLUMNS = ['id', 'full_name', 'email', 'phone', 'interested_genre', 'status', 'created_at'];
    private const DIRECTIONS = ['asc', 'desc'];

    public function __construct(private PDO $db)
    {
    }

    public function countAll(string $keyword = ''): int
    {
        $sql = 'SELECT COUNT(*) AS total FROM bookstore_prospects';
        $params = [];

        if ($keyword !== '') {
            $sql .= ' WHERE full_name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword OR interested_genre LIKE :keyword';
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

        $sql = 'SELECT id, full_name, email, phone, interested_genre, status, created_at FROM bookstore_prospects';
        $params = [];

        if ($keyword !== '') {
            $sql .= ' WHERE full_name LIKE :keyword OR email LIKE :keyword OR phone LIKE :keyword OR interested_genre LIKE :keyword';
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
        $stmt = $this->db->prepare('SELECT * FROM bookstore_prospects WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $sql = 'INSERT INTO bookstore_prospects (full_name, email, phone, interested_genre, status, note)
                VALUES (:full_name, :email, :phone, :interested_genre, :status, :note)';

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?: null,
                'interested_genre' => $data['interested_genre'],
                'status' => $data['status'],
                'note' => $data['note'] ?: null,
            ]);
        } catch (PDOException $exception) {
            if (($exception->errorInfo[1] ?? null) === 1062 || $exception->getCode() === '23000') {
                throw new DuplicateRecordException('Prospect email already exists.');
            }

            throw $exception;
        }
    }

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE bookstore_prospects
                SET full_name = :full_name,
                    email = :email,
                    phone = :phone,
                    interested_genre = :interested_genre,
                    status = :status,
                    note = :note,
                    updated_at = NOW()
                WHERE id = :id';

        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?: null,
                'interested_genre' => $data['interested_genre'],
                'status' => $data['status'],
                'note' => $data['note'] ?: null,
            ]);
        } catch (PDOException $exception) {
            if (($exception->errorInfo[1] ?? null) === 1062 || $exception->getCode() === '23000') {
                throw new DuplicateRecordException('Prospect email already exists.');
            }

            throw $exception;
        }
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM bookstore_prospects WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }
}
