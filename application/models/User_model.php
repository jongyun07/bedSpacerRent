<?php 
   Class User_model extends CI_Model {
	
        Public function __construct() { 
            parent::__construct(); 
            $this->load->database();
        } 
        public function login($email, $password){
			$query = $this->db->get_where('users', array('email'=>$email, 'password'=>$password));
			return $query->row_array();
        }
        public function register($data){           
            return $this->db->insert('users', $data);
        }
        public function getListOfTenants(){
            $query = $this->db->query("SELECT t.id,first_name,last_name,phone_number, r.room_no,CONCAT('₱ ', FORMAT((r.room_value/2), 2)) AS
             monthly_payment, mps.payment_status, DATE_FORMAT(mps.actual_due_date, '%M %d, %Y') AS actual_due_date,r.room_occupied,r.room_capacity FROM tenants AS t INNER JOIN rooms AS r on r.id = t.room_id
              INNER JOIN monitor_payment_status AS mps ON t.id = mps.tenant_id");
            $data =$query->result_array();
            return $data;
        }

        public function getInitialValueM($roomno){
            $this->db->select('room_value');
            $query = $this->db->get_where('rooms',array('room_no' => $roomno));
            return $query->row_array();
        }

        public function getValueM($roomno){
            $this->db->select('room_value');
            $query = $this->db->get_where('rooms',array('room_no' => $roomno));
            return $query->row_array();
        }

        public function getRoomFloorM($id){
            $nameInfo = $this->db->get_where('tenants',array('id'=>$id)); 
            $getRoomId = $nameInfo->row_array();
            $this->db->select('floor');
            $getRoomInfo = $this->db->get_where('rooms',array('id'=>$getRoomId['room_id'])); 
            $getFloor = $getRoomInfo->row_array();
           return $getFloor;
        }
        public function getUpdatedRoomFloorM($roomno){
            $this->db->select('floor');
            $getFloor = $this->db->get_where('rooms',array('room_no' => $roomno));
            return $getFloor->row_array();
        }

        public function getRoomValueM($id){
            $nameInfo = $this->db->get_where('tenants',array('id'=>$id)); 
            $getRoomId = $nameInfo->row_array();
            $this->db->select('room_value');
            $getRoomInfo = $this->db->get_where('rooms',array('id'=>$getRoomId['room_id'])); 
            $getRoomValue = $getRoomInfo->row_array();
           return $getRoomValue;
        }
        public function getUpdatedRoomValueM($roomno){
            $this->db->select('room_value');
            $getRoomValue = $this->db->get_where('rooms',array('room_no' => $roomno));
            return $getRoomValue->row_array();
        }
                
        public function getRoomCurrentDueDate($roomId){
            $this->db->select('id');
            $tenantQuery = $this->db->get_where('tenants',array('room_id' => $roomId));
            $getTenantId = $tenantQuery->row_array();
            $id =  $getTenantId['id'];
            $monitorPaymentStatusQuery = $this->db->query("SELECT MAX(actual_due_date) AS due_date FROM monitor_payment_status WHERE tenant_id = $id");
            $getActualDueDate = $monitorPaymentStatusQuery->row_array();
            $DueDate = $getActualDueDate['due_date']; 
            return $DueDate;
        }

        //Start Initial Add Tenants
        public function getRoomIdM($roomno){
            $query = $this->db->get_where('rooms',array('room_no'=>$roomno)); 
            $result = $query->row_array();
            $getid = $result['id'];
            return $getid;
        }
        public function addRoomM($roomInfo,$roomId){
            $this->db->where('id', $roomId);
            $this->db->update('rooms', $roomInfo);
        }
        public function addOccupancyM($roomno){
            $query = $this->db->get_where('rooms',array('room_no'=>$roomno)); 
            $result = $query->row_array();
            $avail = $result['room_occupied'] + 1;
            $data = array(
                'room_occupied' => $avail
             );       
            $this->db->where('room_no', $roomno);
            $this->db->update('rooms', $data);
        }

        public function addTenantM($tenantsInfo){
            return $this->db->insert('tenants', $tenantsInfo);
        }

        public function getTenantIdM($tenantInfo){
            $query = $this->db->get_where('tenants',$tenantInfo);
            $result = $query->row_array();
            $getid = $result['id'];
            return $getid;
        }
        public function initialPaymentM($roomId){
            $query = $this->db->get_where('rooms',array('id'=>$roomId)); 
            $result = $query->row_array();
            $computation = ($result['room_value']/$result['room_capacity'])*2;
            return $computation;
        }

        public function addInitialBillsCalculationM($initialBillsCalculationInfo){
            return $this->db->insert('bills_calculation', $initialBillsCalculationInfo);
        }
        public function monthlyPaymentM($roomId){
            $query = $this->db->get_where('rooms',array('id'=>$roomId)); 
            $result = $query->row_array();
            $computation = $result['room_value']/$result['room_capacity'];
            return $computation;
        }
        public function addMonthlyBillsCalculationM($monthlyBillsCalculationInfo){
            return $this->db->insert('bills_calculation', $monthlyBillsCalculationInfo);
        }

        public function getBillCalculationIdM($billsCalculationInfo){
            $query = $this->db->get_where('bills_calculation',$billsCalculationInfo);
            $result = $query->row_array();
            $getid = $result['id'];
            return $getid;
        }

        public function getTotalAmountM($billsCalculationInfo){
            $query = $this->db->get_where('bills_calculation',$billsCalculationInfo);
            $result = $query->row_array();
            $computation = (($result['month_current_kwh']-$result['month_before_kwh'])*15)+$result['water_bill'] + $result['monthly_payment'];
            return $computation;
        }

        public function addInitialMonitorPaymentStatusM($initialMonitorPaymentStatusInfo){
            return $this->db->insert('monitor_payment_status', $initialMonitorPaymentStatusInfo);
        }
        public function addMonthlyMonitorPaymentStatusM($monthlyMonitorPaymentStatusInfo){
            return $this->db->insert('monitor_payment_status', $monthlyMonitorPaymentStatusInfo);
        }
        //End Initial Add Tenants
        //Start Edit Tenant
        //DATE_FORMAT(mps.date_paid, '%d/%m/%Y')
        public function getTenantEditInfoM($id){
            $query = $this->db->query("SELECT t.id,first_name,last_name,phone_number, r.room_no, CONCAT('₱ ', FORMAT((r.room_value/2), 2)) AS
             monthly_payment, mps.payment_status, mps.actual_due_date,r.current_electricity_kwh,r.room_capacity FROM tenants AS t INNER JOIN rooms AS r on r.id = t.room_id
              INNER JOIN monitor_payment_status AS mps ON t.id = mps.tenant_id WHERE t.id = $id");
            $data = $query->row_array();
            return $data;
        }
   
        public function getRoomNoOfTenantM($id){
            $nameInfo = $this->db->get_where('tenants',array('id'=>$id)); 
            $getRoom = $nameInfo->row_array();
            $this->db->select('room_no');
            $getRoomNo = $this->db->get_where('rooms',array('id'=>$getRoom['room_id'])); 
            $result = $getRoomNo->row_array();
            return $result;
        }

        public function minusOccpancyM($roomNo){
            $getRoomRec = $this->db->get_where('rooms',array('room_no'=>$roomNo)); 
            $result = $getRoomRec->row_array();
            $occupied = $result['room_occupied'] - 1;
            $data = array(
                'room_occupied' => $occupied
                );       
            $this->db->where('room_no', $roomNo);
            $this->db->update('rooms', $data);   
        }
        public function editTenantsInfoM($editTenantInfo,$id){
            $this->db->where('id', $id);
            $this->db->update('tenants', $editTenantInfo);   
        }
        public function editBillsCalculationInfoM($editBillsCalculationInfo,$id){
            $this->db->where('id', $id);        
            $this->db->update('bills_calculation', $editBillsCalculationInfo);   
        }
        public function editMonitorPaymentStatusInfoM($editMonitorPaymentStatusInfo,$id){
            $this->db->where('id', $id);
            $this->db->update('monitor_payment_status', $editMonitorPaymentStatusInfo);   
        }
        //End Edit Tenant
        public function getRoomLists(){
            $query = $this->db->get('rooms');
            return $query->result_array();
        }

        public function getRoomListRecordByRoom($roomNo){
            $query = $this->db->query("SELECT DISTINCT t.id,first_name,last_name,phone_number,r.room_occupied,r.room_capacity FROM tenants AS t INNER JOIN rooms AS r on r.id = t.room_id
            INNER JOIN monitor_payment_status AS mps ON t.id = mps.tenant_id WHERE r.room_no ='$roomNo'");
            $data =$query->result_array();
            return $data;
        }
        public function nearDeadline(){
            $this->db->query("SELECT * FROM LeVigneau.Vente WHERE date > DATE_ADD(now(), INTERVAL 10 DAY)");
        }
        // public function getListOfRooms(){
        //     $query = $this->db->get_where('rooms',array('' => , ););
        //     return $query->result_array();
        // }
        // public function deleteRecord($id){           
        //     $nameInfo = $this->db->get_where('tenants',array('id'=>$id)); 
        //     $getRoom = $nameInfo->row_array();
        //     $getRoomNo = $this->db->get_where('rooms',array('room_no'=>$getRoom['roomno'])); 
        //     $result = $getRoomNo->row_array();
        //     $avail = $result['room_availability'] - 1;
        //     $data = array(
        //         'room_availability' => $avail
        //      );       
        //     $this->db->where('room_no', $getRoom['roomno']);
        //     $this->db->update('rooms', $data);   
        //     $this->db->delete('tenants', array('id' => $id));    
        // }
        // public function editRecord($id){          
        //     $query = $this->db->get_where('tenants',array('id'=>$id));
        //     return $query->result_array();     
        // }
        // public function updateRecord($data,$id){          
        //     $this->db->where('id', $id);
        //     $this->db->update('tenants', $data); 
        // }
        // public function getRoomList(){
        //     $query = $this->db->get('rooms');
        //     return $query->result_array();
        // }
        // public function getRoomAvailabilityInfo($roomno){
        //     $query = $this->db->get_where('rooms',array('room_no'=>$roomno));
        //     return $query->result_array();
        // }
    
        // public function getMonitoringStatusPayment(){ 
        //     $getRoomNo = $this->db->get_where('tenants',array('roomno'=>$roomno)); 
        //     $data = $getRoomNo->result_array();
        //     return $data;
        // }
    } 
?>