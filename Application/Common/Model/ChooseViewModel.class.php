<?php

namespace Common\Model;


/**
 * 竞价选房视图
 *
 * @create 2016-12-19
 * @author zlw
 */
class ChooseViewModel extends BaseViewModel 
{
	
	/**
	 * 视图配置
	 *
     * @create 2016-12-19
	 * @author zlw
	 */
	public $viewFields = array(
		'Choose' => array(
			'id' 			=> 'id',
			'project_id' 	=> 'project_id',
			'batch_id' 		=> 'batch_id',
			'customer_name'  => 'customer_name',
			'customer_phone' => 'customer_phone',
            'cardno' => 'cardno',
            'cyjno' => 'cyjno',
			'row_number' 	=> 'row_number',
			'money' 		=> 'money',
			'area' 			=> 'area',
			'price' 		=> 'price',
			'house_type' 	=> 'house_type',
			'floor' 		=> 'floor',
			'room' 			=> 'room',
			'password' 		=> 'password',
			'status' 		=> 'status',
			'add_time' 		=> 'add_time',
			'add_ip' 		=> 'add_ip',
            'ywy' 		=> 'ywy',
            'ywyphone' 		=> 'ywyphone',
			'_type' => 'LEFT'
		),
		'Project' => array(
			'id' 		=> 'project_id',
			'name' 		=> 'project_name',
			'cp_id' 	=> 'project_cp_id',
			'address' 	=> 'project_address',
			'mobile' 	=> 'project_mobile',
			'projfzr' 	=> 'project_projfzr',
			'createdate' 	=> 'project_createdate',
			'status' 	=> 'project_status',
			'_on' 	=> 'Choose.project_id = Project.id',
			'_type' => 'LEFT'
		),
		'Kppc' => array(
			'id' 		 => 'batch_id',
			'proj_id' 	 => 'batch_project_id',
			'name' 		 => 'batch_name',
			'kptime' 	 => 'batch_open_time',
			'roomscount' => 'batch_rooms_count',
			'_on' 	=> 'Choose.batch_id = Kppc.id',
			'_type' => 'LEFT'
		),
        'roomlist' => array(
            '_as' => 'rm1',
            'rm1.id'    => 'room_id',
            'rm1.buildname' => 'buildname',
            'rm1.unit' => 'unit',
            'rm1.floor' => 'floor',
            'rm1.room' => 'rm',
            '_on' 	=> 'rm1.cstid = Choose.id',
            '_type' => 'LEFT',
        ),
        'roomlist ' => array(
            '_as' => 'rm2',
            'rm2.buildname' => 'buildname_one',
            'rm2.unit' => 'unit_one',
            'rm2.floor' => 'floor_one',
            'rm2.room' => 'rm_one',
            '_on' 	=> 'rm2.id = Choose.room',
            '_type' => 'LEFT'
        ),
        'user' => array(
            '_as' => 'us',
            'us.id' => 'us_id',
            '_on' 	=> 'us.name = Choose.ywy',
            '_type' => 'LEFT'
        ),

	);
	
} 

