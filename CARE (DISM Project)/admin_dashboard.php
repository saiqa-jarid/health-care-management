<?php
session_start();
include "conn.php";

if (!isset($_SESSION['user']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Font Awsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="css/admin_layout.css">
    <!-- <link rel="stylesheet" href="css/admin_dashboard.css"> -->

</head>

<body>

    <div class="admin-container">

        

        <?php include "admin_sidebar.php"; ?>

        <!-- HAMBURGER -->
        <!-- <div class="hamburger" onclick="toggleSidebar()">☰</div> -->

        <div class="main-content">

            <div class="content-area">


                <h2>Welcome Admin: <?php echo $_SESSION['user']; ?></h2>

                <div class="card">
                    <h4>Health Care Services</h4>
                    <p>Admin Control Panel</p>
                </div>

            </div>
        </div>
    </div>

    <?php include "admin_footer.php"; ?>

    <!-- <script>
                function toggleSidebar() {
                    document.getElementById("sidebar").classList.toggle("active");
                }
            </script> -->
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>