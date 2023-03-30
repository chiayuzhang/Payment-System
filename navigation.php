<?php

if(!isset($_SESSION['logged'])){  //Not login
	?>
	<div class = "container">
		    <a href="login.php"><h1 style ="position:absolute; top:15px;">Group 1 Payment System</h1></a>
			<nav class="nav">
			<ul>
			<li><a href="login.php" style="position:relative;">Login</a></li>
			</ul>
			</nav>
        </div>
<?php
}
?>
	
 <?php
		
		if(isset($_SESSION['type'])) { //if cfo login
		if($_SESSION['type']=='cfo')	{
 ?>
 <div class = "container">
		    
			<nav class="nav">
                <ul>
					<li><a href="cfo_home.php"><h1 style ="position:relative; color:white; margin-left:-35px;">Group 1 Payment System</h1></a></li>
					<li style ="margin-left:550px;"><a href ="cfo_submitPayment.php">Submit Payment</a></li>
					<li><a href ="cfo_viewInvoiceHistory.php">View Invoice</a></li>
					<li><a href ="logout.php">Log Out</a></li>
					<li>CFO</li>
                </ul>
            </nav>
        </div>
 <?php
		} }

		if(isset($_SESSION['type'])) { //if accountant login
			if($_SESSION['type']=='accountant')	{
 ?>
 <div class = "container">
			<nav class="nav">
                <ul>
					<li><a href="accountant_home.php"><h1 style ="position:relative; color:white; margin-left:-35px;">Group 1 Payment System</h1></a></li>
                    <li style ="margin-left:550px;"><a href ="accountant_viewReceipt.php">View Receipt</a></li>
					<li><a href ="accountant_viewInvoice.php">View Invoice</a></li>
					<li><a href ="logout.php">Log Out</a></li> 
					<li>Accountant</li>
                </ul>
            </nav>
        </div>
 <?php
		} }
?>

<?php 
	if(isset($_SESSION['type'])) { //if vendor login
		if($_SESSION['type']=='vendor')	{
?>
<div class = "container">
			<nav class="nav">
                <ul>
					<li><a href="vendor_home.php"><h1 style ="position:relative; color:white; margin-left:-35px;">Group 1 Payment System</h1></a></li>
                    <li style ="margin-left:300px;"><a href="vendor_submitReceipt.php">Submit Receipt</a></li>
					<li><a href ="vendor_submitInvoice.php">Submit Invoice</a></li>
					<li><a href ="vendor_paymentHistory.php">Payment History</a></li>
					<li><a href ="logout.php">Log Out</a></li>
					<li>Vendor</li>
                </ul>
            </nav>
        </div>
 <?php
		} }
?>

<?php 
	if(isset($_SESSION['type'])) { //if vendorManager login
		if($_SESSION['type']=='vmanager')	{
?>
<div class = "container">	
			<nav class="nav">
                <ul>
					<li><a href="vendorManager_home.php"><h1 style ="position:relative; color:white; margin-left:-35px;">Group 1 Payment System</h1></a></li>
					<li style ="margin-left:450px;"><a href="vendorManager_previewInvoice.php">Preview Invoice</a></li>
					<li><a href ="vendorManager_paymentHistory.php">View Payment</a></li>
					<li><a href ="logout.php">Log Out</a></li>
					<li>Vendor Manager</li>
                </ul>
            </nav>
        </div>
 <?php
		} }
?>