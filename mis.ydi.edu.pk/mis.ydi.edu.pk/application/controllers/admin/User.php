<?php

class User
        extends CI_Controller {

    public function __construct() {
        parent::__construct();
         $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
        $this->load->model('user_model', 'user');
        // Set Template parts
        $this->template->baseView('master/app');
        $this->template->assign('user', get_user_info());
        $this->template->assign('heading', 'Users');
    }

    public function login() {
        // Check existing session
        if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Admin") {
            redirect('/admin');
        } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Internee") {
                redirect('/admin');
            } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Interviewer") {
            redirect('interviewer');
        } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Trainer") {
            redirect('trainer');
        } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Publications") {
            redirect('cardmaker');
        } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Manager") {
            redirect('/admin');
        }else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "NawayTakay") {
            redirect('nawaytakay');
        }


        $login = $this->user->login();
        if ($login) {
            if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Admin") {
                redirect('/admin');
            }else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Internee") {
                redirect('/admin');
            }  else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Interviewer") {
                redirect('interviewer');
            } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Trainer") {
                redirect('trainer');
            } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Publications") {
                redirect('cardmaker');
            } else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "Manager") {
                redirect('/admin');
            }else if ($this->session->has_userdata('user_logged') && $this->session->user_level == "NawayTakay") {
            redirect('nawaytakay');
        }
        }
        // Load template data
        $this->template->title('Login');
        $this->template->display('user/login');
    }

    public function logout() {
        auth_user();

        $this->session->unset_userdata(['user_logged', 'user_name', 'user_id', 'user_status', 'user_level']);
        redirect('student');
    }

    public function index() {
        auth_user();
        if (!auth_admin()) {
            show_404();
        }


        $this->template->assign('result', $this->user->all());
        $this->template->addView('user/all', 'body');
        $this->template->display();
    }

    public function profile() {
        auth_user();
        if (!auth_admin()) {
            show_404();
        }
        $id = $this->session->user_id;
        $this->user->userprofile($id);
        $result = $this->user->find($id);
        $this->template->assign('result', $result[0]);
        $this->template->addView('user/profile', 'body');
        $this->template->assign('heading', 'Profile');
        $this->template->display();
    }

    public function add() {
        auth_user();
        if (!auth_admin()) {
            show_404();
        }

        // Create user
        if ($this->user->create()) {
            redirect('admin/user');
        }
        $status = $this->user->status();
        $this->template->assign('status', $status);
        $level = $this->user->level();
        $this->template->assign('level', $level);
        $this->template->addView('user/create', 'body');
        $this->template->display();
    }

    public function edit($id) {
        auth_user();
        if (!auth_admin()) {
            show_404();
        }

        // Update Data
        if ($this->user->update($id)) {
            redirect('admin/user');
        }
        $status = $this->user->status();
        $this->template->assign('status', $status);

        $level = $this->user->level();
        $this->template->assign('level', $level);
        // Get user data
        $result = $this->user->find($id);
        if (empty($result)) {
            show_404();
        }
        $this->template->assign('result', $result[0]);
        $this->template->addView('user/edit', 'body');
        $this->template->display();
    }

    public function delete($id) {
        if (!auth_admin()) {
            show_404();
        }

        $this->user->delete($id);
        redirect('admin/user');
    }

    public function activate($id) {
        $this->user->activate($id);
        redirect('admin/user');
    }

    public function forget() {
        $this->user->forget();
        redirect('admin/user');
    }

    public function deactivate($id) {
        $this->user->deactivate($id);
        redirect('admin/user');
    }

}
