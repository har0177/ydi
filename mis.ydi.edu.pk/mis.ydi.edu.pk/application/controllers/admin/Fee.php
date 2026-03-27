<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Fee
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        auth_user('admin/user/login');
     

        $this->load->model('fee_model', 'fee');
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Fee');
    }

    public function sms() {
        if ($this->fee->sms()) {
            redirect('admin/fee');
        }

        $this->template->addView("fee/sms", 'body');
        $this->template->display();
    }

    public function index() {
        $result = $this->fee->all();
        $this->template->assign('result', $result);
        $this->template->addView("fee/all", 'body');
        $this->template->display();
    }

    public function export() {

        $this->template->addView("fee/export", 'body');
        $this->template->display();
    }

    public function dashboard() {
       
        $report = $this->fee->getReport();
        $this->template->assign('report', $report);

        $status = $this->fee->status();
        $this->template->assign('status', $status);

        $month = AdminLTE::months();
        $this->template->assign('month', $month);


        $paid = $this->fee->paid();
        $this->template->assign('paid', $paid);

        $unpaid = $this->fee->unpaid();
        $this->template->assign('unpaid', $unpaid);

        $dues = $this->fee->dues();
        $this->template->assign('dues', $dues);

        $amount = $this->fee->amount();
        $this->template->assign('amount', $amount);

        $years = AdminLTE::years();
        $this->template->assign('years', $years);

        $par_paid = $this->fee->par_paid();
        $this->template->assign('par_paid', $par_paid);

        $this->template->addView("fee/dashboard", 'body');
        $this->template->display();
    }

    public function create() {
      
        if ($this->fee->create()) {
            redirect('admin/fee');
        }

        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $this->template->addView("fee/create", 'body');
        $this->template->display();
    }

    public function single() {
     
        if ($this->fee->single()) {
            redirect('admin/fee');
        }

        $month = AdminLTE::months();
        $this->template->assign('month', $month);
      $year = AdminLTE::years();
      $this->template->assign('year', $year);
        $this->template->addView("fee/single", 'body');
        $this->template->display();
    }

//	 public function studentfee(){
//        if(!auth_admin()){
//            show_404();
//        }
//        if($this->fee->studentfee()){
//            redirect('admin/fee');
//        }
//		 $years = $this->fee->years();
//       $this->template->assign('years',$years);
//		  $month = $this->fee->month();
//       $this->template->assign('month',$month);
//        $this->template->addView("fee/student_fee",'body');
//        $this->template->display();
//
//    }

    public function dues($id) {
        
        if ($this->fee->feepaid_dues($id)) {
            redirect('admin/fee');
        }
        $this->template->addView("fee/dues", 'body');
        $this->template->display();
    }

    public function printform($id) {
        $result = $this->fee->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("fee/print", 'body');
        $this->template->display();
    }

    public function view($id) {
        $result = $this->fee->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("fee/view", 'body');
        $this->template->display();
    }

    public function print_all() {
        $data = $this->fee->printall();
        if (empty($data)) {
            show_404();
        }
        $this->template->assign('result', $data);
        $this->template->addView("fee/print_all", 'body');
        $this->template->display();
        // //load the view and saved it into $html variable
        // $html=$this->load->view('fee/print_all', $data, true);
        // //this the the PDF filename that user will get to download
        // $pdfFilePath = "feeSlips.pdf";
        // //load mPDF library
        // $this->load->library('m_pdf');
        // $mpdf = new mPDF('utf-8', 'A4');
        // //generate the PDF from the given html
        // $mpdf->WriteHTML($html);
        // //download it.
        // $mpdf->Output($pdfFilePath, "D");
    }

    public function edit($id) {
       
        if ($this->fee->update($id)) {
            redirect('admin/fee');
        }
        $result = $this->fee->find($id);
        if (empty($result)) {
            show_404();
        }
        
        $month = AdminLTE::months();
        $this->template->assign('month', $month);
        $status = $this->fee->status();
        $this->template->assign('status', $status);
        $this->template->assign('r', $result[0]);
      $years = AdminLTE::years($result[0]->year);
      $this->template->assign('year', $years);
        $this->template->addView("fee/edit", 'body');
        $this->template->display();
    }

    public function concession($id) {
       
        if ($this->fee->concession($id)) {
            redirect('admin/fee');
        }
        $result = $this->fee->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("fee/concession", 'body');
        $this->template->display();
    }

    public function fee_partial($id) {
       
        if ($this->fee->update_fee($id)) {
            redirect('admin/fee');
        }
        $result = $this->fee->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("fee/fee_partial", 'body');
        $this->template->display();
    }

    public function paid($id) {
       
        if ($this->fee->paid_fee($id)) {
            redirect('admin/fee');
        }
        
        $result = $this->fee->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('r', $result[0]);
        $this->template->addView("fee/paid", 'body');
        $this->template->display();
    }

    public function delete($ID) {
       
        $this->fee->delete($ID);
        redirect('admin/fee');
    }

}
