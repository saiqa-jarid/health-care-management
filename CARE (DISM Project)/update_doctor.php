<?php
include "conn.php";

// GET ID
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID missing");
}

// GET OLD DATA
$query = "SELECT * FROM doctors WHERE doctor_id = $id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Doctor not found");
}

// UPDATE DATA
if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $city_id = $_POST['city_id'];
    $experience = $_POST['experience'];
    $profile = $_POST['profile'];

    // IMAGE UPDATE (optional)
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $imageName = time() . "_" . $image;
        move_uploaded_file($tmp, "uploads/doctors/" . $imageName);

        $update = "UPDATE doctors SET 
            name='$name',
            email='$email',
            phone='$phone',
            specialization='$specialization',
            city_id='$city_id',
            experience='$experience',
            profile='$profile',
            image='$imageName'
            WHERE doctor_id = $id";
    } else {
        $update = "UPDATE doctors SET 
            name='$name',
            email='$email',
            phone='$phone',
            specialization='$specialization',
            city_id='$city_id',
            experience='$experience',
            profile='$profile'
            WHERE doctor_id = $id";
    }

    if (mysqli_query($conn, $update)) {
        header("Location: update_doctor.php?id=$id&success=1");
        exit();
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
    <title>Update Doctor</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="css/admin_layout.css">
    <!-- <link rel="stylesheet" href="update_doctor.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <div class="admin-container">
        <?php include "admin_sidebar.php"; ?>
        <div class="main-content">

            <div class="content-area">

                <!-- HEADER -->
                <div class="header">
                    <h2> Doctors Management </h2>
                    <p>Edit doctor details</p>
                </div>

                <div class="card">

                    <form method="POST" enctype="multipart/form-data" class="form-box">

                        <h2>Update Doctor</h2>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="<?= $data['name']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" value="<?= $data['email']; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" value="<?= $data['phone']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Specialization</label>
                                <input type="text" name="specialization" value="<?= $data['specialization']; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>City</label>
                                <select name="city_id" required>
                                    <option value="">Select City</option>
                                    <?php
                                    $cityQuery = "SELECT * FROM cities";
                                    $cityResult = mysqli_query($conn, $cityQuery);

                                    while ($city = mysqli_fetch_assoc($cityResult)) {
                                    ?>
                                        <option value="<?= $city['city_id']; ?>"
                                            <?= ($city['city_id'] == $data['city_id']) ? "selected" : "" ?>>
                                            <?= $city['city_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Experience (Years)</label>
                                <input type="text" name="experience" value="<?= $data['experience']; ?>" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Profile</label>
                                <input type="text" name="profile" value="<?= $data['profile']; ?>" required>
                            </div>
                        </div>

                        <p><strong>Current Image:</strong></p>
                        <img src="uploads/doctors/<?= $data['image']; ?>" width="80">

                        <div class="form-row">
                            <div class="form-group" style="width:100%;">
                                <label>Change Image</label>
                                <input type="file" name="image">
                            </div>
                        </div>

                        <button type="submit" name="update" class="btn add">
                            <i class="fa fa-save"></i> Update Doctor
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>

            <?php
            include "admin_footer.php";
            ?>

            <!-- Toast Message -->
            <div id="toast" class="toast">Doctor updated successfully ✅</div>

            <script>
                <?php if (isset($_GET['success'])) { ?>
                    window.onload = function() {
                        let toast = document.getElementById("toast");
                        toast.style.display = "block";

                        setTimeout(() => {
                            // toast.style.display = "none";
                            window.location = "manage_doctors.php";
                        }, 2000);
                    }
                <?php } ?>
            </script>
            <script>
                function toggleSidebar() {
                    document.getElementById("sidebar").classList.toggle("active");
                }
            </script>

</body>

</html>