<?php require_once "controllerUserData.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CFO Submit Payment</title>
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
		
    #textbox1, #textbox2 {
        display: block;
        float: left;    
        width: 100px;    
        height: 100px;    
    }
		
    .grid-container {
		margin-top:25px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(4, 1fr);
        grid-gap: 10px;
        padding-bottom: 5px;
        padding-right: 450px;
        padding-left: 450px;
    }

    .grid-item {
        text-align: left;
		font-size:16px;
		margin-top:15px;
    }
		
    .a{
        text-decoration: none; 
        font-size: 20px;
		color:black;
		font-family: Agency FB;
		font-weight: bold;
	}
	
	select, input{
		font-size:13px;
		border: 1px solid black!important;
	}
		
	input#paymentID:hover{
		cursor:not-allowed;
	}
		
	button {
		font-family: Agency FB;
        border: 2px solid black!important;
        border-width: 5px;
        outline-color: black;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 40px 80px;
        cursor: pointer;
        font-weight: bold;
		border-radius:20px;
		font-size:20px;
		background:#90EE90;	
	}
		
    </style>

    <body>
	    <header>
		<?php 
			include "navigation.php"; 
        ?>
		</header>
		
        <h2><center style="margin-top:125px; font-family: Agency FB; font-size:35px; font-weight: bold;">Please Enter Payment Details</center></h2>
        <br>
        <?php 
        include 'connection.php';

        if(isset($_POST["submit"])){
            // $result = mysqli_query($connect,"SELECT * FROM invoice");
            // $paymentID = $_POST['paymentID'];
            $paymentDate = $_POST["paymentDate"];
            $paymentType = $_POST["paymentType"];
            $cfoID = $_SESSION['id'];
            $companyID = $_POST["companyID"];
            $invoiceID  = $_POST["invoiceID"];

            
            $query = "INSERT INTO `payment` (`paymentDate`, `paymentStatus`, `paymentType`, `cfoID`, `companyID`, `invoiceID`)
            VALUES ('$paymentDate', 'Pending', '$paymentType', '$cfoID', '$companyID', '$invoiceID')";


            $result = mysqli_query($connect,$query);

            echo'<script type="text/javascript">
            alert("Payment has been submitted!");
            </script>';

        
            }
        ?>
	

        <form action="cfo_submitPayment.php" method="POST"><center>
            <div class="grid-container">
            <div class="grid-item">                
                <label for = "Invoice ID"> Invoice ID : </label>
            </div>
            
            <div class="grid-item">
                    <select id="invoiceID" name="invoiceID" style="width:15rem;" required>
                        <option value ="" disabled selected>-- Select an Invoice --</option>
                        <?php
                        //For Selection Wheel to Select Companies       

                            $query = "SELECT invoiceID FROM invoice";
                            $invoice_result = mysqli_query($connect, $query);
                            
                            while ($row = mysqli_fetch_assoc($invoice_result)) {
                                //$companyID = $row["companyID"];
                                echo "<option value='" . $row['invoiceID'] . "'>" . $row['invoiceID'] . "</option>";                            }
                        ?>
                    </select>
                </div>

            <div class="grid-item">
                <label for = "paymentID"> Payment ID : </label>
            </div>
            <div class="grid-item">
                <?php
                    $payment_query= "SELECT MAX(paymentID) as lastPaymentID FROM payment";
                    $payment_result = mysqli_query($connect, $payment_query);
                    $payment_row = mysqli_fetch_assoc($payment_result);
                    $lastPaymentID = $payment_row['lastPaymentID'];
                    $lastPaymentID = $lastPaymentID + 1;
                    echo "<input type='text' id='paymentID' style='width:11.5rem;' value='$lastPaymentID' readonly></input>";
                ?> 
            </div>
			
			<div class="grid-item">
                <label for = "Company Name"> Company Name : </label>
            </div>
            
            <div class="grid-item">
            <select id="companyID" name="companyID" style="width:15rem;" required>
                        <option value="" disabled selected>-- Select a Company --</option>
                        <?php
                        //For Selection Wheel to Select Companies       

                            $query = "SELECT companyID, companyName FROM company";
                            $company_result = mysqli_query($connect, $query);
                            
                            while ($row = mysqli_fetch_assoc($company_result)) {
                                //$companyID = $row["companyID"];
                                echo "<option value='" . $row['companyID'] . "'>" . $row['companyName'] . "</option>";
                            }
                        ?>
                </select>            
            </div>
			
            <div class="grid-item">
                <label for = "paymentDate"> Payment Date : </label>
            </div>
            <div class="grid-item">
                <input type = "date" id = "ap_date" name = "paymentDate" style="text-transform:uppercase;"  required>
            </div>
            

            <div class="grid-item">
                <label for = "paymentType"> Payment Type : </label>
                </div>
                <div class="grid-item">
                    <select required class="form-input" id = "paymentType" name = "paymentType" width = "16" required>
						<option value="" disabled selected>-- Select Payment Type --</option>
                        <option value="Card">Card</option>
                        <option value="Cash">Cash</option>
                        <option value="Online">Online</option>
                    </select>
                </div>
	
            <br>
                </div>
                <div>
                    <button onclick="window.location.href='cfo_home.php';" type="cancel" name= "cancel payment" style ="background-color:#d3d3d3;"> Cancel </button>
                    <button type="submit" name="submit"> Submit Payment</button>
                </div>
        </center>    
        </form>
			<script src="script.js"></script>
			<script type="text/javascript">
			var today = new Date();
			var dd = String(today.getDate()).padStart(2, '0');
			var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
			var yyyy = today.getFullYear();

			today = yyyy+'-'+mm+'-'+dd;
			document.getElementById('ap_date').value = today;
			document.getElementById("ap_date").setAttribute("min", today);

			</script>
    </body>
</html>    

