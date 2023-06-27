<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_coupon'])){

   $coupon_code = $_POST['coupon_code'];
   $coupon_code = filter_var($coupon_code, FILTER_SANITIZE_STRING);
   $discount = $_POST['discount'];
   $discount = filter_var($discount, FILTER_SANITIZE_STRING);
   $imageC = $_FILES['imageC']['name'];
   $imageC = filter_var($imageC, FILTER_SANITIZE_STRING);
   $imageC_size = $_FILES['imageC']['size'];
   $imageC_tmp_name = $_FILES['imageC']['tmp_name'];
   $imageC_folder = '../uploaded_img/'.$imageC;
   $select_coupon = $conn->prepare("SELECT * FROM `coupon` WHERE coupon_code = ?");
   $select_coupon->execute([$coupon_code]);


   if($select_coupon->rowCount() > 0){
      $message[] = 'coupon already exists!';
   }else{
      if($imageC_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($imageC_tmp_name, $imageC_folder);

         $insert_coupon = $conn->prepare("INSERT INTO `coupon`(coupon_code, discount, imageC) VALUES(?,?,?)");
         $insert_coupon ->execute([$coupon_code, $discount, $imageC]);

         $message[] = 'new coupon added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_coupon_id = $_GET['delete'];
   $delete_product_imageC = $conn->prepare("SELECT * FROM `coupon` WHERE coupon_id = ?");
   $delete_product_imageC->execute([$delete_coupon_id]);
   $fetch_delete_imageC = $delete_product_imageC->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_imageC['imageC']);
   $delete_coupon = $conn->prepare("DELETE FROM `coupon` WHERE coupon_id = ?");
   $delete_coupon->execute([$delete_coupon_id]);
   header('location:coupon.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Coupon</title>


   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>


<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add coupon</h3>
      <input type="text" required placeholder="enter coupon code" name="coupon_code" maxlength="100" class="box">
      <input type="number" min="0" max="9999999999" required placeholder="enter coupon discount" name="discount" onkeypress="if(this.value.length == 10) return false;" class="box">

      <input type="file" name="imageC" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      <input type="submit" value="add coupon" name="add_coupon" class="btn">
   </form>

</section>

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_coupon = $conn->prepare("SELECT * FROM `coupon`");
      $show_coupon->execute();
      if($show_coupon->rowCount() > 0){
         while($fetch_coupon = $show_coupon->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_coupon['imageC']; ?>" alt="">
      <div class="flex">
         <div class="discount"><span></span><?= $fetch_coupon['discount']; ?><span>%</span></div>
      </div>
      <div class="coupon_code"><?= $fetch_coupon['coupon_code']; ?></div>
      <br>
      <div class="flex-btn">
 
         <a href="coupon.php?delete=<?= $fetch_coupon['coupon_id']; ?>" class="delete-btn" onclick="return confirm('delete this coupon?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no coupon added yet!</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>