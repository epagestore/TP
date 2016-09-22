<?php  
require(APPPATH.'libraries/REST_Controller.php');  
  
class api extends REST_Controller {  
 	public function __construct()
	{
		parent::__construct();
		//$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('encrypt');
	}
    function key_get()  
    {  
		$this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->get('company_key'));
		if(isset($key_exist[0]))
		{		
			$key=urlencode($this->encrypt->encode(urlencode(json_encode($this->get()))));
			$data = array('key'=>$key,'status'=>'success');
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
      
    function key_post()  
    {   
	
       	$this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		
		if(isset($key_exist[0]))
		{		
			$key=urlencode($this->encrypt->encode(urlencode(json_encode($this->post()))));
			$data = array('key'=>$key,'status'=>'success');
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		} 
    }  
  
    function key_put()  
    {         
       	$this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		if(isset($key_exist[0]))
		{		
			$key=urlencode($this->encrypt->encode(urlencode(json_encode($this->post()))));
			$data = array('key'=>$key,'status'=>'success');
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
  
    function key_delete()  
    {  
        
    }  
	function order_get()  
    {  
		$this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->get('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			$order=$this->order_model->getTransactionOrder($this->get('txn'));
			$milestone=$this->order_model->getTransactionMilestone($this->get('txn'));
			if(!isset($order[0]))
			{
				$data =array('status'=>'failed','msg'=>'invalid id');
				$this->response($data);
			}
			if(isset($milestone[0]))
			{
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name'],'milestone_id'=>$milestone[0]['milestone_key']);
			}
			else
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name']);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
      
    function order_post()  
    {   
	
       $this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			$order=$this->order_model->getTransactionOrder($this->post('txn'));
			$milestone=$this->order_model->getTransactionMilestone($this->post('txn'));
			if(isset($milestone[0]))
			{
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name'],'milestone_id'=>$milestone[0]['milestone_key']);
			}
			else
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name']);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
  
    function order_put()  
    {         
       	$this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			$order=$this->order_model->getTransactionOrder($this->post('txn'));
			$milestone=$this->order_model->getTransactionMilestone($this->post('txn'));
			if(isset($milestone[0]))
			{
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name'],'milestone_id'=>$milestone[0]['milestone_key']);
			}
			else
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name']);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
	function order_product_get()  
    {  
		  $this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->get('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			//$order=$this->order_model->getTransactionOrder($this->get('txn'));
			$order=$this->order_model->getTransactionOrderProduct($this->get('txn'));
			
			$milestone=$this->order_model->getTransactionMilestone($this->get('txn'));
			if(isset($milestone[0]))
			{
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name'],'milestone_id'=>$milestone[0]['milestone_key']);
			}
			else
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['product_transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name']);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
      
    function order_product_post()  
    {   
	
       $this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			//$order=$this->order_model->getTransactionOrder($this->post('txn'));
			$order=$this->order_model->getTransactionOrderProduct($this->post('txn'));
			
			$milestone=$this->order_model->getTransactionMilestone($this->post('txn'));
			if(isset($milestone[0]))
			{
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name'],'milestone_id'=>$milestone[0]['milestone_key']);
			}
			else
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['product_transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name']);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
  
    function order_product_put()  
    {         
       	 $this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			//$order=$this->order_model->getTransactionOrder($this->post('txn'));
			$order=$this->order_model->getTransactionOrderProduct($this->post('txn'));
			
			$milestone=$this->order_model->getTransactionMilestone($this->post('txn'));
			if(isset($milestone[0]))
			{
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name'],'milestone_id'=>$milestone[0]['milestone_key']);
			}
			else
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['product_transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['order_status_value'],'total_amount' =>$order[0]['total_amount'],'product_name' =>$order[0]['product_name']);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
  function milestone_get()  
    {  
		$this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->get('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			$order=$this->order_model->getTransactionMilestone($this->get('txn'));
			if(!isset($order[0]))
			{
				$data =array('status'=>'failed','msg'=>'invalid id');
				$this->response($data);
			}
			$milestones=$this->order_model->getMilestone($order[0]['order_id']);
			$total_milestone=0;
			foreach($milestones as $milestone)
			{
				if($milestone['status']==6)
				$total_milestone+=$milestone['amount'];
			}
			if($order[0]['total_amount']<=$total_milestone)
			{
				$this->order_model->completeOrder($order[0]['order_id']);
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['milestone_status'],'total_amount' =>$order[0]['milestone_amount'],'description' =>$order[0]['milestone_description'],'milestone_key' =>$order[0]['milestone_key'],'complete'=>"1");
				$this->response($data);
			}
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['milestone_status'],'total_amount' =>$order[0]['milestone_amount'],'description' =>$order[0]['milestone_description'],'milestone_key' =>$order[0]['milestone_key'],'complete'=>"0");
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
      
    function milestone_post()  
    {   
	
       $this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			$order=$this->order_model->getTransactionMilestone($this->post('txn'));
			
			if(!isset($order[0]))
			{
				$data =array('status'=>'failed','msg'=>'invalid id');
				$this->response($data);
			}
			$milestones=$this->order_model->getMilestone($order[0]['order_id']);
			$total_milestone=0;
			foreach($milestones as $milestone)
			{
				if($milestone['status']==6)
				$total_milestone+=$milestone['amount'];
			}
			if($order[0]['total_amount']<=$total_milestone)
			{
				$this->order_model->completeOrder($order[0]['order_id']);
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['milestone_status'],'total_amount' =>$order[0]['milestone_amount'],'description' =>$order[0]['milestone_description'],'milestone_key' =>$order[0]['milestone_key'],'complete'=>"1");
				$this->response($data);
			}
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['milestone_status'],'total_amount' =>$order[0]['milestone_amount'],'description' =>$order[0]['milestone_description'],'milestone_key' =>$order[0]['milestone_key'],'complete'=>0);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
  
    function milestone_put()  
    {   
	
       $this->load->model('customer_model');
		$key_exist=$this->customer_model->validateCompanyKey($this->post('company_key'));
		if(isset($key_exist[0]))
		{		
			$this->load->model('order_model');
			$order=$this->order_model->getTransactionMilestone($this->post('txn'));
			
			if(!isset($order[0]))
			{
				$data =array('status'=>'failed','msg'=>'invalid id');
				$this->response($data);
			}
			$milestones=$this->order_model->getMilestone($order[0]['order_id']);
			$total_milestone=0;
			foreach($milestones as $milestone)
			{
				if($milestone['status']==6)
				$total_milestone+=$milestone['amount'];
			}
			if($order[0]['total_amount']<=$total_milestone)
			{
				$this->order_model->completeOrder($order[0]['order_id']);
				$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['milestone_status'],'total_amount' =>$order[0]['milestone_amount'],'description' =>$order[0]['milestone_description'],'milestone_key' =>$order[0]['milestone_key'],'complete'=>"1");
				$this->response($data);
			}
			$data = array('status'=>'success','order_id'=>$order[0]['order_key'],'txn_id' => $order[0]['transaction_id'],'payer_name' =>$order[0]['shipping_firstname'],'order_status' => $order[0]['milestone_status'],'total_amount' =>$order[0]['milestone_amount'],'description' =>$order[0]['milestone_description'],'milestone_key' =>$order[0]['milestone_key'],'complete'=>0);
			$this->response($data);
		}
		else{
			$data =array('status'=>'failed','msg'=>'invalid key');
			$this->response($data);
		}
    }  
    function order_delete()  
    {  
        
    } 
}
?>