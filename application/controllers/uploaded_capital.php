<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploaded_capital extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('uid')== '') {
			redirect(base_url());
		}
	}
	public function index() {
		
		$data['samount'] = $this->input->post('im');
		$data['pageTitle']="Capital";
		$this->load->model('capital_model');
		$jsurl='https://www.google.com/jsapi';
		$data['loadJs']=array($jsurl);
		$data['borrowerloan']=$this->capital_model->get_loan_borrow();
		
		$week_loan_data=$this->capital_model->get_total_loan();
		$data['totalloan']=$week_loan_data;
		$week_insta_data=$this->capital_model->get_total_installment();
		$data['totalinsta']=$week_insta_data;
		$loan=$this->capital_model->get_loan_borrow();
		$data['sponsor']  = $this->capital_model->get_sponsors();
		$data['Sponmoney'] = $this->capital_model->get_total_Sponsored_money();
		$data['Sponname'] = $this->capital_model->get_sponsor_name();
			
		

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
	
	public function insertdata() {
		$this->load->model('capital_model');		
		$success = 1;
		if($this->input->post('id') == ""){
		$data['name_error'] = "Please enter a valid name.";
		$success = 0;
		}
		if($this->input->post('amount') == ""){
		$data['amount_error'] = "Please enter a valid amount.";
		$success = 0;
		}
		
		if ($success == 1){
		
		if($this->capital_model->store_data()){
		$data['im'] = "Record Addedd Successfully";
		}
		else 
		{
		$success = 0;
		$data['im'] = "Unsuccessful. Please Try again!!";
		}
		}
		
		
		
		$this->load->model('capital_model');
		$jsurl='https://www.google.com/jsapi';
		$data['loadJs']=array($jsurl);
		
		

	
	


		$data['sponsor']  = $this->capital_model->get_sponsors();
		$data['Sponmoney'] = $this->capital_model->get_total_Sponsored_money();
		$data['Sponname'] = $this->capital_model->get_sponsor_name();

		$data['contant']=$this->load->view('capital',$data,true);
		$this->load->view('master',$data);
		//redirect(base_url().uploaded_capital);
		
		
	}
	
	public function insertdonor() {
		$this->load->model('capital_model');		
		$success = 1;
		if($this->input->post('Sname') == ""){
		$data['name_error'] = "Please enter a valid name.";
		$success = 0;
		}
		if($this->input->post('title') == ""){
		$data['title_error'] = "Please enter a valid amount.";
		$success = 0;
		}
		
		if ($success == 1){
		
		if($this->capital_model->store_donor()){
		$data['im'] = "Record Addedd Successfully";
		}
		else 
		{
		$success = 0;
		$data['im'] = "Unsuccessful. Please Try again!!";
		}
		}
		
		
		
		$this->load->model('capital_model');
		$jsurl='https://www.google.com/jsapi';
		$data['loadJs']=array($jsurl);
		
		

	
	


		$data['sponsor']  = $this->capital_model->get_sponsors();
		$data['Sponmoney'] = $this->capital_model->get_total_Sponsored_money();
		$data['Sponname'] = $this->capital_model->get_sponsor_name();

		$data['contant']=$this->load->view('capital',$data,true);
		$this->load->view('master',$data);
		//redirect(base_url().uploaded_capital);
		
		
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