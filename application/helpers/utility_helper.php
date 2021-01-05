<?php

	function dnd($var){
		echo '<pre style="border-top: 2px solid red; border-bottom: 2px solid green; margin: 5px 0">';
		var_dump($var);
		echo '</pre>';
	}

	function getSession() {
		return $_SESSION['session'];
	}

	function getUserType(){
		if (getSession()->type == 1){
			echo 'Super Admin';
		}else if (getSession()->type == 2){
			echo 'Admin';
		}else{
			echo 'Member';
		}
	}

	function isSuperAdmin() {
		return getSession()->type == 1 ? true : false;
	}

	function isAdmin() {
		return getSession()->type == 2 ? true : false;
	}

	function isMember() {
		return getSession()->type == 3 ? true : false;
	}

	function login_url($url){
		echo base_url('site/'.$url);
	}

	function dashboard_url($url){
		echo base_url('dashboard/'.$url);
	}

	function home_url($url){
		echo base_url('home/'.$url);
	}

	function member_url($url){
		echo base_url('member/'.$url);
	}

	function dnp($var){
		echo '<pre style="border-top: 2px solid red; border-bottom: 2px solid green; margin: 5px 0">';
		print_r($var);
		echo '</pre>';
	}

	function sendJson($data) {
		header('Content-Type: application/json');
		echo json_encode($data);
	}

