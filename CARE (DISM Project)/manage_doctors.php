<?php
session_start();
include "conn.php";

// Restrict access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: a_login.php");
    exit();
}


if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $specialization = $_POST['specialization'];
    $city_id = $_POST['city_id'];
    $experience = $_POST['experience'];
    $profile = $_POST['profile'];

    // PASSWORD
    // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);



    // ✅ STEP 1: Insert into users table FIRST
    $userQuery = "INSERT INTO users (username, email, password, role) 
                  VALUES ('$name', '$email', '$hashed_password', 'doctor')";

    mysqli_query($conn, $userQuery);

    // ✅ STEP 2: Get user_id
    $user_id = mysqli_insert_id($conn);

    // IMAGE UPLOAD
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $imageName = time() . "_" . $image;
    move_uploaded_file($tmp, "uploads/doctors/" . $imageName);

    // ✅ STEP 3: Insert doctor WITH correct user_id
    $query = "INSERT INTO doctors 
    (user_id, name, email, phone, specialization, city_id, experience, profile, image)
    VALUES 
    ('$user_id','$name','$email','$phone','$specialization','$city_id','$experience','$profile','$imageName')";

    if (mysqli_query($conn, $query)) {
        header("Location: manage_doctors.php?success=1");
        exit();
    } else {
        echo "Insert Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors - Admin Panel</title>
    <!-- <link rel="stylesheet" href="css/manage_doctors.css"> -->
    <link rel="stylesheet" href="css/admin_layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body>


    <div class="admin-container">
        <?php include "admin_sidebar.php"; ?>
        <div class="main-content">

            <div class="content-area">

                <!-- HEADER -->
                <div class="header">
                    <h2><i class="fa-solid fa-user-doctor"></i> Doctor Management</h2>
                    <p>Manage all registered doctors</p>
                </div>

                <section id="add_doctor">
                    <div class="card">


                        <!-- Add Doctor Section -->
                        <form method="POST" enctype="multipart/form-data" class="form-box">
                            <h2>Add Doctor</h2>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for=""> Name </label>
                                    <input type="text" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for=""> Email </label>
                                    <input type="email" name="email" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for=""> Phone </label>
                                    <input type="text" name="phone" required>
                                </div>
                                <!-- <input type="text" name="specialization" placeholder="Specialization" required> -->
                                <!-- Specialization -->
                                <div class="form-group">
                                    <label for=""> Specialization </label>
                                    <select name="specialization" required>
                                        <option value="">Select Specialization</option>
                                        <option value="General Physician">General Physician</option>
                                        <option value="Cardiologist">Cardiologist</option>
                                        <option value="Pulmonologist">Pulmonologist</option>
                                        <option value="Diabetologist">Diabetologist</option>
                                        <option value="Dermatologist">Dermatologist</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for=""> City </label>
                                    <select name="city_id" required>
                                        <option value="">Select City</option>
                                        <?php
                                        $query = "SELECT * FROM cities";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?php echo $row['city_id']; ?>">
                                                <?php echo $row['city_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for=""> Experience </label>
                                    <input type="text" name="experience" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for=""> Qualification </label>
                                    <input type="text" name="profile" required>
                                </div>

                                <div class="form-group">
                                    <!-- IMAGE -->
                                    <label for=""> Image </label>
                                    <input type="file" name="image" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <!-- password -->
                                    <label for=""> Password </label>
                                    <input type="password" name="password" required>
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" name="confirm_password" required>
                                </div>
                            </div>




                            <button type="submit" name="add" class="btn add">
                                <i class="fa fa-plus"></i>Add Doctor</button>
                        </form>
                    </div>
                </section>



                <?php
                $query = "SELECT doctors.*, cities.city_name 
FROM doctors 
JOIN cities ON doctors.city_id = cities.city_id";
                $result = mysqli_query($conn, $query);
                ?>

                <!-- View Doctors Section -->
                <section id="view_doctor">
                    <div class="card">

                        <div class="table-responsive">
                            <table border="1">
                                <h2>All Doctors</h2>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Specialization</th>
                                    <th>City</th>
                                    <th>Experience</th>
                                    <th>Profile</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>

                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>

                                    <tr>
                                        <td><?php echo $row['doctor_id']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['phone']; ?></td>
                                        <td><?php echo $row['specialization']; ?></td>
                                        <td><?php echo $row['city_name']; ?></td>
                                        <td><?php echo $row['experience'] . "yrs"; ?></td>
                                        <td><?php echo $row['profile']; ?></td>
                                        <td>
                                            <img src="uploads/doctors/<?php echo $row['image']; ?>" width="50" height="50" style="border-radius:50%;">
                                        </td>
                                        <td>
                                            <a href="update_doctor.php?id=<?php echo $row['doctor_id']; ?>" class="btn edit">
                                                <i class="fa fa-edit fa-2x" aria-hidden="true"></i>
                                                <!-- <i class="fa fa-pencil"> -->
                                            </a>
                                            <a href="manage_doctors.php?id=<?php echo $row['doctor_id']; ?>"
                                                class="btn delete"
                                                onclick="return confirm('Are you sure you want to delete this doctor?');">

                                                <i class="fa fa-trash fa-2x"></i>
                                            </a>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Toast Message -->
    <div id="toast" class="toast"></div>

    <?php include "admin_footer.php"; ?>


    <!-- Toast JS -->
    <script>
        <?php if (isset($_GET['success'])) { ?>
            window.onload = function() {
                let toast = document.getElementById("toast");

                toast.innerText = "Doctor added successfully ✅";
                toast.style.display = "block";

                setTimeout(() => {
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

<?php


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // safe

    $res = mysqli_query($conn, "SELECT user_id FROM doctors WHERE doctor_id='$id'");
    $row = mysqli_fetch_assoc($res);
    $user_id = $row['user_id'];

    mysqli_query($conn, "DELETE FROM doctors WHERE doctor_id = $id");
    mysqli_query($conn, "DELETE FROM users WHERE user_id='$user_id'");


    header("Location: manage_doctors.php");
    exit();
}
?>