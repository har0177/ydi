<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Expenses
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        auth_user('admin/user/login');
     

        $this->load->model('expenses_model', 'expenses');
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Expenses');
    }

    public function index() {




        $result = $this->expenses->all();
        $this->template->assign('result', $result);
        $this->template->addView("expenses/all", 'body');
        $this->template->display();
    }

    public function create() {
      
        if ($this->expenses->create()) {
            redirect('admin/expenses');
        }

        $this->template->addView("expenses/create", 'body');
        $this->template->display();
    }

    public function add_expname() {
     
        if ($this->expenses->add_expname()) {
            redirect('admin/expenses/add_expname');
        }
        $this->template->assign('result', $this->expenses->all_expname());
        $this->template->addView("expenses/all_expenses", 'body');
        $this->template->display();
    }

    public function edit_expname($id) {
      
        if ($this->expenses->edit_expname($id)) {
            redirect('admin/expenses/add_expname');
        }
        $result = $this->expenses->find_name($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("expenses/edit_expenses", 'body');
        $this->template->display();
    }

    public function view($id) {
        $result = $this->expenses->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("expenses/view", 'body');
        $this->template->display();
    }

    public function edit($id) {
        
        if ($this->expenses->update($id)) {
            redirect('admin/expenses');
        }
        $result = $this->expenses->find($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("expenses/edit", 'body');
        $this->template->display();
    }

    public function delete($ID) {
        
        $this->expenses->delete($ID);
        redirect('admin/expenses');
    }

}
