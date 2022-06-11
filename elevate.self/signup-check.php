
<?php 
session_start(); 
include "db_connect.php";

if (isset($_POST['username']) && isset($_POST['password'])
    && isset($_POST['name']) && isset($_POST['re_password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['username']);
	$pass = validate($_POST['password']);

	$re_pass = validate($_POST['re_password']);
	$name = validate($_POST['name']);

	$user_data = 'username='. $uname. '&name='. $name;


	if (empty($username)) {
		header("Location: signup.php?error=User Name is required&$user_data");
	    exit();
	}else if(empty($pass)){
        header("Location: signup.php?error=Password is required&$user_data");
	    exit();
	}
	else if(empty($re_pass)){
        header("Location: signup.php?error=Re Password is required&$user_data");
	    exit();
	}

	else if(empty($name)){
        header("Location: signup.php?error=Name is required&$user_data");
	    exit();
	}

	else if($pass !== $re_pass){
        header("Location: signup.php?error=The confirmation password  does not match&$user_data");
	    exit();
	}

	function usernameExist( $conn, $username ,$email){
		$sql = "SELECT * FROM users WHERE username = ?;";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt, $sql)){
			header("location: ../signup.php?error=stmtfailed");
			exit();
		 }
		mysqli_stmt_bind_param($stmt, "ss", $username,$email);
		mysqli_stmt_execute($stmt);
	
		$resultData = mysqli_stmt_get_result($stmt);
	
		if($row =mysqli_fetch_assoc($resultData)){
		return $row;
	   }
	else{
		$result = false;
		return $result;
	}
	   mysqli_stnt_close($stmt);
	}

}else{
	header("Location: signup.php");
	exit();
}