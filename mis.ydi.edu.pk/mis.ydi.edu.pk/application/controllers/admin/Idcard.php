<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Idcard extends CI_Controller{
   
   public function __construct() {
      parent::__construct();
       $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
      auth_user('admin/user/login');
     if(!auth_admin()){
            show_404();
        }
      
      
     $this->load->model('students_model', 'idcard');
     $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Id Cards');
      
   }
   
    public function index()
    {
        $result = $this->students->all();
        $this->template->assign('result',$result);
        $this->template->addView("idcard/all",'body');
        $this->template->display();
               
    }
    
  
	 public function view($id) {
		 $result = $this->students->find($id);
        if(empty($result)){
            show_404();
        }
       $this->template->assign('r',$result[0]);
		 $this->template->addView("students/view",'body');
        $this->template->display();
     }
	  
	   public function printform($id) {
		 $result = $this->students->find($id);
        if(empty($result)){
            show_404();
        }
       $this->template->assign('r',$result[0]);
		 $this->template->addView("students/print",'body');
        $this->template->display();
     }
     
        public function print_slc($id) {
		 $result = $this->students->find_slc($id);
        if(empty($result)){
            show_404();
        }
        $result1 = $this->students->find_student($id);
       $this->template->assign('r',$result1[0]);
		 $this->template->addView("students/print_slc",'body');
        $this->template->display();
     }
	  
	  public function print_all() {
		 $data = $this->students->printall();
        if(empty($data)){
            show_404();
        }
       //load the view and saved it into $html variable
		  
        $this->template->assign('result',$data);
		 $this->template->addView("students/print_all",'body');
        $this->template->display();  
     }
	  
    public function edit($id){
        if(!auth_admin()){
            show_404();
        }
        if($this->students->update($id)){
            redirect('admin/students');
        }
        $result = $this->students->find($id);
        if(empty($result)){
            show_404();
        }
		
		  $session = AdminLTE::session();
       $this->template->assign('session',$session);
        $status = $this->students->status();
       $this->template->assign('status',$status);
		 $gender = $this->students->gender();
       $this->template->assign('gender',$gender);
        $this->template->assign('r',$result[0]);
        $this->template->addView("students/edit",'body');
        $this->template->display();
    }
    
     public function slc($id){
        if(!auth_admin()){
            show_404();
        }
        
        if($this->students->slc($id)){
            redirect('admin/students');
        }
        
        $result = $this->students->find_slc($id);
        if(empty($result)){
          $this->template->addView("students/slc",'body');
        $this->template->display(); 
        }else{
        $this->template->assign('result',$result);
        $this->template->addView("students/slc_view",'body');
        $this->template->display();
     }}
    
    public function delete($ID){
        if(!auth_admin()){
            show_404();
        }
        $this->students->delete($ID);
        redirect('admin/students');
    }
   
    
}

