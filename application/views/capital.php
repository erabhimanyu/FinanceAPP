<?php 

$totalLoanAmount = 0;
foreach ($Sponmoney as $bloan)
{
$totalLoanAmount = $bloan['amount'] +$totalLoanAmount; 
}
?>

<div class="panel panel-default">
  <div class="panel-heading"><h3>SRP List</h3><h4>Total SRP Amount: Rs.<?php echo $totalLoanAmount;?></h4></div>
  
  <div class="panel-heading">
  	<a href="#" class="fa fa-fw fa-refresh" onclick="window.location.reload( true );" data-toggle="tooltip" data-placement="bottom" title="Refresh"></a>
  	
  	
  	<a href="<?php echo base_url().'capital/add'; ?>" class="fa fa-fw fa-plus" data-toggle="tooltip" data-placement="bottom" title="Add New Donor"></a>
  	
	<a href="<?php echo base_url().'capital/addamount'; ?>" id="" class="fa fa-fw fa-folder-open-o" data-toggle="tooltip" data-placement="bottom" title="Add Sponsors Amount"></a>
	
  </div>
  <div class="panel-body">
	<div class="box">
	    <div class="box-body table-responsive">
			<table id='tab1' class='table table-bordered table-striped'>
				<thead>
					<tr>
						<th>Name</th>
					  	<th>Contact</th>
					  	<th>Amount</th>
					  	<th>Remark</th>
					  	<th>Date</th>
					  	  			
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
					<tr id="">
						
					  	<td><?php echo $spon['name'],"(",$spon['title'],")";?></td>
						<td><?php echo $spon['contact'];?></td>
						<td><?php echo $spon['amount']; ?></td>
						<td><?php echo $spon['remark']; ?></td>
						<td><?php echo $spon['date']; ?></td>
										  	
					</tr>		
					<?php } endif; ?>				
				</tbody>
			</table>
		</div>
		<!--<nav>
		  <ul class="pagination">
		    <li><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
		    <li><a href="#">1</a></li>
		    <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
		  </ul>
		</nav>-->
	</div>
  </div>
</div>



<script>
$(document).ready(function(){
$('#checkall').click(function(){
		$('.selectAll').each(function(event) {
			if(this.checked) {
				this.checked = false;
			}
			else {       
				this.checked = true;
			}
		});
	});
});

$(document).ready(function(){
  $('#deleteall').click(function () {
	var slvals = []
	$('input:checkbox[name^=checkID]:checked').each(function() {
	slvals.push($(this).val())
	})
	id=slvals;
	if(id.length>1 || id.length<1) {
		alert ('Select 1 record at a time!');
	}
	else {
	 var x=confirm("Are you sure to delete record?")
	  if (x) {
		$.ajax({
	      url     : base_url+"borrower/delete/",
	      type    : 'POST',
	      data    : {'id':id},
	      success : function(data){
	      	data=$.parseJSON(data);
	      	if(data.status == '1') {
	      		alert(data.message);
	      		$('#brtr'+id).remove();
	      	}
	      	else {
	      		alert(data.message);
	      	}
	      }
	    });
	  } else {
	    alert ("Delete Cancelled");
	    window.location=base_url+"borrower";
	  }	
	}
  });
});


$(document).ready(function(){
  $('#addloan').click(function () {
	var slvals = []
	$('input:checkbox[name^=checkID]:checked').each(function() {
	slvals.push($(this).val())
	})
	id=slvals;
	if(id.length>1 || id.length<1) {
		alert ('Select 1 record at a time!');
	}
	else {
		window.location=base_url+"loan/index/"+id;	
	}
  });
});

$(document).ready(function(){
  $('#editborrower').click(function () {
	var slvals = []
	$('input:checkbox[name^=checkID]:checked').each(function() {
	slvals.push($(this).val())
	})
	id=slvals;
	if(id.length>1 || id.length<1) {
		alert ('Select 1 record at a time!');
	}
	else {
		window.location=base_url+"borrower/edit/"+id;	
	}
  });
});

$(document).ready(function(){
  $('#loaninsta').click(function () {
	var slvals = []
	$('input:checkbox[name^=checkID]:checked').each(function() {
	slvals.push($(this).val())
	})
	id=slvals;
	if(id.length>1 || id.length<1) {
		alert ('Select 1 record at a time!');
	}
	else {
		window.location=base_url+"borrower/payinstallment/"+id;	
	}
  });
});

</script>