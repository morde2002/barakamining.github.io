<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- 
    - primary meta tags
  -->
  <title>Baraka Mining And Minerals LTD</title>
  <meta name="title" content="Baraka Mining And Minerals LTD">
  <meta name="description" content="This is a Restaurant html template made by codewithsadee">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/hero-slider-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-3.jpg">

</head>

<body id="top">

  <!-- 
    - #PRELOADER
  -->

  




  <!-- 
    - #TOP BAR
  -->

  <div class="topbar">
    <div class="container">

      <address class="topbar-item">
        <div class="icon">
          <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
        </div>

        <span class="span">
          Baraka Mining & Minerals ltd , Voi, Taita Taveta, Kenya
        </span>
      </address>

      <div class="separator"></div>

      <div class="topbar-item item-2">
        <div class="icon">
          <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
        </div>

        <span class="span">Daily : 8.00 am to 10.00 pm</span>
      </div>

      <a href="tel:+254 769411649" class="topbar-item link">
        <div class="icon">
          <ion-icon name="call-outline" aria-hidden="true"></ion-icon>
        </div>

        <span class="span">+254 769 411 649, </span>
      </a>

      <a href="tel:+254 799445800" class="topbar-item link">
        <div class="icon">
          <ion-icon name="call-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">+254 799 445 800</span>
      </a>

      <div class="separator"></div>

      <a href="barakaminingmi4@gmail.com" class="topbar-item link">
        <div class="icon">
          <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>
        </div>

        <span class="span">barakaminingmi4@gmail.com</span>
      </a>

    </div>
  </div>



  <!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <a href="#" class="logo">
        <img src="./assets/images/logo.png" width="280" height="50" alt="Grilli - Home">
      </a>

      <nav class="navbar" data-navbar>

        <button class="close-btn" aria-label="close menu" data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>

        <a href="#" class="logo">
          <img src="./assets/images/logo.png" width="260" height="50" alt="Grilli - Home">
        </a>


        <ul class="navbar-list">

          <li class="navbar-item">
            <a href="index.html" class="navbar-link hover-underline active">
              <div class="separator"></div>

              <span class="span">Home</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="menu.php" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">Gems</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="aboutus.html" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">About Us</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="story.html" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">Story</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="mine.html" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">Mine</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="contact.html" class="navbar-link hover-underline">
              <div class="separator"></div>

              <span class="span">Contacts</span>
            </a>
          </li>

        </ul>



      </nav>

      <a href="#" class="btn btn-secondary">
        <span class="text text-1">Find A Gem</span>

        <span class="text text-2" aria-hidden="true">Find A Gem</span>
      </a>

      <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
        <span class="line line-1"></span>
        <span class="line line-2"></span>
        <span class="line line-3"></span>
      </button>

      <div class="overlay" data-nav-toggler data-overlay></div>

    </div>
  </header>





  <main>
    <article>

      

  <!-- 
    - #ORDER
  -->




  <section class="ordergem">
  
        <h1 class="heading">latest products</h1>
        <div class="box-container">


        
        <?php
          $select_products = $conn->prepare("SELECT * FROM `products`"); 
          $select_products->execute();
          if($select_products->rowCount() > 0){
          while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>

        <form action="" method="post" class="box">
          <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
          <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
          <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
          <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
          <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
          <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
          <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
          <div class="name"><?= $fetch_product['name']; ?></div>
          <div class="flex">
              <div class="price"><span>ksh</span><?= $fetch_product['price']; ?><span>/-</span></div>
              <input type="number" name="qty" class="qty" width="50%" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
          </div>

          <a href="findgem.html" class="btn btn-secondary">
            <span class="text text-1">inquire</span>

            <span class="text text-2" aria-hidden="true">inquire</span>
          </a>

        </form>

        
        <?php
          }
        }else{
          echo '<p class="empty">no products found!</p>';
        }
        ?>
        </div>
        
      </div>
    </form>
        

      </section>




  <!-- 
    - #FOOTER
  -->

  <footer class="footer section has-bg-image text-center"
    style="background-image: url('./assets/images/footer-bg.jpg')">
    <div class="container">

      <div class="footer-top grid-list">

        <div class="footer-brand has-before has-after">

          <a href="#" class="logo">
            <img src="./assets/images/logo.svg" width="160" height="50" loading="lazy" alt="grilli home">
          </a><br>

          <address class="body-4">
            Baraka Mining & Minerals ltd , Voi, Taita Taveta, Kenya
          </address><br>

          <a href="barakaminingmi4@gmail.com" class="body-4 contact-link">barakaminingmi4@gmail.com</a><br>

          <a href="tel:+254 799 445 800" class="body-4 contact-link">Contact Us: +254 799 445 800</a><br>

          <div class="wrapper">
            <div class="separator"></div>
            <div class="separator"></div>
            <div class="separator"></div>
          </div>

          

          

        </div>

        <ul class="footer-list">

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Home</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Gems</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">About Us</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Story</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Mine</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Contact</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Facebook</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Instagram</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Twitter</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Gmail</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Google Map</a>
          </li>

        </ul>

      </div>

      <div class="footer-bottom">

        <p class="copyright">
            &copy; 2023 BARAKA MINING & MINERALS LTD. All Rights Reserved | Crafted by <a href=""
              target="_blank" class="link">xeleratedtech Inc</a>
          </p>

      </div>

    </div>
  </footer>





  <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn active" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
