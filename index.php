<?php
	$_db = mysqli_connect("localhost", "root", "", "ryses");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Welcome to my sample website</title>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="styles.css">
		<style type="text/css">
			form{
				display: flex;
				flex-basis: content;
				background-color: var(--base);
				color: var(--color);
				border-radius: var(--base-radius);
				margin: var(--base-margin);
				padding: var(--base-padding);
				width: 18.5em;
				position: absolute;
				left: 30em;
			}
			form input{
				background-color: var(--base-radius);
				border: 1px #aaaaaa solid;
				border-radius: var(--base-radius);
				padding: 0 0.3em;
				font-family: "Courier New", monospace;
			}
			form input[type='submit']{
				width: 100%;
				font-family: "Times New Roman", serif;
			}
		</style>
	</head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<table>
				<caption>
					<h3>Welcome to my simple panel</h3>
					<h6 id="notice"></h6>
				</caption>
				<tr>
					<td>
						<label for="user">Username</label>
					</td>
					<td>:</td>
					<td>
						<input type="text" name="username" id="user" onkeyup="checker()">
					</td>
				</tr>
				<tr>
					<td>
						<label for="pass">Password</label>
					</td>
					<td>:</td>
					<td>
						<input type="password" name="password" id="pass" onkeyup="checker()">
					</td>
				</tr>
				<tr>
					<td>
						<label for="pass2">Retype Password</label>
					</td>
					<td>:</td>
					<td>
						<input type="password" name="password2" id="pass2" placeholder="(For register only)" onkeyup="checker()">
					</td>
				</tr>
				<tr>
					<td>
						<label id="toggle" onclick="showPass()">Show password</label>
					</td>
					<td colspan="2">
						<input type="submit" value="Proceed" id="go">
					</td>
				</tr>
			</table>
		</form>
	</body>
	<script type="text/javascript">
		let isShow = false
		function checker(){
			let user = document.getElementById('user').value.replace(/\s/gi, "")
			let pass = document.getElementById('pass').value.replace(/\s/gi, "")
			if(user != "" && pass != ""){
				document.getElementById('go').type = "submit"
			}else{
				document.getElementById('go').type = "hidden"
			}
			if(isShow){
				document.getElementById('pass').value = document.getElementById('pass2').value
			}
		}
		function showPass(){
			let pass = document.getElementById('pass')
			let pass2 = document.getElementById('pass2')
			isShow = !isShow
			if(isShow){
				pass.type = "text"
				pass2.type = "text"
				if(pass2.value.replace(/\s/gi, "") != ""){
					document.getElementById('pass').value = document.getElementById('pass2').value
				}
			}else{
				pass.type = "password"
				pass2.type = "password"
			}
		}
		checker()
	</script>
	<?php
	say("Greetings");
		if(isset($_POST['username']) && isset($_POST['password'])){
			$user = validate($_POST['username']);
			$pass = validate($_POST['password']);
			if(isset($_POST['password2'])){
				// Register
				$pass2 = validate($_POST['password2']);
				if($pass == $pass2){
					$query = mysqli_query($_db, "SELECT * FROM users WHERE username = '$user'");
					if(mysqli_num_rows($query) > 0){
						say("This username is already taken.");
					}else{
						$sql = mysqli_query($_db, "INSERT INTO users (username, password) VALUES ('$user', '$pass')");
						if($sql){
							header("Location: lists.php");
						}else{
							say("Error: " + mysqli_error($_db));
						}
					}
				}else if($pass2 == ""){
					$query = mysqli_query($_db, "SELECT * FROM users WHERE username = '$user' AND password = '$pass'");
					if(mysqli_num_rows($query) > 0){
						header("Location: lists.php");
					}else{
						say("Username doesn\'t exists or wrong password");
					}
				}else{
					say("Mismatch Passwords");
				}
			}else{
				$query = mysqli_query($_db, "SELECT * FROM users WHERE username = '$user' AND password = '$pass'");
				if(mysqli_num_rows($query) > 0){
					header("Location: lists.php");
				}else{
					say("Username doesn't exists or wrong password");
				}
			}
		}
		function say($str){
			echo "<script> document.getElementById('notice').textContent = '" . $str . "';</script>";
		}
		function validate($str){
			$_db = mysqli_connect("localhost", "root", "", "ryses");
			$from_arr = array("<",">");
			$to_arr = array("&lt;","&gt;");
			return str_replace($from_arr, $to_arr, mysqli_real_escape_string($_db, $str));
		}
	?>
</html>