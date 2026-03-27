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
                    <th colspan="6">INFORMATION</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo ucwords($r->name); ?></td>
                    <th>Batch Name</th>
                    <td><?php echo ucwords($r->batch); ?></td>
             
                    <th>Date</th>
                    <td><?php echo $r->date; ?></td>
                </tr>
                <tr>
                    <th colspan="6">TRAINING OBSERVATION FORM</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th colspan="2">HOW NICELY THE TRAINERS DEAL WITH LATECOMERS?</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->one)[1]; ?></td>
                </tr>
                  <tr>
                    <th>2</th>
                    <th colspan="2">HOW THE TRAINER INTRODUCED OBJECTIVES OF THE SESSION ?</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->two)[1]; ?></td>
                </tr>
                  <tr>
                    <th>3</th>
                    <th colspan="2">HOW HE/SHE STARTED THE SESSION (ICEBREAKER)?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->three)[1]; ?></td>
                </tr>
                  <tr>
                    <th>4</th>
                    <th colspan="2">HOW HE/SHE ENGAGED ALL STUDENTS?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->four)[1]; ?></td>
                </tr>
                  <tr>
                    <th>5</th>
                    <th colspan="2">WHAT KIND OF AV AIDS DID HE/SHE USE FOR TEACHING?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->five)[1]; ?></td>
                </tr>
                  <tr>
                    <th>6</th>
                    <th colspan="2">HOW MUCH IS THE RATIO OF STUDENT TALKING TIME AND TRAINER TALKING TIME IN THE SESSION?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->six)[1]; ?></td>
                </tr>
                  <tr>
                    <th>7</th>
                    <th colspan="2">HOW HE/SHE APPRECIATED ENCOURAGED THE TRAINEES?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->seven)[1]; ?></td>
                </tr>
                  <tr>
                    <th>8</th>
                    <th colspan="2">WHAT KIND OF ENERGIZERS DID HE/SHE USE FOR CREATING A CONDUCIVE ENVIRONMENT?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->eight)[1]; ?></td>
                </tr>
                  <tr>
                    <th>9</th>
                    <th colspan="2">HOW THE TRAINER ASSIGNED HOMEWORK?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->nine)[1]; ?></td>
                </tr>
                  <tr>
                    <th>10</th>
                    <th colspan="2">HOW HE/SHE ENGAGED SLOW LEARNERS?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->ten)[1]; ?></td>
                </tr>
                  <tr>
                    <th>11</th>
                    <th colspan="2">DID HE PREPARE LESSON PLAN AND HOW DID HE EXECUTE IT?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->eleven)[1]; ?></td>
                </tr>
                  <tr>
                    <th>12</th>
                    <th colspan="2">HOW DID HE EMPLOYED STRATEGIES TO ACHIEVE THE SESSION OBJECTIVES?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->twelve)[1]; ?></td>
                </tr>
                  <tr>
                    <th>13</th>
                    <th colspan="2">HOW PROFICIENT IS THE TRAINER IN TERMS OF FLUENCY, PRONUNCIATION, SENTENCE STRUCTURE AND UNDERSTANDING OF THE TOPIC?
</th>
                    <td colspan="3" style="text-align: left;"><?php echo explode("-", $r->thirteen)[1]; ?></td>
                </tr>
                
            </table>
        </div>
    </div>
    
    
          <div class="row">
             <div class="col-sm-12 text-center col-xs-12">
                    <div id="one" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>
        </div>

        <script src="<?php echo base_url(); ?>dist/highcharts.js"></script>
        <script src="<?php echo base_url(); ?>dist/exporting.js"></script>
    
    <?php
    
     $name = $r->name;
  $one = explode("-", $r->one)[0];
$two = explode("-", $r->two)[0];
$three = explode("-", $r->three)[0];
$four = explode("-", $r->four)[0];
$five = explode("-", $r->five)[0];
$six = explode("-", $r->six)[0];
$seven = explode("-", $r->seven)[0];
$eight = explode("-", $r->eight)[0];
$nine = explode("-", $r->nine)[0];
$ten = explode("-", $r->ten)[0];
$eleven = explode("-", $r->eleven)[0];
$twelve = explode("-", $r->twelve)[0];
$thirteen = explode("-", $r->thirteen)[0];
     
     
    ?>
    
            <script>
                $(function () {
                    Highcharts.chart('one', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'TRAINING OBSERVATION'
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
                                text: 'TRAINING OBSERVATION'
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
    name: 'Q1',
    data: [
        <?php echo $one; ?>
    ]
},
{
    name: 'Q2',
    data: [
        <?php echo $two; ?>
    ]
},
{
    name: 'Q3',
    data: [
        <?php echo $three; ?>
    ]
},
{
    name: 'Q4',
    data: [
        <?php echo $four; ?>
    ]
},
{
    name: 'Q5',
    data: [
        <?php echo $five; ?>
    ]
},
{
    name: 'Q6',
    data: [
        <?php echo $six; ?>
    ]
},
{
    name: 'Q7',
    data: [
        <?php echo $seven; ?>
    ]
},
{
    name: 'Q8',
    data: [
        <?php echo $eight; ?>
    ]
},
{
    name: 'Q9',
    data: [
        <?php echo $nine; ?>
    ]
},
{
    name: 'Q10',
    data: [
        <?php echo $ten; ?>
    ]
},
{
    name: 'Q11',
    data: [
        <?php echo $eleven; ?>
    ]
},
{
    name: 'Q12',
    data: [
        <?php echo $twelve; ?>
    ]
},
{
    name: 'Q13',
    data: [
        <?php echo $thirteen; ?>
    ]
},
                        
                 
                        ]


                    });
                });



        </script>


</body>
</html>
