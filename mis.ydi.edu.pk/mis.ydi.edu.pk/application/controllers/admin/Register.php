<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Register extends CI_Controller{
   
   public function __construct() {
      parent::__construct();
       $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
      auth_user('admin/user/login');
       if(!auth_admin()){
            show_404();
        }
      
     $this->load->model('register_model', 'register');
     $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Register');
      
   }
   
    public function index()
    {
		  $result = $this->register->all();
        $this->template->assign('result',$result);
        $this->template->addView("register/all",'body');
        $this->template->display();
               
    }
    
    public function dashboard()
    {
        $report = $this->register->getReport();
       $this->template->assign('report',$report);
       
          $status = $this->register->status();
       $this->template->assign('status',$status);
       
          $month = AdminLTE::months();
       $this->template->assign('month',$month);
       
       
	$paid = $this->register->paid();
        $this->template->assign('paid',$paid);
        
	$unpaid = $this->register->unpaid();
        $this->template->assign('unpaid',$unpaid);
        
        $dues = $this->register->dues();
        $this->template->assign('dues',$dues);
        
        $amount = $this->register->amount();
        $this->template->assign('amount',$amount);
        
         $years = AdminLTE::years();
       $this->template->assign('years',$years);
       
        $par_paid = $this->register->par_paid();
        $this->template->assign('par_paid',$par_paid);
        
        $this->template->addView("register/dashboard",'body');
        $this->template->display();
               
    }
    
    
    
    
	 public function paid_fee($id){
        if(!auth_admin()){
            show_404();
        }
        if($this->register->paid_fee($id)){
            redirect('admin/register');
        }
        $result = $this->register->all();
        $this->template->assign('result',$result);
        $this->template->addView("register/all",'body');
        $this->template->display();
    }
   
    
    
	 public function paid_interview($id){
        if(!auth_admin()){
            show_404();
        }
        if($this->register->paid_interview($id)){
            redirect('admin/register');
        }
        $result = $this->register->all();
        $this->template->assign('result',$result);
        $this->template->addView("register/all",'body');
        $this->template->display();
    }
   
  
	 public function paid_other($id){
        if(!auth_admin()){
            show_404();
        }
        if($this->register->paid_other($id)){
            redirect('admin/register');
        }
        $result = $this->register->all();
        $this->template->assign('result',$result);
        $this->template->addView("register/all",'body');
        $this->template->display();
    }
    
    
	 public function status_change($id){
        if(!auth_admin()){
            show_404();
        }
        if($this->register->status_change($id)){
            redirect('admin/register');
        }
        $result = $this->register->all();
        $this->template->assign('result',$result);
        $this->template->addView("register/all",'body');
        $this->template->display();
    }
   
     public function update($id){
        if(!auth_admin()){
            show_404();
        }
        if($this->register->update($id)){
            redirect('admin/register');
        }
        $result = $this->register->find($id);
        if(empty($result)){
            show_404();
        }
		
        
        $this->template->assign('r',$result[0]);
        $this->template->addView("register/edit",'body');
        $this->template->display();
		
    }
    
   
}

