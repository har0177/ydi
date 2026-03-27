<?php

class Students_model
  extends CI_Model
{
  public function all()
  {
    $status = $this->input->post('status');
    $course = $this->input->post('course');
    if (!empty($status) || !empty($course)) {
      if ($course === 'all') {
        $array = ['status' => $status];
      } else {
        $array = ['course' => $course, 'status' => $status];
      }
    } else {
                 // Get the current year and month
    $currentYear = date('Y');
    $currentMonth = date('m');
    
    // Add the where condition to filter by the current month
    $this->db->where('YEAR(do_admission)', $currentYear);
    $this->db->where('MONTH(do_admission)', $currentMonth);
      $array = ['status' => 1];
    }
    $this->db->where($array);
    $this->db->order_by('id', 'DESC');
    $q = $this->db->get('student');
    return $q->result();
  }

  public function idcards()
  {
    $array = ['status' => 1];
    $this->db->where($array);
    $this->db->order_by('id', 'DESC');
    $q = $this->db->get('student');
    return $q->result();
  }

  public function all_std_info()
  {
    $this->db->order_by('id', 'ASC');
    $q = $this->db->get('student');
    return $q->result();
  }

  public function printall()
  {
    $this->db->order_by('id', 'ASC');
    $q = $this->db->get('student');
    return $q->result();
  }

  public function find_student($id)
  {
    $this->db->where('reg_no', $id);
    $q = $this->db->get('student');
    return $q->result();
  }

  public function find_student_info($id)
  {
    $this->db->where('regno', $id);
    $q = $this->db->get('admission_info');
    return $q->result();
  }

  public function find_student_fee($id)
  {
    $array = ['status' => 0];
    $this->db->where($array);
    $this->db->where('reg_no', $id);
    $q = $this->db->get('fee');
    return $q->result();
  }

  public function find_slc($id)
  {
    $this->db->where('regno', $id);
    $q = $this->db->get('slc');
    return $q->result();
  }

  public function find_delete($id)
  {
    $this->db->where('reg_no', $id);
    $q = $this->db->get('student');
    return $q->result();
  }

  public function create()
  {

    // Load form validation library
    $this->load->library('form_validation');
    // define rules
    $rules = [
      [
        'field' => 'regno',
        'label' => 'Registeration Number',
        'rules' => 'required'
      ],
      [
        'field' => 'name',
        'label' => 'Student Name',
        'rules' => 'required'
      ],
      [
        'field' => 'admission',
        'label' => 'Date of Admission',
        'rules' => 'required'
      ],
    ];
    $this->form_validation->set_rules($rules);
    // Check form
    // Check form
    if ($this->form_validation->run() === false) {
      return false;
    }

    $regnoo = $this->input->post('regno', true);
    $regno = preg_replace('/[\W\s\/]+/', '-', $regnoo);
    $name = $this->input->post('name', true);
    $fname = $this->input->post('fname', true);
    $contact = $this->input->post('contact', true);
    $address = $this->input->post('address', true);
    $dob = $this->input->post('dob', true);
    $admission = $this->input->post('admission', true);
    $qualification = $this->input->post('qualification', true);
    $cnic = $this->input->post('cnic', true);
    $fee = $this->input->post('fee', true);
    $interview = $this->input->post('interview', true);
    $monthly = $this->input->post('monthly', true);
    $other = $this->input->post('other', true);
    $comment = $this->input->post('comments', true);
    $from = $this->input->post('from', true);
    $to = $this->input->post('to', true);
    $course = $this->input->post('course', true);
    $student = $this->input->post('student', true);
    $rec = $this->input->post('rec', true);
    $empl = $this->input->post('employee', true);
    $sendSms = $this->input->post('sms', true);
    $type = $this->input->post('type', true);
    if ($empl == "Employee") {
      $empl = $this->input->post('profession', true);
    } else {
      $empl = $this->input->post('employee', true);
    }
    if ($sendSms == "Yes") {
      $dateTime = strtotime($this->input->post('datetime', true));
      $message = "Dear " . $name . "!
             You are successfully registered in YDI " . $type . ". Kindly visit YDI on " . date('d-M-Y h:i:s A',
          $dateTime) . " for initial Evaluation interview.
Regards,
Faisal Nabi
YDI Evaluation Officer
Ph: 0946 725501";
      // Insert user into DB
      AdminLTE::sms($contact, $message);
      $this->db->insert('logs', [
        'contact' => $contact,
        'msg' => $message,
        'date' => date("Y-m-d H:i:s"),
        'from_user' => $this->session->user_id,
      ]);
    }
    $internet = $this->input->post('internet', true);
    $this->check_student($regno);
    // Handle image upload
    $image = null;
    if (!empty($_POST['image'])) {
      $cleanedString = $_POST['image'];

    // Decode the base64 string
    $image_base64 = base64_decode($cleanedString);

      $image = $regno . '.png';
      $file = "images/" . $image;
      file_put_contents($file, $image_base64);
    }

    // Insert user into DB
    $this->db->insert(
      'student', [
        'reg_no' => $regno,
        'name' => $name,
        'f_name' => $fname,
        'contact' => $contact,
        'cnic' => $cnic,
        'address' => $address,
        'dob' => $dob,
        'course' => $course,
        'qualification' => $qualification,
        'std_of' => $student,
        'from' => $from,
        'to' => $to,
        'employment' => $empl,
        'internet' => $internet,
        'do_admission' => $admission,
        'img' => $image,
        'status' => 0,
      ]
    );
    $sql = $this->db->insert(
      'admission_info', [
        'regno' => $regno,
        'course' => $course,
        'date' => $admission,
        'fee' => $fee,
        'interview' => $interview,
        'monthly' => $monthly,
        'other' => $other,
        'comments' => $comment,
        'rec_no' => $rec,
        'fee_status' => 1,
      ]
    );
    if ($monthly != 0) {
      $sql = $this->db->insert(
        'fee', [
        'reg_no' => $regno,
        'course' => $course,
        'year' => date('Y'),
        'monthly' => $monthly,
        'month' => date("m"),
        'dues' => $monthly,
        'total' => $monthly,
        'status' => 0,
        'status_1p' => 0,
        'date_of_payment' => date("Y-m-d"),
        'rec_no' => random_string('alnum', 6),
      ]);
    }
    if ($sql) {
      set_flash_alert('Student created successfully', 'success');
      return true;
    }
    set_flash_alert(implode(': ', $this->db->error()));

    return false;
  }

  public function check_student($id)
  {
    $array = ['reg_no' => $id];
    $this->db->where($array);
    $q = $this->db->get('student');
    if ($q->num_rows() > 0) {
      set_flash_alert("This Registration Number is already assign", 'danger');
      redirect('admin/students');
    }
  }

  public function update($id)
  {
      /*echo '<pre>';
print_r($_POST);
echo '</pre>';
     // die();*/
    // Load form validation library
    $this->load->library('form_validation');
    $rules = [
      [
        'field' => 'name',
        'label' => 'Student Name',
        'rules' => 'required'
      ],
      [
        'field' => 'course',
        'label' => 'Course & Batch',
        'rules' => 'required'
      ],
      [
        'field' => 'admission',
        'label' => 'Date of Admission',
        'rules' => 'required'
      ],
    ];
    $this->form_validation->set_rules($rules);
    // Check form

    if ($this->form_validation->run() === false) {
      return false;
    }
    $status = $this->input->post('status', true);
    $regno = $this->input->post('regno', true);
    $name = $this->input->post('name', true);
    $fname = $this->input->post('fname', true);
    $contact = $this->input->post('contact', true);
    $address = $this->input->post('address', true);
    $dob = $this->input->post('dob', true);
    $admission = $this->input->post('admission', true);
    $qualification = $this->input->post('qualification', true);
    $cnic = $this->input->post('cnic', true);
    $from = $this->input->post('from', true);
    $to = $this->input->post('to', true);
    $course = $this->input->post('course', true);
    $student = $this->input->post('student', true);
    $empl = $this->input->post('employee', true);
    if ($empl == "Employee") {
      $empl = $this->input->post('profession', true);
    } else {
      $empl = $this->input->post('employee', true);
    }
    $internet = $this->input->post('internet', true);
    $image = null;
    
    // Handle image upload
    if (!empty($_POST['image'])) {
       $cleanedString = $_POST['image'];

    // Decode the base64 string
    $image_base64 = base64_decode($cleanedString);

      $image = $regno . '.png';
      $file = "images/" . $image;
      file_put_contents($file, $image_base64);
    }

    $this->db->where('id', $id);
    // Insert user into DB
    $this->db->update(
      'student', [
        'name' => $name,
        'f_name' => $fname,
        'contact' => $contact,
        'cnic' => $cnic,
        'address' => $address,
        'dob' => $dob,
        'course' => $course,
        'qualification' => $qualification,
        'std_of' => $student,
        'from' => $from,
        'to' => $to,
        'employment' => $empl,
        'internet' => $internet,
        'do_admission' => $admission,
        'img' => $image,
        'status' => $status
      ]
    );
    $this->db->where('regno', $regno);
    $sql = $this->db->update(
      'admission_info', [
        'std_status' => $status,
        'course' => $course,
        'date' => $admission
      ]
    );
    if ($status == 2) {
      $sql = $this->db->delete('fee', ['reg_no' => $regno, 'status' => 0]);
    }
    if ($sql) {
      set_flash_alert('Student updated successfully', 'success');
      return true;
    }
    set_flash_alert(implode(': ', $this->db->error()));
    return false;
  }

  public function slc($id)
  {

    // Load form validation library
    $this->load->library('form_validation');
    // define rules
    $rules = [
      [
        'field' => 'remarks',
        'label' => 'Remarks',
        'rules' => 'required'
      ],
      [
        'field' => 'withdraw',
        'label' => 'Withdraw Date',
        'rules' => 'required'
      ]
    ];
    // Set rules
    $this->form_validation->set_rules($rules);
    // Check form
    if ($this->form_validation->run() != false) {

      $remarks = $this->input->post('remarks', true);
      $date = $this->input->post('withdraw', true);
      // Insert user into DB
      $sql = $this->db->insert(
        'slc', [
          'regno' => $id,
          'remarks' => $remarks,
          'date' => $date
        ]
      );
      $this->db->where('reg_no', $id);
      $sql = $this->db->update(
        'student', [
          'status' => 0
        ]
      );
      if ($sql) {
        set_flash_alert('Certificate Issued successfully', 'success');
        redirect('admin/students/print_slc/' . $id);
        return true;
      } else {
        set_flash_alert(implode(': ', $this->db->error()));
      }
    }
    return false;
  }

  public function delete($id)
  {
    if (!empty($id)) {
      $image = $this->find($id);
      $images = $image[0]->img;
      if (file_exists($images)) {
        $this->load->helper("file");
        unlink(base_url() . 'images/' . $images);
      }
      $query = $this->db->delete('fee', ['reg_no' => $id]);
      $query = $this->db->delete('admission_info', ['regno' => $id]);
      $query = $this->db->delete('interview', ['regno' => $id]);
      $query = $this->db->delete('student', ['reg_no' => $id]);
      if ($query) {
        set_flash_alert('Student deleted Successfully', 'success');
      } else {
        set_flash_alert(implode(': ', $this->db->error()));
      }
    } else {
      set_flash_alert('Student Record Not Found', 'danger');
    }
  }

  public function find($id)
  {
    $this->db->where('id', $id);
    $q = $this->db->get('student');
    return $q->result();
  }

  public function status()
  {
    return [
      '' => '',
      '1' => 'Confirmed',
      '0' => 'Pending',
      '2' => 'Struck Off',
      '3' => 'Freeze',
    ];
  }

  public function employee()
  {
    return [
      '' => '',
      'Employee' => 'Employee',
      'Not Employee' => 'Not Employee',
    ];
  }

  public function internet()
  {
    return [
      '' => '',
      '1' => 'Yes',
      '0' => 'No',
    ];
  }

  public function send_sms()
  {

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
    if ($this->form_validation->run() != false) {

      $sender = $this->input->post('sender', true);
      $msg = $this->input->post('message', true);
      // Insert user into DB
      AdminLTE::sms($sender, $msg);
      $this->db->insert('logs', [
        'contact' => $sender,
        'msg' => $msg,
        'date' => date("Y-m-d H:i:s"),
        'from_user' => $this->session->user_id,
      ]);
    }
    return false;
  }
}
