<?php
require_once 'config.php';
session_start();

function register_user($username, $password, $full_name = '', $role = 'pharmacist') {
    global $pdo;
  
    if (trim($username) === '' || trim($password) === '') {
        return ['success' => false, 'message' => 'Username and password are required.'];
    }
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :u");
    $stmt->execute([':u' => $username]);
    if ($stmt->fetch()) {
        return ['success' => false, 'message' => 'Username already taken.'];
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, full_name, role) VALUES (:u, :p, :fn, :r)");
    $stmt->execute([':u' => $username, ':p' => $hash, ':fn' => $full_name, ':r' => $role]);
    return ['success' => true, 'message' => 'Registration successful.'];
}

function login_user($username, $password) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :u LIMIT 1");
    $stmt->execute([':u' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        return ['success' => false, 'message' => 'Invalid username or password.'];
    }
    if (!password_verify($password, $user['password_hash'])) {
        return ['success' => false, 'message' => 'Invalid username or password.'];
    }
    
    $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'username' => $user['username'],
        'full_name' => $user['full_name'],
        'role' => $user['role']
    ];
    return ['success' => true, 'message' => 'Logged in'];
}

function require_login() {
    if (empty($_SESSION['user'])) {
      
        header('Location: login.php');
        exit;
    }
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function logout_user() {
   
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
