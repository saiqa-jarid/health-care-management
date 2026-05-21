<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!-- <head>
    <title>Health Care System</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
</head> -->

<!-- PRELOADER -->
<section class="preloader">
    <div class="spinner">
        <span class="spinner-rotate"></span>
    </div>
</section>

<!-- TOP HEADER -->
<header>
    <div class="container">
        <div class="row">

            <div class="col-md-4 col-sm-6">
                <p>Welcome to a Professional Health Care</p>
            </div>

            <div class="col-md-8 col-sm-6 text-align-right">
                <span><i class="fa fa-phone"></i> 0323-1234567</span>
                <span><i class="fa fa-calendar-plus-o"></i> 24 / 7</span>
                <span><i class="fa fa-envelope-o"></i> care@company.com</span>
            </div>

        </div>
    </div>
</header>

<!-- NAVBAR -->
<section class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">

        <div class="navbar-header">
            <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
                <span class="icon icon-bar"></span>
            </button>

            <!-- LOGO -->
            <a href="index.php" class="navbar-brand">
                <i class="fa fa-h-square"></i>ealth Care
            </a>
        </div>

        <!-- MENU -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">

                <li><a href="index.php#top">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="doctor_display.php">Doctors</a></li>
                <li><a href="newsdisplay.php">News</a></li>
                <li><a href="diseases.php">Diseases</a></li>
                <li><a href="appointment_booking.php">Book Appointment</a></li>
                <li><a href="contact.php">Contact</a></li>

                <?php if(!isset($_SESSION['user'])){ ?>

                    <!-- LOGIN DROPDOWN -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Login <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a href="p_login.php">Patient Login</a></li>
                            <li><a href="d_login.php">Doctor Login</a></li>
                            <li><a href="a_login.php">Admin Login</a></li>
                        </ul>
                    </li>

                    <!-- REGISTER -->
                    <li class="appointment-btn">
                        <a href="p_register.php">Register</a>
                    </li>

                <?php } else { ?>

                    <!-- DASHBOARD BASED ON ROLE -->
                    <?php if($_SESSION['role'] == 'patient'){ ?>
                        <li><a href="patient_dashboard.php">Dashboard</a></li>
                    <?php } elseif($_SESSION['role'] == 'doctor'){ ?>
                        <li><a href="doctor_dashboard.php">Dashboard</a></li>
                    <?php } elseif($_SESSION['role'] == 'admin'){ ?>
                        <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <?php } ?>

                    <!-- USER NAME -->
                    <li>
                        <a href="#">👤 <?php echo $_SESSION['user']; ?></a>
                    </li>

                    <!-- LOGOUT -->
                    <li class="appointment-btn">
                        <a href="logout.php">Logout</a>
                    </li>

                <?php } ?>

            </ul>
        </div>

    </div>
</section>