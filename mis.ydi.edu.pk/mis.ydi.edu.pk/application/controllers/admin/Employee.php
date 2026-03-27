<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Employee
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        auth_user('admin/user/login');
        if (!auth_admin()) {
            show_404();
        }


        $this->load->model('employee_model', 'employee');
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Employee');
    }

    public function index() {
        $result = $this->employee->all();
        $this->template->assign('result', $result);
        $this->template->addView("employee/all", 'body');
        $this->template->display();
    }

    public function create() {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->employee->create()) {
            redirect('admin/employee');
        }

        $category = $this->employee->category();
        $this->template->assign('category', $category);

        $status = $this->employee->status();
        $this->template->assign('status', $status);
        $this->template->addView("employee/create", 'body');
        $this->template->display();
    }

    public function view($id) {
        $result = $this->employee->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("employee/view", 'body');
        $this->template->display();
    }

    public function edit($id) {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->employee->update($id)) {
            redirect('admin/employee');
        }
        $result = $this->employee->find($id);
        if (empty($result)) {
            show_404();
        }

        $category = $this->employee->category();
        $this->template->assign('category', $category);
        $status = $this->employee->status();
        $this->template->assign('status', $status);

        $this->template->assign('r', $result[0]);
        $this->template->addView("employee/edit", 'body');
        $this->template->display();
    }

    public function delete($ID) {
        if (!auth_admin()) {
            show_404();
        }
        $this->employee->delete($ID);
        redirect('admin/employee');
    }

    public function sms($id) {
        $result = $this->employee->find($id);
        if (empty($result)) {
            show_404();
        }
        if ($this->employee->send_sms()) {
            redirect('admin/employee');
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("employee/sms", 'body');
        $this->template->display();
    }

    public function groupsms() {
        auth_user();
        if ($this->employee->groupsms()) {
            redirect('admin/employee');
        }

        $this->template->addView("employee/group", 'body');
        $this->template->display();
    }

}
