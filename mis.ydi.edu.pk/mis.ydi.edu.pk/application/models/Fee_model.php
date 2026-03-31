<?php

class Fee_model
        extends CI_Model {

    public function paid() {
        $q = $this->db->query('Select count(status) as total from fee where status = 1 and year =' . date("Y"));
        return $q->result();
    }

    public function unpaid() {
        $q = $this->db->query('Select count(status) as total from fee where status = 0 and year =' . date("Y"));
        return $q->result();
    }

    public function amount() {
        $q = $this->db->query('Select SUM(paid) as total from fee where (status = 1 OR status = 3) and year =' . date("Y"));
        return $q->result();
    }

    public function dues() {
        $q = $this->db->query('Select SUM(dues) as total from fee where status = 0 and year =' . date("Y"));
        return $q->result();
    }

    public function amount_m() {
        $q = $this->db->query("Select SUM(paid) as total from fee where (status = 1 OR status = 3) and MONTH(date_of_payment) =" . date('m') . "");
        return $q->result();
    }

    public function dues_m() {
        $q = $this->db->query("Select SUM(dues) as total from fee where status = 0 and MONTH(date_of_payment) =" . date('m') . "");
        return $q->result();
    }

    public function par_paid() {
        $q = $this->db->query('Select SUM(paid) as total from fee where status = 3');
        return $q->result();
    }

    function getReport() {
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $status = $this->input->post('status');
        $course = $this->input->post('course');


        if (!empty($month) || !empty($status) || !empty($course)) {
            if ($course == "all") {
                $q = $this->db->query('Select * from fee where status =' . $status . ' and month =' . $month . ' and year =' . $year . ' order by course ASC');
                if ($q->num_rows() > 0) {
                    return $q->result();
                } else {
                    set_flash_alert("No data Found!", 'danger');
                }
            } else {
                $q = $this->db->query('Select * from fee where status =' . $status . ' and month =' . $month . ' and year =' . $year . ' and course=' . $course);
                if ($q->num_rows() > 0) {
                    return $q->result();
                } else {
                    set_flash_alert("No data Found!", 'danger');
                }
            }
        }
    }

    public function all() {
         $this->db->where('YEAR(date_of_payment)', date('Y'));
         $this->db->or_where('status', 0);
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('fee');
        return $q->result();
    }

    public function printall() {
        $q = $this->db->query('Select * from fee where status = 0 order by id DESC');
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            set_flash_alert('All Fee are Paid', 'danger');
            redirect('admin/fee');
        }
    }

    public function find($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('fee');
        return $q->result();
    }

  public function findByReg($id) {
    $this->db->where('reg_no', $id);
    $q = $this->db->get('fee');
    return $q->result();
  }

    public function check_course($course) {
        $array = array('course' => $course, 'status' => 1);
        $this->db->where($array);
        $q = $this->db->get('student');
        if ($q->num_rows() < 1) {
            set_flash_alert('No Student is enrolled in Course ' . AdminLTE::course_name($course), 'danger');
            redirect('admin/fee');
        }
    }

    public function check_std($std, $month, $year) {
        $array = array('reg_no' => $std, 'month' => $month, 'year' => $year);
        $this->db->where($array);
        $q = $this->db->get('fee');
        if ($q->num_rows() > 0) {
            set_flash_alert('Fee Already Added', 'danger');
            redirect('admin/fee');
        }
    }

//public function studentfee() {
//
//		// Load form validation library
//		$this->load->library('form_validation');
//		// define rules
//		$rules = [
//			 [
//				  'field' => 'month',
//				  'label' => 'Month',
//				  'rules' => 'required'
//			 ],
//			 [
//				  'field' => 'session',
//				  'label' => 'Session',
//				  'rules' => 'required'
//			 ],
//			 [
//				  'field' => 'reg_no',
//				  'label' => 'Student Registration Number',
//				  'rules' => 'required'
//			 ],
//			 [
//				  'field' => 'monthly',
//				  'label' => 'Monthly',
//				  'rules' => 'required'
//			 ],
//			 [
//				  'field' => 'submission',
//				  'label' => 'Date',
//				  'rules' => 'required'
//			 ],
//		];
//
//		// Set rules
//		$this->form_validation->set_rules($rules);
//		// Check form
//		if ($this->form_validation->run() != FALSE) {
//
//				$id = $this->input->post('reg_no', TRUE);
//				$course = AdminLTE::student_course($id);
//				$month = $this->input->post('month', TRUE);
//				$session = $this->input->post('session', TRUE);
//				$transport = $this->input->post('transport', TRUE);
//				$hostel = $this->input->post('hostel', TRUE);
//				$promotion = $this->input->post('promotion', TRUE);
//				$monthly = $monthly = AdminLTE::student_fee($id);
//				$other = $this->input->post('other', TRUE);
//
//				$exam = $this->input->post('exam', TRUE);
//
//				$date = $this->input->post('submission', TRUE);
//				$total = $transport + $promotion + $fine + $exam + $monthly + $other + $hostel;
//				$this->check_fee($month, $course, $session, $id);
//
//					 $sql = $this->db->insert(
//                'fee',
//                [
//						 'reg_no' => $id,
//						 'course' => $course,
//						 'session' => $session,
//						 'month' => $month,
//						 'transport' => $transport,
//						 'hostel' => $hostel,
//						 'exam' => $exam,
//						 'promotion' => $promotion,
//						 'monthly' => $monthly,
//						 'dues' => $other,
//						 'total' => $total,
//						 'status' => 0,
//						 'date_of_payment' => $date,
//					]
//                );
//			if ($sql) {
//				set_flash_alert('Fee created successfully', 'success');
//				return TRUE;
//			} else {
//				set_flash_alert(implode(': ', $this->db->error()));
//			}
//		}
//		return FALSE;
//	}

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
              'field' => 'year',
              'label' => 'Year',
              'rules' => 'required'
            ],
            [
                'field' => 'std',
                'label' => 'Student Registration No',
                'rules' => 'required'
            ],
            [
                'field' => 'submission',
                'label' => 'Date',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $std = $this->input->post('std', TRUE);
            $month = $this->input->post('month', TRUE);
            $year = $this->input->post('year', TRUE);

            $comments = $this->input->post('comments', TRUE);
            $others = $this->input->post('other', TRUE);
            $monthly = AdminLTE::student_fee($std);
            $other = AdminLTE::student_fee_dues($std);
            $date = $this->input->post('submission', TRUE);
            $total = $others + $monthly + $other;

            $qq = $this->db->query("Select * from fee where reg_no = '" . $std . "' and month = $month and year =" . $year. "");
            if ($qq->num_rows() > 0) {
                set_flash_alert('Fee Already Added of this Student', 'danger');
                redirect('admin/fee');
            } else {
                AdminLTE::student_fee_dues_update($std);
                AdminLTE::student_fee_dues_update_p($std);
                $sql = $this->db->insert(
                        'fee', [
                    'reg_no' => $std,
                    'course' => AdminLTE::table_data_onefield('student', 'course', array('reg_no' => $std)), 'month' => $month,
                    'year' => $year,
                    'monthly' => $monthly,
                    'comments' => $comments,
                    'others' => $others,
                    'dues' => $total,
                    'total' => $total,
                    'status' => 0,
                    'date_of_payment' => $date,
                    'rec_no' => random_string('alnum', 6),
                ]);

                if ($sql) {
                    set_flash_alert('Fee created successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            }
        }
        return FALSE;
    }

    public function create() {

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
                'field' => 'course',
                'label' => 'Course',
                'rules' => 'required'
            ],
            [
                'field' => 'submission',
                'label' => 'Date',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $data = array();
            $id[] = array();
            $course = $this->input->post('course', TRUE);


            $range = $this->input->post('range', TRUE);
            if ($range == "half") {
                $check_range = "DAY(do_admission) BETWEEN 1 AND 15";
            } else if ($range == "full") {
                $check_range = "DAY(do_admission) BETWEEN 16 AND 31";
            }

            if ($course == "all") {
                $query = $this->db->query("Select * from student where status = 1 and $check_range");
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as
                            $row) {
                        $id = $row['reg_no'];

                        $month = $this->input->post('month', TRUE);

                        $comments = $this->input->post('comments', TRUE);
                        $others = $this->input->post('other', TRUE);
                        $monthly = AdminLTE::student_fee($id);
                        $other = AdminLTE::student_fee_dues($id);
                        $date = $this->input->post('submission', TRUE);
                        $total = $others + $monthly + $other;

                            $qq = $this->db->query("Select * from fee where reg_no = '" . $id . "' and month = $month and year =" . date('Y') . "");


                            if ($qq->num_rows() > 0) {
                                continue;
                            }
                            if ($monthly == 0) {
                                continue;
                            }

                            AdminLTE::student_fee_dues_update($id);
                            AdminLTE::student_fee_dues_update_p($id);
                            $data[] = array(
                                'reg_no' => $id,
                                'course' => $row['course'],
                                'month' => $month,
                                'year' => date('Y'),
                                'monthly' => $monthly,
                                'comments' => $comments,
                                'others' => $others,
                                'dues' => $total,
                                'total' => $total,
                                'status' => 0,
                                'date_of_payment' => $date,
                                'rec_no' => random_string('alnum', 6),
                            );
                    }
                } else {
                    set_flash_alert('No Student is enrolled on These Days', 'danger');
                    redirect('admin/fee');
                }
                if (empty($data)) {
                    set_flash_alert('Fee Already Added', 'danger');
                    redirect("/admin/fee");
                }
                $sql = $this->db->insert_batch('fee', $data);
                if ($sql) {
                    set_flash_alert('Fee created successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            } else {
                $this->check_course($course);
                $query = $this->db->query("Select * from student where course = $course and status = 1 and $check_range");
                if ($query->num_rows() > 0) {
                    foreach ($query->result_array() as
                            $row) {
                        $id = $row['reg_no'];

                        $month = $this->input->post('month', TRUE);

                        $comments = $this->input->post('comments', TRUE);
                        $others = $this->input->post('other', TRUE);
                        $monthly = AdminLTE::student_fee($id);
                        $other = AdminLTE::student_fee_dues($id);
                        $date = $this->input->post('submission', TRUE);
                        $total = $others + $monthly + $other;

                            $qq = $this->db->query("Select * from fee where reg_no = '" . $id . "' and month = $month and year =" . date('Y') . " and course = $course");


                            if ($qq->num_rows() > 0) {
                                continue;
                            }

                            AdminLTE::student_fee_dues_update($id);
                            AdminLTE::student_fee_dues_update_p($id);
                            $data[] = array(
                                'reg_no' => $id,
                                'course' => $course,
                                'month' => $month,
                                'year' => date('Y'),
                                'monthly' => $monthly,
                                'comments' => $comments,
                                'others' => $others,
                                'dues' => $total,
                                'total' => $total,
                                'status' => 0,
                                'date_of_payment' => $date,
                                'rec_no' => random_string('alnum', 6),
                            );
                        }
                    }
                } else {
                    set_flash_alert('No Student is enrolled in Course ' . AdminLTE::course_name($course) . ' on These Days', 'danger');
                    redirect('admin/fee');
                }
                if (empty($data)) {
                    set_flash_alert('Fee Already Added', 'danger');
                    redirect("/admin/fee");
                }
                $sql = $this->db->insert_batch('fee', $data);
                if ($sql) {
                    set_flash_alert('Fee created successfully', 'success');
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
                'field' => 'month',
                'label' => 'Month',
                'rules' => 'required'
            ],
            [
              'field' => 'year',
              'label' => 'Year',
              'rules' => 'required'
            ],
            [
                'field' => 'course',
                'label' => 'Course',
                'rules' => 'required'
            ],
            [
                'field' => 'submission',
                'label' => 'Date',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $this->db->where('id', $id);
            $month = $this->input->post('month', TRUE);
          $year = $this->input->post('year', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $others = $this->input->post('other', TRUE);

            $monthly = $this->input->post('monthly', TRUE);
            $date = $this->input->post('submission', TRUE);
            $total = $others + $monthly;


            $sql = $this->db->update(
                    'fee', [
                'month' => $month,
                'year' => $year,
                'comments' => $comments,
                'others' => $others,
                'monthly' => $monthly,
                'dues' => $total,
                'total' => $total,
                'date_of_payment' => $date,
                    ]
            );
            if ($sql) {
                set_flash_alert('Fee Updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function update_fee($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'monthly',
                'label' => 'Monthly',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $this->db->where('id', $id);
            $result = $this->db->query("select * from fee where id = $id")->result_array();

            $total = $result[0]['total'];

            $monthly = $this->input->post('monthly', TRUE);
            $date = $this->input->post('submission', TRUE);
             $rec = $this->input->post('rec', TRUE);
            

            $t = $total - $monthly;

            $sql = $this->db->update(
                    'fee', [
                'dues' => $t,
                'status' => 3,
                'paid' => $monthly,
                        'date_of_payment' => $date,
                        'rec_no' => $rec
                    ]
            );
            if ($sql) {
                set_flash_alert('Fee Partially Paid successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function paid_fee($id) {
        // Load form validation library
        $this->load->library('form_validation');
        $rules = [
            [
                'field' => 'rec',
                'label' => 'Receipt No',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $rec = $this->input->post('rec', TRUE);
            $date = $this->input->post('submission', TRUE);
            
            
            $this->db->where('id', $id);
        $result = $this->db->query("select * from fee where id = $id")->result_array();

        $total = $result[0]['total'];
        $regno = $result[0]['reg_no'];
        if ($result[0]['status_1p'] === 0 || $result[0]['status_1p'] === '0') {
            $sql = $this->db->update(
                    'fee', [
                'status' => 1,
                'status_1p' => 1,
                'dues' => 0,
                'paid' => $total,
                        'rec_no' => $rec,
                'date_of_payment' => $date,
                    ]
            );
            $this->db->where('regno', $regno);
            $sql = $this->db->update(
                    'admission_info', [
                'std_status' => 1
                    ]
            );
            $this->db->where('reg_no', $regno);
            $sql = $this->db->update(
                    'student', [
                'status' => 1
                    ]
            );

            if ($sql) {
                set_flash_alert('1st Time Payment has been Paid  & Student has been Active successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        } else {
            $sql = $this->db->update(
                    'fee', [
                'status' => 1,
                'dues' => 0,
                'paid' => $total,
                        'rec_no' => $rec,
                'date_of_payment' => $date,
                    ]
            );
            if ($sql) {
                set_flash_alert('Fee has been Paid successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        }
        return FALSE;
    }

    
   

    public function delete($id) {
        $query = $this->db->delete('fee', ['id' => $id]);
        if ($query) {
            set_flash_alert('Fee deleted', 'danger');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function name() {
        $return[''] = '';
        $this->db->where('status', '1');
        $query = $this->db->get('employee');
        foreach ($query->result_array() as
                $row) {
            $return[$row['id']] = $row['name'];
        }
        return $return;
    }

    public function status() {
        return [
            '' => 'Select Status',
            '1' => 'Paid',
            '0' => 'Unpaid',
            '2' => 'Dues Added to New Month',
            '3' => 'Partially Paid',
        ];
    }

    public function sms() {

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
            $q = $this->db->query('Select * from fee where status = 0');
            if ($q->num_rows() > 0) {
                foreach ($q->result() as
                        $dta) {
                    $qq = $this->db->query('Select contact from student where reg_no = ' . $dta->reg_no);
                    foreach ($qq->result() as
                            $cont) {
                        $mobile = $cont->contact;
                        if (empty($mobile) || $mobile == 0) {
                            continue;
                        } else {
                            AdminLTE::sms($mobile, $message);
                            $this->db->insert('logs', [
                                'contact' => $mobile,
                                'msg' => $message,
                                'date' => date("Y-m-d H:i:s"),
                                'from_user' => $this->session->user_id,
                            ]);
                        }
                    }
                }
                set_flash_alert('SMS send Successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert('All Fee are Paid', 'danger');
                redirect('admin/fee');
            }
        }
        return FALSE;
    }

}
