<?php
include "conn.php"; 
include 'header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Medical Encyclopedia</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
   <link rel="stylesheet" href="css/nav-foot.css">
    <link rel="stylesheet" href="css/diseases.css">
   
</head>
<body>

<section class="diseases">
   <h1 class="heading"> Medical <span>Encyclopedia</span> </h1>

   <div class="box-container">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM diseases ORDER BY disease_id DESC");
         while($row = mysqli_fetch_assoc($select)){
            // rawurlencode isliye use kiya taaki brackets aur space URL mein masla na karein
            $image_name = $row['image'];
            $image_path = "uploads/diseases/". $image_name;
      ?>
      <div class="box">
         <div class="image-container">
            <img src="<?php echo $image_path; ?>" 
                 alt="Disease Info" 
                 onerror="this.src='https://cdn-icons-png.flaticon.com/512/2864/2864273.png';">
         </div>
         
         <h3><?php echo $row['name']; ?></h3>
         
         <div class="content">
            <p><b>Symptoms:</b> <?php echo $row['symptoms']; ?></p>
            <p><b>Prevention:</b> <?php echo $row['prevention']; ?></p>
            <p><b>Treatment:</b> <?php echo $row['cure']; ?></p>
         </div>
      </div>
      <?php } ?>
   </div>
</section>
<?php
include "footer.php";
?>

<script src="js/script.js"></script>
</body>
</html>