<?php

class ProspectController
{
    private ProspectRepository $prospects;

    public function __construct()
    {
        $this->prospects = new ProspectRepository(Database::connection());
    }

    public function index(): void
    {
        $keyword = trim((string) ($_GET['q'] ?? ''));
        $sort = (string) ($_GET['sort'] ?? 'created_at');
        $direction = (string) ($_GET['direction'] ?? 'desc');
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 8;

        $total = $this->prospects->countAll($keyword);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = min($page, $totalPages);
        $offset = ($page - 1) * $perPage;

        render('prospects/index', [
            'title' => 'Prospects',
            'prospects' => $this->prospects->getPaginated($keyword, $perPage, $offset, $sort, $direction),
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
        render('prospects/create', [
            'title' => 'Create Prospect',
            'prospect' => [],
            'errors' => [],
        ]);
    }

    public function store(): void
    {
        $data = $this->validatedData();
        if ($data['errors'] !== []) {
            render('prospects/create', [
                'title' => 'Create Prospect',
                'prospect' => $_POST,
                'errors' => $data['errors'],
            ], 422);
            return;
        }

        try {
            $this->prospects->create($data['values']);
            flash_set('success', 'Prospect was created successfully.');
            redirect('/prospects');
        } catch (DuplicateRecordException) {
            render('prospects/create', [
                'title' => 'Create Prospect',
                'prospect' => $_POST,
                'errors' => ['email' => 'This email is already registered as a bookstore prospect.'],
            ], 422);
        }
    }

    public function edit(): void
    {
        $prospect = $this->prospects->findById((int) ($_GET['id'] ?? 0));
        if (!$prospect) {
            render('errors/404', ['title' => 'Prospect Not Found'], 404);
            return;
        }

        render('prospects/edit', [
            'title' => 'Edit Prospect',
            'prospect' => $prospect,
            'errors' => [],
        ]);
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $existing = $this->prospects->findById($id);
        if (!$existing) {
            render('errors/404', ['title' => 'Prospect Not Found'], 404);
            return;
        }

        $data = $this->validatedData();
        if ($data['errors'] !== []) {
            render('prospects/edit', [
                'title' => 'Edit Prospect',
                'prospect' => array_merge($existing, $_POST),
                'errors' => $data['errors'],
            ], 422);
            return;
        }

        try {
            $this->prospects->update($id, $data['values']);
            flash_set('success', 'Prospect was updated successfully.');
            redirect('/prospects');
        } catch (DuplicateRecordException) {
            render('prospects/edit', [
                'title' => 'Edit Prospect',
                'prospect' => array_merge($existing, $_POST),
                'errors' => ['email' => 'This email is already used by another prospect.'],
            ], 422);
        }
    }

    public function delete(): void
    {
        $this->prospects->delete((int) ($_POST['id'] ?? 0));
        flash_set('success', 'Prospect was deleted successfully.');
        redirect('/prospects');
    }

    private function validatedData(): array
    {
        $values = [
            'full_name' => trim((string) ($_POST['full_name'] ?? '')),
            'email' => strtolower(trim((string) ($_POST['email'] ?? ''))),
            'phone' => trim((string) ($_POST['phone'] ?? '')),
            'interested_genre' => trim((string) ($_POST['interested_genre'] ?? 'General')),
            'status' => trim((string) ($_POST['status'] ?? 'new')),
            'note' => trim((string) ($_POST['note'] ?? '')),
        ];

        $errors = [];
        if ($values['full_name'] === '') {
            $errors['full_name'] = 'Full name is required.';
        }
        if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'A valid email is required.';
        }
        if ($values['interested_genre'] === '') {
            $errors['interested_genre'] = 'Interested genre is required.';
        }
        if (!in_array($values['status'], ['new', 'contacted', 'qualified', 'lost'], true)) {
            $errors['status'] = 'Please choose a valid status.';
        }

        return ['values' => $values, 'errors' => $errors];
    }
}
