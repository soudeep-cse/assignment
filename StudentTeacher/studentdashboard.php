<!-- *****Start php***** -->
<?php
session_start();




include './database.php';

$errorapplication="";

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $flag = true;
    
    // Account Information 
    $application = sanitize($_POST['application']);
   
    

    
    $errorapplication=" ";
    
    if(empty($application)){
        $errorapplication="Please fill up the form";
        $flag = false;
    }
  

    if($flag === true){
        if(!empty($application)){
            $sql = "insert into studentdashboard(application) values('$application')";
                
            // To execute this query      
            $result = mysqli_query($conn,$sql);
            // this method will allow us to execute this query
            if($result){
               echo "application sent successfully";
              // header('location:./login.php');
            }
            else{
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        

}}else{
    //echo "404 Error !";
}

function sanitize($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<?php


?>



<!-- **************Form part************ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
 
    
    <table align="center">
     
        <tr>
            <td>
            <h1>Student Dashboard Page</h1>
                <br>
                <br>
                <br>
                <fieldset>
                    <legend>Student Dashboard Form </legend>
                    <!-- ---------------------------------------- -->
                    <form action="studentdashboard.php" method="post" novalidate>
                        <table>

                            <tr>
                                <td>
                                    <label for="application">Application: </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <!-- <input type="text" id="application" name="application" value=""
                                        placeholder="Please enter your email...  "><br><br>
                                         <?//php if(isset($_POST['submit'])){echo $errorapplication;} ?> 
                                     -->
                                     <textarea name="application" id="application" cols="30" rows="10"></textarea>
                                </td>
                            </tr>
                           
                            <tr align="center">
                                
                                <td></td>
                                <td></td>
                                <td><input type="submit" name="submit" value="Sent Application" ></td> 
                                <td></td>
                                <td></td> 
                                <td></td>
                                <br>    
                            </tr>

                           

                        </table>
                    </form>

                </fieldset>
            </td>
        </tr>

    </table>
   

</body>

</html>