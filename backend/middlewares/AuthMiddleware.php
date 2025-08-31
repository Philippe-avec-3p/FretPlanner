<?php
// backend/middlewares/AuthMiddleware.php

class AuthMiddleware {
    public function handle() {
        if (!Session::isLoggedIn()) {
            header('Location: http://localhost/FretPlanner/login');
            exit();
            return false;
        }
        return true;
    }
}

class AdminMiddleware {
    public function handle() {
        if (!Session::isLoggedIn()) {
            header('Location: http://localhost/FretPlanner/login');
            exit();
            return false;
        }

        $user = Session::getUser();
        if ($user['role'] !== 'admin') {
            header('Location: http://localhost/FretPlanner/dashboard');
            exit();
            return false;
        }

        return true;
    }
}

class GuestMiddleware {
    public function handle() {
        if (Session::isLoggedIn()) {
            header('Location: http://localhost/FretPlanner/dashboard');
            exit();
            return false;
        }
        return true;
    }
}