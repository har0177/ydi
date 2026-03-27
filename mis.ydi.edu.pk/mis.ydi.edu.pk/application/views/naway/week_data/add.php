<div class="page-header">
    <h1> 
        <i class="ace-icon fa fa-newspaper-o"></i>
        Weekly Words
        <a href="<?php echo site_url('nawaytakay/all_words'); ?>" class="btn btn-sm btn-success pull-right">  
            <i class="ace-icon fa fa-arrow-circle-o-left"></i> Back</a>
    </h1>
</div><!-- /.page-header -->

<style>
    input[type=text]{
        border: 1px solid lightslategray;
        height: 33px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
          
                            <?php echo form_open('', ['class' => 'form-horizontal']); ?>
                            <fieldset>    	
                                <legend>Add Weekly Words</legend>

                              
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Select Month</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php
                                        $data2 = array(
                                            'data-placeholder' => "Select Month",
                                            'class' => "select2",
                                            'id' => 'month',
                                            'tabindex' => '-1',
                                            'required' => ''
                                        );

                                        //$options = $tmp;
                                        echo form_dropdown('month', $month, set_value('month', date('m')), $data2);
                                        ?>
                                    </div>
                                </div>
                                
                                 <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="status">Select Week</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <?php
                                        $data3 = array(
                                            'class' => "select2",
                                            'id' => 'week',
                                            'tabindex' => '-1',
                                            'required' => ''
                                        );

                                        //$options = $tmp;
                                        echo form_dropdown('week', $weeks, set_value('week', 1), $data3);
                                        ?>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Date:</label>

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="clearfix">
                                            <input type="date" id="name"  name="date" value="<?php echo date("Y-m-d"); ?>" class="col-xs-12 col-sm-4" />

                                        </div>
                                    </div>
                                </div>
<?php 
for($i = 1; $i<= 10; $i++){
?>
                                <div class="form-group">
                                    <label class="control-label col-xs-12 col-sm-2 no-padding-right"><?php echo $i ?>:</label>

                                    <div class="col-xs-12 col-sm-2">
                                        <div class="clearfix">
                                            <input type="text" name="words[]" placeholder="Enter Word" class="col-xs-12 col-sm-12 " />

                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-8">
                                        <div class="clearfix">
                                            <input type="text" name="meaning[]" placeholder="Enter Meaning" class="col-xs-12 col-sm-12 " />

                                        </div>
                                    </div>
                                </div>
<?php } ?>
                                <div class="hr hr-dotted"></div>


                                <div class="form-group">
                                    <div class="col-xs-12 col-sm-4 col-sm-offset-3">
                                        <label>
                                            <input type="submit" name="submit" value="Add Data" class="btn btn-lg btn-success">
                                        </label>
                                    </div>
                                </div>
                            </fieldset>
                            </form>
                            
                            </div>
          
</div>