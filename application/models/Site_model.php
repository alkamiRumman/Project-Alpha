<?php

	class Site_model extends CI_Model {
		function __construct() {
		}

		function getUser($email) {
			$this->db->select('*');
			$this->db->from(TABLE_USER);
			$this->db->where(array('email' => $email));
			$query = $this->db->get();
			if ($query->num_rows()) {
				return $query->row();
			}
			return false;
		}

		function checkEmail($text) {
			$this->db->select('COUNT(*) AS cnt');
			$this->db->from(TABLE_USER);
			$this->db->where('email',$text);
			$result = $this->db->get();
			return $result->first_row()->cnt;
		}

		function save($arr) {
			$this->db->insert(TABLE_USER, $arr);
		}

		function update($arr, $id){
			$this->db->update(TABLE_USER, $arr, array('id' => $id));
		}
	}
