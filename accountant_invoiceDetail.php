<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice Details</title>
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
	
	.form{
		width: 100%;
		z-index: 1;
		border:3px solid blue!important;
		padding:2%;
		height:50rem;
		margin-top:10px;
	}
	
    .grid-container {
		margin-top:-20px;
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

	
	th,td, table{
            box-shadow: 0 10px 20px 0 rgba(0,0,0,.03);
			border-collapse: collapse;
			text-align:center;
        }

        tr:nth-child(odd) {
            background-color: #D6EEEE;
        }
		
		th{
			font-size:17px;
			background-color:#0000ff;
			color:white;
		}
		
		td{
			font-size:15px;
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
			font-size:20px;
			
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
        $id = $_GET["invoiceID"];
        $result = mysqli_query($connect, "SELECT * FROM invoice WHERE invoiceID='$id'");
        $row = mysqli_fetch_assoc($result);
    ?>	  
        
        
	<div>
	    <div><h2 style ="margin-top:80px;">Invoice ID: <?php echo $row["invoiceID"]; ?></h1></div>
        <br><br>
        
        <div class="grid-container" style="">
            <div class="grid-item">
                <label for = "issueDate"> Date Issued : </label>
            </div>
            <div class="grid-item">
                <label><?php echo $row["issueDate"];?></label>
            </div>
            <div class="grid-item">
                <label for = "companyID"> Company ID : </label>
            </div>   
            <div class="grid-item">
            <label><?php echo $row["companyID"];?></label>
            </div>             
            <div class="grid-item">
                <label for = "companyName"> Company Name : </label>
            </div>
            <div class="grid-item">
            <label><?php echo $row["companyName"];?></label>
            </div>
            <div class="grid-item">
                <label for = "dueDate"> Invoice Due : </label>
            </div>
            <div class="grid-item">
                <label><?php echo $row["dueDate"];?></label>
            </div>
            <div class="grid-item">
                <label for = "invoiceStatus"> Invoice Status : </label>
            </div>
            <div class="grid-item">
            <label><?php echo $row["invoiceStatus"];?></label>
            </div>
        </div>
    </div>

        <div>
            <div> <h2 style ="margin-top:10px;" >Product Details</h2> </div>

            <div><center>

                <table style = "width : 90%">
                    <tr>
                        
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price (RM)</th>
                        <th>Quantity</th>
                        <th>Total Price (RM)</th>
                    </tr>

                    <?php

                    $products = mysqli_query($connect, "SELECT * FROM product WHERE invoiceID='$id'");
                    $totalPrice_query= mysqli_query($connect, "SELECT totalPrice FROM product WHERE invoiceID='$id'");    
                    $totalPrice = 0;
                    while ($totalPrice_row = mysqli_fetch_array($totalPrice_query)){
                        $totalPrice = $totalPrice + $totalPrice_row["totalPrice"];
                        
                    }
                    
                    while($row = mysqli_fetch_array($products)) 
                    {

                    ?>

                        <tr>
                            <td><?php echo $row["productID"];?></td>
							<td><?php echo $row["productName"];?></td>
							<td><?php echo $row["price"];?></td>
							<td><?php echo $row["quantity"];?></td>
							<td><?php echo $row["totalPrice"];?></td>
                        </tr>

                    <?php 
                    
                    }
                    // reset the result set
                    mysqli_data_seek($products,0);
                
                ?>

                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Summary (RM) :</td>
                        <td><?php echo $totalPrice?></td>

                    </tr>
				
                </table>
                

            </center></div>

        </div>
        <button onclick="window.location.href='accountant_viewInvoice.php';" style ="background-color: #38b6ff; float:right;  margin-right:100px;" type="cancel" name= "cancel payment"> Go Back <i class="fa-solid fa-arrow-right-from-bracket"></i></button>            


        <?php } ?>

</body>
</html>

