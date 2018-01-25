<?php
namespace Common\Model;

use Think\Model;

/**
 * 模型基类
 *
 * @create 2016-11-24
 * @author zlw
 */
class EventOrderHouseModel extends Model
{

    protected $tableName = 'event_order_house';

	/**
	 * 获取单个
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function getOne(
		$where, 
		$field = '*', 
		$orderBy = 'id DESC'
	) {
		return $this->field($field)
			->where($where)
			->order($orderBy)
			->find();
	}
	
	/**
	 * 根据ID获取单个
	 *
	 * @create 2016-11-24
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
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function getOneByGroup(
		$where, 
		$field = '*', 
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
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function getList(
		$where, 
		$field = '*', 
		$orderBy = 'id DESC',
		$limit = ''
	) {
		return $this->field($field)
                        ->join("INNER JOIN (select id as bid,proj_id, name as batch_name from xk_kppc where is_yx =1) pc ON xk_event_order_house.batch_id=pc.bid  and xk_event_order_house.project_id=pc.proj_id")
			->where($where)
			->order($orderBy)
			->limit($limit)
			->select();
	}
	
	/**
	 * 分组获取列表
	 *
	 * @create 2016-11-24
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
	 * 添加单个
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function addOne($data)
	{
		return $this->data($data)->add();
	}
	
	/**
	 * 更改
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function editOne($where = array(), $data)
	{
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 根据ID更改单个
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function editOneById($id, $data)
	{
		$where['id'] = $id;
		return $this->where($where)->data($data)->save();
	}
	
	/**
	 * 删除
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function deleteOne($where)
	{
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID删除单个
	 *
	 * @create 2016-11-24
	 * @author zlw
	 */
	public function deleteOneById($id)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->delete();
	}
	
	/**
	 * 根据ID添加次数等
	 *
	 * @create 2016-12-01
	 * @author zlw
	 */
	public function setIncById($id, $name, $num = 1)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->setInc($name, $num);
	}
	
	/**
	 * 根据ID减少次数等
	 *
	 * @create 2016-12-01
	 * @author zlw
	 */
	public function setDecById($id, $name, $num = 1)
	{
		$where = array(
			'id' => $id
		);
		return $this->where($where)->setDec($name, $num);
	}


	private static $redis = null;

    /**
     * @return \Redis
     */
	private function getRedis(){
        $redis = &self::$redis;
        if (self::$redis===null){
            $redisHost = C('REDIS_HOST');
            $redis = new \Redis();
            $redis->connect($redisHost);
        }
        return $redis;
    }

    /**
     * 从数据库全部初始化到Redis
     *
     * @param $eventId int
     * @param $status int 强制初始化
     * @return array|boolean
     */
    public function initializeByIdToRedis($eventId,$status=0){ 
        $TIME = time();

        $eventId = intval($eventId);
        if (empty($eventId))
            return array('error_code'=>1,'info'=>'无活动ID');

        $eventRedisKey = "event_order_house_{$eventId}";
        $eventFields = array('start_time','end_time','project_id','batch_id','name','maxcount','desc','mark','states','isyks','isdx','isysdl','is_show_discount');

        $event = $this->getOne(array('id'=>$eventId),array('project_id','batch_id','name','start_time','end_time','states','maxcount','desc','mark','states','0 as isyks','0 as isdx','isysdl','is_show_discount'));

        if (empty($event))
            return array('error_code'=>1,'info'=>'无活动');
        
        //清空活动相关缓存
        $this->cleanAllById($eventId);

        if ($TIME<$event['start_time'] && $status===0)
            return array('error_code'=>1,'info'=>'活动未开始');

        if ($TIME>$event['end_time'] && $status===0)
            return array('error_code'=>1,'info'=>'活动已结束');

        if (empty($event['states']) && $status===0)
            return array('error_code'=>1,'info'=>'活动未启用');

        $sql = "
        SELECT 
            room.id,
            build.id build_id,
            build.buildname,
            room.unit,
            room.floor,
            room.no,
            room.room,
            room.area,
            room.price,
            room.total,
            room.discount,
            room.is_xf status,
            room.hx,
            hx.hxmx,
            room.tnarea,
            room.tnprice,
            room.proj_id project_id,
            room.cp_id company_id,
            room.schedule_phone schedule_phone,
            build.pc_id batch_id,
            build.bldtype,
            kppc.name batch_name,
            project.name project_name,
            od.belong_phone belong_phone
        FROM
            xk_room room
                LEFT JOIN
            xk_project project ON project.id = room.proj_id
                LEFT JOIN
            xk_build build ON build.id = room.bld_id
                LEFT JOIN
            xk_kppc kppc ON kppc.id = build.pc_id
                LEFT JOIN
            xk_hxset hx ON  build.pc_id=hx.batch_id and room.proj_id=hx.project_id and room.hx=hx.hx
                LEFT JOIN
            xk_order_house_order od ON room.id=od.room_id
        WHERE
            project.status = 1 AND kppc.is_yx = 1
                AND project.id = {$event['project_id']}
                AND kppc.id = {$event['batch_id']}
        ORDER BY build.bldtype, build.buildcode , room.unit , CAST(room.floor as UNSIGNED) desc, room.no
        ;
        ";

        $expire_time = $event['end_time']-$TIME+1;

        $rooms = $this->query($sql);
        
        //本次活动最大编号
        $maxcode=0;
        $sql1="select max(code) as code from xk_order_house_order where event_id={$eventId} and project_id={$event['project_id']};";
        $codes = $this->query($sql1);
        if($codes)
        {
            $maxcode=(int)$codes[0]['code'];
        }
        
        $redis = $this->getRedis();

        //某单元所有房间在redis中的集合
        $roomsRedisKeys = null;
        //栈 占用
        $roomRedisKey = null;
        //room记录字段
        $roomFields = array('id','build_id','buildname','project_id','project_name','company_id','batch_id','batch_name','bldtype','unit','hx','hxmx','floor','no','room','area','price','tnprice','tnarea','total','discount','status','schedule_phone');

        //临时变量
        $tempUnitRedisKey = null;
        //正在记录的单元的 redis key
        $unitRedisKey = null;
        $unitName = null;

        //所有栋在redis中的集合
        $buildingsRedisKeys = array();
        //临时记录栋名称
        $tempBuildingRedisKey = null;  
        $buildingName = null;
        $buildingtype = null;
        $buildingid = null;
        //正在记录的栋的redis key
        $buildingRedisKey = null;

        $msg = null;
        $j=0;
        for ($i=0;$i<count($rooms);$i++){
            //生成房间redis key
            $roomRedisKey = "event_order_house_{$eventId}_room_{$rooms[$i]['id']}";

            //收藏排序使用
            $redis->zAdd("event_order_house_{$eventId}_room_collection_sort",0,$rooms[$i]['id']);

            //根据房间记录字段做hash
            foreach ($roomFields as $roomField) {
                $redis->hSet($roomRedisKey,$roomField,$rooms[$i][$roomField]);
            }
            $jminfo=encrypt_url("eventId/{$eventId}/rid/{$rooms[$i]['id']}", getUrlkey());
            $redis->hSet($roomRedisKey,jminfo,$jminfo);
            
            $redis->expire($roomRedisKey,$expire_time);

            //生成 单元(redis key)
            $tempUnitRedisKey = "event_order_house_{$eventId}_build_{$rooms[$i]['build_id']}_unit_{$rooms[$i]['unit']}";

            //检查是否为新的单元
            if ($unitRedisKey != $tempUnitRedisKey){

                //把之前所记录 单元 (unit redis key) 放进 对应的 栋(redis) 中
                if (!empty($unitRedisKey)){
                    //把正在使用的的 单元 设置过期
                    $redis->expire($unitRedisKey,$expire_time);

                    //把上一个记录的单元加入对应的栋redis集合中
                    $msg = msgpack_pack(array($unitRedisKey,$unitName));
                    $redis->zAdd($buildingRedisKey,0,$msg);
                }
                
                //修改正在使用的单元 为 新的单元 redis key
                $unitRedisKey = $tempUnitRedisKey;
                $unitName = $rooms[$i]['unit'];
            }

            //把正在使用的redis key 放入
            $redis->rPush($unitRedisKey,$roomRedisKey);

            //生成栋redis key 提供给单元使用
            $tempBuildingRedisKey = "event_order_house_{$eventId}_build_{$rooms[$i]['build_id']}";

            //检测是否为新的单元
            if ($buildingRedisKey!=$tempBuildingRedisKey){

                //把之前的记录 栋 (building redis key) 放进 $buildingsRedisKeys 中
                if (!empty($buildingRedisKey)){
                    //把正在使用的 栋 设置过期
                    $redis->expire($buildingRedisKey,$expire_time);

                    //把正在使用的栋加入 栋 集合中
                    $buildingsRedisKeys[] = array($buildingRedisKey,$buildingName,$buildingid,$buildingtype);
                }

                //修改为新的栋
                $buildingRedisKey = $tempBuildingRedisKey;
                $buildingName = $rooms[$i]['buildname'];
                $buildingtype = $rooms[$i]['bldtype'];
                $buildingid=$rooms[$i]['build_id'];
            }
            //已售房源
            if($rooms[$i]['status']==1)
            {
                $redis->set("event_order_house_{$eventId}_room_{$rooms[$i]['id']}_locked",1,$expire_time);
                $redis->sAdd("event_order_house_{$eventId}_room_ordered",$rooms[$i]['id']);
                $redis->sAdd("event_order_house_{$eventId}_room_order_phone",$rooms[$i]['belong_phone']);
                $redis->expire("event_order_house_{$eventId}_room_order_phone",$expire_time);
            }
            //预定房源
            if($rooms[$i]['schedule_phone'])
            {
                 $redis->hSet("event_order_house_{$eventId}_room_order_member",$j,$rooms[$i]['id']);
                 $redis->expire("event_order_house_{$eventId}_room_order_member",$expire_time);
                 $j++;
            }

        }

        //修复 由于 上面 算法 会导致最后一位的 单元（无法加入对应栋），栋（无法加入对应栋的集合中） 无法触发 需要将最后一位的  的redis key 放进 最后一位的 栋中

        //修复单元
        $redis->expire($unitRedisKey,$expire_time);
        $msg = msgpack_pack(array($unitRedisKey,$unitName));
        $redis->zAdd($buildingRedisKey,0,$msg);
        $redis->expire($buildingRedisKey,$expire_time);

        //修复栋
        $buildingsRedisKeys[] = array($buildingRedisKey,$buildingName,$buildingid,$buildingtype);

        foreach ($eventFields as $eventField) {
            $redis->hSet($eventRedisKey,$eventField,$event[$eventField]);
        }

        $msg = msgpack_pack($buildingsRedisKeys);
        $redis->hSet($eventRedisKey,'building_hash',$msg);
        
        $sqltemp="select hx from xk_hxset where batch_id={$event['batch_id']} and project_id={$event['project_id']};";
        $hxlist = $this->query($sqltemp);
        foreach($hxlist as $hx)
        {
            $allhx[]=$hx['hx'];
        }
        $allhx=msgpack_pack($allhx);
        $redis->hSet($eventRedisKey,'allhx',$allhx);

        //占位 已经预定的房间
        $redis->sAdd("event_order_house_{$eventId}_room_ordered",0);
        $redis->expire("event_order_house_{$eventId}_room_ordered",$expire_time);

        //活动状态，以第一个选房为准
        //$redis->set("event_{$eventId}_status",0);
        //$redis->expire("event_{$eventId}_status",$expire_time);

        $redis->expire("event_order_house_{$eventId}_room_collection_sort",$expire_time);
        $redis->expire($eventRedisKey,$expire_time);
        
        $redis->set("event_order_house_{$eventId}_maxcode",$maxcode);
        $redis->expire("event_order_house_{$eventId}_maxcode",$expire_time);

        return true;
    }


    public function cleanAllById($eventId){

        $eventId = intval($eventId);
        if (empty($eventId))
            return array('error_code'=>1,'info'=>'无活动ID');

        $redis = $this->getRedis();

        $eventRedisKey = "event_order_house_{$eventId}";

        if($redis->exists($eventRedisKey)){
            $iterator = null;
            while($keys = $redis->scan($iterator,"event_order_house_{$eventId}_*")) {
                foreach($keys as $key) {
                    $redis->del($key);
                }
            }
        }

        $redis->del($eventRedisKey);

        return true;
    }
    
    public function cleanLogById($eventId){

        $eventId = intval($eventId);
        if (empty($eventId))
            return array('error_code'=>1,'info'=>'无活动ID');

        $redis = $this->getRedis();

        $dlsx_list = $redis->keys("dlsx_order_house_2_*"); 
        foreach ( $dlsx_list as $value) { 
          $redis->del($value);
        }
        $redis->del("event_{$eventId}_status");
        return true;
    }


    /**
     * 通过活动(ID)获取所有该活动中栋
     *
     * @param $eventId int
     *
     * @return array
     */
    public function getEventByEventId($eventId){
        $redis = $this->getRedis();

        $key = "event_order_house_{$eventId}";
        $result = $redis->hGetAll($key);
        $result['building_hash'] = msgpack_unpack($result['building_hash']);
        $result['allhx'] = msgpack_unpack($result['allhx']);
   
        return $result;
    }

    /**
     * 通过活动(ID)获取所有该活动中单元
     */
    public function getAllUnitByEventId(){

    }

    /**
     * 通过活动(ID)获取所有该活动中单元
     */
    public function getAllRoomsByEventId(){

    }

    /**
     * 通过Redis key获取该栋下所有单元(unit)
     *
     * @param $redisKey int
     * @return array
     */
    public function getUnitsBelongToBuildingByRedisId($redisKey){
        $redis  = $this->getRedis();
        $result = null;
        foreach ($redis->zRange($redisKey,0,-1) as $item) {
            $result[] = msgpack_unpack($item);
        }
        return $result;
    }

    /**
     * 通过栋(ID)获取该栋下所有单元(unit)
     *
     * @param $eventId int
     * @param $buildingId int
     * @return array
     */
    public function getUnitsBelongToBuildingByEventIdBuildingId($eventId,$buildingId){
        $redis  = $this->getRedis();
        $key = "event_order_house_{$eventId}_build_{$buildingId}";
        return $redis->zRange($key,0,-1);
    }

    public function getRoomsKeyBelongToUnitByRedisId($redisKey){
        $redis = $this->getRedis();

        return $redis->lRange($redisKey,0,-1);
    }

    /**
     *
     * 通过单元(unit)获取该栋下所有房间(room)
     *
     * @param $unitRedisKey int
     * @return array
     */
    public function getRoomsBelongToUnitByRedisId($unitRedisKey){
        $redis = $this->getRedis();

        $roomsKey = $this->getRoomsKeyBelongToUnitByRedisId($unitRedisKey);
        $result = array();
        foreach ($roomsKey as $roomKey)
            $result[] = $redis->hGetAll($roomKey);


        return $result;
    }

    /**
     *
     * 通过redis key 获取房间
     *
     * @param $redisKeys array[int]
     * @return array
     */
    public function getRoomsByRedisKeys($redisKeys){
        $redis = $this->getRedis();

        $result = array();
        foreach ($redisKeys as $redisKey) {
            $result[] = $redis->hGetAll($redisKey);
        }

        return $result;

    }

    /**
     *
     * 通过redis key 获取房间
     *
     * @param $redisKey int
     * @return array
     */
    public function getRoomByRedisKey($redisKey){
        $redis = $this->getRedis();

        return $redis->hGetAll($redisKey);
    }


    /**
     *
     * 通过单元(unit)获取该栋下所有房间(room)
     *
     * @param $eventId int
     * @param $buildingId int
     * @param $unitId int
     * @return array
     */
    public function getRoomsBelongToUnitByEventIdBuildingUnit($eventId,$buildingId,$unitId){
        $redis = $this->getRedis();

        $key = "event_order_house_{$eventId}_build_{$buildingId}_unit_{$unitId}";
        return $redis->zRange($key,0,-1);
    }

    /**
     * 通过 活动ID (eventId) 房间ID (roomId) 增加排行分数
     *
     * @param $eventId int
     * @param $roomId int
     */
    public function IncrementRoomScoreByEventIdRoomId($eventId,$roomId){
        $redis = $this->getRedis();

        $redis->zIncrBy("event_order_house_{$eventId}_room_collection_sort",1,$roomId);
    }

    /**
     * 通过 活动ID (eventId) 房间ID (roomId) 减少排行分数
     *
     * @param $eventId int
     * @param $roomId int
     */
    public function ReductionRoomScoreByEventIdRoomId($eventId,$roomId){
        $redis = $this->getRedis();

        $redis->zIncrBy("event_order_house_{$eventId}_room_collection_sort",-1,$roomId);
    }

    /**
     * @param $eventId
     *
     * @return array
     *
     */
    public function getRoomCollectionSort($eventId){
        $redis = $this->getRedis();

       return $redis->zRangeByScore("event_order_house_{$eventId}_room_collection_sort",'1','+inf',['limit'=>0,10]);
    }

    /**
     * @param $eventId
     *
     * @return array
     */
    public function getAllOrderedRoomInRedis($eventId){
        $redis = $this->getRedis();
        return $redis->sMembers("event_order_house_{$eventId}_room_ordered");
    }

}
