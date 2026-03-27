<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sms
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        auth_user('admin/user/login');
        /* if(!auth_admin()){
          show_404();
          } */
        if (auth_admin()) {
            $this->template->baseView('master/app');
        } else if (auth_inter()) {
            $this->template->baseView('master/interviewer');
        }
        $this->load->model('sms_model', 'sms');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Send SMS');
    }

    public function index() {
        auth_user();
        $sender = $this->sms->singlesms();
        $this->template->assign('sender', $sender);
        $this->template->addView("sms/sms", 'body');
        $this->template->display();
    }

    public function create() {
        auth_user();
        if ($this->sms->create()) {
            redirect('admin/sms');
        }
        $sender = $this->sms->singlesms();
        $this->template->assign('sender', $sender);
        $this->template->addView("sms/sms", 'body');
        $this->template->display();
    }

    public function single() {
        auth_user();
        if ($this->sms->single()) {
            redirect('admin/sms');
        }
        $this->template->addView("sms/single", 'body');
        $this->template->display();
    }

    public function bulk() {
        auth_user();
        if ($this->sms->bulk()) {
            redirect('admin/sms/bulk');
        }

        $this->template->addView("sms/bulk", 'body');
        $this->template->display();
    }
    
     public function bulk_manual() {
        auth_user();
        if ($this->sms->bulk_manual()) {
            redirect('admin/sms/bulk_manual');
        }

        $this->template->addView("sms/bulk_manual", 'body');
        $this->template->display();
    }

    public function group() {
        auth_user();
        if ($this->sms->group()) {
            redirect('admin/sms/group');
        }

        $this->template->addView("sms/group", 'body');
        $this->template->display();
    }

    public function coursewise() {
        auth_user();
        if ($this->sms->coursewise()) {
            redirect('admin/sms/coursewise');
        }

        $this->template->addView("sms/coursewise", 'body');
        $this->template->display();
    }

}
