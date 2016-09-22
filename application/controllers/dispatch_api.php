<?php  
error_reporting(0);
require(APPPATH.'libraries/REST_Controller.php');  
  
class dispatch_api extends REST_Controller {  
 	public function __construct()
	{
		parent::__construct();
		//$this->load->library('session');
		$this->load->helper('url');
		$this->load->library('encrypt');
		$this->load->model('order_model');
	}
	
	public $success='success';
	public $failed='failed';
	public $invalid='Invalid argument pass or argument is missing!!';
	
	function request_or_transfer_or_accept_post()
    {
        if($this->post('product_milestone') && $this->post('customer_id') && $this->post('status') && in_array($this->post('status'),array("1","2","5")))
		{
			$status=$this->post('status');
			if($this->post('dispatch_to'))
			{
				$dispatch=$this->post('dispatch_to');
				$dispatch_to=$dispatch;
			}
			else{
				$dispatch=$this->post('customer_id');
				$dispatch_to=0;
			}
			
			if($this->post('milestone'))
			{
				foreach($this->post('product_milestone') as $ds){				
					$this->db->query("insert into dispatch set dispatch_status=".$this->post('status').",dispatch_from=".$this->post('customer_id').", dispatch_to=".$dispatch_to.", milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
					$this->db->query("update order_milestone dispatcher_status=".$this->post('status').",dispatcher_id='".$dispatch."',dispatcher_date='".date('Y-m-d H:i:s')."' where milestone_id=".$ds);
				}
				
			}else{
				foreach($this->post('product_milestone') as $ds){				
					$this->db->query("insert into dispatch set dispatch_status=".$this->post('status').",dispatch_from=".$this->post('customer_id').", dispatch_to=".$dispatch_to.", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
					$this->db->query("update order_product set dispatcher_status=".$this->post('status').",dispatcher_id='".$dispatch."',dispatcher_date='".date('Y-m-d H:i:s')."' where order_product_id=".$ds);
				}
				
			}	
			$arr=array('request'=>$this->post(),'status'=>$this->success,'msg'=>$this->success);
			$this->response($arr,200);
			
		}else{
			$arr=array('request'=>$this->post(),'status'=>$this->failed,'msg'=>$this->invalid);
			$this->response($arr,200);
		}
    }
	
	public function delivery_success_post()
	{
		if($this->post('product_milestone') && $this->post('customer_id') && $this->post('key'))
		{
			$ds= $this->input->post('product_milestone');
		
			if(!$this->input->post('milestone'))
			{
				$q=$this->db->query("select op.* , o.payer_id,o.payee_id from order_product op left join  `order` o on o.order_id=op.order_id where op.order_product_id=".$ds." and op.dispatcher_id=".$this->post('customer_id'));
				
				$q=$q->result_array();
				$q=$q[0];
				
				if($this->post('key')!=$q['payer_code'])
				{
					$arr=array('request'=>$this->post(),'status'=>$this->failed,'msg'=>'Invalid Key !!!');
					$this->response($arr,200);
					return false;
				}
				$this->db->query("INSERT INTO `payer` SET customer_id =".$q['payer_id'].", order_id = ".$q['order_id'].", order_product_id = ".$q['order_product_id'].", own_code = '".$q['payee_code']."', code_recived ='".$q['payer_code']."',date_added = NOW()");
				$this->db->query("UPDATE `order_product` SET order_product_status_id =6 where order_product_id = ".$ds);
				
				$this->db->query("update order_product set dispatcher_status=4,dispatcher_date='".date('Y-m-d H:i:s')."' where order_product_id=".$ds." and dispatcher_id=".$this->post('customer_id'));
				
				$this->db->query("insert into dispatch set dispatch_status=4 , dispatch_from=".$this->post('customer_id').", dispatch_to=".$q['payer_id'].", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$arr=array('request'=>$this->post(),'status'=>$this->success,'msg'=>$this->success);
				$this->response($arr,200);
				return false;
				
			}else{
			
				$q=$this->db->query("select om.*, o.payer_id,o.payee_id from order_milestone om left join  `order` o on o.order_id=om.order_id where om.milestone_id=".$ds." and om.dispatcher_id=".$this->post('customer_id'));
				$q=$q->result_array();
				$q=$q[0];
				
				if($this->post('key')!=$q['payer_code'])
				{
					
					$arr=array('request'=>$this->post(),'status'=>$this->failed,'msg'=>'Invalid Key !!!');
					$this->response($arr,200);
					return false;
				}
				
				$this->db->query("INSERT INTO `payer` SET customer_id =".$q['payer_id'].", order_id = ".$q['order_id'].", order_product_id = ".$q['milestone_id'].", own_code = '".$q['payee_code']."', code_recived ='".$q['payer_code']."',date_added = NOW()");
				
				$this->db->query("UPDATE `order_milestone` SET status=6 where milestone_id = ".$ds);
				$this->db->query("update order_milestone set dispatcher_status=4, dispatcher_date='".date('Y-m-d H:i:s')."' where milestone_id=".$ds." and dispatcher_id=".$this->post('customer_id'));
				
				$this->db->query("insert into dispatch set dispatch_status=4 , dispatch_from=".$this->post('customer_id').", dispatch_to=".$q['payer_id'].", milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$arr=array('request'=>$this->post(),'status'=>$this->success,'msg'=>$this->success);
				$this->response($arr,200);
				return false;
			}
		}else{
			$arr=array('request'=>$this->post(),'status'=>$this->failed,'msg'=>$this->invalid);
			$this->response($arr,200);
		}
	}
	
	
	public function reject_post()
	{
		
		if($this->post('product_milestone') && $this->post('customer_id'))
		{
			$ds= $this->post('product_milestone');
			if(!$this->post('milestone'))
			{
				
				$Q=$this->db->query("select * from dispatch where dispatch_status>0 and dispatch_to=".$this->post('customer_id')." and order_product_id=".$ds." order by dispatch_id desc limit 0,1")->row();
				$this->db->query("insert into dispatch set dispatch_status=0 , dispatch_from=".$this->post('customer_id').", dispatch_to=".$Q->dispatch_from.", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_product set dispatcher_status=0,dispatcher_date='".date('Y-m-d H:i:s')."' where order_product_id=".$ds." and dispatcher_status=1 and dispatcher_id=".$this->post('customer_id'));
			}else{
				$Q=$this->db->query("select * from dispatch where dispatch_status>0 and dispatch_to=".$this->post('customer_id')." and  milestone_id=".$ds." order by dispatch_id desc limit 0,1")->row();
				$this->db->query("insert into dispatch set dispatch_status=0 , dispatch_to=".$Q->dispatch_from.", dispatch_from=".$this->post('customer_id').",  milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_milestone set dispatcher_status=0, dispatcher_date='".date('Y-m-d H:i:s')."' where milestone_id=".$ds." and dispatcher_status=1 and dispatcher_id=".$this->post('customer_id'));
			}
			$arr=array('request'=>$this->post(),'status'=>$this->success,'msg'=>$this->success);
			$this->response($arr,200);
		}else{
			$arr=array('request'=>$this->post(),'status'=>$this->failed,'msg'=>$this->invalid);
			$this->response($arr,200);
		}
	}
	
	public function product_or_milestone_list_get(){		
		if($this->get('customer_id'))
		{
			$c =$this->get('customer_id');
			$l =$this->get('limit') ? $this->get('limit'):'0';
			$r =$this->get('received')?$this->get('received'):'0';
			
			if($this->get('milestone'))
			{
				if(!$r)
				{
					$orders = $this->order_model->getDspatchMilestone($l,$this->get('customer_id'));
					
				}else{
					$orders = $this->order_model->getDspatchMilestone($l,'',$this->get('customer_id'));
				}
				
			}else{
				
				
				if(!$r)
				{	
					$orders = $this->order_model->getDspatchProduct($l,$this->get('customer_id'));
				}
				else
				{	
					$orders = $this->order_model->getDspatchProduct($l,'',$this->get('customer_id'));
				}
		
				
			}	
			$data= array();
			foreach($orders as $key => $order)
			{
				if(!$this->get('milestone'))
				{
					$w=" order_product_id=".$order['order_product_id'];
				}else{
					$w=" milestone_id=".$order['id'];
				}
				$dcu= $this->db->query("select distinct(dispatch_from) as cst,dispatch_to,date_time from dispatch  where (dispatch_status=1 or dispatch_status=5) and ".$w." and dispatch_to!=0 group by dispatch_from order by dispatch_id asc");
				$dcu=$dcu->result_array(); 
				$arr_dtab=array();
				foreach($dcu as $d)
				{
					$arr_y=array();
					if($this->get('customer_id')==$d['cst'] || $this->get('customer_id')==$d['dispatch_to'])
					{	
					$dc= $this->db->query("select * from customer where customer_id=".$d['cst']); 
					$dc=$dc->row();
					$arr_y['date']=$d['date_time'];
					$arr_y['from']=array("c"=>$dc->customer_id,'name'=>$dc->first_name." ".$dc->last_name,'customer_phone'=>$dc->customer_phone,'location'=>implode(", ",json_decode($dc->dispatcher_location)),"address"=>$dc->address,"DID"=>$dc->dispatcher_id);
					
					$dc= $this->db->query("select * from customer where customer_id=".$d['dispatch_to']); 
					$dc=$dc->row();
					$arr_y['to']=array("c"=>$dc->customer_id,'name'=>$dc->first_name." ".$dc->last_name,'customer_phone'=>$dc->customer_phone,'location'=>implode(", ",json_decode($dc->dispatcher_location)),"address"=>$dc->address,"DID"=>$dc->dispatcher_id);
					$arr_dtab[]=$arr_y;
					}
				}
				if(!$r)
				{	
					$data[]=array("sent"=>$order,"dispatched"=>$arr_dtab);
				}else{
					$data[]=array("received"=>$order,"transferred"=>$arr_dtab);
				}
			}
		
			$arr=array('request'=>$this->get(),'status'=>$this->success,'data'=>$data,'msg'=>$this->success);
			$this->response($arr,200);
			
		}else{
			$arr=array('request'=>$this->get(),'status'=>$this->failed,'msg'=>$this->invalid);
			$this->response($arr,200);
		}
		
		
	}
	public function smsApiSend_get()
	{
		$data= array();
		if((!$this->input->get('customer_id') && !$this->input->get('customer_id'))||(!$this->input->get('customer_id')=='' && !$this->input->get('customer_id')==''))
		{
			$arr=array('request'=>$this->get(),'status'=>$this->failed,'msg'=>$this->invalid);
			$this->response($arr,200);
		}
		$message='Your TP transaction secure code is: '.$this->session->userdata('secure_pass');
		$uc = $this->db->query("select * from customer where customer_id=".$this->input->get('customer_id'))->row();
		if($uc->verify)
		{
			$s = $this->sms->send($message,urlencode("+".$uc->phonecode.$uc->customer_phone));		
		}	
		if(!$s)
		{	
			$data[]=array("output"=>$s);
			$arr=array('request'=>$this->get(),'status'=>$this->success,'data'=>$data,'msg'=>$this->success);
			$this->response($arr,200);
		}
		else{
			$arr=array('request'=>$this->get(),'status'=>$this->failed,'msg'=>$this->invalid);
			$this->response($arr,200);
		}
		
	}
}
?>