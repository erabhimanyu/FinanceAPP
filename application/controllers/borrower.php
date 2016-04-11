<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class borrower extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('uid')== '') {
			redirect(base_url());
		}

	}
	public function index($id=false)
	{
		$data['pageTitle']="Borrower Information";
		$this->load->helper('form');
		$this->load->model('borrower_model');
		if($id) {
			$data['borrower']=$this->borrower_model->get_borrower($id);	
			$data['takenloan']=$this->borrower_model->get_loan_byborrower($id);	
			$data['installment']=$this->borrower_model->get_installment($id);	
			$data['ltxn']=$this->borrower_model->get_transaction_byloan($id);
		    $data['contant']=$this->load->view('borrower_detail',$data,true);
		    $this->load->view('master',$data);
			 
		}
		else {
			$data['borrower']=$this->borrower_model->get_borrower_info();			
			$data['contant']=$this->load->view('borrower_info',$data,true);
			$this->load->view('master',$data);
		}
	}

	public function edit($id=false)
	{
		$data['pageTitle']="Edit Borrower Information";
		$this->load->helper('form');
		if($id) {
			$this->load->model('borrower_model');
		    $query = $this->borrower_model->get_borrower($id);
		    $data['edit_borrower'] = $query;
		    $data['contant']=$this->load->view('editborrower',$data,true);
		    $this->load->view('master',$data);
		}
	}

	public function delete()
	{
		$del_id=$this->input->post('id');
		$data = array(
			'deleted_at'=>date('Y-m-d h:i:s')		
		);
		$this->load->model('borrower_model');
		$delquery = $this->borrower_model->delete_borrower($data,$del_id);
		if($delquery) {
			$return=array("status"=>'1',"message"=>"Borrower deleted successfully");
		}
		else {
			$return=array("status"=>'0',"message"=>"Something went wrong!!");
		}
		echo json_encode($return);
	}

	public function add()
	{
		$data['pageTitle']="Add New Borrower";
		$this->load->helper('form');
		$jsurl=base_url().'public/datepicker/bootstrap-datepicker.js';
		$data['loadJs']=array($jsurl);
		$cssurl=base_url().'public/datepicker/datepicker.css';
		$data['loadCss']=array($cssurl);
		$data['contant']=$this->load->view('add_borrower','',true);
		$this->load->view('master',$data);
	}

	function save(){
		// Including Validation Library
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		// Validating Name Field
		$this->form_validation->set_rules('firstname', 'firstname', 'required|min_length[1]|max_length[50]');
		$this->form_validation->set_rules('lastname', 'lastname', 'required|min_length[1]|max_length[50]');
		// Validating Email Field
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		// Validating Mobile no. Field
		$this->form_validation->set_rules('mobile', 'Mobile No.', 'required|regex_match[/^[0-9]{10}$/]');
		// Validating Address Field
		$this->form_validation->set_rules('address', 'Address', 'required|min_length[1]|max_length[50]');
		if ($this->form_validation->run() == FALSE) {
			redirect(base_url().'borrower/add');
		}
		else {

			$this->load->model('borrower_model');
			$firstname = strtoupper($this->input->post('firstname'));
			$lastname = strtoupper($this->input->post('lastname'));
			$dob = $this->input->post('dob');
			$mobile = $this->input->post('mobile');
			$phone = $this->input->post('phone');
			$address = $this->input->post('address');
			$city = strtoupper($this->input->post('city'));
			$gender = $this->input->post('gender');
			$email = $this->input->post('email');
			$adharno = $this->input->post('adharno');
			$drivinglic = $this->input->post('drivinglic');
			$note = $this->input->post('note');
			$docs = $this->input->post('proofs');
			$created_at=date('Y-m-d H:i:s');
			$data = array(
				'firstname'=>$firstname,
				'lastname'=>$lastname,
				'dob'=>$dob,
				'address'=>$address,
				'city'=>$city,
				'mobile'=>$mobile,
				'phone'=>$phone,
				'gender'=>$gender,
				'adharno'=>$adharno,
				'drivinglic'=>$drivinglic,
				'note'=>$note,
				'docs'=>$docs,
				'created_at'=>$created_at,				
				'email'=>$email			
			);
			
			$result=$this->borrower_model->save_borrower($data);
			if($result) {
				$this->session->set_flashdata('success','Borrower Added successfully');
				$insert_id=$this->db->insert_id();
				redirect(base_url().'loan/index/'.$insert_id);
			}
			else {
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url().'borrower/add');
			}  
		}
	}

	function update(){
	$borrower_id = $this->input->post('borrower_id');
	// Including Validation Library
	$this->load->library('form_validation');
	$this->form_validation->set_rules('firstname', 'firstname', 'required|min_length[1]|max_length[50]');
	$this->form_validation->set_rules('lastname', 'lastname', 'required|min_length[1]|max_length[50]');
	// Validating Email Field
	$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	// Validating Mobile no. Field
	$this->form_validation->set_rules('mobile', 'Mobile No.', 'required|regex_match[/^[0-9]{10}$/]');
	// Validating Address Field
	$this->form_validation->set_rules('address', 'Address', 'required|min_length[1]|max_length[50]');
	if ($this->form_validation->run() == FALSE) {
		redirect(base_url().'borrower/edit/'.$borrower_id);
	}
	else {
			$this->load->model('borrower_model');
			$borrower_id = $this->input->post('borrower_id');	
			$firstname = strtoupper($this->input->post('firstname'));
			$lastname = strtoupper($this->input->post('lastname'));
			$dob = $this->input->post('dob');
			$mobile = $this->input->post('mobile');
			$phone = $this->input->post('phone');
			$address = $this->input->post('address');
			$city = strtoupper($this->input->post('city'));
			$email = $this->input->post('email');
			$gender = $this->input->post('gender');
			$adharno = $this->input->post('adharno');
			$drivinglic = $this->input->post('drivinglic');	
			$note = $this->input->post('note');
			$updated_at	= date('Y-m-d h:i:s');	
			$data = array(
				'firstname'=>$firstname,
				'lastname'=>$lastname,
				'dob'=>$dob,
				'address'=>$address,
				'city'=>$city,
				'mobile'=>$mobile,
				'phone'=>$phone,
				'gender'=>$gender,
				'adharno'=>$adharno,
				'drivinglic'=>$drivinglic,	
				'note'=>$note,
				'updated_at'=>$updated_at,				
				'email'=>$email			
			);
			
			$result=$this->borrower_model->update_borrower($data,$borrower_id);
			if($result) {
				$this->session->set_flashdata('success','Customer edited successfully');
				redirect(base_url().'borrower/edit/'.$borrower_id);
			}
			else {
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url().'borrower/edit/'.$borrower_id);
			}  
		}
	}

	function search() {
		//dsm($this->input->post());die;
		$firstname = $this->input->post('firstname');
		$mobile = $this->input->post('mobile');
		$city = $this->input->post('city');	
		$gender = $this->input->post('gender');
		$status = $this->input->post('status');
		$this->load->helper('form');
		$data['pageTitle']="Borrower Information";
		$this->load->model('borrower_model');
		$data['borrower']=$this->borrower_model->get_search_borrower($firstname,$mobile,$city,$gender,$status);
		$data['contant']=$this->load->view('borrower_info',$data,true);
		$this->load->view('master',$data);		
	}

	function payinstallment($id=false) {
			$data['id']=$id;
			$data['l_id'] = $this->uri->segment(4);
			$this->load->helper('form');		
			$jsurl=base_url().'public/datepicker/bootstrap-datepicker.js';
			$data['loadJs']=array($jsurl);
			$cssurl=base_url().'public/datepicker/datepicker.css';
			$data['loadCss']=array($cssurl);
			$this->load->model('borrower_model');
			$data['installment']=$this->borrower_model->get_installment_last($id);
			$data['loan']=$this->borrower_model->get_loan($id);	
			$data['borrower']=$this->borrower_model->get_borrower($id);
			$data['sel_loan']=$this->borrower_model->get_activeloan_byborrower($id);
		    $data['contant']=$this->load->view('installment',$data,true);
		    $this->load->view('master',$data);
	}
	
	
	function get() {
	return "hello";
	}

	function get_amount() {	
		//dsm($this->input->post()); die;
		
		//all post data
		$id=$this->input->post('id');
		$date=$this->input->post('date');
		$payoff=$this->input->post('payoff');
		$install= (int)($this->input->post('installment'));
		
		
		//old code for calculation of interest
		
		/* $this->load->model('borrower_model');
		$amount=$this->borrower_model->get_loan_amount($id);
		$chkamount=$this->borrower_model->get_loan_amount_loantxn($id);
		if($chkamount == "0") {
			$principal=$amount[0]['amount'];
		}
		else {
			$finalamount=$this->borrower_model->get_loan_finalamount($id);
			$principal=$finalamount[0]['final_amount'];
		}
		$chkdate=$this->borrower_model->get_loan_date($id);

		if($chkdate == "0") {
			$diff=daydiff($amount[0]['start_date'],$date);

			if($diff<$amount[0]['installment_duration']) {
				$interest=calculate_interest($principal,$amount[0]['rate'],$amount[0]['installment_duration']);
			}
			else {
				$interest=calculate_interest($principal,$amount[0]['rate'],$diff);				
			}
			if($payoff=="1") {
				$pay_amount=$principal+$interest;
				echo $pay_amount;
			}
			else {
				$pay_amount=$interest;	
				echo $pay_amount;
			}
		}
		else {
			$last_date=$this->borrower_model->get_date($id);
			
			$diff=daydiff($last_date[0]['paid_date'],$date);
			
			$interest=calculate_interest($principal,$amount[0]['rate'],$diff);				
			if($payoff=="1") {
				$pay_amount=$principal+$interest;
				echo $pay_amount;
			}
			else {
				$pay_amount=$interest;
				echo $pay_amount;
			}
		} */
		
		
		
		//Calculation of Monthly Interest
		$this->load->model('borrower_model');
		$count=$this->borrower_model->get_installment_count($id);
		$type=$this->borrower_model->get_loan_type($id);
		$rate = $type[0]['rate'];
		$loan_type = $type[0]['type'];
		$currentdateMonth = getMonth($date);
		$currentdateYear = (int)(getYear($date));
		$principal;
		if ( $count == "0"){
		
		
		$principal = (int) ($type[0]['amount']);
		
		$balance = 0;
		$lastInstallmentMonth = (int) getMonth($type[0]['start_date']);
		$lastInstallmentYear = (int)(getYear($type[0]['start_date']));
		
		}else{
		
		
		$paid_date=$this->borrower_model->get_last_installment($id);
		$principal = $paid_date[0]['remaining_amount'];
		//previous balance amount
		$balance = $paid_date[0]['balance'];
		$lastInstallmentMonth = (int) getMonth($paid_date[0]['paid_date']);
		$lastInstallmentYear = (int)(getYear($paid_date[0]['paid_date']));
		
		}
		
		
		
		
		
		
		
		//Date and year comparision
		
		
		$diffMonth =  $currentdateMonth - $lastInstallmentMonth;
		$diffYear =  $currentdateYear - $lastInstallmentYear;
		
		
		
		
		//Checking of the installment amount and reducing it from the principal amount
		$check_install = 0;
		if(!$install){
		$install = 0;
		
		}else {
		
		if($install > ($principal)){
		$check_install = -1;
		$install = 0;
		}else{
		$check_install = 0;
		}
		
		}
		//calculation of interest and installment amount according to loan type
		if ($loan_type == "Only Interest") {
		
		$installment = 0;
		
		if($diffYear == 0){
		
		if($diffMonth > 0){	
		$interest = round(($principal-$install) * $rate /100)*$diffMonth;}
		else{
		$interest = 0;
		}
		}elseif($diffYear >0) {
		
		$diffMonth = ((12 * ($diffYear)) + ($currentdateMonth - $lastInstallmentMonth));
		$interest = round(((($principal)-$install) * $rate /100)*$diffMonth);
		} else{
		$interest = 0;
		}
		
		
		}else if($type[0]['type'] == "Charity"){
		$interest = 0;
		$installment = 0;
		}else {
		$installment = 0;
		$interest = 0;
		}
		
		//adding balance amount to the installement
		$interest = $interest + $balance;
		//sending Installment and interest data to the view
		 echo $interest;
		echo '!';
		echo $installment;
		echo '!';
		echo $check_install;
		
    
		
	}

	function save_installment() {
		$this->load->model('borrower_model');
		$borrower_id = $this->input->post('borrower_id');	
		$loanid = (int) $this->input->post('loanid');
		$pay_amount = $this->input->post('pay_amount');
		$paid_amount = $this->input->post('paid_amount');
		$paid_date = $this->input->post('paid_date');
		$payoff = $this->input->post('payoff');
		$note = $this->input->post('note');
		$installment = $this->input->post('paid_installment');
		$balance = $pay_amount - $paid_amount;
		$type=$this->borrower_model->get_loan_type($loanid);
		
		
		$count=$this->borrower_model->get_installment_count($loanid);
		if ($count == "0"){
		$remaining_amount = $type[0] ['amount'] - $installment;
		
		}else{
		
		$in=$this->borrower_model->get_last_installment($loanid);
		$remaining_amount = (int)($in[0] ['remaining_amount']) - $installment;
		
		}
		
		$data = array(
			'borrower_id'=>$borrower_id,
			'loan_id'=>$loanid,
			'pay_amount'=>$pay_amount,
			'paid_amount'=>$paid_amount,
			'paid_date'=>$paid_date,
			'note'=>$note,
			'payoff'=>$payoff,
			'installment'=>$installment,
			'balance'=>$balance,
			'remaining_amount'=>$remaining_amount
		);
		
		
		if($payoff=="1"){
			$famont=$this->get_pay_amount($loanid,$paid_date,$payoff);
			if($famont>$paid_amount) {
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url().'borrower');			
			}
		}
		else {
			$result=$this->borrower_model->save_loan_installment($data);
			$last_id=$this->db->insert_id();
			if($result) {
				$this->session->set_flashdata('success','Installment Added successfully');
				redirect(base_url().'borrower');
			}
			else {
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url().'borrower');
			} 
		}		
	}
	
	function get_pay_amount($id,$date,$payoff) {	

		$this->load->model('borrower_model');
		$amount=$this->borrower_model->get_loan_amount($id);
		$chkamount=$this->borrower_model->get_loan_amount_loantxn($id);
		if($chkamount == "0") {
			$principal=$amount[0]['amount'];
		}
		else {
			$finalamount=$this->borrower_model->get_loan_finalamount($id);
			$principal=$finalamount[0]['final_amount'];
		}
		$chkdate=$this->borrower_model->get_loan_date($id);

		if($chkdate == "0") {
			$diff=daydiff($amount[0]['start_date'],$date);

			if($diff<$amount[0]['installment_duration']) {
				$interest=calculate_interest($principal,$amount[0]['rate'],$amount[0]['installment_duration']);
			}
			else {
				$interest=calculate_interest($principal,$amount[0]['rate'],$diff);				
			}
			if($payoff=="1") {
				$pay_amount=$principal+$interest;
				return $pay_amount;
			}
			else {
				$pay_amount=$interest;	
				return $pay_amount;
			}
		}
		else {
			$last_date=$this->borrower_model->get_date($id);
			
			$diff=daydiff($last_date[0]['paid_date'],$date);
			
			$interest=calculate_interest($principal,$amount[0]['rate'],$diff);				
			if($payoff=="1") {
				$pay_amount=$principal+$interest;
				return $pay_amount;
			}
			else {
				$pay_amount=$interest;
				return $pay_amount;
			}
		}
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */