<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?>
        <span> <a href="<?php echo site_url( 'admin/fee/create' ); ?>" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-plus-square"></i> Add Fee for Whole Courses</a>
            <a href="<?php echo site_url( 'admin/fee/print_all' ); ?>" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-file-pdf-o"></i> Save to PDF</a>
                <a href="<?php echo site_url( 'admin/fee/sms' ); ?>" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-phone-square"></i> Send SMS to Unpaid Students</a>
                <a href="<?php echo site_url( 'admin/fee/single' ); ?>" class="btn btn-sm btn-success pull-right">
                <i class="ace-icon fa fa-plus-circle"></i> Add Single Fee</a>

        </span>
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
                    <th>Rec No</th>
                    <th>Month / Year</th>
                    <th>Registration No</th>
                    <th>Name</th>

                    <th>Monthly Fee</th>
                    <th>Dues</th>
                    <th>Date of Payment</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                <?php
                $i = 1;
                foreach( $result as $r ) {
                  ?>
                    <tr>
                        <td> <?php echo $i ?></td>
                        <td><?php echo $r->rec_no ?></td>
                        <td><?php if( $r->status_1p == 1 ) {
                            echo AdminLTE::month( $r->month ) . " - " . $r->year . " - " . "1st Time Payment";
                          } else {
                            echo AdminLTE::month( $r->month ) . " - " . $r->year;
                          } ?></td>
                        <td><?php echo $r->reg_no; ?></td>
                        <td><?php echo ucwords( strtolower( AdminLTE::student_data( $r->reg_no, "name" ) ) ); ?></td>


                        <td><?php echo $r->monthly ?></td>
                        <td><?php echo $r->dues ?></td>
                        <td><?php echo dateformatesformysql_fata( $r->date_of_payment ); ?></td>


                      <?php
                      if( $r->status == '1' ) {
                        echo "<td><span class='label label-large label-success'>Paid</span></td>";
                        ?>
                          <td>
                              <div class="hidden-sm action-buttons">
                                  <a title="Print Fee" class="light-blue2"
                                     href="<?php echo site_url( 'admin/fee/printform/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-print bigger-130"></i>
                                  </a>

                                  <a title="Delete Fee" class="red"
                                     onclick="return confirm('Are You Sure Want to Delete it?');"
                                     href="<?php echo site_url( 'admin/fee/delete/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                  </a>
                              </div>

                          </td>
                        <?php
                      } elseif( $r->status == '0' ) {
                        echo "<td><span class='label label-large label-info'>Unpaid</span></td>";
                        ?>
                          <td>
                              <div class="hidden-sm action-buttons">
                                  <a title="Print Fee" class="light-blue2"
                                     href="<?php echo site_url( 'admin/fee/printform/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-print bigger-130"></i>
                                  </a>
                                  <a title="Paid Fee" class="green"
                                     href="<?php echo site_url( 'admin/fee/paid/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-paypal bigger-130"></i>
                                  </a>

                                  <a title="Partial Paid Fee" class="light-red"
                                     href="<?php echo site_url( 'admin/fee/fee_partial/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-money bigger-130"></i>
                                  </a>

                                  <a title="Update Fee" class="grey"
                                     href="<?php echo site_url( 'admin/fee/edit/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-pencil bigger-130"></i>
                                  </a>

                                  <a title="Delete Fee" class="red"
                                     onclick="return confirm('Are You Sure Want to Delete it?');"
                                     href="<?php echo site_url( 'admin/fee/delete/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                  </a>
                              </div>

                          </td>
                        <?php
                      } elseif( $r->status == '2' ) {
                        echo "<td><span class='label label-large label-danger'>Dues Added to New Month</span></td>";
                        ?>
                          <td>
                              <div class="hidden-sm action-buttons">
                                  <a title="Print Fee" class="light-blue2"
                                     href="<?php echo site_url( 'admin/fee/printform/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-print bigger-130"></i>
                                  </a>

                                  <a title="Delete Fee" class="red"
                                     onclick="return confirm('Are You Sure Want to Delete it?');"
                                     href="<?php echo site_url( 'admin/fee/delete/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                  </a>
                              </div>

                          </td>
                        <?php
                      } else {
                        echo "<td><span class='label label-large label-default'>Partially Paid</span></td>";
                        ?>
                          <td>
                              <div class="hidden-sm action-buttons">
                                  <a title="Print Fee" class="light-blue2"
                                     href="<?php echo site_url( 'admin/fee/printform/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-print bigger-130"></i>
                                  </a>

                                  <a title="Delete Fee" class="red"
                                     onclick="return confirm('Are You Sure Want to Delete it?');"
                                     href="<?php echo site_url( 'admin/fee/delete/' . $r->id ) ?>">
                                      <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                  </a>
                              </div>

                          </td>
                        <?php
                      }
                      ?>

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