
<!-- start edit modal -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding-left: 38px;">                                 
                <form class="update-modal">
                    <input type="hidden" id="edit_id" name="edit_id">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">First Name</label>
                            <div class="col-md">
                                <input name="edit_first_name" placeholder="First Name" class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>                              
                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Last Name</label>
                            <div class="col-md">
                                <input name="edit_last_name" placeholder="Last Name" class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Phone Number</label>
                            <div class="col-md">
                                <input name="edit_phone_number" max="11" placeholder="Phone No." class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Room #</label>
                            <div class="col-md">
                            <select name="edit_room_no" class="form-control" id="edit_room_no" data-live-search="true" style="width:200px;">
                                <option disabled selected  style="color:#999999;">Room #</option>                                            
                                <?php foreach ($roomLists as $roomlist ){
                                    $disable = $roomlist['room_occupied'] < $roomlist['room_capacity'] ? "" : "disabled";
                                    $color = $roomlist['room_occupied'] < $roomlist['room_capacity'] ? "dark" : "danger";
                                    ?>
                                    <option value="<?php echo $roomlist['room_no'];?>" class="text-<?php echo $color;?>" <?php echo $disable;?>> <?php echo $roomlist['room_no'];?> </option>
                                <?php }?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Current Electricity</label>
                            <div class="col-md">
                                <input name="edit_month_current_kwh" readonly class="form-control" type="text" style="width:200px;">   
                            </div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Monthly Rent</label>
                            <div class="col-md">
                                <input readonly name="edit_monthly_payment" class="form-control" type="text" style="width:200px;">   
                            </div>  
                        </div>

                        <div class="form-group" id="editDateType">
                            <label class="control-label col-sm font-weight-bold">Due Date</label>
                            <div class="col-md">
                                <input readonly id="edit_due_date" name="edit_due_date" class="form-control" style="width:200px;" />
                            </div>
                        </div>

                        <div class="form-group"id="notice">
                        </div>

                    </div>                                                            
                </form>  
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" onclick="updateTenant()" class="btn btn-success">Update</button>
            </div>
        </div>
    </div>    
</div>
<!-- end edit modal -->
<!-- start add modal -->
<div class="modal fade" id="add">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding-left: 38px;">              
                <form class="add-modal">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">First Name</label>
                            <div class="col-md">
                                <input name="add_first_name" placeholder="First Name" class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>                              
                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Last Name</label>
                            <div class="col-md">
                                <input name="add_last_name" placeholder="Last Name" class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Phone Number</label>
                            <div class="col-md">
                                <input name="add_phone_number" max="11" placeholder="Phone No." class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Room #</label>
                            <div class="col-md">
                            <select name="add_room_no" class="form-control" id="add_room_no" data-live-search="true" style="width:200px;">
                                <option disabled selected  style="color:#999999;">Room #</option>                                            
                                <?php foreach ($roomLists as $roomlist ){
                                    $disable = $roomlist['room_occupied'] < $roomlist['room_capacity'] ? "" : "disabled";
                                    $notAvailable = $roomlist['room_occupied'] < $roomlist['room_capacity'] ? "" : "Not Available";
                                    $color = $roomlist['room_occupied'] < $roomlist['room_capacity'] ? "dark" : "danger";
                                    ?>
                                    <option value="<?php echo $roomlist['room_no'];?>" class="text-<?php echo $color;?>" <?php echo $disable;?>> <?php echo $roomlist['room_no'];?> <?php echo $notAvailable;?> </option>
                                <?php }?>
                            </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Current Electricity</label>
                            <div class="col-md">
                                <input name="add_month_current_kwh" placeholder="KWH" class="form-control" type="text" style="width:200px;">   
                            </div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Initial Payment</label>
                            <div class="col-md">
                                <input readonly value ="₱ 0.00" name="add_monthly_payment" class="form-control" type="text" style="width:200px;">   
                            </div>  
                        </div>

                        <div class="form-group" id="addDateType">
                            <label class="control-label col-sm font-weight-bold">Due Date</label>
                            <div class="col-md">
                                <input readonly id="add_due_date" name="add_due_date" class="form-control" style="width:200px;" />
                            </div>
                        </div>

                    </div>                                                            
                </form>                  
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" onclick="addTenant()" class="btn btn-success"><i class="fas fa-paper-plane"></i>Add Tenant</button> 
            </div>

        </div>
    </div>
</div>
<!-- end add modal -->
<!-- start tenants information modal -->
<div class="modal fade" id="tenantsInfo">
    <div class="modal-dialog">
        <div class="modal-content" >
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tenants Information</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">              
                <table class="table">
                    <thead class="thead-dark">
                        <tr class="table100-head">
                        <th class="column1 disable-sorting">#</th>
                        <th class="column2">Full Name</th>
                        <th class="column3">Phone Number</th>
                        </tr>
                    </thead>
                    <tbody id = "filteredTend">                                                
                    </tbody>
                </table>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer" id="addmodalfooter">
                <button type="button" class="btn btn-secondary btn-md" id="viewTenantsPaymentCalculationByRoom"><i class="fas fa-calculator"></i> View Calculation</button>  
                <button type="button" class="btn btn-primary btn-md" id="btn-modal-add" data-toggle="modal" data-target="#addTenantByRoom"><i class="fas fa-plus"></i> Add</button> 
            </div>
        </div>
    </div>
</div>
<!-- end add modal -->
<!-- start add modal -->
<div class="modal fade" id="addTenantByRoom">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding-left: 38px;">  
            <form class="addTenantByRoom">
                    <div class="row">
                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">First Name</label>
                            <div class="col-md">
                                <input name="add_byroom_first_name" placeholder="First Name" class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>                              
                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Last Name</label>
                            <div class="col-md">
                                <input name="add_byroom_last_name" placeholder="Last Name" class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Phone Number</label>
                            <div class="col-md">
                                <input name="add_byroom_phone_number" max="11" placeholder="Phone No." class="form-control" type="text" style="width:200px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Current Electricity</label>
                            <div class="col-md">
                                <input name="add_byroom_month_current_kwh" placeholder="KWH" class="form-control" type="text" style="width:200px;">   
                            </div>  
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm font-weight-bold">Initial Payment</label>
                            <div class="col-md">
                                <input readonly value ="₱ 0.00" name="add_byroom_monthly_payment" class="form-control" type="text" style="width:200px;">   
                            </div>  
                        </div>

                        <div class="form-group" id="addDateType">
                            <label class="control-label col-sm font-weight-bold">Due Date</label>
                            <div class="col-md">
                                <input readonly id="add_byroom_due_date" name="add_byroom_due_date" class="form-control" style="width:200px;" />
                            </div>
                        </div>

                    </div>                                                            
                </form>                              
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" id="addByRoom" class="btn btn-success"><i class="fas fa-plus"></i> Add</button> 
                <!-- <button type="button" class="btn btn-primary" onclick="backTenantsInfo()" id="backToTable"><i class="fas fa-arrow-left"></i> Back</button>  -->
            </div>

            </div>
        </div>
    </div>
</div>
<!-- end add modal -->
<!-- start delete modal -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" style="padding-left: 38px;">              
                    <form class="deleteTenant">
                        <div class="form-group">
                            <label class="control-label">Are you sure you want to delete this tenant?</label>
                        </div>                                                                                         
                    </form>                  
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="tenantDelete btn btn-danger"><i class="fas fa-check"></i> Yes</button> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> No</button>
            </div>

            </div>
        </div>
    </div>
</div>
<!-- end delete modal -->

<!-- start calculation modal -->
<div class="modal fade" id="viewCalculation">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Transaction Calculation of </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">              
                <div class="col-md">
                    <label class="control-label col-sm font-weight-bold d-inline">Current Electricity(kwh):</label>
                    <input type="text" style="width:150px;" class="d-inline form-control" placeholder="kwh"> 
                    <button type="button" class="mb-1 btn btn-success"><i class="fas fa-calculator"></i></button>   
                </div>        
                    <hr>
                    <div class="details-body">
                    </div>                                                                                 
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="tenantDelete btn btn-success"><i class="fas fa-money-bill-alt"></i> Pay rent</button> 
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
            </div>

            </div>
        </div>
    </div>
</div>
<!-- end calculation modal -->
        
    