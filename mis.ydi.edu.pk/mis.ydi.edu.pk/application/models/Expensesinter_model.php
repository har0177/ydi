<?php

class Expensesinter_model extends CI_Model {

    public function all() {
        $q = $this->db->get('expensesinter');
        return $q->result();
    }

    public function find($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('expensesinter');
        return $q->result();
    }

    public function create() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
                [
                'field' => 'comments',
                'label' => 'Comments',
                'rules' => 'required'
            ],
             [
                'field' => 'rec',
                'label' => 'Receipt No',
                'rules' => 'required'
            ],
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {

                   $rec = $this->input->post('rec', TRUE);
            $daily = $this->input->post('daily', TRUE);
            $comments = $this->input->post('comments', TRUE);
            
               $date = $this->input->post('date', TRUE);
            // Insert user into DB
            $sql = $this->db->insert(
                    'expensesinter', [
                       'rec_no' => $rec,
                'daily' => $daily,
                        'comments' => $comments,
                        'date' => $date
                    
                    ]
            );
            if ($sql) {
                set_flash_alert('Expenses created successfully', 'success');
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
                'field' => 'comments',
                'label' => 'Comments',
                'rules' => 'required'
            ],
             [
                'field' => 'rec',
                'label' => 'Receipt No',
                'rules' => 'required'
            ],
                
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
                 $rec = $this->input->post('rec', TRUE);
            $daily = $this->input->post('daily', TRUE);
            $comments = $this->input->post('comments', TRUE);
               $date = $this->input->post('date', TRUE);
            // Insert user into DB
            $this->db->where('id', $id);
           
                $sql = $this->db->update(
                        'expensesinter', [
                             'rec_no' => $rec,
                'daily' => $daily,
                        'comments' => $comments,
                            'date' => $date
                        ]
                );
                if ($sql) {
                    set_flash_alert('Expenses Updated successfully', 'success');
                    return TRUE;
                } else {
                    set_flash_alert(implode(': ', $this->db->error()));
                }
            
        }
        return FALSE;
    }

    public function delete($id) {
        

        $query = $this->db->delete('expensesinter', ['id' => $id]);
        
        if ($query) {
            set_flash_alert('Expenses deleted', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

     
    
 

}
