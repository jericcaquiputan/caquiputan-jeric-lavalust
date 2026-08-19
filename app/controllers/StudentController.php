<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentController extends Controller
{
    private function studentData()
    {
        return [
            'student_id' => 'MCC2024-01769',
            'name'       => 'Jeric M. Caquiputan',
            'course'     => 'BS Information Technology',
            'year'       => '3rd Year',
            'section'    => '3F6',
            'email'      => 'caquiputanjeric3@gmail.com'
        ];
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Unique access condition for the protected student profile.
        if (isset($_GET['access']) && $_GET['access'] === 'JERIC3F6') {
            $_SESSION['student_access'] = true;
        }

        if (isset($_GET['lock'])) {
            $_SESSION['student_access'] = false;
        }

        $data = $this->studentData();
        $data['access_granted'] = $_SESSION['student_access'] ?? false;
        $data['blocked'] = isset($_GET['blocked']);

        $this->call->view('student_home', $data);
    }

    public function profile()
    {
        $data = $this->studentData();
        $this->call->view('student_profile', $data);
    }
}
