<?php require_once "controllerUserData.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Vendor home</title>
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
        margin-top:200px;
        font-weight:bold;
        font-family:Agency FB;
        font-size:45px;
        text-transform:uppercase;
	}
	
	h2{
        margin-top:250px;
        font-weight:bold;
        font-family:Agency FB;
        font-size:45px;
        text-transform:uppercase;
	}

    .label{
        font-weight:bold;
        font-size:20px;
        text-transform:uppercase;
    }

    .button {
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
		font-size: 30px;
    }

    .button1 {
        background-color: #ffde59;
    } /* yellow */

    .button2 {
        background-color: #38b6ff;
    } /* Blue */
    .button3 {
        background-color: #90EE90;
    } /* Green */
	
	button:hover{
		background-color:white;
		text-decoration:underline!important;
		color:blue;
	}
    
	</style>
</head>

<body>
    <header>
    <?php 
        include "navigation.php"; 
    ?>
    </header>


    <h2><center style ="font-family:Agency FB; font-size:50px; font-weight: bold; margin-top:-50px;">As a Vendor , <br> do you want to: </center></h2>
    <br>
    <html>

    <div class = "container"><center>
        <div class = "row">
            <div class = "col">
                <button class="button button1" onclick="window.location.href='vendor_submitReceipt.php';">Submit Receipt</button>
                <label class="label">Or</label>
                <button class="button button2 " onclick="window.location.href='vendor_submitInvoice.php';">Submit Invoice</button>
            </div>
            <div class = "col">
            <button class="button button3 " onclick="window.location.href='vendor_paymentHistory.php';">View Payment History</button>

            </div>
        </div>
    </center></div>
    </body>
</html>
