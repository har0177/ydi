<?php

class Expenses_model
        extends CI_Model {

    public function all() {
        $this->db->where("YEAR(date)", date('Y'));
        $this->db->order_by("id", "DESC");
        $q = $this->db->get('expenses');
        return $q->result();
    }

    public function all_expname() {
        $q = $this->db->get('expense_names');
        return $q->result();
    }

    public function find($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('expenses');
        return $q->result();
    }

    public function find_name($id) {
        $this->db->where('id', $id);
        $q = $this->db->get('expense_names');
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
            $exp = $this->input->post('exp_name', TRUE);
            $amount = $this->input->post('amount', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $date = $this->input->post('date', TRUE);


            // Insert user into DB
            $sql = $this->db->insert(
                    'expenses', [
                'rec_no' => $rec,
                'amount' => $amount,
                'exp_id' => $exp,
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

    public function add_expname() {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'exp_name',
                'label' => 'Expense Name',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $exp = $this->input->post('exp_name', TRUE);

            // Insert user into DB
            $sql = $this->db->insert(
                    'expense_names', [
                'exp_name' => $exp
                    ]
            );
            if ($sql) {
                set_flash_alert('Expense Name created successfully', 'success');
                redirect("admin/expenses/add_expname");
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
        return FALSE;
    }

    public function edit_expname($id) {

        // Load form validation library
        $this->load->library('form_validation');
        // define rules
        $rules = [
            [
                'field' => 'exp_name',
                'label' => 'Expense Name',
                'rules' => 'required'
            ]
        ];

        // Set rules
        $this->form_validation->set_rules($rules);
        // Check form
        if ($this->form_validation->run() != FALSE) {
            $exp = $this->input->post('exp_name', TRUE);

            $this->db->where('id', $id);

            $sql = $this->db->update(
                    'expense_names', [
                'exp_name' => $exp,
                    ]
            );

            if ($sql) {
                set_flash_alert('Expense Name Updated successfully', 'success');
                redirect("admin/expenses/add_expname");
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
            $exp = $this->input->post('exp_name', TRUE);
            $amount = $this->input->post('amount', TRUE);
            $comments = $this->input->post('comments', TRUE);
            $date = $this->input->post('date', TRUE);
            // Insert user into DB
            $this->db->where('id', $id);

            $sql = $this->db->update(
                    'expenses', [
                'rec_no' => $rec,
                'amount' => $amount,
                'exp_id' => $exp,
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


        $query = $this->db->delete('expenses', ['id' => $id]);

        if ($query) {
            set_flash_alert('Expenses deleted', 'success');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

}
