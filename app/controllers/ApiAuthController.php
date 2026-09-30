<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ApiAuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->call->library('api');
        $this->call->database();
    }

    public function preflight()
    {
        // The Api library handles OPTIONS and exits in its constructor.
    }

    public function login()
    {
        $this->api->rate_limit(null, 10, 60);
        $input = $this->api->body();
        $username = trim((string) ($input['username'] ?? ''));
        $password = (string) ($input['password'] ?? '');

        if ($username === '' || $password === '') {
            $this->api->respond_error('Username and password are required.', 422);
        }

        $stmt = $this->db->raw(
            'SELECT id, username, password FROM users WHERE username = ? LIMIT 1',
            [$username]
        );
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $matchesHash = $user && password_verify($password, $user['password']);
        $matchesLegacy = $user && hash_equals((string) $user['password'], $password);
        if (!$user || (!$matchesHash && !$matchesLegacy)) {
            $this->api->respond_error('Invalid username or password.', 401);
        }
        if ($matchesLegacy) {
            $this->db->raw(
                'UPDATE users SET password = ? WHERE id = ?',
                [password_hash($password, PASSWORD_DEFAULT), (int) $user['id']]
            );
        }

        $token = $this->api->encode_jwt([
            'sub' => (int) $user['id'],
            'role' => 'user',
        ]);
        $this->api->respond([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => 900,
        ]);
    }

    public function logout()
    {
        $this->api->respond(['message' => 'Logged out.']);
    }
}
