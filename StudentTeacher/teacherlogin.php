<!-- *****Start php***** -->
<?php
session_start();




include './database.php';


    if(isset($_COOKIE['emailUser']) && isset($_COOKIE['password'])){
        $email=$_COOKIE['emailUser'];
        $pass=$_COOKIE['password'];
     }

else {
    $email="";
    $pass="";
}

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $flag = true;
    
    // Account Information 
    $emailUser = sanitize($_POST['emailUser']);
    $password = sanitize($_POST['password']);
    

    
    $erroremailUser=$errorpassword=" ";
    
    if(empty($emailUser)){
        $erroremailUser="Please fill up the form";
        $flag = false;
    }
    
    if(empty($password)){
        $errorpassword="Please fill up the form";
        $flag = false;
    }

    if($flag === true){
        // Data base operation should be done here ..  
        $sql = "Select * from `teacherstudent`.`teacher` WHERE  email='$emailUser' OR Username='$emailUser' AND password='$password' ";
        // $email $password
        // we want to execute the query
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if($row > 0){
            //echo " we found a user ";
            $_SESSION["id"]= $row['id'];
            $_SESSION["firstname"]= $row['firstname']; // row theke data gula access kortesi 
            $_SESSION["lastname"]= $row['lastname']; // row theke data gula access kortesi 
            $_SESSION["Username"]= $row['Username']; // 'email' // eita hocche amar table er column field 
            $_SESSION["email"]= $row['email']; // 'email' // eita hocche amar table er column field  
            $_SESSION["password"]= $row['password'];


            if(isset($_POST['rememberme'])){
                setcookie('emailUser',$_POST['emailUser'],time()+(60*60*24));
                setcookie('password',$_POST['password'],time()+(60*60*24));
            }
            else {
                    setcookie('emailUser','',time()-(60*60*24));
                    setcookie('password','',time()-(60*60*24));  
            }

            // ekhon passenger Profile e niye jabo 
            //header('location:../../passengerProfile/subNavbar/personalInformation/personalInformation.php');
            //echo "Login successfully done";
            header('location:./teacherdashboard.php');
            
          
            
        }else{
            echo "we don't found a user ";
        }
    }
}else{
    //echo "404 Error !";
}

function sanitize($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
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
            <h1>Teacher Login Page</h1>
                <br>
                <br>
                <br>
                <fieldset>
                    <legend>Teacher Login Form: </legend>
                    <!-- ---------------------------------------- -->
                    <form action="teacherlogin.php" method="post" novalidate>
                        <table>

                            <tr>
                                <td>
                                    <label for="emailUser">Username/Email: </label>
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="text" id="emailUser" name="emailUser" value="<?php if(isset($_POST['rememberme'])){echo  $email;}  ?>"
                                        placeholder="Please enter your email...  "><br><br>
                                         <?php if(isset($_POST['submit'])){echo $erroremailUser;} ?> 
                                    
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="password">Password: </label>
                                    
                                </td>
                                <td>:</td>
                                <td>
                                    <input type="password" id="password" name="password" value="<?php if(isset($_POST['rememberme'])){echo  $pass;}  ?>"
                                        placeholder="Please enter your password...  "><br>
                                        <?php if(isset($_POST['submit'])){echo $errorpassword;} ?>
                                </td>
                            </tr>
                            
                            <tr>
                                <td></td>
                                <td></td>
                                <td><input type="checkbox" name="rememberme">Remember Me</input></td>
                                <br>
                            </tr>
                            <tr align="center">
                                
                                <td></td>
                                <td></td>
                                <td><input type="submit" name="submit" value="Login" ></td> 
                                <td></td>
                                <td></td> 
                                <td></td>
                                <br>    
                            </tr>

                            <tr>
                                <!-- <td> </td> -->
                                <td></td>
                                <td></td>
                                <td><p>Don't have an account?<a href="./teacherregister.php">Register here</a></p></td>
                            </tr>

                        <tr>
                                <td></td>
                                <td> <a href="./forgotpassword.php">Forgot Password?</a></td>

                        </tr>
                        </table>
                    </form>

                </fieldset>
            </td>
        </tr>

    </table>
   

</body>

</html>