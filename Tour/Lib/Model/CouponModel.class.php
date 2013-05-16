<?php

class CouponModel extends Model {

	// �����Ż���
	public function c($data = 0) {
		if (empty($data)) $data = $_POST;
		if ( $this->create( $data ) ) {
			$ret = $this->add();
			return $ret;
		} else {
			return $this->getError();
		}
	}
	
	// �����Ż��루�����
	public function cList($data = 0) {
		if (empty($data)) $data = $_POST;
		if ($this->create($data)) {
			$ret = $this->addAll($data);
			return $ret;
		} else {
			return $this->getError();
		}
	}
	
	// �����Ż���
	public function u($data = 0) {
		if (empty($data)) $data = $_POST;
		$coupon = $this->save( $data );
		return $coupon;
	}

	// ��ȡ�Ż���
    public function r($id = 0){
		$sql = array('id' => (int)$id);
		$coupon = $this->where($sql)->find();
		return $coupon;
    }
	
	// ��ȡ�Ż����б�
	public function rList($data = 0) {
		if (empty($data)) $data = $_POST;
		$sql = array('author_id' => $_SESSION['id'], 'type_id' => (int)$data['type_id'], 'line_id' => (int)$data['line_id'], 'price' => (int)$data['price'], 'generate_time' => (int)$data['generate_time']);
		$couponList = $this->where($sql)->order('`used` ASC')->select();
		return $couponList;
	}
	
	// ��ȡ�Ż�ȯ��ͨ�����룩
	public function rByCode($code = 0) {
		$sql = array('code' => $code);
		$coupon = $this->where($sql)->find();
		return $coupon;
	}
	
	// ��ȡ�Ż�ȯ�����б�ͨ�����飩
	public function rListByGroup() {
		$sql = array('author_id' => $_SESSION['id']);
		$couponList = $this->field('COUNT(1) AS `count`,`type_id`,`line_id`,`price`,`generate_time`')->where($sql)->group('`author_id`,`type_id`,`line_id`,`price`,`generate_time`')->order('`id` DESC')->select();
		return $couponList;
	}
}