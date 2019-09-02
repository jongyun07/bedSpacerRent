
$(document).ready(function() {
    var fullDate = new Date()
    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
    var dayFormat = (fullDate.getDate()/10) >= 1 ? fullDate.getDate():"0"+fullDate.getDate();
    var currentDate = twoDigitMonth + "/" +  dayFormat+ "/" + fullDate.getFullYear();
    $('#add_board_date').attr('value', currentDate);

    $("#add_room_number").change(function(){
        var getRoomNo = $('#add_room_number').val(); 
        $('#roomMate pre').detach();
        $.ajax({
            url : "http://localhost/bedSpacerRent/index.php/main/getInitialValueC",
            type: "POST",
            data: {getRoomNo:getRoomNo},
                success: function(data)
                {   $('#roomMate pre').detach();
                    var res = JSON.parse(data);
                    $("input[name='add_initial_payment']").val("₱ "+ number_format( res.room_value, 2, '.', ',' ));
                    $("input[name='add_electricity_kwh']").val(res.electricity_kwh);
                    if(res.occupied > 0){
                        $("input[name='add_electricity_kwh']").attr("readonly",true);
                    }else{
                        $("input[name='add_electricity_kwh']").attr("readonly",false);
                    }
                    var details =  "<pre>Room mate              : <b>"+res.tenants+"</b><br></pre>";
                    if(res.tenants != undefined){
                        $('#roomMate').append(details);
                    }
                },
        });
    });
    // $('.blink_me').fadeOut(500).fadeIn(500, blink); 
    $("#edit_room_no").change(function(){
        var getRoomNo = $('#edit_room_no').val(); 
        var getTenantId = $('#edit_id').val(); 
        $('#notice-section').remove();
        $.ajax({
            url : "http://localhost/bedSpacerRent/index.php/main/getRoomFloorC",
            type: "POST",
            data: {getRoomNo:getRoomNo,getTenantId:getTenantId},
                success: function(data)
                {   var floor = JSON.parse(data);
                    if(floor.getRoomFloor != floor.getUpdatedRoomFloor){
                    //     $.ajax({
                    //         url : "http://localhost/bedSpacerRent/index.php/main/getValueC",
                    //         type: "POST",
                    //         data: {getRoomNo:getRoomNo},
                    //             success: function(data)
                    //             {   console.log(data);
                    //                 $("input[name='edit_monthly_payment']").val("₱ "+ number_format( data, 2, '.', ',' ));
                    //                 $('#notice label').detach();
                    //             },
                    //     });
                    // }else{
                        
                        $.ajax({
                            url : "http://localhost/bedSpacerRent/index.php/main/getValueRoomDiscrepancyC",
                            type: "POST",
                            data: {getRoomNo:getRoomNo,getTenantId:getTenantId},
                                success: function(data)
                                {  var calculated = JSON.parse(data);
                                   var outputCredit = 
                                    "<div id='notice-section'><label class='control-label col-sm text-danger font-weight-bold'>Notice:</label>" +
                                    "<div class='col-md'>" +
                                    "Need to Pay <span class='text-danger'>₱"+ calculated.calculatedPayment +"</span> due to a room value discrepancy <br>" +
                                    "Current Room Value: <span class='text-danger'>₱"+ calculated.getRoomValue +"</span> 1 month advance 1 month deposit <br>" +
                                    "Change Room Value: <span class='text-danger'>₱"+ calculated.getUpdatedRoomValue +"</span> 1 month advance 1 month deposit <br>" +
                                    "Lacking payment: <span class='text-danger'>₱"+ calculated.calculatedPayment +"</span> for room change <br>" +
                                    "</div></div>";
                                    $("input[name='edit_monthly_payment']").val("₱"+ number_format( calculated.amount, 2, '.', ',' ));
                                    $("input[name='edit_month_current_kwh']").val(calculated.getKWH);
                                    if(calculated.checkOccupation >=1){
                                        $("input[name='edit_month_current_kwh']").attr("readonly",true);
                                    }else{
                                        $("input[name='edit_month_current_kwh']").attr("readonly",false);
                                    }
                                    if(calculated.calculatedPayment > 0){
                                        $('#notice').append(outputCredit);
                                    }
                                },
                        });
                    }
                },
        });
       
    });
    $('#notice-section').remove();

    // (function blink() { 
    //     $('.blink_me').fadeOut(100).fadeIn(100, blink); 
    //   })();
        
    // $('#mdueDate').attr('value', currentDate);
    // $('#addTenantDueDate').attr('value', currentDate);
   

    //  $('input[id="dueDate"]').datepicker();
    //  $('input[id="mdueDate"]').datepicker(); 
    //  $('input[id="addTenantDueDate"]').datepicker();

    // $('#bdt').bdt({
    //     showSearchForm: 1,
    //     showEntriesPerPageField: 1
    // });


    // $(".close, .popup").on("click", function(){
    //     $('#filteredTend tr').detach();
    // });

    // $("#btn-modal-add").on("click",function(){
    //     $("#tenantsInfo").modal('toggle');
    // });

    // $("#backToTable").on("click",function(){
    //     $("#addTenantByRoom").modal('toggle');
    // });
    

});


// function calculateInitialValue(){
//     // var data = $( ".add_room_number option:selected" ).val();
//     var option = $('.add_room_number').find('option:selected');
//      var data=  option.text();
//     console.log(data);
// }
// function deleteRec(id){
//         $('.tenantDelete').attr('onclick',`deleteRec('${id}')`);
//         $('.tenantDelete').on('click',function(){
//             $.ajax({
//                 url : "http://localhost/bedSpacerRent/index.php/main/delete/"+ id,
//                 type: "POST",
//                 data: id, 
//                 success: function(data)
//                     {  
//                         location.reload();
//                     },
//                 });
//         });        
// }

function addTenant(){  
    console.log($(".add-modal").serializeArray());
    $.ajax({
        url : "http://localhost/bedSpacerRent/index.php/main/addTenantC",
        type: "POST",
        data: $(".add-modal").serializeArray(),
            success: function(data)
            {
                location.reload();
            },
    });
}

function addByRoom(roomNo){  
//   var arr = $(".addTenantByRoom").serializeArray()
    
    $.ajax({
        url : "http://localhost/bedSpacerRent/index.php/main/addTenantByRoomC/" + roomNo,
        type: "POST",
        data: $(".addTenantByRoom").serializeArray(),
            success: function(data)
            {
                location.reload();
            },
    });
}

function editTenant(id){
    $('#notice-section').remove();
    $.ajax({
        url : "http://localhost/bedSpacerRent/index.php/main/getTenantEditInfoC/" + id,
        type: "GET",
        datatype: "JSON",
            success: function(data)
            {           
                var res = JSON.parse(data);
                var paymentStatus = res.payment_status ==1?"Paid": "Unpaid";
                $('[name="edit_id"]').val(res.id);                 
                $('[name="edit_first_name"]').val(res.first_name);
                $('[name="edit_last_name"]').val(res.last_name);
                $('[name="edit_phone_number"]').val(res.phone_number);
                $('[name="edit_room_no"]').val(res.room_no);
                $('[name="edit_monthly_payment"]').val(res.monthly_payment);
                $('[name="edit_payment_status"]').val(paymentStatus);
                $('[name="edit_month_current_kwh"]').val(res.current_electricity_kwh);
                $('[name="edit_due_date"]').val(res.actual_due_date);
                $('#edit').modal('toggle');
            }
    });         
}

function updateTenant(){         
    console.log($(".update-modal").serializeArray());
    $.ajax({
        url : "http://localhost/bedSpacerRent/index.php/main/updateTenantC",
        type: "POST",
        data: $(".update-modal").serializeArray(),
            success: function(data)
            {   
                location.reload();
            },
    });
}
function calculateTransaction(roomNo){
$('#viewCalculation .modal-title').append("<span id='roomNumber'>"+roomNo+"</span>");
$("#tenantsInfo").modal('toggle');

    $.ajax({
        url : "http://localhost/bedSpacerRent/index.php/main/paymentTransactionC/" + roomNo,
        type: "GET",
        datatype: "JSON",
            success: function(data){
                var res = JSON.parse(data);
                var details = 
                  "<div class='col-md pl-5' id='paymentDetails'>"
                    + "<pre>Tenant/s                 : <b>"+res.tenants_full_name+"</b><br></pre>"
                    + "<pre>Due Date                 : <b>"+res.actual_due_date+" </b><br></pre>"
                    + "<pre>Electricity Last Month   : <b>"+res.month_before_kwh+" kwh</b><br></pre>"
                    + "<pre>Electricity This Month   : <b>"+res.month_current_kwh+" kwh</b><br></pre>"
                    + "<pre>Total Electricity Charge : <b>₱ "+res.total_payment_kwh+"</b><br></pre>"
                    + "<pre>Monthly Rent             : <b>₱ "+res.monthly_payment+"</b><br></pre>"
                    + "<pre>Water Bill               : <b>₱ "+res.water_bill+"</b><br></pre>"
                    + "<pre>Total Payment Per Person : <b>₱ "+res.total_amount_paid+" / Head</b><br></pre>"
                    + "<pre><b class='text-danger'>General Total Payment    : ₱ "+res.total_payment_by_room+"</b><br></pre>"
                + "</div>";
                $('#viewCalculation .details-body').append(details);
                $('#viewCalculation').modal('show');
            }
    });
}

function viewRoomDetails(room_no,room_space){
    $('#paymentDetails').remove();
    $('#filteredTend tr').remove();
    $('#addTenantByRoom .modal-title').remove();
    $.ajax({
        url : "http://localhost/bedSpacerRent/index.php/main/tenantsFilterByRoomC/" + room_no,
        type: "GET",
        datatype: "JSON",
            success: function(data)
            {   
                var res = JSON.parse(data); 
                // console.log(res.tenantsByRoom.length);    
                if(res.tenantsByRoom === undefined || res.tenantsByRoom.length == 0){   
                    var fullDate = new Date()
                    var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
                    var dayFormat = (fullDate.getDate()/10) >= 1 ? fullDate.getDate():"0"+fullDate.getDate();
                    var currentDate = twoDigitMonth + "/" +  dayFormat+ "/" + fullDate.getFullYear();
                    $('#rn').val(room_no);
                    $('#addTenantByRoom .modal-header').prepend("<h4 class='modal-title'>"+room_no+"</h4>"); 
                    $('[name="add_byroom_monthly_payment"]').val("₱ "+res.initial_payment);
                    $('[name="add_byroom_due_date"]').val(currentDate);
                    $('#addByRoom').attr('onclick',`addByRoom('${room_no}')`);
                    $("#addTenantByRoom").modal('toggle');
                        
                }else{   
                    $.each(res.tenantsByRoom, function(i, tenants) {
                            var  row = 
                            "<tr id='tenantsByRoom'><td class='column1'>"+tenants['id'] +"</th>"
                            + "<td class='column2'>"+tenants['full_name']+"</td>"
                            + "<td class='column5'>"+tenants['phone_number']+"</td>";
                        $('#filteredTend').append(row);
                    }); 
                    $("#tenantsInfo").modal('toggle');
                    $('#roomNumber').remove();
                    $("#viewTenantsPaymentCalculationByRoom").show();
                    $('#viewTenantsPaymentCalculationByRoom').attr('onclick',`calculateTransaction('${room_no}')`);
                    if(room_space == 0){
                        $("#btn-modal-add").hide();
                    }else{$("#btn-modal-add").show();}                   
                }
                $('#btn-modal-add').attr('onclick',`addRoomNoInModal('${room_no}')`);
                

            }
    });
}

function addRoomNoInModal(rNo){
    $("#tenantsInfo").modal('toggle');
    $('#rn').val(rNo);
    $('#addTenantByRoom .modal-header').prepend("<h4 class='modal-title'>"+rNo+"</h4>");
    $.ajax({
        url : "http://localhost/bedSpacerRent/index.php/main/getInitialAndDueDateC/" + rNo,
        type: "GET",
        datatype: "JSON",
            success: function(data)
            {    
                var res = JSON.parse(data); 
                $('[name="add_byroom_monthly_payment"]').val("₱ "+ res.initial_payment);
                $('[name="add_byroom_due_date"]').val(res.due_date);
               
            }
        });
}


function number_format(number, decimals, decPoint, thousandsSep){
    decimals = decimals || 0;
    number = parseFloat(number);

    if(!decPoint || !thousandsSep){
        decPoint = '.';
        thousandsSep = ',';
    }

    var roundedNumber = Math.round( Math.abs( number ) * ('1e' + decimals) ) + '';
    var numbersString = decimals ? roundedNumber.slice(0, decimals * -1) : roundedNumber;
    var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
    var formattedNumber = "";

    while(numbersString.length > 3){
        formattedNumber += thousandsSep + numbersString.slice(-3)
        numbersString = numbersString.slice(0,-3);
    }

    return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
}



     