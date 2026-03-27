<?php

class User
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        // Set Template parts
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Users');
    }

    public function login() {
     // Check existing session
        if ($this->session->has_userdata('user_logged')) {
            redirect('student/portal');
        }

        $login = $this->user->login();
        if ($login) {
             if ($this->session->has_userdata('user_logged')) {
            redirect('student/portal');
        }
        }
        // Load template data
        $this->template->title('Login');
        $this->template->display('user/login');
    }

    public function logout() {
      
        $this->user->logout();
        $this->session->unset_userdata(['user_logged', 'user_name', 'user_id', 'user_status']);
        redirect('student');
    }

   
    public function profile() {
       
        $id = $this->session->user_id;
        $this->user->userprofile($id);
        $result = $this->user->find($id);
        $this->template->assign('result', $result[0]);
        $this->template->addView('user/profile', 'body');
        $this->template->assign('heading', 'Profile');
        $this->template->display();
    }

   

}
