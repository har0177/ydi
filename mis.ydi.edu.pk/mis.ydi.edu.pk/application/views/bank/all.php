<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/bank/create'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-plus-square"></i> Add New Bank Details</a>
        

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Manage <?php echo $heading; ?>
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>
            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Amount</th>
                        <th>Comments</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $r) {
                        ?>
                        <tr>
                            <td> <?php echo $i ?></td>
                           
                            <td><?php echo $r->amount ?></td>
                            <td><?php echo $r->comments ?></td>
                            <td><?php echo dateformatesformysql_fata($r->date); ?></td>


                            <td>
                                <div class="hidden-sm action-buttons">
                                    <a title="View Bank Form" class="green" href="<?php echo site_url('admin/bank/view/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-eye bigger-130"></i>
                                    </a>

                                    <a title="Update Bank Form" class="light-grey" href="<?php echo site_url('admin/bank/edit/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                    <a title="Delete Bank Form" class="red" onclick="return confirm('Are You Sure Want to Delete it?')" href="<?php echo site_url('admin/bank/delete/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>

                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12 text-center col-xs-12">
                    <div id="reg" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
                </div>

            </div>

            <script src="<?php echo base_url(); ?>dist/highcharts.js"></script>
            <script src="<?php echo base_url(); ?>dist/exporting.js"></script>

            <script>
                                        $(function () {

                                            Highcharts.chart('reg', {
                                                chart: {
                                                    type: 'column'
                                                },
                                                title: {
                                                    text: 'Bank Details of  <?php echo date("Y") ?>'
                                                },
                                                xAxis: {
                                                    categories:
<?php
$qc = $this->db->query("SELECT MONTHNAME(date) as date, MONTH(date) as month from bank group by MONTH(date)");
echo json_encode(array_columnn($qc->result(), 'date'), JSON_NUMERIC_CHECK);
?>,
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
<?php

$dated = array_columnn($qc->result(), 'month');
$rupee = array();

    foreach ($dated as $dd) {
         $qcc = $this->db->query("SELECT SUM(amount) as total from bank where MONTH(date) = $dd and YEAR(date) = '".  date("Y")."'");
        $va = $qcc->row();
        if ($va->total == NULL) {
            $rupee[] = 0;
        } else {
            $rupee[] = $va->total;
        }
    }
    ?>
                                                        {
                                                            name: 'Deposit Amount',
                                                            data: <?php echo json_encode($rupee, JSON_NUMERIC_CHECK) ?>

                                                        },
    <?php
    unset($rupee);

?>



                                                ]




                                            });
                                        });


            </script>
        </div>
    </div>
</div>