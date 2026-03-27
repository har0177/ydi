<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Attendance extends CI_Controller {

     public function __construct() {
      parent::__construct();
       $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
      auth_user('admin/user/login');
     if(!auth_inter()){
            show_404();
        }
      
     $this->load->model('myattend_model', 'attend');
     $this->template->baseView('master/interviewer');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Attendance');
    }

 
    public function index() {
         if(!auth_inter()){
                redirect("/admin");
        }
        $result = $this->attend->all();
        $this->template->assign('result', $result);
        $this->template->addView("attend/all", 'body');
        $this->template->display();
    }
    
 
      public function export() {
          
        $this->template->addView("attend/export", 'body');
        $this->template->display();
    }

    public function search() {
          if(!auth_inter()){
                redirect("/admin");
        }
            
        $this->template->addView("attend/search", 'body');
        $this->template->display();
    }
    
    public function search_week() {
          if(!auth_inter()){
                redirect("/admin");
        }
            
        $this->template->addView("attend/search_week", 'body');
        $this->template->display();
    }
    
    public function view_attendance($course, $date) {
          if(!auth_inter()){
                redirect("/admin");
        }
            
         $this->template->assign('course', $course);
           $this->template->assign('date', $date);
        $result = $this->attend->course_data($course);
        $this->template->assign('result', $result);
        $this->template->addView("attend/view", 'body');
        $this->template->display();
    }
    
      public function update($course, $date) {
          if(!auth_inter()){
                redirect("/admin");
        }
        
        if($this->attend->update($course, $date)){
            redirect('admin/attendance');
        }
            
         $this->template->assign('course', $course);
           $this->template->assign('date', $date);
        $result = $this->attend->check_data($course, $date);
        $this->template->assign('result', $result);
        $this->template->addView("attend/update", 'body');
        $this->template->display();
    }
    
    
    public function search_attendance() {
         if(!auth_inter()){
                redirect("/admin");
        }
         $course = $this->input->post('course', TRUE);
        $date = $this->input->post('date', TRUE);
         $this->template->assign('course', $course);
           $this->template->assign('date', $date);
           $this->attend->check_attend_view($date, $course);
        $result = $this->attend->course_data($course);
        $this->template->assign('result', $result);
        $this->template->addView("attend/view", 'body');
        $this->template->display();
    }
    
    public function search_attendance_weekly() {
         if(!auth_inter()){
                redirect("/admin");
        }
         $course = $this->input->post('course', TRUE);
        $from = $this->input->post('from', TRUE);
        $to = $this->input->post('to', TRUE);
         $this->template->assign('course', $course);
           $this->template->assign('from', $from);
            $this->template->assign('to', $to);
         $result = $this->attend->check_attend_weekly($from, $to, $course);
         $this->attend->course_data($course);
         
        $this->template->assign('result', $result);
        $this->template->addView("attend/export_week", 'body');
        $this->template->display();
    }
    
     public function attendance_checking() {
         if(!auth_inter()){
                redirect("/admin");
        }
        $course = $this->input->post('course', TRUE);
       $report  = $this->attend->attendance_checking($course);
        
        
       $this->template->assign('report',$report);
        $this->template->addView("attend/attendance", 'body');
        $this->template->display();
    }
    
     public function days() {
          
        $this->template->addView("attend/export_days", 'body');
        $this->template->display();
    }

     public function months() {
          
        $this->template->addView("attend/export", 'body');
        $this->template->display();
    }

    public function create() {
         if(!auth_inter()){
                redirect("/admin");
        }
        if($this->attend->create()){
            redirect('admin/attendance');
        }
        $course = $this->input->post('course', TRUE);
       
        $result = $this->attend->course_data($course);
        $this->template->assign('result', $result);
        $this->template->addView("attend/create", 'body');
        $this->template->display();
    }

//	 public function studentattend(){
//        if(!auth_admin()){
//            show_404();
//        }
//        if($this->attend->studentattend()){
//            redirect('attend');
//        }
//		 $session = $this->attend->session();
//       $this->template->assign('session',$session);
//		  $month = $this->attend->month();
//       $this->template->assign('month',$month);
//        $this->template->addView("attend/student_attend",'body');
//        $this->template->display();
//        
//    }

   
  
    public function delete($ID) {
         if(!auth_inter()){
                redirect("/admin");
        }
        $this->attend->delete($ID);
        redirect('admin/attend');
    }

}
