  

<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Payment Details of <?php echo $name ?>
        </div>

        <div>
            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
            </div>
            <table id="dyntable" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Sr. No</th>
                        <th>Month / Year</th>
                        <th >Paid</th>
                        <th >Dues</th>	

                        <th >Date</th>

                    </tr>
                </thead>

                <tbody>
                    <?php
                    $i = 1;

                    foreach ($book as
                            $r) {
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
<td ><?php echo date("F",strtotime($r->date)) . " / " . date("Y",strtotime($r->date)); ?></td>
                            <td ><?php echo $r->paid ?></td>
                            <td ><?php echo $r->dues ?></td>
                            
                            <td ><?php echo $r->date ?></td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>