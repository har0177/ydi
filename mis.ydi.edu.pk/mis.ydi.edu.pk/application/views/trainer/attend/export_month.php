

<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading; ?> Attendance
        <span>     <a href="<?php echo site_url('trainer'); ?>" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
            <a href="#" id="export" class="btn btn-sm btn-success pull-right">  
                <i class="ace-icon fa fa-database"></i> Export to Excel</a>
           


        </span>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Manage <?php echo $heading; ?> Attendance of the Month <?php echo date('F') . " - " . date('Y'); ?>
        </div>
       

            <table id="dyntableExport" class="table table-bordered table-condensed">
                
                    <thead>

                       
                        <tr>
                            <th>S.NO </th>
                            <th>Name</th>
                            <th>Roll No</th>

    <?php for ($th = 01; $th <= 31; $th++) { ?>
                                <th> <?php if ($th < 10) {
            echo('0' . $th);
        } else {
            echo($th);
        } ?> </th>
    <?php }//end for loop  ?>
                                <th> P </th><th> A </th><th> L </th><th> N/A </th>
                        </tr>
                    </thead>
                    <?php
                    $i = 1;
                   foreach ($result as $r) {
                        $id = $r->reg_no;
                        $hazir = 0;
                        $bemar = 0;
                        $ghairHazir = 0;
                        $rokhsat = 0;
                        $mezaan = '';
                        $na = 0;
                        ?>
                        <tbody>


                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo ucwords(strtolower($r->name ?? '')); ?></td>
                                <td><?php echo $id; ?></td>

                                <?php
                                for ($k = 01; $k <= 31; $k++) {


                                    $this->db->select('status');
       $array = array('course_id' => $r->course, 'std_id' => $id, 'Day(date)' => $k, 'Month(date)' => date('m'), 'Year(date)' => date('Y'));
                                    $this->db->where($array);
                                    $query = $this->db->get('attend');
                                    if ($query->num_rows() > 0) {
                                        $ttend = $query->result();
                                        foreach ($ttend as $status) {

                                            echo "<td>";

                                            if ($status->status == 1) {
                                                echo $att = ('<span class="badge badge-success">P</span>');
                                                ?>

                                                <?php
                                                $hazir += 1;
                                            } else if ($status->status == 2) {
                                                echo $att = ('<span class="badge badge-warning">A</span>');
                                                ?>

                                                <?php
                                                $ghairHazir += 1;
                                            } else if ($status->status == 3) {
                                                echo $att = ('<span class="badge badge-yellow">L</span>');
                                                ?>

                                                <?php
                                                $rokhsat += 1;
                                            }  else if ($status->status == 4) {
                                                echo $att = ('<span class="badge badge-red">N/A</span>');
                                                ?>

                                                <?php
                                                $na += 1;
                                            }
                                        }
                                        echo"</td>";
                                    } else {
                                        ?>
                                        <td> </td> 
                                        <?php
                                    }
                                }
                                echo "<td> $hazir </td><td> $ghairHazir </td> <td> $rokhsat </td><td> $na </td>";
                                ?>
                            </tr>

                        </tbody>
                        <?php
                        $i++;
                    }
                
                ?>
            </table> 

        </div>
    </div>
