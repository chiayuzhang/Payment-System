<?php require_once "controllerUserData.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vendor Submit Receipt</title>
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

        .column{
            float: left;
            width: 84.3%;
        }
        
        .column1{
            float: center;
            
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .grid-container {
		margin-top:20px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-template-rows: repeat(2, 1fr);
        grid-gap: 15px;
        padding-bottom: 5px;
        padding-right: 450px;
        padding-left: 450px;
    }
	
	.grid-item {
        text-align: left;
		font-size:19px;
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
		
        <h2><center style="margin-top:125px; font-family: Agency FB; font-size:35px; font-weight: bold;">Please Enter Receipt Details</center></h2>
    <script src="receiptSelection.js"></script>
        <h2><center style="margin-top:15px; font-family: Agency FB; font-size:25px; font-weight: bold;">Select An Invoice To Display Company</center></h2>

        <?php 
            include 'connection.php';

            if(isset($_POST["upload"])){
                 //$result = mysqli_query($connect,"SELECT * FROM invoice");
                if($invoiceID = $_POST["invoiceID"]){
                    $query = "INSERT INTO `receipt` (`invoiceID`)
                    VALUES ($invoiceID)";
    
                    mysqli_query($connect,$query);
    
                    echo'<script type="text/javascript">
                    alert("Receipt has been generated!");
                    </script>';
                }else{
                    echo'<script type="text/javascript">
                    alert("Please select an invoiceID again to confirm submit.");
                    </script>';
                }

            }
             // Retrieve the data for the selected invoice
             if(isset($_POST["submit"])){
                if($invoiceID = $_POST["invoiceID"]){
                    $selection_query = "SELECT * FROM invoice WHERE invoiceID = '$invoiceID'";
                    $selected_invoice = mysqli_query($connect, $selection_query);

                    $data = array();
                    while($row = mysqli_fetch_assoc($selected_invoice)){
                        $data[] = $row;
                    }

                }else{
                    echo'<script type="text/javascript">
                    alert("Please select an invoiceID!");
                    </script>';
                }


            }
        ?>	

    <form method="POST" action="vendor_submitReceipt.php">
    <div>        
        <div class="grid-container">
            <div class="grid-item">
                <label for = "invoiceID"> Invoice ID : </label>
            </div>
            <div class="grid-item">

                <select id="selectionInvoiceID" name="invoiceID" onchange="this.form.submit()">
                    <option value="" disabled>-- Select a Invoice ID --</option>
                    <?php
                    //For Selection Wheel to Select Companies       

                        $query = "SELECT invoiceID FROM invoice WHERE invoiceStatus = 'Approved' AND payStatus ='Paid'";
                        $invoice_result = mysqli_query($connect, $query);
                        
                        while ($row = mysqli_fetch_assoc($invoice_result)) {
                            //$companyID = $row["companyID"];
                            echo "<option value='" . $row['invoiceID'] . "'>" . $row['invoiceID'] . "</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="grid-item">
                <label for = "paymentIDLabel"> Payment ID : </label>
            </div>   
            <div class="grid-item">
                <input type="text" id="paymentID" name="paymentID" disabled value="<?php if(isset($data) && !empty($data) && $data[0] != NULL){echo $data[0]['paymentID'];}else{echo " ";} ?>">           
            </div>
            <div class="grid-item">
                <label for = "companyIDLabel"> Company ID : </label>
            </div>
            <div class="grid-item">
                <input type="text" id="companyID" name="companyID" disabled value="<?php if(isset($data) && !empty($data) && $data[0] != NULL){echo $data[0]['companyID'];}else{echo " ";} ?>">            
            </div>
            <div class="grid-item">
                <label for = "companyNameLabel"> Company Name : </label>
            </div>
            <div class="grid-item">
                <input type="text" id="companyName" name="companyName" disabled value="<?php if(isset($data) && !empty($data) && $data[0] != NULL){echo $data[0]['companyName'];}else{echo " ";} ?>">           
            </div>
        </div>

        <center>
            <div class = "column1">
			<button type="cancel" style ="background-color: #38b6ff;" onclick="window.location.href='vendor_home.php'; return false;" name= "cancel"> Cancel </button>
            <button type="submit" name= "submit"> Check Invoice</button>
            <button type="upload" name= "upload" style ="background-color: #ffde59;"> Submit Receipt </button>
            </div>
        </center>    
        </form>  

    </body>
    
</html>    
