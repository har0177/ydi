<?php

class User_model
        extends CI_Model {

    public function login() {
        $this->load->library('form_validation');

        // Define rules
        $rules = [
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ]
        ];
        // check rules
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() != FALSE) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password');

            // Get user by username first
            $this->db->select('*');
            $this->db->where('reg_no', $username);
            $this->db->where('status', 1);
            $query = $this->db->get('student');
            $result = $query->result();

            if (empty($result)) {
                set_flash_alert('Invalid login details');
                return false;
            }

            $user = $result[0];

            // Use secure password verification with backward compatibility
            if (!verify_password($password, $user->password)) {
                set_flash_alert('Invalid login details');
                return false;
            }

            // Migrate legacy password to secure hash if needed
            if (is_legacy_password($user->password)) {
                $new_hash = secure_password_hash($password);
                $this->db->where('id', $user->id);
                $this->db->update('student', ['password' => $new_hash]);
            }

            // Regenerate session ID to prevent session fixation
            $this->session->sess_regenerate(TRUE);

            $this->session->set_userdata([
                'user_logged' => $user->reg_no,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_status' => $user->status,
            ]);
            $this->db->insert(
                    'log_details', [
                        'regno' => $user->reg_no,
                        'login' => date("Y-m-d H:i:s")
                        ]);
            set_flash_alert('logged-in successfully', 'success');
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
     public function logout() {
          $this->db->where('regno', $this->session->user_logged);
          $this->db->order_by('id', 'DESC');
          $this->db->limit(1);
           $this->db->update(
                    'log_details', [
                            'logout' => date("Y-m-d H:i:s")
                        ]);
     }

   
  
}
