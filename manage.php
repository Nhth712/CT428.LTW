<?php
   @include 'lib/db_product.php';

   // Thêm sản phẩm
   if(isset($_POST['add_product'])){

      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_image = $_FILES['product_image']['name'];
      $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
      $product_image_folder = 'uploaded_img/'.$product_image;

      if(empty($product_name) || empty($product_price) || empty($product_image)){
         $message[] = 'Vui lòng điền đầy đủ thông tin.';
      }
      else{
         $insert = "INSERT INTO products(name, price, image) VALUES('$product_name', '$product_price', '$product_image')";
         $upload = mysqli_query($conn,$insert);
         if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            $message[] = 'Thêm sản phẩm mới thành công!';
         }
         else{
            $message[] = 'Không thể thêm sản phẩm';
         }
      }

   };

   // Xóa sản phẩm
   if(isset($_GET['delete'])){
      $id = $_GET['delete'];
      mysqli_query($conn, "DELETE FROM products WHERE id = $id");
      header('location:manage.php');
   };

   // Quay về trang đăng nhập
   if (isset($_POST['logout'])) {
      // Xóa phiên và chuyển hướng về trang login.php
      session_start();
      session_destroy();
      header('Location: login.php');
      exit;
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/product.css">

</head>
<body>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
   
<div class="container">

   <div class="admin-product-form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>THÊM MỘT SẢN PHẨM</h3>
         <input type="text" name="product_name" class="box" placeholder="Nhập tên sản phẩm">
         <input type="number" name="product_price" class="box" placeholder="Nhập giá sản phẩm">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="submit" class="btn" name="add_product" value="THÊM SẢN PHẨM">
      </form>

   </div>

   <?php

   $select = mysqli_query($conn, "SELECT * FROM products");
   
   ?>
   <div class="product-display">
      <table class="product-display-table">
         <thead>
            <tr>
               <th>Image</th>
               <th>Name</th>
               <th>Price</th>
               <th>Action</th>
            </tr>
         </thead>
         <?php while($row = mysqli_fetch_assoc($select)){ ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>$<?php echo $row['price']; ?>/-</td>
            <td>
               <a href="update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> SỬA </a>
               <a href="manage.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> XÓA </a>
            </td>
         </tr>
      <?php } ?>
      </table>
   </div>

   <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <input type="submit" class="btn" name="logout" value="THOÁT">
   </form>

</div>


</body>
</html>