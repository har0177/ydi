<?php

class Bank_model
        extends CI_Model {

    public function all() {
        $this->db->order_by("id", "DESC");
        $q = $this->db->get('bank');
        return $q->result();
    }


    public function find($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('bank');
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
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
           
            $amount = $this->input->post('amount', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $date = $this->input->post('date', TRUE);


            // Insert user into DB
            $sql = $this->db->insert(
                    'bank', [
               
                'amount' => $amount,
                'comments' => $comments,
                'date' => $date
                    ]
            );
            if ($sql) {
                set_flash_alert('Bank Detail Added successfully', 'success');
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
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
         
            $amount = $this->input->post('amount', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $date = $this->input->post('date', TRUE);
            // Insert user into DB
            $this->db->where('id', $id);

            $sql = $this->db->update(
                    'bank', [
               
                'amount' => $amount,
                'comments' => $comments,
                'date' => $date
                    ]
            );
            if ($sql) {
                set_flash_alert('Bank Details Updated successfully', 'success');
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function delete($id) {


        $query = $this->db->delete('bank', ['id' => $id]);

        if ($query) {
            set_flash_alert('Bank Details Deleted', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

}
