<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
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

   $update_product = $conn->prepare("UPDATE `products` SET name = ?, price = ?, weight = ? shapes = ?, clarity = ? WHERE id = ?");
   $update_product->execute([$name, $price, $weight, $shapes, $clarity, $pid]);

   $message[] = 'product updated successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `products` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'image 01 updated successfully!';
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
   <title>update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
         </div>
      </div>
      <span>update name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
         <select class="box" name="price" required>
            <option value="under-500">Under $500</option>
            <option value="500-1k">$500-$1,000</option>
            <option value="1k-2k">$1,000 - $2,000</option>
            <option value="2k-5k">$2,000 - $5,000</option>
            <option value="over-5k">Above $5,000</option>
            <option value="other">My own price range</option>
         </select><br>
         <span>Or Enter your own price range option you selected above:</span><br>
         <input type="text" class="box" name="price" size="30" maxlength="30" placeholder="enter product price" value="<?= $fetch_products['price']; ?>">
      <span>update weight</span>
      <textarea name="weight" class="box" required cols="30" rows="10"><?= $fetch_products['weight']; ?></textarea>
      <span>update shapes</span>
      <textarea name="shapes" class="box" required cols="30" rows="10"><?= $fetch_products['shapes']; ?></textarea>
      <span>update clarity</span>
          <select class="box" name="clarity" required <?= $fetch_products['clarity']; ?>>
            <option value="Any">Any</option>
            <option value="Loupe-Clean">Loupe-Clean</option>
            <option value="Eye-Clean">Eye-Clean</option>
            <option value="PK1">PK1</option>
            <option value="PK2">PK2</option>
            <option value="Cabouchon">Cabouchon</option>
          </select>
      <span>update image 01</span>
      <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>