<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Report</title>
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
	
	button {
		margin-top:20px;
		margin-left:400px;
		font-family: Agency FB;
		border: 2px solid black!important;
		border-width: 5px;
		outline-color: black;
		padding: 8px 10px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		cursor: pointer;
		font-weight: bold;
		border-radius:20px;
		font-size:16px;
		background:#90EE90;
		position:absolute;
	}
	
	
	input:hover{
	cursor:not-allowed;
	}

    .grid-container {
        border-style: dotted;
        border-width: 5px;
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        grid-template-rows: repeat(2, 1fr);
        grid-gap: 10px;

        padding-bottom: 5px;
        padding-right: 450px;
        padding-left: 450px;

    }
    .grid-item{

    }

    table,th,td {
		font-size:16px;
        border:1px dotted black!important;
        border-collapse: collapse;
    }
    th, td {
        padding: 5px;
        text-align: left;
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

        $total_no_invoices = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(invoiceID) FROM invoice"));
        $total_no_invoices_expired = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(invoiceID) FROM invoice WHERE invoiceStatus = 'Expired'"));
        $total_no_invoices_paid = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(invoiceID) FROM invoice WHERE invoiceStatus = 'Approved' AND payStatus = 'Paid'"));
        $total_no_invoices_pending = mysqli_fetch_row(mysqli_query($connect, "SELECT COUNT(invoiceID) FROM invoice WHERE invoiceStatus = 'Approved' AND payStatus = 'Pending'"));
        $invoices_paid_total = mysqli_fetch_row(mysqli_query($connect, "SELECT SUM(totalPrice) FROM invoice WHERE payStatus = 'Paid'"));
        $invoices_pending_total = mysqli_fetch_row(mysqli_query($connect, "SELECT SUM(totalPrice) FROM invoice WHERE invoiceStatus = 'Approved' AND payStatus IS NULL OR payStatus = 'Pending'"));


    ?>	  
        
            
    <div align="center">
    <title>Payment Report</title>
	<div style ="margin-top:110px;"><h1>Payment Report</h1></div>
        <br><br>
        <table style="width:70%" >
        <tr>
            <th>Total Number Of Invoices :</th>
            <td><?php echo $total_no_invoices[0];?></td>
        </tr>
        <tr>
            <th>Total Number Of Invoices Past Due :</th>
            <td><?php echo $total_no_invoices_expired[0];?></td>
        </tr>
        <tr>
            <th>Invoices Paid :</th>
            <td><?php echo $total_no_invoices_paid[0];?></td>
        </tr>
        <tr>
            <th>Invoices Pending :</th>
            <td><?php echo $total_no_invoices_pending[0];?></td>
        </tr>
        <tr>
            <th>Invoice Paid In Total (RM) :</th>
            <td><?php echo $invoices_paid_total[0];?></td>
        </tr>
        <tr>
            <th>Invoices Pending In Total (RM) :</th>
            <td><?php echo $invoices_pending_total[0];?></td>
        </tr>

        </table>
        
        
        <button type="button" onclick="window.location.href='accountant_viewInvoice.php';"> Go Back <i class="fa-solid fa-arrow-right-from-bracket"></i>	</button>
    </div>
    <?php ?>

</body>


