<?php
	if(!isset($_GET['user'])){
		header("Location: lists.php");
	}
	$_db = mysqli_connect("localhost", "root", "", "ryses");
	$id = $_GET['user'];
	$q = mysqli_query($_db, "SELECT * FROM users WHERE ID = '$id'");
	$row = mysqli_fetch_array($q);
	$username = $row['username'];
	$password = $row['password'];
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Edit User</title>
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
		<form action="<?php echo $_SERVER['PHP_SELF'] . "?user=" . $id; ?>" method="POST">
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
						<input type="text" name="username" id="user" onkeyup="checker()" value="<?php echo $username;?>">
					</td>
				</tr>
				<tr>
					<td>
						<label for="pass">Password</label>
					</td>
					<td>:</td>
					<td>
						<input type="text" name="password" id="pass" onkeyup="checker()" value="<?php echo $password;?>">
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<input type="submit" value="Proceed" id="go">
					</td>
				</tr>
			</table>
		</form>
	</body>
	<script type="text/javascript">
		function checker(){
			let user = document.getElementById('user').value.replace(/\s/gi, "")
			let pass = document.getElementById('pass').value.replace(/\s/gi, "")
			if(user != "" && pass != ""){
				document.getElementById('go').type = "submit"
			}else{
				document.getElementById('go').type = "hidden"
			}
		}
		checker()
	</script>
	<?php
		if(isset($_POST['username']) && isset($_POST['password'])){
			$user = $_POST['username'];
			$pass = $_POST['password'];
			$query = mysqli_query($_db, "UPDATE users SET username = '$user', password = '$pass' WHERE ID = '$id'");
			if($query){
				header("Location: lists.php");
			}else{
				say($mysqli_error($_db));
			}
		}
		function say($str){
			echo "<script> document.getElementById('notice').textContent = '" . $str . "';</script>";
		}
	?>
</html>