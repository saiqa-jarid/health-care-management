<?php
session_start();
include "conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Search</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/nav-foot.css">
    <link rel="stylesheet" href="css/doctor_display.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
</head>

<body>

    <?php include "header.php"; ?>

    <div class="container" style="margin-top:50px;">

        <!-- 🔍 SEARCH FORM -->
        <form method="GET" class="form-box" style="margin-bottom:20px;">
            <div class="search-title full-width">
                <h2> Search Doctor </h2>
                <div style="width: 60px; height: 3px; background: #3ab5a4; margin: 10px auto 30px;"></div>
            </div>

            <!-- NAME -->
            <input type="text" name="name" placeholder="Search by Name"
                value="<?php echo $_GET['name'] ?? ''; ?>">

            <!-- CITY -->
            <select name="city_id">
                <option value="">All Cities</option>
                <?php
                $cities = mysqli_query($conn, "SELECT * FROM cities");
                while ($c = mysqli_fetch_assoc($cities)) {
                ?>
                    <option value="<?php echo $c['city_id']; ?>"
                        <?php if (isset($_GET['city_id']) && $_GET['city_id'] == $c['city_id']) echo "selected"; ?>>
                        <?php echo $c['city_name']; ?>
                    </option>
                <?php } ?>
            </select>

            <!-- SPECIALIZATION (FROM DATABASE 🔥) -->
            <select name="specialization">
                <option value="">All Specialization</option>

                <?php
                $specQuery = mysqli_query($conn, "
            SELECT DISTINCT TRIM(specialization) as specialization 
            FROM doctors
        ");

                while ($s = mysqli_fetch_assoc($specQuery)) {
                ?>
                    <option value="<?php echo $s['specialization']; ?>"
                        <?php if (isset($_GET['specialization']) && strtolower($_GET['specialization']) == strtolower($s['specialization'])) echo "selected"; ?>>
                        <?php echo $s['specialization']; ?>
                    </option>
                <?php } ?>

            </select>

            <button type="submit" class="btn add">Search</button>

        </form>


        <?php
        // 🔥 FILTER LOGIC
        $where = [];

        if (!empty($_GET['name'])) {
            $name = mysqli_real_escape_string($conn, $_GET['name']);
            $where[] = "doctors.name LIKE '%$name%'";
        }

        if (!empty($_GET['city_id'])) {
            $city_id = intval($_GET['city_id']);
            $where[] = "doctors.city_id = $city_id";
        }

        if (!empty($_GET['specialization'])) {
            $spec = mysqli_real_escape_string($conn, $_GET['specialization']);

            // 🔥 CASE INSENSITIVE MATCH
            $where[] = "LOWER(TRIM(doctors.specialization)) = LOWER(TRIM('$spec'))";
        }

        // MAIN QUERY
        $sql = "SELECT doctors.*, cities.city_name 
        FROM doctors 
        JOIN cities ON doctors.city_id = cities.city_id";

        if (count($where) > 0) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $result = mysqli_query($conn, $sql);
        ?>


        <!-- 👨‍⚕️ DOCTOR CARDS -->

        <div class="section-title-doctors">
            <h2>Our Doctors</h2>
            <div style="width: 60px; height: 3px; background: #3ab5a4; margin: 10px auto 30px;"></div>
            <p>Meet our experienced and professional healthcare specialists</p>
        </div>


        <div class="doctor-grid">

            <?php
            while ($row = mysqli_fetch_assoc($result)) {

                // 🔥 Fetch availability for each doctor
                $doc_id = $row['doctor_id'];
                $availability = mysqli_query($conn, "
        SELECT * FROM doctor_availability 
        WHERE doctor_id = '$doc_id'
    ");

                $timings = [];
                while ($a = mysqli_fetch_assoc($availability)) {
                    $timings[] = $a['day'] . " (" . date("h:i A", strtotime($a['start_time'])) . " - " . date("h:i A", strtotime($a['end_time'])) . ")";
                }

                $image = !empty($row['image'])
                    ? "uploads/doctors/" . $row['image']
                    : "https://via.placeholder.com/150";
            ?>

                <div class="doctor-card">

                    <!-- IMAGE -->
                    <div class="doctor-img">
                        <img src="<?php echo $image; ?>" alt="Doctor">
                    </div>

                    <!-- INFO -->
                    <div class="doctor-info">
                        <h3><?php echo $row['name']; ?></h3>
                        <p class="spec"><?php echo $row['specialization']; ?></p>

                        <p><i class="fa fa-location-dot"></i> <?php echo $row['city_name']; ?></p>
                        <p><i class="fa fa-briefcase"></i> <?php echo $row['experience']; ?> years experience</p>

                        <!-- TIMINGS -->
                        <div class="timings">
                            <strong>Availability:</strong>
                            <?php if (count($timings) > 0) { ?>
                                <ul>
                                    <?php foreach ($timings as $t) { ?>
                                        <li><?php echo $t; ?></li>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <p>No schedule added</p>
                            <?php } ?>
                        </div>

                        <!-- BUTTON -->
                        <a href="appointment_booking.php?doctor_id=<?php echo $row['doctor_id']; ?>#appointment" class="book-btn">
                            Book Appointment
                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

    <?php include "footer.php"; ?>

</body>

</html>