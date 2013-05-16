<?php

class AgentIncomeModel extends Model {

	// ����������
	public function c($data = 0) {
		if (empty($data)) $data = $_POST;
		if ( $this->create( $data ) ) {
			$ret = $this->add();
			return $ret;
		} else {
			return $this->getError();
		}
	}
	
	// ��������
	public function u($data = 0) {
		if (empty($data)) $data = $_POST;
		$line = $this->save( $data );
		return $line;
	}
	
	// �������루ͨ��������ţ�
	public function uByOrder($data = 0, $order_id = 0) {
		if (empty($data)) $data = $_POST;
		$sql = array('order_id' => $order_id);
		$line = $this->where($sql)->save($data);
		return $line;
	}

	// ��ȡ��·
    public function r($id = 0){
		$sql = array('id' => (int)$id);
		$line = $this->where($sql)->find();
		return $line;
    }
	
	// ��ȡ�����б�
	public function rList($user_id = 0, $page = 1, $limit = 10) {
		$sql = array('user_id' => $user_id);
		$incomeList = $this->where($sql)->page($page)->limit($limit)->order('`id` DESC')->select();
		return $incomeList;
	}
	
	// ��ȡ�����б�ͨ��������ţ�
	public function rByOrder($order_id = 0) {
		$sql = array('order_id' => $order_id);
		$incomeList = $this->where($sql)->select();
		return $incomeList;
	}
}