<div class="page-header">
    <h1>
        <i class="ace-icon fa fa-user"></i>
        Manage <?php echo $heading ?>

    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
            <?php echo form_open('', ['class' => 'form-horizontal']); ?>
            <fieldset >
                <legend>Add New Expense Type</legend>
                <div class="form-group">
                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Expense Type:</label>

                    <div class="col-xs-12 col-sm-9">
                        <div class="clearfix">
                            <input type="text" id="name" placeholder="Expense Type" value="<?php echo $r->exp_name; ?>" required="" name="exp_name" class="col-xs-12 col-sm-9" />
                        </div>
                    </div>
                </div>

                <div class="hr hr-dotted"></div>


                <div class="form-group">
                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                        <label>
                            <input type="submit" name="submit" value="Add Expense Type" class="btn btn-lg btn-success">
                        </label>
                    </div>
                </div>
            </fieldset>
            </form>
        </div>

    </div>

</div>