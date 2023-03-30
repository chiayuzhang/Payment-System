<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "payment_system");
$email = "";
$name = "";

if(isset($_POST['logbtn'])){
	$username = $_POST['username'];
	$pass = $_POST['password'];
	$type = $_POST['type'];
	
	if($type =='cfo'){
		$users = mysqli_query($connect,"SELECT * FROM cfo WHERE C_Username = '$username' AND password = '$pass'");
		if(mysqli_num_rows($users)==0){
			?>
			<script type="text/javascript">
				alert("Account not available!");
			</script>
			<?php
		}else{
			$user = mysqli_fetch_assoc($users);

			 $_SESSION['logged'] = 'true';
			 $_SESSION['type'] = 'cfo';
			 $_SESSION['id'] = $user['cfoID'];
			 header('Location:cfo_home.php');
		}
	}
	if($type =='accountant'){
		$users = mysqli_query($connect,"SELECT * FROM accountant WHERE AC_Username = '$username' AND password = '$pass'");
		if(mysqli_num_rows($users)==0){
			?>
			<script type="text/javascript">
				alert("Account not available!");
			</script>
			<?php
		}else{
			$user = mysqli_fetch_assoc($users);

			 $_SESSION['logged'] = 'true';
			 $_SESSION['type'] = 'accountant';
			 $_SESSION['id'] = $user['accID'];
			 header('Location:accountant_home.php');
		}
	}
	if($type =='vendor'){
		$users = mysqli_query($connect,"SELECT * FROM vendor WHERE V_Username = '$username' AND password = '$pass'");
		if(mysqli_num_rows($users)==0){
			?>
			<script type="text/javascript">
				alert("Account not available!");
			</script>
			<?php
		}else{
			$user = mysqli_fetch_assoc($users);

			 $_SESSION['logged'] = 'true';
			 $_SESSION['type'] = 'vendor';
			 $_SESSION['id'] = $user['vendorID'];
			 header('Location:vendor_home.php');
		}
	}
	if($type =='vmanager'){
		$users = mysqli_query($connect,"SELECT * FROM vmanager WHERE VM_Username = '$username' AND password = '$pass'");
		if(mysqli_num_rows($users)==0){
			?>
			<script type="text/javascript">
				alert("Account not available!");
			</script>
			<?php
		}else{
			$user = mysqli_fetch_assoc($users);

			 $_SESSION['logged'] = 'true';
			 $_SESSION['type'] = 'vmanager';
			 $_SESSION['id'] = $user['vmanagerID'];
			 header('Location:vendorManager_home.php');
		}
	}
	
			
}
?>