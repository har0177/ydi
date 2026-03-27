
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Manage <?php echo $heading; ?>
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->
        <div>

            <table id="" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Image</th>
                        <th>Course</th>
                        <th>Registration No</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Status</th>
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
                            <td class="hidden-480">
                                <?php if ($r->img == "") {
                                    ?>
                                    <img  width="100" height="100px" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/profile.png'); ?>" />
                                <?php } else {
                                    ?>
                                    <img  width="100" height="100px" alt="<?php echo $r->name ?>" src="<?php echo site_url('images/' . $r->img); ?>" />
                                <?php } ?>
                            </td>
                            <td><?php echo AdminLTE::student_course($r->course) ?></td>
                            <td><?php echo $r->reg_no ?></td>
                            <td><?php echo ucwords(strtolower($r->name)); ?></td>
                            <td><?php echo ucwords(strtolower($r->f_name)); ?></td>

                            </td>


                            <td><?php
                                if ($r->status == '1') {
                                    echo "<span class='label label-large label-success'>Confirmed</span>";
                                } else if ($r->status == '2') {
                                    echo "<span class='label label-large label-warning'>Struck Off</span> <br> $r->comments";
                                } else {
                                    echo "<span class='label label-large label-inverse'>Pending</span>";
                                }
                                ?>	</td>
                            <td>
                                <div class="hidden-sm action-buttons">
    <!--                                    <a title="Print Student Form"  class="light-blue2" href="<?php echo site_url('admin/students/printform/' . $r->id) ?>">
                                        <i class="ace-icon fa fa-print bigger-130"></i>
                                    </a>-->
                                    <?php
                                    $data = AdminLTE::report_info($r->reg_no);

                                    if (empty($data)) {
                                        ?>
                                        <a title="Progress Report" class="green" href="<?php echo site_url('trainer/report/' . $r->reg_no) ?>">
                                            <i class="ace-icon fa fa-pie-chart bigger-130"></i>
                                        </a>
                                        <a title="Progress Report View" class="green" href="<?php echo site_url('trainer/view/' . $r->reg_no) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>
                                    <?php } else {
                                        ?>
                                        <a title="Progress Report View" class="green" href="<?php echo site_url('trainer/view/' . $r->reg_no) ?>">
                                            <i class="ace-icon fa fa-eye bigger-130"></i>
                                        </a>
                                    <?php }
                                    ?>


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
    </div>
</div>

