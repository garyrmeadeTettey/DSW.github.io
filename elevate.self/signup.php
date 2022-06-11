<?php
   include_once("db_connect.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>SIGN UP</title>
     <link rel="stylesheet" href="style.css">
	
</head>
<body>

  <!-- validate form -->
  <?php
  $mess="";
  $error=true;
  $em="";
  $pa="";
  $nam="";
  $success="";
  if (isset($_POST["submit"])){
    
    if(!isset($_POST['email'],$_POST['pass'],$_POST['name'])){
      $mess = "fill the form";
    }
    else{
     $email=trim(strtolower($_POST['email']));
     $pass=trim($_POST['pass']);
     $name=trim($_POST['name']);

     $nam=$name;
     $pa=$pass;
     $em=$email;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $mess = "Invalid email";
     }else if (empty(trim($name))) {
      $mess = "name is required";
     }
     else if (empty(trim($pass))) {
      $mess = "password is required";
     }else{
          $error=false;
     }
    }
  }
   ?>



<!-- check user if exist in the database -->
<?php
    //if the message length==0
    // then we don't have form errors
    if($error==false){

      //limit the users by 1
      $sql = "SELECT * FROM users WHERE email='$email'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
         $mess="account exist , please login";
      } else {
        $sql="INSERT INTO `users`( `email`, `pass`, `username`) VALUES ('$email','$pass','$nam')";
        if (mysqli_query($conn, $sql)) {
          $_SESSION["email"]=$em;
          $_SESSION["username"]=$nam;
          die();
          //redirect to the main page
          header("Location: semi-rough/index.php");
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
      }
    }

?>
<!-- end checking u -->

     <form action="signup.php" method="post">
     	<h2>SIGN UP</h2>
          <?php if(strlen($mess)>3) { ?>
			<p class="error"><?php echo  $mess; ?></p>
	<?php } ?>
     <label >Username</label>
          <input name="name" type="text"  value="<?php echo $nam ?>" /><br>
      <label >Email</label>
      <input name="email" type="text" value="<?php echo $em  ?>" /><br>
      <label>Password</label>
      <input name="pass" type="text"  value="<?php echo $pa  ?>" /><br>
     	<button type="submit" name="submit">Sign Up</button>
          <a href="index.php" class="ca">Already have an account?</a>
     </form>
</body>
</html> 
