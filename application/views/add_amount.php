
<div class="panel panel-default">
  <div class="panel-heading"><h3>Add sponsor amount</h3></div>
  <div class="panel-body">
		
	  
	  
  	<!-- .form-->
	<form action="<?php echo base_url();?>capital/saveamount" method = "POST" enctype = "multipart/form-data" onsubmit="return validateForm()" name="mainform" id="mainform">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-body">
					<div class="row">
						<?php echo validation_errors(); ?>
					</div>
					<?php
						echo form_open('capital/save', array('name' => 'addform'));    
						if(isset($edit_news)) {
																
							echo '<input type="hidden" name="borrower_id" value="'.$id.'"/>';
						}						
					?>

					<div class="form-group">
						<div class="col-md-6">
						<label>Donor Name <span class="text-danger">*</span></label>
						<select class= "form-control" name="id">
				<?php
					if(empty($Sponname)){
						echo "<option>No register Donor</option>";}
					else{
						foreach ($Sponname as $donor)
					{
						?>				
					<option value="<?php echo $donor['id'];?>"><?php echo $donor['name'],"(",$donor['title'],")";?></option>
						<?php }}?>
					</select>
						</div>
					<div class="form-group">
						<div class="col-md-6">
						<label>Amount in Rs.<span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="" id="title" name="amount" placeholder="Amount" required/>
						</div>
					</div>	
					</div>
					
					<div class="col-md-6">
						<label>Date</label>
						<!--<input type="text" class="form-control" value="" id="dob" name="dob"  placeholder="Enter Date of Birth" required/>-->
						<input type="text" class="form-control" value="" name="date" id="date" data-date-format="yyyy-mm-dd" placeholder="Date" pattern="\d{4}-\d{1,2}-\d{1,2}">	
						</div>
					
					<div class="form-group">
						<div class="col-md-6">
						<label>Remark<span class="text-danger">*</span></label>
						<textarea type="text" class="form-control" value="" id="remark" name="remark" placeholder="Remark" required></textarea>
						</div>
					
					</div>
									
							
					
					
					
					<div class="modal-footer">
						<input type="submit" name="submit"  class="btn btn-primary" value="Submit" style="margin-top:15px;">
					</div>		
					<?php
					echo form_close();
					?>

				</div><!-- /.box-body -->
			</div>
		</div>
	</form>
	<!-- /.form-->
  </div>
</div>
<script type="text/javascript">
	$('#date').datepicker();
</script>