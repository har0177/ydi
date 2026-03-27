<?php

class Dashboard_model extends CI_Model
{
       
      
         public function info($id) {
		$q = $this->db->query('Select SUM('.$id.') as total from admission_info where '.$id.'_status = 1');
		return $q->result();
	}
      
     public function user(){
       return $this->db->count_all('user');
    }
	 
	  public function students(){
       return $this->db->count_all('student');
    }
	 
	 public function employee(){
       return $this->db->count_all('employee');
    }
    
   
     public function courses(){
       return $this->db->count_all('courses');
    }
    

  
 
  
}
