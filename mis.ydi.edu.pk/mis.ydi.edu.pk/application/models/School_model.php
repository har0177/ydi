<?php

class School_model
        extends CI_Model {

    public function all_course() {
        $query = $this->db->get('courses');
        return $query->result();
    }

    public function check_batch($batch) {
        $array = array('batch_name' => $batch);

        $this->db->where($array);
        $q = $this->db->get('batch');
        if ($q->num_rows() > 0) {
            set_flash_alert("This Batch Name is already Registered", 'danger');
            redirect("admin/school/all_batch");
        }
    }

    public function add_course() {
        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'course',
                'label' => 'course',
                'rules' => 'required'
            ],
            [
                'field' => 'batch[]',
                'label' => 'Batch',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $course = $this->input->post('course', TRUE);
            $batch = $this->input->post('batch', TRUE);



            foreach ($batch as
                    $value) {

                for ($i = 0;
                        $i < count($value);
                        $i++) {
                    $array = array('batch' => $value);
                    $this->db->where($array);
                    $q = $this->db->get('courses');
                    if ($q->num_rows() > 0) {
                        set_flash_alert("This Batch is already Assign", 'danger');
                        redirect("admin/school/all_course");
                    }
                    $data[] = array(
                        'course_name' => $course,
                        'batch' => $value
                    );
                }
            }
            // Insert user into DB
            $sql = $this->db->insert_batch('courses', $data);
            if ($sql) {
                set_flash_alert('Course created successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function edit_course($id) {
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'course',
                'label' => 'course',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $course = $this->input->post('course', TRUE);
$status = $this->input->post('status', TRUE);

            // Data for db
            $update['course_name'] = $course;
            $update['status'] = $status;
            // Update user into DB
            $this->db->where('course_id', $id);
            $sql = $this->db->update('courses', $update);
            if ($sql) {
                set_flash_alert('Course updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function find_course($id) {
        $this->db->where('course_id', $id);
        $query = $this->db->get('courses');
        return $query->result();
    }

    public function delete_course($id) {
        $query = $this->db->delete('courses', ['course_id' => $id]);
        if ($query) {
            set_flash_alert('Course deleted', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    public function all_batch() {
        $query = $this->db->get('batch');
        return $query->result();
    }

    public function add_batch() {
        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'batch',
                'label' => 'batch',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $batch = $this->input->post('batch', TRUE);
            $this->check_batch($batch);
            $sql = $this->db->insert('batch', [
                'batch_name' => $batch
                    ]
            );

            if ($sql) {
                set_flash_alert('Batch created successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function edit_batch($id) {
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'batch',
                'label' => 'batch',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $batch = $this->input->post('batch', TRUE);

            // Data for db
            $update['batch_name'] = $batch;
            $array = array('batch_name' => $batch, 'batch_id!= ' => $id);
            $this->db->where($array);
            $q = $this->db->get('batch');
            if ($q->num_rows() > 0) {
                set_flash_alert("This Batch is already Registered", "danger");
            } else {

                // Update user into DB
                $this->db->where('batch_id', $id);
                $sql = $this->db->update('batch', $update);

                if ($sql) {
                    set_flash_alert('Batch updated successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            }
        }
        return FALSE;
    }

    public function find_batch($id) {
        $this->db->where('batch_id', $id);
        $query = $this->db->get('batch');
        return $query->result();
    }

    public function delete_batch($id) {
        $query = $this->db->delete('batch', ['batch_id' => $id]);
        if ($query) {
            set_flash_alert('Batch deleted', 'success');
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

    public function all_sms() {
        $this->db->where(array('from_user' => $this->session->user_id));

        $query = $this->db->get('sms_temp');
        return $query->result();
    }

    public function add_sms() {
        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'message',
                'label' => 'sms',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $sms = $this->input->post('message', TRUE);
            $sql = $this->db->insert('sms_temp', [
                'sms' => $sms,
                'from_user' => $this->session->user_id,
                    ]
            );

            if ($sql) {
                set_flash_alert('SMS created successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function edit_sms($id) {
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'message',
                'label' => 'sms',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $sms = $this->input->post('message', TRUE);

            // Data for db
            $update['sms'] = $sms;
            $array = array('id' => $id);
            $this->db->where($array);
            $q = $this->db->get('sms_temp');


            // Update user into DB
            $this->db->where('id', $id);
            $sql = $this->db->update('sms_temp', $update);

            if ($sql) {
                set_flash_alert('SMS updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function find_sms($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sms_temp');
        return $query->result();
    }

    public function delete_sms($id) {
        $query = $this->db->delete('sms_temp', ['id' => $id]);
        if ($query) {
            set_flash_alert('SMS deleted', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

}
