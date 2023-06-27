<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $note = $_POST['note'];
   $note = filter_var($note, FILTER_SANITIZE_STRING);
   $PlateNumber = $_POST['PlateNumber'];
   $PlateNumber = filter_var($PlateNumber, FILTER_SANITIZE_STRING);
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   date_default_timezone_set('Asia/Jakarta');
   $jam_pendaftaran=$_POST['jam_pendaftaran'];

// $cek = mysql_query("SELECT* FROM orders WHERE jam_pendaftaran = '$jam_pendaftaran'");
// $htg = mysql_fetch_array($cek);
   
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message = 'Please add your address!';
      }else{
         $coupon_code = $_POST['coupon_code'];
         $coupon_code = filter_var($coupon_code, FILTER_SANITIZE_STRING);

         $check_coupon = $conn->prepare("SELECT * FROM `coupon` WHERE coupon_code = ?");
         $check_coupon->execute([$coupon_code]);

         if ($check_coupon->rowCount() > 0) {
            $coupon_data = $check_coupon->fetch(PDO::FETCH_ASSOC);
            $discount = $coupon_data['discount'];
            $total_price -= ($total_price * $discount / 100);

            $message = 'Discount applied successfully!';
         } else {
            $message = 'Invalid coupon code!';
         }
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, note, jam_pendaftaran, PlateNumber) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $note,$jam_pendaftaran, $PlateNumber]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message = 'Order placed successfully!';
      }
      
   }else{
      $message = 'Your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="heading">
   <h3>Checkout</h3>
   <p><a href="home.php">Home</a> <span> / Checkout</span></p>
</div>

<section class="checkout">

   <h1 class="title">Order Summary</h1>

   <form action="" method="post">

      <div class="cart-items">
         <h3>Detail Transaksi</h3>
         <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if($select_cart->rowCount() > 0){
               while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                  $cart_items[] = $fetch_cart['name'].$fetch_cart['price'];
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['price'] * 1);
         ?>
         <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">Rp.<?= $fetch_cart['price']; ?></span></p>
         <?php
               }
            }else{
               echo '<p class="empty">Your cart is empty!</p>';
            }
         ?>
         <p class="grand-total"><span class="name">Grand Total:</span><span class="price">Rp.<?= $grand_total; ?></span></p>
         <br>
         <input type="text" name="coupon_code" placeholder="Enter coupon code">
         
      </div>

      <input type="hidden" name="total_products" value="<?= $total_products; ?>">
      <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
      <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
      <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
      <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
      <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">


      <div class="user-info">
      <h3>your info</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a href="update_profile.php" class="btn">update info</a>
      <h3>Service Poin</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
      <a href="update_address.php" class="btn">update address</a>
      <h3>more info</h3>
      <h2>Plate Number</h2>
      <input type="text" required placeholder="enter Plate Number" name="PlateNumber" maxlength="100" class="box">
      <h2>Booking Time [08:00 s/d 18:00] </h2>
      <input type="time" required placeholder="enter time" class="box" id="email" name="jam_pendaftaran" min="08:00:00" max="18:00:00" required="">
      <h2>Note</h2>
      <input type="text" required placeholder="enter note" name="note" maxlength="100" class="box">
      <h2>Payment</h2>
      <select name="method" class="box" required>
         <option value="" disabled selected>select payment method --</option>
         <option value="Cash">Cash</option>
         <option value="Virtual Account">Virtual Account</option>
      </select>


      <input type="submit" value="place order" class="btn <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

   </form>
   
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>



