<?php
ob_start();
class Dispatcher extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');	
		if(!isset($_GET['id']))
		{
			if(!$this->session->userdata('customer_id'))
			{
				redirect('home');
			}
		}/*else if(!$this->session->userdata('customer_id'))
		{
			redirect('home?id='.urlencode($_GET['id']).'&redirect='.$this->uri->segment(1).'/'.$this->uri->segment(2));
		}*/
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('order_model');
		$this->load->library('encrypt');
		$this->load->model('currencies_model');
		//$this->currency();
		
	}
	function currency()
	{
		$data = array();
		$this->load->model('currencies_model');
		if($this->session->userdata('currency_id')){
			$currency_id = $this->session->userdata('currency_id');		
		} else { 
			$currency_id = '4';				
		}
		$currencies= $this->currencies_model->getCurrencies();
	
		foreach($currencies as $currency)
		{
					
				$this->currency['currencies'][] = array(
				'currency_id' => $currency['currency_id'],
				'currency_symbol'          => $currency['symbol'],
				'code'          => $currency['code'],	
				'status'          => $currency['status']										
				);
		}		
		
		$this->session->set_userdata($this->currency);
		$currency_detail = $this->currencies_model->getCurrencyInfo($currency_id);		
		$data['currency_symbol'] = $currency_detail->symbol;				
		$data['currency_title'] = $currency_detail->title;		
		$value = $currency_detail->value;			
		$data['value'] = $value;
		
		return $data ; 
	}
	public function index()
	{
		
		if(isset($_GET['m']))
		$dispatch=$_GET['m'];
		else{
		$dispatch=0;
		}
		$data='';
		$customer_id=$this->session->userdata('customer_id');
		$order= array();
		if($dispatch=='1')
		{
			$limit=$this->input->get('limit') ? $this->input->get('limit'):'0';
			if(!$this->session->userdata("req"))
			$order = $this->order_model->getDspatchMilestone($limit,$this->session->userdata('customer_id'));
			else
			$order = $this->order_model->getDspatchMilestone($limit,'',$this->session->userdata('customer_id'));
		}else
		{
			$limit=$this->input->get('limit') ? $this->input->get('limit'):'0';
			if(!$this->session->userdata("req"))
			$order = $this->order_model->getDspatchProduct($limit,$this->session->userdata('customer_id'),'',$dispatch);
			else
			$order = $this->order_model->getDspatchProduct($limit,'',$this->session->userdata('customer_id'),$dispatch);
		}
		//echo $this->session->userdata("req");
		$data['orders']=$order;
		
		//$unique = array_map("unserialize", array_unique(array_map("serialize", $merchant)));
		//$company = array_map("unserialize", array_unique(array_map("serialize", $company)));
		//$data['marchant_list']=$unique;	
		//$data['company_list']=$company;	

		
		$pendingamount=$this->order_model->getPendingAmount($customer_id);
		$data['pending_amount']=$pendingamount[0]['pnamount'];
		if($pendingamount[0]['pnamount']=='')
		$data['pending_amount']='0';
		foreach($this->currency() as $key => $cr)
		$data[$key]  = $cr;
		
		
		$this->load->model('customer_model');
		$cust_detail=$this->customer_model->get_customer($customer_id); 
		$data['cust_detail']=$cust_detail;
		$data['dm']=$dispatch;
		
		$ci =& get_instance();
		$data['ci']=$ci;
		
		if(!$limit)
		$this->load->view('header',$data);
		$this->load->view('dispatcher',$data);
		if(!$limit)
		$this->load->view('footer',$data);
	}
	
	public function searchDispatcher()
	{
		$s= '';
		if($this->input->post('search'))
		{
			$sql="select * from customer where customer_id !=".$this->session->userdata('customer_id')." and (email like '%".$this->input->post('search')."%' or customer_phone like '%".$this->input->post('search')."%' or dispatcher_location like '%".$this->input->post('search')."%' or (CONCAT(first_name,' ',last_name ) like '%".$this->input->post('search')."%') or dispatcher_id like '%".$this->input->post('search')."%')and dispatcher=1 and dispatcher_id!='' order by first_name asc limit 0,100";
			$sqlq=$this->db->query($sql);
			$rs=$sqlq->result_array();
			$arr=array();
			foreach($rs as $r)
			{
				$phonecode = $r['phonecode']?'+'.$r['phonecode'].' ':'';
				$arr[]='<option dsp_id="'.$r['customer_id'].'" value="'.$r['first_name']." ".$r['last_name'].' ('.$r['dispatcher_id'].')" data="'.$r['first_name']." ".$r['last_name'].'<br/>'.$phonecode.$r['customer_phone'].'<br/>'.implode(", ",json_decode($r['dispatcher_location'])).'<br/>'.$r['customer_add'].'<br/>'.$r['dispatcher_id'].'">'.$r['first_name']." ".$r['last_name'].' ('.$r['dispatcher_id'].')</option>';		
				foreach(json_decode($r['dispatcher_location']) as $dl)
				{
				$arr[]='<option dsp_id="'.$r['customer_id'].'" value="'.$dl.' ('.$r['dispatcher_id'].')" data="'.$r['first_name']." ".$r['last_name'].'<br/>'.$phonecode.$r['customer_phone'].'<br/>'.implode(", ",json_decode($r['dispatcher_location'])).'<br/>'.$r['customer_add'].'<br/>'.$r['dispatcher_id'].'">'.$dl.' ('.$r['dispatcher_id'].')</option>';
				}
				
				$arr[]='<option dsp_id="'.$r['customer_id'].'" value="'.$r['email'].'" data="'.$r['first_name']." ".$r['last_name'].'<br/>'.$phonecode.$r['customer_phone'].'<br/>'.implode(", ",json_decode($r['dispatcher_location'])).'<br/>'.$r['customer_add'].'<br/>'.$r['dispatcher_id'].'">'.$r['email'].' ('.$r['dispatcher_id'].')</option>';
				
				if($r['customer_phone'])
				$arr[]='<option dsp_id="'.$r['customer_id'].'" value="'.$r['customer_phone'].'" data="'.$r['first_name']." ".$r['last_name'].'<br/>'.$phonecode.$r['customer_phone'].'<br/>'.implode(", ",json_decode($r['dispatcher_location'])).'<br/>'.$r['customer_add'].'<br/>'.$r['dispatcher_id'].'">'.$r['customer_phone'].'</option>';
				
				if($r['dispatcher_id'])
				$arr[]='<option dsp_id="'.$r['customer_id'].'" value="'.$r['dispatcher_id'].'" data="'.$r['first_name']." ".$r['last_name'].'<br/>'.$phonecode.$r['customer_phone'].'<br/>'.implode(", ",json_decode($r['dispatcher_location'])).'<br/>'.$r['customer_add'].'<br/>'.$r['dispatcher_id'].'" >'.$r['dispatcher_id'].'</option>';				
			}
			ksort($arr);
			$s=implode("",$arr);
		}
		
		echo $s;
	}
	
	public function req()
	{
		$this->session->set_userdata("req",$this->input->get('m'));
		$this->load->library('user_agent');
		redirect($this->agent->referrer());
	}
	
	public function rejected()
	{
		print_r($this->input->post());
		if($this->input->post())
		{
			$ds= $this->input->post('dispatch');
			if($this->input->post('m')!=1)
			{
				
				$Q=$this->db->query("select * from dispatch where dispatch_status>0 and dispatch_to=".$this->session->userdata('customer_id')." and order_product_id=".$ds." order by dispatch_id desc limit 0,1")->row();
				$this->db->query("insert into dispatch set dispatch_status=0 , dispatch_from=".$this->session->userdata('customer_id').", dispatch_to=".$Q->dispatch_from.", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_product set dispatcher_status=0,dispatcher_date='".date('Y-m-d H:i:s')."' where order_product_id=".$ds." and dispatcher_status=1 and dispatcher_id=".$this->session->userdata('customer_id'));
			}else{
				$Q=$this->db->query("select * from dispatch where dispatch_status>0 and dispatch_to=".$this->session->userdata('customer_id')." and  milestone_id=".$ds." order by dispatch_id desc limit 0,1")->row();
				$this->db->query("insert into dispatch set dispatch_status=0 , dispatch_to=".$Q->dispatch_from.", dispatch_from=".$this->session->userdata('customer_id').",  milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_milestone set dispatcher_status=0, dispatcher_date='".date('Y-m-d H:i:s')."' where milestone_id=".$ds." and dispatcher_status=1 and dispatcher_id=".$this->session->userdata('customer_id'));
			}
		}
	}
	
	public function accepted()
	{
		print_r($this->input->post());
		if($this->input->post())
		{
			$ds= $this->input->post('dispatch');
			if($this->input->post('m')!=1)
			{
				
				$this->db->query("insert into dispatch set dispatch_status=2 , dispatch_from=".$this->session->userdata('customer_id').", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_product set dispatcher_status=2,dispatcher_date='".date('Y-m-d H:i:s')."' where order_product_id=".$ds." and dispatcher_status=1 and dispatcher_id=".$this->session->userdata('customer_id'));
			}else{
			
				$this->db->query("insert into dispatch set dispatch_status=2 , dispatch_from=".$this->session->userdata('customer_id').", milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_milestone set dispatcher_status=2, dispatcher_date='".date('Y-m-d H:i:s')."' where milestone_id=".$ds." and dispatcher_status=1 and dispatcher_id=".$this->session->userdata('customer_id'));
			}
		}
	}
	
	public function delivery()
	{
		/* print_r($this->input->post());
		if($this->input->post())
		{
			$ds= $this->input->post('dispatch');
			if(!$this->input->post('m'))
			{
				$this->db->query("insert into dispatch set dispatch_status=3 , dispatch_from=".$this->session->userdata('customer_id').", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_product set dispatcher_status=3,dispatcher_date='".date('Y-m-d H:i:s')."' where dispatcher_status=2 and order_product_id=".$ds." and dispatcher_id=".$this->session->userdata('customer_id'));
			}else{
				
				$this->db->query("insert into dispatch set dispatch_status=3 , dispatch_from=".$this->session->userdata('customer_id').", milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				$this->db->query("update order_milestone set  dispatcher_status=3, dispatcher_date='".date('Y-m-d H:i:s')."' where dispatcher_status=2 and milestone_id=".$ds." and dispatcher_id=".$this->session->userdata('customer_id'));
				
			}
		} */
	}
	
	public function delivery_success()
	{
		if($this->input->post())
		{
			$ds= $this->input->post('dispatch');
		
			if($this->input->post('m')!=1)
			{
				$q=$this->db->query("select op.* , o.payer_id,o.payee_id from order_product op left join  `order` o on o.order_id=op.order_id where op.order_product_id=".$ds." and op.dispatcher_id=".$this->session->userdata('customer_id'));
				
				$q=$q->result_array();
				$q=$q[0];
				
				if($this->input->post('code')!=$q['payer_code'])
				{
					echo "invalid!";
					return false;
				}
				$this->db->query("INSERT INTO `payer` SET customer_id =".$q['payer_id'].", order_id = ".$q['order_id'].", order_product_id = ".$q['order_product_id'].", own_code = '".$q['payee_code']."', code_recived ='".$q['payer_code']."',date_added = NOW()");
				$this->db->query("UPDATE `order_product` SET order_product_status_id =6 where order_product_id = ".$ds);
				
				$this->db->query("update order_product set dispatcher_status=4,dispatcher_date='".date('Y-m-d H:i:s')."' where order_product_id=".$ds." and dispatcher_id=".$this->session->userdata('customer_id'));
				
				$this->db->query("insert into dispatch set dispatch_status=4 , dispatch_from=".$this->session->userdata('customer_id').", dispatch_to=".$q['payer_id'].", order_product_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				echo "1";
				return;
				
			}else{
			
				$q=$this->db->query("select om.*, o.payer_id,o.payee_id from order_milestone om left join  `order` o on o.order_id=om.order_id where om.milestone_id=".$ds." and om.dispatcher_id=".$this->session->userdata('customer_id'));
				$q=$q->result_array();
				$q=$q[0];
				
				if($this->input->post('code')!=$q['payer_code'])
				{
					
					echo "Invalid!";
					return false;
				}
				
				$this->db->query("INSERT INTO `payer` SET customer_id =".$q['payer_id'].", order_id = ".$q['order_id'].", order_product_id = ".$q['milestone_id'].", own_code = '".$q['payee_code']."', code_recived ='".$q['payer_code']."',date_added = NOW()");
				
				$this->db->query("UPDATE `order_milestone` SET status=6 where milestone_id = ".$ds);
				$this->db->query("update order_milestone set dispatcher_status=4, dispatcher_date='".date('Y-m-d H:i:s')."' where milestone_id=".$ds." and dispatcher_id=".$this->session->userdata('customer_id'));
				
				$this->db->query("insert into dispatch set dispatch_status=4 , dispatch_from=".$this->session->userdata('customer_id').", dispatch_to=".$q['payer_id'].", milestone_id=".$ds.",date_time='".date("Y-m-d H:i:s")."', ip_address='".$this->input->ip_address()."'");
				
				echo "1";
			}
		}
	}
	
}?>