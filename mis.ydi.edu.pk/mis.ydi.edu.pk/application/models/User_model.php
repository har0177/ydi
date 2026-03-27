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
            ],
            [
                'field' => 'level',
                'label' => 'Level',
                'rules' => 'required'
            ]
        ];
        // check rules
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() != FALSE) {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password');
            $level = $this->input->post('level', TRUE);

            // Get user by username first (without password check)
            $this->db->select('*');
            $this->db->where('username', $username);
            $this->db->where('level', $level);
            $query = $this->db->get('user');
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
                $this->db->update('user', ['password' => $new_hash]);
            }

            // Regenerate session ID to prevent session fixation
            $this->session->sess_regenerate(TRUE);

            $this->session->set_userdata([
                'user_logged' => $user->username,
                'user_id' => $user->id,
                'user_name' => $user->fullname,
                'user_status' => $user->status,
                'user_level' => $user->level,
            ]);
            set_flash_alert('logged-in successfully', 'success');
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function all() {
        $query = $this->db->get('user');
        return $query->result();
    }

    public function create() {
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
                'rules' => 'required|is_unique[user.username]'
            ],
            [
                'field' => 'email',
                'label' => 'Email address',
                'rules' => 'required|valid_email|is_unique[user.email]'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Retype Password',
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
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ],
            [
                'field' => 'level',
                'label' => 'Level',
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
            $status = $this->input->post('status', TRUE);
            $level = $this->input->post('level', TRUE);


            // Insert user into DB
            $sql = $this->db->insert(
                    'user', [
                'fullname' => $fullname,
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'address' => $address,
                'phone' => $phone,
                'status' => $status,
                'level' => $level,
                    ]
            );
            if ($sql) {
                set_flash_alert('User created successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function update($id) {
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
            [
                'field' => 'status',
                'label' => 'Status',
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
            $status = $this->input->post('status', TRUE);
            $level = $this->input->post('level', TRUE);

            $q = $this->db->query("Select username, email from user where (username = '" . $username . "' OR email = '" . $email . "') and id != $id");

            if ($q->num_rows() > 0) {
                set_flash_alert("This Username / Email Address is already Registered", 'danger');
                redirect('admin/user');
            }
            // Data for db
            $update['fullname'] = $fullname;
            $update['username'] = $username;
            $update['email'] = $email;
            if (!empty($this->input->post('password', TRUE))) {
                $update['password'] = $password;
            }
            $update['address'] = $address;
            $update['phone'] = $phone;
            $update['status'] = $status;
            $update['level'] = $level;

            // Update user into DB
            $this->db->where('id', $id);
            $sql = $this->db->update('user', $update);
            if ($sql) {
                set_flash_alert('User updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
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

            $q = $this->db->query("Select username, email from user where (username = '" . $username . "' OR email = '" . $email . "') and id != $id");
            if ($q->num_rows() > 0) {
                set_flash_alert("This Username / Email Address is already Registered", 'danger');
                redirect('admin/user');
            }
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

    public function find($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->result();
    }

    public function delete($id) {
        $query = $this->db->delete('user', ['id' => $id]);
        if ($query) {
            set_flash_alert('User deleted', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function activate($id) {
        $query = $this->db->update('user', ['deleted' => '0'], ['id' => $id]);
        if ($query) {
            set_flash_alert('User Activated', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function forget() {
        $email = $this->input->post('email', TRUE);
        $array = array('email' => $email);
        $this->db->where($array);
        $q = $this->db->get('user');
        if ($q->num_rows() == 0) {
            set_flash_alert("This Email is not Registered", 'danger');
            redirect('admin/user');
        } else {
            $pass = random_string('alnum', 12); // Longer random password
            $password = secure_password_hash($pass);

            $config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://mail.ydi.edu.pk',
    'smtp_port' => 465,
    'smtp_user' => 'haroon0177@ydi.edu.pk',
    'smtp_pass' => 'ydi@0177',
    'mailtype'  => 'html', 
    'charset'   => 'iso-8859-1'
);
$this->load->library('email', $config);
$this->email->set_newline("\r\n");
$this->email->clear();
            $this->email->from('haroon0177@ydi.edu.pk', 'Youth Development Institute Swat');
            $this->email->to($email);
            $this->email->subject('YDI Password Reset');
            $this->email->message("Your Password has been successfully reset.  \r\n Your new password: " . $pass);

            $send = $this->email->send();
            if ($send) {
                $update['password'] = $password;
                $this->db->where('email', $email);
                $sql = $this->db->update('user', $update);
                if ($sql) {
                    set_flash_alert('Password Reset Successfully Check Your Email Address', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
                
            } else {
                set_flash_alert("Email not send", 'danger');
            }
        }
    }

    public function deactivate($id) {
        $query = $this->db->update('user', ['deleted' => '1'], ['id' => $id]);
        if ($query) {
            set_flash_alert('User Deactivated', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function status() {
        return [
            '' => '',
            '1' => 'Active',
            '0' => 'Deactive',
        ];
    }

    public function level() {
        return [
            '' => '',
            'Manager' => 'Manager',
            'Admin' => 'Administration',
            'Interviewer' => 'Evaluation / Interviewer',
            'Trainer' => 'Trainer',
            'Consultant' => 'Consultancy',
            'Publications' => 'Publications',
            'NawayTakay' => 'Naway Takay',
          'Internee' => 'Internee',

        ];
    }

}
