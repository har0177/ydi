<?php

class Student_model extends CI_Model {

    public function find_student($id) {
        $this->db->where('reg_no', $id);
        $q = $this->db->get('student');
        return $q->result();
    }

    public function profile() {
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        $this->upload->set_upload_path('./images');
        $image = '';
        if ($this->upload->do_upload('file')) {
            $image = $this->upload->data('file_name');
        }
        $this->db->where('reg_no', $this->session->user_logged);
        $sql = $this->db->update(
                'student', [

            'bg' => $image,
                ]
        );
        if ($sql) {
            set_flash_alert('Background Picture Updated successfully', 'success');
            return TRUE;
        }
        else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function image_upload() {
            $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        $this->upload->set_upload_path('./images');
        $image = '';
        if ($this->upload->do_upload('file')) {
            $image = $this->upload->data('file_name');
        }
        $this->db->where('reg_no', $this->session->user_logged);
        $sql = $this->db->update(
                'student', [

            'profile' => $image,
                ]
        );
        if ($sql) {
            set_flash_alert('Profile Picture Updated successfully', 'success');
            return TRUE;
        }
        else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }
    
      public function profile_update($id) {
        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
           
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            // Data for db
            $update = [];

            // Use secure password hashing
            if (!empty($this->input->post('password', TRUE))) {
                $update['password'] = secure_password_hash($this->input->post('password', TRUE));
            }

            // Update user into DB
            if (!empty($update)) {
                $this->db->where('reg_no', $id);
                $sql = $this->db->update('student', $update);
                if ($sql) {
                    set_flash_alert('Profile updated successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            }
        }
        return FALSE;
    }

    
    

}
