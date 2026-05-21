<?php
session_start();
include "conn.php";

// ✅ sirf doctor login allowed
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'doctor') {
    header("Location: login.php");
    exit();
}

// ✅ user id lo
$user_id = $_SESSION['user_id'];

// ✅ doctor data fetch (city join ke sath)
$query = "SELECT doctors.*, cities.city_name 
          FROM doctors 
          LEFT JOIN cities ON doctors.city_id = cities.city_id
          WHERE doctors.user_id = $user_id
          LIMIT 1";

$result = mysqli_query($conn, $query);

// ✅ error check
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

// ✅ agar record nahi mila
if (mysqli_num_rows($result) == 0) {
    echo "Doctor profile not found";
    exit();
}

$doctor = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/doctor_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>

    <div class="layout">

        <?php include "doctor_sidebar.php"; ?>

        <div class="main-content">

            <!-- <div class="header">
                <h3>Doctor Profile</h3>
            </div> -->
            <?php include "doctor_header.php"; ?>

            <div class="dashboard">
                <div class="profile-box">

                    <!-- IMAGE -->
                    <?php if (!empty($doctor['image'])) { ?>
                        <img src="uploads/doctors/<?= $doctor['image'] ?>">
                    <?php } else { ?>
                        <img src="uploads/doctors/default.png">
                    <?php } ?>

                    <h2><?= htmlspecialchars($doctor['name']) ?></h2>

                    <p><b>Email:</b> <?= htmlspecialchars($doctor['email']) ?></p>
                    <p><b>Phone:</b> <?= htmlspecialchars($doctor['phone']) ?></p>
                    <p><b>Specialization:</b> <?= htmlspecialchars($doctor['specialization']) ?></p>
                    <p><b>City:</b> <?= htmlspecialchars($doctor['city_name']) ?></p>
                    <p><b>Experience:</b> <?= $doctor['experience'] ?> years</p>
                    <p><b>Qualification:</b> <?= htmlspecialchars($doctor['profile']) ?></p>

                    <a href="edit_profile.php" class="btn edit">✏ Edit Profile</a>
                    <a href="doctor_dashboard.php" class="btn back">⬅ Back</a>

                </div>
            </div>

            <?php include "doctor_footer.php"; ?>

        </div>

    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>