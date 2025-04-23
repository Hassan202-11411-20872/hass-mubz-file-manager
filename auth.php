<?php
require_once __DIR__ . '/config.php';

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

function login(string $email, string $password): bool {
    $pdo = getPDO();
    
    $stmt = $pdo->prepare("SELECT id, name, password_hash FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['logged_in'] = true;
        return true;
    }
    
    return false;
}

function register(string $name, string $email, string $password): int {
    $pdo = getPDO();
    
    // Validate email uniqueness first
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        throw new RuntimeException("Email already registered");
    }
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password_hash]);
        return (int)$pdo->lastInsertId();
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
        throw new RuntimeException("Registration failed. Please try again.");
    }
}