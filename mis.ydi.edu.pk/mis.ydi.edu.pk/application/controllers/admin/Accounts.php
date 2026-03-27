<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Accounts extends CI_Controller {

    public function __construct() {
        parent::__construct();

 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        auth_user('admin/user/login');
        if (!auth_admin()) {
            show_404();
        }

        $this->load->model('account_model', 'account');
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Account');
    }

    public function basicsalary() {
        $postData = $this->input->post("id", TRUE);
        $data = array(
            'salary' => AdminLTE::employee_data($postData, "salary"),
            'dues' => AdminLTE::salary_dues($postData),
        );

        echo json_encode($data);
    }

    public function index() {
        $result = $this->account->all();
        $this->template->assign('result', $result);
        $this->template->addView("account/all", 'body');
        $this->template->display();
    }

    public function create() {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->account->create()) {
            redirect('admin/accounts');
        }
        $name = $this->account->name();
        $this->template->assign('name', $name);
        $month = AdminLTE::months();
        $this->template->assign('month', $month);

        $this->template->addView("account/create", 'body');
        $this->template->display();
    }

    public function partial($id) {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->account->update_partial($id)) {
            redirect('admin/accounts');
        }
        $result = $this->account->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("account/partial", 'body');
        $this->template->display();
    }

    public function edit($id) {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->account->update($id)) {
            redirect('admin/accounts');
        }
        $result = $this->account->find($id);
        if (empty($result)) {
            show_404();
        }
        $name = $this->account->name();
        $this->template->assign('name', $name);
        $month = AdminLTE::months();
        $this->template->assign('month', $month);

        $status = $this->account->status();
        $this->template->assign('status', $status);
        $this->template->assign('r', $result[0]);
        $this->template->addView("account/edit", 'body');
        $this->template->display();
    }

    public function paid($id) {
        if (!auth_admin()) {
            show_404();
        }
        if ($this->account->paid_salary($id)) {
            redirect('admin/accounts');
        }
        $result = $this->account->all();
        $this->template->assign('result', $result);
        $this->template->addView("account/all", 'body');
        $this->template->display();
    }

    public function delete($ID) {
        if (!auth_admin()) {
            show_404();
        }
        $this->account->delete($ID);
        redirect('admin/accounts');
    }

    public function details($id) {


        $name = AdminLTE::employee_name($id);
        $this->template->assign('name', $name);
        $this->template->assign('book', $this->account->salary_details($id));
        $this->template->addView('account/details', 'body');
        $this->template->display();
    }

}
