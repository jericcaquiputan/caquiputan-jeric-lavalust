<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle($next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!($_SESSION['student_access'] ?? false)) {
            header('Location: ' . site_url('student') . '?blocked=1');
            exit;
        }

        return $next();
    }
}
