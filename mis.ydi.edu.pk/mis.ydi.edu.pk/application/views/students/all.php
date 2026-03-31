<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <a href="<?php echo site_url( 'admin/students/create' ); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-plus-square"></i> Add New</a>
        <!--        <a href="<?php echo site_url( 'admin/students/print_all' ); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-file-pdf-o"></i> Save to PDF</a>-->
        <a href="<?php echo site_url( 'admin/register' ); ?>" class="btn btn-sm btn-success pull-right">
            <i class="ace-icon fa fa-money"></i> Registration Fee</a>

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">

        <div class="widget-box hidden-print">
            <div class="table-header">
                Search Students by Status
            </div>
            <div class="widget-body">
                <div class="widget-main">

                    <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">

                          <?php echo form_open( '', [ 'class' => 'form-horizontal' ] ); ?>

                            <div class="form-group">

                                <div class="col-xs-12 col-sm-4">

                                  <?php
                                  $data = [
                                    'data-placeholder' => "Select Student Status",
                                    'class'            => "select2",
                                    'id'               => 'status',
                                    'tabindex'         => '-1',
                                    'required'         => ''
                                  ];

                                  echo form_dropdown( 'status', $status, set_value( 'status', 1 ), $data );
                                  ?>
                                </div>

                                <div class="col-xs-12 col-sm-4">

                                    <select required name="course" class="select2">

                                        <option value="all">All Courses</option>


                                      <?php echo AdminLTE::courses(); ?>

                                    </select>

                                </div>

                                <div class="col-xs-12 col-sm-2" style="text-align: right">
                                    <input type="submit" name="submit" value="Search" class="btn btn-sm btn-success">


                                </div>
                            </div>


                          <?php echo form_close(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-header">
            Manage <?php echo $heading; ?>
        </div>
        <!-- div.table-responsive -->
        <!-- div.dataTables_borderWrap -->

        <div>


            <div class="modal fade" id="switch_modal" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button title="Close" type="button" class="close dark-opaque" data-dismiss="modal">
                                <i class="ace-icon fa fa-close bigger-130"></i>
                            </button>

                            <h4 class="modal-title">Password Authentication</h4>
                        </div>
                        <div class="modal-body">
                          <?php echo form_open( 'admin/students/delete', [ 'class' => 'form-horizontal' ] ); ?>
                            <div class="form-group">
                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Password:</label>

                                <div class="col-xs-12 col-sm-9">
                                    <div class="clearfix">
                                        <input type="hidden" id="regno" name="regno" class="col-xs-12 col-sm-9"/>

                                        <input type="password" id="name" required="" name="password"
                                               class="col-xs-12 col-sm-9"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                    <label>
                                        <input type="submit" name="submit" value="Delete Student"
                                               class="btn btn-lg btn-success">
                                    </label>
                                </div>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <table id="dyntable" class="table table-striped table-bordered table-hover">

                <thead>
                <tr>
                    <th>S.No</th>
                    <th>Course</th>
                    <th>Reg No</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php

                //$status = $this->input->post('status');
                //$q = $this->db->query("SELECT * from student where status = '" . $status . "'");
                // $q = $this->db->query("SELECT * from student order by id asc");

                $i = 1;
                foreach( $result as $r ) {
                  ?>
                    <tr>
                        <td> <?php echo $i ?></td>
                        <td><?php echo AdminLTE::student_course( $r->course ) ?></td>
                        <td><?php echo $r->reg_no ?></td>
                        <td><?php echo date( "d-m-Y", strtotime( $r->do_admission ) ) ?></td>
                        <td><?php echo ucwords( strtolower( $r->name ?? '' ) ); ?></td>
                        <td><?php echo ucwords( strtolower( $r->f_name ?? '' ) ); ?></td>
                        <td><?php echo $r->contact ?></td>
                        <td><?php
                          if( $r->status
                              == '1' ) {
                            echo "<span class='label label-large label-success'>Confirmed</span>";
                          } elseif( $r->status
                                    == '2' ) {
                            echo "<span class='label label-large label-warning'>Struck Off</span> <br> $r->comments";
                          } elseif( $r->status
                                    == '3' ) {
                            echo "<span class='label label-large label-yellow'>Freeze</span>";
                          } else {
                            echo "<span class='label label-large label-inverse'>Pending</span>";
                          }
                          ?>    </td>
                        <td>
                            <div class="hidden-sm action-buttons">
                                <a title="Account Statement" class="light-blue2"
                                   href="<?php echo site_url( 'admin/students/account/' . $r->id ) ?>">
                                    <i class="ace-icon fa fa-dollar bigger-130"></i>
                                </a>
                               <!-- <a title="Print Student Form" class="light-blue2"
                                   href="<?php /*echo site_url( 'admin/students/printform/' . $r->id ) */?>">
                                    <i class="ace-icon fa fa-print bigger-130"></i>
                                </a>-->

                                <a title="View Student Form" class="green"
                                   href="<?php echo site_url( 'admin/students/view/' . $r->id ) ?>">
                                    <i class="ace-icon fa fa-eye bigger-130"></i>
                                </a>

                                <a title="Update Student Form" class="grey"
                                   href="<?php echo site_url( 'admin/students/edit/' . $r->id ) ?>">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>
                                <!-- <a title="Student SLC" class="grey" href="<?php echo site_url( 'admin/students/slc/' . $r->reg_no ) ?>">
                                        <i class="ace-icon fa fa-certificate bigger-130"></i>
                                    </a>
                                   !-->
                                <!--                                    <a title="Student Card" class="blue" href="<?php echo site_url( 'admin/students/card/' . $r->reg_no ) ?>">
                                        <i class="ace-icon fa fa-picture-o bigger-130"></i>
                                    </a>-->
                                <a title="Send SMS" class="purple"
                                   href="<?php echo site_url( 'admin/students/sms/' . $r->reg_no ) ?>">
                                    <i class="ace-icon fa fa-phone-square bigger-130"></i>
                                </a>
                                <a title="Delete Student" class="red" href='#switch_modal' data-toggle='modal'
                                   data-id='<?php echo $r->reg_no; ?>'>
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
    </div>
</div>


<script>
  $(document).ready(function () {
    $('#switch_modal').on('show.bs.modal', function (e) {
      var regno = $(e.relatedTarget).data('id')
      document.getElementById('regno').value = regno//Show fetched data
    })
  })
</script>