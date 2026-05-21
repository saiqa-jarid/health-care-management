<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!-- <div class="admin-container"> -->


    <!-- HAMBURGER -->
        <div class="hamburger" onclick="toggleSidebar()">
            <i class="fa fa-bars"></i>
        </div>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <h3>🏥 Admin</h3>

        <a href="index.php">Home</a>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="manage_cities.php">Cities</a>
        <a href="manage_doctors.php">Doctors</a>
        <a href="manage_patients.php">Patients</a>
        <a href="manage_appointments.php">Appointments</a>
        <a href="manage_news.php">News</a>
        <a href="manage_diseases.php">Diseases</a>

        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- MAIN CONTENT START -->
    <!-- <div class="main-content"> -->