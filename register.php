<?php
    require_once("lib/db_login.php");

    $message = '';

    // Nếu nhấn nút đăng ký
    if (isset($_POST["btn_submit"])) {
        
        $username = $_POST["username"];
        $password = $_POST["pass"];
        $name = $_POST["name"];
        $email = $_POST["email"];

        $username = strip_tags($username);
        $username = addslashes($username);
        $password = strip_tags($password);
        $password = addslashes($password);

        // TH: Để trống thông tin
        if ($username == "" || $password == "" || $name == "" || $email == "") {
            $message = "Vui lòng nhập đầy đủ thông tin!";
        } 
        
        else {
            $sql = "select * from users where username = '$username'";
            $query = mysqli_query($conn, $sql);
            $num_rows = mysqli_num_rows($query);
            
            
            if ($num_rows > 0) {
                $message = "Tài khoản đã tồn tại!";
            } 
            
            // TH: Đúng dữ liệu (Nếu không yêu cầu các trường hợp, thì chỉ cần đoạn này)
            else {
                // Nếu có yêu cầu mã hóa mật khẩu
                // $hashpw = password_hash($password, PASSWORD_DEFAULT);
                // $sql = "INSERT INTO users(username, password, name, email) VALUES ('$username', '$hashpw', '$name', '$email')";
                
                $sql = "INSERT INTO users(username, password, name, email) VALUES ('$username', '$password', '$name', '$email')";
                
                if (mysqli_query($conn, $sql)) {
                    header('Location: login.php');
                } 
                
                else {
                    $message = "Đăng ký thất bại. Vui lòng thử lại sau.";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        
        <h2>ĐĂNG KÝ</h2>

        <form action="register.php" method="post">
            
        <!-- NHẬP TÀI KHOẢN -->
            <label for="username">
                <strong>
                    Tài khoản:
                </strong>
            </label>
            <input type="text" id="username" name="username" required>

            <!-- NHẬP MẬT KHẨU -->
            <label for="pass">
                <strong>    
                    Mật khẩu:
                </strong>
            </label>
            <input type="password" id="pass" name="pass" required>

            <!-- NHẬP HỌ TÊN -->
            <label for="name">
                <strong>
                    Họ tên:
                </strong></label>
            <input type="text" id="name" name="name" required>

            <!-- NHẬP EMAIL -->
            <label for="email">
                <strong>
                    Email:
                </strong>
            </label>
            <input type="text" id="email" name="email" required>

            <!-- NÚT ĐĂNG KÝ -->
            <input type="submit" name="btn_submit" value="Đăng ký">

        </form>

        <div class="register-link">
            <p>
                <!-- VĂN BẢN HIỂN THỊ -->
                Bạn đã có tài khoản? 

                <!-- CHÈN LIÊN KẾT -->
                <a href="login.php">
                    Đăng nhập
                </a>
            </p>
        </div>

        <div class="error">
            <?php echo $message; ?>
        </div>

    </div>
</body>
</html>