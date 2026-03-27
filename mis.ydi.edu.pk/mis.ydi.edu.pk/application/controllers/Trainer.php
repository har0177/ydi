<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trainer
        extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct() {
        parent::__construct();
        if (!auth_trainer()) {
            redirect("/admin");
        }
         $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('trainer_model', 'trainer');
        $this->template->baseView('master/trainer');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Students');
    }

    public function index() {
        if (!auth_trainer()) {
            redirect("/admin");
        }

        $this->template->title('Trainer Dashboard');
        $this->template->addView("trainer/dashboard", 'body');
        $this->template->display();
    }
    
    public function data() {
        if (!auth_trainer()) {
            redirect("/admin");
        }

$result = $this->trainer->materials();
        $this->template->assign('result', $result);
        $this->template->title('Trainer Practice Materials');
        $this->template->addView("data/all", 'body');
        $this->template->display();
    }

    public function students($id) {
        if (!auth_trainer()) {
            redirect("/admin");
        }

        $result = $this->trainer->find_students($id);
        $this->template->assign('result', $result);
        $this->template->title('Students');
        $this->template->addView("trainer/all", 'body');
        $this->template->display();
    }

    public function logout() {
        if (!auth_trainer()) {
            redirect("/admin");
        }

        $this->session->unset_userdata(['user_logged', 'user_name', 'user_id', 'user_status', 'user_level']);
        redirect('student');
    }

    public function profile() {
        auth_user();
        if (!auth_trainer()) {
            redirect("/admin");
        }


        $id = $this->session->user_id;

        if ($this->trainer->userprofile($id)) {
            redirect('/trainer');
        }
        $result = $this->trainer->find($id);
        $this->template->assign('result', $result[0]);
        $this->template->addView('user/profile', 'body');
        $this->template->assign('heading', 'Profile');
        $this->template->display();
    }

    public function report($id) {

        if ($this->trainer->create($id)) {
            redirect('trainer/view/' . $id);
        }
        $result = $this->trainer->find_student_info($id);
        if (empty($result)) {
            show_404();
        }
        $strategy = $this->trainer->strategy();
        $this->template->assign('strategy', $strategy);
        $this->template->assign('r', $result[0]);
        $this->template->title('Students');
        $this->template->addView("trainer/report", 'body');
        $this->template->display();
    }
    
    
    public function upload() {
       
        $this->template->title('Practice Materials');
        $this->template->addView("data/create", 'body');
        $this->template->display();
    }
    
     public function upload_data() {
        if ($this->trainer->upload()) {
            redirect('trainer/data');
        }
    }

    public function view($id) {

        $report = $this->trainer->getReport();
        $this->template->assign('report', $report);


        $result = $this->trainer->student_info($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("trainer/view", 'body');
        $this->template->display();
    }

    public function printall() {

        
        $this->template->addView("trainer/view_all", 'body');
        $this->template->display();
    }

    public function update($id) {

        if ($this->trainer->update($id)) {
            redirect('trainer/view/' . $id);
        }
        $result = $this->trainer->student_info($id);
        if (empty($result)) {
            show_404();
        }
        $strategy = $this->trainer->strategy();
        $this->template->assign('strategy', $strategy);
        $this->template->assign('r', $result[0]);
        $this->template->addView("trainer/update", 'body');
        $this->template->display();
    }

    public function edit_data($id) {

       
        $result = $this->trainer->data_detail($id);
        if (empty($result)) {
            show_404();
        }
         $this->template->title('Practice Materials');
        $this->template->assign('r', $result[0]);
        $this->template->addView("data/edit", 'body');
        $this->template->display();
    }

    public function add_attend($course) {

        if ($this->trainer->create_attend($course)) {
            redirect('trainer');
        }

        $date = date("Y-m-d");
        $this->trainer->check_course($course);
        $this->trainer->check_attend($date, $course);
        $result = $this->trainer->course_data($course);
        $this->template->assign('result', $result);
        $this->template->addView("trainer/attend/create", 'body');
        $this->template->display();
    }
    
    public function update_data($id){
         if ($this->trainer->edit_data($id)) {
            redirect('trainer/data');
        }
    }

    public function view_attendance($course, $date) {

        $this->template->assign('course', $course);
        $this->template->assign('date', $date);
        $result = $this->trainer->course_data($course);
        $this->template->assign('result', $result);
        $this->template->addView("trainer/attend/view", 'body');
        $this->template->display();
    }

    public function update_attend($course, $date) {

        if ($this->trainer->update_attend($course, $date)) {
            redirect('admin/attendance');
        }

        $this->template->assign('course', $course);
        $this->template->assign('date', $date);
        $result = $this->trainer->check_data($course, $date);
        $this->template->assign('result', $result);
        $this->template->addView("trainer/attend/update", 'body');
        $this->template->display();
    }

    public function month($course) {
        $result = $this->trainer->course_data($course);
        $this->template->assign('result', $result);
        $this->template->addView("trainer/attend/export_month", 'body');
        $this->template->display();
    }
    public function delete_data($id) {
          if ($this->trainer->delete_data($id)) {
            redirect('trainer/data');
        }
    }
}
