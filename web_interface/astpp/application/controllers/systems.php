<?php

class Systems extends CI_Controller
{
	function  Systems()
	{
		parent::__construct();
		$this->load->helper('template_inheritance');
		$this->load->helper('authorization');
		$this->load->helper('form');
		$this->load->helper('romon');
		$this->load->library('astpp');	

		$this->load->library('session');
		$this->load->library('form_builder');
		
		
		$this->load->model('pricelists_model');
		
		$this->load->model('system_model');
		$this->load->model('accounts_model');
		
		$this->config->load('astpp_config', TRUE);
		$this->config->item('system_config_group','astpp_config');
		
		if($this->session->userdata('user_login')== FALSE)
			redirect(base_url().'astpp/login');
							
	}
	
	/*
	 * CI has a built in method named _remap which allows
	 * you to overwrite the behavior of calling your controller methods over URI
	*/
	public function _remap($method, $params = array())
	{
		$logintype = $this->session->userdata('logintype');
		$access_control = validate_access($logintype,$method, "systems");
		if ($access_control){
			return call_user_func_array(array($this, $method), $params);			 
	        //$this->$method();
		}
		else{
			$errors =  "Permission Access denied";
			$this->session->set_userdata('astpp_errormsg', $errors);
			if($logintype!=0){
				redirect(base_url().'astpp/dashboard');
			}
			else{
				redirect(base_url().'user/dashboard');
			}			
		}
	}
	
	function index()
	{
		$data['app_name'] = 'ASTPP - Open Source Billing Solution | Accounts | Create';
		$data['username'] = $this->session->userdata('user_name');	
		$data['page_title'] = 'System';	
				
		$this->load->view('view_system',$data);
	}
	
	/**
	 * -------Here we write code for controller systems functions configuration------
	 * @action: Add, Edit, Delete and List configuration
	 */
	function configuration($action=false,$id=false)
	{
		$data['app_name'] = 'ASTPP - Open Source Billing Solution | Accounts | Create';
		$data['username'] = $this->session->userdata('user_name');	
		$data['page_title'] = 'System - configuration';	
		$data['cur_menu_no'] = 10;
		
		
		$data['system_config_group'] = $this->config->item('astpp_config');
		
		$this->load->model('cc_model');
		$data['brands'] =  $this->cc_model->get_cc_brands();
		
		if($action == false)
		$action = "list";
				
		
		if($action == 'list')
		{
			$this->load->view('view_system_configuration',$data);
		}
		elseif($action == 'add')
		{			
			if(!empty($_POST))
			{
				$errors = "";
				if(trim($_POST['name']) == "")
				$errors .= "Name is required<br />";
				if(trim($_POST['value']) == "")
				$errors .= "Value is required<br />";
								
				if ($errors == "")
				{					
					$response = $this->system_model->add_config($_POST);
					//$this->session->set_userdata('astpp_notification', 'Configuration item added successfully!');
					$this->common_model->status_message($response);
					redirect(base_url().'systems/configuration/');				
				}
				else 
				{
					$this->session->set_userdata('astpp_errormsg', $errors);
					redirect(base_url().'systems/configuration/');				
				}			
			}
			
			$data['resellers'] = $this->common_model->list_sellers_select('');
			$data['resellersList'] = $this->common_model->list_sellers();
			
			$data['brands'] = $this->common_model->list_cc_brands_select($data['resellersList'][0],'');
			
			$this->load->view('view_system_configuration_add',$data);			
		}		
		elseif($action == 'edit')
		{
			if(!empty($_POST))
			{
				$errors = "";
				if(trim($_POST['name']) == "")
				$errors .= "Name is required<br />";
				if(trim($_POST['value']) == "")
				$errors .= "Value is required<br />";
							
				if ($errors == "")
				{
					$_POST['reseller'] = trim($_POST['reseller']);
					$_POST['brand'] = trim($_POST['brand']);
					$response = $this->system_model->edit_config($_POST);
					$this->common_model->status_message($response);
					//$this->session->set_userdata('astpp_notification', 'Configuration Item updated successfully!');
					redirect(base_url().'systems/configuration/');				
				}
				else 
				{
					$this->session->set_userdata('astpp_errormsg', $errors);
					redirect(base_url().'systems/configuration/');				
				}
			}	
			else
			{	
			  if($config = $this->system_model->get_config_by_id($id))
			  {
				  $data['config'] = $config;	
			  }
			  else
			  {
				  echo "This route is not available.";
				  return;
			  }
			  	
			  $data['resellers'] = $this->common_model->list_sellers_select($config['reseller']);
			  $data['resellersList'] = $this->common_model->list_sellers();
			  $data['brands'] = $this->common_model->list_cc_brands_select(@$data['resellersList'][0],$config['brand']);
			  $this->load->view('view_system_configuration_add',$data);	
			}
		}
		elseif($action == 'delete')
		{
			if (!($config = $this->system_model->get_config_by_id($id)))
			{				
				$this->session->set_userdata('astpp_errormsg', 'Configuration Item not found!');
				redirect(base_url().'systems/configuration/');
			}
			
			$response = $this->system_model->remove_config($config);		
			$this->common_model->status_message($response);
			//$this->session->set_userdata('astpp_notification', 'Configuration Item removed successfully!');
			redirect(base_url().'systems/configuration/');
		}		
		
	}
	
	function update_brands_select($reseller)
	{
		$output = '<select name="brand" id="brands" class="select field medium">';
		$output .= '<option value=""></option>'.$this->common_model->list_cc_brands_select(urldecode($reseller),'');
		$output .= "</select>";
		
		echo $output;
	}
	
	
	/**
	 * -------Here we write code for controller systems functions configuration_search------
	 * We post an array of configuration field to CI database session variable configuration_search
	 */
	function configuration_search()
	{	
		$ajax_search = $this->input->post('ajax_search',0);	
		if($this->input->post('advance_search', TRUE)==1) {		
			$this->session->set_userdata('advance_search',$this->input->post('advance_search'));
			unset($_POST['action']);
			unset($_POST['advance_search']);
			$this->session->set_userdata('configuration_search', $_POST);		
		}
		if(@$ajax_search!=1) {		
		redirect(base_url().'systems/configuration/');
		}
	}
	
	/**
	 * -------Here we write code for controller accounts functions clearsearchfilter_configuration------
	 * Empty CI database session variable configuration_search for normal listing
	 */
	function clearsearchfilter_configuration()
	{
		$this->session->set_userdata('advance_search',0);
		$this->session->set_userdata('configuration_search', "");
		redirect(base_url().'systems/configuration/');		
	}
	
	/**
	 * -------Here we write code for controller systems functions configuration_grid------
	 * Listing of configuration table data through php function json_encode
	 */
	function configuration_grid()
	{
		$json_data = array();
		$count_all = $this->system_model->systems_configuration(false);
		
		$config['total_rows'] = $count_all;
		$config['per_page'] = $_GET['rp'];

		$page_no = $_GET['page'];

		$json_data['page'] = $page_no;
		$json_data['total'] = ($config['total_rows'] > 0) ? $config['total_rows'] : 0;

		$perpage = $config['per_page'];
		$start = ($page_no - 1) * $perpage;
		if ($start < 0)
		    $start = 0;
			
		$query = $this->system_model->systems_configuration(true,$start, $perpage);
		if($query->num_rows() > 0)
		{
			$system_config_group = $this->config->item('astpp_config');
			foreach ($query->result_array() as $row)
			{			  
				$json_data['rows'][] = array('cell'=>array(
					$row['id'],
					$row['name'],
					$row['value'],
					$row['comment'],
					$system_config_group['system_config_group'][$row['group_title']],
					$row['reseller'],
					$row['brand'],
					$this->get_action_buttons($row['id'])
				));
			}
		}
		echo json_encode($json_data);			
	}
	
	
	function get_action_buttons($id)
	{
		$ret_url = '';
		$ret_url = '<a href="'.base_url().'systems/configuration/edit/'.$id.'/" class="icon edit_image" rel="facebox" title="Update">&nbsp;</a>';
// 		$ret_url .= '<a href="'.base_url().'systems/configuration/delete/'.$id.'/" class="icon delete_image" title="Delete" onClick="return get_alert_msg();">&nbsp;</a>';
		return $ret_url;
	}	
	
	/**
	 * -------Here we write code for controller systems functions purgedeactivated------
	 * System - Purge Deactivated
	 */
	function purgedeactivated()
	{
		$data['app_name'] = 'ASTPP - Open Source Billing Solution | Accounts | Create';
		$data['username'] = $this->session->userdata('user_name');	
		$data['page_title'] = 'System - Purge Deactivated';	
		$data['cur_menu_no'] = 10;
		
		if(!empty($_POST))
		{
			$result = $this->system_model->purge_deactivated_records();
			$this->session->set_userdata('astpp_notification', $result);
			redirect(base_url().'systems/purgedeactivated/');
		}
		
		$this->load->view('view_system_purgedeactivated',$data);
	}
	
	/**
	 * -------Here we write code for controller systems functions taxes------
	 * @action: Add, Edit, Delete and List taxes
	 */
	function taxes($action=false,$id=false)
	{
		$data['app_name'] = 'ASTPP - Open Source Billing Solution | System | Taxes';
		$data['username'] = $this->session->userdata('user_name');	
		$data['page_title'] = 'Taxes';	
		$data['cur_menu_no'] = 10;

		if($action == false)
		$action = "list";
				
		
		if($action == 'list')
		{
			$this->load->view('view_system_taxes',$data);
		}
		elseif($action == 'add')
		{			
			if(!empty($_POST))
			{
				$errors = "";
				if(trim($_POST['taxes_priority']) == "")
				$errors .= "Priority is required<br />";
				if(trim($_POST['taxes_amount']) == "")
				$errors .= "Amount is required<br />";
				if(trim($_POST['taxes_rate']) == "")
				$errors .= "Rate is required<br />";
								
				if ($errors == "")
				{	
					$_POST['taxes_amount']=$this->common_model->add_calculate_currency($_POST['taxes_amount'],'','',false,false);
					
					$this->system_model->add_tax($_POST);
					$this->session->set_userdata('astpp_notification', 'Tax added successfully!');
					redirect(base_url().'systems/taxes/');				
				}
				else 
				{
					$this->session->set_userdata('astpp_errormsg', $errors);
					redirect(base_url().'systems/taxes/');				
				}			
			}			
			$this->load->view('view_system_taxes_add',$data);			
		}		
		elseif($action == 'edit')
		{
			if(!empty($_POST))
			{
				$errors = "";
				if(trim($_POST['taxes_priority']) == "")
				$errors .= "Priority is required<br />";
				if(trim($_POST['taxes_amount']) == "")
				$errors .= "Amount is required<br />";
				if(trim($_POST['taxes_rate']) == "")
				$errors .= "Rate is required<br />";
							
				if ($errors == "")
				{			
					$_POST['taxes_amount']=$this->common_model->add_calculate_currency($_POST['taxes_amount'],'','',false,false);
					$this->system_model->edit_tax($_POST);
					$this->session->set_userdata('astpp_notification', 'Tax updated successfully!');
					redirect(base_url().'systems/taxes/');				
				}
				else 
				{
					$this->session->set_userdata('astpp_errormsg', $errors);
					redirect(base_url().'systems/taxes/');				
				}
			}	
			else
			{	
			  if($tax = $this->system_model->get_tax_by_id($id))
			  {
				  $data['tax'] = $tax;	
			  }
			  else
			  {
				  echo "This Tax is not available.";
				  return;
			  }		
			  $this->load->view('view_system_taxes_add',$data);
			}
		}
		elseif($action == 'delete')
		{
			if (!($tax = $this->system_model->get_tax_by_id($id)))
			{				
				$this->session->set_userdata('astpp_errormsg', 'Tax not found!');
				redirect(base_url().'systems/taxes/');
			}
			
			$this->system_model->remove_tax($tax);		
			$this->session->set_userdata('astpp_notification', 'Tax removed successfully!');
			redirect(base_url().'systems/taxes/');
		}		
		
	}
	
	
	/**
	 * -------Here we write code for controller systems functions taxes_search------
	 * We post array of taxes field to CI database session variable taxes_search
	 */
	function taxes_search()
	{
		$ajax_search = $this->input->post('ajax_search',0);
		if($this->input->post('advance_search', TRUE)==1) {		
			$this->session->set_userdata('advance_search',$this->input->post('advance_search'));
			unset($_POST['action']);
			unset($_POST['advance_search']);
			$this->session->set_userdata('taxes_search', $_POST);		
		}
		if(@$ajax_search!=1) {		
		redirect(base_url().'systems/taxes/');
		}
	}
	
	/**
	 * -------Here we write code for controller systems functions clearsearchfilter_taxes------
	 * Empty CI database session variable taxes_search for normal listing
	 */
	function clearsearchfilter_taxes()
	{
		$this->session->set_userdata('advance_search',0);
		$this->session->set_userdata('taxes_search', "");
		redirect(base_url().'systems/taxes/');		
	}
	
	/**
	 * -------Here we write code for controller systems functions taxes_grid------
	 * Listing of Taxes data through php function json_encode
	 */
	function taxes_grid()
	{
		$json_data = array();
		
		$count_all = $this->system_model->getTaxesCount();
		
		$config['total_rows'] = $count_all;			
		$config['per_page'] = $_GET['rp'];

		$page_no = $_GET['page']; 
		
		$json_data['page'] = $page_no;			
		$json_data['total'] = ($config['total_rows']>0) ? $config['total_rows'] : 0;	
					
		 
		 $perpage = $config['per_page'];
		 $start = ($page_no-1) * $perpage;
		 if($start < 0 )
		 $start = 0;
		 
		$query = $this->system_model->getTaxesList($start, $perpage);
		
		if($query->num_rows() > 0)
		{
			
			foreach ($query->result_array() as $row)
			{
		
				$json_data['rows'][] = array('cell'=>array(
								  $row['taxes_priority'],
								  $this->common_model->calculate_currency($row['taxes_amount']),
								  $this->common_model->format_currency($row['taxes_rate']),
								  $row['taxes_description'],
								  $row['last_modified'],
								  $row['date_added'],
								  $this->get_action_buttons_taxes($row['taxes_id'])
							  ));
			}
		}
		echo json_encode($json_data);			
	}
	
	
	function get_action_buttons_taxes($id)
	{		    	
		$ret_url = '';
		$ret_url = '<a href="/systems/taxes/edit/'.$id.'/" class="icon edit_image" rel="facebox" title="Update">&nbsp;</a>';
		$ret_url .= '<a href="/systems/taxes/delete/'.$id.'/" class="icon delete_image" title="Delete" onClick="return get_alert_msg();">&nbsp;</a>';
		return $ret_url;
	}
	
	
	function template($action=false,$id=false)
    {
            
		$data['app_name'] = 'ASTPP - Open Source Billing Solution | Template';
		$data['username'] = $this->session->userdata('user_name');	
		$data['page_title'] = 'Email Template';	
		$data['cur_menu_no'] = 10;
                
                if($action === false)
		$action = "list";
                
                if($action == 'list')
		{
		
                    $this->load->view('view_system_template',$data);
		}
                elseif($action == 'add')
		{		
//                    print_r($_POST);
////                    exit;
			if(!empty($_POST))
			{
				$errors = "";
				if(trim($_POST['tem_name']) == "")
				$errors .= "Name is required<br />";

				if(trim($_POST['template']) == "")
				$errors .= "template is required<br />";							
								
				if ($errors == "")
				{
					$this->system_model->add_template($_POST);
					$this->session->set_userdata('astpp_notification', 'Tempalte  added successfully!');
					redirect(base_url().'systems/template');				
				}
				else 
				{
					$this->session->set_userdata('astpp_errormsg', $errors);
					redirect(base_url().'systems/template');				
				}			
			}
			$this->load->view('view_system_template_add',$data);		
		}
                elseif($action == 'edit')
		{
			if(!empty($_POST))
			{
				$errors = "";
				if(trim($_POST['tem_name']) == "")
				$errors .= "Name is required<br />";
				if(trim($_POST['template']) == "")
				$errors .= "template is required<br />";		
                                
				if ($errors == "")
				{				
                                    
					$data_tem=$this->system_model->edit_template($id,$_POST);
					$this->session->set_userdata('astpp_notification', 'Template updated successfully!');
					redirect(base_url().'systems/template');				
				}
				else 
				{
					$this->session->set_userdata('astpp_errormsg', $errors);
					redirect(base_url().'systems/template');				
				}
			}	
			else
			{	
			  if($system = $this->system_model->get_template_by_id_all($id))
			  {
				  $data['template'] = $system;	
			  }
			  else
			  {
				  echo "This Template is not available.";
				  return;
			  }
                          $data['edit_id'] =$id;
			  $this->load->view('view_system_template_add',$data);	
			}
		}
		elseif($action == 'delete')
		{
			if (!($system = $this->system_model->get_template_by_id($id)))
			{				
				$this->session->set_userdata('astpp_errormsg', 'template not found!');
				redirect(base_url().'systems/template');
			}
//			$this->switch_config_model->remove_switch($switch);		
			$this->session->set_userdata('astpp_notification', 'Template removed successfully!');
			redirect(base_url().'systems/template');
		}			
	}
        function template_grid()
        {
		$json_data = array();
		$json_data['page'] = 0;
                $json_data['total'] = 0;
                $query = $this->system_model->get_template_count();
                
                
		if($query->num_rows() > 0)
		{
			$perpage = 20;
			if(isset($_GET['rp']))
			{
                            $perpage = $_GET['rp'];
			}
			
			if(!isset($_GET['page']))
			{
				$json_data['page'] = 1;	
				$start_from = 0;
			}
			else
			{
				$json_data['page'] = $_GET['page'];	
				$start_from = ($json_data['page']-1)*$perpage;
			}
			
			$json_data['total'] = $query->num_rows();
			
			
			$this->db->limit($perpage,$start_from);
                        
                         $query = $this->system_model->get_templates();
                             $json_data['rows']=array();
			foreach ($query->result_array() as $row)
			{

                            $accnumber=$this->accounts_model->get_account_number($row['accountid']);
				$json_data['rows'][] = array('cell'=>array(
					$row['name'],
                                        $row['subject'],
					$row['template'],
                                        $this->get_action_button($accnumber['number']),
					$row['created_date'],
					$row['modified_date'],
					$this->get_action_buttons_tem($row['id'])
				));
			}
		}
		echo json_encode($json_data);		
        }
        
        
        function get_action_buttons_tem($id)
	{		
		$ret_url = '';
		$ret_url = '<a href="'.base_url().'systems/template/edit/'.$id.'/" class="icon edit_image" title="Update">&nbsp;</a>';
		return $ret_url;
	}
        function get_action_button($accountid)
	{

		$ret_url = '';
                 $ret_url = '<a href="'.base_url().'accounts/account_detail/'.$accountid.'"  >'.$accountid.'</a>';
		return $ret_url;
	}
        function search()
	{	
		$ajax_search = $this->input->post('ajax_search',0);
		if($this->input->post('advance_search', TRUE)==1) {	
                    
			$this->session->set_userdata('advance_search',$this->input->post('advance_search'));
			
			unset($_POST['action']);
			unset($_POST['advance_search']);
			$this->session->set_userdata('template_search', $_POST);	
                        
		}
		if(@$ajax_search!=1) {
			redirect(base_url().'systems/template');
		}
	}
        function clearsearchfilter()
	{
		$this->session->set_userdata('advance_search',0);
		$this->session->set_userdata('template_search', "");
		redirect(base_url().'systems/template');		
	}
	
}
?>
