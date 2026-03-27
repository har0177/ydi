<?php

class AdminLTE {

    public static function table_data_onefield($table, $Onefield = Null, $arraywhere = NULL) {
        $CI = & get_instance();
        $CI->db->select($Onefield);
        $array = $arraywhere;
        $CI->db->where($array);
        $query = $CI->db->get($table);

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0][$Onefield];
        } else {
            return FALSE;
        }
    }

    public static function count_attend($field, $status, $id) {
        $CI = & get_instance();
        $query = $CI->db->query("SELECT count($field) as total from attend where status = $status and std_id = $id and date >= (CURDATE() - INTERVAL 2 DAY )order by date DESC");

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->total;
        } else {
            return FALSE;
        }
    }
    
    public static function count_lastweek($field, $status, $id) {
        $CI = & get_instance();
        $query = $CI->db->query("SELECT count($field) as total from attend where status = $status and std_id = $id and date >= (CURDATE() - INTERVAL 7 DAY )order by date DESC");

        if ($query->num_rows() > 0) {
            $result = $query->row();
            return $result->total;
        } else {
            return FALSE;
        }
    }

    public static function rank($id, $course) {
        $CI = & get_instance();

        $que = $CI->db->query("SELECT FIND_IN_SET(percentage, (
SELECT GROUP_CONCAT(DISTINCT percentage
ORDER BY percentage DESC )
FROM trainer_data where course = $course and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()))
) AS rank
FROM trainer_data where regno = $id and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE())");

        if ($que->num_rows() > 0) {
             $result = $que->result_array();
            return $result[0]["rank"];
        } else {
            $que = $CI->db->query("SELECT FIND_IN_SET(percentage, (
SELECT GROUP_CONCAT(DISTINCT percentage
ORDER BY percentage DESC )
FROM trainer_data where course = $course and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1)
) AS rank
FROM trainer_data where regno = $id and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1");

            $result = $que->result_array();
            return $result[0]["rank"];
        }
    }

    public static function rank_date($id, $course, $date) {
        $CI = & get_instance();

        $que = $CI->db->query("SELECT FIND_IN_SET(percentage, (
SELECT GROUP_CONCAT(DISTINCT percentage
ORDER BY percentage DESC )
FROM trainer_data where course = $course and WEEKOFYEAR(date)=WEEKOFYEAR('$date'))
) AS rank
FROM trainer_data where regno = $id and WEEKOFYEAR(date)=WEEKOFYEAR('$date')");

        if ($que->num_rows() > 0) {
            $result = $que->result_array();
            return $result[0]["rank"];
        } else {
            set_flash_alert("No data Found!", 'danger');
        }
    }

    public static function course_name($id) {
        $CI = & get_instance();
        $CI->db->select('course_name');
        $array = array('course_id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('courses');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['course_name'];
        } else {
            return FALSE;
        }
    }

    public static function exp_name($id) {
        $CI = & get_instance();
        $CI->db->select('exp_name');
        $array = array('id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('expense_names');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['exp_name'];
        } else {
            return FALSE;
        }
    }

    public static function batch_name($id) {
        $CI = & get_instance();
        $CI->db->select('batch_name');
        $array = array('batch_id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('batch');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['batch_name'];
        } else {
            return FALSE;
        }
    }

    public static function fetch($id) {
        $CI = & get_instance();
        $q = $CI->db->get($id);
        return $q->result();
    }

    public static function student_data($id, $check) {
        $CI = & get_instance();
        $CI->db->select($check);
        $array = array('reg_no' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('student');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0][$check];
        } else {
            return FALSE;
        }
    }
    public static function inter_data($id, $check) {
        $CI = & get_instance();
        $CI->db->select($check);
        $array = array('regno' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('interview');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0][$check];
        } else {
            return FALSE;
        }
    }
    
     public static function weekly_data($id, $check) {
        $CI = & get_instance();
        $CI->db->select($check);
        $array = array('regno' => $id);
        $CI->db->where($array);
          $CI->db->order_by("id", "DESC");
        $CI->db->limit(1);
        $query = $CI->db->get('trainer_data');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0][$check];
        } else {
            return FALSE;
        }
    }

    public static function get_placing_string($placing) {
        $i = intval($placing % 10);
        $place = substr($placing, -2); //For 11,12,13 places

        if ($i == 1 && $place != '11') {
            return $placing . 'st';
        } else if ($i == 2 && $place != '12') {
            return $placing . 'nd';
        } else if ($i == 3 && $place != '13') {
            return $placing . 'rd';
        }
        return $placing . 'th';
    }

    public static function employee_name($id) {
        $CI = & get_instance();
        $CI->db->select('name');
        $array = array('status' => 1, 'id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('employee');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['name'];
        } else {
            return FALSE;
        }
    }

    public static function withdraw_info($cur = "") {
        $CI = & get_instance();
        $array = array('regno' => $cur);
        $CI->db->where($array);
        $q = $CI->db->get('slc');
        $r = $q->result();
        return $r;
    }

    public static function admission_info($cur = "") {
        $CI = & get_instance();
        $array = array('regno' => $cur);
        $CI->db->where($array);
        $q = $CI->db->get('admission_info');
        $r = $q->result();
        return $r;
    }

    public static function interview_info($cur = "") {
        $CI = & get_instance();
        $array = array('regno' => $cur);
        $CI->db->where($array);
        $q = $CI->db->get('interview');
        $r = $q->result();
        return $r;
    }
    
    public static function data_info($cur = "") {
        $CI = & get_instance();
        $array = array('course' => $cur);
        $CI->db->where($array);
        $q = $CI->db->get('data');
        $r = $q->result();
        return $r;
    }
    
    public static function record_count_int($id) {
            $CI = & get_instance();
		$array = array('course' => $id);
		$CI->db->where($array);
		return $CI->db->count_all("data");
	}
        
         public static function record_count_week($id) {
            $CI = & get_instance();
		$array = array('regno' => $id);
		$CI->db->where($array);
		return $CI->db->count_all("trainer_data");
	}
    
        
        public static function fetch_data($limit, $start, $id) {
            $CI = & get_instance();
		$CI->db->limit($limit, $start);
		$array = array('course' => $id);
		$CI->db->where($array);
		$CI->db->order_by('id', 'Desc');
		$query = $CI->db->get("data");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
                }
		
	}
        
        public static function fetch_data_weekly($limit, $start, $id) {
            $CI = & get_instance();
		$CI->db->limit($limit, $start);
		$array = array('regno' => $id);
		$CI->db->where($array);
		$CI->db->order_by('id', 'Desc');
		$query = $CI->db->get("trainer_data");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
                }
		
	}
        
      public static function naway_info($cur = "") {
        $CI = & get_instance();
        $array = array('regno' => $cur);
        $CI->db->where($array);
        $q = $CI->db->get('naway');
        $r = $q->result();
        return $r;
    }

    public static function report_info($cur = "") {
        $CI = & get_instance();
        $q = $CI->db->query("SELECT * from trainer_data where regno = $cur order by id DESC");
        $r = $q->result();
        return $r;
    }

    public static function employee_data($id, $field) {
        $CI = & get_instance();
        $CI->db->select($field);
        $array = array('id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('employee');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0][$field];
        } else {
            return FALSE;
        }
    }

    public static function employee_qua($id) {
        $CI = & get_instance();
        $CI->db->select('qualification');
        $array = array('status' => 1, 'id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('employee');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['qualification'];
        } else {
            return FALSE;
        }
    }

    public static function employee_image($id) {
        $CI = & get_instance();
        $CI->db->select('img');
        $array = array('status' => 1, 'id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('employee');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['img'];
        } else {
            return FALSE;
        }
    }

    public static function student_image($id, $field) {
        $CI = & get_instance();
        $CI->db->select($field);
        $array = array('status' => 1, 'reg_no' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('student');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0][$field];
        } else {
            return FALSE;
        }
    }

    public static function student_name($id) {
        $CI = & get_instance();
        $CI->db->select('name');
        $array = array('reg_no' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('student');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['name'];
        } else {
            return FALSE;
        }
    }

    public static function student_fname($id) {
        $CI = & get_instance();
        $CI->db->select('f_name');
        $array = array('reg_no' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('student');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['f_name'];
        } else {
            return FALSE;
        }
    }

    public static function student_course($id) {
        $CI = & get_instance();
        $CI->db->select('*');
        $array = array('course_id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('courses');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['course_name'] . " " . AdminLTE::batch_name($result[0]['batch']);
        } else {
            return FALSE;
        }
    }

    public static function student_batch($id) {
        $CI = & get_instance();
        $CI->db->select('*');
        $array = array('batch_id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('batch');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['batch_name'];
        } else {
            return FALSE;
        }
    }

    public static function student_fee($id) {
        $CI = & get_instance();
        $CI->db->select('monthly');
        $array = array('std_status' => 1, 'regno' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('admission_info');

        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['monthly'];
        } else {
            return FALSE;
        }
    }

    public static function tuition_fee_record($id, $month, $field) {
        $CI = & get_instance();
        $CI->db->select($field);
        $array = array('reg_no' => $id, 'month' => $month, 'year' => date('Y'));
        $CI->db->where($array);
        $query = $CI->db->get('fee');

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0][$field];
        } else {
            return FALSE;
        }
    }

    public static function student_fee_dues($id) {
        $CI = & get_instance();
        $CI->db->select('dues');
        $array = array('reg_no' => $id);
        $CI->db->where($array);
        $CI->db->order_by('id', 'Desc');
        $CI->db->limit(1);
        $query = $CI->db->get('fee');
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['dues'];
        } else {
            return FALSE;
        }
    }

    public static function student_fee_data($id, $field) {
        $CI = & get_instance();
        $CI->db->select($field);
        $array = array('status' => 0, 'reg_no' => $id);
        $CI->db->where($array);
        $CI->db->order_by('id', 'Desc');
        $CI->db->limit(1);
        $query = $CI->db->get('fee');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0][$field];
        } else {
            return FALSE;
        }
    }

    public static function salary_dues($id) {
        $CI = & get_instance();
        $CI->db->select('amount');
        $array = array('status' => 0, 'emp_id' => $id);
        $CI->db->where($array);
        $CI->db->order_by('id', 'Desc');
        $CI->db->limit(1);
        $query = $CI->db->get('salary');
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['amount'];
        } else {
            return FALSE;
        }
    }

    public static function student_fee_dues_update($id) {
        $CI = & get_instance();
        $CI->db->select('id');
        $array = array('status' => 0, 'reg_no' => $id);
        $CI->db->where($array);
        $CI->db->order_by('id', 'Desc');
        $CI->db->limit(1);
        $query = $CI->db->get('fee');
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            $idd = $result[0]['id'];
            $CI->db->where('id', $idd);
            $CI->db->update(
                    'fee', [
                'status' => 2,
                    ]
            );
        } else {
            return FALSE;
        }
    }

    public static function student_fee_dues_p($id) {
        $CI = & get_instance();
        $CI->db->select('dues');
        $array = array('status' => 4, 'reg_no' => $id);
        $CI->db->where($array);
        $CI->db->order_by('id', 'Desc');
        $CI->db->limit(1);
        $query = $CI->db->get('fee');
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result[0]['dues'];
        } else {
            return FALSE;
        }
    }

    public static function student_fee_dues_update_p($id) {
        $CI = & get_instance();
        $CI->db->select('id');
        $array = array('status' => 4, 'reg_no' => $id);
        $CI->db->where($array);
        $CI->db->order_by('id', 'Desc');
        $CI->db->limit(1);
        $query = $CI->db->get('fee');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $idd = $result[0]['id'];
            $CI->db->where('id', $idd);
            $CI->db->update(
                    'fee', [
                'status' => 2,
                    ]
            );
        } else {
            return FALSE;
        }
    }

    public static function courses($cur = "") {
        $CI = & get_instance();
        $query = $CI->db->get('courses');
        foreach ($query->result() as
                $r) {
            $c = $cur == $r->course_id ? "selected = ''" : "";
            $data .= "<option value = '$r->course_id' $c> $r->course_name " . AdminLTE::batch_name($r->batch) . " </option>";
        }
        return $data;
    }

    public static function expense_names($cur = "") {
        $CI = & get_instance();
        $query = $CI->db->get('expense_names');
        foreach ($query->result() as
                $r) {
            $c = $cur == $r->id ? "selected = ''" : "";
            $data .= "<option value = '$r->id' $c> $r->exp_name </option>";
        }
        return $data;
    }

    public static function batch($cur = "") {
        $CI = & get_instance();
        $query = $CI->db->get('batch');
        foreach ($query->result() as
                $r) {
            $c = $cur == $r->batch_id ? "selected = ''" : "";
            $data .= "<option value = '$r->batch_id' $c> $r->batch_name </option>";
        }
        return $data;
    }

    public static function std() {
        $CI = & get_instance();
        $array = array('status' => 1);
        $CI->db->where($array);
        $query = $CI->db->get('student');
        foreach ($query->result() as
                $r) {
            $data .= "<option value = '$r->reg_no'> $r->reg_no </option>";
        }
        return $data;
    }
    
    public static function naway_std() {
        $CI = & get_instance();
        $array = array('status' => 1);
        $CI->db->where($array);
        $query = $CI->db->get('naway');
        foreach ($query->result() as
                $r) {
            $data .= "<option value = '$r->regno'> $r->regno </option>";
        }
        return $data;
    }

    public static function salary_dues_update($id) {
        $CI = & get_instance();
        $CI->db->select('id');
        $array = array('status' => 0, 'emp_id' => $id);
        $CI->db->where($array);
        $CI->db->order_by('id', 'Desc');
        $CI->db->limit(1);
        $query = $CI->db->get('salary');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            $idd = $result[0]['id'];
            $CI->db->where('id', $idd);
            $CI->db->update(
                    'salary', [
                'status' => 2,
                'amount' => 0,
                    ]
            );
        } else {
            return FALSE;
        }
    }

    public static function month($month) {
        if ($month == "01") {
            echo "January";
        } else if ($month == "02") {
            echo "February";
        } elseif ($month == "03") {
            echo "March";
        } elseif ($month == "04") {
            echo "April";
        } elseif ($month == "05") {
            echo "May";
        } elseif ($month == "06") {
            echo "June";
        } elseif ($month == "07") {
            echo "July";
        } elseif ($month == "08") {
            echo "August";
        } elseif ($month == "09") {
            echo "September";
        } elseif ($month == "10") {
            echo "October";
        } elseif ($month == "11") {
            echo "November";
        } elseif ($month == "12") {
            echo "December";
        }
    }

    public static function day($day) {
        if ($day == "01") {
            echo "First";
        } else if ($day == "02") {
            echo "Second";
        } elseif ($day == "03") {
            echo "Third";
        } elseif ($day == "04") {
            echo "Fourth";
        } elseif ($day == "05") {
            echo "Fifth";
        } elseif ($day == "06") {
            echo "Sixth";
        } elseif ($day == "07") {
            echo "Seven";
        } elseif ($day == "08") {
            echo "Eighth";
        } elseif ($day == "09") {
            echo "Ninth";
        } elseif ($day == "10") {
            echo "Tenth";
        } elseif ($day == "11") {
            echo "Eleventh";
        } elseif ($day == "12") {
            echo "Twelfth";
        } else if ($day == "13") {
            echo "Thirteenth";
        } elseif ($day == "14") {
            echo "Fourteenth";
        } elseif ($day == "15") {
            echo "Fifteenth";
        } elseif ($day == "16") {
            echo "Sixteenth";
        } elseif ($day == "17") {
            echo "Seventeenth";
        } elseif ($day == "18") {
            echo "Eighteenth";
        } elseif ($day == "19") {
            echo "Ninteenth";
        } elseif ($day == "20") {
            echo "Twentieth";
        } elseif ($day == "21") {
            echo "Twenty - First";
        } elseif ($day == "22") {
            echo "Twenty - Second";
        } elseif ($day == "23") {
            echo "Twenty - Third";
        } elseif ($day == "24") {
            echo "Twenty - Fourth";
        } elseif ($day == "25") {
            echo "Twenty - Fifth";
        } elseif ($day == "26") {
            echo "Twenty - Sixth";
        } elseif ($day == "27") {
            echo "Twenty - Seventh";
        } elseif ($day == "28") {
            echo "Twenty - Eighth";
        } elseif ($day == "29") {
            echo "Twenty - Ninth";
        } elseif ($day == "30") {
            echo "Thirtieth";
        } elseif ($day == "31") {
            echo "Thirty - First";
        }
    }

    public static function year($month) {
        if ($month == "1980") {
            echo "Nineteen Eighty";
        } else if ($month == "1981") {
            echo "Nineteen Eighty One";
        } else if ($month == "1982") {
            echo "Nineteen Eighty Two";
        } else if ($month == "1983") {
            echo "Nineteen Eighty Three";
        } else if ($month == "1984") {
            echo "Nineteen Eighty Four";
        } else if ($month == "1985") {
            echo "Nineteen Eighty Five";
        } else if ($month == "1986") {
            echo "Nineteen Eighty Six";
        } elseif ($month == "1987") {
            echo "Nineteen Eighty Seven";
        } elseif ($month == "1988") {
            echo "Nineteen Eighty Eight";
        } elseif ($month == "1989") {
            echo "Nineteen Eighty Nine";
        } else if ($month == "1990") {
            echo "Nineteen Ninety";
        } else if ($month == "1991") {
            echo "Nineteen Ninety One";
        } else if ($month == "1992") {
            echo "Nineteen Ninety Two";
        } else if ($month == "1993") {
            echo "Nineteen Ninety Three";
        } else if ($month == "1994") {
            echo "Nineteen Ninety Four";
        } else if ($month == "1995") {
            echo "Nineteen Ninety Five";
        } else if ($month == "1996") {
            echo "Nineteen Ninety Six";
        } elseif ($month == "1997") {
            echo "Nineteen Ninety Seven";
        } elseif ($month == "1998") {
            echo "Nineteen Ninety Eight";
        } elseif ($month == "1999") {
            echo "Nineteen Ninety Nine";
        } else if ($month == "2000") {
            echo "Two Thousands";
        } else if ($month == "2001") {
            echo "Two Thousand and One";
        } elseif ($month == "2002") {
            echo "Two Thousand and Two";
        } elseif ($month == "2003") {
            echo "Two Thousand and Three";
        } elseif ($month == "2004") {
            echo "Two Thousand and Four";
        } elseif ($month == "2005") {
            echo "Two Thousand and Five";
        } else if ($month == "2006") {
            echo "Two Thousand and Six";
        } elseif ($month == "2007") {
            echo "Two Thousand and Seven";
        } elseif ($month == "2008") {
            echo "Two Thousand and Eight";
        } elseif ($month == "2009") {
            echo "Two Thousand and Nine";
        } elseif ($month == "2010") {
            echo "Two Thousand and Ten";
        } else if ($month == "2011") {
            echo "Two Thousand and Eleven";
        } elseif ($month == "2012") {
            echo "Two Thousand and Twelve";
        } elseif ($month == "2013") {
            echo "Two Thousand and Thirteen";
        } elseif ($month == "2014") {
            echo "Two Thousand and Fourteen";
        } elseif ($month == "2015") {
            echo "Two Thousand and Fifteen";
        }
    }

    public static function years($cur = "") {
        $data = "";
        for ($i = 2017;
                $i <= date('Y');
                $i++) {
            $c = $cur == $i ? "selected = ''" : "";
            $data .= "<option value = '$i' $c> $i </option>";
        }
        return $data;
    }

    public static function months() {
        return [
            '' => 'Please Select Month',
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        ];
    }

    public static function status() {
        return [
            '' => 'Please Select Status',
            '3' => 'Freeze',
            '2' => 'Struck Off',
            '1' => 'Confirmed',
            '0' => 'Pending'
        ];
    }
    
     
    

    public static function fetchall($table, $arr = NULL, $range = NULL, $where = NULL, $groupby = NULL, $order = NULL, $gJoin = NULL) {
        $CI = & get_instance();
        if ($range) {
            $CI->db->select($range, false);
        } else {
            $CI->db->select('*', false);
        }
        if ($arr) {
            $CI->db->join($arr['table'], $table . '.' . $arr['id'] . ' = ' . $arr['table'] . '.' . 'id', 'left outer');
        }
        if ($gJoin) {
            $CI->db->join($gJoin['table'], $table . '.' . $gJoin['fID'] . '=' . $gJoin['table'] . '.' . $gJoin['sID'], 'left');
        }
        if ($where) {
            $CI->db->where($where, '', FALSE);
        }
        if ($groupby) {
            $CI->db->group_by($groupby);
        }

        if ($order) {
            $CI->db->order_by($order['id'], $order['order']);
        }
        $records = $CI->db->get($table)->result_array();
        //echo $this->db->last_query(); exit;
        //echo "<!--".$this->db->last_query()." -->";
        return $records;
    }

    public static function user_data($id) {
        $CI = & get_instance();
        $CI->db->select('*');
        $array = array('id' => $id);
        $CI->db->where($array);
        $query = $CI->db->get('user');
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result[0]['emp_id'];
        } else {
            return FALSE;
        }
    }

    public static function sms($no, $msg) {


        $id = "rchyouthins";
        $pass = "webnaxtor1";
        $mask = "YDI";
        $lang = "English";
// Prepare data for POST request
        $data = "id=" . $id . "&pass=" . $pass . "&mask=" . $mask . "&to=" . $no . "&lang=" . $lang . "&msg=" . $msg;

        //  http://outreach.pk/api/sendsms.php/sendsms/url?id=rchyouthins&pass=webnaxtor1&mask=YDI&to=923339471086&lang=English&msg=Hello&type=xml
// Send the POST request with cURL

        $ch = curl_init('http://www.outreach.pk/api/sendsms.php/sendsms/url');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responce = curl_exec($ch);
        curl_close($ch);
        if ($responce) {
            set_flash_alert($responce, 'success');
        }
    }

    public static function sms_balance() {

        $id = "rchyouthins";
        $pass = "webnaxtor1";
        $url = "http://outreach.pk/api/sendsms.php/balance/status?id=$id&pass=$pass";
        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $response = curl_exec($ch);
        curl_close($ch);
//Write out the response
        echo "Remaining Balance:" . $response;
    }

}
