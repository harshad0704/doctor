<?php

include "db.php";

if(isset($_GET['doctor_id']) && isset($_GET['date']))
{

$doctor=$_GET['doctor_id'];
$date=$_GET['date'];

$query=mysqli_query($conn,"
SELECT *
FROM doctor_availability
WHERE doctor_id='$doctor'
AND available_date='$date'
AND is_booked=0
ORDER BY start_time
");

if(mysqli_num_rows($query)>0)
{

echo "<option value=''>Select Slot</option>";

while($row=mysqli_fetch_assoc($query))
{

echo "<option value='".$row['id']."'>";

echo date("h:i A",strtotime($row['start_time']));

echo " - ";

echo date("h:i A",strtotime($row['end_time']));

echo "</option>";

}

}
else
{

echo "<option>No Slots Available</option>";

}

}

?>