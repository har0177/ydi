<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Expensesinter
        extends CI_Controller {

    public function __construct() {
        parent::__construct();

        auth_user('admin/user/login');
        if (!auth_inter()) {
            show_404();
        }
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('expensesinter_model', 'expenses');
        $this->template->baseView('master/interviewer');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Expenses');
    }

    public function index() {

        $daily = $this->db->query("Select SUM(daily) as daily, MONTHNAME(date) as date from expensesinter where YEAR(date) = '" . date('Y') . "' group by MONTH(date)");

        $dail = json_encode(array_columnn($daily->result(), 'daily'), JSON_NUMERIC_CHECK);
        $date = json_encode(array_columnn($daily->result(), 'date'), JSON_NUMERIC_CHECK);


        $this->template->assign('daily', $dail);
        $this->template->assign('date', $date);
        $result = $this->expenses->all();
        $this->template->assign('result', $result);
        $this->template->addView("expensesinter/all", 'body');
        $this->template->display();
    }

    public function create() {
        if (!auth_inter()) {
            show_404();
        }
        if ($this->expenses->create()) {
            redirect('expensesinter');
        }

        $this->template->addView("expensesinter/create", 'body');
        $this->template->display();
    }

    public function view($id) {
        $result = $this->expenses->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("expensesinter/view", 'body');
        $this->template->display();
    }

    public function edit($id) {
        if (!auth_inter()) {
            show_404();
        }
        if ($this->expenses->update($id)) {
            redirect('expensesinter');
        }
        $result = $this->expenses->find($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("expensesinter/edit", 'body');
        $this->template->display();
    }

    public function delete($ID) {
        if (!auth_inter()) {
            show_404();
        }
        $this->expenses->delete($ID);
        redirect('expensesinter');
    }

}
