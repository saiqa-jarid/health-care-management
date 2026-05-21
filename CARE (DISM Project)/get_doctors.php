<?php
// include "conn.php";

// if(isset($_POST['specialization'])){
//     $spec = $_POST['specialization'];

//     $query = "SELECT * FROM doctors WHERE specialization='$spec'";
//     $result = mysqli_query($conn, $query);

//     echo '<option value="">Select Doctor</option>';

//     while($row = mysqli_fetch_assoc($result)){
//         echo '<option value="'.$row['doctor_id'].'">'.$row['name'].'</option>';
//     }
// }
?>


<?php
include "conn.php";

$spec = $_POST['specialization'] ?? '';
$city = $_POST['city_id'] ?? '';

$query = "SELECT * FROM doctors WHERE 1";

// Apply specialization filter
if(!empty($spec)){
    $query .= " AND specialization = '$spec'";
}

// Apply city filter
if(!empty($city)){
    $query .= " AND city_id = '$city'";
}

$result = mysqli_query($conn, $query);

echo '<option value="">Select Doctor</option>';

if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        echo '<option value="'.$row['doctor_id'].'">'.$row['name'].'</option>';
    }
} else {
    echo '<option value="">No doctors found</option>';
}
?>