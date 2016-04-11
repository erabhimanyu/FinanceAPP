<?php 

$totalLoanAmount = 0;
foreach ($Sponmoney as $bloan)
{
$totalLoanAmount = $bloan['amount'] +$totalLoanAmount; 
}
?>
<div class="box" >
<center><h2 style="margin-left:20px;">Total SRP Amount: <br><strong>Rs. <?php echo $totalLoanAmount;?></strong></h2>
</center>
</div>
<div class="container-fluid">
<div class="box"style="padding-left:20%;">

		<div style="width:20%;display:inline-table;">
					<form role="form" action = "<?php echo base_url();?>uploaded_capital/insertdonor" method = "POST">
					<center><h2 style="margin-left:20px;">Register Donor</strong></h2>
					  <div class="form-group">
						<label>Name:</label>
						<input type="text" class="form-control" name="Sname" id="Sname">
					  </div>
					  <div class="form-group">
						<label for="pwd">Title:</label>
						<input type="text" class="form-control" name="title" id="title">
					  </div>
					  <div class="form-group">
						<label for="pwd">Contact:</label>
						<input type="text" class="form-control" name="contact" id="contact">
					  </div>
					  <button type="submit" class="btn btn-default">Add</button>
				 
				</form>
		</div>
		<div style="display:inline-table; float:right;padding-right:30%">
					
					
									<form action = "<?php echo base_url();?>uploaded_capital/insertdata" method = "POST"><br>
<div class="col-md-12" style= "left: 50%;">

<div class="form-group">
  
  <label>Name:<span class="text-danger">*</span></label><br>
  <select name="id">
  <?php
  if(empty($Sponname)){
		echo "<option>No register Donor</option>";}
					else{
		foreach ($Sponname as $donor)
					{
	?>				
  <option value="<?php echo $donor['id'];?>"><?php echo $donor['name'];?></option>
 <?php }}?>
</select>
  <br>
  <label>Amount:<span class="text-danger">*</span></label>
  <br>
  <input type="text" name="amount"><span class="text-danger"> <?php 
					if (isset($amount_error)){
					echo $amount_error;
						}					
							?></span>
  <br>
  <label>Type:<span class="text-danger">*</span></label>
  <br>
  <input type="radio" name="type" value="Individual" checked>Individual<br>
  <input type="radio" name="type" value="Group">Group<br>
  
						<input type="submit" name="submit"  class="btn btn-primary" value="Add" style="margin-top:5px;">
						<span>
						<?php 
					if (isset($im)){
					echo $im;
						}					
							?>
							</span>

  </div></div></form>
					
					
					
		</div>


</div>

</div>
<br><br>

<div class="box">
	<table width="100%"> 
		
		<tr>
			<td width="50%" style="border-right:1px solid;">
				
					
				<div class="box-body table-responsive">
		<table id='tab1' class='table table-bordered'>
			<thead>
				<tr>
					<th>Sponsor Name</th>
				  	<th>Amount</th>
				  	<th>Individual/Group</th>
				  	
				  	
				  		
				</tr>
			</thead>
			<tbody>
				<?php
					if(empty($sponsor)):
						echo "<tr><td colspan='7' align='center'>No Record Found!</td></tr>";
					else :
					foreach ($sponsor as $spon)
					{
				?>					
				<tr>
				  	<td><?php echo $spon['name'];?></td>
				  	<td><?php echo $spon['amount']; ?></td>
					<td><?php echo $spon['type']; ?></td>
				  	
					
				</tr>	
				<?php } endif; ?>								
			</tbody>
		</table>
	</div>	


	
				
		
				
			
			</td>
			</head>
			
			
			
			
			
			<td width="50%">
				<div id="chart_div1" style="width: 400px; height: 200px;">
				
		
				
<form action = "<?php echo base_url();?>uploaded_capital/insertdata" method = "POST"><br>
<div class="col-md-12" style= "left: 50%;">

<div class="form-group">
  
  
  <select name="id">
  <?php
  if(empty($Sponname)){
		echo "<option>No register Donor</option>";}
					else{
		foreach ($Sponname as $donor)
					{
	?>				
  <option value="<?php echo $donor['id'];?>"><?php echo $donor['name'];?></option>
 <?php }}?>
</select>
  <br>
  <label>Amount:<span class="text-danger">*</span></label>
  <br>
  <input type="text" name="amount"><span class="text-danger"> <?php 
					if (isset($amount_error)){
					echo $amount_error;
						}					
							?></span>
  <br>
  <label>Type:<span class="text-danger">*</span></label>
  <br>
  <input type="radio" name="type" value="Individual" checked>Individual<br>
  <input type="radio" name="type" value="Group">Group<br>
  
						<input type="submit" name="submit"  class="btn btn-primary" value="Add" style="margin-top:5px;">
						<span>
						<?php 
					if (isset($im)){
					echo $im;
						}					
							?>
							</span>

  </div></div></form>



				
				</div>	
			</td>
		</tr>
	</table>
</div>




<!--<div class="row">
    <div class="col-md-6">
		<div class="box">
		    <div class="box-header">
		        <h3 class="box-title">Next Installment(s) (This Week)</h3>
		    </div>
		    <div class="box-body table-responsive">
				<table id='tab1' class='table table-bordered table-striped'>
					<thead>
						<tr>
						  	<th>Loan</th>
						  	<th>Borrower</th>
						  	<th>Pay Amount</th>
						  	<th>Next Installment date</th>	  			
						</tr>
					</thead>
					<tbody>
						<?php
							if(empty($next_installment)):
								echo "<tr><td colspan='4' align='center'>No Record Found!</td></tr>";
							else :
							foreach ($next_installment as $ninsta)
							{
						?>					
						<tr>
						  	<td><a href="<?php echo base_url().'loan/view/'.$ninsta['loan_id'];?>"><?php echo $ninsta['loanname'];?></a></td>
						  	<td><a href="<?php echo base_url().'borrower/index/'.$ninsta['borrower_id'];?>"><?php echo $ninsta['firstname'] ." ". $ninsta['lastname'];?></a></td>
						  	<td><?php echo $ninsta['pay_amount']; ?></td>
						  	<td><?php $date = date_create($ninsta['nextdate']); echo date_format($date,"d-m-Y");?></td>
						</tr>	
						<?php } endif; ?>								
					</tbody>
				</table>
			</div>
		</div>    	
    </div>
    <div class="col-md-6">
		<div class="box">
		    <div class="box-header">
		        <h3 class="box-title">Payoff (This Week)</h3>
		    </div>
		    <div class="box-body table-responsive">
				<table id='tab1' class='table table-bordered table-striped'>
					<thead>
						<tr>
						  	<th>Loan</th>
						  	<th>Borrower</th>
						  	<th>Pay Amount</th>
						  	<th>Payoff date</th>	  			
						</tr>
					</thead>
					<tbody>
						<?php
							if(empty($payoff)):
								echo "<tr><td colspan='4' align='center'>No Record Found!</td></tr>";
							else :
							foreach ($payoff as $payoff)
							{
						?>					
						<tr>
						  	<td><a href="<?php echo base_url().'loan/view/'.$payoff['loan_id'];?>"><?php echo $payoff['loanname'];?></a></td>
						  	<td><a href="<?php echo base_url().'borrower/index/'.$payoff['borrower_id'];?>"><?php echo $payoff['firstname'] ." ". $payoff['lastname'];?></a></td>
						  	<td><?php echo $payoff['payoff_amount']; ?></td>
						  	<td><?php $date = date_create($payoff['payoff_date']); echo date_format($date,"d-m-Y");?></td>
						</tr>	
						<?php } endif; ?>								
					</tbody>
				</table>
			</div>
		</div>    	
    </div>
</div>-->


