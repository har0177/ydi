<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Add New <?php echo $heading; ?>
        <a href="<?php echo site_url('admin/accounts'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->
<script type="text/javascript">
    $(document).ready(function () {

        $('#employee').change(function () {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo site_url('admin/accounts/basicsalary'); ?>",
                method: "POST",
                data: {id: id},
                async: true,
                dataType: 'json',
                success: function (data) {
                    $("#salary").val(data.salary);
                     $("#dues").val(data.dues);

                }
            });
            return false;
        });
    });

</script>
<div class="row">
    <div class="col-xs-12">

        <div class="widget-box">
            <div class="widget-body">
                <div class="widget-main">
                    <div id="fuelux-wizard-container">

                        <div class="step-content pos-rel">
                            <?php echo form_open('', ['class' => 'form-horizontal']); ?>

                            <fieldset >    	
                                <legend>Salary Information</legend>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Employee Name</label>

                                    <div class="col-xs-12 col-sm-9">

                                        <select required name="employee" class="select2" id="employee">

                                            <option value="" >Please Select Employee</option>


                                            <?php echo AdminLTE::employees(); ?>


                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Basic Salary:</label>

                                    <div class="col-xs-12 col-sm-4">
                                        <input type="number" min="0" step="any" placeholder="Basic Salary" name="basicsalary" id="salary" disabled=""
                                               class="form-control">
                                    </div>

                                </div>
                                                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Dues:</label>

                                    <div class="col-xs-12 col-sm-4">
                                        <input type="number" min="0" step="any" value="0" name="dues" id="dues" disabled=""
                                               class="form-control">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">This Month Salary:</label>

                                    <div class="col-xs-12 col-sm-4">
                                        <input type="number" min="0" step="any" value="0" name="paid" id="paid"
                                               class="form-control">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Month</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php
                                        $data = array(
                                            'data-placeholder' => "Select Month",
                                            'class' => "select2",
                                            'id' => 'month',
                                            'tabindex' => '-1',
                                            'required' => ''
                                        );

                                        //$options = $tmp;
                                        echo form_dropdown('month', $month, set_value('month'), $data);
                                        ?>
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Year</label>

                                    <div class="col-xs-12 col-sm-9">
                                       <select required name="year" class="select2">

                                <option value="" >Please Select Year </option>


                                <?php echo AdminLTE::years(date('Y')); ?>


                            </select>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Date: </label>

                                    <div class="col-xs-12 col-sm-3">
                                        <input type="text" name="date" value="<?php echo date('Y-m-d'); ?>" class="form-control datepicker"/>
                                    </div>
                                </div>
                                <div class="hr hr-dotted"></div>

                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Add Salary" class="btn btn-lg btn-success">
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
    </div>


</div><!-- /.col -->