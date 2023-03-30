<?php require_once "controllerUserData.php"; ?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Company View Invoice Page</title>
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
			color:#0000FF;
			font-size:22px;
			align:center;
			position:relative;
        }

        th,td, table{
            border:1px solid black!important;
			border-collapse: collapse;
			text-align:center;
        }

        tr:nth-child(odd) {
            background-color: #D6EEEE;
        }
		
		th{
			font-size:15px;
			background-color:#0000ff;
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
			margin: 20px 60px;
			cursor: pointer;
			font-weight: bold;
			border-radius:20px;
			font-size:16px;
			background:#90EE90;
			position:absolute;
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
	
	<div style ="margin-top:110px; margin-left:65px;"><h1>Invoice History</h1></div>

		
		
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
                        <th>Invoice ID</th>
                        <th>Due Date</th>
                        <th>Date Issued</th>
                        <th>Total Price(RM)</th>
                        <th>Payment Status</th>
						</tr>
					</thead>
			<?php
			include 'connection.php';
			
			if(isset($_POST['btnsearch']))
			{
				$valuesearch = $_POST['valuesearch'];
				$result = mysqli_query($connect, "SELECT * FROM `invoice` WHERE `invoiceID` LIKE'%$valuesearch%'");
			}
			else
			{
				$result = mysqli_query($connect, "SELECT * FROM invoice WHERE invoiceStatus = 'Approved'");
			}
			
			while($row = mysqli_fetch_assoc($result))
			{
			?>		
					<tbody>
						<tr>
                        <td><a href="accountant_invoiceDetail.php?view&invoiceID=<?php echo $row["invoiceID"];?>"><i class="fa fa-eye"></i></a></td>
							<td><?php echo $row["invoiceID"];?></td>
							<td><?php echo $row["dueDate"];?></td>
							<td><?php echo $row["issueDate"];?></td>
							<td><?php echo $row["totalPrice"];?></td>
							<td><?php echo $row["payStatus"];?></td>
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
        <button type="submit" style="text-align:center; margin-left:-550px;" onclick="window.location.href='accountant_paymentReport.php';"> Generate Payment Report</button>
        <button type="button" style ="background-color: #38b6ff;" onclick="window.location.href='accountant_home.php';">Go Back <i class="fa-solid fa-arrow-right-from-bracket"></i></button>
    </div>
        


	
</body>
</html>
        
