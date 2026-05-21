<?php
session_start();
include "conn.php";

// CHECK LOGIN
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {

    // Save return page
    $_SESSION['redirect_url'] = $_SERVER['HTTP_REFERER'];

    header("Location: p_login.php");
    exit();
}

// if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient'){
//     header("Location: p_login.php");
//     exit();
// }


$user_id = $_SESSION['user_id'];

$getPatient = mysqli_query($conn, "
SELECT patient_id FROM patients WHERE user_id='$user_id'
");

$p = mysqli_fetch_assoc($getPatient);

$patient_id = $p['patient_id'];



if (isset($_POST['book'])) {

    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // STEP 1: CHECK DAY AVAILABILITY
    $day = date('l', strtotime($date));

    $checkAvail = mysqli_query($conn, "
SELECT * FROM doctor_availability 
WHERE doctor_id='$doctor_id' 
AND day='$day'
");

    if (mysqli_num_rows($checkAvail) == 0) {
        die("Doctor is not available on this day");
    }

    // STEP 2: CHECK IF TIME FALLS IN SLOT
    $valid_slot = false;

    while ($avail = mysqli_fetch_assoc($checkAvail)) {
        if ($time >= $avail['start_time'] && $time < $avail['end_time']) {
            $valid_slot = true;
            break;
        }
    }

    if (!$valid_slot) {
        die("Selected time is outside doctor's availability");
    }

    // STEP 3: PREVENT DOUBLE BOOKING
    $check = mysqli_query($conn, "
    SELECT * FROM appointments 
    WHERE doctor_id='$doctor_id'
    AND appointment_date='$date'
    AND appointment_time='$time'
    ");

    if (mysqli_num_rows($check) > 0) {
        die("Time slot already booked");
    }

    // STEP 4: INSERT APPOINTMENT
    $insert = "INSERT INTO appointments 
    (doctor_id, patient_id, appointment_date, appointment_time, status)
    VALUES 
    ('$doctor_id','$patient_id','$date','$time','pending')";

    if (mysqli_query($conn, $insert)) {
        header("Location: appointment_booking.php?success=1");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
