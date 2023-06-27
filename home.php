<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body >

<?php include 'components/user_header.php'; ?>


<section class="hero">

   <div class="swiper hero-slider">


      <div class="swiper-wrapper">

         <div class="swiper-slide slide">
            <div class="content">
               <h3>Bersihkan Kendaraan Anda dengan Sempurna!</h3>
               <span>Dengan layanan cuci mobil kami, Anda dapat membersihkan kendaraan Anda dengan sempurna dan dengan bangga menampilkan mobil yang bersih dan terawat ke mana pun Anda pergi</span>
               <br>

            </div>
            <div class="image">
               <img src="assetvclean/logoimg1.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <h3>Kami pedull dengan kebersihan mobil Anda</h3>
               <span>Kami menjaga kebersihan dengan serius! Percayakan kebersihan mobil Anda kepada kaml Tim kami yang berdedikasi menggunakan produk dan teknik berkualitas tinggl untuk memberikan perawatan terbaik untuk kendaraan Anda</span>
               <br>
  
            </div>
            <div class="image">
               <img src="assetvclean/logoimg2.png" alt="">
            </div>
         </div>

         <div class="swiper-slide slide">
            <div class="content">
               <h3>Kemudahan dan kenyamanan dalam satu aplikasi</h3>
               <span>Aplikasi kami menggabungkan kemudahan dan kenyamanan dengan mulus Semua yang Anda butuhkan untuk kendaraan Anda dapat diakses dengan mudah melalui platform kami yang mudah digunakan</span>
               <br>

            </div>
            <div class="image">
               <img src="assetvclean/logoimg3.png" alt="">
            </div>
         </div>

      </div>

      <div class="swiper-pagination"></div>

   </div>
</section>


<section class="products">

   <h1 class="title">Service</h1>

   <div class="box-container">

      <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="flex">
      <div class="price"><span>Rp. </span><?= $fetch_products['price']; ?></div>
      </div>
      <div class="keterangan"><?= $fetch_products['keterangan']; ?></div>
      <button type="submit" name="add_to_cart" class="cart-btn">add to cart</button>
   </form>
      <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>

   </div>

</section>


<section class="products">

   <h1 class="title">Coupon Discount</h1>

   <div class="box-container">

      <?php
         $select_coupon = $conn->prepare("SELECT * FROM `coupon` LIMIT 6");
         $select_coupon->execute();
         if($select_coupon->rowCount() > 0){
            while($fetch_coupon = $select_coupon->fetch(PDO::FETCH_ASSOC)){
      ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="coupon_code" value="<?= $fetch_coupon['coupon_code']; ?>">
      <input type="hidden" name="discount" value="<?= $fetch_coupon['discount']; ?>">
      <input type="hidden" name="imageC" value="<?= $fetch_coupon['imageC']; ?>">
      <img src="uploaded_img/<?= $fetch_coupon['imageC']; ?>" alt="">
      <h3><div class="discount"><span></span><?= $fetch_coupon['discount']; ?><span>%</span></div>
      <div class="coupon_code"><span>Code Unik :  </span><?= $fetch_coupon['coupon_code']; ?></div></h3>

   </form>
      <?php
            }
         }else{
            echo '<p class="empty">no Discount added yet!</p>';
         }
      ?>

   </div>

</section>


</section>

<section class="category">

   <h1 class="title">News</h1>

   <div class="box-container">

      <a href="https://www.brin.go.id/news/110469/riset-dan-inovasi-kendaraan-listrik-berkembang-ke-arah-lebih-baik" class="box">
         <img src="assetvclean/messageImage_1686385370267.jpg" alt="">
         <h3>Perkembangan Riset dan Inovasi Kendaraan Listrik Berkembang ke Arah Lebih Baik</h3>
         <p>Perkembangan riset dan inovasi kendaraan listrik terus berjalan ke arah yang lebih baik. Deputi Bidang Kebijakan Pembangunan BRIN....</p>
      </a>

      <a href="https://www.liputan6.com/otomotif/read/4734002/selain-cegah-jamur-ini-manfaat-tak-terduga-cuci-mobil-setelah-kehujanan" class="box">
         <img src="assetvclean/messageImage_1686385706538.jpg" alt="">
         <h3>Selain Cegah Jamur, Ini Manfaat Tak Terduga Cuci Mobil Setelah Kehujanan</h3>
         <p>Curah hujan yang mulai sering turun, membuat pemilik mobil harus lebih ekstra melakukan perawatan. Sebab, air hujan akan memberikan efek negatif terhadap cat mobil jika tidak langsung dicuci dengan air bersih....</p>
      </a>
   </div>

</section>





<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>
<a href="https:/wa.me/6282252636543"  target="_blank" class="whatsapp_float"><i class="fa-brands fa-whatsapp whatsapp-icon"></i></a>
</body>
</html>