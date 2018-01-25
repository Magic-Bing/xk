<?php
namespace Common\Model;


/**
 * 代金券
 *
 * @create 2016-11-24
 * @author zlw
 */
class VoucherModel extends BaseModel
{

    /**
     * 表名
     *
     * @create 2016-11-24
     * @author zlw
     */
    protected $tableName = 'voucher';


    /**
     * 去掉不符合的代金券
     *
     * @create 2016-12-01
     * @author zlw
     */
    public function unsetVoucherByProjectId($vouchers)
    {
        if (!empty($vouchers)) {
            foreach ($vouchers as $key => $voucher) {
                $nowVoucher = $this->getOneById($voucher['voucher_id']);
                if ($nowVoucher['use_quantity'] + $voucher['voucher_num'] > $nowVoucher['quantity']) {
                    unset($vouchers[$key]);
                }
            }
        }

        return $vouchers;
    }


    /**
     * 更改代金券使用数量
     *
     * @create 2016-12-01
     * @author zlw
     */
    public function updateQuantityByProjectId($projectId)
    {
        $VoucheractivityattrView = D("VoucheractivityattrView");

        $where['activity_project_id'] = $projectId;
        $vouchers = $VoucheractivityattrView->getListByGroup(
            $where,
            'voucher_id as voucher_id, sum(VoucherActivityAttr.quantity) as total_quantity, VoucherActivity.project_id as project_id',
            'voucher_id'
        );

        if (!empty($vouchers)) {
            foreach ($vouchers as $voucher) {
                $nowVoucher = $this->getOneById($voucher['voucher_id']);
                if ($voucher['total_quantity'] >= $nowVoucher['quantity']) {
                    $total_quantity = $nowVoucher['quantity'];
                } else {
                    $total_quantity = $voucher['total_quantity'];
                }

                $data['open_quantity'] = $total_quantity;
                $this->editOneById($voucher['voucher_id'], $data);
            }
        }

        return true;
    }

}

