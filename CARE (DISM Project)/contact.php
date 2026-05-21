<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>

    <!-- TEMPLATE CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="css/tooplate-style.css"> -->
    <link rel="stylesheet" href="css/nav-foot.css">

    <!-- PAGE CSS -->
    <link rel="stylesheet" href="css/contact.css">

</head>

<body>

    <?php include "header.php"; ?>

    <h1 style="color: #333; text-align:center; margin-top: 50px;"> Contact Us </h1>
    <div style="width: 60px; height: 3px; background: #3ab5a4; margin: 10px auto 30px;"></div>
    <div class="contact-wrapper">


        <div class="contact-section px-3 px-md-5">



            <div class="row">

                <!-- LEFT (1/3) -->
                <div class="col-md-4">
                    <div class="contact-box">

                        <h3>Contact Info</h3>

                        <p><i class="fa fa-map-marker"></i> Karachi, Pakistan</p>
                        <p><i class="fa fa-phone"></i> 0323-1234567</p>
                        <p><i class="fa fa-phone"></i> 021-9876543</p>
                        <p><i class="fa fa-envelope"></i> care@company.com</p>

                        <hr>

                        <h4>Clinic Timings</h4>
                        <p>Mon - Sat: 9:00 AM - 9:00 PM</p>
                        <p>Sunday: Closed</p>

                        <h4>Ramadan Timings</h4>
                        <p>Mon - Sat: 10:00 AM - 5:00 PM</p>

                    </div>
                </div>

                <!-- RIGHT (2/3) -->
                <div class="col-md-8">
                    <div class="contact-box">

                        <h3>Have a Query?</h3>

                        <form onsubmit="return validateForm(event)">

                            <input type="text" id="name" placeholder="Your Name">
                            <span class="error" id="nameError"></span>

                            <input type="email" id="email" placeholder="Your Email">
                            <span class="error" id="emailError"></span>

                            <input type="text" id="phone" placeholder="Phone Number">
                            <span class="error" id="phoneError"></span>

                            <input type="text" id="subject" placeholder="Subject">

                            <textarea rows="5" id="message" placeholder="Your Message"></textarea>
                            <span class="error" id="messageError"></span>

                            <button type="submit">Send Message</button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- MAP -->
    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.202049103615!2d67.09503007357476!3d24.92518592800196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb339d021ae1ac7%3A0xe782bed1d92700d8!2sDUA%20home%20health%20care%20services!5e0!3m2!1sen!2s!4v1776951472924!5m2!1sen!2s"
            width="100%"
            height="500"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <!-- <iframe 
        src="https://www.google.com/maps?q=karachi&output=embed"
        width="100%" 
        height="500" 
        style="border:0;" 
        loading="lazy">
    </iframe> -->
    </div>

    <!-- TOAST -->
    <div id="toast" class="toast">Message sent successfully!</div>

    <?php include "footer.php"; ?>

    <!-- VALIDATION SCRIPT -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        function showToast(message) {
            let toast = document.getElementById("toast");
            toast.innerHTML = message;
            toast.classList.add("show");

            setTimeout(() => {
                toast.classList.remove("show");
            }, 3000);
        }

        function validateForm(e) {

            let valid = true;

            let name = document.getElementById("name").value.trim();
            let email = document.getElementById("email").value.trim();
            let phone = document.getElementById("phone").value.trim();
            let message = document.getElementById("message").value.trim();

            let nameRegex = /^[A-Za-z ]{3,}$/;
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            let phoneRegex = /^03[0-9]{9}$/;

            // CLEAR ERRORS
            document.getElementById("nameError").innerHTML = "";
            document.getElementById("emailError").innerHTML = "";
            document.getElementById("phoneError").innerHTML = "";
            document.getElementById("messageError").innerHTML = "";

            if (!nameRegex.test(name)) {
                document.getElementById("nameError").innerHTML = "Enter valid name (min 3 letters)";
                valid = false;
            }

            if (!emailRegex.test(email)) {
                document.getElementById("emailError").innerHTML = "Enter valid email";
                valid = false;
            }

            if (!phoneRegex.test(phone)) {
                document.getElementById("phoneError").innerHTML = "Enter valid phone (03XXXXXXXXX)";
                valid = false;
            }

            if (message.length < 5) {
                document.getElementById("messageError").innerHTML = "Message too short";
                valid = false;
            }

            if (valid) {
                e.preventDefault(); // 🔥 STOP PAGE RELOAD
                showToast("Message sent successfully!");

                // OPTIONAL: clear form
                document.querySelector("form").reset();
            }

            return false; // 🔥 IMPORTANT
        }
    </script>

</body>

</html>