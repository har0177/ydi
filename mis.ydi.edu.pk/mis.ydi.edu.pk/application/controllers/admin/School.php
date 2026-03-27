<?php

class School
        extends CI_Controller {

    public function __construct() {
        parent::__construct();

        auth_user('admin/user/login');
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        if (auth_admin()) {
            $this->template->baseView('master/app');
        } else if (auth_inter()) {
            $this->template->baseView('master/interviewer');
        }

        $this->load->model('school_model', 'school');
        // Set Template parts


        $this->template->assign('user', get_user_info());
    }

    public function all_course() {
        auth_user();
        $this->template->assign('heading', "Courses");
        $this->template->assign('result', $this->school->all_course());
        $this->template->addView('courses/all', 'body');
        $this->template->display();
    }

    public function add_course() {
        auth_user();


        // Create user
        if ($this->school->add_course()) {
            redirect('admin/school/all_course');
        }
        $this->template->assign('heading', "Courses");
        $this->template->addView('courses/create', 'body');
        $this->template->display();
    }

    public function edit_course($id) {
        auth_user();


        // Update Data
        if ($this->school->edit_course($id)) {
            redirect('admin/school/all_course');
        }

        $result = $this->school->find_course($id);
        if (empty($result)) {
            show_404();
        }
          $status = $this->school->status();
       $this->template->assign('status',$status);
        $this->template->assign('heading', "Courses");
        $this->template->assign('r', $result[0]);
        $this->template->addView('courses/edit', 'body');
        $this->template->display();
    }

    public function delete_course($id) {


        $this->school->delete_course($id);
        redirect('admin/school/all_course');
    }

    public function all_batch() {
        auth_user();
        $this->template->assign('heading', "batch");
        $this->template->assign('result', $this->school->all_batch());
        $this->template->addView('batch/all', 'body');
        $this->template->display();
    }

    public function add_batch() {
        auth_user();

        // Create user
        if ($this->school->add_batch()) {
            redirect('admin/school/all_batch');
        }
        $this->template->assign('heading', "batch");
        $this->template->addView('batch/create', 'body');
        $this->template->display();
    }

    public function edit_batch($id) {
        auth_user();


        // Update Data
        if ($this->school->edit_batch($id)) {
            redirect('admin/school/all_batch');
        }

        $result = $this->school->find_batch($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('heading', "batch");
        $this->template->assign('r', $result[0]);
        $this->template->addView('batch/edit', 'body');
        $this->template->display();
    }

    public function delete_batch($id) {

        $this->school->delete_batch($id);
        redirect('admin/school/all_batch');
    }

    public function all_sms() {
        auth_user();
        $this->template->assign('heading', "SMS");
        $this->template->assign('result', $this->school->all_sms());
        $this->template->addView('smstemp/all', 'body');
        $this->template->display();
    }

    public function add_sms() {
        auth_user();

        // Create user
        if ($this->school->add_sms()) {
            redirect('admin/school/all_sms');
        }
        $this->template->assign('heading', "SMS");
        $this->template->addView('smstemp/create', 'body');
        $this->template->display();
    }

    public function edit_sms($id) {
        auth_user();


        // Update Data
        if ($this->school->edit_sms($id)) {
            redirect('admin/school/all_sms');
        }

        $result = $this->school->find_sms($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('heading', "SMS");
        $this->template->assign('r', $result[0]);
        $this->template->addView('smstemp/edit', 'body');
        $this->template->display();
    }

    public function delete_sms($id) {

        $this->school->delete_sms($id);
        redirect('admin/school/all_sms');
    }

}
