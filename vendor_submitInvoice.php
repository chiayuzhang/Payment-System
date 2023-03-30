<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vendor Submit Invoice Page</title>
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
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        grid-gap: 12px;
        padding-bottom: 5px;
        padding-right: 450px;
        padding-left: 450px;
		
        }
		
		h2{
			font-weight:bold;
			font-family: Agency FB;
			font-size:35px;
		}
		
        .enterInvoice{
			margin-top:110px;
            text-align:center;
            font-size: 35px;
        }
        .enterProduct{
            padding-left: 450px;
			padding-right:450px;
            font-size: 30px;
            text-align:center;
        }
        
        .grid-item {
        text-align: left;
        font-weight: bold;
        font-size: 20px;
		width:25rem;
        }
		
		
        .form{
            text-align:center;
        }
        
        .button{
            text-align: center;
        }
		
	
	select, input{
		font-size:13px;
		border: 1px solid black!important;
		
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
			width:19%;
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
	
        <h2 class="enterInvoice">Please Enter Invoice Details</h2>
        <?php
            
            include 'connection.php';

            if(isset($_POST["submit"])){
                // $result = mysqli_query($connect,"SELECT * FROM invoice");
                $vendorID = $_SESSION['id'];
                // $productName = $_POST["productName"];
                // $quantity = $_POST["quantity"];
                // $price = $_POST["price"];
                
                for( $a = 0; $a < count($_POST["productName"]); $a++ ){
                    $query = "INSERT INTO `product` (`productName`, `quantity`, `price`) 
                    VALUES ('" . $_POST["productName"][$a] . "' , '" . $_POST["quantity"][$a] . "' , '" . $_POST["price"][$a] . "')";
                    mysqli_query($connect,$query);
                }



                $companyID = $_POST["companyID"];
                $invoiceDue = $_POST["invoiceDue"];
                $sql = "INSERT INTO `invoice` (`invoiceID`, 
                `dueDate`, 
                `issueDate`, 
                `totalPrice`, 
                `invoiceStatus`, 
                `vendorID`, 
                `paymentID`,
				`payStatus`,
                `companyID`, 
                `companyName`) 
                VALUES 
                (NULL, '$invoiceDue', NULL, NULL, NULL, '$vendorID', NULL,'Pending','$companyID',NULL)";

               
                mysqli_query($connect,$sql);

                echo'<script type="text/javascript">
                alert("Product has been submitted!");
                </script>';
            
        }
        ?>		
        <form class = "" action="" method="POST"><center>
            <div>
                <div class="grid-container" style="margin-top:25px;">
                <div class="grid-item">
                    <label for = "companyName"> Company Name : </label>
                </div>
                <div class="grid-item">
                    <label for = "invoiceID"> Invoice ID : </label>
                </div>
                <div class="grid-item">
                    <label for = "invoiceDue"> Invoice Due : </label>
                </div>
                <div class="grid-item">
                    <select id="companyID" name="companyID" required>
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
                    <?php

                        $invoice_query= "SELECT MAX(invoiceID) as lastInvoiceID FROM invoice";
                        $invoice_result = mysqli_query($connect, $invoice_query);
                        $invoice_row = mysqli_fetch_assoc($invoice_result);
                        $lastInvoiceID = $invoice_row['lastInvoiceID'];
                        $lastInvoiceID = $lastInvoiceID + 1;
                        echo "<label>$lastInvoiceID</label>";
                    ?>
                </div>
                <div class="grid-item">
                    <input type = "date" name = "invoiceDue" style ="text-transform:uppercase;" id="ap_date" required> 
                </div>
            </div>
            <br>
            <br>
            <h2 class="enterProduct">Enter Product Details: </h2>
            <br>
            
            <table id= "tableId" class = "table" border="1" align = "center">
                
                    <tr align="center">
                        <th class ="th">Product ID</th>
                        <th class ="th">Product Name</th>
                        <th class ="th">Price</th>
                        <th class ="th">Quantity</th>
                    </tr>
                <tbody id="tbody"></tbody >
            </table>
            <br>

            <button type ="cancel" style ="background-color: #38b6ff;" onclick="window.location.href='vendor_home.php'; return false;" >Cancel </button>
			<button type="button" onclick="addRow();">Add Product</button>
            <button type="submit" style ="background-color: #ffde59;" name= "submit"> Submit Invoice </button>

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
		
        var items = 1;
        function addRow(){
            
            var html="<tr align='center'>";
                html+="<td id='productId[]'>" + items + "</td>";
                html+="<td><input type='text' name='productName[]' required></td>";
                html+="<td><input type='number' step='0.01' name='price[]' required></td>";
                html+="<td><input type='number' name='quantity[]' required></td>";
            html+="</tr>";
            document.getElementById("tbody").insertRow().innerHTML = html;
            items++;
        }
    </script>

    </body>
    
    
</html>    

