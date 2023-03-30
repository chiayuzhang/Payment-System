<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vendor View Payment History Page</title>
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
		
        .column{
            float: left;
            width: 50%;
        }
        
        .column1{
            float: right;
            width: 20%;
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
			background:#90EE90;
		}
		
		input{
			border:1px solid black!important;
		}
		
		.btnsearch{
		background-color:#0000FF;
		color:white;
		font-size:14px;
		cursor:pointer;
		width:6rem;
		}

  
        
    </style>


</head>

    
<body>

	<header>
	<?php 
		include "navigation.php"; 
	?>
	</header>
	
	<div style ="margin-top:110px; margin-left:65px;"><h1>View Payment History</h1></div>

		
		
		<div>
		<form method="POST">
		<input type="text" name="valuesearch" placeholder="Enter ID" class ="" style="margin-left:800px; margin-top:20px;">
		<input type="submit" name="btnsearch" value="search" class ="btnsearch">
		</form>
		</div>
        <br><br>
		
        
		<div>
			<div>
            <center>
				<table style = "width : 90%">
					<thead>
						<tr>
                        <th>Action</th>
                        <th>Payment ID</th>
                        <th>Payment Type</th>
                        <th>Payment Date</th>
                        <th>Payment Status</th>
                        <th>Invoice ID</th>
                        <th>Total Paid(RM)</th>
						</tr>
					</thead>
			<?php
			
			include 'connection.php';
			
			if(isset($_POST['btnsearch']))
			{
				$valuesearch = $_POST['valuesearch'];
				$result = mysqli_query($connect, "SELECT * FROM `payment` WHERE `paymentID` LIKE'%$valuesearch%'");
			}
			else
			{
				$result = mysqli_query($connect, "SELECT * FROM payment");
			}
			
        
			while($row = mysqli_fetch_assoc($result))
			{
			?>		
                    <?php
                    $invoice_result = mysqli_query($connect, "SELECT * FROM invoice WHERE paymentID = '{$row['paymentID']}' ");
                    $invoice_row = mysqli_fetch_assoc($invoice_result);
                    ?>
                    
					<tbody>
						<tr>
                        <td><a href="vendor_paymentDetail.php?view&paymentID=<?php echo $row["paymentID"];?>"><i class="fa fa-eye"></i></a></td>
							<td><?php echo $row["paymentID"];?></td>
							<td><?php echo $row["paymentType"];?></td>
							<td><?php echo $row["paymentDate"];?></td>
							<td><?php echo $row["paymentStatus"];?></td>
							<td><?php echo $row["invoiceID"];?></td>
                            <td><?php echo $invoice_row["totalPrice"];?></td>
						</tr>
						</tr>
					</tbody>
			<?php
			}
			?>
					
				</table>
                </center>
			</div>
		</div>
	</div>
    <br><br>

    <div class = "column1">
        <button type="button" style ="background-color: #38b6ff;" onclick="window.location.href='vendor_home.php';">Go Back <i class="fa-solid fa-arrow-right-from-bracket"></i></button>
        </div>
        


	
</body>
</html>
        
