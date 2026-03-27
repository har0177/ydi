<?php

class Dashboard
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        auth_user('admin/user/login');
    
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('dashboard_model', 'dashboard');
        $this->load->model('fee_model', 'fee');
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Dashboard');
    }

    public function index() {
   


        $users = $this->dashboard->user();
        $this->template->assign('users', $users);

        $students = $this->dashboard->students();
        $this->template->assign('students', $students);

        $employee = $this->dashboard->employee();
        $this->template->assign('employee', $employee);

        $courses = $this->dashboard->courses();
        $this->template->assign('courses', $courses);


        $this->template->addView("dashboard/all", 'body');
        $this->template->display();
    }

}
