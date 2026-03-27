<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Interviewer
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
              $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");

        $this->load->model('inter_model', 'inter');
        $this->template->baseView('master/interviewer');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Students');
    }

    public function index() {
        if (!auth_inter()) {
            redirect("/admin");
        }
        
       $months =  $this->db->query("SELECT MONTHNAME(date) as date from admission_info where YEAR(date) = '" . date('Y') . "' group by MONTH(date)");
$moths = json_encode(array_columnn($months->result(), 'date'), JSON_NUMERIC_CHECK);
$interview = array();
$other = array();
$final = array();
$rad = array();
$dailss = array();
foreach ($months->result() as
     $mm) {
    $m = $mm->date; 
 
        $regis = $this->db->query("Select SUM(interview) as interview, SUM(other) as other from admission_info where interview_status = 1 and other_status = 1 and YEAR(date) = '" . date('Y') . "' and MONTHNAME(date) = '" . $m . "' group by MONTH(date)");

        $fin = $this->db->query("Select SUM(fee) as fee from interview where YEAR(date) = '" . date('Y') . "' and MONTHNAME(date) = '" . $m . "' group by MONTH(date)");

        $radm = $this->db->query("Select SUM(fee) as rfee from radm_fee where YEAR(date) = '" . date('Y') . "' and MONTHNAME(date) = '" . $m . "' group by MONTH(date)");
        
         $daily = $this->db->query("Select SUM(daily) as daily from expensesinter where YEAR(date) = '" . date('Y') . "' and MONTHNAME(date) = '" . $m . "' group by MONTH(date)");

     
     
     foreach ($regis->result() as
             $value) {
         if ($value->interview == NULL) {
            $interview[] = 0;
        }else if ($value->other == NULL) {
            $other[] = 0;
        } else{
             $interview[] = $value->interview;
            $other[] = $value->other;
        }
     }
      if($fin->num_rows() > 0){
              $final[] = $fin->row()->fee;
      
    }else{
        $final[] = 0;
    }
     if($radm->num_rows() > 0){
              $rad[] = $radm->row()->rfee;
      
    }else{
        $rad[] = 0;
    }
    if($daily->num_rows() > 0){
              $dailss[] = $daily->row()->daily;
      
    }else{
        $dailss[] = 0;
    }
     
    
         $this->template->assign('interview', $interview);
        $this->template->assign('other', $other);
        $this->template->assign('datess', $moths);
        $this->template->assign('final', $final);
        $this->template->assign('radm', $rad);
        $this->template->assign('daily', $dailss);
     }  
       
unset($interview);
unset($other);
unset($final);
unset($rad);
unset($dailss);

        $result = $this->inter->dashboard();
        $this->template->assign('result', $result);
        $this->template->title('Interviewer Dashboard');
        $this->template->addView("inter/dashboard", 'body');
        $this->template->display();
    }

    public function reports() {
        if (!auth_inter()) {
            redirect("/admin");
        }


        $this->template->title('Reports Dashboard');
        $this->template->addView("inter/reports", 'body');
        $this->template->display();
    }
	
	public function reports_struckoff() {
        if (!auth_inter()) {
            redirect("/admin");
        }


        $this->template->title('Reports Dashboard');
        $this->template->addView("inter/reports_struckoff", 'body');
        $this->template->display();
    }

    public function report($id) {

        $report = $this->inter->getReport();
        $this->template->assign('report', $report);


        $result = $this->inter->report($id);
        if (empty($result)) {
            set_flash_alert("No data Found!", 'danger');
            redirect("interviewer/all");
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/report_week", 'body');
        $this->template->display();
    }

    public function reports_all() {
        if (!auth_inter()) {
            redirect("/admin");
        }


        $this->template->title('Reports Dashboard');
        $this->template->addView("inter/reports_all", 'body');
        $this->template->display();
    }

    public function all() {
        if (!auth_inter()) {
            redirect("/admin");
        }

        $result = $this->inter->all();
      $status = $this->inter->status();
    $this->template->assign( 'status', $status );
    $this->template->assign( 'result', $result );
        $this->template->title('Interviewer Dashboard');
        $this->template->addView("inter/all", 'body');
        $this->template->display();
    }
    
    
      public function createObservation() {
      
        if ($this->inter->createObservation()) {
            redirect('interviewer/all_observations');
        }

        $this->template->addView("inter/observationsForm", 'body');
        $this->template->display();
    }
    
    
     public function viewObservation($id) {
      
         $result = $this->inter->viewObservation($id);
        if (empty($result)) {
           set_flash_alert("No data Found!", 'danger');
          redirect('interviewer/all_observations');
        }

        $this->template->assign('r', $result[0]);

        $this->template->addView("inter/observationView", 'body');
        $this->template->display();
        
        
    }
    
    
       public function all_observations() {
        if (!auth_inter()) {
            redirect('/interviewer');
        }

        $result = $this->inter->all_observations();
         $this->template->assign('heading', 'Observations');
    $this->template->assign( 'result', $result );
        $this->template->title('Obserbation Dashboard');
        $this->template->addView("inter/all_observations", 'body');
        $this->template->display();
    }

    public function update_fee($id) {
        if (!auth_inter()) {
            redirect("/admin");
        }

        if ($this->inter->update_fee($id)) {
            redirect('/interviewer');
        }
        $result = $this->inter->find_student_info($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/edit", 'body');
        $this->template->display();
    }

    public function paid($id) {
        if (!auth_inter()) {
            redirect("/admin");
        }


        if ($this->inter->paid_fee($id)) {
            redirect('/interviewer');
        }

        $result = $this->inter->all();
        $this->template->assign('result', $result);
        $this->template->addView("inter/all", 'body');
        $this->template->display();
    }

    public function logout() {
        if (!auth_inter()) {
            redirect("/admin");
        }


        $this->session->unset_userdata(['user_logged', 'user_name', 'user_id', 'user_status', 'user_level']);
        redirect('student');
    }

    public function profile() {
        auth_user();
        if (!auth_inter()) {
            redirect("/admin");
        }


        $id = $this->session->user_id;

        if ($this->inter->userprofile($id)) {
            redirect('/interviewer');
        }
        $result = $this->inter->find($id);
        $this->template->assign('result', $result[0]);
        $this->template->addView('user/profile', 'body');
        $this->template->assign('heading', 'Profile');
        $this->template->display();
    }

    public function interview($id) {

        if ($this->inter->create($id)) {
            redirect('interviewer/view/' . $id);
        }
        $result = $this->inter->find_student_info($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/interview", 'body');
        $this->template->display();
    }

    public function view($id) {

        $result = $this->inter->inter_student_info($id);
        if (empty($result)) {
            set_flash_alert("First Take Interview", "danger");
            redirect('interviewer/interview/' . $id);
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/view", 'body');
        $this->template->display();
    }

    public function update($id) {

        if ($this->inter->update($id)) {
            redirect('interviewer/view/' . $id);
        }
        $result = $this->inter->inter_student_info($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/interview_update", 'body');
        $this->template->display();
    }

    public function struckoff($id) {
        if (!auth_inter()) {
            redirect("/admin");
        }

        if ($this->inter->struckoff($id)) {
            redirect('/interviewer');
        }
        $result = $this->inter->find_student_info($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $status = AdminLTE::status();
        $this->template->assign('status', $status);
        $this->template->addView("inter/struckoff", 'body');
        $this->template->display();
    }

    public function radm($id) {
        if (!auth_inter()) {
            redirect("/admin");
        }

        if ($this->inter->radm($id)) {
            redirect('/interviewer');
        }
        $result = $this->inter->find_student_info($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $status = AdminLTE::status();
        $this->template->assign('status', $status);
        $this->template->addView("inter/radm", 'body');
        $this->template->display();
    }

    public function interview_final($id) {

        if ($this->inter->create_final($id)) {
            redirect('interviewer/view_final/' . $id);
        }
        $result = $this->inter->inter_student_info($id);
        if (empty($result)) {
            set_flash_alert("First Take Interview", "danger");
            redirect('interviewer/interview/' . $id);
        }

        $status = $this->inter->inter_status();
        $this->template->assign('status', $status);
        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/interview_final", 'body');
        $this->template->display();
    }

    public function view_final($id) {
     
        $result = $this->inter->inter_student_info_final($id);
        if (empty($result)) {
            set_flash_alert("First Take Interview", "danger");
            redirect('interviewer/interview_final/' . $id);
        }

        $this->template->assign('r', $result[0]);

        $this->template->addView("inter/view_final", 'body');
        $this->template->display();
    }

    public function update_final($id) {

        if ($this->inter->update_final($id)) {
            redirect('interviewer/view_final/' . $id);
        }
        $result = $this->inter->inter_student_info_final($id);
        if (empty($result)) {
            show_404();
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/interview_update_final", 'body');
        $this->template->display();
    }

    public function sms($id) {
        $result = $this->inter->find_student_info($id);
        if (empty($result)) {
            show_404();
        }
        if ($this->inter->send_sms()) {
            redirect('interviewer');
        }

        $this->template->assign('r', $result[0]);
        $this->template->addView("inter/sms", 'body');
        $this->template->display();
    }

    public function logs() {
        $this->template->addView("reports/logs", 'body');
        $this->template->display();
    }

}
