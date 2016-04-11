<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class capital extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('uid')== '') {
			redirect(base_url());
		}
	}
	public function index() {
	
		$data['im'] = "";
		$data['pageTitle']="Capital";
		$this->load->model('capital_model');
		$jsurl='https://www.google.com/jsapi';
		$data['loadJs']=array($jsurl);
		$data['borrowerloan']=$this->capital_model->get_loan_borrow();
		
		$week_loan_data=$this->capital_model->get_total_loan();
		
		$week_insta_data=$this->capital_model->get_total_installment();
		$data['totalinsta']=$week_insta_data;
		$loan=$this->capital_model->get_loan_borrow();
		$data['sponsor']  = $this->capital_model->get_sponsors();
		$data['Sponmoney'] = $this->capital_model->get_total_Sponsored_money();
		$data['Sponname'] = $this->capital_model->get_sponsor_name();		
		foreach ($loan as $row) {
			$chkamount=$this->capital_model->get_loan_amount_loantxn($row['loan_id']);

			if($chkamount == "0") {
				$principal=$row['amount'];
			}
			else {
				$finalamount=$this->capital_model->get_loan_finalamount($row['loan_id']);
				$principal=$finalamount[0]['final_amount'];
			}			
			$chkdate=$this->capital_model->check_date($row['loan_id']);
			if($chkdate=="0") {
				$date=strtotime($row['start_date']);
				$nextdate = date('Y-m-d', strtotime("+".$row['installment_duration']." days", $date));
				$week = date("W");
				
				$res=getWeekDates(date('Y'), $week, $nextdate);
				if($res=="true") {
					$row['nextdate']=$nextdate;	
					$diff=daydiff($row['start_date'],$nextdate);	
					$pay_amount=calculate_interest($principal,$row['rate'],$diff);
					$row['pay_amount']=$pay_amount;	
					$data['next_installment'][]=$row;				
				}			
			}
			else {
				$date=$this->capital_model->get_date($row['loan_id']);	
				foreach ($date as $rowdate) {	
					$date=strtotime($rowdate['paid_date']);	
					$nextdate = date('Y-m-d', strtotime("+".$row['installment_duration']." days", $date));
					$week = date("W");
					
					$res=getWeekDates(date('Y'), $week, $nextdate);	
					if($res=="true") {
						$row['nextdate']=$nextdate;
						$diff=daydiff($rowdate['paid_date'],$nextdate);		
						$pay_amount=calculate_interest($principal,$row['rate'],$diff);
						$row['pay_amount']=$pay_amount;	
						$data['next_installment'][]=$row;
					}									
				}
			}				
		}

		foreach ($loan as $row) {
			$chkamount=$this->capital_model->get_loan_amount_loantxn($row['loan_id']);

			if($chkamount == "0") {
				$principal=$row['amount'];
			}
			else {
				$finalamount=$this->capital_model->get_loan_finalamount($row['loan_id']);
				$principal=$finalamount[0]['final_amount'];
			}			
			$chkdate=$this->capital_model->check_date($row['loan_id']);
			if($chkdate=="0") {
				$date=strtotime($row['start_date']);
				$nextdate = date('Y-m-d', strtotime("+".$row['installment_duration']." days", $date));
				$week = date("W");
				
				$res=getWeekDates(date('Y'), $week, $nextdate);
				if($res=="true") {
					$row['nextdate']=$nextdate;	
					$diff=daydiff($row['start_date'],$nextdate);	
					$pay_amount=calculate_interest($principal,$row['rate'],$diff);
					$row['pay_amount']=$pay_amount;	
					$payoff_res=getWeekDates(date('Y'), $week, $row['payoff_date']);
					if($payoff_res=="true") {
						$row['payoff_amount']=$principal+$pay_amount;
						$data['payoff'][]=$row;	
					}				
				}			
			}
			else {
				$date=$this->capital_model->get_date($row['loan_id']);	
				foreach ($date as $rowdate) {	
					$date=strtotime($rowdate['paid_date']);	
					$nextdate = date('Y-m-d', strtotime("+".$row['installment_duration']." days", $date));
					$week = date("W");
					
					$res=getWeekDates(date('Y'), $week, $nextdate);	
					if($res=="true") {
						$row['nextdate']=$nextdate;
						$diff=daydiff($rowdate['paid_date'],$nextdate);						
						$pay_amount=calculate_interest($principal,$row['rate'],$row['installment_duration']);
						$row['pay_amount']=$pay_amount;	
						$payoff_res=getWeekDates(date('Y'), $week, $row['payoff_date']);
						if($payoff_res=="true") {
							$row['payoff_amount']=$principal+$pay_amount;
							$data['payoff'][]=$row;
						}
					}									
				}
			}				
		}
		$data['contant']=$this->load->view('capital',$data,true);
		$this->load->view('master',$data);
	}
	public function report() {
			$data['pageTitle']="Report";
			$this->load->model('capital_model');
			$data['installment']=$this->capital_model->get_installment();
			$data['contant']=$this->load->view('insallment_report',$data,true);
			$this->load->view('master',$data);		
	}
	
public function add()
	{
		$data['pageTitle']="Add New Borrower";
		$this->load->helper('form');
		$jsurl=base_url().'public/datepicker/bootstrap-datepicker.js';
		$data['loadJs']=array($jsurl);
		$cssurl=base_url().'public/datepicker/datepicker.css';
		$data['loadCss']=array($cssurl);
		$data['contant']=$this->load->view('add_donor','',true);
		$this->load->view('master',$data);
	}
public function addamount()
	{
		$data['pageTitle']="Add New Borrower";
		$this->load->helper('form');
		$this->load->model('capital_model');
		$jsurl=base_url().'public/datepicker/bootstrap-datepicker.js';
		$data['loadJs']=array($jsurl);
		$cssurl=base_url().'public/datepicker/datepicker.css';
		$data['loadCss']=array($cssurl);
		$data['Sponname'] = $this->capital_model->get_sponsor_name();		
		$data['contant']=$this->load->view('add_amount',$data,true);
		
		$this->load->view('master',$data);
	}	
function save(){
		// Including Validation Library
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		// Validating Name Field
		$this->form_validation->set_rules('firstname', 'firstname', 'required|min_length[1]|max_length[50]');
		
		// Validating Email Field
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		// Validating Mobile no. Field
		$this->form_validation->set_rules('mobile', 'Mobile No.', 'required|regex_match[/^[0-9]{10}$/]');
		// Validating Address Field
		$this->form_validation->set_rules('address', 'Address', 'required|min_length[1]|max_length[50]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('Try Again','Validation Error');
			redirect(base_url().'capital/add');
		}
		else {

			$this->load->model('capital_model');
			$firstname = strtoupper($this->input->post('firstname'));
			
			
			$mobile = $this->input->post('mobile');
			$title = $this->input->post('title');
			$address = $this->input->post('address');
			$city = strtoupper($this->input->post('city'));
			$gender = $this->input->post('gender');
			$email = $this->input->post('email');
			
			$note = $this->input->post('note');
			
			$created_at=date('Y-m-d H:i:s');
			$data = array(
				'name'=>$firstname,
				'address'=>$address,
				'city'=>$city,
				'title'=>$title,
				'contact'=>$mobile,
				'gender'=>$gender,
				'note'=>$note,
				'email'=>$email			
			);
			
			$result=$this->capital_model->save_donor($data);
			if($result) {
				$this->session->set_flashdata('success','Donor Added successfully');
				$insert_id=$this->db->insert_id();
				redirect(base_url().'capital');
			}
			else {
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url().'capital/add');
			}  
		}
	}
function saveamount(){
		// Including Validation Library
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
		// Validating Name Field
		$this->form_validation->set_rules('amount', 'Amount', 'required|min_length[1]|max_length[50]|integer');
		
				
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('Try Again','Validation Error');
			redirect(base_url().'capital/addamount');
		}
		else {

			$this->load->model('capital_model');
			$id = strtoupper($this->input->post('id'));
			
			
			$amount = $this->input->post('amount');
								
			$date = $this->input->post('date');
			$remark = $this->input->post('remark');
			$created_at=date('Y-m-d H:i:s');
			$data = array(
				'donor_id'=>$id,
				'amount'=>$amount,
				'date'=>$date,
				'created_at'=>$created_at,
				'remark'=>$remark			
			);
			
			$result=$this->capital_model->save_amount($data);
			if($result) {
				$this->session->set_flashdata('success','Amount Added successfully');
				$insert_id=$this->db->insert_id();
				redirect(base_url().'capital');
			}
			else {
				$this->session->set_flashdata('error','Something went wrong');
				redirect(base_url().'capital/add');
			}  
		}
	}	
	 
/*	function getWeekDates($year, $week, $date, $start=true)
	{
	    $from = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
	    $to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
		if(($date >= $from) && ($date <= $to)) {
			return "true";
		}
		else {
			return "false";
		}
	}*/
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */