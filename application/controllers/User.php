<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class User extends CI_Controller {
 
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('user_model');
	}
 
	public function index(){
		//load session library
		$this->load->library('session');
 
		//restrict users to go back to login if session has been set
		if($this->session->userdata('user')){
			redirect('user/home');
		}
		else{
			$this->load->view('login_page');
		}
	}
 
	public function login(){
		//load session library
		$this->load->library('session');
 
		$output = array('error' => false);
 
		$username = $_POST['username'];
		$password = $_POST['password'];
 
		$data = $this->user_model->login($username, $password);
 
		if($data){
			$this->session->set_userdata('user', $data);
			$output['message'] = 'Logging in. Please wait...';
		}
		else{
			$output['error'] = true;
			$output['message'] = 'Login Invalid. User not found';
		}
 
		echo json_encode($output); 
	}
 
	public function home(){
		//load session library
		$this->load->library('session');
 
		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$data['listOfTenants'] = $this->user_model->getListOfTenants();  	
			$data['roomLists'] = $this->user_model->getRoomLists(); 
       		$this->load->view('home',$data);

		}
		else{
			redirect('/');
		}
 
	}
	public function room(){
		$this->load->library('session');
		if($this->session->userdata('user')){	   
			$data['roomLists'] = $this->user_model->getRoomLists(); 	
			$totalRoomCapacity = 0;
			$totalRoomOccupancy= 0;
			for ($i=0; $i < count($data['roomLists']) ;	 $i++) { 
				$totalRoomCapacity = $totalRoomCapacity + $data['roomLists'][$i]['room_capacity'];
				$totalRoomOccupancy = $totalRoomOccupancy + $data['roomLists'][$i]['room_occupied'];
				if($data['roomLists'][$i]['room_occupied'] > 0){
					$getDueDate = $this->user_model->getRoomCurrentDueDate($data['roomLists'][$i]['id']);
					$data['roomLists'][$i] = array_merge($data['roomLists'][$i],array( 'actual_due_date' => $getDueDate ));
				}
				else{				
					$data['roomLists'][$i] = array_merge($data['roomLists'][$i],array('actual_due_date' => ''));
				}
			}
			$data['occupiedRoom'] = $totalRoomOccupancy;
			$data['roomTotalAvailable'] =  $totalRoomCapacity - $totalRoomOccupancy;
       		$this->load->view('room',$data);

		}
		else{
			redirect('/');
		}
	}

	public function roomPaymentCalculation(){
		$this->load->library('session');
		if($this->session->userdata('user')){	    
       		$this->load->view('room_total_calculation');
		}
		else{
			redirect('/');
		}
	}

	public function registration(){
		$data = array(
			'fname' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
		);
		$this->user_model->register($data);		
	}

	public function reg_view(){
		$this->load->view('registration');
	}
 
	public function logout(){
		//load session library
		$this->load->library('session');
		$this->session->unset_userdata('user');
		redirect('/');
	}
 
}