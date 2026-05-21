<?php

include "conn.php";

?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- head -->

<head>
     <title> Home </title>

     <!-- CSS -->
     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/animate.css">
     <link rel="stylesheet" href="css/owl.carousel.css">
     <link rel="stylesheet" href="css/owl.theme.default.min.css">
     <link rel="stylesheet" href="css/index.css">
     <link rel="stylesheet" href="css/tooplate-style.css">
     <link rel="stylesheet" href="css/nav-foot.css">

</head>

<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">




     <?php
     include "header.php";
     ?>


     <!-- ===== HERO SECTION ===== -->
     <section class="hero">
          <video autoplay muted loop>
               <source src="videos/hero.mp4" type="video/mp4">
          </video>
          <div class="hero-overlay">
               <h1>Care That Heals</h1>
               <p>Your health, our priority</p>
          </div>
     </section>




     <!-- ===== HOME ===== -->
     <section id="home" class="slider" data-stellar-background-ratio="0.5">
          <div class="container">
               <div class="row">

                    <!-- ===== CAROUSEL ===== -->
                    <div class="owl-carousel owl-theme">
                         <div class="item item-first">
                              <div class="caption">
                                   <div class="col-md-offset-1 col-md-10">
                                        <h3>Let's make your life happier with</h3>
                                        <h1>Healthy Living</h1>
                                        <a href="doctor_display.php" class="section-btn btn btn-default smoothScroll">Meet Our Doctors</a>
                                   </div>
                              </div>
                         </div>

                         <div class="item item-second">
                              <div class="caption">
                                   <div class="col-md-offset-1 col-md-10">
                                        <h3>Lets work together to live better with a </h3>
                                        <h1>New Lifestyle</h1>
                                        <a href="about.php" class="section-btn btn btn-default btn-gray smoothScroll">More About Us</a>
                                   </div>
                              </div>
                         </div>

                         <div class="item item-third">
                              <div class="caption">
                                   <div class="col-md-offset-1 col-md-10">
                                        <h3>We will guide you achieve</h3>
                                        <h1>Your Health Benefits</h1>
                                        <a href="newsdisplay.php" class="section-btn btn btn-default btn-blue smoothScroll">New Researches</a>
                                   </div>
                              </div>
                         </div>
                    </div>

               </div>
          </div>
     </section>


     <!-- ABOUT -->
     <section id="about">
          <div class="container">
               <div class="row">

                    <div class="col-md-6 col-sm-6">
                         <div class="about-info">
                              <h2 class="wow fadeInUp" data-wow-delay="0.6s">Welcome to Your <i class="fa fa-h-square"></i>ealth Care Center</h2>
                              <div class="wow fadeInUp" data-wow-delay="0.8s">
                                   <p>Our team of experienced and compassionate doctors is always ready to care for you. </p>
                                   <p>We combine modern medical expertise with personalized attention.
                                        Because your well-being deserves nothing but the best</p>
                              </div>
                              <figure class="profile wow fadeInUp" data-wow-delay="1s">
                                   <img src="images/Dr.Azam.jpg" class="img-responsive" alt="">
                                   <figcaption>
                                        <h3>Dr. Azam Ali</h3>
                                        <p>General Principal</p>
                                   </figcaption>
                              </figure>
                         </div>
                    </div>

               </div>
          </div>
     </section>


     <?php
     $query = "SELECT doctors.*, cities.city_name 
          FROM doctors 
          JOIN cities ON doctors.city_id = cities.city_id
          ORDER BY doctors.doctor_id DESC 
          LIMIT 3";

     $result = mysqli_query($conn, $query);
     ?>


     <!-- TEAM -->
     <section id="team" data-stellar-background-ratio="1">
          <div class="container">

               <div class="row">

                    <div class="col-md-6 col-sm-6">
                         <div class="about-info">
                              <h2 class="wow fadeInUp" data-wow-delay="0.1s">Our Doctors</h2>
                         </div>
                    </div>

                    <div class="clearfix"></div>

                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>



                         <div class="col-md-4 col-sm-6">
                              <div class="team-thumb wow fadeInUp" data-wow-delay="0.2s">

                                   <!-- IMAGE (same class, no styling change) -->
                                   <img src="uploads/doctors/<?php echo $row['image']; ?>" class="img-responsive" alt="">

                                   <div class="team-info">
                                        <h3><?php echo $row['name']; ?></h3>
                                        <p><?php echo $row['specialization']; ?></p>

                                        <div class="team-contact-info">
                                             <p><i class="fa fa-graduation-cap"></i> <?php echo $row['profile']; ?></p>
                                             <p><i class="fa fa-map-marker"></i> <?php echo $row['city_name']; ?></p>
                                        </div>
                                   </div>

                              </div>
                         </div>

                    <?php } ?>

               </div>

          </div>
     </section>


     <!-- NEWS -->

     <?php
     $query = "SELECT * FROM news ORDER BY publish_date DESC LIMIT 3";
     $result = mysqli_query($conn, $query);
     ?>

     <section id="news" data-stellar-background-ratio="2.5">
          <div class="container">
               <div class="row">

                    <div class="col-md-12 col-sm-12">
                         <!-- SECTION TITLE -->
                         <div class="section-title wow fadeInUp" data-wow-delay="0.1s">
                              <h2>Latest News</h2>
                         </div>
                    </div>

                    <?php
                    $delay = 0.4; // for animation delay

                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                         <div class="col-md-4 col-sm-6">
                              <div class="news-thumb wow fadeInUp" data-wow-delay="<?= $delay; ?>s">

                                   <a href="news.php?id=<?= $row['news_id']; ?>">
                                        <img src="uploads/news/<?= $row['images']; ?>"
                                             class="img-responsive news-image"
                                             alt="">
                                   </a>

                                   <div class="news-info">

                                        <!-- DATE -->
                                        <span>
                                             <?= date("F d, Y", strtotime($row['publish_date'])); ?>
                                        </span>

                                        <!-- TITLE -->
                                        <h3>
                                             <a href="news-detail.php?id=<?= $row['news_id']; ?>">
                                                  <?= $row['title']; ?>
                                             </a>
                                        </h3>

                                        <!-- CONTENT (SHORT) -->
                                        <p>
                                             <?= substr($row['content'], 0, 100); ?>...
                                        </p>

                                        <!-- AUTHOR -->
                                        <div class="author">
                                             <!-- <img src="images/author-image.jpg" class="img-responsive" alt=""> -->
                                             <div class="author-info">
                                                  <h5><?= $row['author']; ?></h5>
                                                  <p>Author</p>
                                             </div>
                                        </div>

                                   </div>
                              </div>
                         </div>

                    <?php
                         $delay += 0.2; // increase animation delay
                    }
                    ?>

               </div>
          </div>
     </section>





     <!-- GOOGLE MAP -->
     <section id="google-map">
          
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.202049103615!2d67.09503007357476!3d24.92518592800196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb339d021ae1ac7%3A0xe782bed1d92700d8!2sDUA%20home%20health%20care%20services!5e0!3m2!1sen!2s!4v1776951472924!5m2!1sen!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
     </section>


     <?php

     include "footer.php";

     ?>

     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="js/bootstrap.min.js"></script>



</body>

</html>