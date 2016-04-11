<?php

$msg = "No Document submitted.";
$docs = "No Document submitted.";
$path = "";
$filePath = "";


if(isset($_POST['submit']))
{
		$path = "docs/";
		if (!is_dir($path)) 
		{
			mkdir($path);
		}
		
    if(count($_FILES['upload']['name']) > 0){
        //Loop through each file
        for($i=0; $i<count($_FILES['upload']['name']); $i++) {
          //Get the temp file path
            $tmpFilePath = $_FILES['upload']['tmp_name'][$i];

            //Make sure we have a filepath
            if($tmpFilePath != ""){
            
                //save the filename
                $shortname = $_FILES['upload']['name'][$i];

                //save the url and the file
                $filePath = $path . date('d-m-Y-H-i-s').'-'.$_FILES['upload']['name'][$i];

                //Upload the file into the temp dir
                if (move_uploaded_file($tmpFilePath, $filePath)) 
				{
					$shortnames[] = $shortname;  
					$files[] = $filePath;  
                }
              }
        }
    }

    //show success message   
    if(is_array($files)){
        $msg = '<ul>';
        $docs = '<ul>';
		$i = 0;
        foreach($files as $file){
           // $msg = $msg. "<li>$file</li>";
		   $msg = $msg. "<li><a href='../". $file."' target='_blank'>".  $shortnames[$i]."</a></li>";
		   $docs = $docs. "<li><a href='". $file."' target='_blank'>".  $shortnames[$i]."</a></li>";
		   $i++;
        }
        $msg = $msg. '</ul>';
        $docs = $docs. '</ul>';
    }
}
?>



<div class="panel panel-default">
  <div class="panel-heading"><h3>Add New Borrower</h3></div>
  <div class="panel-body">
		
	  <form action = "" method = "POST" enctype = "multipart/form-data">
		 <table>
			 <tr>
				 <td><label for='upload'>Borrower Scanned Document for Proof:</label>
					<input id='upload' name="upload[]" type="file" multiple="multiple" /></td>
				 <td><input type="submit" name="submit" value="Submit" class="btn btn-primary" value="Upload" style="margin:15px;"></td>
			 </tr>
		 </table>
      </form>
	  
  	<!-- .form-->
	<form action="../custom/insert_borrower.php" method = "POST" enctype = "multipart/form-data" onsubmit="return validateForm()" name="mainform" id="mainform">
		<div class="col-md-12">
			<div class="box box-warning">
				<div class="box-body">
					<div class="row">
						<?php echo validation_errors(); ?>
					</div>
					<?php
						echo form_open('borrower/save', array('name' => 'addform'));    
						if(isset($edit_news)) {
																
							echo '<input type="hidden" name="borrower_id" value="'.$id.'"/>';
						}						
					?>

					<div class="form-group">
						<div class="col-md-6">
						<label>Borrower First Name <span class="text-danger">*</span></label>
						<input type="text" value="" class="form-control" id="firstname" name="firstname" placeholder="Enter Borrower First Name" required pattern="[a-zA-Z]+"/>
						</div>
						<div class="col-md-6">
						<label>Borrower Last Name <span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="" id="lastname" name="lastname" placeholder="Enter Borrower Last Name" required pattern="[a-zA-Z]+"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6" style="margin-top:20px;">
							<label>Gender</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="gender" value="male">
                                Male                   
                            </label>
                         
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="gender" value="female">
                                Female                   
                            </label>
						</div>
						<div class="col-md-6">
						<label>Date of Birth(YYYY-MM-DD)</label>
						<!--<input type="text" class="form-control" value="" id="dob" name="dob"  placeholder="Enter Date of Birth" required/>-->
						<input type="text" class="form-control" value="" name="dob" id="dp1" data-date-format="yyyy-mm-dd" placeholder="1990-01-01" pattern="\d{4}-\d{1,2}-\d{1,2}">	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
						<label>Mobile <span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="" id="mobile" name="mobile" placeholder="Enter Mobile" required pattern="[789][0-9]{9}"/>
						</div>
						<div class="col-md-6">
						<label>Phone</label>
						<input type="text" class="form-control" value="" id="phone" name="phone" placeholder="Enter Phone"/>
						</div>						
                    </div>
					<div class="form-group">
						<div class="col-md-6">
						<label>Driving Licence No.</label>
						<input type="text" class="form-control" value="" id="drivinglic" name="drivinglic" placeholder="Enter Driving Licence No."/>
						</div>
						<div class="col-md-6">
						<label>Adhar Card No.</label>
						<input type="text" class="form-control" value="" id="adharno" name="adharno" placeholder="Enter Adhar Card No."/>
						</div>						
                    </div>
					<div class="form-group">
						<div class="col-md-6">
						<label>Email <span class="text-danger">*</span></label>
						<input type="email" class="form-control" value="" id="email" name="email" placeholder="Enter Email" required/>
						</div>
						<div class="col-md-6">
						<label>City</label>
						<input type="text" class="form-control" value="" id="city" name="city" placeholder="Enter City"/>
						</div>
					</div>			
					<div class="form-group">
						<div class="col-md-6">
						<label>Borrower Address</label>
						<textarea class="form-control" id="address" name="address" placeholder="Enter Borrower Address" required></textarea>						</div>
						<div class="col-md-6">
						<label>Note</label>
						<textarea class="form-control" id="note" name="note" placeholder="Enter Note"></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-6">
						<label>Borrower Documents</label><br/>
						<input  id="docs" name="docs" value="<?php echo $docs;?>" hidden></input>
						<label><?php echo $msg;?></label>
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
	$('#dp1').datepicker();
</script>