<?php 
   Class User_model extends CI_Model {
	
        Public function __construct() { 
            parent::__construct(); 
            $this->load->database();
        } 
        public function login($username, $password){
			$query = $this->db->get_where('user', array('username'=>$username, 'password'=>$password));
			return $query->row_array();
        }
        public function register($data){           
            return $this->db->insert('user', $data);
        }
        public function getListOfTenants(){
            $query = $this->db->query("SELECT t.id, t.first_name, t.last_name, t.phone_number, t.payment_status, t.board_date, r.room_number FROM tenant t JOIN room r on t.room_id = r.id");
            $data = $query->result_array();
            return $data;
        }

        public function getRoomInfoM($roomno){
            $query = $this->db->query("SELECT r.room_value,r.occupied,r.electricity_kwh FROM room r WHERE room_number = '$roomno'");
            $data = $query->row_array(); 
            return $data;
        }
        public function getRoomTenantsInfoM($roomno){
            $query = $this->db->query("SELECT CONCAT(t.first_name,' ',t.last_name) AS tenants FROM room r JOIN tenant t ON t.room_id = r.id WHERE room_number = '$roomno'");
            $data = $query->row_array(); 
            return $data;
        }

        public function checkOccupationM($roomno){
            $this->db->select('occupied');
            $query = $this->db->get_where('room',array('room_number' => $roomno));
            return $query->row_array();
        }
        public function getKWHM($roomno){
            $this->db->select('electricity_kwh');
            $query = $this->db->get_where('room',array('room_number' => $roomno));
            return $query->row_array();
        }

        public function getRoomFloorM($id){
            $nameInfo = $this->db->get_where('tenant',array('id'=>$id)); 
            $getRoomId = $nameInfo->row_array();
            $this->db->select('floor');
            $getRoomInfo = $this->db->get_where('room',array('id'=>$getRoomId['room_id'])); 
            $getFloor = $getRoomInfo->row_array();
           return $getFloor;
        }
        public function getUpdatedRoomFloorM($roomno){
            $this->db->select('floor');
            $getFloor = $this->db->get_where('room',array('room_number' => $roomno));
            return $getFloor->row_array();
        }

        public function getRoomValueM($id){
            $nameInfo = $this->db->get_where('tenant',array('id'=>$id)); 
            $getRoomId = $nameInfo->row_array();
            $this->db->select('room_value');
            $getRoomInfo = $this->db->get_where('room',array('id'=>$getRoomId['room_id'])); 
            $getRoomValue = $getRoomInfo->row_array();
           return $getRoomValue;
        }
        public function getUpdatedRoomValueM($roomno){
            $this->db->select('room_value');
            $getRoomValue = $this->db->get_where('room',array('room_number' => $roomno));
            return $getRoomValue->row_array();
        }
                
        public function getRoomCurrentDueDate($roomId){
            $this->db->select('id');
            $tenantQuery = $this->db->get_where('tenant',array('room_id' => $roomId));
            $getTenantId = $tenantQuery->row_array();
            $id =  $getTenantId['id'];
            $monitorPaymentStatusQuery = $this->db->query("SELECT MAX(actual_due_date) AS due_date FROM monitor_payment_status WHERE tenant_id = $id");
            $getActualDueDate = $monitorPaymentStatusQuery->row_array();
            $DueDate = $getActualDueDate['due_date']; 
            return $DueDate;
        }

        //Start Initial Add Tenants
        public function getRoomIdM($roomno){
            $this->db->select('id');
            $roomid = $this->db->get_where('room',array('room_number' => $roomno));
            return $roomid->row_array();
        }
        public function addOccupancyM($roomno,$kwh){
            $query = $this->db->get_where('room',array('room_number'=>$roomno)); 
            $result = $query->row_array();
            $avail = $result['occupied'] + 1;
            $data = array(
                'occupied' => $avail,
                'electricity_kwh' => $kwh,
             );       
            $this->db->where('room_number', $roomno);
            $this->db->update('room', $data);
        }

        public function addTenantM($tenantsInfo){
            return $this->db->insert('tenant', $tenantsInfo);
        }

        public function getTenantIdM($tenantInfo){
            $query = $this->db->get_where('tenant',$tenantInfo);
            $result = $query->row_array();
            $getid = $result['id'];
            return $getid;
        }
        public function initialPaymentM($roomId){
            $query = $this->db->get_where('room',array('id'=>$roomId)); 
            $result = $query->row_array();
            $computation = ($result['room_value']/$result['capacity'])*2;
            return $computation;
        }

        public function monthlyPaymentM($roomId){
            $query = $this->db->get_where('room',array('id'=>$roomId)); 
            $result = $query->row_array();
            $computation = $result['room_value']/$result['capacity'];
            return $computation;
        }
        public function addBillCalculationM($BillCalculationInfo){
            return $this->db->insert('bill_calculation', $BillCalculationInfo);
        }

        public function getBillCalculationIdM($billCalculationInfo){
            $query = $this->db->get_where('bill_calculation',$billCalculationInfo);
            $result = $query->row_array();
            $getid = $result['id'];
            return $getid;
        }

        public function getTotalAmountM($billCalculationInfo){
            $query = $this->db->get_where('bill_calculation',$billCalculationInfo);
            $result = $query->row_array();
            $parkingFee = $result['parking_fee'] == 1? 300 : 0;
            $waterBill = $result['water_bill'] == 1? 100 : 0;
            $discount = $result['water_bill'] == 1? 200 : 0;
            $computation = ((($result['month_current_kwh']-$result['month_before_kwh'])*15) + $result['monthly_payment']+$parkingFee+$waterBill)-$discount;
            return $computation;
        }
        // public function getWaterBillM($roomId){
        //     $this->db->select('water_bill');
        //     $getFloor = $this->db->get_where('room',array('id' => $roomId));
        //     return $getFloor->row_array();
        // }
        public function addTransactionHistoryM($transactionHistory){
            return $this->db->insert('transaction_history', $transactionHistory);
        }
        //End Initial Add Tenants
        //Start Edit Tenant
        //DATE_FORMAT(mps.date_paid, '%d/%m/%Y')
        public function getTenantEditInfoM($id){
            $query = $this->db->query("SELECT t.id,first_name,last_name,phone_number, r.room_number, CONCAT('₱ ', FORMAT((r.room_value/2), 2)) AS
             monthly_payment, mps.payment_status, mps.actual_due_date,r.electricity_kwh,r.capacity FROM tenant AS t INNER JOIN room AS r on r.id = t.room_id
              INNER JOIN monitor_payment_status AS mps ON t.id = mps.tenant_id WHERE t.id = $id");
            $data = $query->row_array();
            return $data;
        }
   
        public function getRoomNoOfTenantM($id){
            $nameInfo = $this->db->get_where('tenant',array('id'=>$id)); 
            $getRoom = $nameInfo->row_array();
            $this->db->select('room_number');
            $getRoomNo = $this->db->get_where('room',array('id'=>$getRoom['room_id'])); 
            $result = $getRoomNo->row_array();
            return $result;
        }

        public function minusOccpancyM($roomNo){
            $getRoomRec = $this->db->get_where('room',array('room_number'=>$roomNo)); 
            $result = $getRoomRec->row_array();
            $occupied = $result['occupied'] - 1;
            $data = array(
                'occupied' => $occupied
                );       
            $this->db->where('room_number', $roomNo);
            $this->db->update('room', $data);   
        }
        public function editTenantsInfoM($editTenantInfo,$id){
            $this->db->where('id', $id);
            $this->db->update('tenant', $editTenantInfo);   
        }
        public function editBillCalculationInfoM($editBillCalculationInfo,$id){
            $this->db->where('id', $id);        
            $this->db->update('bill_calculation', $editBillCalculationInfo);   
        }
        public function editMonitorPaymentStatusInfoM($editMonitorPaymentStatusInfo,$id){
            $this->db->where('id', $id);
            $this->db->update('monitor_payment_status', $editMonitorPaymentStatusInfo);   
        }
        //End Edit Tenant
        public function getRoomLists(){
            $query = $this->db->get('room');
            return $query->result_array();
        }

        public function getRoomListRecordByRoom($roomNo){
            $query = $this->db->query("SELECT DISTINCT t.id,CONCAT( first_name,' ',last_name) AS full_name,phone_number,r.occupied,r.capacity FROM tenant AS t INNER JOIN room AS r on r.id = t.room_id
            INNER JOIN monitor_payment_status AS mps ON t.id = mps.tenant_id WHERE r.room_number ='$roomNo'");
            return $query->result_array();
        }
        public function nearDeadline(){
            $this->db->query("SELECT * FROM LeVigneau.Vente WHERE date > DATE_ADD(now(), INTERVAL 10 DAY)");
        }
        public function paymentTransactionTenantsNamesM($roomid){
            $query = $this->db->query("SELECT CONCAT(t.first_name,' ',t.last_name) AS full_name FROM tenant t INNER JOIN monitor_payment_status mps ON t.id = mps.tenant_id INNER JOIN bill_calculation bc ON mps.bill_calculation_id = bc.id WHERE t.room_id = '$roomid' AND mps.payment_status = 0");
            return $query->result_array();
        }
        public function paymentTransactionTenantsDetailsM($roomid){
            $query = $this->db->query("SELECT DISTINCT mps.actual_due_date,mps.total_amount_paid,monthly_payment ,mps.payment_status, bc.month_before_kwh, bc.month_current_kwh,bc.total_payment_kwh, r.water_bill FROM tenant t INNER JOIN monitor_payment_status mps ON t.id = mps.tenant_id INNER JOIN bill_calculation bc ON mps.bill_calculation_id = bc.id INNER JOIN room r ON t.room_id = r.id WHERE t.room_id = '$roomid' AND mps.payment_status = 0");
            return $query->row_array();
        }
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