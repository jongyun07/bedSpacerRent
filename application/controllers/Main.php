<?php 
   class Main extends CI_Controller {
  
    public function __construct()
    {
      parent::__construct();
      $this->load->model('user_model');
      $this->load->helper('url');
    }
    public function tenantsFilterByRoomC($roomNo){
      $data['tenantsByRoom'] = $this->user_model->getRoomListRecordByRoom($roomNo);
      $getRoomId = $this->user_model->getRoomIdM($roomNo);
      $initial_payment = $this->user_model->initialPaymentM($getRoomId);
      $data['initial_payment'] = number_format($initial_payment,2);
      echo json_encode($data);
    }
    public function getInitialValueC(){
      $data = $this->user_model->getInitialValueM($this->input->post('getRoomNo'));

      $calculation = $data['room_value']+100;
      echo  $calculation;
    }

    public function getValueC(){
      $data = $this->user_model->getValueM($this->input->post('getRoomNo'));
      $calculation = $data['room_value']/2;
      echo  $calculation;
    }
    public function getValueRoomDiscrepancyC(){
      $getRoomValue= $this->user_model->getRoomValueM($this->input->post('getTenantId'));
      $getUpdatedRoomValue= $this->user_model->getUpdatedRoomValueM($this->input->post('getRoomNo'));
      $data['amount'] = $getUpdatedRoomValue['room_value']/2;
      $data['getRoomValue'] = $getRoomValue['room_value'];
      $data['getUpdatedRoomValue'] = $getUpdatedRoomValue['room_value'];
      $data['calculatedPayment'] = $getUpdatedRoomValue['room_value'] - $getRoomValue['room_value'];
      echo json_encode($data);
    }
    
    public function getRoomFloorC(){
      $data['getRoomFloor'] = $this->user_model->getRoomFloorM($this->input->post('getTenantId'));
      $data['getUpdatedRoomFloor'] = $this->user_model->getUpdatedRoomFloorM($this->input->post('getRoomNo'));
      echo json_encode($data);
    }

    public function getInitialAndDueDateC($roomNo){
      $getRoomId = $this->user_model->getRoomIdM($roomNo);
      $initial_payment = $this->user_model->initialPaymentM($getRoomId);
      $data['initial_payment'] = number_format($initial_payment,2);
      $dueDate = $this->user_model->getRoomCurrentDueDate($getRoomId);
      $origDate = strtotime($dueDate);
      $data['due_date'] = date("d/m/Y", $origDate);
      echo json_encode($data);
    }
  
    public function addTenantC() { 
        $this->user_model->addOccupancyM($this->input->post('add_room_no'));  
        $getRoomId = $this->user_model->getRoomIdM($this->input->post('add_room_no'));
        $data['room'] = array(
          'current_electricity_kwh' => $this->input->post('add_month_current_kwh'), 
        );
        $this->user_model->addRoomM($data['room'],$getRoomId);  

        $data['tenants'] = array(
            'first_name' => $this->input->post('add_first_name'),
            'last_name' => $this->input->post('add_last_name'),       
            'room_id' => $getRoomId,
            'phone_number' => $this->input->post('add_phone_number'),
        );
        $this->user_model->addTenantM($data['tenants']);  

        $tenantId = $this->user_model->getTenantIdM($data['tenants']);
        $data['initial_bills_calculation'] = array(
            'month_before_kwh' => $this->input->post('add_month_current_kwh'),
            'month_current_kwh' => $this->input->post('add_month_current_kwh'),
            'total_payment_kwh' => 0,
            'water_bill' => 100,
            'monthly_payment' => $this->user_model->initialPaymentM($getRoomId),
            'tenant_id' => $tenantId,
        );
        $this->user_model->addInitialBillsCalculationM($data['initial_bills_calculation']);  

        $data['monthly_bills_calculation'] = array(
          'month_before_kwh' => $this->input->post('add_month_current_kwh'),
          'month_current_kwh' => $this->input->post('add_month_current_kwh'),
          'total_payment_kwh' => 0,
          'water_bill' => 100,
          'monthly_payment' => $this->user_model->monthlyPaymentM($getRoomId),
          'tenant_id' => $tenantId,
        );
        $this->user_model->addMonthlyBillsCalculationM($data['monthly_bills_calculation']);

        $origDate = strtotime($this->input->post('add_due_date'));
        $dueDate = date("Y-m-d", $origDate);
        $day = date('d', strtotime($dueDate));
        $month = date('F', strtotime($dueDate));
        $year = date('Y', strtotime($dueDate));
        $nextMonthDate = date("Y-m-d", strtotime("+1 month", $origDate));
        $nextMonth = date('F', strtotime($nextMonthDate));
        $data['intial_monitor_payment_status'] = array(
            'tenant_id' => $tenantId,
            'bills_calculation_id' => $this->user_model->getBillCalculationIdM($data['initial_bills_calculation']),
            'date_paid' => $dueDate,
            'actual_due_date' => $dueDate,
            'actual_due_day_monthly' => $day,
            'total_amount_paid' => $this->user_model->getTotalAmountM($data['initial_bills_calculation']),
            'payment_status' => 1,
            'month' => $month,
            'year' => $year,
        );
        $this->user_model->addInitialMonitorPaymentStatusM($data['intial_monitor_payment_status']);  

        $data['monthly_monitor_payment_status'] = array(
          'tenant_id' => $tenantId,
          'bills_calculation_id' => $this->user_model->getBillCalculationIdM($data['monthly_bills_calculation']),
          'date_paid' => "0000-00-00",
          'actual_due_date' => $nextMonthDate,
          'actual_due_day_monthly' => $day,
          'total_amount_paid' => $this->user_model->getTotalAmountM($data['monthly_bills_calculation']),
          'payment_status' => 0,
          'month' => $nextMonth,
          'year' => $year,
      );
      $this->user_model->addMonthlyMonitorPaymentStatusM($data['monthly_monitor_payment_status']);     
    } 
    public function addTenantByRoomC($roomNo){
      $this->user_model->addOccupancyM($roomNo);  
        $getRoomId = $this->user_model->getRoomIdM($roomNo);
        $data['room'] = array(
          'current_electricity_kwh' => $this->input->post('add_byroom_month_current_kwh'), 
        );
        $this->user_model->addRoomM($data['room'],$getRoomId);  
        $data['tenants'] = array(
          'first_name' => $this->input->post('add_byroom_first_name'),
          'last_name' => $this->input->post('add_byroom_last_name'),       
          'room_id' => $getRoomId,
          'phone_number' => $this->input->post('add_byroom_phone_number'),
      );
      $this->user_model->addTenantM($data['tenants']);  

      $tenantId = $this->user_model->getTenantIdM($data['tenants']);
      $data['initial_bills_calculation'] = array(
          'month_before_kwh' => $this->input->post('add_byroom_month_current_kwh'),
          'month_current_kwh' => $this->input->post('add_byroom_month_current_kwh'),
          'total_payment_kwh' => 0,
          'water_bill' => 100,
          'monthly_payment' => $this->user_model->initialPaymentM($getRoomId),
          'tenant_id' => $tenantId,
      );
      $this->user_model->addInitialBillsCalculationM($data['initial_bills_calculation']);  

      $data['monthly_bills_calculation'] = array(
        'month_before_kwh' => $this->input->post('add_byroom_month_current_kwh'),
        'month_current_kwh' => $this->input->post('add_byroom_month_current_kwh'),
        'total_payment_kwh' => 0,
        'water_bill' => 100,
        'monthly_payment' => $this->user_model->monthlyPaymentM($getRoomId),
        'tenant_id' => $tenantId,
      );
      $this->user_model->addMonthlyBillsCalculationM($data['monthly_bills_calculation']);

      $origDate = strtotime($this->input->post('add_byroom_due_date'));
      $dueDate = date("Y-m-d", $origDate);
      $day = date('d', strtotime($dueDate));
      $month = date('F', strtotime($dueDate));
      $year = date('Y', strtotime($dueDate));
      $nextMonthDate = date("Y-m-d", strtotime("+1 month", $origDate));
      $nextMonth = date('F', strtotime($nextMonthDate));
      $data['intial_monitor_payment_status'] = array(
          'tenant_id' => $tenantId,
          'bills_calculation_id' => $this->user_model->getBillCalculationIdM($data['initial_bills_calculation']),
          'date_paid' => $dueDate,
          'actual_due_date' => $dueDate,
          'actual_due_day_monthly' => $day,
          'total_amount_paid' => $this->user_model->getTotalAmountM($data['initial_bills_calculation']),
          'payment_status' => 1,
          'month' => $month,
          'year' => $year,
      );
      $this->user_model->addInitialMonitorPaymentStatusM($data['intial_monitor_payment_status']);  

      $data['monthly_monitor_payment_status'] = array(
        'tenant_id' => $tenantId,
        'bills_calculation_id' => $this->user_model->getBillCalculationIdM($data['monthly_bills_calculation']),
        'date_paid' => "0000-00-00",
        'actual_due_date' => $nextMonthDate,
        'actual_due_day_monthly' => $day,
        'total_amount_paid' => $this->user_model->getTotalAmountM($data['monthly_bills_calculation']),
        'payment_status' => 0,
        'month' => $nextMonth,
        'year' => $year,
    );
    $this->user_model->addMonthlyMonitorPaymentStatusM($data['monthly_monitor_payment_status']);  
    }
 
    
    public function getTenantEditInfoC($id) {
      $data = $this->user_model->getTenantEditInfoM($id);  
      $AddMonth = array('actual_due_date'=> date('F d, Y', strtotime("+1 months", strtotime($data['actual_due_date']))));
      $tenantInfo = array_replace($data, $AddMonth);
      echo json_encode($tenantInfo);
    }        
    public function updateTenantC(){
      $editId = $this->input->post('edit_id');
      $getTenantRoomNo = $this->user_model->getRoomNoOfTenantM($editId);
      $getUpdatedRoomNo =$this->input->post('edit_room_no');
      if($getUpdatedRoomNo != $getTenantRoomNo['room_no']){
        $this->user_model->minusOccpancyM($getTenantRoomNo['room_no']);
        $this->user_model->addOccupancyM($getUpdatedRoomNo); 
        $data['rooms'] = array(
          'current_electricity_kwh' => $this->input->post('edit_month_current_kwh'), 
        );
        $this->user_model->addRoomM($data['rooms'],$getUpdatedRoomNo);  
      } 
      $getRoomId = $this->user_model->getRoomIdM($getUpdatedRoomNo);
      $data['tenants'] = array(
        'first_name' => $this->input->post('edit_first_name'),
        'last_name' => $this->input->post('edit_last_name'),
        'room_id' => $getRoomId,
        'phone_number' => $this->input->post('edit_phone_number'),
      );
      $this->user_model->editTenantsInfoM($data['tenants'],$editId);

      $data['bills_calculation'] = array(
        'month_current_kwh' => $this->input->post('edit_month_current_kwh'),
        'monthly_payment' => $this->user_model->initialPaymentM($getRoomId),
      );
      $this->user_model->editBillsCalculationInfoM($data['bills_calculation'],$editId);

      $data['monitor_payment_status'] = array(
        'total_amount_paid' => $this->user_model->getTotalAmountM($data['bills_calculation']),
      );
      $this->user_model->editMonitorPaymentStatusInfoM($data['monitor_payment_status'],$editId);
    } 
    public function paymentTransactionC($roomNo){
      $tenantsByRoom = $this->user_model->getRoomListRecordByRoom($roomNo);
      echo json_encode(tenantsByRoom);
    }
  } 
?>