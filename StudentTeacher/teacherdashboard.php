<?php
session_start();
include './database.php';


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<!-- View -->
<div align="center">
<h1>Teacher Dashboard</h1>
</div>
<table align="center">
    <tr>
    <th>Application</th>
    <th></th><th></th><th></th><th></th><th></th><th></th>
    
    </tr>
<?php
$sql="select * from studentdashboard";
$query=mysqli_query($conn,$sql);
while ($row=mysqli_fetch_assoc($query)) {
    $id=$row['id'];
    $application=$row['application'];
   
?>
 <tr>
        
        <td><?php echo $application;?></td>
        <td></td><td></td><td></td><td></td><td></td><td></td>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
        <td><button> <a href="./teacherdashboard.php ? edit=<?php  echo $id;?>   ">Edit</a></button></td>
        <td><button> <a href="./teacherdashboard.php ? delete=<?php  echo $id;?>  ">Delete</a></button></td>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    </tr>
    <?php }
    ?>
    
</table>


<?php

    if(isset($_GET['delete'])){
        $id=$_GET['delete'];


        $sql = "DELETE FROM passengers WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
          echo "Record deleted successfully";
        } else {
          echo "Error deleting record: " . mysqli_error($conn);
        }

    }

?>





</body>
</html>