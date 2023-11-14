<!-- Kết nối đến CSDL -->
<?php

        // Tài khoản và mật khẩu truy cập phpMyAdmin
    $server_username = "root";
    $server_password = "";

        // Máy chủ
    $server_host = "localhost";

        // Tên CSDL
    $database = 'b2013908';

        // Kết nối CSDL
    $conn = mysqli_connect($server_host,$server_username,$server_password,$database); 
    // Hoặc: $conn = mysqli_connect($server_host,$server_username,$server_password,$database) or die("không thể kết nối tới database");

        // Thiết lập bảng mã Unicode
    mysqli_query($conn,"SET NAMES 'UTF8'");
?>