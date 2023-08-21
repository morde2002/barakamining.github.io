<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $weight = $_POST['weight'];
   $weight = filter_var($weight, FILTER_SANITIZE_STRING);

   $shapes = $_POST['shapes'];
   $shapes = filter_var($shapes, FILTER_SANITIZE_STRING);

   $clarity = $_POST['clarity'];
   $clarity = filter_var($clarity, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;


   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, weight, shapes, price, clarity, image_01) VALUES(?,?,?,?,?,?)");
      $insert_products->execute([$name, $weight, $shapes, $price, $clarity, $image_01]);

      if($insert_products){
         if($image_size_01 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            $message[] = 'new product added!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>Weight (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="Gem's Weight" name="weight">
         </div>

         <div class="inputBox">
            <span>shapes (optional)</span>
            <input type="text" class="box" placeholder="e.g. Antique,Baguette,Cushion,Emerald Cut, Heart e.t.c" name="shapes">
         </div>
      
        <div class="inputBox">
         <span>Clarity (required)</span>
          <select type="text" class="box" name="clarity" required>
            <option value="Any">Any</option>
            <option value="Loupe-Clean">Loupe-Clean</option>
            <option value="Eye-Clean">Eye-Clean</option>
            <option value="PK1">PK1</option>
            <option value="PK2">PK2</option>
            <option value="Cabouchon">Cabouchon</option>
          </select>
        </div>

        <div class="inputBox">
         <span>Select Price range (required)</span>
          <select class="box" name="price" required>
            <option value="under-Ksh500">Under KSh500</option>
            <option value="500-1K">Ksh500-Ksh1,000</option>
            <option value="1k-2k">Ksh1,000 - Ksh2,000</option>
            <option value="2k-5k">Ksh2,000 - Ksh5,000</option>
            <option value="over-5k">Above Ksh5,000</option>
          </select><br>
        </div>
         
        <div class="inputBox">
            <span>image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">products added</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="weight"><?= $fetch_products['weight']; ?></div>
      <div class="shapes"><?= $fetch_products['shapes']; ?></div>
      <div class="price">$<span><?= $fetch_products['price']; ?></span>/-</div>
      <div class="clarity"><?= $fetch_products['clarity']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
   
   </div>

</section>








<script src="../js/admin_script.js"></script>
   
</body>
</html>