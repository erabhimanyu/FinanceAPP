<?php
	class capital_model extends CI_Model{   
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}	

	/* get currant active loan by borrower  */
	function get_loan_borrow() {
		$this->db->select('loan.*, borrower.firstname, borrower.lastname');
		$this->db->from('loan');
		$this->db->join('borrower','loan.borrower_id=borrower.borrower_id');
		$this->db->where('loan.status',"1");
		$this->db->where('loan.deleted_at',NULL,false);
		$query = $this->db->get();
	    return $query->result_array();       
	}
	
	function store_data()
	{
	
	 $data1 = array
            (
                'donor_id' => $this->input->post('id'),
                'amount' => $this->input->post('amount'),
				'type' => $this->input->post('type')
            );
	return $this->db->insert('sponsors',$data1);
	}
	
	
function save_donor($data){
			$result=$this->db->insert('sponsors_name',$data);
			return $result;
	}  
function save_amount($data){
			$result=$this->db->insert('sponsors',$data);
			return $result;
	}  	
	
	
	
	function get_sponsors() {
		$this->db->select('sponsors.*,sponsors_name.*');
		$this->db->from('sponsors');
		$this->db->join('sponsors_name','sponsors.donor_id=sponsors_name.id');
		//$this->db->where('sponsors.sponsor_id',"1");	
		$query = $this->db->get();
	    return $query->result_array();       
	}


	/* get installment by borrower */
	function get_total_Sponsored_money() {
		$this->db->select('sponsors.*');
		$this->db->from('sponsors');
		$query = $this->db->get();
	 	return $query->result_array();       
	}
	function get_sponsor_name() {
		$this->db->select('sponsors_name.*');
		$this->db->from('sponsors_name');
		$query = $this->db->get();
	 	return $query->result_array();       
	}
	/* get installment with loan and borrower */
	function get_installment() {
		$this->db->select('installment.*,loan.*, borrower.firstname, borrower.lastname');
		$this->db->from('installment');
		$this->db->join('borrower','installment.borrower_id=borrower.borrower_id');
		$this->db->join('loan','installment.loan_id=loan.loan_id');	
 		$this->db->order_by('installment.insta_id','ASC');
		$query=$this->db->get();
	 	return $query->result_array();       
	}

	/*  get sum of given loan by week  */
	function get_total_loan() {
		$sql="SELECT sum(amount) as total 
			FROM loan 
			group by date_format(`start_date`,'%U') 
			order by date_format(`start_date`,'%U') desc limit 0,4";
		$query=$this->db->query($sql);
		return $query->result_array();  
	}

	/* get sum of paid installment by week */
	function get_total_installment() {
		$sql="SELECT sum(`paid_amount`) as totalinsta 
			FROM installment 
			group by date_format(`paid_date`,'%U')
			order by date_format(`paid_date`,'%U') desc limit 0,4";
		$query=$this->db->query($sql);
		return $query->result_array();		
	}

	/* get installment by loan id */
	function get_date($id) {
		$sql="SELECT * FROM installment WHERE loan_id='".$id."'";
		$query=$this->db->query($sql);
		return $query->result_array();		
	}

	/* check installment id */
	function check_date($id) {
		$sql="SELECT * FROM installment WHERE loan_id='".$id."'";
		$query=$this->db->query($sql);
		return $query->num_rows();		
	}	
	function get_loan_amount_loantxn($id) {
	  $query = $this->db->get_where('loan_transaction',array('loan_id'=>$id));
	  return $query->num_rows() ;		
	}
	function get_loan_finalamount($id) {
	  $query = $this->db->get_where('loan_transaction',array('loan_id'=>$id));
	  return $query->result_array(); 	
	}
}
?>