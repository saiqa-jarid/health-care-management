<?php
include "conn.php";

$doctor_id = $_POST['doctor_id'];
$date = $_POST['date'];

$day = date('l', strtotime($date)); // Monday, Tuesday etc

// GET DOCTOR AVAILABILITY
$query = "SELECT * FROM doctor_availability 
          WHERE doctor_id='$doctor_id' AND day='$day'";

$result = mysqli_query($conn,$query);

$options = "<option value=''>Select Time Slot</option>";

while($row = mysqli_fetch_assoc($result)){

    $start = strtotime($row['start_time']);
    $end = strtotime($row['end_time']);

    while($start < $end){

        $time = date("H:i:s",$start);

        // CHECK IF SLOT IS BOOKED
        $check = "SELECT * FROM appointments 
                  WHERE doctor_id='$doctor_id' 
                  AND appointment_date='$date' 
                  AND appointment_time='$time'
                  AND status != 'cancelled'";

        $checkResult = mysqli_query($conn,$check);

        if(mysqli_num_rows($checkResult) == 0){
            $display = date("h:i A",$start);
            $options .= "<option value='$time'>$display</option>";
        }

        $start = strtotime("+30 minutes", $start); // SLOT GAP
    }
}

echo $options;
?>