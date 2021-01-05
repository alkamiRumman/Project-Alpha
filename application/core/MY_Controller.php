<?php

	class MY_Controller extends CI_Controller {
		public $path;
		public $data = [];
		public $checkUserVerification = [];

		public function __construct() {
			parent::__construct();
			$this->load->library('email');
			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'ssl://rummanitsolution.com';
			$config['smtp_user'] = 'info@rummanitsolution.com';
			$config['smtp_pass'] = 'OTee!(+G33Z[';
			$config['smtp_port'] = '465';
			$config['charset'] = 'utf-8';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
		}

		public function makeView($view) {
			$this->load->view("header", $this->data);
			$this->load->view("navbar", $this->data);
			$this->load->view($this->path.$view, $this->data);
			$this->load->view('footer', $this->data);
		}

		function getUserData() {
			return isset($_SESSION["session"]) ? $_SESSION["session"] : false;
		}

		function getUserDataType() {
			return $this->getUserData()->type;
		}

		function ifLogin() {
			if ($this->getUserData()) {
				if ($this->getUserDataType() == 1) {
					$url = 'dashboard/index';
				} else if ($this->getUserDataType() == 2) {
					$url = 'home/index';
				} else {
					$url = 'member/index';
				}
				return redirect($url);
			}
		}

		function ifNotSuperAdmin() {
			if ($this->getUserDataType() != 1) {
				redirect();
			}
		}

		function ifNotAdmin() {
			if ($this->getUserDataType() != 2) {
				redirect();
			}
		}

		function ifNotMember() {
			if ($this->getUserDataType() != 3) {
				redirect();
			}
		}

	}
