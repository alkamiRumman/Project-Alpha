<?php

	/**
	 * @property Site_model $Site_model
	 */
	class Site extends MY_Controller {
		public $path = '/site';

		function __construct() {
			parent::__construct();
			$this->load->model('Site_model');
		}

		function index() {
			$this->ifLogin();
			$this->load->view('site/login');
		}

		function verify() {
			$email = $this->input->post("email");
			$pass = $this->input->post("password");
			if ($user = $this->Site_model->getUser($email)) {
				if (md5($pass) == $user->password) {
					if ($user->status == 1) {
						$user = (array)$user;
						unset($user["password"]);
						$this->session->set_userdata("session", (object)$user);
						$this->session->set_flashdata('success', 'Login Succeed!');
						$this->ifLogin();
					} else {
						$this->session->set_flashdata('danger', 'Admin Verification Needed!');
						redirect($this->index());
					}
				} else {
					$this->session->set_flashdata('danger', 'Wrong Username or Password..');
					redirect($this->index());
				}
			} else {
				$this->session->set_flashdata('danger', 'User not exists!');
				redirect($this->index());
			}
		}

		function register() {
			$this->ifLogin();
			$this->data['title'] = 'Register new member';
			$this->load->view('site/register');
		}

		function checkEmail() {
			$cnt = $this->Site_model->checkEmail($this->input->get('text'));
			return sendJson(["count" => $cnt]);
		}

		function save() {
			$name = $arr['name'] = $this->input->post('name');
			$email = $arr['email'] = $this->input->post('email');
			$phone = $arr['phone'] = $this->input->post('phone');
			$password = $this->input->post('password');
			$arr['password'] = md5($password);
			$arr['type'] = 3;
			$arr['status'] = 1;
			$this->Site_model->save($arr);

			$this->email->from('info@rummanitsolution.com', COMPANY);
			$this->email->to($email);

			$this->email->subject('Member Information');
			$this->email->message('<h2>!Welcome ' . $name . '!</h2><br> 
			<h3>Login Information</h3><p>Email: <b>' . $email . '</b><br>Phone: <b>' . $phone . '</b>
			<br>Password: <b>' . $password . '</b><br>Please wait for the verification. We will update you by another email after completing verification.</p>');
			$this->email->send();

			$this->session->set_flashdata('success', 'Signup Successful. Need to wait for admin verification!');
			redirect($this->index());
		}

		function profile(){
//			$this->ifLogin();
			$this->data['user'] = getSession();
			$this->makeView('/profile');
		}

		function updateProfile($id){
//			return dnd($_POST);
			$name = $arr['name'] = $this->input->post('name');
			$arr['password'] = md5($this->input->post('password'));
			$config['upload_path'] = './images/' . $id;
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['overwrite'] = true;

			if (!is_dir('images')) {
				mkdir('./images', 0777, true);
			}
			if (!is_dir('images/' . $id)) {
				mkdir('./images/' . $id, 0777, true);
			}
			$this->upload->initialize($config);
			$this->load->library('upload', $config);
			$this->upload->do_upload('profilePicture');
			$profile = $this->upload->data('file_name');

			if (!empty($_FILES['profilePicture']['name'])) {
				$arr['profilePicture'] = $profile;
				getSession()->profilePicture = $profile;
			}
			$this->Site_model->update($arr, $id);
			getSession()->name = $name;
			$this->session->set_flashdata('success', 'Profile Updated!!');
			redirect(base_url());
		}

		function forgetPassword(){
			$this->load->view('site/forgetPassword');
		}

		function verifyEmail(){
			$email = $this->input->post('email');
			$pass = substr(uniqid(rand(), true), 6, 6);
			if ($user = $this->Site_model->getUser($email)){
				$arr['password'] = md5($pass);

				$this->email->from('info@rummanitsolution.com', COMPANY);
				$this->email->to($email);

				$this->email->subject(COMPANY. ' - Forget Password');
				$this->email->message('<h2>Hello ' . $user->name . '!</h2><br><p>
					According to your request your new password is: '. $pass. '</p>');
				$this->email->send();

				$this->Site_model->update($arr, $user->id);
				$this->session->set_flashdata('success', 'An email is sent to '. $email);
				redirect($this->index());
			} else{
				$this->session->set_flashdata('danger', 'Email not matched!');
				redirect($this->index());
			}
		}

		function logout() {
			$this->session->unset_userdata('session');
			$this->session->set_flashdata('success', 'Successfully Logged Out!!');
			redirect(base_url());
		}

	}
