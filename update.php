<?php
   @include 'lib/db_product.php';

   $id = $_GET['edit'];

   if(isset($_POST['update_product'])){
      $product_name = $_POST['product_name'];
      $product_price = $_POST['product_price'];
      $product_image = $_FILES['product_image']['name'];
      $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
      $product_image_folder = 'uploaded_img/'.$product_image;
      if(empty($product_name) || empty($product_price) || empty($product_image)){
         $message[] = 'Vui lòng điền đầy đủ thông tin!!';
      }
      else{
         $update_data = "UPDATE products SET name='$product_name', price='$product_price', image='$product_image'  WHERE id = '$id'";
         $upload = mysqli_query($conn, $update_data);
         if($upload){
            move_uploaded_file($product_image_tmp_name, $product_image_folder);
            header('location:manage.php');
         }
         else{
            $message[] = 'Vui lòng điền đầy đủ thông tin!';
         }
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
   <div class="admin-product-form-container centered">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
      while($row = mysqli_fetch_assoc($select)){
   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
      <h3 class="title">CẬP NHẬT SẢN PHẨM</h3>
      <input type="text" class="box" name="product_name" value="<?php echo $row['name']; ?>" placeholder="Nhập tên sản phẩm">
      <input type="number" min="0" class="box" name="product_price" value="<?php echo $row['price']; ?>" placeholder="Nhập giá sản phẩm">
      <input type="file" class="box" name="product_image"  accept="image/png, image/jpeg, image/jpg">
      <input type="submit" value="CẬP NHẬT SẢN PHẨM" name="update_product" class="btn">
      <a href="manage.php" class="btn">QUAY VỀ</a>
   </form>
   
   <?php 
      }; 
   ?>


</div>
</div>
</body>
</html>