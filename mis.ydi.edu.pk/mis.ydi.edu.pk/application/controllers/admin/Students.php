<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Students extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    auth_user( 'admin/user/login' );
    if( !auth_admin() ) {
      show_404();
    }
    $this->db->query( "SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));" );
    $this->load->model( 'students_model', 'students' );
    $this->load->model( 'fee_model', 'fee' );
    $this->load->model( 'register_model', 'admission' );
    $this->template->baseView( 'master/app' );
    $this->template->assign( 'user', get_user_info() );
    $this->template->assign( 'heading', 'Student' );

  }

  public function index()
  {

    $status = $this->students->status();
    $this->template->assign( 'status', $status );
    $result = $this->students->all();
    $this->template->assign( 'result', $result );
    $this->template->addView( "students/all", 'body' );
    $this->template->display();
  }

  public function logs()
  {
    $this->template->addView( "reports/logs", 'body' );
    $this->template->display();
  }

  public function log_details()
  {
    $this->template->addView( "reports/log_details", 'body' );
    $this->template->display();
  }

  public function idcards()
  {
    $result = $this->students->idcards();
    $this->template->assign( 'result', $result );
    $this->template->addView( "students/idcards", 'body' );
    $this->template->display();

  }

  public function student_adm_wdr()
  {

    $result = $this->students->all_std_info();
    $this->template->assign( 'result', $result );
    $this->template->addView( "students/student_adm_wdr", 'body' );
    $this->template->display();

  }

  public function create()
  {
    if( !auth_admin() ) {
      show_404();
    }
    if( $this->students->create() ) {
      redirect( 'admin/students' );
    }

    $employee = $this->students->employee();
    $this->template->assign( 'employee', $employee );
    $internet = $this->students->internet();
    $this->template->assign( 'internet', $internet );
    $this->template->addView( "students/create", 'body' );
    $this->template->display();
  }

  public function view( $id )
  {
    $result = $this->students->find( $id );
    if( empty( $result ) ) {
      show_404();
    }
    $this->template->assign( 'r', $result[ 0 ] );
    $this->template->addView( "students/view", 'body' );
    $this->template->display();
  }

  public function printform( $id )
  {
    $result = $this->students->find( $id );
    if( empty( $result ) ) {
      show_404();
    }
    $this->template->assign( 'r', $result[ 0 ] );
    $this->template->addView( "students/print", 'body' );
    $this->template->display();
  }

  public function account( $id )
  {
    $result = $this->students->find( $id );

    if( empty( $result ) ) {
      show_404();
    }

    // Load attendance model
    $this->load->model( 'Myattend_model', 'attend' );

    $fee = $this->fee->findByReg( $result[ 0 ]->reg_no );
    $admission = $this->admission->findByReg( $result[ 0 ]->reg_no );
    $attendance = $this->attend->getAttendanceByStudent( $result[ 0 ]->reg_no );

    $this->template->assign( 'r', $result[ 0 ] );
    $this->template->assign( 'fee', $fee );
    $this->template->assign( 'admission', $admission );
    $this->template->assign( 'attendance', $attendance );
    $this->template->addView( "students/account", 'body' );
    $this->template->display();
  }

  public function print_slc( $id )
  {
    $result = $this->students->find_slc( $id );
    if( empty( $result ) ) {
      show_404();
    }
    $result1 = $this->students->find_student( $id );
    $this->template->assign( 'r', $result1[ 0 ] );
    $this->template->addView( "students/print_slc", 'body' );
    $this->template->display();
  }

  public function print_all()
  {
    $data = $this->students->printall();
    if( empty( $data ) ) {
      show_404();
    }
    //load the view and saved it into $html variable

    $this->template->assign( 'result', $data );
    $this->template->addView( "students/print_all", 'body' );
    $this->template->display();
  }

  public function edit( $id )
  {
    if( !auth_admin() ) {
      show_404();
    }
    if( $this->students->update( $id ) ) {
      redirect( 'admin/students' );
    }
    $result = $this->students->find( $id );
    if( empty( $result ) ) {
      show_404();
    }

    $employee = $this->students->employee();
    $this->template->assign( 'employee', $employee );
    $internet = $this->students->internet();
    $this->template->assign( 'internet', $internet );
    $status = $this->students->status();
    $this->template->assign( 'status', $status );
    $this->template->assign( 'r', $result[ 0 ] );
    $this->template->addView( "students/edit", 'body' );
    $this->template->display();

  }

  public function slc( $id )
  {
    if( !auth_admin() ) {
      show_404();
    }

    if( $this->students->slc( $id ) ) {
      redirect( 'admin/students' );
    }

    $result = $this->students->find_slc( $id );
    if( empty( $result ) ) {
      $this->template->addView( "students/slc", 'body' );
      $this->template->display();
    } else {
      $this->template->assign( 'result', $result );
      $this->template->addView( "students/slc_view", 'body' );
      $this->template->display();
    }
  }

  public function card( $id )
  {
    $result = $this->students->find_student( $id );
    if( empty( $result ) ) {
      show_404();
    }
    $this->template->assign( 'r', $result[ 0 ] );
    $this->template->addView( "students/card", 'body' );
    $this->template->display();

  }

  public function sms( $id )
  {
    $result = $this->students->find_student( $id );
    if( empty( $result ) ) {
      show_404();
    }
    if( $this->students->send_sms() ) {
      redirect( 'admin/students' );
    }

    $this->template->assign( 'r', $result[ 0 ] );
    $this->template->addView( "students/sms", 'body' );
    $this->template->display();

  }

  public function delete()
  {
    if( !auth_admin() ) {
      show_404();
    }

    $password = $this->input->post( 'password' );

    // Get manager user for verification
    $this->db->select( '*' );
    $this->db->where( 'level', "Manager" );
    $query = $this->db->get( 'user' );
    $result = $query->result();

    $valid = false;
    if( !empty( $result ) ) {
      foreach( $result as $user ) {
        if( verify_password( $password, $user->password ) ) {
          $valid = true;
          // Migrate legacy password if needed
          if( is_legacy_password( $user->password ) ) {
            $new_hash = secure_password_hash( $password );
            $this->db->where( 'id', $user->id );
            $this->db->update( 'user', ['password' => $new_hash] );
          }
          break;
        }
      }
    }

    if( !$valid ) {
      set_flash_alert( 'Invalid login details' );
      redirect( 'admin/students' );
    } else {
      $ID = $this->input->post( 'regno', true );
      $this->students->delete( $ID );
      redirect( 'admin/students' );
    }

  }

  public function addrop()
  {

    if( !auth_admin() ) {
      show_404();
    }
    $this->template->title( 'Reports Dashboard' );
    $this->template->addView( "reports/addrop", 'body' );
    $this->template->display();

  }

  public function alladm()
  {
    if( !auth_admin() ) {
      show_404();
    }

    $this->template->title( 'Reports Dashboard' );
    $this->template->addView( "reports/alladm", 'body' );
    $this->template->display();

  }
}

