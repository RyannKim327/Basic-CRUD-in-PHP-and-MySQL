<?php
	$_db = mysqli_connect("localhost", "root", "", "ryses");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Lists of all registered users</title>
		<link rel="stylesheet" href="styles.css">
		<style type="text/css">

		</style>
	</head>
	<body>
		<table>
			<tr>
				<th>ID</th>
				<th>Username</th>
				<td>Admin</td>
				<th></th>
				<th></th>
			</tr>
			<tr>
			<?php
				$query = mysqli_query($_db, "SELECT * FROM users");
				while($arrays = mysqli_fetch_row($query)){
					echo "<td>" . $arrays[0] . "</td>";
					echo "<td>" . $arrays[1] . "</td>";
					echo "<td>" . $arrays[3] . "</td>";
					echo "<td><a href='?delete=" . $arrays[0] . "'>Delete</a></td>";
					echo "<td><a href='update.php?user=" . $arrays[0] . "'>Update</a></td></tr><tr>";
				}
			?>
			</tr>
		</table>
	</body>
	<?php
		if(isset($_GET['delete'])){
			$id = $_GET['delete'];
			$query = mysqli_query($_db, "DELETE FROM users WHERE id = '$id'");
			if($query){
				echo "<script>alert('Deleted');</script>";
			}else{
				echo "<script>alert('" . mysqli_error($_db) . "');</script>";
			}
		}
	?>
</html>