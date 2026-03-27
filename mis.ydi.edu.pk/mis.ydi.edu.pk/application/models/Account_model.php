<?php
		
		class Account_model extends CI_Model
		{
				
				public function all()
				{
						$this->db->order_by( 'id', 'DESC' );
						$q = $this->db->get( 'salary' );
						return $q->result();
				}
				
				public function find( $id )
				{
						$this->db->where( 'id', $id );
						$q = $this->db->get( 'salary' );
						return $q->result();
				}
				
				public function create()
				{
						
						// Load form validation library
						$this->load->library( 'form_validation' );
						// define rules
						$rules = [
								[
										'field' => 'month',
										'label' => 'Month',
										'rules' => 'required'
								],
								[
										'field' => 'employee',
										'label' => 'Employee',
										'rules' => 'required'
								],
						];
						
						// Set rules
						$this->form_validation->set_rules( $rules );
						// Check form
						if( $this->form_validation->run() != false ) {
								$month = $this->input->post( 'month', true );
								$year = $this->input->post( 'year', true );
								$employee = $this->input->post( 'employee', true );
								$date = $this->input->post( 'date', true );
								$paid = $this->input->post( 'paid', true );
								$salary = AdminLTE::employee_data( $employee, "salary" );
								
								$array = [
										'month'  => $month,
										'year'   => $year,
										'emp_id' => $employee
								];
								$this->db->where( $array );
								$q = $this->db->get( 'salary' );
								if( $q->num_rows() > 0 ) {
										$result = $q->result_array();
										$alpaid = $result[ 0 ][ 'paid' ];
										$aldue = $result[ 0 ][ 'dues' ];
										$totalamount = $result[ 0 ][ 'total' ];
										$status = 0;
										if( $paid + $alpaid == $totalamount ) {
												$status = 1;
										} else {
												$status = 3;
										}
										$this->db->where( [
												"emp_id" => $employee,
												"month"  => $month,
												"year"   => $year
										] );
										$sql = $this->db->update(
												'salary', [
												'dues'   => $aldue - $paid,
												'paid'   => $paid + $alpaid,
												'status' => $status,
										] );
								} else {
										$due = AdminLTE::salary_dues( $employee );
										$total = $salary + $due;
										AdminLTE::salary_dues_update( $employee );
										$status = 0;
										if( $paid == 0 ) {
												$status = 0;
										} elseif( $paid > 0 && $paid < $salary ) {
												$status = 3;
										} elseif( $paid == $salary ) {
												$status = 1;
										}
										$sql = $this->db->insert(
												'salary', [
												'emp_id' => $employee,
												'month'  => $month,
												'year'   => $year,
												'date'   => $date,
												'paid'   => $paid,
												'dues'   => $total - $paid,
												'total'  => $total,
												'status' => $status,
										] );
								}
								
								if( $sql ) {
										set_flash_alert( 'Salary created successfully of ' . AdminLTE::employee_name( $employee ), 'success' );
										return true;
								} else {
										set_flash_alert( implode( ': ', $this->db->error() ) );
								}
						}
						return false;
				}
				
				public function update( $id )
				{
						// Load form validation library
						$this->load->library( 'form_validation' );
						$rules = [
								
								[
										'field' => 'paid',
										'label' => 'Paid',
										'rules' => 'required'
								],
						];
						
						// Set rules
						$this->form_validation->set_rules( $rules );
						// Check form
						if( $this->form_validation->run() != false ) {
								$amount = $this->input->post( 'paid', true );
								
								$this->db->where( 'id', $id );
								
								$result = $this->db->query( "select * from salary where id = $id" )->result_array();
								
								//$paid = $result[0]['paid'];
								$total = $result[ 0 ][ 'total' ];
								$due = $result[ 0 ][ 'total' ] - $amount;
								$status = 0;
								if( $amount == 0 ) {
										$status = 0;
								} elseif( $amount > 0 && $amount < $total ) {
										$status = 3;
								} elseif( $amount == $total ) {
										$status = 1;
								}
								
								$this->db->where( 'id', $id );
								$sql = $this->db->update(
										'salary', [
												// 'total' => $total,
												'paid' => $amount,
												'dues' => $due,
												'status' => $status
										]
								);
								if( $sql ) {
										set_flash_alert( 'Salary Updated successfully', 'success' );
										return true;
								} else {
										set_flash_alert( implode( ': ', $this->db->error() ) );
								}
						}
						return false;
				}
				
				public function paid_salary( $id )
				{
						$this->db->where( 'id', $id );
						$result = $this->db->query( "select * from salary where id = $id" )->result_array();
						
						$total = $result[ 0 ][ 'total' ];
						
						$sql = $this->db->update(
								'salary', [
										'status' => 1,
										'dues'   => 0,
										'paid'   => $total
								]
						);
						$sql = $this->db->insert(
								'salary_detail', [
								'emp_id' => $result[ 0 ][ 'emp_id' ],
								'dues'   => 0,
								'paid'   => $result[ 0 ][ 'dues' ]
						] );
						if( $sql ) {
								set_flash_alert( 'Salary has been Paid successfully', 'success' );
								return true;
						} else {
								set_flash_alert( implode( ': ', $this->db->error() ) );
						}
						
						return false;
				}
				
				public function delete( $id )
				{
						$query = $this->db->delete( 'salary', [ 'id' => $id ] );
						if( $query ) {
								set_flash_alert( 'Salary deleted', 'success' );
						} else {
								set_flash_alert( implode( ': ', $this->db->error() ) );
						}
				}
				
				public function salary_details( $id )
				{
						$this->db->where( 'emp_id', $id );
						$query = $this->db->get( 'salary_detail' );
						return $query->result();
				}
				
				public function name()
				{
						$return[ '' ] = '';
						$this->db->where( 'status', '1' );
						$query = $this->db->get( 'employee' );
						foreach( $query->result_array() as
						         $row ) {
								$return[ $row[ 'id' ] ] = $row[ 'name' ];
						}
						return $return;
				}
				
				public function status()
				{
						return [
								''  => '',
								'1' => 'Paid',
								'0' => 'Unpaid',
								'3' => 'Partially Paid / Advance'
						];
				}
				
				public function update_partial( $id )
				{
						// Load form validation library
						$this->load->library( 'form_validation' );
						$rules = [
								
								[
										'field' => 'salary',
										'label' => 'Salary',
										'rules' => 'required'
								]
						];
						
						// Set rules
						$this->form_validation->set_rules( $rules );
						// Check form
						if( $this->form_validation->run() != false ) {
								
								$this->db->where( 'id', $id );
								$result = $this->db->query( "select * from salary where id = $id" )->result_array();
								
								$total = $result[ 0 ][ 'total' ];
								$paid = $result[ 0 ][ 'paid' ];
								
								$tution = $paid + $this->input->post( 'salary', true );
								
								$t = $total - $tution;
								
								$sql = $this->db->update(
										'salary', [
												'dues'   => $t,
												'status' => 3,
												'paid'   => $tution
										]
								);
								
								$sql = $this->db->insert(
										'salary_detail', [
										'emp_id' => $result[ 0 ][ 'emp_id' ],
										'dues'   => $t,
										'paid'   => $this->input->post( 'salary', true )
								] );
								if( $sql ) {
										set_flash_alert( 'Salary Partially / Advance Paid successfully', 'success' );
										return true;
								} else {
										set_flash_alert( implode( ': ', $this->db->error() ) );
								}
						}
						return false;
				}
				
		}
