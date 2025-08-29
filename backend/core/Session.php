<?php
// backend/core/Session.php

class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            $config = require __DIR__ . '/../config/config.php';

            session_name($config['session']['name']);
            ini_set('session.gc_maxlifetime', $config['session']['lifetime']);
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function remove($key) {
        unset($_SESSION[$key]);
    }

    public static function destroy() {
        session_destroy();
        $_SESSION = [];
    }

    public static function flash($key, $value = null) {
        if ($value === null) {
            $value = self::get($key);
            self::remove($key);
            return $value;
        }

        self::set($key, $value);
    }

    public static function isLoggedIn() {
        return self::has('user_id');
    }

    public static function getUser() {
        if (!self::isLoggedIn()) {
            return null;
        }

        $userModel = new User();
        return $userModel->findById(self::get('user_id'));
    }

    public static function login($user) {
        self::set('user_id', $user['id']);
        self::set('user_role', $user['role']);
    }

    public static function logout() {
        self::destroy();
    }
}