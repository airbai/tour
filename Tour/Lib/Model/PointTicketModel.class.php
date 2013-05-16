<?php

class PointTicketModel extends Model {
	// ����
	public function c($data = 0) {
		if (empty($data)) $data = $_POST;
		if ( $this->create( $data ) ) {
			$ret = $this->add();
			return $ret;
		} else {
			return $this->getError();
		}
	}

	// ��ȡ��Ʊ
	public function r($id = 0) {
		$sql = array('ticket_id' => (int)$id);
		$ticket = $this->where($sql)->find();
		return $ticket;
	}

	// ��ȡ��Ʊ�б�
	public function rList($id = 0) {
		$sql = array('ticket_id' => (int)$id);
		$ticketList = $this->where($sql)->select();
		return $ticketList;
	}

	// ��ѯ������Ʊ
	public function rAll($id = 0) {
		$sql = array('point_id' => (int)$id);
		$ticketList = $this->join('`tour_ticket` ON `tour_ticket`.`id`=`tour_point_ticket`.`ticket_id`')->where($sql)->order('`tour_point_ticket`.`show_id` ASC')->select();
		return $ticketList;
	}
	
	// ɾ����Ʊ
	public function dByTicketId($id = 0) {
		$sql = array('ticket_id' => (int)$id);
		$this->where($sql)->delete();
	}
}