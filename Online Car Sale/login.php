<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM sellers WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['seller_id'] = $user['seller_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: add-car.php");
                exit();
            } else {
                echo "<script>alert('Incorrect password'); window.location.href='login.html';</script>";
            }
        } else {
            echo "<script>alert('Username not found. Please register.'); window.location.href='register.html';</script>";
        }
    } catch(PDOException $e) {
        echo "<script>alert('System error. Please try again later.'); window.location.href='login.html';</script>";
    }
} else {
    header("Location: login.html");
    exit();
}
?>