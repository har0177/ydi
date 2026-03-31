
<div class="page-header">
    <h1>    <i class="ace-icon fa fa-dashboard"></i>
						<?php echo "Dashboard of " . ($this->session->user_name ?? '') . " - " . ($this->session->user_level ?? '') ?>
						<?php
								echo date("d F, Y");
						?>  </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">


        <div class="row">

            <div class="widget-box hidden-print">
                <div class="table-header">
                    Search Date Wise Reports
                </div>
                <div class="widget-body">
                    <div class="widget-main">

                        <div id="fuelux-wizard-container">

                            <div class="step-content pos-rel">
																														
																														<?php echo form_open('', ['class' => 'form-horizontal']); ?>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-2 no-padding-right" for="status">From Date: </label>

                                    <div class="col-xs-12 col-sm-3">
                                        <input type="text" name="from" value="<?php echo date('Y-m-d'); ?>" class="form-control datepicker"/>
                                    </div>
                                    <label class="control-label col-xs-12 col-sm-2 no-padding-right" for="status">To Date: </label>

                                    <div class="col-xs-12 col-sm-3">
                                        <input type="text" name="to" value="<?php echo date('Y-m-d'); ?>" class="form-control datepicker"/>
                                    </div>
                                    <div class="col-xs-12 col-sm-2">
                                        <input type="submit" name="submit" value="Search" class="btn btn-lg btn-success">


                                    </div>
                                </div>
																														
																														
																														<?php echo form_close(); ?>

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div>
                </div>
            </div>
										<?php if (auth_manager()) { ?>
              <div class="col-sm-12 text-center col-xs-12">
                  <div id="profit" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
              </div>
										
										<?php } ?>
										
										<?php if (auth_admin()) { ?>
              <div class="col-sm-12 text-center col-xs-12">
                  <div id="reg" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
              </div>


              <div class="col-sm-12 text-center col-xs-12">
                  <div id="fee" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
              </div>

              <div class="col-sm-12 text-center col-xs-12">
                  <div id="expenses" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
              </div>

              <div class="col-sm-6 text-center col-xs-12">

                  <div id="bank" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
              </div>
              <div class="col-sm-6 text-center col-xs-12">
                  <div id="users" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
              </div>
              <div class="col-sm-12 text-center col-xs-12">

                  <div id="course" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
              </div>
										<?php } if (auth_manager()) { ?>

              <div class="col-sm-12 text-center col-xs-12">

                  <div id="teacher" style="min-width: 300px; height: 400px; margin: 0 auto"></div>

              </div>
              <div class="col-sm-12 text-center col-xs-12">

                  <div id="student" style="min-width: 300px; height: 400px; margin: 0 auto"></div>

              </div>
												<?php
												$cour = $this->db->query("Select course from trainer_data group by course");
												foreach ($cour->result() as
												         $vals) {
														if(AdminLTE::user_course($vals->course) == 1){
																?>
                  <div class="col-sm-6 text-center col-xs-12">

                      <div id="stra<?php echo $vals->course ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                  </div>
																<?php
														}
												}
										}
										?>
        </div>


        <script src = "<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
						<?php
								$dates = '';
								if (isset($_POST["submit"])) {
										$from = $this->input->post('from') ?? '';
										$to = $this->input->post('to') ?? '';
										$dates = $from;
										$q = $this->db->query('SELECT fee, admfee, fee.date as date, expe, salary
FROM (
(SELECT SUM(fee) as fee, date FROM admission_info where fee_status = 1 and DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '"group by date) as fee
LEFT JOIN
(SELECT SUM(paid) as admfee, date_of_payment as date FROM fee where DATE(date_of_payment) BETWEEN "' . $from . '"  AND "' . $to . '" group by date_of_payment) as admfee
ON fee.date = admfee.date
LEFT JOIN
(SELECT SUM(amount) as expe, date from expenses where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" group by date) as expe
ON fee.date = expe.date
LEFT JOIN
(SELECT SUM(paid) as salary, date from salary where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" group by date) as salary
ON fee.date = salary.date
)');
								}
								else {

										$q = $this->db->query('SELECT fee, admfee, fee.date as date, expe, salary
FROM (
(SELECT SUM(fee) as fee, MONTHNAME(date) as date FROM admission_info where fee_status = 1 and Month(date)= "' . date("F Y") . '" and Year(date)= "' . date("Y") . '"  group by MONTH(date)) as fee
LEFT JOIN
(SELECT SUM(paid) as admfee, MONTHNAME(date_of_payment) as date FROM fee where Month(date_of_payment) = "' . date("F Y") . '" and Year(date_of_payment)= "' . date("Y") . '" group by MONTH(date_of_payment)) as admfee
ON fee.date = admfee.date
LEFT JOIN
(SELECT SUM(amount) as expe, MONTHNAME(date) as date from expenses where Month(date) = "' . date("F Y") . '" and Year(date)= "' . date("Y") . '" group by MONTH(date)) as expe
ON fee.date = expe.date
LEFT JOIN
(SELECT SUM(paid) as salary, MONTHNAME(date) as date from salary where Month(date) = "' . date("F Y") . '" and Year(date)= "' . date("Y") . '" group by MONTH(date)) as salary
ON fee.date = salary.date
)');
								}

								$qResult = $q->result();
								$rc = json_encode(array_columnn($qResult, 'expe'), JSON_NUMERIC_CHECK);

								$sl = json_encode(array_columnn($qResult, 'salary'), JSON_NUMERIC_CHECK);
								$admfee = json_encode(array_columnn($qResult, 'fee'), JSON_NUMERIC_CHECK);
								$fee = json_encode(array_columnn($qResult, 'admfee'), JSON_NUMERIC_CHECK);

								$date = json_encode(array_columnn($qResult, 'date'), JSON_NUMERIC_CHECK);
						?>
        <script>
          $(function () {

            Highcharts.chart('reg', {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Admission / Traning Fee / Expenses / Salary Chart of Year <?php echo date("F Y") ?>'
              },
              xAxis: {
                categories:
																<?php echo $date; ?>,
                crosshair: true
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Admission/ Training Fee / Expenses / Salary Chart of Year <?php echo date("F Y") ?>'
                }
              },
              tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0;"><b>{point.y:.1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },
              plotOptions: {
                column: {
                  pointPadding: 0.2,
                  borderWidth: 0
                },
                series: {
                  dataLabels: {
                    enabled: true,
                    format: 'Rs. {y}'
                  }
                }
              },
              series: [
                {
                  name: 'Total Admission Fee',
                  data: <?php echo $admfee; ?>

                },
                {
                  name: 'Total Training Fee',
                  data: <?php echo $fee; ?>

                },
                {
                  name: 'Total Salary Paid',
                  data: <?php echo $sl; ?>

                },
                {
                  name: 'Total Expenses',
                  data: <?php echo $rc ?>

                },
              ]


            });
          });        </script>
						<?php
								$paid = array();
								$unpaid = array();
								$ffdate = array();
								if (isset($_POST["submit"])) {
										$from = $this->input->post('from') ?? '';
										$to = $this->input->post('to') ?? '';
										$qq = $this->db->query('Select SUM(paid) as paid, SUM(dues) as dues, date_of_payment as date from fee where DATE(date_of_payment) BETWEEN "' . $from . '"  AND "' . $to . '" group by date_of_payment');
								}
								else {
										$qq = $this->db->query("Select SUM(paid) as paid, SUM(dues) as dues, MONTHNAME(date_of_payment) as date from fee where Month(date_of_payment) = '" . date('m') . "' and Year(date_of_payment)= '" . date('Y') . "' group by MONTH(date_of_payment)");
								}
								
								foreach ($qq->result() as
								         $feedata) {
										$paid[] = $feedata->paid;
										$unpaid[] = $feedata->dues;
										$ffdate[] = $feedata->date;
								}
						?>

        <script>
          $(function () {


            Highcharts.chart('fee', {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Paid / Unpaid Fee Chart of Year <?php echo date("F Y")  ?>'
              },
              xAxis: {
                categories:
																<?php echo json_encode($ffdate); ?>,
                crosshair: true
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Paid / Unpaid Fee Chart of Year <?php echo date("F Y")  ?>'
                }
              },
              tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },
              plotOptions: {
                column: {
                  pointPadding: 0.2,
                  borderWidth: 0
                },
                series: {
                  dataLabels: {
                    enabled: true,
                    format: 'Rs. {y}',
                  }
                }
              },
              series: [
                {
                  name: 'Total Training Paid Fee',
                  data: <?php echo json_encode($paid, JSON_NUMERIC_CHECK); ?>

                },
                {
                  name: 'Total Training Unpaid Fee',
                  data: <?php echo json_encode($unpaid, JSON_NUMERIC_CHECK); ?>

                }


              ]


            });
          });        </script>
        <script>
          $(function () {

            Highcharts.chart('users', {
              chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
              },
              title: {
                text: 'Users / Students / Employees / Courses Chart'
              },
              tooltip: {
                headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },
              plotOptions: {
                pie: {
                  allowPointSelect: true,
                  cursor: 'pointer',
                  dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {y}',
                    style: {
                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                  }
                }
              },
              series: [{
                name: 'Total',
                colorByPoint: true,
                data: [{
                  name: 'Users',
                  y: <?php
																		if (empty($user ?? 0)) {
																				echo 0;
																		}
																		else {
																				echo $users ?? 0;
																		}
																		?>,
                  sliced: true,
                  selected: true
                }, {
                  name: 'Students',
                  y: <?php
																		if (empty($students ?? 0)) {
																				echo 0;
																		}
																		else {
																				echo $students ?? 0;
																		}
																		?>
                }, {
                  name: 'Employee',
                  y: <?php
																		if (empty($employee ?? 0)) {
																				echo 0;
																		}
																		else {
																				echo $employee ?? 0;
																		}
																		?>
                }, {
                  name: 'Courses',
                  y: <?php
																		if (empty($courses ?? 0)) {
																				echo 0;
																		}
																		else {
																				echo $courses ?? 0;
																		}
																		?>
                }]
              }]
            });
          });        </script>
						<?php if (auth_manager()) { ?>
								<?php
								//             $q = $this->db->query("SELECT fee, admfee, fee.date as date, expe
								//FROM (
								//(SELECT SUM(fee) as fee, DATE_FORMAT(date, '%m-%Y')  as date FROM admission_info group by MONTH(date)) as fee
								//LEFT JOIN
								//(SELECT SUM(paid) as admfee, DATE_FORMAT(date_of_payment, '%m-%Y') as date FROM fee group by MONTH(date_of_payment)) as admfee
								//ON fee.date = admfee.date
								//LEFT JOIN
								//(SELECT SUM(e_bill + t_bill + rent+ daily) as expe, DATE_FORMAT(date, '%m-%Y') as date from expenses group by MONTH(date)) as expe
								//ON fee.date = expe.date
								//)");
								
								if (isset($_POST["submit"])) {
										$from = $this->input->post('from') ?? '';
										$to = $this->input->post('to') ?? '';

										$q = $this->db->query('SELECT fee, admfee, fee.date as date, expe, salary
FROM (
(SELECT SUM(fee) as fee, date FROM admission_info where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '"group by date) as fee
LEFT JOIN
(SELECT SUM(paid) as admfee, date_of_payment as date FROM fee where DATE(date_of_payment) BETWEEN "' . $from . '"  AND "' . $to . '" group by date_of_payment) as admfee
ON fee.date = admfee.date
LEFT JOIN
(SELECT SUM(amount) as expe, date from expenses where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" group by date) as expe
ON fee.date = expe.date
LEFT JOIN
(SELECT SUM(paid) as salary, date from salary where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" group by date) as salary
ON fee.date = salary.date
)');
										$revdate = json_encode(array_columnn($q->result(), 'date'), JSON_NUMERIC_CHECK);
								}
								else {
										$q = $this->db->query("SELECT fee, admfee, fee.date as date, expe, salary
FROM (
(SELECT SUM(fee) as fee, MONTHNAME(date) as date FROM admission_info where Month(date) = '" . date('m') . "' and Year(date) = '" . date('Y') . "' group by MONTH(date)) as fee
LEFT JOIN
(SELECT SUM(paid) as admfee, MONTHNAME(date_of_payment) as date FROM fee where Month(date_of_payment) = '" . date('m') . "' and Year(date_of_payment) = '" . date('Y') . "' group by MONTH(date_of_payment)) as admfee
ON fee.date = admfee.date
LEFT JOIN
(SELECT SUM(amount) as expe, MONTHNAME(date) as date from expenses where Month(date) = '" . date('m') . "' and Year(date) = '" . date('Y') . "' group by MONTH(date)) as expe
ON fee.date = expe.date
LEFT JOIN
(SELECT SUM(paid) as salary, MONTHNAME(date) as date from salary where Month(date) = '" . date('m') . "' and Year(date) = '" . date('Y') . "' group by MONTH(date)) as salary
ON fee.date = salary.date
)");
										$revdate = json_encode(array_columnn($q->result(), 'date'), JSON_NUMERIC_CHECK);
								}
								
								$qResult2 = $q->result();
								$feeArr = array_columnn($qResult2, 'fee');
								$admfeeArr = array_columnn($qResult2, 'admfee');
								$expeArr = array_columnn($qResult2, 'expe');
								$salaryArr = array_columnn($qResult2, 'salary');

								$fee = json_encode($feeArr, JSON_NUMERIC_CHECK);
								$admfee = json_encode($admfeeArr, JSON_NUMERIC_CHECK);

								$expen = json_encode($expeArr, JSON_NUMERIC_CHECK);
								$revenue = array();
								$expe = array();
								$salary = json_encode($salaryArr, JSON_NUMERIC_CHECK);

								foreach (array_keys($feeArr + $admfeeArr) as
								         $keys) {
										$revenue[$keys] = ($feeArr[$keys] ?? 0) + ($admfeeArr[$keys] ?? 0);
								}
								foreach (array_keys($expeArr + $salaryArr) as
								         $keys) {
										$expe[$keys] = ($expeArr[$keys] ?? 0) + ($salaryArr[$keys] ?? 0);
								}
								$c = array();
								foreach (array_keys($revenue + $expe) as
								         $key) {
										$c[$key] = ($revenue[$key] ?? 0) - ($expe[$key] ?? 0);
								}
								?>

          <script>
            $(function () {


              Highcharts.chart('profit', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Revenue / Expense of Year <?php echo date("F Y")  ?>'
                },
                xAxis: {
                  categories:
																		<?php echo $revdate; ?>,
                  crosshair: true
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Revenue / Expense of Year <?php echo date("F Y")  ?>'
                  }
                },
                tooltip: {
                  headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                  pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                  footerFormat: '</table>',
                  shared: true,
                  useHTML: true
                },
                plotOptions: {
                  column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                  },
                  series: {
                    dataLabels: {
                      enabled: true,
                      format: 'Rs. {y}',
                    }
                  }
                },
                series: [
                  {
                    name: 'Total Revenue',
                    data: <?php echo json_encode($revenue) ?>

                  },

                  {
                    name: 'Total Expenses',
                    data: <?php echo json_encode($expe) ?>

                  },
                  {
                    name: 'Total Balance',
                    data: <?php echo json_encode($c) ?>

                  }


                ]


              });
            });            </script>
						
						<?php
								$courseds = $this->db->query("Select course from trainer_data group by course");

								$date_year = date('Y');
								if (!isset($dates)) { $dates = ''; }
								foreach ($courseds->result() as
								$valds) {
								if(AdminLTE::user_course($valds->course) == 1){
								if (isset($_POST["submit"])) {
							    $dates = $this->input->post('from') ?? '';
            $year_from_date = date('Y', strtotime($dates !== '' ? $dates : 'now')); // Extract year from $dates
										$query = $this->db->query("Select * from trainer_data where course = $valds->course and YEAR(date) = $year_from_date and WEEKOFYEAR(date)= WEEKOFYEAR('$dates') group by regno order by percentage DESC");
										
								}
								else {
										$query = $this->db->query("Select * from trainer_data where course = $valds->course and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1 group by regno order by percentage DESC ");
										
								}
								
								
								
								$name = array();
								$perc = array();
								$totals = array();
								$totalstra = array();
								$trainer_name = "";
								if($query->num_rows() > 0){
										foreach ($query->result() as
										         $value) {
												$trainer_name = AdminLTE::employee_name($value->trainer);
												if (!empty($dates)) {
														$rank = AdminLTE::rank_date($value->regno, $valds->course, $dates);
												}
												else {
														$rank = AdminLTE::rank($value->regno, $valds->course);
												}
												if ($rank <= 3) {
														$name[] = AdminLTE::student_name($value->regno);
														$perc[] = $value->percentage;
														$attend = explode(",", $value->attend ?? '')[0];
														$coop = explode(",", $value->coop ?? '')[0];
														$pre = explode(",", $value->pre ?? '')[0];
														$part = explode(",", $value->part ?? '')[0];
														$ling = explode(",", $value->ling ?? '')[0];
														$punc = explode(",", $value->punc ?? '')[0];
														$marks = $value->marks;
														$tmarks = $value->tmarks;
														
														
														$totals[] = (($attend + $coop + $pre + $part + $ling + $punc) / 600) * 60;
														$totalstra[] = ($tmarks != 0) ? ($marks / $tmarks) * 40 : 0;
												}
												
										}
										
								}
						
						?>

          <script>
            $(function () {
              Highcharts.chart('stra<?php echo $valds->course ?>', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Top 3 Students in Course <?php echo AdminLTE::student_course($valds->course). "(". $trainer_name .")" ?>'
                },
                xAxis: {
                  categories:
																		<?php echo json_encode($name) ?>
                  ,
                  crosshair: true
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Top 3 Students'
                  }
                },
                tooltip: {
                  headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                  pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                  footerFormat: '</table>',
                  shared: true,
                  useHTML: true
                },
                plotOptions: {
                  column: {
                    pointPadding: 0.1,
                    borderWidth: 0
                  },
                  series: {
                    dataLabels: {
                      enabled: true,
                      format: '{y} %'
                    }
                  }
                },
                series: [{
                  name: 'Skills',
                  data: <?php echo json_encode($totals);
																		?>

                }, {
                  name: '<?php echo isset($value) ? ($value->stra ?? '') : '' ?>',
                  data: <?php echo json_encode($totalstra); ?>

                }, {

                  name: 'Total Percentage',
                  data: <?php echo json_encode($perc, JSON_NUMERIC_CHECK) ?>

                }]


              });
            });                </script>
						<?php }} ?>
						
						
						
						<?php
								$emp_id = $this->db->query("Select emp_id from user where level = 'Trainer' and status = 1");
								$cc = array();
								$totalc = array();
								$date_year = date('Y');
								foreach ($emp_id->result() as $value) {
										$emp = AdminLTE::employee_name($value->emp_id);
										if($emp){
												$cc[] = $emp;
												
												if (isset($_POST["submit"])) {
														$dates = $this->input->post('from') ?? '';
														$que = $this->db->query("Select count(percentage) as countp, SUM(percentage) as pertage from trainer_data where trainer = $value->emp_id and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR('$dates')");
												}
												else {
														$que = $this->db->query("Select count(percentage) as countp, SUM(percentage) as pertage from trainer_data where trainer = $value->emp_id and YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1");
												}
												
												
												foreach ($que->result() as $data) {
														
														$totalp = $data->countp;
														$totalperc = $data->pertage;
														
														if ($totalp == 0) {
																$tt = 0;
														}
														else {
																$tt = round($totalperc / $totalp);
														}
														$totalc[] = $tt;
												}
										}
								}
						?>

          <script>
            $(function () {
              Highcharts.chart('teacher', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Top 3 Trainers'
                },
                xAxis: {
                  categories:
																		<?php echo json_encode($cc); ?>
                  ,
                  crosshair: true
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Top 3 Trainers'
                  }
                },
                tooltip: {
                  headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                  pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                  footerFormat: '</table>',
                  shared: true,
                  useHTML: true
                },
                plotOptions: {
                  column: {
                    pointPadding: 0.1,
                    borderWidth: 0
                  },
                  series: {
                    dataLabels: {
                      enabled: true,
                      format: '{y} %'
                    }
                  }
                },
                series: [{
                  name: 'Percentage',
                  data: <?php echo json_encode($totalc, JSON_NUMERIC_CHECK);
																		?>

                }]


              });
            });            </script>
						
						
						<?php
								$date_year = date('Y');
								$totalc = array();
								$cc = array();
								if (isset($_POST["submit"])) {
										$dates = $this->input->post('from') ?? '';
										$que = $this->db->query("Select regno, percentage from trainer_data where YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR('$dates') order by percentage DESC");
								}
								else {
										if (!isset($dates)) { $dates = ''; }
										$que = $this->db->query("Select regno, percentage from trainer_data where YEAR(date) = $date_year and WEEKOFYEAR(date)=WEEKOFYEAR(CURDATE()) - 1 order by percentage DESC");
								}


								foreach ($que->result() as
								         $data) {
										$cc[] = AdminLTE::student_name($data->regno);
										if (!empty($dates)) {
												$rank = AdminLTE::rank_date_ydi($data->regno, $dates);
										}
										else {
												$rank = AdminLTE::rank_ydi($data->regno);
										}
										if ($rank <= 3) {
												
												$totalc[] = $data->percentage;;
										}
								}
						
						
						?>

          <script>
            $(function () {
              Highcharts.chart('student', {
                chart: {
                  type: 'column'
                },
                title: {
                  text: 'Top 3 Students in YDI'
                },
                xAxis: {
                  categories:
																		<?php echo json_encode($cc); ?>
                  ,
                  crosshair: true
                },
                yAxis: {
                  min: 0,
                  title: {
                    text: 'Top 3 Students in YDI'
                  }
                },
                tooltip: {
                  headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                  pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                  footerFormat: '</table>',
                  shared: true,
                  useHTML: true
                },
                plotOptions: {
                  column: {
                    pointPadding: 0.1,
                    borderWidth: 0
                  },
                  series: {
                    dataLabels: {
                      enabled: true,
                      format: '{y} %'
                    }
                  }
                },
                series: [{
                  name: 'Percentage',
                  data: <?php echo json_encode($totalc, JSON_NUMERIC_CHECK);
																		?>

                }]


              });
            });            </script>
								
								
								<?php
						}
							        $emp_course = $this->db->query("SELECT course_id FROM courses WHERE status = 1");
$c = array();
$total = array();
$reg = array();
$struck = array();
$freez = array();
$pend = array();
	$date_month = date('m');
								$date_year = date('Y');

foreach ($emp_course->result() as $value) {
    $c[] = AdminLTE::student_course($value->course_id);

    $query = $this->db->query("SELECT 
                                    (SELECT COUNT(*) AS total FROM student WHERE course = $value->course_id) AS total,
                                    (SELECT COUNT(*) AS reg FROM student WHERE course = $value->course_id AND status = 1) AS regular,
                                    (SELECT COUNT(*) AS struck FROM student WHERE course = $value->course_id AND status = 2) AS struck,
                                    (SELECT COUNT(*) AS freez FROM student WHERE course = $value->course_id AND status = 3) AS freez,
                                    (SELECT COUNT(*) AS pending FROM student WHERE course = $value->course_id AND status = 0) AS pending");

    foreach ($query->result() as $data) {
        if ($data->total > 0) {
            $total[] = $data->total;
            $reg[] = $data->regular;
            $struck[] = $data->struck;
            $freez[] = $data->freez;
            $pend[] = $data->pending;
        }
    }
}
						?>
        <script>
          $(function () {
            Highcharts.chart('course', {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Students in Courses'
              },
              xAxis: {
                categories:
																<?php echo json_encode($c) ?>
                ,
                crosshair: true
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Students in Courses'
                }
              },
              tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },
              plotOptions: {
                column: {
                  pointPadding: 0.1,
                  borderWidth: 0
                },
                series: {
                  dataLabels: {
                    enabled: true,
                    format: '{y}'
                  }
                }
              },
              series: [{
                name: 'Total No. of Students',
                data: <?php echo json_encode($total, JSON_NUMERIC_CHECK);
																?>

              },
                {
                  name: 'Regular Students',
                  data: <?php echo json_encode($reg, JSON_NUMERIC_CHECK);
																		?>

                },
                {
                  name: 'Struckoff Students ',
                  data: <?php echo json_encode($struck, JSON_NUMERIC_CHECK);
																		?>

                }, {
                  name: 'Freeze Students',
                  data: <?php echo json_encode($freez, JSON_NUMERIC_CHECK);
																		?>

                },
                {
                  name: 'Pending Students ',
                  data: <?php echo json_encode($pend, JSON_NUMERIC_CHECK);
																		?>

                }]


            });
          });        </script>

        <script>
          $(function () {

            Highcharts.chart('expenses', {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Expenses Detail of  <?php echo date("Y") ?>'
              },
              xAxis: {
                categories:
																<?php
																if (isset($_POST["submit"])) {
																		$from = $this->input->post('from') ?? '';
																		$to = $this->input->post('to') ?? '';
																		$qc = $this->db->query('SELECT date, date as month from expenses where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" group by date');
																}
																else {
																		$qc = $this->db->query("SELECT MONTHNAME(date) as date, MONTH(date) as month from expenses group by MONTH(date)");
																}
																$qcResult = $qc->result();
																echo json_encode(array_columnn($qcResult, 'date'), JSON_NUMERIC_CHECK);
																?>,
                crosshair: true
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Expenses Detail'
                }
              },
              tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },
              plotOptions: {
                column: {
                  pointPadding: 0.1,
                  borderWidth: 0
                },
                series: {
                  dataLabels: {
                    enabled: true,
                    format: 'Rs. {y}'
                  }
                }
              },
              series: [
																<?php
																$qs = $this->db->query("select * from expense_names");
																$dated = array_columnn($qcResult, 'month');
																$rupee = array();
																foreach ($qs->result() as
																$v) {
																foreach ($dated as
																         $dd) {
																		if (isset($_POST["submit"])) {
																				$from = $this->input->post('from') ?? '';
																				$to = $this->input->post('to') ?? '';
																				$qcc = $this->db->query('SELECT SUM(amount) as total from expenses where exp_id = "' . $v->id . '" and date = "' . $dd . '"  group by date');
																		}
																		else {
																				$qcc = $this->db->query("SELECT SUM(amount) as total from expenses where exp_id = $v->id and MONTH(date) = $dd and YEAR(date) = '" . date("Y") . "'");
																		}
																		$va = $qcc->row();
																		if (!$va || $va->total == NULL) {
																				$rupee[] = 0;
																		}
																		else {
																				$rupee[] = $va->total;
																		}
																}
																?>
                {
                  name: '<?php echo AdminLTE::exp_name($v->id) ?>',
                  data: <?php echo json_encode($rupee, JSON_NUMERIC_CHECK) ?>

                },
																<?php
																unset($rupee);
																$rupee = array();
																}
																?>



              ]




            });
          });            </script>
						<?php
								$deposit = array();
								$depdate = array();
								if (isset($_POST["submit"])) {
										$from = $this->input->post('from') ?? '';
										$to = $this->input->post('to') ?? '';
										$dq = $this->db->query('Select SUM(amount) as deposit, date from bank where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" group by date');
								}
								else {
										$dq = $this->db->query("Select SUM(amount) as deposit, MONTHNAME(date) as date from bank where Month(date) = '" . date('m') . "' and Year(date) = '" . date('Y') . "' group by MONTH(date)");
								}
								
								foreach ($dq->result() as
								         $bankdata) {
										$deposit[] = $bankdata->deposit;
										
										$depdate[] = $bankdata->date;
								}
						?>

        <script>
          $(function () {

            Highcharts.chart('bank', {
              chart: {
                type: 'column'
              },
              title: {
                text: 'Bank Details of  <?php echo date("F Y") ?>'
              },
              xAxis: {
                categories:
																<?php echo json_encode($depdate); ?>,
                crosshair: true
              },
              yAxis: {
                min: 0,
                title: {
                  text: 'Bank Details '
                }
              },
              tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
              },
              plotOptions: {
                column: {
                  pointPadding: 0.1,
                  borderWidth: 0
                },
                series: {
                  dataLabels: {
                    enabled: true,
                    format: 'Rs. {y}'
                  }
                }
              },
              series: [
                {
                  name: 'Deposit Amount',
                  data: <?php echo json_encode($deposit, JSON_NUMERIC_CHECK) ?>

                },
              ]




            });
          });


        </script>
    </div>
</div>






