<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class Student extends CI_Controller
{

  /**
   * Index Page for this controller.
   * Maps to the following URL
   *   http://example.com/index.php/welcome
   * - or -
   *   http://example.com/index.php/welcome/index
   * - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */

  public function __construct()
  {
    parent::__construct();
    $this->load->model( 'user_model', 'user' );
    // Set Template parts
    $this->db->query( "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));" );
    $this->template->baseView( 'master/app' );
    $this->template->assign( 'user', get_user_info() );
    $this->template->assign( 'heading', 'Users' );
  }

  public function birthDay()
  {
    $this->db->where( 'DAYOFMONTH(dob)', date( 'd' ) );
    $this->db->where( 'MONTH(dob)', date( 'm' ) );
    $this->db->where( 'status', 1 );
    $q = $this->db->get( 'student' );
    if( $q->num_rows() > 0 ) {
      foreach( $q->result() as $row ) {
        if( $row->contact !== null ) {
          $contact = $row->contact;
          $message = "Dear " . $row->name . "!
     Wishing you a day filled with happiness and a year filled with joy. Happy birthday!
Regards, 
YDI";
          // Insert user into DB

          AdminLTE::sms( $contact, $message );

          $this->db->insert( 'logs', [
            'contact'   => $contact,
            'msg'       => $message,
            'date'      => date( "Y-m-d H:i:s" ),
            'from_user' => 'Automatic',
          ] );

        }
      }
    }

  }

  public function index()
  {

    // Check existing session
    if( $this->session->has_userdata( 'user_logged' ) && $this->session->user_level == "Admin" ) {
      redirect( '/admin' );
    } elseif( $this->session->has_userdata( 'user_logged' ) && $this->session->user_level == "Interviewer" ) {
      redirect( 'interviewer' );
    }

    $login = $this->user->login();
    if( $login ) {
      if( $this->session->has_userdata( 'user_logged' ) && $this->session->user_level == "Admin" ) {
        redirect( '/admin' );
      } elseif( $this->session->has_userdata( 'user_logged' ) && $this->session->user_level == "Interviewer" ) {
        redirect( 'interviewer' );
      }
    }

    // Load template data
    $this->template->title( 'Login' );
    $this->template->display( 'user/login' );

  }

}
