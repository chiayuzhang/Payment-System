<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vendor View Payment Details</title>
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
	
	
    .grid-container {
		margin-left:50px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(2, 1fr);
        grid-gap: 10px;
        padding-left: 15px;
		font-size:20px;
		width:70%;
    }
	
	.grid-item > label{
		font-weight:bold;
		font-family: Agency FB;	
		font-size:25px;
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
    
	.fa-eye{
			color:#008037;
			font-size:22px;
			align:center;
			position:relative;
        }

        table, th, td {
            border:1px solid black!important;
			border-collapse: collapse;
			text-align:center;
        }

        tr:nth-child(odd) {
            background-color: #D6EEEE;
        }
		
		th{
			font-size:15px;
			background-color:#008037;
			color:white;
		}
		
		td{
			font-size:13px;
			text-align:center;
			background-color:white;
		}
		
		button {
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
			font-size:16px;
			
			
		}
		
		input{
			border:1px solid black!important;
		}
		
		.btnsearch{
		background-color:#00FF00;
		color:black;
		font-size:14px;
		cursor:pointer;
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
        
        
	<div>
	    <div style ="margin-top:110px; margin-left:50px;"><h1>Payment Details</h1></div>
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
            <button type="button" style ="background-color: #38b6ff; float:right;" onclick="window.location.href='vendor_paymentHistory.php';">Go Back <i class="fa-solid fa-arrow-right-from-bracket"></i></a></button>

        </div>

    </div>
<?php } ?>
    





</body>


