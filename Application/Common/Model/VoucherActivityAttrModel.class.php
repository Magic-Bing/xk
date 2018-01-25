<?php
namespace Common\Model;


/**
 * 代金券活动 - 选择代金券
 *
 * @create 2016-11-28
 * @author zlw
 */
class VoucherActivityAttrModel extends BaseModel 
{
	
	/**
	 * 表名
	 *
	 * @create 2016-11-28
	 * @author zlw
	 */
	protected $tableName = 'voucher_activity_attr';

	/**
	 * 添加代金券列表
	 * 
	 * $data = [[voucher_id, voucher_num]]
	 *
	 * @create 2016-11-30
	 * @author zlw
	 */
	public function addVouchers($activity_id, $data = array(), $add_user_id = '0')
	{
		$hasWhere['activity_id'] = $activity_id;
		$hasAttrs = $this->where($hasWhere)->select();
		
		$hasVouchers = array();
		foreach ($hasAttrs as $hasAttr) {
			$hasVouchers[] = $hasAttr['voucher_id'];
		}
		
		$putVouchers = array();
		$putVoucherQuantity = array();
		foreach ($data as $dataValue) {
			$putVouchers[] = $dataValue['voucher_id'];
			
			//格式化输入数据
			$putVoucherQuantity[$dataValue['voucher_id']] = $dataValue['voucher_num'];
		}
		
		//删除多余代金券
		$deleteVouchers = array_diff($hasVouchers, $putVouchers);
		if (!empty($deleteVouchers)) {
			foreach ($deleteVouchers as $deleteVoucher) {
				$this->deleteVoucher($activity_id, $deleteVoucher);
			}
		}

		//添加新的代金券
		if (!empty($putVouchers)) {
			foreach ($putVouchers as $putVoucher) {
				$addData['activity_id'] = $activity_id;
				$addData['voucher_id'] = $putVoucher;
				$addData['quantity'] = $putVoucherQuantity[$putVoucher];
				$addData['add_user_id'] = $add_user_id;
				$this->addVoucher($addData);
			}
		}
		
		return true;
	}

	/**
	 * 添加代金券
	 * 
	 * $data = [activity_id, voucher_id, quantity, add_user_id]
	 *
	 * @create 2016-11-30
	 * @author zlw
	 */
	public function addVoucher($data = array())
	{
		if (empty($data)) {
			return false;
		}

		$hasWhere['activity_id'] = $data['activity_id'];
		$hasWhere['voucher_id'] = $data['voucher_id'];
		$hasAttr = $this->where($hasWhere)->find();
		
		if (empty($hasAttr)) {
			if (!isset($data['add_time'])) {
				$data['add_time'] = time();
			}
			if (!isset($data['add_ip'])) {
				$data['add_ip'] = get_client_ip(0, false);
			}
			
			return $this->data($data)->add();
		} else {
			$editWhere['activity_id'] = $data['activity_id'];
			$editWhere['voucher_id'] = $data['voucher_id'];
			$editData['quantity'] = $data['quantity'];
			return $this->where($editWhere)->data($editData)->save();
		}
	}
	
	/**
	 * 删除单个代金券
	 *
	 * @create 2016-11-30
	 * @author zlw
	 */
	public function deleteVoucher($activity_id, $voucher_id)
	{
		$deleteWhere['activity_id'] = $activity_id;
		$deleteWhere['voucher_id'] = $voucher_id;
		return $this->where($deleteWhere)->delete();
	}
	
} 


