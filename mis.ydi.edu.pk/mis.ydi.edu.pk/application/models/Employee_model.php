<?php

class Employee_model
        extends CI_Model {

    public function all() {
        $q = $this->db->get('employee');
        return $q->result();
    }

    public function find($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('employee');
        return $q->result();
    }

    public function check_user($username) {
        $array = array('username' => $username);
        $this->db->where($array);
        $q = $this->db->get('user');
        if ($q->num_rows() > 0) {
            set_flash_alert("This Username is already Registered", 'danger');
            redirect('admin/employee');
        }
    }

    public function check_course($course) {
        $array = array('course' => $course);
        $this->db->where($array);
        $q = $this->db->get('employee');
        if ($q->num_rows() > 0) {
            set_flash_alert("This Course " . AdminLTE::student_course($course) . " is already Registered", 'danger');
            redirect('admin/employee');
        }
    }

    public function create() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required'
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|is_unique[user.username]'
            ],
            [
                'field' => 'category',
                'label' => 'Category',
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
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            $this->upload->set_upload_path('./images');
            $image = '';
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data('file_name');
            }
            $status = $this->input->post('status', TRUE);
            $name = $this->input->post('name', TRUE);
            $course = $this->input->post('course[]', TRUE);
            $cnic = $this->input->post('cnic', TRUE);
            $qua = $this->input->post('qualification', TRUE);
            $cat = $this->input->post('category', TRUE);
            $contact = $this->input->post('contact', TRUE);
            $address = $this->input->post('address', TRUE);
            $salary = $this->input->post('salary', TRUE);
            $date = $this->input->post('join', TRUE);
            $username = $this->input->post('username', TRUE);
            $password = secure_password_hash($this->input->post('password', TRUE));


            $courses = "";

            if (!empty($course)) {

                $courses = implode(",", $course);
                $this->check_course($courses);
            }

            if ($image == '') {
                // Insert user into DB
                $sql = $this->db->insert(
                        'employee', [
                    'name' => $name,
                    'cnic' => $cnic,
                    'course' => $courses,
                    'qualification' => $qua,
                    'category' => $cat,
                    'address' => $address,
                    'contact' => $contact,
                    'salary' => $salary,
                    'join_date' => $date,
                    'status' => $status,
                        ]
                );
                if ($cat == "Admin" || $cat == "Interviewer" || $cat == "Trainer" || $cat == "CardMaker" || $cat == "NawayTakay") {
                    $sql = $this->db->insert(
                            'user', [
                        'fullname' => $name,
                        'username' => $username,
                        'password' => $password,
                        'address' => $address,
                        'phone' => $contact,
                        'status' => $status,
                        'level' => $cat,
                        'emp_id' => $this->db->insert_id(),
                            ]
                    );
                }
                if ($sql) {
                    set_flash_alert('Employee created successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            } else {

                // Insert user into DB
                $sql = $this->db->insert(
                        'employee', [
                    'name' => $name,
                    'cnic' => $cnic,
                    'course' => $courses,
                    'qualification' => $qua,
                    'category' => $cat,
                    'address' => $address,
                    'contact' => $contact,
                    'img' => $image,
                    'salary' => $salary,
                    'join_date' => $date,
                    'status' => $status,
                        ]
                );
                if ($cat == "Admin" || $cat == "Interviewer" || $cat == "Trainer" || $cat == "CardMaker" || $cat == "NawayTakay") {
                    $sql = $this->db->insert(
                            'user', [
                        'fullname' => $name,
                        'username' => $username,
                        'password' => $password,
                        'address' => $address,
                        'phone' => $contact,
                        'status' => $status,
                        'level' => $cat,
                        'emp_id' => $this->db->insert_id(),
                            ]
                    );
                }
                if ($sql) {
                    set_flash_alert('Employee created successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            }
        }
        return FALSE;
    }

    public function update($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required'
            ],
            [
                'field' => 'category',
                'label' => 'Category',
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
            $config['allowed_types'] = 'gif|jpg|png';

            $this->load->library('upload', $config);
            $this->upload->set_upload_path('./images');
            $image = '';
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data('file_name');
            }
            $status = $this->input->post('status', TRUE);
            $name = $this->input->post('name', TRUE);
            $course = $this->input->post('course[]', TRUE);
            $cnic = $this->input->post('cnic', TRUE);
            $qua = $this->input->post('qualification', TRUE);
            $cat = $this->input->post('category', TRUE);
            $contact = $this->input->post('contact', TRUE);
            $address = $this->input->post('address', TRUE);
            $salary = $this->input->post('salary', TRUE);
            $date = $this->input->post('join', TRUE);
            $courses = "";
            if (!empty($course)) {

                $courses = implode(",", $course);
           
            }
            // Insert user into DB
            $this->db->where('id', $id);
            if ($image == '') {
                $sql = $this->db->update(
                        'employee', [
                    'name' => $name,
                    'cnic' => $cnic,
                    'course' => $courses,
                    'qualification' => $qua,
                    'category' => $cat,
                    'address' => $address,
                    'contact' => $contact,
                    'salary' => $salary,
                    'join_date' => $date,
                    'status' => $status,
                        ]
                );
                if ($sql) {
                    set_flash_alert('Employee Updated successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            } else {
                $sql = $this->db->update(
                        'employee', [
                    'name' => $name,
                    'cnic' => $cnic,
                    'course' => $courses,
                    'qualification' => $qua,
                    'category' => $cat,
                    'address' => $address,
                    'contact' => $contact,
                    'img' => $image,
                    'salary' => $salary,
                    'join_date' => $date,
                    'status' => $status,
                        ]
                );
                if ($sql) {
                    set_flash_alert('Employee Updated successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            }
        }
        return FALSE;
    }

    public function delete($id) {
        $image = $this->find($id);
        $images = $image[0]->img;
        if (file_exists($images)) {
            $this->load->helper("file");
            delete_files(base_url() . 'images/' . $images);
        }

        $query = $this->db->delete('employee', ['id' => $id]);
        $query = $this->db->delete('salary', ['emp_id' => $id]);
        $query = $this->db->delete('user', ['emp_id' => $id]);
        if ($query) {
            set_flash_alert('Employee deleted', 'success');
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

    public function course() {
        return [
            '' => '',
            'Male' => 'Male',
            'Female' => 'Female',
        ];
    }

    public function Category() {
        return [
            '' => '',
            'Manager' => 'Manager',
            'Admin' => 'Administration',
            'Interviewer' => 'Evaluation / Interviewer',
            'Trainer' => 'Trainer',
            'Consultant' => 'Consultancy',
            'Publications' => 'Publications',
             'Internee' => 'Internee',
            'Security' => 'Security',
            'Peon' => 'Peon',
            'NawayTakay' => 'Naway Takay',
        ];
    }

    public function send_sms() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'message',
                'label' => 'Message',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $sender = $this->input->post('sender', TRUE);
            $msg = $this->input->post('message', TRUE);
            // Insert user into DB

            AdminLTE::sms($sender, $msg);
            $this->db->insert('logs', [
                'contact' => $sender,
                'msg' => $msg,
                'date' => date("Y-m-d H:i:s"),
                'from_user' => $this->session->user_id,
            ]);
        }
        return FALSE;
    }

    public function groupsms() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'message',
                'label' => 'Message',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $message = $this->input->post('message', TRUE);

            $id[] = array();
            $array = array('status' => 1);
            $this->db->where($array);
            $query = $this->db->get('employee');
            foreach ($query->result_array() as
                    $row) {

                $id = $row['id'];
                $value = $row['contact'];

                if (!empty($value)) {
                    AdminLTE::sms($value, $message);
                    $this->db->insert('logs', [
                        'contact' => $value,
                        'msg' => $message,
                        'date' => date("Y-m-d H:i:s"),
                        'from_user' => $this->session->user_id,
                    ]);
                }
            }
        }
        return FALSE;
    }

}
