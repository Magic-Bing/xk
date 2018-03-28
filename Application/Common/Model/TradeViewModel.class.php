<?php

namespace Common\Model;

/**
 * 交易视图
 *
 * @create 2016-12-19
 * @author zlw
 */
class TradeViewModel extends BaseViewModel {

    /**
     * 视图配置
     *
     * @create 2017-09-19
     * @author jxw
     */
    public $viewFields = array(
        'Trade' => array(
            'id' => 'id',
            'yw_id' => 'yw_id',
            'room_id' => 'room_id',
            'cst_id' => 'cst_id',
            'source' => 'source',
            'status' => 'status',
            'isyx' => 'isyx',
            'code' => 'code',
             'cjtotal' => 'cjtotal',
            'tradetime' => 'trade_time',
            'pay' => 'pay',
            'proportion' => 'proportion',
            'money' => 'money',
            'createdbyid' => 'createdbyid',
            'createdby' => 'createdby',
            '_type' => 'LEFT'
        ),
        'Roomlist' => array(
            'bld_id' => 'bld_id',
            'pc_id' => 'batch_id',
            'proj_id' => 'project_id',
            'projname' => 'project_name',
            'pcname' => 'batch_name',
            'buildcode' => 'bld_code',
            'buildname' => 'bld_name',
            'unit' => 'unit',
            'floor' => 'floor',
            'no' => 'no',
            'room' => 'room',
            'hx' => 'hx',
            'area' => 'area',
            'total' => 'total',
            'is_xf' => 'is_xf',
            '_on' => 'Trade.room_id = Roomlist.id',
            '_type' => 'LEFT'
        ),
        'Choose' => array(
            'customer_name' => 'cst_name',
            'customer_phone' => 'cst_phone',
            'batch_id' => 'pcid',
            'project_id' => 'xmid',
            'cardno' => 'cardno',
            'cyjno' => 'cyjno',
            'ywy' => 'ywy',
            'ywyphone' => 'ywyphone',
            '_on' => 'Trade.cst_id = Choose.id',
            '_type' => 'LEFT'
        ),
        'pzcsvalue' => array(
            'id' => 'pvid',
            '_on' => 'pzcsvalue.project_id = Choose.project_id and pzcsvalue.batch_id = Choose.batch_id and pzcsvalue.pzcs_id=7 and pzcsvalue.cs_value=-1',
        ),
    );

}
