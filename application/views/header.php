	<header class="header">
		<a href="<?php echo base_url(); ?>" class="logo">SRP - Finance</a>
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			    <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $this->session->userdata("name"); ?><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="treeview">
                                    <a href="#" onclick="$(myModal).modal('show');">
                                        <i class="fa fa-user"></i>
                                        <span>Change Password</span>
										
                                    </a>
                                </li>
                                <li class="treeview">
                                    <a href="<?php echo base_url().'login/logout'; ?>">
                                        <i class="fa fa-sign-out"></i>
                                        <span>SignOut</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
				
			<?php 
			
			if(isset($installment)){
			
			
			?>	
			 <div class="navbar-right">
				<ul class="nav navbar-nav">
					 <li class="dropdown user user-menu">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                
                                <span id ="notify"><?php echo "Notifications"; ?><i class="caret"></i></span>
								
                            </a>
							<ul class="dropdown-menu">
				<?php 
				
				//logic for notification
				$count = 0;
				
				foreach ($installment as $insta){
				if (!($insta['type'] == "Charity")){
				
				$check = 1;
				
				
				foreach ($install as $in) {
				
				if (($in['loan_id'] == $insta['loan_id']) and ($in['borrower_id'] == $insta['borrower_id'])) {
				
					
					$check = 0;
					$date = $in['paid_date'];
					$dateMonth = getMonth($date);
					$currentMonth = getMonth(date('y-m-d'));
					$balance = $in['pay_amount'];
					if($dateMonth<$currentMonth){
					$count = $count +1;
					
					echo "<li class=\"treeview\"></i><a href=#><span><dt>",$insta['firstname'],"</span> <br>";
					echo "<span><dl> - Amount Payable: ",round($insta['rate']*$in['remainining_amount']/100)*($currentMonth-$dateMonth),"</dl></dt></span></a></li>";
					
								
					
					
					break;
					}elseif (($dateMonth==$currentMonth) and !($in['paid_amount'] == $in['pay_amount']) and $in['installment'] == 0) {
						echo "<li class=\"treeview\"><a href=#><span><dt>",$insta['firstname']," ",$insta['lastname'],"</span> </a></li><br>";
						echo "<span><dl> - Amount Payable: ",$in['pay_amount']-$in['paid_amount']+$in['balance'],"</dl></dt></span> </a></li>";
						break;
					}
					else if(($dateMonth==$currentMonth) and ($in['installment'] > 0) and $in['paid_amount'] ==0 and $in['balance'] > 0){
						echo "<li class=\"treeview\"><a href=#><span><dt>",$insta['firstname']," ",$insta['lastname'],"</span><br>";
						echo "<span><dl> - Amount Payable: ",$in['balance'],"</dl></dt></span></a></li>";
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
					echo "<li class=\"treeview\"><a href=#><span><dt>",$insta['firstname']," ",$insta['lastname'],"<br></span>";
					echo "<span><dl> - Amount Payable: ",round(($insta['rate']*$insta['amount'])/100)*($diffMonth),"</dl></dt></span></a></li>";
					
					
					
					}
								
				}}}
				if ($count == 0) {
				
				echo "<li class=\"treeview\"><center><strong><span>No notification</span></strong></center></li>";
				
				}}
				?>
						</ul>
					</li>
				 </ul>
			</div>	
				
				
				
		</nav>
	</header>
	
	

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <div class="modal-body">
        <?php
            $this->load->helper('form');
            echo form_open('login/change_password', array('name' => 'passwordform'));    
        ?>
        <div class="form-group">
            <div class="col-md-8">
                <label>Old Password</label>
                <input type="password" class="form-control" id="opasssword" name="opasssword" placeholder="Enter Old Passsword "/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8">
                <label>New Password</label>
                <input type="password" class="form-control" id="npasssword" name="npasssword" placeholder="Enter New Passsword "/>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8">
                <label>New Confirm Password</label>
                <input type="password" class="form-control" id="ncpasssword" name="ncpasssword" placeholder="Enter New Confirm Passsword "/>
            </div>
        </div>
    
        <div class="modal-footer">
            <div class="col-md-8"><br/>
                <input type="submit" name="submit"  class="btn btn-primary" value="Submit">
            </div>
        </div>                      
        <?php
            echo form_close();
        ?>
      </div>
    </div>
  </div>
 </div> 

<script>
//Notification color change
var count = <?php echo $count ?>;
if(count > 0){
document.getElementById("notify").style.color = "yellow";
}
</script> 