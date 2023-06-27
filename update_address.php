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

   $address = $_POST['street'].', No. '.$_POST['building'].', RT.'.$_POST['rt'].'/ RW.'.$_POST['rw'].', '.$_POST['region'] .', '. $_POST['city'] .' - '. $_POST['pos_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'address saved!';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Address</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form action="" method="post">
      <h3>your address</h3>
      <input type="text" class="box" placeholder="building no." required maxlength="50" name="building">
      <input type="number" class="box" placeholder="RT" required max="999999" min="0" maxlength="6" name="rt">
      <input type="number" class="box" placeholder="RW" required max="999999" min="0" maxlength="6" name="rw">
      <input type="text" class="box" placeholder="street name" required maxlength="50" name="street">
      <input type="text" class="box" placeholder="region name" required maxlength="50" name="region">
      <input type="text" class="box" placeholder="city name" required maxlength="50" name="city">
      <input type="number" class="box" placeholder="pos code" required max="999999" min="0" maxlength="6" name="pos_code">
      <input type="submit" value="save address" name="submit" class="btn">
   </form>

</section>



<?php include 'components/footer.php' ?>


<script src="js/script.js"></script>

</body>
</html>