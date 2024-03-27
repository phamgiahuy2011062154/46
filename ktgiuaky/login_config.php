<?php
session_start();
include ('config.php');

$username = $_POST['username'];
$password = $_POST['password'];

// Kiểm tra tài khoản trong cơ sở dữ liệu
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Lưu thông tin người dùng vào session
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['username'] = $row['username'];
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['role'] = $row['role'];

    // Chuyển hướng đến trang tương ứng với vai trò
    if ($row['role'] == 'admin') {
        header("Location: index_admin.php");
    } else {
        header("Location: index.php");
    }
} else {
    // Đăng nhập không thành công
    header("Location: login.php");
}
?>