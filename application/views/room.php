<?php $this->load->view('template/header'); ?>
        <div class="container-fluid">
            <div class="row ml-5" style="height:45px;">
                <div class="col-lg-2" style="font-size:20px;">
                    <div class="d-inline-block">Total Occupied Rooms:</div> 
                    <div class="d-inline-block rounded text-center font-weight-bold bg-danger text-white" style="width:40px; padding-top:2px;height:40px; border:white solid .5px;"><?php echo $occupiedRoom; ?></div>
                    
                </div>
                <div class="col-lg-2" style="font-size:20px;">
                    <div class="d-inline-block">Total Available Rooms:</div> 
                    <div class="d-inline-block rounded text-center font-weight-bold bg-success text-white" style="width:40px; padding-top:2px;height:40px; border:white solid .5px;"><?php echo $roomTotalAvailable; ?></div>
                </div>
                <!-- <div class="col-lg-2" style="font-size:20px;">
                <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on top">
  Tooltip on top
</button>
                    <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="top" title="Tooltip on top"></i>
                </div> -->
            </div>
            <hr>
            <div class="row ml-5">
                <div class="col-lg-6">
                    <h1>1st Floor</h1>
                    <?php
                    $numOfCols = 4;
                    $rowCount = 0;
                    ?>
                    <div class="row" style="margin:0px 0px;">
                    <?php foreach ($roomLists as $room){
                        $date1 = strtotime(date("Y/m/d"));
                        $date2 = strtotime($room['actual_due_date']);
                        $secs = $date2 - $date1;
                        $days = $secs / 86400;
                        $blinkMe = $days <= 10 && $days >=1  ? "blink_me" : "";
                        $delayed = $days < 0 && $room['room_occupied'] != 0? "Delayed" : "";
                        $box_color = $room['room_occupied'] >= $room['room_capacity'] ? "btn-warning" : "btn-success";
                        if($room['floor']==1){
                        ?> 
                        
                        <button class="btn <?php echo $box_color." ".$blinkMe;?>" id="roomCapacity" style="margin:5px;font-size:20px; width:190px; height:190px;" onclick="viewRoomDetails('<?php echo $room['room_no']?>','<?php echo $room['room_capacity']-$room['room_occupied'];?>')">
                        <b style="font-size:14px;"><?php echo $delayed;?></b> <br>
                        <b><?php echo $room['room_no']?></b><br>
                        <b style="font-size:14px;"> Occupied Space:  <?php echo $room['room_occupied'];?></b> 
                        <b style="font-size:14px;"> Available Space:  <?php echo $room['room_capacity']-$room['room_occupied'];?></b> 
                        
                        </button>
                    <?php
                        $rowCount++;
                        if($rowCount % $numOfCols == 0) echo '</div><div class="row" style="margin:0px 0px;">';
                        }
                    }
                    ?>
                    </div>
                </div>
        
                <div class="col-lg-6">
                    <h1>2nd Floor</h1>

                    <?php
                
                    $numOfCols = 4;
                    $rowCount = 0;
                    ?>
                    <div class="row" style="margin:0px 0px;">
                    <?php foreach ($roomLists as $room){
                         $date1 = strtotime(date("Y/m/d"));
                         $date2 = strtotime($room['actual_due_date']);
                         $secs = $date2 - $date1;
                         $days = $secs / 86400;
                         $blinkMe = $days <= 10 && $days >=1  ? "blink_me" : "";
                        $box_color = $room['room_occupied'] >= $room['room_capacity'] ? "btn-danger" : "btn-success";
                        if($room['floor']==2){
                        ?> 
                        
                        <button class="btn <?php echo $box_color." ".$blinkMe;?>" id="roomCapacity" style="margin:5px;font-size:20px; width:190px; height:190px;" onclick="viewRoomDetails('<?php echo $room['room_no']?>','<?php echo $room['room_capacity']-$room['room_occupied'];?>')">
                        <b><?php echo $room['room_no']?></b><br>
                        <b style="font-size:14px;"> Occupied Space:  <?php echo $room['room_occupied'];?></b> 
                        <b style="font-size:14px;"> Available Space:  <?php echo $room['room_capacity']-$room['room_occupied'];?></b> 
                        </button>
                    <?php
                        $rowCount++;
                        if($rowCount % $numOfCols == 0) echo '</div><div class="row" style="margin:0px 0px;">';
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>

        </div>
<?php $this->load->view('template/footer'); ?>    
