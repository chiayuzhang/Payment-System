<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>VM Payment Details</title>
<link rel="stylesheet" href="css/style.css"> <!-- css files-->
	
    <script defer src="https://use.fontawesome.com/releases/v6.2.0/js/all.js"></script> <!-- font awesome-->
	<style>
	
	h1{
		font-weight:bold;
		font-family: Agency FB;
		font-size: 30px;
		display:inline;
		margin: auto;
		width: 60%;
		padding: 10px;
	}
	
	h2{
		margin-top:30px;
		font-size:35px;
		font-family:Agency FB;
		font-weight:bold;
		color:blue;
		padding:1%
	}

    .grid-container {
		float:center;
		margin-top:-20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(2, 1fr);
        grid-gap: 10px;
        padding-left: 70px;
		width:70%;
		text-align:left;
    }
	
	.grid-item > label{
		font-weight:bold;
		font-family: Agency FB;	
		font-size:20px;
	}

    table {
            border:1px solid black;
        }

    tr:nth-child(odd) {
        background-color: #D6EEEE;
    }

    .column1{
            float: right;
            width: 10%;
        }

    .column3{
        float:left;
        width:30;
    }
	
	button, input 
		{
			font-family: Agency FB;
			border: 2px solid black!important;
			border-width: 5px;
			outline-color: black;
			padding: 8px 10px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			margin: 40px 80px;
			cursor: pointer;
			font-weight: bold;
			border-radius:20px;
			font-size:25px;
			background:#90EE90;
		}
		
	
	th,td, table{
        box-shadow: 0 10px 20px 0 rgba(0,0,0,.03);
		border-collapse: collapse;
		text-align:center;
        }
		
	th{
		font-size:17px;
		background-color:#90ee90;
		color:black;
	}
		
	td{
		font-size:15px;
		text-align:center;
		background-color:white;
	}
	
	</style>
</head>
<body>
	<header>
        <?php 
		include "navigation.php"; 
		?>

		
    </header>
    <?php
    include 'connection.php';
    
    if(isset($_GET['view']))
    {
        $id = $_GET["paymentID"];
        $result = mysqli_query($connect, "SELECT * FROM payment WHERE paymentID='$id'");
        $row = mysqli_fetch_assoc($result);

        $invoice_result = mysqli_query($connect, "SELECT * FROM invoice WHERE paymentID = '$id'");
        $invoice_row = mysqli_fetch_assoc($invoice_result);
    ?>	  
        
    <center>
	<div>
	    <div><h2 style ="margin-top:100px; margin-left:55px;">Payment Detail </h2></div>
        <br><br>
        
        <div class="grid-container">
            <div class="grid-item">
                <label for = "invoiceID"> Invoice ID : </label>
            </div>
            <div class="grid-item">
                <label><?php echo $row["invoiceID"];?></label>
            </div>

            <div class="grid-item">
                <label for = "companyID"> Company ID : </label>
            </div>   
            <div class="grid-item">
            <label><?php echo $row["companyID"];?></label>
            </div>  

            <div class="grid-item">
                <label for = "paymentID"> Payment ID : </label>
            </div>
            <div class="grid-item">
            <label><?php echo $row["paymentID"];?></label>
            </div>

            <div class="grid-item">
                <label for = "paymentDate"> Payment Date : </label>
            </div>
            <div class="grid-item">
                <label><?php echo $row["paymentDate"];?></label>
            </div>

            <div class="grid-item">
                <label for = "companyName"> Company Name : </label>
            </div>
            <div class="grid-item">
            <label><?php echo $invoice_row["companyName"];?></label> 
            </div>

            <div class="grid-item">
                <label for = "paymentType"> Payment Type : </label>
            </div>
            <div class="grid-item">
                <label><?php echo $row["paymentType"];?></label>
            </div>

            <div class="grid-item">
                <label for = "totalPrice"> Total Paid(RM) : </label>
            </div>
            <div class="grid-item">
                <label><?php echo $invoice_row["totalPrice"];?></label>
            </div>

            <div class="grid-item">
                <label for = "paymentStatus"> Payment Status : </label>
            </div>
            <div class="grid-item">
                <label><?php echo $row["paymentStatus"];?></label>
            </div>
        </div>
        
        <br><br>
        <form action = "vendorManager_paymentDetail.php" method ="POST" >    
            <input type = "hidden" name="id" value="<?php echo $id?>" />
            <input type="submit" name = "approve"  id="approvePayment" value = " Approve Payment "  />
            <input type ="submit" name = "deny"  id = "denyPayment" style="background-color: #F5A623;" value = " Deny Payment "  />
            <button type="button" name= "go back" style ="background-color:#38b6ff;" onclick="window.location.href='vendorManager_paymentHistory.php';"> Go Back <i class="fa-solid fa-arrow-right-from-bracket"></i></button>     
        </form>
    </div>
	</center>
<?php } ?>
    




<?php
if(isset($_POST['approve'])){
    $id = $_POST['id'];
    $vmanagerID = $_SESSION['id'];
    $approved = "UPDATE payment SET paymentStatus = 'Paid' WHERE paymentID = '$id'";
    $vmanagerSESSION = "UPDATE payment SET vmanagerID = '$vmanagerID' WHERE paymentID = '$id'";
    $sessionResult = mysqli_query($connect,$vmanagerSESSION);
    $result = mysqli_query($connect,$approved);
    echo'<script type="text/javascript">
    alert("Payment Approved!");
    window.location.href = "vendorManager_paymentHistory.php";
    </script>';
}
if(isset($_POST['deny'])){
    $id = $_POST['id'];

    $denied = "DELETE FROM payment WHERE paymentID = '$id'";
    $result = mysqli_query($connect,$denied);
    echo'<script type="text/javascript">
    alert("Payment has been Deleted!");
    window.location.href = "vendorManager_paymentHistory.php";
    </script>';
}
?>
</body>


