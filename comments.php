<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $Friendliness = $_POST['Friendliness'];
   $Friendliness = filter_var($Friendliness, FILTER_SANITIZE_STRING);
   $Cleanliness = $_POST['Cleanliness'];
   $Cleanliness = filter_var($Cleanliness, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND Cleanliness = ? AND Friendliness = ? AND message = ?");
   $select_message->execute([$name, $email, $Friendliness, $Cleanliness, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'sudah mengirim pesan!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, Friendliness, Cleanliness, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $Friendliness, $Cleanliness, $msg]);

      $message[] = 'pesan berhasil dikirim!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
   

<?php include 'components/user_header.php'; ?>


<div class="heading">
   <h3>Comments and Suggestions</h3>
   <p><a href="home.php">Home</a> <span> / Comments</span></p>
</div>

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="assetvclean/Logo Login Page@2x.png" alt="">
      </div>

      <form action="" method="post">
         <h3>Comments and Suggestions!</h3>
         <h2 style="text-align: left;">Name</h2>
         <input type="text" name="name" maxlength="50" class="box" placeholder="enter your name" required>
         <h2 style="text-align: left;">Email</h2>
         <input type="email" name="email" maxlength="50" class="box" placeholder="enter your email" required>
         <h2 style="text-align: left;">Friendliness[0 s/d 10] </h2>
         <input type="number" class="box" placeholder="Friendliness" required max="10" min="0" maxlength="2" name="Friendliness">
         <h2 style="text-align: left;">Cleanliness[0 s/d 10] </h2>
         <input type="number" class="box" placeholder="Cleanliness" required max="10" min="0" maxlength="2" name="Cleanliness">
         <h2 style="text-align: left;">Comments</h2>
         <textarea name="msg" class="box" required placeholder="enter your Comments" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
<a href="https:/wa.me/6282252636543"  target="_blank" class="whatsapp_float"><i class="fa-brands fa-whatsapp whatsapp-icon"></i></a>
</body>
</html>