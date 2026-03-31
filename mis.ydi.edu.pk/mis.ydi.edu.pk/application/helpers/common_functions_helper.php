<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Secure Password Hashing Functions
 * PHP 8.3 compatible with backward compatibility for legacy passwords
 */

if (!function_exists('secure_password_hash')) {
    /**
     * Hash password using modern algorithm (Argon2 with fallback to bcrypt)
     * @param string $password Plain text password
     * @return string Hashed password
     */
    function secure_password_hash($password) {
        if (defined('PASSWORD_ARGON2ID')) {
            return password_hash($password, PASSWORD_ARGON2ID, [
                'memory_cost' => 65536,
                'time_cost' => 4,
                'threads' => 3
            ]);
        }
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
}

if (!function_exists('verify_password')) {
    /**
     * Verify password with backward compatibility for legacy hashing
     * @param string $password Plain text password
     * @param string $hash Stored hash
     * @return bool True if password matches
     */
    function verify_password($password, $hash) {
        // Modern hash (starts with $)
        if (strpos($hash, '$') === 0) {
            return password_verify($password, $hash);
        }

        // Legacy crypt() with 'ca' salt (2 character salt)
        if (strlen($hash ?? '') == 13) {
            return crypt($password, 'ca') === $hash;
        }

        // Legacy MD5 (32 hex characters)
        if (strlen($hash ?? '') === 32 && ctype_xdigit($hash)) {
            return md5($password) === $hash;
        }

        return false;
    }
}

if (!function_exists('is_legacy_password')) {
    /**
     * Check if password hash is legacy format
     * @param string $hash Password hash
     * @return bool True if legacy format
     */
    function is_legacy_password($hash) {
        return strpos($hash, '$') !== 0;
    }
}

if (!function_exists('set_alert')) {

    function set_alert($message, $type = 'danger') {
        $data = [];
        $data['message'] = $message;
        $data['type'] = $type;
        $type_title = 'Woops';

        switch ($type) {
            case 'success':
            case 'ok':
                $type_title = 'Well done';
                break;
            case 'info':
                $type_title = 'Heads up';
                break;
            case 'warning':
                $type_title = 'Warning';
                break;
            default :
                break;
        }

        $data['title'] = $type_title;

        return $data;
    }

}

if (!function_exists('alert')) {

    function alert($alert) {
        ?>
        <div class="alert alert-<?php echo $alert['type'] ?> alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong><?php echo $alert['title'] ?>!</strong> <?php echo $alert['message'] ?>
        </div>
        <?php
    }

}

if (!function_exists('auth_user')) {

    function auth_user($redirect = 'admin/user/login') {
        $CI = & get_instance();
        if (!$CI->session->has_userdata('user_logged')) {
            redirect($redirect);
        }
    }

}

if (!function_exists('active_link')) {

    function active_link($link, $class = 'class="active"') {
        if (is_array($link) && in_array(base_url(uri_string()), array_map('site_url', $link))) {
            return ' ' . $class;
        } else if (base_url(uri_string()) == site_url($link)) {
            return ' ' . $class;
        }
        return '';
    }

}

if (!function_exists('set_flash_alert')) {

    function set_flash_alert($message, $type = 'danger') {
        $CI = & get_instance();
        $data = set_alert($message, $type);
        $CI->session->set_userdata(['flash_alert' => $data]);
    }

}

if (!function_exists('flash_alert')) {

    function flash_alert() {
        $CI = & get_instance();
        if ($CI->session->has_userdata('flash_alert')) {
            alert($CI->session->flash_alert);
            $CI->session->unset_userdata('flash_alert');
        }
    }

}

if (!function_exists('get_user_info')) {

    function get_user_info() {
        $CI = & get_instance();
        return [
            'fullname' => $CI->session->user_logged,
            'username' => $CI->session->user_name,
            'id' => $CI->session->user_id,
            'status' => $CI->session->user_status,
            'level' => $CI->session->user_level,
        ];
    }

}

if(!function_exists('auth_manager')){
    function auth_manager() {
        $CI = & get_instance();
        if ($CI->session->user_level == 'Manager') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if(!function_exists('auth_internee')){
    function auth_internee() {
        $CI = & get_instance();
        if ($CI->session->user_level == 'Internee') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}

if (!function_exists('auth_admin')) {

    /**
     * 
     * @return boolean True if current user has role of <b>Status of 1</b>
     * False otherwise
     */
    function auth_admin() {
        $CI = & get_instance();
        if ($CI->session->user_level == 'Admin' || $CI->session->user_level == 'Manager') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
    
    
    if (!function_exists('auth_card')) {

    /**
     * 
     * @return boolean True if current user has role of <b>Status of 1</b>
     * False otherwise
     */
    function auth_card() {
        $CI = & get_instance();
        if ($CI->session->user_level == 'Publications') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    }
    
    if (!function_exists('auth_inter')) {

    /**
     * 
     * @return boolean True if current user has role of <b>Status of 1</b>
     * False otherwise
     */
    function auth_inter() {
        $CI = & get_instance();
        if ($CI->session->user_level == 'Interviewer') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    }
    
      if (!function_exists('auth_naway')) {

    /**
     * 
     * @return boolean True if current user has role of <b>Status of 1</b>
     * False otherwise
     */
    function auth_naway() {
        $CI = & get_instance();
        if ($CI->session->user_level == 'NawayTakay') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    }
    
     
    if (!function_exists('auth_trainer')) {

    /**
     * 
     * @return boolean True if current user has role of <b>Status of 1</b>
     * False otherwise
     */
    function auth_trainer() {
        $CI = & get_instance();
        if ($CI->session->user_level == 'Trainer') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    }
    
    date_default_timezone_set('asia/karachi');
//================ Date formating function starts==================//
function dateformatesformysql($dates) {
   if($dates!='00/00/0000'){
      $convertdate = $dates; //receives date like 08/27/2015
      $return = date('Y-m-d', strtotime($convertdate));
      return $return;
   }
}
function dateformatesformysql_fata($dates) {
   if($dates!='00/00/0000'){
      $convertdate = $dates; //receives date like 08/27/2015
      $return = date('d-m-Y', strtotime($convertdate));
      return $return;
   }
}

function dateformates($dates) {
   if($dates!='0000-00-00' && $dates!=''){
	   $convertdate = $dates; //receives date like 0000-00-00
	   $return = date('F  Y',strtotime($convertdate));
	   if(strstr($return,'1969')){
		   return 'N/A';
		   }else{
	   return $return; //returns date formated MONTH 00, 0000
		   }
   }else{
	   return 'N/A';
	   }
}

//format conversion to store date
function cnvrt_date($date){
	if($date!='' && $date!='00-00-0000'){
		$date1=explode("-",$date);
		$date= $date1[2].'-'.str_pad($date1[1], 2, '0', STR_PAD_LEFT).'-'.$date1[0];
		return $date;
	}
}

//format conversion to display date
function display_date($date){
	if($date!='0000-00-00' && $date!=''){
		$date1=explode("-",$date);
		$date = $date1[2].'-'.$date1[1].'-'.$date1[0];
		return $date;
	}
}

function display_date_no_day($date){
	if($date!='0000-00' && $date!=''){
		$date1=explode("-",$date);
		$date = $date1[1].'-'.$date1[0];
		return $date;
	}
}


function calendar_date($dates) {
   $convertdate = $dates; //receives date like 0000-00-00
   $return = str_replace(",0",",",date('Y,m,d',strtotime($convertdate)));
   return $return; //returns date formated MONTH 00, 0000
}
function calendar_date_project($dates) {
   $convertdate = $dates; //receives date like 0000-00-00
   $return = str_replace(",0",",",date('d-m-Y',strtotime($convertdate)));
   return $return; //returns date formated 00-00-0000
}

function get_MONTHyear($dates) {
   $convertdate = $dates; //receives date like 0000-00-00
   $return = date('M, Y',strtotime($convertdate));
   return $return; //returns date formated MONTH 0000
}


function get_fullMONTHyear($dates) {
   $convertdate = $dates; //receives date like 0000-00-00
   $return = date('d M,Y',strtotime($convertdate));
   return $return; //returns date formated MONTH 0000
}

function get_year($dates) {
   $convertdate = $dates; //receives date like 0000-00-00
   $return = date('Y',strtotime($convertdate));
   return $return; //returns date formated MONTH 0000
}
function get_bdp_date($dates) {
   $convertdate = $dates; //receives date like 0000-00-00
   $return = date('m-d-Y',strtotime($convertdate));
   return $return; //returns date formated MONTH 0000
}


//================ Date formating function ends==================//





//================ User validation function starts==================//
	function validate(){
		$CI =& get_instance();
		
		if(!($CI->session->userdata('validated')) )
	   	{
			redirect(base_url().'login');
		}else{
			return true;
		}
		
	}
//================ User validation function Ends==================//


	function rolesignals(){
		$housing = get_roles();
		$CI =& get_instance();
			if(in_array($CI->session->userdata('role'),$housing)==true){
				redirect(base_url().'housing');
				}
	}

	function get_roles(){
		return $housing = array(4,5,7,8,9);
		}


//print array
function print_array($arr,$flag = NULL){
	echo '<pre>';
	print_r($arr);
	if(!$flag){
		exit;
	}
}

function convert_number($n) {
    // first strip any formatting;
    $n = (0+str_replace(",","",$n));
    // is this a number?
    if(!is_numeric($n)) return false;
    // now filter it;
	if($n>=999 || $n<=-999){
		if($n>=1000000000000 || $n<=-1000000000000) return round(($n/1000000000000),4).'T';
		else if($n>=1000000000 || $n<=-1000000000) return round(($n/1000000000),3).'B';
		else if($n>=1000000 || $n<=-1000000) return round(($n/1000000),2).'M';
		else if($n>=1000 || $n<=-1000) return round(($n/1000),1).'K';
		return number_format($n);
	}else{
		return $n;
	}
}

function convert_million($n) {
    $n = (0+str_replace(",","",$n));
    return round(($n/1000000),2).'M';
}


function convert_number_m($n) {
        // first strip any formatting;
        $n = (0+str_replace(",","",$n));
        // is this a number?
        if(!is_numeric($n)) return false;
        // now filter it;
		if($n>=999 || $n<=-999){
			if($n>=1000000000000 || $n<=-1000000000000) return round(($n/1000000000000),4).'T';
			else if($n>=1000000000 || $n<=-1000000000) return round(($n/1000000000),3).'B';
			else if($n>=999 || $n<=-999) return round(($n/1000000),2).'M';
			//else if($n>=1000 || $n<=-1000) return round(($n/1000),1).'K';
			return number_format($n);
		}else{
			return $n;
		}
    }
//========== Function to count value occurrence in array ends=======//	
function upload_file($FILES,$file_element_name,$upload_path){
	$expensions = array("gif","jpg","png","jpeg","doc","docx","xls","xlsx","pdf","ppt","pptx");
	$errors= array();
	$file_name = $FILES[$file_element_name]['name'];
	$file_size =$FILES[$file_element_name]['size'];
	$file_tmp =$FILES[$file_element_name]['tmp_name'];
	$file_type=$FILES[$file_element_name]['type'];
	$tmp = explode('.', $file_name);
	$ext = end($tmp);
	$file_ext=strtolower($ext ?? '');
	if(in_array($file_ext,$expensions)=== false){
		$errors[]="extension not allowed, please choose a JPEG or PNG file.";
	}
	if(empty($errors)==true){
		move_uploaded_file($file_tmp,$upload_path.$file_name);
		return $file_name;
	} else {
		//print_r($errors);
		return '';
	}
}



	function unique_location($location_str){
	  $t = explode(',',$location_str);
	  $t = array_filter(array_map('trim',$t),'strlen');
	  $t = array_unique($t);
	  $t = implode(', ',$t);
	  return $t;
    }
    /**
     * Custom array sorting function
     * PHP 8.3 compatible - uses anonymous function instead of create_function()
     */
    function custom_sort_array($field, &$array, $direction = 'asc')
    {
        usort($array, function($a, $b) use ($field, $direction) {
            $aVal = $a[$field] ?? null;
            $bVal = $b[$field] ?? null;

            if ($aVal == $bVal) {
                return 0;
            }

            if ($direction === 'desc') {
                return ($aVal > $bVal) ? -1 : 1;
            } else {
                return ($aVal < $bVal) ? -1 : 1;
            }
        });

        return true;
    }

if (!function_exists('array_columnn')) {
    function array_columnn($array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = is_object($subArray)?$subArray->$columnKey: $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $index = is_object($subArray)?$subArray->$indexKey: $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $index = is_object($subArray)?$subArray->$indexKey: $subArray[$indexKey];
                    $result[$index] = is_object($subArray)?$subArray->$columnKey: $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}


