<?php

class Usermodel extends CI_Model 
{
    function Usermodel()
    {     
        parent::__construct();      
    }
    function edit_account($data)
    {
	$updatedata=array(
	    "language"=>$data['language'],
	    "company_name"=>$data['company'],
	    "province"=>$data['state'],
	    "email"=>$data['email'],
	    "first_name"=>$data['name'],
	    "city"=>$data['city'],
	      "telephone_1"=>$data['telephone'],
	      "address_1"=>$data['Address'],
	      "country"=>$data['country'],
	      "postal_code"=>$data['code'],
	    "tz"=>$data['timezone']
	    );
	    $this->db->update("accounts",$updatedata);
	    return;
	    
    }
    function get_account($name)
    {
	$this->db->where("number",$name);
	$detail=$this->db->get("accounts");
	return $detail;
    }
    
    
    
    function buildRatesSearch()
    {
	if($this->session->userdata('advance_search')==1){
	    $routes_search =  $this->session->userdata('rates_search');
	    
	    $pattern_operator = $routes_search['pattern_operator'];
	    
	    if(!empty($routes_search['pattern'])) {
		    switch($pattern_operator){
			    case "1":
			    $this->db->like('pattern', $routes_search['pattern']); 
			    break;
			    case "2":
			    $this->db->not_like('pattern', $routes_search['pattern']);
			    break;
			    case "3":
			    $this->db->where('pattern', $routes_search['pattern']);
			    break;
			    case "4":
			    $this->db->where('pattern <>', $routes_search['pattern']);
			    break;
		    }
	    }
	    
	    $comment_operator = $routes_search['comment_operator'];
	    
	    if(!empty($routes_search['comment'])) {
		    switch($comment_operator){
			    case "1":
			    $this->db->like('comment', $routes_search['comment']); 
			    break;
			    case "2":
			    $this->db->not_like('comment', $routes_search['comment']);
			    break;
			    case "3":
			    $this->db->where('comment', $routes_search['comment']);
			    break;
			    case "4":
			    $this->db->where('comment <>', $routes_search['comment']);
			    break;
		    }
	    }
	    
		    
	    $increment_operator = $routes_search['increment_operator'];
	    if(!empty($routes_search['increment'])) {
		    switch($increment_operator){
			    case "1":
			    $this->db->where('inc ', $routes_search['increment']);
			    break;
			    case "2":
			    $this->db->where('inc <>', $routes_search['increment']);					
			    break;
			    case "3":
			    $this->db->where('inc > ', $routes_search['increment']); 					
			    break;
			    case "4":
			    $this->db->where('inc < ', $routes_search['increment']); 	
			    break;
			    case "5":
			    $this->db->where('inc >= ', $routes_search['increment']);
			    break;
			    case "6":
			    $this->db->where('inc <= ', $routes_search['increment']);
			    break;
		    }
	    }	
	    
	    $connect_charge_operator = $routes_search['connect_charge_operator'];
	    if(!empty($routes_search['connect_charge'])) {
		    switch($connect_charge_operator){
			    case "1":
			    $this->db->where('connectcost ', $routes_search['connect_charge']);
			    break;
			    case "2":
			    $this->db->where('connectcost <>', $routes_search['connect_charge']);					
			    break;
			    case "3":
			    $this->db->where('connectcost > ', $routes_search['connect_charge']); 					
			    break;
			    case "4":
			    $this->db->where('connectcost < ', $routes_search['connect_charge']); 	
			    break;
			    case "5":
			    $this->db->where('connectcost >= ', $routes_search['connect_charge']);
			    break;
			    case "6":
			    $this->db->where('connectcost <= ', $routes_search['connect_charge']);
			    break;
		    }
	    }	
	    
	    $included_seconds_operator = $routes_search['included_seconds_operator'];
	    if(!empty($routes_search['included_seconds'])) {
		    switch($included_seconds_operator){
			    case "1":
			    $this->db->where('includedseconds ', $routes_search['included_seconds']);
			    break;
			    case "2":
			    $this->db->where('includedseconds <>', $routes_search['included_seconds']);					
			    break;
			    case "3":
			    $this->db->where('includedseconds > ', $routes_search['included_seconds']); 					
			    break;
			    case "4":
			    $this->db->where('includedseconds < ', $routes_search['included_seconds']); 	
			    break;
			    case "5":
			    $this->db->where('includedseconds >= ', $routes_search['included_seconds']);
			    break;
			    case "6":
			    $this->db->where('includedseconds <= ', $routes_search['included_seconds']);
			    break;
		    }
	    }	
	    
	    $cost_per_add_minutes_operator = $routes_search['cost_per_add_minutes_operator'];
	    if(!empty($routes_search['cost_per_add_minutes'])) {
		    switch($cost_per_add_minutes_operator){
			    case "1":
			    $this->db->where('cost ', $routes_search['cost_per_add_minutes']);
			    break;
			    case "2":
			    $this->db->where('cost <>', $routes_search['cost_per_add_minutes']);					
			    break;
			    case "3":
			    $this->db->where('cost > ', $routes_search['cost_per_add_minutes']); 					
			    break;
			    case "4":
			    $this->db->where('cost < ', $routes_search['cost_per_add_minutes']); 	
			    break;
			    case "5":
			    $this->db->where('cost >= ', $routes_search['cost_per_add_minutes']);
			    break;
			    case "6":
			    $this->db->where('cost <= ', $routes_search['cost_per_add_minutes']);
			    break;
		    }
	      }
	  }
    }
    
    function getRatesList($flag, $start='', $limit='')
    {
	$this->buildRatesSearch();
	$this->db->where('pricelist', $this->session->userdata['accountinfo']['pricelist']);	
	$this->db->from('routes');
	if($flag)
	{
	    $this->db->order_by("comment ASC, pattern ASC"); 
	    $this->db->limit($limit,$start);
	    $query = $this->db->get();
	}else{
	    $query = $this->db->count_all_results();
	}	
	return $query;
    }
}
?>