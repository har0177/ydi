<?php

class Inter_model
        extends CI_Model {

  public function all_observations() {
     
        $this->db->order_by('id', 'DESC');
            // Get the current year and month
    $currentYear = date('Y');
    //$currentMonth = date('m');
    
    // Add the where condition to filter by the current month
    $this->db->where('YEAR(date)', $currentYear);
    //$this->db->where('MONTH(date)', $currentMonth);
    
        $q = $this->db->get('observations');
        return $q->result();
    }
    
       public function viewObservation($id) {
        $this->db->where('id', $id);
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('observations');
        return $q->result();
    }
    
      public function createObservation() {
     
    // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required'
            ],
            [
                'field' => 'batch',
                'label' => 'Batch Name',
                'rules' => 'required'
            ],
            [
                'field' => 'one[]',
                'label' => 'HOW NICELY THE TRAINERS DEALS WITH LATE COMERS?',
                'rules' => 'required'
            ],
            [
                'field' => 'two[]',
                'label' => 'HOW THE TRAINER INTRODUCED OBJECTIVES OF THE SESSION ?',
                'rules' => 'required'
            ],
             [
        'field' => 'three[]',
        'label' => 'HOW HE/SHE STARTED THE SESSION (ICEBREAKER)?',
        'rules' => 'required'
    ],
    [
        'field' => 'four[]',
        'label' => 'HOW HE/SHE ENGAGED ALL STUDENTS?',
        'rules' => 'required'
    ],
    [
        'field' => 'five[]',
        'label' => 'WHAT KIND OF AV AIDS DID HE/SHE USE FOR TEACHING?',
        'rules' => 'required'
    ],
    [
        'field' => 'six[]',
        'label' => 'HOW MUCH IS THE RATIO OF STUDENT TALKING TIME AND TRAINER TALKING TIME IN THE SESSION?',
        'rules' => 'required'
    ],
    [
        'field' => 'seven[]',
        'label' => 'HOW HE/SHE APPRECIATED ENCOURAGED THE TRAINEES?',
        'rules' => 'required'
    ],
    [
        'field' => 'eight[]',
        'label' => 'WHAT KIND OF ENERGIZERS DID HE/SHE USE FOR CREATING A CONDUCIVE ENVIRONMENT?',
        'rules' => 'required'
    ],
    [
        'field' => 'nine[]',
        'label' => 'HOW THE TRAINER ASSIGNED HOMEWORK?',
        'rules' => 'required'
    ],
    [
        'field' => 'ten[]',
        'label' => 'HOW HE/SHE ENGAGED SLOW LEARNERS?',
        'rules' => 'required'
    ],
    [
        'field' => 'eleven[]',
        'label' => 'DID HE PREPARE LESSON PLAN AND HOW DID HE EXECUTE IT?',
        'rules' => 'required'
    ],
    [
        'field' => 'twelve[]',
        'label' => 'HOW DID HE EMPLOYED STRATEGIES TO ACHIEVE THE SESSION OBJECTIVES?',
        'rules' => 'required'
    ],
    [
        'field' => 'thirteen[]',
        'label' => 'HOW PROFICIENT IS THE TRAINER IN TERMS OF FLUENCY, PRONUNCIATION, SENTENCE STRUCTURE AND UNDERSTANDING OF THE TOPIC?
',
        'rules' => 'required'
    ]
          
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $name = $this->input->post('name', TRUE);
            $batch = $this->input->post('batch', TRUE);
            $date = $this->input->post('date', TRUE);
            $one = $this->input->post('one', TRUE);
            $two = $this->input->post('two', TRUE);
             $three = $this->input->post('three', TRUE);
    $four = $this->input->post('four', TRUE);
    $five = $this->input->post('five', TRUE);
    $six = $this->input->post('six', TRUE);
    $seven = $this->input->post('seven', TRUE);
    $eight = $this->input->post('eight', TRUE);
    $nine = $this->input->post('nine', TRUE);
    $ten = $this->input->post('ten', TRUE);
    $eleven = $this->input->post('eleven', TRUE);
    $twelve = $this->input->post('twelve', TRUE);
    $thirteen = $this->input->post('thirteen', TRUE);
            $sql = $this->db->insert(
                    'observations', [
                'name' => $name,
                'batch' => $batch,
                'date' => $date,
                'one' => implode(",", $one),
                'two' => implode(",", $two),
                   'three' => implode(",", $three),
        'four' => implode(",", $four),
        'five' => implode(",", $five),
        'six' => implode(",", $six),
        'seven' => implode(",", $seven),
        'eight' => implode(",", $eight),
        'nine' => implode(",", $nine),
        'ten' => implode(",", $ten),
        'eleven' => implode(",", $eleven),
        'twelve' => implode(",", $twelve),
        'thirteen' => implode(",", $thirteen)
              
                    ]
            );
         
            if ($sql) {
                set_flash_alert('Observation Form successfully', 'success');
               return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }
    
   
    
    public function all() {
         $status = $this->input->post( 'status' );
    $course = $this->input->post( 'course' );
 
    if( !empty( $status ) || !empty( $course ) ) {
      if( $course === 'all' ) {
        $array = [ 'std_status' => $status ];
      } else {
        $array = [ 'course' => $course, 'std_status' => $status ];
      }
    } else {
                 // Get the current year and month
    $currentYear = date('Y');
    $currentMonth = date('m');
    
    // Add the where condition to filter by the current month
    $this->db->where('YEAR(date)', $currentYear);
    $this->db->where('MONTH(date)', $currentMonth);
    
      $array = [ 'std_status' => 1 ];
    }
        $this->db->where( $array );
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('admission_info');
        return $q->result();
    }

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

    public function report($id) {
        $this->db->where('regno', $id);
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('trainer_data');
        return $q->result();
    }
   
    
    

    public function dashboard() {
        $this->db->order_by('id', 'DESC');
                 // Get the current year and month
    $currentYear = date('Y');
    $currentMonth = date('m');
    
    // Add the where condition to filter by the current month
    $this->db->where('YEAR(date)', $currentYear);
    $this->db->where('MONTH(date)', $currentMonth);
        $q = $this->db->get('admission_info');
        return $q->result();
    }

    public function find($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('user');
        return $query->result();
    }

    public function find_student_info($id) {
        $this->db->where('regno', $id);
        $q = $this->db->get('admission_info');
        return $q->result();
    }

    public function Inter_student_info($id) {
        $this->db->where(array('regno' => $id, 'status' => 1));
        $q = $this->db->get('interview');
        return $q->result();
    }

    public function Inter_student_info_final($id) {
        $this->db->where(array('regno' => $id, 'status' => 3));
        $q = $this->db->get('interview');
        return $q->result();
    }

    public function update_fee($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'interview',
                'label' => 'Interviwe Fee',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $this->db->where('regno', $id);
            $interview = $this->input->post('interview', TRUE);


            $sql = $this->db->update(
                    'admission_info', [
                'interview' => $interview
                    ]
            );
            if ($sql) {
                set_flash_alert('Interview Fee Updated successfully', 'success');
                redirect('interviewer/all');
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function paid_fee($id) {

        $this->db->where('regno', $id);


        $sql = $this->db->update(
                'admission_info', [
            'interview_status' => 1,
            'other_status' => 1
                ]
        );
        if ($sql) {
            set_flash_alert('Interview & Form Fee has been Paid successfully', 'success');
            redirect('interviewer/all');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
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
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function create($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'edir',
                'label' => 'EDIR Number',
                'rules' => 'required'
            ],
            [
                'field' => 'cstart',
                'label' => 'Classes Starts From',
                'rules' => 'required'
            ],
            [
                'field' => 'comp[]',
                'label' => 'Comprehension',
                'rules' => 'required'
            ],
            [
                'field' => 'grac[]',
                'label' => 'Grammar Accuracy',
                'rules' => 'required'
            ],
            [
                'field' => 'compro[]',
                'label' => 'Comprehensibility & Pronunciation',
                'rules' => 'required'
            ],
            [
                'field' => 'flu[]',
                'label' => 'Fluency',
                'rules' => 'required'
            ],
            [
                'field' => 'mtol[]',
                'label' => 'Maturity Of Language',
                'rules' => 'required'
            ],
            [
                'field' => 'voca[]',
                'label' => 'Vocabulary',
                'rules' => 'required'
            ],
            [
                'field' => 'greet[]',
                'label' => 'Greetings/ Farewell',
                'rules' => 'required'
            ],
            [
                'field' => 'blang[]',
                'label' => 'Body Language',
                'rules' => 'required'
            ],
            [
                'field' => 'clevel[]',
                'label' => 'Confidence Level',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $edir = $this->input->post('edir', TRUE);
            $comp = $this->input->post('comp', TRUE);
            $grac = $this->input->post('grac', TRUE);
            $compro = $this->input->post('compro', TRUE);
            $flu = $this->input->post('flu', TRUE);
            $mtol = $this->input->post('mtol', TRUE);
            $voca = $this->input->post('voca', TRUE);
            $greet = $this->input->post('greet', TRUE);
            $blang = $this->input->post('blang', TRUE);
            $clevel = $this->input->post('clevel', TRUE);
            $course = $this->input->post('course', TRUE);
            $cstart = $this->input->post('cstart', TRUE);
            $idate = $this->input->post('idate', TRUE);
             $inter_name = $this->input->post('inter_name', TRUE);
            $comments = $this->input->post('comments', TRUE);


            $sql = $this->db->insert(
                    'interview', [
                'edir' => $edir,
                'comp' => implode(",", $comp),
                'grac' => implode(",", $grac),
                'compro' => implode(",", $compro),
                'flu' => implode(",", $flu),
                'mtol' => implode(",", $mtol),
                'voca' => implode(",", $voca),
                'greet' => implode(",", $greet),
                'blang' => implode(",", $blang),
                'clevel' => implode(",", $clevel),
                'regno' => $id,
                'cstart' => $cstart,
                'date' => $idate,
                'status' => 1,
                'inter_name' => $inter_name,
                'comments' => $comments
                    ]
            );
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'student', [
                'course' => $course,
                'status' => 1
            ]);
            $this->db->where('regno', $id);
            $sql = $this->db->update(
                    'admission_info', [
                'course' => $course,
                'interview_status' => 1,
                'other_status' => 1,
                'std_status' => 1
            ]);
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'fee', [
                'course' => $course,
            ]);
            if ($sql) {
                set_flash_alert('Interview Done & Interview + Form Fee Paid successfully', 'success');
                redirect('interviewer/view/' . $id);
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
                'field' => 'edir',
                'label' => 'EDIR Number',
                'rules' => 'required'
            ],
            [
                'field' => 'cstart',
                'label' => 'Classes Starts From',
                'rules' => 'required'
            ],
            [
                'field' => 'comp[]',
                'label' => 'Comprehension',
                'rules' => 'required'
            ],
            [
                'field' => 'grac[]',
                'label' => 'Grammar Accuracy',
                'rules' => 'required'
            ],
            [
                'field' => 'compro[]',
                'label' => 'Comprehensibility & Pronunciation',
                'rules' => 'required'
            ],
            [
                'field' => 'flu[]',
                'label' => 'Fluency',
                'rules' => 'required'
            ],
            [
                'field' => 'mtol[]',
                'label' => 'Maturity Of Language',
                'rules' => 'required'
            ],
            [
                'field' => 'voca[]',
                'label' => 'Vocabulary',
                'rules' => 'required'
            ],
            [
                'field' => 'greet[]',
                'label' => 'Greetings/ Farewell',
                'rules' => 'required'
            ],
            [
                'field' => 'blang[]',
                'label' => 'Body Language',
                'rules' => 'required'
            ],
            [
                'field' => 'clevel[]',
                'label' => 'Confidence Level',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $edir = $this->input->post('edir', TRUE);
            $comp = $this->input->post('comp', TRUE);
            $grac = $this->input->post('grac', TRUE);
            $compro = $this->input->post('compro', TRUE);
            $flu = $this->input->post('flu', TRUE);
            $mtol = $this->input->post('mtol', TRUE);
            $voca = $this->input->post('voca', TRUE);
            $greet = $this->input->post('greet', TRUE);
            $blang = $this->input->post('blang', TRUE);
            $clevel = $this->input->post('clevel', TRUE);
            $course = $this->input->post('course', TRUE);
            $idate = $this->input->post('idate', TRUE);
            $cstart = $this->input->post('cstart', TRUE);
             $inter_name = $this->input->post('inter_name', TRUE);
            $comments = $this->input->post('comments', TRUE);


            $this->db->where(array('regno' => $id, 'status' => 1));
            $sql = $this->db->update(
                    'interview', [
                'edir' => $edir,
                'comp' => implode(",", $comp),
                'grac' => implode(",", $grac),
                'compro' => implode(",", $compro),
                'flu' => implode(",", $flu),
                'mtol' => implode(",", $mtol),
                'voca' => implode(",", $voca),
                'greet' => implode(",", $greet),
                'blang' => implode(",", $blang),
                'clevel' => implode(",", $clevel),
                'cstart' => $cstart,
                'date' => $idate,
                 'inter_name' => $inter_name,
                'comments' => $comments
                    ]
            );
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'student', [
                'course' => $course,
                'status' => 1
            ]);
            $this->db->where('regno', $id);
            $sql = $this->db->update(
                    'admission_info', [
                'course' => $course,
                'std_status' => 1
            ]);
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'fee', [
                'course' => $course,
            ]);
            if ($sql) {
                set_flash_alert('Interview Details Updated successfully', 'success');
                redirect('interviewer/view/' . $id);
            } else {
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
                    'admission_info', [
                'std_status' => $status
                    ]
            );
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'student', [
                'status' => $status,
                'comments' => $comments,
                'dates' => $dates
                    ]
            );
            if ($status == 2) {
                $sql = $this->db->delete('fee', ['reg_no' => $id, 'status' => 0]);
            }
            if ($sql) {
                $msg = " ";
                if ($status == 1) {
                    $msg = "Confirmed";
                } else if ($status == 2) {
                    $msg = "Struck Off";
                } else if ($status == 3) {
                    $msg = "Freeze";
                } else {
                    $msg = "Pending";
                }
                set_flash_alert('Student ' . $msg . ' successfully', 'success');

                redirect('interviewer/all');
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function radm($id) {
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
            $fee = $this->input->post('fee', TRUE);

            $sql = $this->db->insert(
                    'radm_fee', [
                'fee' => $fee,
                'regno' => $id
                    ]
            );

            $this->db->where('regno', $id);
            $sql = $this->db->update(
                    'admission_info', [
                'std_status' => $status
                    ]
            );
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'student', [
                'status' => $status,
                    ]
            );
            if ($sql) {
                $msg = " ";
                if ($status == 1) {
                    $msg = "Confirmed";
                } else if ($status == 2) {
                    $msg = "Struck Off";
                } else if ($status == 3) {
                    $msg = "Freeze";
                } else {
                    $msg = "Pending";
                }
                set_flash_alert('Student ' . $msg . ' successfully', 'success');

                redirect('interviewer/all');
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function create_final($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'edir',
                'label' => 'EDIR Number',
                'rules' => 'required'
            ],
            [
                'field' => 'comp[]',
                'label' => 'Comprehension',
                'rules' => 'required'
            ],
            [
                'field' => 'grac[]',
                'label' => 'Grammar Accuracy',
                'rules' => 'required'
            ],
            [
                'field' => 'compro[]',
                'label' => 'Comprehensibility & Pronunciation',
                'rules' => 'required'
            ],
            [
                'field' => 'flu[]',
                'label' => 'Fluency',
                'rules' => 'required'
            ],
            [
                'field' => 'mtol[]',
                'label' => 'Maturity Of Language',
                'rules' => 'required'
            ],
            [
                'field' => 'voca[]',
                'label' => 'Vocabulary',
                'rules' => 'required'
            ],
            [
                'field' => 'greet[]',
                'label' => 'Greetings/ Farewell',
                'rules' => 'required'
            ],
            [
                'field' => 'blang[]',
                'label' => 'Body Language',
                'rules' => 'required'
            ],
            [
                'field' => 'clevel[]',
                'label' => 'Confidence Level',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $edir = $this->input->post('edir', TRUE);
            $comp = $this->input->post('comp', TRUE);
            $grac = $this->input->post('grac', TRUE);
            $compro = $this->input->post('compro', TRUE);
            $flu = $this->input->post('flu', TRUE);
            $mtol = $this->input->post('mtol', TRUE);
            $voca = $this->input->post('voca', TRUE);
            $greet = $this->input->post('greet', TRUE);
            $blang = $this->input->post('blang', TRUE);
            $clevel = $this->input->post('clevel', TRUE);
            $course = $this->input->post('course', TRUE);
            $status = $this->input->post('status', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $idate = $this->input->post('idate', TRUE);
             $inter_name = $this->input->post('inter_name', TRUE);
            $fee = $this->input->post('fee', TRUE);


            $sql = $this->db->insert(
                    'interview', [
                'edir' => $edir,
                'comp' => implode(",", $comp),
                'grac' => implode(",", $grac),
                'compro' => implode(",", $compro),
                'flu' => implode(",", $flu),
                'mtol' => implode(",", $mtol),
                'voca' => implode(",", $voca),
                'greet' => implode(",", $greet),
                'blang' => implode(",", $blang),
                'clevel' => implode(",", $clevel),
                'regno' => $id,
                'comments' => $comments,
                'date' => $idate,
                'status' => $status,
                'inter_name' => $inter_name,
                'fee' => $fee
                    ]
            );
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'student', [
                'course' => $course
            ]);
            $this->db->where('regno', $id);
            $sql = $this->db->update(
                    'admission_info', [
                'course' => $course
            ]);
            if ($sql) {
                set_flash_alert('Interview Done successfully', 'success');
                redirect('interviewer/view_final/' . $id);
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function update_final($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'edir',
                'label' => 'EDIR Number',
                'rules' => 'required'
            ],
            [
                'field' => 'comp[]',
                'label' => 'Comprehension',
                'rules' => 'required'
            ],
            [
                'field' => 'grac[]',
                'label' => 'Grammar Accuracy',
                'rules' => 'required'
            ],
            [
                'field' => 'compro[]',
                'label' => 'Comprehensibility & Pronunciation',
                'rules' => 'required'
            ],
            [
                'field' => 'flu[]',
                'label' => 'Fluency',
                'rules' => 'required'
            ],
            [
                'field' => 'mtol[]',
                'label' => 'Maturity Of Language',
                'rules' => 'required'
            ],
            [
                'field' => 'voca[]',
                'label' => 'Vocabulary',
                'rules' => 'required'
            ],
            [
                'field' => 'greet[]',
                'label' => 'Greetings/ Farewell',
                'rules' => 'required'
            ],
            [
                'field' => 'blang[]',
                'label' => 'Body Language',
                'rules' => 'required'
            ],
            [
                'field' => 'clevel[]',
                'label' => 'Confidence Level',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {


            $edir = $this->input->post('edir', TRUE);
            $comp = $this->input->post('comp', TRUE);
            $grac = $this->input->post('grac', TRUE);
            $compro = $this->input->post('compro', TRUE);
            $flu = $this->input->post('flu', TRUE);
            $mtol = $this->input->post('mtol', TRUE);
            $voca = $this->input->post('voca', TRUE);
            $greet = $this->input->post('greet', TRUE);
            $blang = $this->input->post('blang', TRUE);
            $clevel = $this->input->post('clevel', TRUE);
            $course = $this->input->post('course', TRUE);
            $status = $this->input->post('status', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $idate = $this->input->post('idate', TRUE);
             $inter_name = $this->input->post('inter_name', TRUE);
            $fee = $this->input->post('fee', TRUE);

            $this->db->where(array('regno' => $id, 'status' => 2));
            $sql = $this->db->update(
                    'interview', [
                'edir' => $edir,
                'comp' => implode(",", $comp),
                'grac' => implode(",", $grac),
                'compro' => implode(",", $compro),
                'flu' => implode(",", $flu),
                'mtol' => implode(",", $mtol),
                'voca' => implode(",", $voca),
                'greet' => implode(",", $greet),
                'blang' => implode(",", $blang),
                'clevel' => implode(",", $clevel),
                'comments' => $comments,
                'date' => $idate,
                'status' => $status,
                'inter_name' => $inter_name,
                'fee' => $fee
                    ]
            );
            $this->db->where('reg_no', $id);
            $sql = $this->db->update(
                    'student', [
                'course' => $course
            ]);
            $this->db->where('regno', $id);
            $sql = $this->db->update(
                    'admission_info', [
                'course' => $course
            ]);
            if ($sql) {
                set_flash_alert('Interview Details Updated successfully', 'success');
                redirect('interviewer/view_final/' . $id);
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public static function inter_status() {
        return [
            '' => 'Please Select Status',
            '2' => 'Class Change Interview',
            '3' => 'Final Interview',
        ];
    }
    
      public function status()
  {
    return [
      ''  => '',
      '1' => 'Confirmed',
      '0' => 'Pending',
      '2' => 'Struck Off',
      '3' => 'Freeze',
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

}
