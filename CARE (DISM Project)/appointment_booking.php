<?php
include "conn.php";
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking Page</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css"> -->
    <link rel="stylesheet" href="css/nav-foot.css">
    <link rel="stylesheet" href="css/appointment_booking.css">
    <!-- <link rel="stylesheet" href="css/tooplate-style.css"> -->
</head>

<body>

    <?php
    include "header.php";
    ?>


<!-- Header Overlay -->
 <section class="appointment-hero">
    <div class="overlay">
        <h1 class="text-light">Book an Appointment</h1>
        <div style="width: 60px; height: 3px; background: #3ab5a4; margin: 10px auto 30px;"></div>
        <!-- <p>Quick, easy, and hassle-free healthcare scheduling</p> -->
    </div>
</section>

    <!-- MAKE AN APPOINTMENT -->
    <section id="appointment" data-stellar-background-ratio="3">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-sm-6">
                    <img src="images/appointment-image.jpg" class="img-responsive" alt="">
                </div>

                <div class="col-md-6 col-sm-6">
                    <!-- CONTACT FORM HERE -->
                    <form id="appointment-form" method="POST" action="book_appointment.php">
                        <!-- <form id="appointment-form" role="form" method="post" action="#"> -->

                        <!-- SECTION TITLE -->

                        <div class="section-title wow fadeInUp" data-wow-delay="0.4s">
                            <h2 class="appointment-label">Choose Your Doctor, Date and Time</h2>
                        </div>

                        <div class="wow fadeInUp" data-wow-delay="0.8s">

                            <!-- Select City -->
                            <div class="col-md-6 col-sm-6">
                                <label>Select City</label>
                                <select class="form-control" name="city_id" id="city" required>
                                    <option value="">Select City</option>

                                    <?php
                                    $cities = mysqli_query($conn, "SELECT * FROM cities");
                                    while ($c = mysqli_fetch_assoc($cities)) {
                                    ?>
                                        <option value="<?= $c['city_id']; ?>">
                                            <?= $c['city_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>


                            <!-- Select Speciality -->
                            <div class="col-md-6 col-sm-6">
                                <label>Select Specialization</label>
                                <select class="form-control" name="specialization" id="specialization" required>
                                    <option value="">Select Specialization</option>

                                    <?php
                                    $spec = mysqli_query($conn, "SELECT DISTINCT specialization FROM doctors");
                                    while ($s = mysqli_fetch_assoc($spec)) {
                                    ?>
                                        <option value="<?= $s['specialization']; ?>">
                                            <?= $s['specialization']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>


                            <!-- Select Doctor -->
                            <div class="col-md-6 col-sm-6">
                                <label>Select Doctor</label>
                                <select class="form-control" name="doctor_id" id="doctor" required>
                                    <option value="">Select Doctor</option>
                                </select>
                            </div>


                            <div class="col-md-6 col-sm-6">
                                <label>Select Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>

                            <div class="col-md-12 col-sm-12">
                                <label>Select Time Slot</label>
                                <select class="form-control" name="time" id="time" required>
                                    <option value="">Select Time Slot</option>
                                </select>

                                <button type="submit" class="form-control" id="cf-submit" name="book">
                                    Book Appointment
                                </button>
                            </div>

                        </div>
                    </form>


                </div>

            </div>
        </div>
    </section>

    <?php
    include "footer.php";
    ?>

    <div id="toast" class="toast"></div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {

            function loadDoctors() {
                var city = $('#city').val();
                var spec = $('#specialization').val();

                if (city != "" && spec != "") {
                    $.ajax({
                        url: "get_doctors.php",
                        type: "POST",
                        data: {
                            city_id: city,
                            specialization: spec
                        },
                        success: function(data) {
                            $('#doctor').html(data);
                        }
                    });
                }
            }

            // Trigger on change
            $('#city').change(loadDoctors);
            $('#specialization').change(loadDoctors);

        });


        // Book Appointment
        document.querySelector('[name="date"]').addEventListener("change", loadSlots);
        document.querySelector('[name="doctor_id"]').addEventListener("change", loadSlots);

        function loadSlots() {
            let doctor = document.querySelector('[name="doctor_id"]').value;
            let date = document.querySelector('[name="date"]').value;

            if (doctor && date) {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "get_slots.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onload = function() {
                    document.getElementById("time").innerHTML = this.responseText;
                }

                xhr.send("doctor_id=" + doctor + "&date=" + date);
            }
        }


        
    </script>
    <script>
function showToast(message) {
    let toast = document.getElementById("toast");
    toast.innerHTML = message;
    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

// RUN AFTER PAGE LOAD
window.addEventListener("load", function() {
    const params = new URLSearchParams(window.location.search);

    if (params.get("success") === "1") {
        showToast("Appointment booked successfully!");
    }
});
</script>

</body>

</html>