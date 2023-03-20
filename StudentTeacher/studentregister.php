<!-- *********Start php********** -->
<?php

session_start();
include './database.php';

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $flag = true;
        // general information
        $firstname = sanitize($_POST['firstname']);
        $lastname = sanitize($_POST['lastname']);
        $Username = sanitize($_POST['Username']);
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password']);
        $confirmpassword = sanitize($_POST['confirmpassword']);
        $section=sanitize($_POST['section']);

        $errorfirstname=$errorlastname=$errorUsername=$erroremail=$errorpassword=$errorconfirmpassword=$errorvalidmail=$errormatchedpassword=$errorsection=" ";
        // if input form is empty then show some specific error 
        if(empty($firstname)){
            $errorfirstname="Please fill up the form";
            $flag = false;
        }

        if(empty($lastname)){
            $errorlastname="Please fill up the form";
            $flag=false;
        }
        if(empty($Username)){
            $errorUsername="Please fill up the form";
            $flag = false;
        }
        if(!preg_match("/^^[^0-9][a-z0-9]+([_-]?[a-z0-9])*$/",$Username)){
            $Error[]= 'Username:Must be in lowercase.<br>';
        }
        if(empty($email)){
            $erroremail="Please fill up the form";
            $flag = false;
        }else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errorvalidmail="This is not correct email format..";
                $flag = false;
            }
        }
        if(empty($password)){
            $errorpassword="Please fill up the form";
            $flag = false;
        }


        

        //Pregmatch
        if(!preg_match_all('$\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password)){
            $Error[]= 'Password: Enter password which contains atleast Upper,Lower character & number & special character.<br>';
        }
        
        if(empty($confirmpassword)){
            $errorconfirmpassword="Please fill up the form";
            $flag = false;
        }
        
        if(empty($section)){
            $errorsection="Please fill up the form";
            $flag = false;
        }

        if($flag === true){
        
        
            if(!empty($firstname) && !empty($lastname) && !empty($email)&& !empty($password)&& !empty($confirmpassword)){
                if($password===$confirmpassword){

                    $sql="select * from student where (email='$email' or Username='$Username');";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    if($row>0){
                        if($Username==$row['Username']){
                            echo "Username is already used.Used different Username.<br>";
                        }
                        if($email==$row['email']){
                            echo "Email is already used.Used different email";
                        }
                        

                        }
                        else{
                            if (!isset($Error)) {
                               
                            
                            $sql = "insert into student(firstname,lastname,Username, email, password,section) values('$firstname', '$lastname','$Username','$email','$password','$section')";
                
                            // To execute this query      
                            $result = mysqli_query($conn,$sql);
                            // this method will allow us to execute this query
                            if($result){
                               echo "Register successfully";
                              // header('location:./login.php');
                            }
                            else{
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                        }
                    }
                    }

                else{
                    $errormatchedpassword="Password didn't matched.";
                    //echo "Password didn't matched.";
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
if(isset($Error)){
foreach ($Error as $Error) {
    echo '&#x26A0'.$Error.'<br>';
}
}
?>




<!--*********Form part************** -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>
<body>



<form action="studentregister.php" novalidate method="post" >
<div align="center">
<h1>Student Registration Form</h1>
</div>    

<table align="center">
    <tr>
        <td>
            <br>
            <br>
            <br>
            <fieldset>
                <legend>Student Registration Form: </legend>
                <!-- ---------------------------------------- -->
                <form action="studentregister.php" novalidate>
                    <table>
                    
                        <tr>
                            <td>
                                <label for="firstname">First Name</label>
                    
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" id="firstname" name="firstname" value="<?php if(isset($_POST['submit'])){echo $firstname;}    ?>"
                                    placeholder="Enter your first name here...  "><br>
                                    <?php if(isset($_POST['submit'])){echo $errorfirstname;} ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="lastname">Last Name</label>
                              
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" id="lastname" name="lastname" value="<?php if(isset($_POST['submit'])){echo $lastname;} ?>"
                                    placeholder="Enter your first name here...  "><br>
                                    <?php if(isset($_POST['submit'])){echo $errorlastname;} ?>
                            </td>
                        </tr>

                       

                        <tr>
                            <td>
                                <label for=Username">Username:</label>
                         
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" id="Username" name="Username" value="<?php if(isset($_POST['submit'])){echo $Username;} ?>"
                                    placeholder="Enter your email...  "><br>   
                                    <?php if(isset($_POST['submit'])){echo $errorUsername;} ?>                        
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="email">Email</label>
                         
                            </td>
                            <td>:</td>
                            <td>
                                <input type="email" id="email" name="email" value="<?php if(isset($_POST['submit'])){echo $email;} ?>"
                                    placeholder="Enter your email...  "><br>   
                                    <?php if(isset($_POST['submit'])){echo $erroremail; echo  $errorvalidmail;} ?>                        
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="password">Password</label>
                            </td>
                            <td>:</td>
                            <td>
                                <input type="password" id="password" name="password" value=""
                                    placeholder="Enter your password...  "><br>
                                    <?php if(isset($_POST['submit'])){echo $errorpassword;} ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                            <label for="confirmpassword">Confirm Password</label>
                         
                            </td>
                            <td>:</td>
                            <td>
                                <input type="password" id="confirmpassword" name="confirmpassword" value=""
                                    placeholder="Enter confirm password...  "><br>
                                    <?php if(isset($_POST['submit'])){echo $errorconfirmpassword;echo $errormatchedpassword;} ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                            <label for="section">Section: </label>
                         
                            </td>
                            <td>:</td>
                            <td>
                                <input type="text" id="section" name="section" value=""
                                    placeholder="Enter section...  "><br>
                                    <?php if(isset($_POST['submit'])){echo $errorsection;} ?>
                            </td>
                        </tr>
                        
                        <tr align="center">
                            <td></td>
                            <td></td>
                            <td><input type="submit" name="submit" value="Register">
                            </td>
                        </tr>

                    </table>
                </form>

            </fieldset>
        </td>
    </tr>

</table>

</form>
    
<div align="center">
<h4>Already Have an Accout?<a href="./studentlogin.php">Login here</a></h4>


</div>    



</body>
</html>