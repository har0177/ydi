<?php

class Backup extends CI_Controller {

    public function __construct() {
        parent::__construct();
 $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
          auth_user('admin/user/login');
      /*if(!auth_admin()){
            show_404();
        }*/
     
    }
    
    public function db_backup(){
      $this->load->dbutil();

        $prefs = array(     
                'format'      => 'sql',             
                'filename'    => 'my_db_backup.sql'
              );


        $backup = $this->dbutil->backup($prefs); 

        $db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.sql';
        $save = '/upload/_tmp/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup); 


        $this->load->helper('download');
        force_download($db_name, $backup); 
}
}

		