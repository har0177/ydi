<?php

class Card_model extends CI_Model {

    public function all() {
        $this->db->order_by('id', 'DESC');
         $this->db->where('status', 1);
        $q = $this->db->get('student');
        return $q->result();
    }

    public function idcards() {
        $array = array('card_status' => 0);
        $this->db->where($array);
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('student');
        return $q->result();
    }

    
    public function find($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('student');
        return $q->result();
    }

    public function find_student($id) {
        $this->db->where('reg_no', $id);
        $q = $this->db->get('student');
        return $q->result();
    }
    
     public function find_user($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->result();
    }
    public function userprofile($id) {
        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'fullname',
                'label' => 'Fullname',
                'rules' => 'required'
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required'
            ],
            [
                'field' => 'email',
                'label' => 'Email address',
                'rules' => 'required|valid_email|trim'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'required|matches[password]'
            ],
            [
                'field' => 'address',
                'label' => 'Address',
                'rules' => 'required'
            ],
            [
                'field' => 'phone',
                'label' => 'Phone Number',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $fullname = $this->input->post('fullname', TRUE);
            $username = $this->input->post('username', TRUE);
            $email = $this->input->post('email', TRUE);
            $password = secure_password_hash($this->input->post('password', TRUE));
            $address = $this->input->post('address', TRUE);
            $phone = $this->input->post('phone', TRUE);


            // Data for db
            $update['fullname'] = $fullname;
            $update['username'] = $username;
            $update['email'] = $email;
            if (!empty($this->input->post('password', TRUE))) {
                $update['password'] = $password;
            }
            $update['address'] = $address;
            $update['phone'] = $phone;

            // Update user into DB
            $this->db->where('id', $id);
            $sql = $this->db->update('user', $update);
            if ($sql) {
                set_flash_alert('Profile updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }
    
    
    public function issue($id) {

		
                            $this->db->where('reg_no', $id);
                $sql = $this->db->update(
                        'student', [
                    'card_status' => 1
                        ]
                );
                   
                if ($sql) {
			set_flash_alert('Student Card Issued successfully', 'success');
			return TRUE;
		} else {
			set_flash_alert(implode(': ', $this->db->error()));
		}
		
		

		return FALSE;
	}


}
