<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Nawaytakay extends CI_Controller {

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
        $this->load->model('naway_model', 'naway');
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->template->baseView('master/naway');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Naway Takay Students');
    }

    public function index() {
        if (!auth_naway()) {
            redirect("/admin");
        }

        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		$moths = array();
        $rad = array();
        $adm = array();
        $dailss = array();
        $c = array();
        foreach ($months as
                $m) {
            $moths[] = $m;

            $adms = $this->db->query("Select SUM(fee) as fee from naway where Year(date) = '" . date('Y') . "' and MONTHNAME(date) = '" . $m . "' group by MONTHNAME(date)");

            $radm = $this->db->query("Select SUM(paid) as fee from naway_fee where year = '" . date('Y') . "' and MONTHNAME(STR_TO_DATE(month, '%m')) = '" . $m . "' group by MONTHNAME(STR_TO_DATE(month, '%m'))");

            $daily = $this->db->query("Select SUM(daily) as daily from expensesnaway where YEAR(date) = '" . date('Y') . "' and MONTHNAME(date) = '" . $m . "' group by MONTH(date)");


            if ($radm->num_rows() > 0) {
                $rad[] = $radm->row()->fee;
            }
            else {
                $rad[] = 0;
            }

            if ($adms->num_rows() > 0) {
                $adm[] = $adms->row()->fee;
            }
            else {
                $adm[] = 0;
            }
            if ($daily->num_rows() > 0) {
                $dailss[] = $daily->row()->daily;
            }
            else {
                $dailss[] = 0;
            }


            foreach (array_keys($rad + $dailss) as
                    $key) {
                $c[$key] = $rad[$key] - $dailss[$key] + $adm[$key];
            }
            $this->template->assign('adm', $adm);
            $this->template->assign('radm', $rad);
            $this->template->assign('datess', $moths);
            $this->template->assign('daily', $dailss);
            $this->template->assign('revenue', $c);
        }
        unset($adm);
        unset($rad);
        unset($dailss);
        unset($c);

        $result = $this->naway->all();
        $this->template->assign('result', $result);
        $this->template->title('NawayTakay Dashboard');
        $this->template->addView("naway/dashboard", 'body');
        $this->template->display();
    }

    public function all_attend() {
        if (!auth_naway()) {
            redirect("/admin");
        }

        $this->template->title('NawayTakay Attendance Dashboard');
        $this->template->addView("naway/all_attend", 'body');
        $this->template->display();
    }

    public function search_attendance() {
        if (!auth_naway()) {
            redirect("/admin");
        }

        $date = $this->input->post('date', TRUE);
        $this->template->assign('date', $date);
        $this->naway->check_attend_view($date);
        $result = $this->naway->course_data();
        $this->template->assign('result', $result);
        $this->template->addView("naway/view_attend", 'body');
        $this->template->display();
    }

    public function all() {
        if (!auth_naway()) {
            redirect("/admin");
        }
        $result = $this->naway->naway_students();
        $this->template->assign('result', $result);
        $this->template->title('NawayTakay');
        $this->template->addView("naway/all", 'body');
        $this->template->display();
    }
    
     public function all_words() {
        if (!auth_naway()) {
            redirect("/admin");
        }
         $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $this->template->assign('result', $this->naway->all_words());
        $this->template->addView("naway/week_data/all", 'body');
        $this->template->display();
    }
    
    

    public function add($id) {
        if (!auth_naway()) {
            redirect("/admin");
        }

        if ($this->naway->add_student($id)) {
            redirect('/nawaytakay');
        }
        $result = $this->naway->find_student($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("naway/add", 'body');
        $this->template->display();
    }

    public function add_words() {
        if (!auth_naway()) {
            redirect("/admin");
        }

        if ($this->naway->add_words()) {
            redirect('/nawaytakay/all_words');
        }
        
        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $weeks = AdminLTE::weeks();
        $this->template->assign('weeks', $weeks);
        $this->template->addView("naway/week_data/add", 'body');
        $this->template->display();
    }
public function edit_words($id) {
        if (!auth_naway()) {
            redirect("/admin");
        }

        if ($this->naway->edit_words($id)) {
            redirect('/nawaytakay/all_words');
        }
        
        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $weeks = AdminLTE::weeks();
        $this->template->assign('weeks', $weeks);
        $this->template->assign('result', $this->naway->find_words($id));
        $this->template->addView("naway/week_data/edit", 'body');
        $this->template->display();
    }

    public function bulk() {
        if (!auth_naway()) {
            redirect("/admin");
        }
        if ($this->naway->bulk()) {
            redirect('nawaytakay/bulk');
        }

        $this->template->addView("naway/bulk", 'body');
        $this->template->display();
    }

    public function struckoff($id) {
        if (!auth_naway()) {
            redirect("/admin");
        }

        if ($this->naway->struckoff($id)) {
            redirect('/nawaytakay');
        }
        $result = $this->naway->find_student_info($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $status = AdminLTE::status();
        $this->template->assign('status', $status);
        $this->template->addView("naway/struckoff", 'body');
        $this->template->display();
    }

    public function sms($id) {
        $result = $this->naway->find_student_info($id);
        if (empty($result)) {
            show_404();
        }
        if ($this->naway->send_sms()) {
            redirect('nawaytakay');
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("naway/sms", 'body');
        $this->template->display();
    }

    public function logout() {
        if (!auth_naway()) {
            redirect("/admin");
        }


        $this->session->unset_userdata(['user_logged',
            'user_name',
            'user_id',
            'user_status',
            'user_level']);
        redirect('student');
    }

    public function profile() {
        auth_user();
        if (!auth_naway()) {
            redirect("/admin");
        }


        $id = $this->session->user_id;

        if ($this->naway->userprofile($id)) {
            redirect('/nawaytakay');
        }
        $result = $this->naway->find($id);
        $this->template->assign('result', $result[0]);
        $this->template->addView('user/profile', 'body');
        $this->template->assign('heading', 'Profile');
        $this->template->display();
    }

    public function create_attend() {
        if (!auth_naway()) {
            redirect("/admin");
        }
        if ($this->naway->create_attend()) {
            redirect('nawaytakay/all');
        }
        $date = $this->input->post('date', TRUE);
        $this->naway->check_attend($date);
        $result = $this->naway->course_data();
        $this->template->assign('result', $result);
        $this->template->addView("naway/create_attend", 'body');
        $this->template->display();
    }

    public function view_attendance($date) {
        if (!auth_naway()) {
            redirect("/admin");
        }

        $this->template->assign('date', $date);
        $result = $this->naway->course_data();
        $this->template->assign('result', $result);
        $this->template->addView("naway/view_attend", 'body');
        $this->template->display();
    }

    public function update_attend($date) {
        if (!auth_naway()) {
            redirect("/admin");
        }

        if ($this->naway->update_attend($date)) {
            redirect('nawaytakay/all');
        }


        $this->template->assign('date', $date);
        $result = $this->naway->check_data($date);
        $this->template->assign('result', $result);
        $this->template->addView("naway/update_attend", 'body');
        $this->template->display();
    }

    public function search() {
        if (!auth_naway()) {
            redirect("/admin");
        }

        $this->template->addView("naway/search", 'body');
        $this->template->display();
    }

    public function days() {

        $this->template->addView("naway/export_days", 'body');
        $this->template->display();
    }

    public function group() {
        auth_user();
        if ($this->naway->group()) {
            redirect('nawaytakay/all');
        }

        $this->template->addView("naway/group", 'body');
        $this->template->display();
    }

    public function all_fee() {


        $months = $this->db->query("SELECT MONTHNAME(STR_TO_DATE(month, '%m')) as date from naway_fee where year = '" . date('Y') . "' group by MONTHNAME(STR_TO_DATE(month, '%m'))");
        $moths = json_encode(array_columnn($months->result(), 'date'), JSON_NUMERIC_CHECK);
        $rad = array();
        $dailss = array();
        $c = array();
        foreach ($months->result() as
                $mm) {
            $m = $mm->date;

            $radm = $this->db->query("Select SUM(paid) as fee from naway_fee where year = '" . date('Y') . "' and MONTHNAME(STR_TO_DATE(month, '%m')) = '" . $m . "' group by MONTHNAME(STR_TO_DATE(month, '%m'))");

            $daily = $this->db->query("Select SUM(daily) as daily from expensesnaway where YEAR(date) = '" . date('Y') . "' and MONTHNAME(date) = '" . $m . "' group by MONTH(date)");


            if ($radm->num_rows() > 0) {
                $rad[] = $radm->row()->fee;
            }
            else {
                $rad[] = 0;
            }
            if ($daily->num_rows() > 0) {
                $dailss[] = $daily->row()->daily;
            }
            else {
                $dailss[] = 0;
            }


            foreach (array_keys($rad + $dailss) as
                    $key) {
                $c[$key] = $rad[$key] - $dailss[$key];
            }

            $this->template->assign('radm', $rad);
            $this->template->assign('datess', $moths);
            $this->template->assign('daily', $dailss);
            $this->template->assign('revenue', $c);
        }

        unset($rad);
        unset($dailss);
        unset($c);


        $result = $this->naway->all_fee();
        $this->template->assign('result', $result);
        $this->template->addView("naway/fee/all", 'body');
        $this->template->display();
    }

    public function create_fee() {

        if ($this->naway->create_fee()) {
            redirect('nawaytakay/all_fee');
        }

        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $this->template->addView("naway/fee/create", 'body');
        $this->template->display();
    }

    public function paid_fee($id) {
        if (!auth_naway()) {
            show_404();
        }
        if ($this->naway->paid_fee($id)) {
            redirect('nawaytakay/all_fee');
        }
    }

    public function delete($ID) {
        if (!auth_naway()) {
            show_404();
        }
        $this->naway->delete($ID);
        redirect('nawaytakay/all_fee');
    }

    public function view_student($id) {
        $result = $this->naway->find_student_info($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("naway/view", 'body');
        $this->template->display();
    }
	
	public function update_student($id) {
        $result = $this->naway->find_student_info($id);
        if (empty($result)) {
            show_404();
        }
		
		if ($this->naway->update_student($id)) {
            redirect('nawaytakay/all');
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("naway/update", 'body');
        $this->template->display();
    }

    public function single() {
        if (!auth_naway()) {
            show_404();
        }
        if ($this->naway->single()) {
            redirect('nawaytakay/all_fee');
        }

        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $this->template->addView("naway/fee/single", 'body');
        $this->template->display();
    }
    
    public function all_reports() {
        if (!auth_naway()) {
            show_404();
        }
        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        
        $this->template->addView("naway/week_data/view_all", 'body');
        $this->template->display();
    }
    
     public function monthly_report($id) {

        if ($this->naway->monthly_report($id)) {
            redirect('nawaytakay/monthly_view/' . $id);
        }
        $result = $this->naway->find_student_info($id);
        if (empty($result)) {
            show_404();
        }
        
         $strategy = $this->naway->strategy();
        $this->template->assign('strategy', $strategy);
      
        $this->template->assign('r', $result[0]);
        $this->template->title('Students');
        $this->template->addView("naway/week_data/report", 'body');
        $this->template->display();
    }
    
    
    public function monthly_view($id) {

        $report = $this->naway->getReport();
        $this->template->assign('report', $report);


        $result = $this->naway->student_info($id);
        if (empty($result)) {
            show_404();
        }
        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $this->template->assign('r', $result[0]);
        $this->template->addView("naway/week_data/view", 'body');
        $this->template->display();
    }
    
      public function monthly_update($id) {

        $report = $this->naway->getReport();
        $this->template->assign('report', $report);


        $result = $this->naway->student_info($id);
        if (empty($result)) {
            show_404();
        }
        
        if ($this->naway->monthly_update($id)) {
            redirect('/nawaytakay/monthly_view/'. $id);
        }
        $strategy = $this->naway->strategy();
        $this->template->assign('strategy', $strategy);
      
        
        
        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $this->template->assign('r', $result[0]);
        $this->template->addView("naway/week_data/update", 'body');
        $this->template->display();
    }

}
