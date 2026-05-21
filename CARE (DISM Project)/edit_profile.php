<?php
session_start();
include "conn.php";

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'doctor') {
    header("Location: doctor_profile.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch doctor data
$query = "SELECT * FROM doctors WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);
$doctor = mysqli_fetch_assoc($result);

// UPDATE
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $city_id = $_POST['city_id'];
    $experience = $_POST['experience'];
    $profile = $_POST['profile'];

    $image = $doctor['image']; // default old image

    // IMAGE UPLOAD
    if (!empty($_FILES['image']['name'])) {
        $file_name = time() . "_" . $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $folder = "uploads/doctors/" . $file_name;

        move_uploaded_file($tmp_name, $folder);

        $image = $file_name;
    }

    $update = "UPDATE doctors SET 
        name='$name',
        phone='$phone',
        specialization='$specialization',
        city_id='$city_id',
        experience='$experience',
        profile='$profile',
        image='$image'
        WHERE user_id='$user_id'";

    $success = false;

    if (mysqli_query($conn, $update)) {
        $success = true;
    } else {
        echo "Update Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/doctor_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="layout">

        <?php include "doctor_sidebar.php"; ?>

        <div class="main-content">

            <!-- <div class="header">
                <h3>Edit Profile</h3>
            </div> -->
            <?php include "doctor_header.php"; ?>

            <div class="dashboard">

                <div class="form-box">

                    <h2>✏️ Edit Profile</h2>

                    <form method="POST" enctype="multipart/form-data">

                        <!-- CURRENT IMAGE -->
                        <div style="text-align:center;">
                            <?php if (!empty($doctor['image'])) { ?>
                                <img src="uploads/doctors/<?= $doctor['image'] ?>" style="width:100px;height:100px;border-radius:50%;object-fit:cover;">
                            <?php } else { ?>
                                <img src="uploads/doctors/default.png" style="width:100px;height:100px;border-radius:50%;">
                            <?php } ?>
                        </div>

                        Change Image:
                        <input type="file" name="image">

                        Name:
                        <input type="text" name="name" value="<?= $doctor['name'] ?>" required>

                        Phone:
                        <input type="text" name="phone" value="<?= $doctor['phone'] ?>" required>

                        Specialization:
                        <input type="text" name="specialization" value="<?= $doctor['specialization'] ?>" required>

                        City:
                        <select name="city_id" required>
                            <?php
                            $cities = mysqli_query($conn, "SELECT * FROM cities");
                            while ($row = mysqli_fetch_assoc($cities)) {
                            ?>
                                <option value="<?= $row['city_id'] ?>"
                                    <?= ($row['city_id'] == $doctor['city_id']) ? 'selected' : '' ?>>
                                    <?= $row['city_name'] ?>
                                </option>
                            <?php } ?>
                        </select>

                        Experience:
                        <input type="text" name="experience" value="<?= $doctor['experience'] ?>">

                        Qualification:
                        <input type="text" name="profile" value="<?= $doctor['profile'] ?>">

                        <button name="update">Update Profile</button>
                    </form>

                    <a href="doctor_profile.php">⬅ Back to Profile</a>

                </div>

            </div>

            <?php include "doctor_footer.php"; ?>

        </div>

    </div>

    <!-- Toast Message -->
    <?php if (isset($success) && $success): ?>
        <div id="toast" class="toast">
            ✅ Profile updated successfully!
        </div>
    <?php endif; ?>


    <script>
        // Toast Message
        document.addEventListener("DOMContentLoaded", function() {

            const toast = document.getElementById("toast");

            if (toast) {
                // show animation
                setTimeout(() => {
                    toast.classList.add("show");
                }, 100);

                // redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = "doctor_profile.php";
                }, 2000);
            }

        });
    </script>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>