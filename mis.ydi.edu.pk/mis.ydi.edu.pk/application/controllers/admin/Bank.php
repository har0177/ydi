<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Bank
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        auth_user('admin/user/login');
        if (!auth_admin()) {
            show_404();
        }

        $this->load->model('bank_model', 'bank');
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Bank');
    }

    public function index() {


        $result = $this->bank->all();
        $this->template->assign('result', $result);
        $this->template->addView("bank/all", 'body');
        $this->template->display();
    }

    public function create() {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->bank->create()) {
            redirect('admin/bank');
        }

        $this->template->addView("bank/create", 'body');
        $this->template->display();
    }

  


    public function view($id) {
        $result = $this->bank->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("bank/view", 'body');
        $this->template->display();
    }

    public function edit($id) {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->bank->update($id)) {
            redirect('admin/bank');
        }
     
        $this->template->addView("bank/edit", 'body');
        $this->template->display();
    }

    public function delete($ID) {
        if (!auth_admin()) {
            show_404();
        }
        $this->bank->delete($ID);
        redirect('admin/bank');
    }

}
