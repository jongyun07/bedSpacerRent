<?php $this->load->view('template/header'); ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-lg-3">
            <button type="button" id="addCurrentDate" class="btn btn-primary btn-md" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i> Create</button>   
        </div>
    </div>  
    <br>
    <div class="table-responsive">
        <table id="bdt" class="table">
            <thead class="thead-dark">
                <tr >
                    <th class="column1 disable-sorting">#</th>
                    <th class="column2">First name</th>
                    <th class="column3">Last name</th>
                    <th class="column3">Phone Number</th>
                    <th class="column5">Room #</th>
                    <th class="column5">Payment_status</th>
                    <th class="column5">Board Date</th>
                    <th class="column6-head">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($listOfTenants as $listitem ){ 
                $paymentStatus = $listitem['payment_status']==1?"Paid": "Unpaid";
                $color = $listitem['payment_status']==1 ? "success": "danger";
                ?>
                <tr>
                <td class="column1"><?php echo $listitem['id'];?> </th>
                <td class="column2"><?php echo $listitem['first_name'];?></td>
                <td class="column3"><?php echo $listitem['last_name'];?></td>
                <td class="column3"><?php echo $listitem['phone_number'];?></td>
                <td class="column5"><?php echo $listitem['room_number'];?></td>
                <td class="column5 text-<?php echo $color;?>"><?php echo $paymentStatus;?></td>
                <td class="column5"><?php echo $listitem['board_date']?></td>
                <td class="column6">
                    <button type="button" class="btn btn-secondary " onclick="view()"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-danger" onclick="deleteRec('<?php echo $listitem['id'];?>')"  data-toggle="modal" data-target="#delete"><i class="fas fa-trash"></i></button>
                    <button type="button" class="btn btn-primary" onclick="editTenant('<?php echo $listitem['id'];?>')" ><i class="fas fa-edit"></i></button>
                </td>
                </tr>
            <?php } ?>   
            </tbody>
        </table>
    </div>
</div>
<?php $this->load->view('template/footer'); ?>     
