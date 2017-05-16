<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>Login</title>
	</head>
	<body>
		<h1>Welcome to Fred Zappia's Website</h1>
		
		<div class = "login">
		<?php
		$post_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
		$post_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

		if (isset($_SESSION['logged_user_by_sql'])){
			print ("<h3>You already logged in.</h3>");
			print ("<h3>To change another account, please <a href='logout.php'>log out</a> first.</h3>");
		} else {

		if (empty($post_username) || empty($post_password)){
		?>
			<h2>Log in</h2>
			<form action="login.php" method="post" class="inputform">
				Username: <input type="text" name="username"><br>
				Password: <input type="password" name="password"><br>
				<input type="submit" value="Login">
			</form>
			<p><a href ="index.php">Return to home page</a></p>
			<form method="POST"><input type="submit" name='reset' value='Password reset' id="reset"></form>

		<?php

		} else {
			require_once 'includes/config.php';
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			if ($mysqli->connect_errno){
				die("Couldn't connect to database");
			}

			// prepare and bind
			$stmt = $mysqli->stmt_init();
			$query = "SELECT * FROM User_info WHERE username= ?";
			if ($stmt->prepare($query)){
				$stmt->bind_param('s',$post_username);
				$stmt->execute();
				$result = $stmt->get_result();
		}

			//Make sure there is exactly one user with this username
			if ($result && $result->num_rows == 1){
				$row = $result->fetch_assoc();
				$db_hash_password = $row['hashpassword'];

				if (password_verify($post_password,$db_hash_password)){
					$db_username = $row['username'];
					$_SESSION['logged_user_by_sql'] = $db_username;
				}
			}

			$mysqli->close();

			if (isset($_SESSION['logged_user_by_sql'])){
				print("<h3 class='center'>Congratulations, $db_username You have accessed the website as admin.</p>");
				print("<p><a href ='index.php'>Return to home page</a></p>");
			} else{
				print "<h3 class='center'>You did not login successfully.</p>";
				print "<p>Please <a href = 'login.php'>try again.</a></p>";
			}

		}
		
		if(isset($_POST['reset'])){
			print("<h2>Password reset</h2>");
			print("<p>Reset code was sent to your email address</p>");
			$length=20;
			$crypto_strong=TRUE;
			$codebase = openssl_random_pseudo_bytes($length, $crypto_strong);
			$code = bin2hex($codebase);
			//print($code);
			$_SESSION['code']=$code;
			
			ini_set('SMTP','info2300.coecis.cornell.edu');
			ini_set('smtp_port',22);
			$to = "yg367@cornell.edu"; // this is your Email address
			$subject = "Password reset code";
			$headers = "From:yg367@cornell";
			mail($to,$subject,$code,$headers);
			print("<form method='POST'  action='login.php' class='inputform'>Reset code: <input type='text' name='code'><br>New password: <input type='password' name='new_password'><br><input type='submit' name='reset_submit' value='Reset'></form>");
			
		}
		
		if(isset($_SESSION['code']) && !empty($_POST['reset_submit'])){
			$code=FILTER_INPUT(INPUT_POST, 'code', FILTER_SANITIZE_STRING);
			$new_password=FILTER_INPUT(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
			$new_hashed_password=password_hash($new_password, PASSWORD_DEFAULT);
			if($_SESSION['code']===$code){
				require_once 'includes/config.php';
				$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				if ($mysqli->connect_errno){
					die("Couldn't connect to database");
				}

				// prepare and bind
				$stmt = $mysqli->stmt_init();
				$query = "UPDATE User_info SET hashpassword=? WHERE username='cadbygy';";
				//print($new_hashed_password);
				if ($stmt->prepare($query)){
					$stmt->bind_param('s',$new_hashed_password);
					$stmt->execute();
				}
				
				echo "<script type='text/javascript'>alert('Password reset completed')</script>";
			}else{
				echo "<script type='text/javascript'>alert('Wrong code')</script>";
			}
			unset($_SESSION['code']);
			
		}
		
	}
		?>
		
		
		
		</div>
	</body>
	</html>
