<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UsersModel');
    }

    public function index()
    {
        $data['users'] = $this->UsersModel->all();
        $this->call->view('users', $data);
    }

    public function create()
    {
        $this->call->view('user_form', [
            'title' => 'Create User',
            'action' => '/users/store',
            'user' => [],
            'errors' => [],
        ]);
    }

    public function store()
    {
        $data = $this->user_data();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $this->call->view('user_form', [
                'title' => 'Create User',
                'action' => '/users/store',
                'user' => $data,
                'errors' => $errors,
            ]);
            return;
        }

        $this->UsersModel->insert($data);
        $this->response->redirect_after_post('/');
    }

    public function edit($id)
    {
        $user = $this->UsersModel->find((int) $id);

        if (empty($user)) {
            $this->response->redirect('/');
        }

        $this->call->view('user_form', [
            'title' => 'Edit User',
            'action' => '/users/update/' . (int) $id,
            'user' => $user,
            'errors' => [],
        ]);
    }

    public function update($id)
    {
        $data = $this->user_data();
        $errors = $this->validate($data);

        if (!empty($errors)) {
            $data['id'] = (int) $id;
            $this->call->view('user_form', [
                'title' => 'Edit User',
                'action' => '/users/update/' . (int) $id,
                'user' => $data,
                'errors' => $errors,
            ]);
            return;
        }

        $this->UsersModel->update((int) $id, $data);
        $this->response->redirect_after_post('/');
    }

    public function delete($id)
    {
        $this->UsersModel->soft_delete((int) $id);
        $this->response->redirect_after_post('/');
    }

    private function user_data()
    {
        return [
            'firstname' => trim((string) $this->request->post('firstname', '')),
            'lastname' => trim((string) $this->request->post('lastname', '')),
            'email' => trim((string) $this->request->post('email', '')),
            'username' => trim((string) $this->request->post('username', '')),
        ];
    }

    private function validate($data)
    {
        $errors = [];

        foreach (['firstname' => 'First name', 'lastname' => 'Last name', 'email' => 'Email', 'username' => 'Username'] as $field => $label) {
            if ($data[$field] === '') {
                $errors[$field] = $label . ' is required.';
            }
        }

        if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Enter a valid email address.';
        }

        return $errors;
    }
}
