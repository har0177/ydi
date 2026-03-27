<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

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
        $this->load->model('user_model', 'user');
        $this->load->model('student_model', 'students');
        // Set Template parts
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Student Portal');
    }

    public function index() {

        // Check existing session
        if ($this->session->has_userdata('user_logged')) {
            redirect('student/portal');
        }

        $login = $this->user->login();
        if ($login) {
            if ($this->session->has_userdata('user_logged')) {
                redirect('student/portal');
            }
        }



        // Load template data
        $this->template->title('Login');
        $this->template->display('user/login');
    }

    public function profile() {
        if ($this->students->profile()) {
            redirect('student/portal');
        }
    }

    public function profile_update($id) {
        if ($this->students->profile_update($id)) {
            redirect('student/portal');
        }
    }

    public function image() {
        if ($this->students->image_upload()) {
            redirect('student/portal');
        }
    }

    public function portal() {


        $this->template->title('Student Portal');

        $this->template->addView("students/portal", 'body');
        $this->template->display();
    }
    
    public function process() {

        $this->load->view('vendor/autoload.php');

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
                '87e9ce2e3ab856b2b087', '208df2813b240084ae03', '781635', $options
        );

        $pic = "";
        $image = AdminLTE::student_image($this->session->user_logged, "profile");
        if (!empty($image)) {
            $pic = base_url() . "images/" . $image;
        }
        else {
            $pic = "https://mis.ydi.edu.pk/images/" . AdminLTE::student_image($this->session->user_logged, "img");
        }
        $data['message'] = $_POST["message"];
        $data['nickname'] = $this->session->user_name;
        $data['pic'] = $pic;
        $data['guid'] = $this->session->user_logged;
       $data['timestamp'] = date('d F Y, h:i:s A');

        $pusher->trigger('YDI', 'my-event', $data);
    }

    
    
}
