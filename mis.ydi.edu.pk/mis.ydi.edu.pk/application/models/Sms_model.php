<?php

class Sms_model
        extends CI_Model {

    public function singlesms() {
        $return[' '] = "Select Mobile Number";
        $this->db->where('status', '1');
        $query = $this->db->get('student');
        foreach ($query->result_array() as
                $row) {
            if (empty($row['contact'])) {
                continue;
            }
            $return[$row['contact']] = $row['contact'];
        }
        return $return;
    }

    public function create() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'sender',
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

            $mobile = $this->input->post('sender', TRUE);
            $message = $this->input->post('message', TRUE);

            AdminLTE::sms($mobile, $message);
            $this->db->insert('logs', [
                'contact' => $mobile,
                'msg' => $message,
                'date' => date("Y-m-d H:i:s"),
                'from_user' => $this->session->user_id,
            ]);
        }
        return FALSE;
    }

    public function single() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'mobile',
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

            $mobile = $this->input->post('mobile', TRUE);
            $message = $this->input->post('message', TRUE);

            AdminLTE::sms($mobile, $message);
            $this->db->insert('logs', [
                'contact' => $mobile,
                'msg' => $message,
                'date' => date("Y-m-d H:i:s"),
                'from_user' => $this->session->user_id,
            ]);
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
    
    
    
        public function bulk_manual() {

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

AdminLTE::sms_bulk($sender, $message);
 $this->db->insert('logs', [
                'contact' => $sender,
                'msg' => $message,
                'date' => date("Y-m-d H:i:s"),
                'from_user' => $this->session->user_id,
            ]);

        }
        return FALSE;
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
            $array = array('status' => 1);
            $this->db->where($array);
            $query = $this->db->get('student');
            foreach ($query->result_array() as
                    $row) {

                $id = $row['reg_no'];
                $value = $row['contact'];
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

    public function coursewise() {

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
            $course = $this->input->post('course', TRUE);

            $id[] = array();
            $array = array('status' => 1, 'course' => $course);
            $this->db->where($array);
            $query = $this->db->get('student');
            foreach ($query->result_array() as
                    $row) {
                $id = $row['reg_no'];
                $value = $row['contact'];
                if (empty($value) || $value == 0) {
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

}
