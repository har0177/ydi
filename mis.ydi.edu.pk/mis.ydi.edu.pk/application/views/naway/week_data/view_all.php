<script src="<?php echo base_url(); ?>dist/highcharts.js"></script>
<script src="<?php echo base_url(); ?>dist/exporting.js"></script>

<div class="widget-box hidden-print">
    <div class="table-header">
        Search Report
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <div id="fuelux-wizard-container">

                <div class="step-content pos-rel">

                    <?php echo form_open('', ['class' => 'form-horizontal']); ?>


                    <div class="form-group">
                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Month</label>



                        <div class="col-xs-12 col-sm-6">
                            <?php
                            $data2 = array(
                                'data-placeholder' => "Select Month",
                                'class' => "select2",
                                'id' => 'month',
                                'tabindex' => '-1',
                                'required' => ''
                            );

                            //$options = $tmp;
                            echo form_dropdown('month', $month, set_value('month', date('m')), $data2);
                            ?>
                        </div>
                        <input type="hidden" name="reg" value="<?php echo $r->regno ?>" class="form-control">

                        <input type="submit" name="submit" value="Search" class="btn btn-sm btn-success">
                    </div>




                    <?php echo form_close(); ?>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
</div>
<style>
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
    
    line-height: 1.8;
  text-align: center;
}
    
    @media print{
      
        .words > tbody > tr > td{
            font-size: 25px;
        }
        .words > tbody > tr > th{
            font-size: 25px;
        }
    }
    .idd > thead > tr >th
    {
        font-size:14px;
        font-weight:bold;
        text-align: left;
        border: 1px solid #4EBC30 !important;
        color: #FFF !important;

        background-color: #4EBC30 !important;
        -webkit-print-color-adjust: exact;
    }
   

    .idd > tbody > tr >td, .idd > tbody > tr >th
    {
        text-align: left;

    }

</style>
<?php
if (isset($_POST['submit'])) {

 $date = $this->input->post('month');
$year = date("Y");
     
            $array = array("MONTH(date)" => $date, "YEAR(date)" => $year);
            $this->db->where($array);
            $q = $this->db->get('report_naway');
            if ($q->num_rows() > 0) {
                $report =  $q->result();
            
            
   
        foreach ($report as
                $rr) {
            ?>

            <div class="page-header">

                <img src="<?php echo base_url() . 'images/logo.jpg' ?>" width="100px">  <h2 style="text-align: center;">
                    YOUTH DEVELOPMENT INSTITUTE <br>
                    NawayTakay Program

                </h2>

            </div><!-- /.page-header -->

            <div class="col-xs-12">

                <table id="" class="table table-striped table-bordered table-responsive" cellspacing="10">
                    <tr>
                        <th colspan="4">   TRAINEE'S PROFILE</th>
                    </tr>
                    <tr><th>Name</th>
                        <td><?php echo ucwords(strtolower(AdminLTE::student_name($rr->regno))); ?></td>
                        <th>Registration No</th>
                        <td><?php echo strtoupper($rr->regno); ?></td>
                    </tr>
                    <tr>
                        <th>EDIR Number</th>
                        <td><?php echo AdminLTE::table_data_onefield("interview", "edir", array(
                "regno" => $rr->regno)) ?></td>
                        <th>Courses & Batch</th>
                        <td><?php $course = AdminLTE::table_data_onefield("student", "course", array(
                        "reg_no" => $rr->regno));

            echo AdminLTE::student_course($course);
            ?></td>

                    </tr>
                    <tr>
                        <th>Trainer</th>
                        <td><?php
            echo $rr->trainer;
            ?>

                        </td>
                        <th>Date</th>
                        <td><?php echo dateformatesformysql_fata($rr->date) ?></td>

                </table>
                 <br>
            <br>
<h3>Strategy used for Evaluation: <?php echo $rr->stra ?> </h3>


                <table class="table table-striped table-bordered table-condensed idd">
                <thead>
                    <tr>
                        <th>
                            Criteria
                        </th>   

                        <th>
                            Obtained Marks
                        </th> 
                        <th>
                            Total Marks
                        </th> 
                        <th>
                            Comments
                        </th> 


                    </tr>

                </thead>
                <tbody>
                    <tr><th style="width: 25%">Learned Vocabulary</th>
                        <td style="width: 15%"><?php echo explode(":", $rr->lc)[0]; ?></td>
                        <td style="width: 10%"><?php echo explode(":", $rr->lc)[1]; ?></td>
                        <td style="width: 55%"><?php echo explode(":", $rr->lc)[2]; ?></td>
                    </tr>
                    <tr><th >Confidence</th>

                        <td><?php echo explode(":", $rr->conf)[0]; ?></td>
                        <td><?php echo explode(":", $rr->conf)[1]; ?></td>
                        <td><?php echo explode(":", $rr->conf)[2]; ?></td>
                    </tr>
                    <tr><th >Sentence Structure</th>
                        <td><?php echo explode(":", $rr->ss)[0]; ?></td>
                        <td><?php echo explode(":", $rr->ss)[1]; ?></td>
                        <td><?php echo explode(":", $rr->ss)[2]; ?></td>
                    </tr>
                    <tr><th >Word Pronunciation</th>
                        <td><?php echo explode(":", $rr->wp)[0]; ?></td>
                        <td><?php echo explode(":", $rr->wp)[1]; ?></td>
                        <td><?php echo explode(":", $rr->wp)[2]; ?></td>
                    </tr>
                    <tr><th >Spelling</th>
                        <td><?php echo explode(":", $rr->sp)[0]; ?></td>
                        <td><?php echo explode(":", $rr->sp)[1]; ?></td>
                        <td><?php echo explode(":", $rr->sp)[2]; ?></td>
                    </tr>


                    <tr>
                        <th colspan="2"> Total Marks</th>
                       
                        <th><?php echo $rr->marks ?></th>
                        <th><?php echo $rr->tmarks ?></th>
                    </tr>
            </table>
                <div class="row">

                    <div id="a_p_t<?php echo $rr->regno ?>" style="min-width: 300px; height: 400px; margin: 0 auto"></div>



                </div>


            </div>
            <?php
            $array = array(
                "date" => $rr->date,
                "regno" => $rr->regno);
            $this->db->where($array);
            $query = $this->db->get('report_naway');


            foreach ($query->result() as
                    $value) {
                ?>
                <script>
                    $(function () {
                        Highcharts.chart('a_p_t<?php echo $rr->regno ?>', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Student Monhtly Report'
                            },
                            xAxis: {
                                categories: [
                                    'Student Monhtly Report'

                                ],
                                crosshair: true
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: '<?php echo AdminLTE::student_name($value->regno) ?>'
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
                                    name: 'Total',
                                    data: [
                                        10
                                    ]

                                }, {
                                    name: 'Learned Vocabulary',
                                    data: [
                <?php echo explode(":", $value->lc)[0] ?>
                                    ]

                                }, {
                                    name: 'Confidence',
                                    data: [
                <?php echo explode(":", $value->conf)[0] ?>
                                    ]

                                }, {
                                    name: 'Sentence Structure',
                                    data: [
                <?php echo explode(":", $value->ss)[0] ?>
                                    ]

                                }, {
                                    name: 'Word Pronunciation',
                                    data: [
                <?php echo explode(":", $value->wp)[0] ?>
                                    ]

                                }, {
                                    name: 'Spellings',
                                    data: [
                <?php echo explode(":", $value->sp)[0] ?>
                                    ]



                                }]


                        });
                    });


                </script>

            <?php } ?>
             <DIV style="page-break-after:always"></DIV>

    <h3>Monthly Words</h3>
    <table id="" class="table table-striped table-bordered table-hover table-condensed words">
        <tr>
            <th>Week</th>
            <th>Words / Meanings</th>
        </tr>
        <tbody>
           

                <?php
                $word = $this->db->query("Select * from week_words where month = MONTH('$rr->date') order by id ASC");
                if ($word->num_rows() > 0) {
                    foreach ($word->result() as
                            $w) {
                        for ($i = 1;
                                $i <= 5;
                                $i++) {



                            if ($w->week == $i) {
                                ?>
 <tr>
                                <th style="vertical-align: middle"><?php echo "Week " . $i ?></th>


                                <td style="text-align: left">
                                <?php
                                for ($j = 0;
                                        $j <= 9;
                                        $j++) {
                                    if (!empty(explode(":", $w->words)[$j])) {
                                        echo $j + 1 . " : " . explode(":", $w->words)[$j] . " / " . explode(":", $w->meanings)[$j] . "<br>";
                                    }
                                }
                                ?>
                                </td>
   </tr>
                    <?php
                }
                ?>


            <?php }
        }
    } ?>

         
        </tbody>
    </table>
 <DIV style="page-break-after:always"></DIV>
            <?php
        }
    }else {

                set_flash_alert("No data Found!", 'danger');
            }
}
            
            ?>