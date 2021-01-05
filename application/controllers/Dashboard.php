<?php

	/**
	 * @property Core_model $core
	 */
	class Dashboard extends MY_Controller {
		public $path = '/dashboard';

		function __construct() {
			parent::__construct();
			if (!$this->session->userdata('session')) {
				redirect('site/logout');
			}
			$this->ifNotSuperAdmin();
			$this->load->model('Core_model', 'core');
		}

		function index() {
			$this->data['title'] = 'Dashboard';
			$this->makeView('/index');
		}

		function users() {
			$this->data['title'] = 'Users';
			$this->makeView('/users');
		}

		function checkEmail() {
			$cnt = $this->core->checkEmail($this->input->get('text'));
			return sendJson(["count" => $cnt]);
		}

		function saveUser() {
//			return dnp($_SESSION['session']->id);
			$name = $arr['name'] = $this->input->post('name');
			$email = $arr['email'] = $this->input->post('email');
			$phone = $arr['phone'] = $this->input->post('phone');
			$password = $this->input->post('password');
			$arr['password'] = md5($password);
			$arr['type'] = $this->input->post('type');
			$this->core->saveUser($arr);

			$this->email->from('info@rummanitsolution.com', COMPANY);
			$this->email->to($email);

			$this->email->subject('User Information');
			$this->email->message('<h2>!Welcome ' . $name . '!</h2><br> 
			<h3>Login Information</h3><p>Email: <b>' . $email . '</b><br>Phone: <b>' . $phone . '</b>
			<br>Password: <b>' . $password . '</b></p>');
			$this->email->send();

			$this->session->set_flashdata('success', 'Added Successfully.');
			redirect('dashboard/users');
		}

		function getUser() {
			$action = '<a href="deleteUser/$1" onclick="return confirm(\'Are You sure?\')" class="btn btn-sm btn-danger">
            <i class="fa fa-trash"></a>';
			$this->datatables->select('id, name, email, phone, createAt, type');
			$this->datatables->from(TABLE_USER);
			$this->datatables->where(array('type !=' => 1));
			$this->datatables->addColumn('actions', $action, 'id');
			$this->datatables->generate();
		}

		function deleteUser($id) {
			$this->core->deleteUser($id);
			$this->session->set_flashdata('success', 'Successfully Removed..');
			redirect('dashboard/users');
		}

		function dormitory() {
			$this->data['title'] = 'Dormitory';
			$this->data['users'] = $this->core->getUsers();
			$this->makeView('/dormitory');
		}

		function saveDormitory() {
//			return dnp($_POST);
			$arr['name'] = $this->input->post('name');
			$arr['address'] = $this->input->post('address');
			$arr['phone'] = $this->input->post('phone');
			$arr['userId'] = $this->input->post('userId');
			$this->core->saveDormitory($arr);
			$this->session->set_flashdata('success', 'Dormitory Added Successfully.');
			redirect('dashboard/dormitory');
		}

		function getDormitory() {
			$action = '<a href="javascript:void(0);" onclick="loadPopup(\'' . base_url('dashboard/editDormitory/$1') . '\')" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
            <a href="deleteDormitory/$1" onclick="return confirm(\'You are not allowed\')" class="btn btn-sm btn-danger">
            <i class="fa fa-trash"></a>';
			$this->datatables->select('d.id as id, d.name, d.address, d.phone, u.name as user, d.createAt');
			$this->datatables->from(TABLE_DORMITORY . ' as d');
			$this->datatables->join(TABLE_USER . ' as u', 'd.userId = u.id');
			$this->datatables->addColumn('actions', $action, 'id');
			$this->datatables->generate();
		}

		function editDormitory($id) {
			$this->data['users'] = $this->core->getUsers();
			$this->data['data'] = $this->core->getDormitoryEditById($id);
			$this->makeView('/editDormitory');
		}

		function updateDormitory($id) {
			$arr['name'] = $this->input->post('name');
			$arr['address'] = $this->input->post('address');
			$arr['phone'] = $this->input->post('phone');
			$arr['userId'] = $this->input->post('userId');
			$arr['updateAt'] = date('Y-m-d H:i:s');
			$this->core->updateDormitory($arr, $id);
			$this->session->set_flashdata('success', 'Dormitory Updated Successfully.');
			redirect('dashboard/dormitory');
		}

		function deleteDormitory($id) {
			$this->core->deleteDormitory($id);
			$this->session->set_flashdata('success', 'Dormitory Successfully Removed..');
			redirect('dashboard/dormitory');
		}

		function addCompany() {
			$this->data['title'] = 'Add New Company';
			$this->makeView('/addCompany');
		}

		function companyList() {
			$this->data['title'] = 'Company List';
			$this->data['data'] = $this->core->getCompany();
			$this->makeView('/companyList');
		}

		function saveCompany() {
//			return dnp($_POST);
			$arr['companyName'] = $this->input->post('companyName');
			$arr['billingAccount'] = $this->input->post('billingAccount');
			$arr['billingAddress'] = $this->input->post('billingAddress');
			$arr['mailingAddress'] = $this->input->post('mailingAddress');
			$arr['supervisorName'] = $this->input->post('supervisorName');
			$arr['supervisorNumber'] = $this->input->post('supervisorNumber');
			$arr['userId'] = getSession()->id;
//			return dnp($arr);
			$this->core->saveCompany($arr);
			$lastId = $this->db->insert_id();
			for ($i = 0; $i < sizeof($this->input->post('name')); $i++) {
				$ar['companyId'] = $lastId;
				$ar['name'] = array_values(array_filter($this->input->post('name')))[$i];
				$ar['email'] = array_values(array_filter($this->input->post('email')))[$i];
				$ar['phone'] = array_values(array_filter($this->input->post('phone')))[$i];
				$ar['position'] = array_values(array_filter($this->input->post('position')))[$i];
				$this->core->saveContact($ar);
			}
			$this->session->set_flashdata('success', 'Company Added Successfully.');
			redirect('dashboard/companyList');
		}

		function getCompany() {
			$action = '<a href="javascript:void(0);" onclick="loadPopup(\'' . base_url('dashboard/editCompany/$1') . '\')" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
            <a href="deleteCompany/$1" onclick="return confirm(\'You are not allowed\')" class="btn btn-sm btn-danger">
            <i class="fa fa-trash"></a>';
			$this->datatables->select('c.id as id, c.companyName, c.billingAccount, c.billingAddress, c.mailingAddress,
			c.uen, c.createAt, u.name as user');
			$this->datatables->from(TABLE_COMPANY . ' as c');
			$this->datatables->join(TABLE_USER . ' as u', 'c.userId = u.id');
			$this->datatables->addColumn('actions', $action, 'id');
			$this->datatables->generate();
		}

		function editCompany($id) {
			$data = $this->data['data'] = $this->core->getCompanyById($id);
			$this->data['contact'] = $this->core->getContactById($data->id);
			$this->makeView('/editCompany');
		}

		function updateCompany($id) {
//			return dnp($_POST);
			$arr['companyName'] = $this->input->post('companyName');
			$arr['billingAccount'] = $this->input->post('billingAccount');
			$arr['billingAddress'] = $this->input->post('billingAddress');
			$arr['mailingAddress'] = $this->input->post('mailingAddress');
			$arr['supervisorName'] = $this->input->post('supervisorName');
			$arr['supervisorNumber'] = $this->input->post('supervisorNumber');
			$arr['updateAt'] = date('Y-m-d H:i:s');
			$this->core->updateCompany($arr, $id);
			$this->core->deleteContactInfo($id);
			for ($i = 0; $i < sizeof($this->input->post('name')); $i++) {
				$ar['companyId'] = $id;
				$ar['name'] = array_values(array_filter($this->input->post('name')))[$i];
				$ar['email'] = array_values(array_filter($this->input->post('email')))[$i];
				$ar['phone'] = array_values(array_filter($this->input->post('phone')))[$i];
				$ar['updateAt'] = date('Y-m-d H:i:s');
				$this->core->saveContact($ar);
			}
			$this->session->set_flashdata('success', 'Company Updated Successfully.');
			redirect('dashboard/companyList');
		}

		function deleteCompany($id) {
			$this->core->deleteCompany($id);
			$this->session->set_flashdata('success', 'Company Successfully Removed..');
			redirect('dashboard/companyList');
		}

		function viewContact($id){
			$this->data['contact'] = $this->core->getContactById($id);
			$this->data['dormitory'] = $this->core->getDormitoryById($id);
			$this->makeView('/viewContact');
		}

		function workerDetails(){
			$this->data['title'] = 'Worker Details';
			$this->makeView('/workerDetails');
		}

		function getWorkerDetails() {
//			$action = '<a href="javascript:void(0);" onclick="loadPopup(\'' . base_url('home/editDormitory/$1') . '\')" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
//            <a href="deleteDormitory/$1" onclick="return confirm(\'You are not allowed\')" class="btn btn-sm btn-danger">
//            <i class="fa fa-trash"></a>';
			$this->datatables->select('w.id as id, u.name, w.dormitoryName, w.identificationNumber, w.workPass, w.fullName, w.dateOfBirth, w.
			gender, w.nationality, w.postalCode, w.blockNumber, w.levelNo, w.unitNo, w.contactNo, w.workPlace, w.workPassType, w.
			industrySector, w.healthStatus, w.billingAccount, w.employer, w.createAt');
			$this->datatables->from(TABLE_WORKERDETAILS. ' as w');
			$this->datatables->join(TABLE_USER. ' as u', 'w.userId = u.id');
//			$this->datatables->addColumn('actions', $action, 'id');
			$this->datatables->generate();
		}
	}
