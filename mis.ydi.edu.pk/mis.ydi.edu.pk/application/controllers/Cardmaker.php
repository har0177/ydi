<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cardmaker extends CI_Controller{
   
   public function __construct() {
      parent::__construct();
      
      auth_user('admin/user/login');
       if(!auth_card()){
                 redirect("/admin");
        }
       $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
     $this->load->model('card_model', 'card');
     $this->template->baseView('master/card');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Student');
      
   }
   
    public function index()
    {
        if(!auth_card()){
                redirect("/admin");
        }
        
        
        $result = $this->card->all();
        $this->template->assign('result',$result);
        $this->template->addView("card/all",'body');
        $this->template->display();           
    }
    
    public function idcards()
    {
        $result = $this->card->idcards();
        $this->template->assign('result',$result);
        $this->template->addView("students/idcards",'body');
        $this->template->display();
               
    }
    
    public function card($id){
       $result = $this->card->find_student($id);
        if(empty($result)){
            show_404();
        }
       $this->template->assign('r',$result[0]);
		 $this->template->addView("students/card",'body');
        $this->template->display();
        
        }
        
        public function issue($id){
       
            if($this->card->issue($id)){
           redirect('/cardmaker');
        }else{
            show_404();
        }
        
        }
        
        public function logout()
    {    
            
               if(!auth_card()){
                redirect("/admin");
        }
        
        
        $this->session->unset_userdata(['user_logged', 'user_name', 'user_id', 'user_status', 'user_level']);
        redirect('student');
    }
    
      public function profile()
    {
          auth_user();
            if(!auth_card()){
                redirect("/admin");
        }
        
        $id = $this->session->user_id;
        
         if($this->card->userprofile($id)){
           redirect('/cardmaker');
        }
        $result = $this->card->find_user($id);
        $this->template->assign('result',$result[0]);
        $this->template->addView('user/profile', 'body');
        $this->template->assign('heading', 'Profile');
        $this->template->display();
    }
	
   
    
}

