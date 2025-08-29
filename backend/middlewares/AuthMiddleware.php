<?php
// backend/middlewares/AuthMiddleware.php

class AuthMiddleware {
    public function handle() {
        if (!Session::isLoggedIn()) {
            $router = new Router();
            $router->redirect('/login');
            return false;
        }
        return true;
    }
}

class AdminMiddleware {
    public function handle() {
        if (!Session::isLoggedIn()) {
            $router = new Router();
            $router->redirect('/login');
            return false;
        }

        $user = Session::getUser();
        if ($user['role'] !== 'admin') {
            $router = new Router();
            $router->redirect('/dashboard');
            return false;
        }

        return true;
    }
}

class GuestMiddleware {
    public function handle() {
        if (Session::isLoggedIn()) {
            $router = new Router();
            $router->redirect('/dashboard');
            return false;
        }
        return true;
    }
}