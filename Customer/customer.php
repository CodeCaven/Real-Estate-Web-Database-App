<?php include("../loginCheck.php");?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Ruthless Real Estate</title>

    <!-- Bootstrap -->
    <link href="../Bootstrap-3.3.6/css/bootstrap.css" rel="stylesheet"> 
	<!-- Custom styles for this template -->
    <link href="../ruthless.css" rel="stylesheet">
	<!-- Data Tables-->
	<link rel="stylesheet" type="text/css" href="../DataTables-1.10.12/css/dataTables.bootstrap.css"/>
	
	
  </head>
  
  <body>
	<?php
	include("../menu.php");
	include("../connection.php");
	$conn = oci_connect($UName,$PWord,$Db)
	or die("Couldn't logon.");
	$query = "SELECT * FROM Customer 
				ORDER BY customer_surname, customer_fname";
				//dataTables block this ordering
			
	$stmt = oci_parse($conn,$query);
	$error = false;
	if(@oci_execute($stmt))
	{
	
	?>
	<div class="container">
		<div class="page-header">
			<h3>Customer Search</h3>
		  </div>
		  <div class="row">
			<div class="col-lg-12">
			<form method="get"  action="customerEmail.php">
			  <table class="table"  id="customer">
				<thead>
				  <tr>
					<th>#</th>
					<th>Surname</th>
					<th>FirstName</th>
					<th>Home Address</th>
					<th>Suburb</th>
					<th>State</th>
					<th>PostCode</th>
					<th>Email Address</th>
					<th>Mobile</th>
					<th>Email</th>
					<th>Modify</th>
				  </tr>
				</thead>
				<tbody>
				<?php
					while ($line = oci_fetch_array($stmt))
					{
					?>
						<tr>
							<td><?php echo $line["CUSTOMER_ID"]; ?></td>
							<td><?php echo $line["CUSTOMER_SURNAME"]; ?></td>
							<td><?php echo $line["CUSTOMER_FNAME"]; ?></td>
							<td><?php echo $line["CUSTOMER_STREET"]; ?></td>
							<td><?php echo $line["CUSTOMER_SUBURB"]; ?></td>
							<td><?php echo $line["CUSTOMER_STATE"]; ?></td>
							<td><?php echo $line["CUSTOMER_PC"]; ?></td>
							<td><?php echo $line["CUSTOMER_EMAIL"]; ?></td>
							<td><?php echo $line["CUSTOMER_MOBILE"]; ?></td>
							<?php 
							if ($line["CUSTOMER_MAILINGLIST"] == "Y")
							{
							?>
							<td align="center"> <input type="checkbox" name="check[]" value="<?php echo $line["CUSTOMER_ID"]; ?>"></td>
							<?php
							}
							else
							{
							?>
								<td></td>
							<?php
							}
							?>
							<td><a href="customerUpdate.php?customerid=<?php echo $line["CUSTOMER_ID"]; ?>&Action=Update">Modify</a></td>
							
						</tr>
						<?php
					}
					?> 
				</tbody>
			  </table>
					<button class="btn btn-sm btn-primary " type="submit">Send Emails</button>
					<p></p>
				</form>
				
			  
	
	

	<?php
	}
	else
	{
		$error = true;
	}
	
	if(!$error){
	define('FPDF_FONTPATH','../fpdf17/font/');
	require('../fpdf17/fpdf.php');
	//create our new class by extending the XFPDF class
	class XFPDF extends FPDF
	{
	//create our function
	function FancyTable($header,$data)
	{
	$this->SetFillColor(255,0,0);
	$this->SetTextColor(255,255,255);
	$this->SetDrawColor(128,0,0);
	$this->SetLineWidth(.3);
	$this->SetFont('','B');
	//hard coding for width of each table cell
	$w=array(25,25,35,26,15,40,23,10);
	//use for loop to output table header using header array which we haven't created yet,
	//but is going to contain all our table field names from the database
	for($i=0;$i<sizeof($header);$i++)
	{
	//output cell with width from array (25, 35 etc), height of 7,
	//text from header array, border, move cursor to right after cell created
	//text is centred and the cell is filled with previously set fill colour
	$header[$i] = str_ireplace("CUSTOMER_","", $header[$i]);
	$header[$i] = str_ireplace("MAILING","", $header[$i]);
	$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
	}
	//output a blank line
	$this->Ln();
	$this->SetFillColor(224,235,255);
	$this->SetTextColor(0,0,0);
	$this->SetFont('');
	//we going to use this to turn the cell transparency off and on and thus alternate
	//background colours
	$fill=0;
	//using our data array (which we haven't created yet)
	foreach($data as $row)
	{
	//new cell –width from array, height = 6, data from row, left & right border
	//move cursor to right after each cell, left align contents, set transparency
	$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
	$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
	$this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
	$this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
	$this->Cell($w[4],6,$row[4],'LR',0,'L',$fill);
	$this->Cell($w[5],6,$row[5],'LR',0,'L',$fill);
	$this->Cell($w[6],6,$row[6],'LR',0,'L',$fill);
	$this->Cell($w[7],6,$row[7],'LR',0,'L',$fill);
	$this->Ln();
	$fill=!$fill;
	}
	$this->Cell(array_sum($w),0,'','T');
	}
	}
	

	$query = "SELECT customer_surname, customer_fname, customer_street,
					customer_suburb, customer_state, customer_email, customer_mobile, customer_mailingList FROM Customer
					ORDER BY customer_mailingList, customer_surname";
	$stmt = oci_parse($conn,$query);
	$pdferror = false;
	if(@oci_execute($stmt)){
	
	$nrows = oci_fetch_all($stmt,$results);
	
	if ($nrows> 0)
	{
	
	$data = array();
	$header= array();
	
	while(list($column_name) = each($results))
	{
		$header[]=$column_name;
	}
	reset($results);
	
	for($i = 0; $i < $nrows; $i++){
		$data[$i][0] = $results["CUSTOMER_SURNAME"][$i];
		$data[$i][1] = $results["CUSTOMER_FNAME"][$i];
		$data[$i][2] = $results["CUSTOMER_STREET"][$i];
		$data[$i][3] = $results["CUSTOMER_SUBURB"][$i];
		$data[$i][4] = $results["CUSTOMER_STATE"][$i];
		$data[$i][5] = $results["CUSTOMER_EMAIL"][$i];
		$data[$i][6] = $results["CUSTOMER_MOBILE"][$i];
		$data[$i][7] = $results["CUSTOMER_MAILINGLIST"][$i];
	}
	
	$pdf=new XFPDF();
	$pdf->Open();
	$pdf->SetFont('Arial','',8);
	$pdf->AddPage();
	$pdf->FancyTable($header,$data);
	$pdf->Output("CustomerTable.pdf"); 
	
	}
	
	?>
				<div class="container">
				<div class="row">
				<div class="col-4">
				
				<form action="CustomerTable.pdf" target="_blank">
					<button class="btn btn-sm btn-success " type="submit">Click for PDF</button>
				</form>
				</div>
				</div>
				</div>
	<?php
	}
	else
	{
		$pdferror = true;
		// if true, pdf button won't be displayed
	}
	}
	if($error)
	{
	?>
		<div class="container">
				<div class="row">
				<div class="col-4">
					<p class="text-success bg-danger text-center">Oops there was a problem, please try again later.</p>
					<input  class="btn btn-sm btn-info" type="button" value="Retry"
						OnClick="window.location='/RuthlessRealEstate/main.php'">
				</div>
				</div>
			</div>
	
	<?php
	
	
	}
	?>
	</div>
		</div>
	</div>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jQuery-2.2.3/jquery-2.2.3.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../Bootstrap-3.3.6/js/bootstrap.js"></script>
    <!-- Data Tables-->
	<script type="text/javascript" src="../DataTables-1.10.12/js/jQuery.dataTables.js"></script> 
	<script type="text/javascript" src="../DataTables-1.10.12/js/dataTables.bootstrap.js"></script> 
	<script src="dataTableCustomer.js"></script> 
	
</body>
</html>