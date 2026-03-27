<?php

class Naway_model extends CI_Model {

     function getReport() {
        $date = $this->input->post('month');
        $reg = $this->input->post('reg');
$year = date("Y");
        if (!empty($reg) || !empty($date)) {
            $array = array("MONTH(date)" => $date, "YEAR(date)" => $year, "regno" => $reg);
            $this->db->where($array);
            $q = $this->db->get('report_naway');
            if ($q->num_rows() > 0) {
                return $q->result();
            } else {

                set_flash_alert("No data Found!", 'danger');
            }
        }
    }
    public function all() {
        $this->db->where('std_status', 1);
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('admission_info');
        return $q->result();
    }

    public function all_fee() {
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('naway_fee');
        return $q->result();
    }

    public function all_words() {
        $this->db->order_by('id', 'ASC');
        $q = $this->db->get('week_words');
        return $q->result();
    }

    public function naway_students() {
        $this->db->where("status", 1);
        $this->db->order_by('id', 'DESC');
        
        $q = $this->db->get('naway');
        return $q->result();
    }

    public function course_data() {
        $this->db->order_by('regno', 'ASC');
        $this->db->where(array(
            'status' => 1));
        $q = $this->db->get('naway');
        return $q->result();
    }

    public function check_attend($date) {
        $array = array(
            'date' => $date);
        $this->db->where($array);
        $q = $this->db->get('naway_attend');
        if ($q->num_rows() > 0) {
            set_flash_alert('Attendance of this Date Already Added', 'danger');
            redirect('nawaytakay/search');
        }
    }

    public function find($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->result();
    }

    public function find_words($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('week_words');
        return $query->row();
    }

    public function find_student_info($id) {
        $this->db->where('regno', $id);
        $q = $this->db->get('naway');
        return $q->result();
    }

    public function find_student($id) {
        $this->db->where('reg_no', $id);
        $q = $this->db->get('student');
        return $q->result();
    }

 public function update_student($id) {
// Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'fee',
                'label' => 'Fee',
                'rules' => 'required'
            ]
        ];

// Set rules
        $this->form_validation->set_rules($rules);
// Check form
        if ($this->form_validation->run() != FALSE) {

            $this->db->where('regno', $id);
            $fee = $this->input->post('fee', TRUE);
            $dates = $this->input->post('date', TRUE);

            $this->db->where('regno', $id);
            $sql = $this->db->update(
                    'naway', [
                'fee' => $fee,
                'date' => $dates
                    ]
            );

            if ($sql) {
               
                set_flash_alert('Student Record Updated successfully', 'success');

                redirect('nawaytakay/all');
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }
    public function struckoff($id) {
// Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'status',
                'label' => 'Status',
                'rules' => 'required'
            ]
        ];

// Set rules
        $this->form_validation->set_rules($rules);
// Check form
        if ($this->form_validation->run() != FALSE) {

            $this->db->where('regno', $id);
            $status = $this->input->post('status', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $dates = $this->input->post('date', TRUE);

            $this->db->where('regno', $id);
            $sql = $this->db->update(
                    'naway', [
                'status' => $status,
                'comments' => $comments,
                'dates' => $dates
                    ]
            );

            if ($sql) {
                $msg = " ";
                if ($status == 1) {
                    $msg = "Confirmed";
                }
                else if ($status == 2) {
                    $msg = "Struck Off";
                }
                set_flash_alert('Student ' . $msg . ' successfully', 'success');

                redirect('nawaytakay/all');
            }
            else {
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

            $q = $this->db->query("SELECT username, email FROM user WHERE (username = ? OR email = ?) AND id != ?", array($username, $email, $id));
            if ($q->num_rows() > 0) {
                set_flash_alert("This Username / Email Address is already Registered", 'danger');
                redirect('interviewer');
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
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function add_student($id) {
// Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'fee',
                'label' => 'Fee',
                'rules' => 'required'
            ]
        ];

// Set rules
        $this->form_validation->set_rules($rules);
// Check form
        if ($this->form_validation->run() != FALSE) {


            $fee = $this->input->post('fee', TRUE);
            $date = $this->input->post('date', TRUE);


            $sql = $this->db->insert(
                    'naway', [
                'regno' => $id,
                'date' => $date,
                'fee' => $fee,
                'status' => 1
                    ]
            );

            if ($sql) {
                set_flash_alert('Student Added to Naway Takay successfully', 'success');
                return TRUE;
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function add_words() {
// Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'month',
                'label' => 'Month',
                'rules' => 'required'
            ],
            [
                'field' => 'week',
                'label' => 'Week',
                'rules' => 'required'
            ]
        ];

// Set rules
        $this->form_validation->set_rules($rules);
// Check form
        if ($this->form_validation->run() != FALSE) {


            $month = $this->input->post('month', TRUE);
            $week = $this->input->post('week', TRUE);
            $words = $this->input->post('words', TRUE);
            $meanings = $this->input->post('meaning', TRUE);
$date = $this->input->post('date', TRUE);

            $sql = $this->db->insert(
                    'week_words', [
                'month' => $month,
                'week' => $week,
                'words' => implode(":", $words),
                'meanings' => implode(":", $meanings),
                'date' => $date
                    ]
            );

            if ($sql) {
                set_flash_alert('Weekly Words Added to Naway Takay successfully', 'success');
                return TRUE;
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function edit_words($id) {
// Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'month',
                'label' => 'Month',
                'rules' => 'required'
            ],
            [
                'field' => 'week',
                'label' => 'Week',
                'rules' => 'required'
            ]
        ];

// Set rules
        $this->form_validation->set_rules($rules);
// Check form
        if ($this->form_validation->run() != FALSE) {

$date = $this->input->post('date', TRUE);

            $month = $this->input->post('month', TRUE);
            $week = $this->input->post('week', TRUE);
            $words = $this->input->post('words', TRUE);
            $meanings = $this->input->post('meaning', TRUE);

            $this->db->where('id', $id);
            $sql = $this->db->update(
                    'week_words', [
                'month' => $month,
                'week' => $week,
                'words' => implode(":", $words),
                'meanings' => implode(":", $meanings),
                'date' => $date
                    ]
            );

            if ($sql) {
                set_flash_alert('Weekly Words Updated successfully', 'success');
                return TRUE;
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
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

    public function create_attend() {
        $date = $this->input->post('date', TRUE);
        $attend = $this->input->post('attend', TRUE);
        $id = $this->input->post('id', TRUE);
        $data = array();

        if (!empty($attend)) {

            foreach ($attend as
                    $user =>
                    $value) {
                foreach ($value as
                        $value1) {
                    $data[] = array(
                        'status' => $value1,
                        'date' => $date,
                        'std_id' => $user,
                    );
                }
            }

            $sql = $this->db->insert_batch('naway_attend', $data);

            if ($sql) {
                set_flash_alert('Attendance Sheet created successfully.', 'success');

                redirect('nawaytakay/view_attendance/' . $date);
                return TRUE;
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
    }

    public function check_data($date) {
        $array = array(
            'date' => $date);
        $this->db->where($array);
        $q = $this->db->get('naway_attend');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        else {
            set_flash_alert('No Record Found', 'danger');
            redirect('nawaytakay/all_attend');
        }
    }

    public function check_student() {

        $q = $this->db->get('naway');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        else {
            set_flash_alert('No Student enrolled!', 'danger');
            redirect('nawaytakay/all_fee');
        }
    }

    public function update_attend($date) {
        $attend = $this->input->post('attend', TRUE);
        $id = $this->input->post('id', TRUE);

        if (!empty($attend)) {

            foreach ($attend as
                    $user =>
                    $value) {
                foreach ($value as
                        $value1) {
                    $this->db->where(array(
                        'date' => $date,
                        'std_id' => $user));
                    $sql = $this->db->update('naway_attend', [
                        'status' => $value1,
                    ]);
                }
            }

            if ($sql) {

                set_flash_alert('Attendance Sheet Update successfully', 'success');
                redirect('nawaytakay/view_attendance/' . $date);
                return TRUE;
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
    }

    public function check_attend_view($date) {
        $array = array(
            'date' => $date);
        $this->db->where($array);
        $q = $this->db->get('naway_attend');
        if ($q->num_rows() < 1) {
            set_flash_alert('Attendance of this Date Not Found!', 'danger');
            redirect('nawaytakay/all_attend');
        }
    }

    public function group() {

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
            $array = array(
                'status' => 1);
            $this->db->where($array);
            $query = $this->db->get('naway');
            foreach ($query->result_array() as
                    $row) {

                $id = $row['regno'];
                $value = AdminLTE::student_data($row['regno'], "contact");
                if ($value == 0 || $value == "") {
                    continue;
                }


                AdminLTE::sms($value, $message);
                $this->db->insert('logs', [
                    'contact' => $value,
                    'msg' => $message,
                    'date' => date("Y-m-d H:i:s"),
                    'from_user' => $this->session->user_id,
                ]);
            }
        }
        return FALSE;
    }

    public function student_fee_dues_update($id) {

        $this->db->select('id');
        $array = array(
            'status' => 0,
            'reg_no' => $id);
        $this->db->where($array);
        $this->db->order_by('id', 'Desc');
        $this->db->limit(1);
        $query = $this->db->get('naway_fee');
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            $idd = $result[0]['id'];
            $this->db->where('id', $idd);
            $this->db->update(
                    'naway_fee', [
                'status' => 2,
                    ]
            );
        }
        else {
            return FALSE;
        }
    }

    public function student_fee_dues_update_p($id) {

        $this->db->select('id');
        $array = array(
            'status' => 4,
            'reg_no' => $id);
        $this->db->where($array);
        $this->db->order_by('id', 'Desc');
        $this->db->limit(1);
        $query = $this->db->get('naway_fee');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $idd = $result[0]['id'];
            $this->db->where('id', $idd);
            $this->db->update(
                    'naway_fee', [
                'status' => 2,
                    ]
            );
        }
        else {
            return FALSE;
        }
    }

    public function check_std($std, $month, $year) {
        $array = array(
            'reg_no' => $std,
            'month' => $month,
            'year' => $year);
        $this->db->where($array);
        $q = $this->db->get('naway_fee');
        if ($q->num_rows() > 0) {
            set_flash_alert('Fee Already Added', 'danger');
            redirect('nawaytakay/all_fee');
        }
    }

    public function student_fee_dues($id) {

        $this->db->select('dues');
        $array = array(
            'reg_no' => $id);
        $this->db->where($array);
        $this->db->order_by('id', 'Desc');
        $this->db->limit(1);
        $query = $this->db->get('naway_fee');
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['dues'];
        }
        else {
            return FALSE;
        }
    }

    public function create_fee() {

// Load form validation library
        $this->load->library('form_validation');
// define rules
        $rules = [
            [
                'field' => 'month',
                'label' => 'Month',
                'rules' => 'required'
            ],
            [
                'field' => 'monthly',
                'label' => 'Fee',
                'rules' => 'required'
            ]
        ];

// Set rules
        $this->form_validation->set_rules($rules);
// Check form
        if ($this->form_validation->run() != FALSE) {
            $data = array();
            $id[] = array();
            $this->check_student();
            $array = array(
                'status' => 1);
            $this->db->where($array);
            $query = $this->db->get('naway');
            foreach ($query->result_array() as
                    $row) {
                $id = $row['regno'];
                $date = $this->input->post('date', TRUE);
                $month = $this->input->post('month', TRUE);
                $monthly = $this->input->post('monthly', TRUE);

                $this->check_std($id, $month, date("Y"));
                $this->student_fee_dues_update($id);
                $this->student_fee_dues_update_p($id);
                $data[] = array(
                    'reg_no' => $id,
                    'month' => $month,
                    'year' => date("Y"),
                    'date' => $date,
                    'monthly' => $monthly,
                    'dues' => $monthly + $this->student_fee_dues($id),
                    'status' => 0,
                );
            }
            $sql = $this->db->insert_batch('naway_fee', $data);
            if ($sql) {
                set_flash_alert('Fee created successfully', 'success');
                return TRUE;
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function paid_fee($id) {

        $this->db->where('id', $id);
        $result = $this->db->query("select * from naway_fee where id = $id")->result_array();

        $total = $result[0]['dues'];

        $sql = $this->db->update(
                'naway_fee', [
            'status' => 1,
            'dues' => 0,
            'date' => date("Y-m-d"),
            'paid' => $total
                ]
        );
        if ($sql) {
            set_flash_alert('Fee has been Paid successfully', 'success');
            return TRUE;
        }
        else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function delete($id) {
        $query = $this->db->delete('naway_fee', ['id' => $id]);
        if ($query) {
            set_flash_alert('Fee deleted', 'danger');
        }
        else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function single() {

// Load form validation library
        $this->load->library('form_validation');
// define rules
        $rules = [
            [
                'field' => 'month',
                'label' => 'Month',
                'rules' => 'required'
            ],
            [
                'field' => 'monthly',
                'label' => 'Fee',
                'rules' => 'required'
            ]
        ];

// Set rules
        $this->form_validation->set_rules($rules);
// Check form
        if ($this->form_validation->run() != FALSE) {
            $id = $this->input->post('std', TRUE);

            $month = $this->input->post('month', TRUE);
            $monthly = $this->input->post('monthly', TRUE);
            $date = $this->input->post('date', TRUE);
            $this->check_std($id, $month, date("Y"));
            $this->student_fee_dues_update($id);
            $this->student_fee_dues_update_p($id);
            $sql = $this->db->insert(
                    'naway_fee', [
                'reg_no' => $id,
                'month' => $month,
                'year' => date("Y"),
                'date' => $date,
                'monthly' => $monthly,
                'dues' => $monthly + $this->student_fee_dues($id),
                'status' => 0,
            ]);


            if ($sql) {
                set_flash_alert('Fee created successfully', 'success');
                return TRUE;
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function bulk() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'sender[]',
                'label' => 'Phone Number',
                'rules' => 'required'
            ],
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
            $sender = $this->input->post('sender', TRUE);


            foreach ($sender as
                    $value) {


                AdminLTE::sms($value, $message);
                $this->db->insert('logs', [
                    'contact' => $value,
                    'msg' => $message,
                    'date' => date("Y-m-d H:i:s"),
                    'from_user' => $this->session->user_id,
                ]);
            }
        }
        return FALSE;
    }

    public function monthly_report($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'lc[]',
                'label' => 'Learned Vocabulary',
                'rules' => 'required'
            ],
            [
                'field' => 'conf[]',
                'label' => 'Confidence',
                'rules' => 'required'
            ],
            [
                'field' => 'ss[]',
                'label' => 'Sentence Structure',
                'rules' => 'required'
            ],
            [
                'field' => 'wp[]',
                'label' => 'Word Pronuncation',
                'rules' => 'required'
            ],
            [
                'field' => 'sp[]',
                'label' => 'Spellings',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $trainer = $this->input->post('trainer', TRUE);
            $lc = $this->input->post('lc', TRUE);
            $conf = $this->input->post('conf', TRUE);
            $ss = $this->input->post('ss', TRUE);
            $wp = $this->input->post('wp', TRUE);
            $sp = $this->input->post('sp', TRUE);
            $date = $this->input->post('date', TRUE);
 $stra = $this->input->post('strategy', TRUE);


            $sql = $this->db->insert(
                    'report_naway', [
                'lc' => implode(":", $lc),
                'ss' => implode(":", $ss),
                'conf' => implode(":", $conf),
                'wp' => implode(":", $wp),
                'sp' => implode(":", $sp),
                'regno' => $id,
                'date' => $date,
                'trainer' => $trainer,
                        'stra' => $stra,
                    ]
            );
            $lastid = $this->db->insert_id();
            $value = $this->db->query("Select * from report_naway where id = $lastid")->row();

            $lcm = explode(":", $value->lc)[0];
            $ssm = explode(":", $value->ss)[0];
            $confm = explode(":", $value->conf)[0];
            $wpm = explode(":", $value->wp)[0];
            $spm = explode(":", $value->sp)[0];

            $lctm = explode(":", $value->lc)[1];
            $sstm = explode(":", $value->ss)[1];
            $conftm = explode(":", $value->conf)[1];
            $wptm = explode(":", $value->wp)[1];
            $sptm = explode(":", $value->sp)[1];
            $totalm = $lcm + $ssm + $confm + $wpm + $spm;
            $totaltm = $lctm + $sstm + $conftm + $wptm + $sptm;
            ;
            $total = ($totalm * 100) / $totaltm;
            $this->db->where("id", $lastid);
            $sql = $this->db->update(
                    'report_naway', [
                'percentage' => $total,
                'marks' => $totalm,
                'tmarks' => $totaltm
                    ]
            );

            if ($sql) {
                set_flash_alert('Report Done successfully', 'success');
                redirect('nawaytakay/monthly_view/' . $id);
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

     public function monthly_update($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'lc[]',
                'label' => 'Learned Vocabulary',
                'rules' => 'required'
            ],
            [
                'field' => 'conf[]',
                'label' => 'Confidence',
                'rules' => 'required'
            ],
            [
                'field' => 'ss[]',
                'label' => 'Sentence Structure',
                'rules' => 'required'
            ],
            [
                'field' => 'wp[]',
                'label' => 'Word Pronuncation',
                'rules' => 'required'
            ],
            [
                'field' => 'sp[]',
                'label' => 'Spellings',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $trainer = $this->input->post('trainer', TRUE);
            $lc = $this->input->post('lc', TRUE);
            $conf = $this->input->post('conf', TRUE);
            $ss = $this->input->post('ss', TRUE);
            $wp = $this->input->post('wp', TRUE);
            $sp = $this->input->post('sp', TRUE);
            $date = $this->input->post('date', TRUE);
 $stra = $this->input->post('strategy', TRUE);

    $this->db->where(array('date' => $date, 'regno' => $id));
            $sql = $this->db->update(
                    'report_naway', [
                'lc' => implode(":", $lc),
                'ss' => implode(":", $ss),
                'conf' => implode(":", $conf),
                'wp' => implode(":", $wp),
                'sp' => implode(":", $sp),
                'date' => $date,
                'trainer' => $trainer,
                        'stra' => $stra,
                    ]
            );
            $aa = $this->db->query("Select * from report_naway where regno = '$id' and date ='" . $date . "'");

            foreach ($aa->result() as
                    $value) {
            $lcm = explode(":", $value->lc)[0];
            $ssm = explode(":", $value->ss)[0];
            $confm = explode(":", $value->conf)[0];
            $wpm = explode(":", $value->wp)[0];
            $spm = explode(":", $value->sp)[0];

            $lctm = explode(":", $value->lc)[1];
            $sstm = explode(":", $value->ss)[1];
            $conftm = explode(":", $value->conf)[1];
            $wptm = explode(":", $value->wp)[1];
            $sptm = explode(":", $value->sp)[1];
            $totalm = $lcm + $ssm + $confm + $wpm + $spm;
            $totaltm = $lctm + $sstm + $conftm + $wptm + $sptm;
            ;
            $total = ($totalm * 100) / $totaltm;
            $this->db->where(array('date' => $date, 'regno' => $id));
            $sql = $this->db->update(
                    'report_naway', [
                'percentage' => $total,
                'marks' => $totalm,
                'tmarks' => $totaltm
                    ]
            );
                    }
            if ($sql) {
                set_flash_alert('Report Updated successfully', 'success');
                redirect('nawaytakay/monthly_view/' . $id);
            }
            else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function student_info($id) {
        $this->db->where(array('regno' => $id));
        $this->db->order_by("id", "DESC");
        $this->db->limit(1);
        $q = $this->db->get('report_naway');
        return $q->result();
    }
    
    public function strategy() {
        return [
            '' => '',
            'Quiz' => 'Quiz',
            'Test' => 'Test',
            'Presentation' => 'Presentation',
            'Interview' => 'Interview',
            'Oral' => 'Oral',
        ];
    }
    
    
}
