<?php

class Trainer_model
        extends CI_Model {

    function getReport() {
        $date = $this->input->post('date');
        $reg = $this->input->post('reg');

        if (!empty($reg) || !empty($date)) {
            $array = array("date" => $date, "regno" => $reg);
            $this->db->where($array);
            $q = $this->db->get('trainer_data');
            if ($q->num_rows() > 0) {
                return $q->result();
            } else {

                set_flash_alert("No data Found!", 'danger');
            }
        }
    }

    function getReport_data() {
        $date = $this->input->post('date');
        $emp = AdminLTE::user_data($this->session->user_id);

        if (!empty($date)) {
            $emp = $this->db->escape($emp);
            $date = $this->db->escape($date);
            $q = $this->db->query("Select * from trainer_data where trainer = $emp and WEEKOFYEAR(date) = WEEKOFYEAR($date) group by regno");
            if ($q->num_rows() > 0) {
                return $q->result();
            } else {

                set_flash_alert("No data Found of This Week!", 'danger');
            }
        }else{
               set_flash_alert("Please Select Date First!", 'danger');
        }
    }

    public function find($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->result();
    }

    public function find_students($id) {
        $this->db->where(array('course' => $id, 'status' => 1));
        $q = $this->db->get('student');
        return $q->result();
    }
    
     public function materials() {
         $emp = AdminLTE::user_data($this->session->user_id);
         $this->db->where("trainer", $emp);
        $this->db->order_by("id", "DESC");
        $q = $this->db->get('data');
        return $q->result();
    }

    public function find_student_info($id) {
        $this->db->where('regno', $id);
        $q = $this->db->get('admission_info');
        return $q->result();
    }

    public function student_info($id) {
        $this->db->where(array('regno' => $id));
        $this->db->order_by("id", "DESC");
        $this->db->limit(1);
        $q = $this->db->get('trainer_data');
        return $q->result();
    }
    
     public function data_detail($id) {
        $this->db->where(array('id' => $id));
        $q = $this->db->get('data');
        return $q->result();
    }

    public function create($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'attend[]',
                'label' => 'Attendance',
                'rules' => 'required'
            ],
            [
                'field' => 'punc[]',
                'label' => 'Punctuality',
                'rules' => 'required'
            ],
            [
                'field' => 'pre[]',
                'label' => 'Presentation',
                'rules' => 'required'
            ],
            [
                'field' => 'ling[]',
                'label' => 'Lingual Skill',
                'rules' => 'required'
            ],
            [
                'field' => 'coop[]',
                'label' => 'Cooperation',
                'rules' => 'required'
            ],
            [
                'field' => 'part[]',
                'label' => 'Participation',
                'rules' => 'required'
            ],
            [
                'field' => 'strategy',
                'label' => 'Strategy',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $trainer = $this->input->post('trainer', TRUE);
            $coop = $this->input->post('coop', TRUE);
            $pre = $this->input->post('pre', TRUE);
            $ling = $this->input->post('ling', TRUE);
            $part = $this->input->post('part', TRUE);
            $attend = $this->input->post('attend', TRUE);
            $punc = $this->input->post('punc', TRUE);
            $date = date("Y-m-d");
            $marks = $this->input->post('marks', TRUE);
            $tmarks = $this->input->post('tmarks', TRUE);
            $strategy = $this->input->post('strategy', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $course = $this->input->post('course', TRUE);


            $sql = $this->db->insert(
                    'trainer_data', [
                'attend' => implode(",", $attend),
                'pre' => implode(",", $pre),
                'part' => implode(",", $part),
                'punc' => implode(",", $punc),
                'ling' => implode(",", $ling),
                'coop' => implode(",", $coop),
                'marks' => $marks,
                'tmarks' => $tmarks,
                'stra' => $strategy,
                'regno' => $id,
                'comments' => $comments,
                'date' => $date,
                'trainer' => $trainer,
                'course' => $course,
                    ]
            );
            $lastid = $this->db->insert_id();
            $AA = $this->db->query("Select * from trainer_data where id = $lastid");
            foreach ($AA->result() as
                    $value) {
                $attend = explode(",", $value->attend)[0];
                $coop = explode(",", $value->coop)[0];
                $pre = explode(",", $value->pre)[0];
                $part = explode(",", $value->part)[0];
                $ling = explode(",", $value->ling)[0];
                $punc = explode(",", $value->punc)[0];
                $total1 = (($attend + $coop + $pre + $part + $ling + $punc) / 600) * 60;
                $total2 = ($value->marks / $value->tmarks) * 40;
                $total = $total1 + $total2;
                $this->db->where("id", $lastid);
                $sql = $this->db->update(
                        'trainer_data', [
                    'percentage' => $total,
                        ]
                );
            }
            if ($sql) {
                set_flash_alert('Report Done successfully', 'success');
                redirect('trainer/view/' . $id);
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function update($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'attend[]',
                'label' => 'Attendance',
                'rules' => 'required'
            ],
            [
                'field' => 'punc[]',
                'label' => 'Punctuality',
                'rules' => 'required'
            ],
            [
                'field' => 'pre[]',
                'label' => 'Presentation',
                'rules' => 'required'
            ],
            [
                'field' => 'ling[]',
                'label' => 'Lingual Skill',
                'rules' => 'required'
            ],
            [
                'field' => 'coop[]',
                'label' => 'Cooperation',
                'rules' => 'required'
            ],
            [
                'field' => 'part[]',
                'label' => 'Participation',
                'rules' => 'required'
            ],
            [
                'field' => 'strategy',
                'label' => 'Strategy',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $coop = $this->input->post('coop', TRUE);
            $pre = $this->input->post('pre', TRUE);
            $ling = $this->input->post('ling', TRUE);
            $part = $this->input->post('part', TRUE);
            $attend = $this->input->post('attend', TRUE);
            $punc = $this->input->post('punc', TRUE);
            $marks = $this->input->post('marks', TRUE);
            $tmarks = $this->input->post('tmarks', TRUE);
            $strategy = $this->input->post('strategy', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $date = $this->input->post('date', TRUE);

            $this->db->where(array('date' => $date, 'regno' => $id));
            $sql = $this->db->update(
                    'trainer_data', [
                'attend' => implode(",", $attend),
                'pre' => implode(",", $pre),
                'part' => implode(",", $part),
                'punc' => implode(",", $punc),
                'ling' => implode(",", $ling),
                'coop' => implode(",", $coop),
                'marks' => $marks,
                'tmarks' => $tmarks,
                'stra' => $strategy,
                'comments' => $comments
                    ]
            );
            $aa = $this->db->query("Select * from trainer_data where regno = '$id' and date ='" . $date . "'");

            foreach ($aa->result() as
                    $value) {
                $att = explode(",", $value->attend)[0];
                $co = explode(",", $value->coop)[0];
                $pr = explode(",", $value->pre)[0];
                $par = explode(",", $value->part)[0];
                $lin = explode(",", $value->ling)[0];
                $pun = explode(",", $value->punc)[0];
                $total1 = (($att + $co + $pr + $par + $lin + $pun) / 600) * 60;
                $total2 = ($value->marks / $value->tmarks) * 40;
                $total = $total1 + $total2;
                $this->db->where(array('date' => $date, 'regno' => $id));
                $sql = $this->db->update(
                        'trainer_data', [
                    'percentage' => $total,
                        ]
                );
            }
            if ($sql) {
                set_flash_alert('Report Updated successfully', 'success');
                redirect('trainer/view/' . $id);
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

            $q = $this->db->query("SELECT username, email FROM user WHERE (username = ? OR email = ?) AND id != ?", array($username, $email, $id));
            if ($q->num_rows() > 0) {
                set_flash_alert("This Username / Email Address is already Registered", 'danger');
                redirect('trainer');
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

    public function strategy() {
        return [
            '' => '',
            'Quiz' => 'Quiz',
            'Test' => 'Test',
            'Presentation' => 'Presentation',
            'Interview' => 'Interview',
        ];
    }

    public function check_course($course) {
        $array = array('course' => $course, 'status' => 1);
        $this->db->where($array);
        $q = $this->db->get('student');
        if ($q->num_rows() < 1) {
            set_flash_alert('No Student is enrolled in this Course', 'danger');
            redirect('trainer');
        }
    }

    public function check_data($course, $date) {
        $array = array('course_id' => $course, 'date' => $date);
        $this->db->where($array);
        $q = $this->db->get('attend');
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            set_flash_alert('No Record Found', 'danger');
            redirect('trainer');
        }
    }

    public function course_data($id) {
        $this->db->order_by('reg_no', 'ASC');
        $this->db->where(array('course' => $id, 'status' => 1));
        $q = $this->db->get('student');
        return $q->result();
    }

    public function check_attend($date, $course) {
        $array = array('course_id' => $course, 'date' => $date);
        $this->db->where($array);
        $q = $this->db->get('attend');
        if ($q->num_rows() > 0) {
            set_flash_alert('Attendance of this Course and Date Already Added', 'danger');
            redirect('trainer/view_attendance/' . $course . '/' . $date);
        }
    }

    public function create_attend($course) {

        $date = date("Y-m-d");
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
                        'course_id' => $course,
                        'date' => $date,
                        'std_id' => $user,
                    );
                }
            }
            $sql = $this->db->insert_batch('attend', $data);
            
            foreach ($attend as
            $userid =>
            $v) {
        $absent = AdminLTE::count_attend("status", 2, $userid);
        if($absent == 2){
            $msg = "Dear " . AdminLTE::student_name($userid) . ","
                    . "You have been absent for the last two days. Kindly confirm your attendance status, otherwise your registeration will be cancelled with the 3rd absentee."
                    ;
           $to = AdminLTE::student_data($userid, "contact");
           // AdminLTE::sms($to, $msg);
             $this->db->insert('logs', [
        'contact' => $to,
        'msg' => $msg,
        'date' => date("Y-m-d H:i:s"),
        'from_user' => $this->session->user_id,
    ]);
        }else if ($absent >= 3) {
            $this->db->where('regno', $userid);
            $sql = $this->db->update(
                    'admission_info', [
                'std_status' => 2,
                    ]
            );
            $this->db->where('reg_no', $userid);
            $sql = $this->db->update(
                    'student', [
                'status' => 2,
                'comments' => "3 days continuous absenteeism",
                'dates' => date('Y-m-d'),
                    ]
            );
            $sql = $this->db->delete('fee', ['reg_no' => $userid, 'status' => 0]);
            $absent_students[] = AdminLTE::student_name($userid);
            
              $msg = "Dear " . AdminLTE::student_name($userid) . ", 
                  It is to inform you that you have been absent for more than three days, so either make your presence sure tomorrow or send an application (in case of any problem), otherwise your registration will be cancelled and you will have to apply for readmission as per YDI policy. 
Regards,
Faisal Nabi
Evaluation Officer
"
                    ;
           $to = AdminLTE::student_data($userid, "contact");
           // AdminLTE::sms($to, $msg);
             $this->db->insert('logs', [
        'contact' => $to,
        'msg' => $msg,
        'date' => date("Y-m-d H:i:s"),
        'from_user' => $this->session->user_id,
    ]);
        }
    }
    if ($sql) {
        if (!empty($absent_students)) {
            set_flash_alert('Attendance Sheet created successfully. These students are struckoff due to 3 days continuous absenteeism ' . json_encode($absent_students), 'success');
        } else {
            set_flash_alert('Attendance Sheet created successfully.', 'success');
        }
            redirect('trainer/view_attendance/' . $course . '/' . $date);
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
    }

    public function update_attend($course, $date) {
        $attend = $this->input->post('attend', TRUE);
        $id = $this->input->post('id', TRUE);

        if (!empty($attend)) {

            foreach ($attend as
                    $user =>
                    $value) {
                foreach ($value as
                        $value1) {
                    $this->db->where(array('course_id' => $course, 'date' => $date, 'std_id' => $user));
                    $sql = $this->db->update('attend', [
                        'status' => $value1,
                    ]);
                }
            }

            if ($sql) {

                set_flash_alert('Attendance Sheet Update successfully', 'success');
                redirect('trainer/view_attendance/' . $course . '/' . $date);
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
    }

    public function upload() {

        $course = $this->input->post('course', TRUE);
        $topic = $this->input->post('topic', TRUE);
        $comments = $this->input->post('comments', TRUE);
             $link = $this->input->post('link', TRUE);
        $emp = AdminLTE::user_data($this->session->user_id);
         $config['upload_path'] = "./materials";
        $config['allowed_types'] = '*';
$config['max_size']     = '2000';
$config['max_width'] = '1024';
$config['max_height'] = '768';
        $this->load->library('upload', $config);
        
        $image = '';
        if ($this->upload->do_upload('image')) {
            $image = $this->upload->data('file_name');
        }else{
          set_flash_alert($this->upload->display_errors(), 'danger');
                return TRUE;
        }
           $sql = $this->db->insert(
                    'data', [
                        'topic' => $topic,
                        'course' => $course,
                        'comments' => $comments,
                        'data' => $image,
                        'trainer' => $emp,
                        'link' => $link
                    ]);
                
           if ($sql) {
                set_flash_alert('Data Uploaded successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        
        return FALSE;
        }
        
          public function edit_data($id) {

        $course = $this->input->post('course', TRUE);
        $topic = $this->input->post('topic', TRUE);
        $comments = $this->input->post('comments', TRUE);
         $link = $this->input->post('link', TRUE);
         $config['upload_path'] = "./materials";
        $config['allowed_types'] = '*';
$config['max_size']     = '2000';
$config['max_width'] = '1024';
$config['max_height'] = '768';
        $this->load->library('upload', $config);
        
        $image = '';
        if ($this->upload->do_upload('image')) {
            $image = $this->upload->data('file_name');
        }else{
          set_flash_alert($this->upload->display_errors(), 'danger');
                return TRUE;
        }
        $this->db->where("id", $id);
           $sql = $this->db->update(
                    'data', [
                        'topic' => $topic,
                        'course' => $course,
                        'comments' => $comments,
                        'data' => $image,
                        'link' => $link,
                    ]);
                
           if ($sql) {
                set_flash_alert('Data Updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        
        return FALSE;
        }
        
        public function delete_data($id) {


        $query = $this->db->delete('data', ['id' => $id]);

        if ($query) {
            set_flash_alert('Data deleted', 'success');
            return True;
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

}
