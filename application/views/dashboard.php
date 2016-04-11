<?php 

$totalLoanAmount = 0;

?>
<script type="text/javascript">

      google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {

	  var data = google.visualization.arrayToDataTable([
	    ['Week', 'Amount'],
	   	<?php
	   		$i=1;
	   		foreach($totalloan as $row) {
   				echo "['".$i."',".$row['total']."],";
	   			$i++;
	   		}
	   	?>
	  ]);

	  var options = {
	    title: 'Total Loan',
	    hAxis: {title: 'Week', titleTextStyle: {color: 'red'}}
	  };

	  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

	  chart.draw(data, options);

	}
</script>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {

	  var data = google.visualization.arrayToDataTable([
	    ['Week', 'Installment'],
	   	<?php
	   		$i=1;
	   		foreach($totalinsta as $row) {
   				echo "['".$i."',".$row['totalinsta']."],";
	   			$i++;
	   		}
	   	?>
	  ]);

	  var options = {
	    title: 'Total Installment',
	    hAxis: {title: 'Week', titleTextStyle: {color: 'red'}}
	  };

	  var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));

	  chart.draw(data, options);

	}
</script>

<div class="box" style="height:100px;">
	<table width="100%"> 
		<tr>
			<td width="50%" style="border-right:1px solid;">
				<div id="chart_div0" style="width:100%; height: 200px; ">
					<div>
						<table>
							<tr>
								<td>
									<h4 style="margin-left:20px;"><strong>Total Capital</strong></h4>
								</td>
								
							</tr>
							<tr>
								<td>
									
									<?php 
									$totalLoanAmount = 0;
									foreach ($borrowerloan as $bloan)
										{
											$totalLoanAmount = $bloan['amount'] +$totalLoanAmount; 
										}
									?>
									<h4 style="margin-left:20px;"><strong>Rs. <?php echo $totalLoanAmount;?></strong></h4>
								</td>
								
							</tr>
						</table>
					</div>
            
				</div>
			</td>
			<td width="50%">
				<div id="chart_div00" style="width: 100%; height: 200px;">
					<div>
						<table>
							<tr>
								<td>
									<h4 style="margin-left:20px;"><strong>Total Lent Amount</strong></h4>
								</td>
								
							</tr>
							<tr>
								<td>
									<?php 
									$totalLoanAmount = 0;
									foreach ($borrowerloan as $bloan)
										{
											$totalLoanAmount = $bloan['amount'] +$totalLoanAmount; 
										}
									?>
									<h4 style="margin-left:20px;"><strong>Rs. <?php echo $totalLoanAmount;?></strong></h4>
								</td>
								
							</tr>
						</table>
					</div>
					
				</div>	
			</td>
			
		</tr>
	</table>
		
		
</div>

<div class="box">
	<table width="100%"> 
		<tr>
			<td width="50%" style="border-right:1px solid;">
				<div id="chart_div" style="width:400px; height: 200px;"></div>
			</td>
			<td width="50%">
				<div id="chart_div1" style="width: 400px; height: 200px;"></div>	
			</td>
		</tr>
	</table>
</div>

<div class="box">
    <div class="box-header">
        <h3 class="box-title">UnPaid Interest \ Installments </h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">  	
		
		<table id='tab1' class='table table-bordered'>
			<thead>
			  <tr class = "active">
			  <th colspan = "15"><center>Notifications</center></th>
			  </tr>
			  <tr>
			  	<th>#</th>
			  	<th>Borrower</th>
			   	<th>Loan Amount</th>
			  	<th>Loan Type</th>
			  	<th>Remaining Loan</th>
			  	<th>Rate</th>
				<th>Amount Payable</th>
			  	
			  </tr>
			</thead>
			<tbody>
				<?php 
				$i = 1;
				$count = 0;
				foreach ($installment as $insta){
					$check = 1;
				if(!($insta['type'] == "Charity")){	
					foreach ($install as $in) {
				if (($in['loan_id'] == $insta['loan_id']) and ($in['borrower_id'] == $insta['borrower_id'])) {
					$check = 0;
					$date = $in['paid_date'];
					$dateMonth = getMonth($date);
					$currentMonth = getMonth(date('y-m-d'));
					$balance = $in['pay_amount'];
					if($dateMonth<$currentMonth){
					$count = $count +1;
					echo "<td>",$i,"</td>";
					echo "<td>",$insta['firstname'],"</td>";
					echo "<td>",$insta['amount'],"</td>";
					echo "<td>",$insta['type'],"</td>";
					echo "<td>",$in['remaining_amount'],"</td>";
					echo "<td>",$insta['rate'],"</td>";
					echo "<td>",round($insta['rate']*$in['remainining_amount']/100)*($currentMonth-$dateMonth),"</td>";
					$i = $i +  1;
					break;
					}elseif (($dateMonth==$currentMonth) and !($in['paid_amount'] == $in['pay_amount']) and $in['installment'] == 0) {
						echo "<td>",$i,"</td>";
						echo "<td>",$insta['firstname'],"</td>";
						echo "<td>",$insta['amount'],"</td>";
						echo "<td>",$insta['type'],"</td>";
						echo "<td>",$in['remaining_amount'],"</td>";
						echo "<td>",$insta['rate'],"</td>";
						echo "<td>",$in['pay_amount']-$in['paid_amount']+$in['balance'],"</td>";
						$i = $i + 1;
						$count = $count +1;
						break;
					}
					else if(($dateMonth==$currentMonth) and ($in['installment'] > 0) and $in['paid_amount'] ==0 and $in['balance'] > 0){
						echo "<td>",$i,"</td>";
						echo "<td>",$insta['firstname'],"</td>";
						echo "<td>",$insta['amount'],"</td>";
						echo "<td>",$insta['type'],"</td>";
						echo "<td>",$in['remaining_amount'],"</td>";
						echo "<td>",$insta['rate'],"</td>";
						echo "<td>",$in['balance'],"</td>";
						$i = $i + 1;
						$count = $count +1;
						break;
					}else{
					
					}
							
				
				}
				
				
				
				}
				
				if ($check == 1){
				$date = $insta['start_date'];
				
				$dateMonth = getMonth($date);
				$dateYear = getYear($date);
				$currentYear = getYear(date('Y-M-D'));
				$currentMonth = getMonth(date('y-m-d'));
				$diffYear = ($currentYear-$dateYear);
				$diffMonth = $diffYear*12 + $currentMonth - $dateMonth;
				if($currentYear > $dateYear || ($currentYear == $dateYear and $currentMonth > $dateMonth)){
					$count = $count +1;
					echo "<td>",$i,"</td>";
					echo "<td>",$insta['firstname'],"</td>";
					echo "<td>",$insta['amount'],"</td>";
					echo "<td>",$insta['type'],"</td>";
					echo "<td>",$insta['amount'],"</td>";
					echo "<td>",$insta['rate'],"</td>";
					echo "<td>",round(($insta['rate']*$insta['amount'])/100)*($diffMonth),"</td>";
					$i = $i +  1;
					
					}}
								
				}
				?>
				
				
				
				
				
			</tbody>
			<?php } 
			if ($count == 0) {
			echo "<tr><td colspan='15' align='center'>No Record Found!</td></tr>";
			}
			
			?>
		</table>
		
	<br><br>
		<h3>Loan Installment List</h3>
		<?php 
		foreach ($installment as $insta){
		
		?>
		<table id='tab1' class='table table-bordered'>
			<thead>
			  
			  <tr class = "active">
				
			  	<th class="active">Type:</th>
				<th class="info"><?php echo $insta['type']; ?></th>
			  	
				<th class="active">Borrower Name:</th>
				<th><a href="<?php echo base_url().'borrower/index/'.$insta['borrower_id'];?>"><?php echo $insta['firstname'] ." ". $insta['lastname'];?></a></th>
				<th class="active">Contact:</th>
				<th><a href="<?php echo base_url().'borrower/index/'.$insta['borrower_id'];?>"><?php echo $insta['mobile']?></a></th>
				<th class="active">Loan amount:</th>
				<th><?php echo $insta['amount'];?></th>
				<th class="active">Rate:</th>
				<th><?php echo $insta['rate'];?>%</th>
				<th colspan = "1"></th>
			  	
			  <tr>
			  	<th>#</th>
			  	<th>Date</th>			  	
			  	<th>Remaining Loan</th>
			  	<th>Rate</th>
				<th>Old Balance</th>
			  	<th>Interest</th>
				<th>Installment Received</th>
			  	<th>Balance Interest</th>
				<th>Interest Recieved</th>
			  	<th>Remarks</th>
			  	<th>Status</th>
			  </tr>
			</thead>
			<tbody>
			<?php 
			$i = 1;
			$pay = 0;
					$paid = 0;
					$totalpaid = 0;
					$totalpay = 0;
					$date = 0;
					$totalInstallment = 0;
					$oldBalance = 0;
					$remaining = $insta['amount'];
					$Paidinstallment = 0;
					$interest = round(($insta['amount']*$insta['rate'])/100);
					foreach ($install as $in) {
					
					if (($in['loan_id'] == $insta['loan_id']) and ($in['borrower_id'] == $insta['borrower_id'])) {
					$paid = $in['paid_amount'];
					
			
			?>
			<td><?php echo "".$i;?></td>
			<td><?php echo $in['paid_date'];?></td>
			<td><?php echo $in['remaining_amount'];?></td>
			<td><?php echo $insta['rate'];?></td>
			<td><?php echo $in['balance'];?></td>
			<td><?php echo $in['pay_amount'];?></td>	
			<td><?php echo $in['installment'];?></td>
			<td><?php echo $in['pay_amount'] + $in['balance'];?></td>
			<td><?php echo $in['paid_amount'];?></td>
			<td></td>
			<td></td>
			
			</tbody>
			<?php $i = $i + 1;} } if($i == 1){ echo "<tr><td colspan='15' align='center'>No Record Found!</td></tr>";}?>
		</table><br><br>
		<?php }?>
		
		

		
	</div>
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