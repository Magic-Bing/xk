<?php
namespace Common\Model;

use Think\Model;

/**
 * 房间表
 *
 * @create 2016-8-22
 * @author zlw
 */
class RoomModel extends Model 
{
	
	/**
	 * 获取房间
	 *
	 * @create 2016-8-24
	 * @author zlw
	 */
	public function getRoom($where)
	{
		return $this->where($where)->find();
	}

	
	/**
	 * 获取房间
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function getRoomById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->find();
	}
	

	/**
	 * 获取房间列表
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function getRoomList(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*'
	) {
		return $this->field($field)
				->where($where)
				->order($orderBy)
				->select();
	}
        
        public function getRoomListJoinhx(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = 'xk_room.*,hxmx'
	) {
		return $this->field($field)
				->where($where)
                                ->join('LEFT JOIN (select a.proj_id,a.pc_id,a.id as bld_id,b.hx as hux,b.hxmx from xk_build a join xk_hxset b on a.proj_id=b.project_id and a.pc_id=b.batch_id) as __KPPC__ ON __KPPC__.proj_id = __ROOM__.proj_id AND __KPPC__.bld_id = __ROOM__.bld_id AND __KPPC__.hux = __ROOM__.hx ')
                              
				->order($orderBy)
				->select();
	}
        
        
        /**
	 * 获取房间列表 微信认购
	 *
	 * @create 2017-04-26
	 * @author jxw
	 */
	public function getRoomListJoinWxrg(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = '*'
	) {
		return $this->field($field)
				->where($where)
                                ->join('LEFT JOIN (select id as wxrg_id,cst_name,cst_id,cztime,room_id from xk_wxrglog  where status=1) as __WXRG__ ON __WXRG__.room_id = __ROOM__.id')
				->order($orderBy)
				->select();
	}
	
        /**
	 * 获取房间列表 热销top10
	 *
	 * @create 2016-10-09
	 * @author jxw
	 */
	public function getRoomListJoinAttribute(
		array $where = array(), 
		$orderBy = 'id DESC',
		$field = 'xk_room.*'
	) {

	    if($where){
	        $where1=[];
	        foreach ($where AS $key=>$value){
                $where1['xk_room.'.$key]=$value;
	        }
        }
        $md=session("chooseuid");
	    if(!$md){
            $md=session("user_id");
            if(!$md){
                $md=cookie("user_id");
            }
            if(!$md){
                $md=session("USER_ID");
            }
        }
//        echo $md;exit;
		return $this->field($field.",cr.id crid")
				->where($where1)
				->join('LEFT JOIN (select djcount,room_id from xk_roomattribute a left join xk_room b on a.room_id=b.id where djcount>0 and b.is_xf=0 order by djcount desc limit 10 ) as __ROOMATTRIBUTE__ ON __ROOMATTRIBUTE__.room_id = __ROOM__.id')
                ->join("LEFT JOIN (select * from xk_cst2rooms where cst_id =$md) cr ON xk_room.id=cr.room_id ")
				->order($orderBy)
				->select();
	}
        
	
	/**
	 * 获取房间列表
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function getRoomListGroupBy(
		$field, 
		$groupBy, 
		$orderBy = 'id DESC',
		array $where = array()
	) {
		return $this->field($field)
			->where($where)
			->group($groupBy)
			->order($orderBy)
			->select();
	}
	
	
	/**
	 * 条件更改
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function editRoom($data, $where)
	{
		return $this->where($where)->data($data)->save();
	}
	
	
	/**
	 * 单独更改
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
	public function editRoomById($data, $id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->data($data)->save();
	}

	
	/**
	 * 获取单个
	 *
	 * @create 2016-9-22
	 * @author zlw
	 */
	public function getOne(
		$where, 
		$field, 
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->find();
	}

	
	/**
	 * 根据ID获取房间
	 *
	 * @create 2016-10-12
	 * @author zlw
	 */
	public function getOneById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->find();
	}

	
	/**
	 * 分组获取单个
	 *
	 * @create 2016-9-23
	 * @author zlw
	 */
	public function getOneByGroup(
		$where, 
		$field, 
		$groupBy = 'id',
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->group($groupBy)
			->order($orderBy)
			->find();
	}

	
	/**
	 * 获取列表
	 *
	 * @create 2016-9-22
	 * @author zlw
	 */
	public function getList(
		$where, 
		$field, 
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->select();
	}

	
	/**
	 * 获取列表
	 *
	 * @create 2016-9-22
	 * @author zlw
	 */
	public function getListByGroup(
		$where, 
		$field, 
		$groupBy = 'id',
		$orderBy = 'id DESC',
		$limit = ''
	) {
		return $this->field($field)
			->where($where)
			->group($groupBy)
			->order($orderBy)
			->limit($limit)
			->select();
	}

    /**
     * 获取 栋 最小的单元
     *
     * @param $buildingIds array int
     *
     * @return array
     */
    public function getAllUnitsByBuilding($buildingIds){

        return $this->where(['bld_id'=>['in',$buildingIds]])->field('bld_id,unit')->group('bld_id,unit')->order('unit asc')->select();
    }

    /**
     * 获取房间列表 栋正序 单元正序 楼层排倒 房间号正
     *
     * @param $buildingId int
     * @param $unit int
     * @author zlw
     */
    public function getRoomListOrderFloorDescNoAscByBuildingIdUnitId($buildingId,$unit) {

        return $this
            ->where(['bld_id'=>$buildingId,'unit'=>$unit])
            ->order('unit asc,CAST(floor as UNSIGNED) ,no desc')
            ->select();

    }


    public function getRoomAttrByBuildingIdBatchId($buildingId,$batchId){

        $buildingId = intval($buildingId);
        $batchId = intval($batchId);

        $sql="
        SELECT 
            room.id,
            kppc.name batch_name,
            project.name project_name,
            build.buildname,
            room.unit,
            room.floor,
            room.no,
            room.room,
            room.hx,
            round(attr.djcount/2,0) as djcount,
            attr.sccount,
            attr.sscount
        FROM
            xk_room room
                LEFT JOIN
            xk_project project ON project.id = room.proj_id
                LEFT JOIN
            xk_build build ON build.id = room.bld_id
                LEFT JOIN
            xk_kppc kppc ON kppc.id = build.pc_id
                LEFT JOIN
            xk_roomattribute attr ON attr.room_id = room.id
        WHERE
            project.status = 1 AND kppc.is_yx = 1
                AND project.id = {$buildingId}
                AND kppc.id = {$batchId}
        ORDER BY build.buildcode , room.unit , CAST(room.floor as unsigned), room.no
        ;
        ";

        return $this->query($sql);
    }

    public function getRoomsByBuildingIdBatchId($buildingId,$batchId){
        $buildingId = intval($buildingId);
        $batchId = intval($batchId);

        $sql="
        SELECT 
            room.id,
            kppc.name batch_name,
            project.name project_name,
            build.buildname,
            room.unit,
            room.floor,
            room.no,
            room.room,
            room.hx
        FROM
            xk_room room
                LEFT JOIN
            xk_project project ON project.id = room.proj_id
                LEFT JOIN
            xk_build build ON build.id = room.bld_id
                LEFT JOIN
            xk_kppc kppc ON kppc.id = build.pc_id
        WHERE
            project.status = 1 AND kppc.is_yx = 1
                AND project.id = {$buildingId}
                AND kppc.id = {$batchId}
        ORDER BY build.buildcode , room.unit , CAST(room.floor as unsigned), room.no
        ;
        ";
        return $this->query($sql);
    }

} 








