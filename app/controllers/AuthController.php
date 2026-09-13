<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->model('UsersModel');
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['authenticated'])) {
            $this->response->redirect('/products');
            return;
        }

        $this->call->view('login', [
            'error' => '',
            'username' => '',
        ]);
    }

    public function authenticate()
    {
        $username = trim((string) $this->request->post('username', ''));
        $password = (string) $this->request->post('password', '');
        $user = $this->UsersModel->find_by('username', $username);

        $storedPassword = is_array($user) ? ($user['password'] ?? '') : ($user->password ?? '');
        $isActive = is_array($user) ? ($user['is_active'] ?? 1) : ($user->is_active ?? 1);
        $passwordMatches = $storedPassword && password_verify($password, $storedPassword);
        $legacyPasswordMatches = $storedPassword && hash_equals((string) $storedPassword, $password);

        if (!$user || !$isActive || (!$passwordMatches && !$legacyPasswordMatches)) {
            $this->call->view('login', [
                'error' => 'Invalid username or password.',
                'username' => $username,
            ]);
            return;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_regenerate_id(true);
        $_SESSION['authenticated'] = true;
        $_SESSION['user_id'] = (int) (is_array($user) ? ($user['id'] ?? 0) : ($user->id ?? 0));

        if ($legacyPasswordMatches) {
            $this->UsersModel->update($_SESSION['user_id'], ['password' => password_hash($password, PASSWORD_DEFAULT)]);
        }

        $this->response->redirect_after_post('/products');
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();
        $this->response->redirect_after_post('/login');
    }
}
