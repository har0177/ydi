<?php

class Register_model extends CI_Model {

    public function fee() {
        $q = $this->db->query('Select SUM(fee) as total from admission_info where fee_status = 1');
        return $q->result();
    }

    public function interview() {
        $q = $this->db->query('Select SUM(interview) as total from admission_info where interview_status = 1');
        return $q->result();
    }

    public function other() {
        $q = $this->db->query('Select SUM(other) as total from admission_info where other_status = 1');
        return $q->result();
    }

    function getReport() {
        $month = $this->input->post('month');
        $status = $this->input->post('status');
        $course = $this->input->post('course');

        if (!empty($month) || !empty($status) || !empty($course)) {
            $q = $this->db->query('Select * from fee where status =' . $status . ' and month =' . $month . ' and year =' . date('Y') . ' and course=' . $course);
            if ($q->num_rows() > 0) {
                return $q->result();
            } else {
                set_flash_alert("No data Found!", 'danger');
            }
        }
    }

    public function all() {
		    $this->db->where('std_status',1);
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('admission_info');
        return $q->result();
    }

    public function find($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('admission_info');
        return $q->result();
    }

  public function findByReg($id) {
    $this->db->where('regno', $id);
    $q = $this->db->get('admission_info');
    return $q->result();
  }

    public function paid_interview($id) {

        $this->db->where('id', $id);
        $result = $this->db->query("select * from admission_info where id = $id")->result_array();

        $status = $result[0]['interview_status'];
        if ($status == 0) {
            $sql = $this->db->update(
                    'admission_info', [
                'interview_status' => 1
                    ]
            );
            if ($sql) {
                set_flash_alert('Interview Fee has been Paid successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        } else {
            $sql = $this->db->update(
                    'admission_info', [
                'interview_status' => 0
                    ]
            );
            if ($sql) {
                set_flash_alert('Interview Fee has been UnPaid successfully', 'danger');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }


        return FALSE;
    }

    public function paid_fee($id) {

        $this->db->where('id', $id);
        $result = $this->db->query("select * from admission_info where id = $id")->result_array();

        $status = $result[0]['fee_status'];
        if ($status == 0) {
            $sql = $this->db->update(
                    'admission_info', [
                'fee_status' => 1
                    ]
            );
            if ($sql) {
                set_flash_alert('Registeration Fee has been Paid successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        } else {
            $sql = $this->db->update(
                    'admission_info', [
                'fee_status' => 0
                    ]
            );
            if ($sql) {
                set_flash_alert('Registeration Fee has been UnPaid successfully', 'danger');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }


        return FALSE;
    }

    public function paid_other($id) {

        $this->db->where('id', $id);
        $result = $this->db->query("select * from admission_info where id = $id")->result_array();

        $status = $result[0]['other_status'];
        if ($status == 0) {
            $sql = $this->db->update(
                    'admission_info', [
                'other_status' => 1
                    ]
            );
            if ($sql) {
                set_flash_alert('Other Fee has been Paid successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        } else {
            $sql = $this->db->update(
                    'admission_info', [
                'other_status' => 0
                    ]
            );
            if ($sql) {
                set_flash_alert('Other Fee has been UnPaid successfully', 'danger');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }


        return FALSE;
    }

    public function status_change($id) {

        $this->db->where('id', $id);
        $result = $this->db->query("select * from admission_info where id = $id")->result_array();
$regno = $result[0]['regno'];
        $status = $result[0]['std_status'];
        if ($status == 0 || $status == 2) {
              $this->db->where('id', $id);
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
                set_flash_alert('Student Status has been Active successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        } else {
            $this->db->where('id', $id);
            $sql = $this->db->update(
                    'admission_info', [
                'std_status' => 0
                    ]
            );
            $this->db->where('reg_no', $regno);
            $sql = $this->db->update(
                    'student', [
                'status' => 0
                    ]
            );
            if ($sql) {
                set_flash_alert('Student Status has been Decactive successfully', 'danger');
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
        $rules = [
            
            [
                'field' => 'fee',
                'label' => 'Registeration Fee',
                'rules' => 'required'
            ],
            [
                'field' => 'interview',
                'label' => 'Interview Fee',
                'rules' => 'required'
            ],
            [
                'field' => 'monthly',
                'label' => 'Monthly Fee',
                'rules' => 'required'
            ],
            [
                'field' => 'other',
                'label' => 'Other Fee',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

            $fee = $this->input->post('fee', TRUE);
            $interview = $this->input->post('interview', TRUE);
            $monthly = $this->input->post('monthly', TRUE);
            $other = $this->input->post('other', TRUE);
            $comment = $this->input->post('comments', TRUE);
            $rec = $this->input->post('rec', TRUE);

            $this->db->where('id', $id);
            // Insert user into DB
            $sql = $this->db->update(
                    'admission_info', [
                'fee' => $fee,
                'interview' => $interview,
                'monthly' => $monthly,
                'other' => $other,
                'comments' => $comment,
                         'rec_no' => $rec,
                    ]
            );

            if ($sql) {
                set_flash_alert('Student Fee updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }

        return FALSE;
    }

}
