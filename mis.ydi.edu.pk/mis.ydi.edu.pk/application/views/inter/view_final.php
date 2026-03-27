<style type = "text/css">
 
      @media print {
        .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    line-height: 1.428571;
    text-align: center;
    font-size: 16px;
}
      }
  
</style><div class="page-header">

    <img src="<?php echo base_url() . 'images/logo.jpg' ?>" width="100px">  <h2 style="text-align: center;">    
        YOUTH DEVELOPMENT INSTITUTE <br>
        English Proficiency Program

    </h2>

</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">

        <table id="" class="table table-striped table-bordered table-responsive">
            <tr>
                <th colspan="4">   TRAINEE'S PROFILE</th>
            </tr>
            <tr><th >Name</th>
                <td style=""><?php echo ucwords(strtolower(AdminLTE::student_name($r->regno))); ?></td>
                <th >Father Name</th>


                <td style=""><?php echo ucwords(strtolower(AdminLTE::student_fname($r->regno))); ?></td>
            </tr>
            <tr>
                <th>Registration No</th>
                <td><?php echo strtoupper($r->regno); ?></td>
                <th>Interview Date</th>
                <td><?php echo strtoupper(dateformatesformysql_fata($r->date)); ?></td>
            </tr>
            <tr>
                <th>EDIR Number</th>
                <td><?php echo strtoupper($r->edir); ?></td>
                <th>Courses & Batch</th>
                <td><?php echo strtoupper(AdminLTE::student_course(AdminLTE::student_data($r->regno, 'course'))); ?>
                </td>

            </tr>

    <tr>
                <th>Interviewer</th>
                <td colspan='3'><?php echo $r->inter_name; ?></td>
             

            </tr>


            <tr>
                <th colspan="4">   TRAINEE’S LINGUAL</th>
            </tr>
            <tr><th >Comprehension</th>
                <td colspan="3" style="text-align: left" style=""><?php echo explode("-", $r->comp)[1]; ?></td>
            </tr>

            <tr><th>Grammar Accuracy</th>
                <td colspan="3" style="text-align: left"><?php echo explode("-", $r->grac)[1]; ?></td>
            </tr>
            <tr><th>Comprehensibility & Pronunciation</th>
                <td colspan="3" style="text-align: left"><?php echo explode("-", $r->compro)[1]; ?></td>
            </tr>

            <tr><th>Fluency</th>
                <td colspan="3" style="text-align: left"><?php echo explode("-", $r->flu)[1]; ?></td>
            </tr>

            <tr><th>Maturity Of Language</th>
                <td colspan="3" style="text-align: left"><?php echo explode("-", $r->mtol)[1]; ?></td>
            </tr>
            <tr><th>Vocabulary</th>
                <td colspan="3" style="text-align: left"><?php echo explode("-", $r->voca)[1]; ?></td>
            </tr>



            <tr>
                <th colspan="4">    BEHAVIORAL INFORMATION</th>
            </tr>
            <tr><th>Greetings/ Farewell</th>
                <td colspan="3" style="text-align: left" style=""><?php echo explode("-", $r->greet)[1]; ?></td>
            </tr>

            <tr><th>Body Language</th>
                <td colspan="3" style="text-align: left"><?php echo explode("-", $r->blang)[1]; ?></td>
            </tr>
            <tr><th>Confidence Level</th>
                <td colspan="3" style="text-align: left"><?php echo explode("-", $r->clevel)[1]; ?></td>
            </tr>


        </table>


          <div class="row">
             <div class="col-sm-8 text-center col-xs-8">
                    <div id="one" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>
        </div>

        <script src="<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
       
<?php
$this->db->select('*');
$this->db->from('student');
$this->db->join('interview', 'interview.regno = student.reg_no');
$this->db->where(array('reg_no' => $r->regno, 'interview.status' => 3));
$query = $this->db->get();

$compre = 0;
$grac = 0;
$comp = 0;
$flu = 0;
$mlang = 0;
$voca = 0;
$greet = 0;
$blang = 0;
$clevel = 0;
$name = "";
foreach ($query->result() as $value) {
    $name = AdminLTE::student_name($value->regno);
    $comp = explode("-", $value->comp)[0];
    $grac = explode("-", $value->grac)[0];
    $flu = explode("-", $value->flu)[0];
    $compre = explode("-", $value->compro)[0];
    $voca = explode("-", $value->voca)[0];
     $mlang = explode("-", $value->mtol)[0];
     $greet = explode("-", $value->greet)[0];
     $blang = explode("-", $value->blang)[0];
     $clevel = explode("-", $value->clevel)[0];
     
    
}
?>
             <script>
                $(function () {
                    Highcharts.chart('one', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'TRAINEE’S LINGUAL &  BEHAVIORAL INFORMATION'
                        },
                        subtitle: {
                            text: 'Source: Engr Haroon Yousaf'
                        },

                        xAxis: {
                            categories: [
                                '<?php echo $name ?>'
                            ],
                            crosshair: true
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'TRAINEE’S LINGUAL &  BEHAVIORAL INFORMATION'
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
                        series: [
                         {
                                name: 'Total',
                                data: [
100
                                ]

                            },
                            {
                                name: 'Comprehension',
                                data: [
<?php echo $comp ?>
                                ]

                            },
                             {
                                name: 'Grammar Accuracy',
                                data: [
<?php echo $grac ?>
                                ]

                            },
                             {
                                name: 'Comprehensibility & Pronunciation',
                                data: [
<?php echo $compre ?>
                                ]

                            },
                             {
                                name: 'Fluency',
                                data: [
<?php echo $flu ?>
                                ]

                            },
                             {
                                name: 'Maturity Of Language',
                                data: [
<?php echo $mlang ?>
                                ]

                            },
                             {
                                name: 'Vocabulary',
                                data: [
<?php echo $voca ?>
                                ]

                            },
                             {
                                name: 'Greetings/ Farewell',
                                data: [
<?php echo $greet ?>
                                ]

                            },
                             {
                                name: 'Body Language',
                                data: [
<?php echo $blang ?>
                                ]

                            },
                             {
                                name: 'Confidence Level',
                                data: [
<?php echo $clevel ?>
                                ]

                            }
                 
                        ]


                    });
                });



        </script>


  <b>Comments / Recommendations: </b> <span> <?php echo $r->comments; ?></span>

        <h3 style="font-family: Times"> Recommendations:</h3> 

        <p style="text-align: center"></p>
        <pre style="background: white; border: none; text-align: center">   <b>Signatures:</b> __________________________________________________________________________________   
        Evaluator              Administration                Trainer
        </pre>




    </div>
</div>

