<?php
    session_start();
    require_once("lib/db_login.php");

    $message = '';

    if (isset($_POST["btn_submit"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $username = strip_tags($username);
        $username = addslashes($username);
        $password = strip_tags($password);
        $password = addslashes($password);

        if ($username == "" || $password == "") {
            $message = "Username hoặc password không được để trống!";
        } 
        
        else {
            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $query = mysqli_query($conn, $sql);

            if (!$query) {
                die('Query Failed: ' . mysqli_error($conn));
            }

            $num_rows = mysqli_num_rows($query);

            if ($num_rows == 0) {
                $message = "<strong style='font-size: x-small; font-weight: bold;'>Tên đăng nhập hoặc mật khẩu không đúng!</strong>";
            }
            
            else {
                $user = mysqli_fetch_assoc($query);
                
                // Chuyển hướng đến trang Sản phẩm
                $_SESSION['username'] = $username;
                header('Location: manage.php');
                exit;
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="container">
        <h2>ĐĂNG NHẬP</h2>

        <!-- FORM -->
        <form method="POST" action="login.php">
            
            <!-- USERNAME -->
            <label for="username">
                <strong>
                    Tài khoản:
                </strong>
            </label>
            <input type="text" id="username" name="username" required>
        
            <!-- PASSWORD -->
            <label for="password">
                <strong>
                    Mật khẩu:
                </strong>
            </label>
            <input type="password" id="password" name="password" required>
        
            <!-- Button -->
            <input type="submit" name="btn_submit" value="Đăng nhập">

        </form>

        <!-- Link to Sign Up -->
        <div class="register-link">
            <p> 
                Chưa có tài khoản? 
                <a href="register.php">
                    Tạo tài khoản mới
                </a>
            </p>
        </div>

        <!-- Thông báo "Tên đăng nhập hoặc mật khẩu không đúng!" -->
        <div class="error">
            <?php 
                echo $message; 
            ?>
        </div>
        
        <!-- Thông báo tự động ẩn sau 4 giây -->
        <script>
            // Kiểm tra xem có thông báo không
            var errorMessage = document.querySelector('.error');

            if (errorMessage) {
                // Thiết lập hàm để ẩn thông báo sau một khoảng thời gian
                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 4000); // 4000 milliseconds = 4 seconds (giây)
            }
        </script>

    </div>
    
</body>
</html>