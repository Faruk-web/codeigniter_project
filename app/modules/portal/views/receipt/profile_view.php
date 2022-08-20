<div class="tab-pane active">

                <div class="box-body">
                    <?php echo form_open_multipart($route.qString(),'class="form-horizontal"'); ?>
                    <div class="col-md-8">
                        <div class="form-group <?php echo (form_error('membership_number')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Member Name</label>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="membership_number" id="membership_number" value="">
                                    <label class="input-group-addon">
                                        <input type="checkbox" name="new" id="new" value="1" > New Member
                                    </label>
                                </div>
                            </div>
                            
                        </div>

                        <div class="form-group <?php echo (form_error('month_period')!='')?'has-error has-danger':''; ?>">
                            <label class="control-label col-sm-3 required">Member Profile</label>
                            <div class="col-sm-9">
                            <input type="file" class="form-control" name="membership_number" id="membership_number" value="">
                               
                                </select>
                            </div>
                           
                        </div>
                        <div class="col-sm-3">
                                <div class="input-group">
                                <button type="button" class="btn btn-secondary">Secondary</button>
                                   
                                </div>
                            </div>
                      
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>