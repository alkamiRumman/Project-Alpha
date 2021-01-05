<?php

	class Core_model extends CI_Model {
		function __construct() {
			$this->titlesTable = 'titles';
			$this->itemsTable = 'items';
		}

		function getCommunity() {
			$this->db->select('*');
			$this->db->from(TABLE_COMPANY);
			return $this->db->get()->result();
		}

		function checkEmail($text) {
			$this->db->select('COUNT(*) AS cnt');
			$this->db->from(TABLE_USER);
			$this->db->where('email', $text);
			$result = $this->db->get();
			return $result->first_row()->cnt;
		}

		function saveUser($arr) {
			$this->db->insert(TABLE_USER, $arr);
		}

		function deleteUser($id) {
			$this->db->where('id', $id);
			$this->db->delete(TABLE_USER);
		}

		function saveDormitory($arr) {
			$this->db->insert(TABLE_DORMITORY, $arr);
		}

		function getDormitoryById($id) {
			$this->db->select('d.name as dormitoryName, d.address, d.phone as dormitoryPhone, u.name, u.phone');
			$this->db->from(TABLE_DORMITORYTYPE. ' as t');
			$this->db->join(TABLE_DORMITORY. ' as d', 't.dormitoryId = d.id');
			$this->db->join(TABLE_USER. ' as u', 'u.id = d.userId');
			$this->db->where('t.companyId', $id);
			return $this->db->get()->result();
		}

		function getDormitoryEditById($id) {
			$this->db->select('d.id, d.name, d.userId, d.address, d.phone, u.name as username');
			$this->db->from(TABLE_DORMITORY. ' as d');
			$this->db->join(TABLE_USER. ' as u', 'u.id = d.userId');
			$this->db->where('d.id', $id);
			return $this->db->get()->row();
		}
		
		function getCompany(){
			$this->db->select('d.*, u.name as user');
			$this->db->from(TABLE_DORMITORY. ' as d');
			$this->db->join(TABLE_USER. ' as u', 'd.userId = u.id','right');
			return $this->db->get()->result();
		}

		function getUsers(){
			$this->db->select('id, name');
			$this->db->from(TABLE_USER);
			$this->db->where('type', 2);
			return $this->db->get()->result();
		}

		function updateDormitory($arr, $id) {
			$this->db->update(TABLE_DORMITORY, $arr, array('id' => $id));
		}

		function deleteDormitory($id) {
			$this->db->where('id', $id);
			$this->db->delete(TABLE_DORMITORY);
		}

		function saveCompany($arr) {
			$this->db->insert(TABLE_COMPANY, $arr);
		}

		function getCompanyById($id) {
			$this->db->select('*');
			$this->db->from(TABLE_COMPANY);
			$this->db->where('id', $id);
			return $this->db->get()->row();
		}

		function getContactById($id) {
			$this->db->select('*');
			$this->db->from(TABLE_CONTACTINFO);
			$this->db->where('companyId', $id);
			return $this->db->get()->result();
		}

		function updateCompany($arr, $id) {
			$this->db->update(TABLE_COMPANY, $arr, array('id' => $id));
		}

		function deleteCompany($id) {
			$this->db->where('id', $id);
			$this->db->delete(TABLE_COMPANY);
		}

	}
