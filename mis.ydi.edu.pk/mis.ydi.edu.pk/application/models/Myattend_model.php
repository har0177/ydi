<?php

class Myattend_model
        extends CI_Model {

    public function all() {
        $this->db->order_by('course', 'ASC');
        $this->db->where(array('status' => 1));
        $q = $this->db->get('student');
        return $q->result();
    }

    public function course_data($id) {
        $this->db->order_by('reg_no', 'ASC');
        $this->db->where(array('course' => $id, 'status' => 1));
        $q = $this->db->get('student');
        return $q->result();
    }

    public function find($id) {
        $this->db->where(array('reg_no' => $id, 'status' => 1));
        $q = $this->db->get('student');
        return $q->result();
    }

    public function check_attend($date, $course) {
        $array = array('course_id' => $course, 'date' => $date);
        $this->db->where($array);
        $q = $this->db->get('attend');
        if ($q->num_rows() > 0) {
            set_flash_alert('Attendance of this Course and Date Already Added', 'danger');
            redirect('admin/attendance/search');
        }
    }

    public function check_attend_view($date, $course) {
        $this->check_course($course);
        $array = array('course_id' => $course, 'date' => $date);
        $this->db->where($array);
        $q = $this->db->get('attend');
        if ($q->num_rows() < 1) {
            set_flash_alert('Attendance of this Course and Date Not Found!', 'danger');
            redirect('admin/attendance');
        }
    }

    public function check_attend_weekly($from, $to, $course) {
        $this->check_course($course);
        $q = $this->db->query('Select count(DISTINCT(std_id)) as std, count(status) as status, DAYNAME(date) as name, date from attend where course_id = "' . $course . '" AND DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" group by date');
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            set_flash_alert('Attendance of this Course and Date Not Found!', 'danger');
            redirect('admin/attendance/search_week');
        }
    }

    public function attendance_checking($course) {
        $this->check_course($course);
        $q = $this->db->query('Select count(std_id) as std, count(status) as status, DAYNAME(date) as date from attend where course_id = "' . $course . '" ');
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            set_flash_alert('Attendance of this Course Not Found!', 'danger');
            redirect('admin/attendance');
        }
    }

    public function check_course($course) {
        $array = array('course' => $course, 'status' => 1);
        $this->db->where($array);
        $q = $this->db->get('student');
        if ($q->num_rows() < 1) {
            set_flash_alert('No Student is enrolled in this Course', 'danger');
            redirect('admin/attendance');
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
            redirect('admin/attendance');
        }
    }

    public function create() {
        $course = $this->input->post('course', TRUE);
        $date = $this->input->post('date', TRUE);
        $attend = $this->input->post('attend', TRUE);
        $id = $this->input->post('id', TRUE);
        $data = array();
		 $this->attend->check_course($course);
        $this->attend->check_attend($date, $course);
     
        $absent_students = array();
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
                    //AdminLTE::sms($to, $msg);
                     $this->db->insert('logs', [
                'contact' => $to,
                'msg' => $msg,
                'date' => date("Y-m-d H:i:s"),
                'from_user' => $this->session->user_id,
            ]);
                }else if ($absent >= 3) {
                    // Check if student was admitted within the last 7 days (grace period)
                    $admission_date = AdminLTE::student_data($userid, "do_admission");
                    $days_since_admission = (strtotime(date('Y-m-d')) - strtotime($admission_date)) / 86400;

                    if ($days_since_admission >= 7) {
                        // Only strike off if admitted more than 7 days ago
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
                        //AdminLTE::sms($to, $msg);
                         $this->db->insert('logs', [
                    'contact' => $to,
                    'msg' => $msg,
                    'date' => date("Y-m-d H:i:s"),
                    'from_user' => $this->session->user_id,
                ]);
                    }
                }
            }
            if ($sql) {
                if (!empty($absent_students)) {
                    set_flash_alert('Attendance Sheet created successfully. These students are struckoff due to 3 days continuous absenteeism ' . json_encode($absent_students), 'success');
                } else {
                    set_flash_alert('Attendance Sheet created successfully.', 'success');
                }

                redirect('admin/attendance/view_attendance/' . $course . '/' . $date);
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
    }

    public function update($course, $date) {
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
                redirect('admin/attendance/view_attendance/' . $course . '/' . $date);
                return TRUE;
            } else {
                set_flash_alert(implode(': ', $this->db->error()));
            }
        }
    }

    public function delete($id) {
        $query = $this->db->delete('attend', ['id' => $id]);
        if ($query) {
            set_flash_alert('Attendance deleted', 'danger');
        } else {
            set_flash_alert(implode(': ', $this->db->error()));
        }
    }

    /**
     * Get all attendance records for a student (works for struck-off students too)
     */
    public function getAttendanceByStudent($reg_no) {
        $this->db->select('attend.*, courses.course_name, courses.batch');
        $this->db->from('attend');
        $this->db->join('courses', 'courses.course_id = attend.course_id', 'left');
        $this->db->where('attend.std_id', $reg_no);
        $this->db->order_by('attend.date', 'DESC');
        $q = $this->db->get();
        return $q->result();
    }

}
