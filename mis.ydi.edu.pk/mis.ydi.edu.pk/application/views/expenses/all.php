<div class="page-header hidden-print">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/expenses/create'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-plus-square"></i> Add New Expense</a>
        <a href="<?php echo site_url('admin/expenses/add_expname'); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-plus-square"></i> Add Expense Type</a>

    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
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
                                    <input type="submit" name="submit" value="Search" class="btn btn-sm btn-success">


                                </div>
                            </div>


                            <?php echo form_close(); ?>

                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div>
            </div>
        </div>

        <?php
        if (isset($_POST["submit"])) {
            $from = $this->input->post('from', TRUE);

            $to = $this->input->post('to', TRUE);

            $dateexp = $this->db->query('Select * from expenses where DATE(date) BETWEEN "' . $from . '"  AND "' . $to . '" order by id ASC');
            if ($dateexp->num_rows() > 0) {
                ?>
            <div class="table-header">
                Expenses from <?php echo dateformatesformysql_fata($from) ?> to <?php echo dateformatesformysql_fata($to) ?>


            </div>
            <!-- div.table-responsive -->
            <!-- div.dataTables_borderWrap -->
            <div>
                <table id="" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Receipt.No</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Comments</th>
                            <th>Date</th>
                                <th>Action</th>
                        </tr>
                    </thead>
        
           <tbody>
                        <?php
                        $i = 1;
                        foreach ($dateexp->result() as
                                $value) {
                            ?>
                            <tr>
                                <td> <?php echo $i ?></td>
                                <td><?php echo $value->rec_no ?></td>
                                <td><?php echo AdminLTE::exp_name($value->exp_id) ?></td>
                                <td><?php echo $value->amount ?></td>
                                <td><?php echo $value->comments ?></td>
                                <td><?php echo dateformatesformysql_fata($value->date); ?></td>

                                <td>
                                    <div class="hidden-sm action-buttons">
                                        <a title="View Expanses Form" class="green" href="<?php echo site_url('admin/expenses/view/' . $value->id) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>

                                        <a title="Update Expanses Form" class="light-grey" href="<?php echo site_url('admin/expenses/edit/' . $value->id) ?>">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>

                                        <a title="Delete Expanses Form" class="red" onclick="return confirm('Are You Sure Want to Delete it?')" href="<?php echo site_url('admin/expenses/delete/' . $value->id) ?>">
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
            </div>
 <?php
                
            }
            else {
                set_flash_alert("No Record Found!", "danger");
                redirect("admin/expenses");
            }
        }
        else {
            ?>
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
                            <th>Receipt.No</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Comments</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($result as
                                $r) {
                            ?>
                            <tr>
                                <td> <?php echo $i ?></td>
                                <td><?php echo $r->rec_no ?></td>
                                <td><?php echo AdminLTE::exp_name($r->exp_id) ?></td>
                                <td><?php echo $r->amount ?></td>
                                <td><?php echo $r->comments ?></td>
                                <td><?php echo dateformatesformysql_fata($r->date); ?></td>


                                <td>
                                    <div class="hidden-sm action-buttons">
                                        <a title="View Expanses Form" class="green" href="<?php echo site_url('admin/expenses/view/' . $r->id) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>

                                        <a title="Update Expanses Form" class="light-grey" href="<?php echo site_url('admin/expenses/edit/' . $r->id) ?>">
                                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                                        </a>

                                        <a title="Delete Expanses Form" class="red" onclick="return confirm('Are You Sure Want to Delete it?')" href="<?php echo site_url('admin/expenses/delete/' . $r->id) ?>">
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
                                                    text: 'Expenses Detail of  <?php echo date("Y") ?>'
                                                },
                                                xAxis: {
                                                    categories:
    <?php
    $qc = $this->db->query("SELECT MONTHNAME(date) as date, MONTH(date) as month from expenses group by MONTH(date)");
    echo json_encode(array_columnn($qc->result(), 'date'), JSON_NUMERIC_CHECK);
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
    $dated = array_columnn($qc->result(), 'month');
    $rupee = array();
    foreach ($qs->result() as
            $v) {
        foreach ($dated as
                $dd) {
            $qcc = $this->db->query("SELECT SUM(amount) as total from expenses where exp_id = $v->id and MONTH(date) = $dd and YEAR(date) = '" . date("Y") . "'");
            $va = $qcc->row();
            if ($va->total == NULL) {
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
    }
    ?>



                                                ]




                                            });
                                        });


                </script>
            </div>

<?php } ?>
    </div>
</div>