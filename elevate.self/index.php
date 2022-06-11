<?php
   include_once("db_connect.php");
?>
<!DOCTYPE html>
<html>
<head>

	<title>LOGIN</title>
	<link rel="stylesheet" href="style.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<!-- validate form -->
<?php
  $mess="";
  $error=true;
  $email="";

  if (isset($_POST["submit"])){
    if(!isset($_POST['email'],$_POST['pass'])){
      $mess = "fill the form";
    }
    else{
     $email=trim(strtolower($_POST['email']));
     $pass=trim($_POST['pass']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $mess = "Invalid email";
    }else{
      $error=false;
     }
    }
  }
?>
<!-- end form validation -->



<!-- check user if exist in the database -->
<?php
    //if the message length==0
    // then we don't have form errors
    if($error==false){
      //limit the users by 1
      $sql = "SELECT * FROM users WHERE email='$email' AND pass='$pass' LIMIT 1";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
          //user is now logged in
          $_SESSION["email"]=$row["email"];
          $_SESSION["usrname"]=$row["username"];
          //redirect to the main page
          header("Location: semi-rough/index.php");
          die();
        }
      } else {
         $mess="account not found";
      }
    }

?>
<!-- end checking user -->

<form action="index.php" method="post">
	<h2>LOGIN</h2>
	<?php if(strlen($mess)>3) { ?>
			<p class="error"><?php echo  $mess; ?></p>
	<?php } ?>
	<label>Email</label>
	<input type="text" name="email" placeholder="email"><br>

	<label>Password</label>
	<input type="text" name="pass" placeholder="Password"><br>

	<button type="submit" name="submit">Login</button>
		<a href="signup.php" class="ca">Create an account</a>
</form>
</body>
</html>  