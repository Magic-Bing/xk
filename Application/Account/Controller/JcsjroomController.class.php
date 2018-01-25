<?php

namespace Account\Controller;

/**
 * 基础数据管理-房间导入
 *
 * @create 2017-04-17
 * @author jxw
 */
class JcsjroomController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '基础数据设置');

        //设置当前方法
        $this->set_current_action('jcsj_room', 'jcsj');
    }

    /**
     * 房间信息
     *
     * @create 2016-12-19
     * @author zlw
     */
    public function index() {
        $this->set_seo_title("房间导入");
        $this->display();
    }
    
    public function room() {
         
        $Model = new \Think\Model();
		
        //查询条件
        $where 	  	= " where 66=66 ";
        $buildname	= I("buildname","","trim");
        $unit  		= I("unit","","trim");
        $hx   		= I("hx","","trim");
        $room 		= I("room","","trim");
        $excel 		= I("excel",0,"intval");

        if (!empty($buildname) && $buildname<>"") {
			$where .=" and b.buildname like '%". $buildname ."%' " ;
            $this->assign('buildname', $buildname); 
		}
        if (!empty($unit) && $unit<>"") {
			$where .=" and a.unit like '%". $unit ."%' " ;
            $this->assign('unit', $unit); 
		}

        if (!empty($hx) && $hx<>"") {
			$where .=" and a.hx like '%". $hx ."%' " ;
            $this->assign('hx', $hx); 
		}
        if (!empty($room) && $room<>"") {
			$where .=" and a.room like '%". $room ."%' " ;
            $this->assign('room', $room); 
		}

        $projid = I('projid',0,'intval');
        if($excel===1){
            $roomlist=$Model->query("SELECT concat_ws('-',c.name,b.buildname,a.unit,a.room) dz,a.hx,a.area,Format(a.price,2) p1,a.tnarea,Format(a.tnprice,2) p2,Format(a.total,2) p3,Format(a.discount,2) p4,CASE WHEN a.is_xf=0 THEN  '待售' ELSE  '已售' END zt FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ".$where ."and  a.proj_id=" . $projid . "  order by a.id asc ");
            $this->exportExcel("房间数据",['head'=>['房间名称','户型','建筑面积','建筑单价','套内面积','套内单价','标准总价','优惠总价','销售状态']],$roomlist,0);
        }
        $ishaveid=false;
        //可选项目取值
        $user_project_ids = $this->get_user_project_ids();
        //获取项目列表
        $project_where = array();
        //$project_where['status'] = 1;
        if (!empty($user_project_ids)) {
            $project_where['id'] = array('in', $user_project_ids);
        } else {
            $project_where['id'] = '-99999';
        }
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_list_key => $project_list_value) {
                $project_list[] = $project_list_value;
                if(empty($projid))
                {
                    $projid=$project_list_value['id'];
                    $ishaveid=true;
                }
                else if($projid==$project_list_value['id'])
                {
                    $ishaveid=true;
                }
            }
        } else {
            $project_list = array();
        }
        $this->assign('projlist', $project_list);
        
        if(!empty($projid) && !$ishaveid)
        {
             $this->error("项目错误，请选择正确的项目！");
        }
        if (!empty($projid) && $projid<>0) {   
            $selectedproj=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.id=" .$projid. " and 2=2 order by b.id asc,a.id asc" );
            $this->assign('selectedproj', $selectedproj[0]);
            
            //房间列表
            $allroom=$Model->query("SELECT a.* FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ".$where ." and  a.proj_id=" . $projid );
            $count = count($allroom);
            $listRows = I('r', '10', 'intval');
		
            //分页
            $Page = $this->bootstrapPage($count, $listRows);
            $page_show  = $Page->show();
            $total_pages = $Page->totalPages;

            //房间列表
            $limit = 'limit '.$Page->firstRow.','.$Page->listRows;
            $roomlist=$Model->query("SELECT a.*,b.buildname,c.name as projname FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ".$where ."and  a.proj_id=" . $projid . "  order by a.id asc ".$limit );
			
            $this->assign('projid', $projid); 
            $p = I('p', '1', 'intval');
            $this->assign('p', $p);
            $this->assign('total_pages', $total_pages);
            $this->assign('page_show', $page_show); 
            $this->assign('count', $count);
            $this->assign('listRows', $listRows);;
            $this->assign('roomlist', $roomlist); 
        } 
        $this->set_seo_title("房间导入");
        $this->display();
     }
     
     /**
     * 编辑房间信息
     *
     * @create 2017-05-02
     * @author zlw
     */
    public function edit() {
        $id = I('id', 0, 'intval');
        if ($id == 0) {
            $this->error("房间不存在，请确认后重试！");
        }
        $this->assign('id', $id);
        
        $roominfo=D('Roomview')->getOneById($id);
        $this->assign('roominfo', $roominfo);
        $this->set_seo_title("房间导入");
        $this->display();
    }
     
     /**
	 * 导出数据
	 *
	 * @create 2016-10-9
	 * @author zlw
	 */
	public function exportfj()
    {
		$project_id = I("projid", '', 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error('项目不存在，请重试！');
		}
		
		//房间信息
		$rooms_list = array(
			array(
				'buildname' => '10栋',
				'unit' => '55',
				'floor' => '12',
				'no' => (string) '01',
				'hx' => 'A2',
				'area' => '90',
				'tnarea' => '80',
				'price' => '8000',
				'tnprice' => '10500',
				'total' => '810000',
				'discount' => '800000',
			),
			array(
				'buildname' => '6栋',
				'unit' => '55',
				'floor' => '11',
				'no' => '02',
				'hx' => 'A1',
				'area' => '90',
				'tnarea' => '80',
				'price' => '8100',
				'tnprice' => '11500',
				'total' => '910000',
                'discount' => '900000',
			),
		);
		
		//格式化数据
        $data = array();
        foreach ($rooms_list as $k => $rooms_info) {
            $data[$k]['buildname'] 	= $rooms_info['buildname'];
            $data[$k]['unit'] 		= $rooms_info['unit'];
            $data[$k]['floor'] 		= $rooms_info['floor'];
            $data[$k]['no'] 		= $rooms_info['no']." ";
            $data[$k]['hx']  		= $rooms_info['hx'];
            $data[$k]['area']  		= $rooms_info['area'];
            $data[$k]['tnarea']  	= $rooms_info['tnarea'];
            $data[$k]['price'] 		= $rooms_info['price'];
            $data[$k]['tnprice'] 	= $rooms_info['tnprice'];
            $data[$k]['total'] 		= $rooms_info['total'];
            $data[$k]['discount'] 	= $rooms_info['discount'];
        }
		
		//获取项目信息
		$project = D('Common/Project')->getOneById($project_id);

		$headArr = array(
			'title' => array(
				array('项目标识', '_type' => true),
				$project_id,
				'房间模板',
				array('项目名称', '_type' => true),
				$project['name'],
                '',
                array('说明', '_type' => true),
                '此行不可更改！'
			),
			'head'  => array(
				'楼栋',
				'单元',
				'楼层',
				'房号',
				'户型',
				'建筑面积',
				'套内面积',
				'建筑单价',
				'套内单价',
				'标准总价',
				'优惠总价',
			),
		);
		
        $filename = $project['name']."房间列表";

        $this->exportExcel($filename, $headArr, $data,1);
    }
   
    /**
	 * 导出数据
	 *
	 * @create 2016-10-9
	 * @author zlw
	 */
	public function exportcw()
    {
		$project_id = I("projid", '', 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error('项目不存在，请重试！');
		}
		
		//房间信息
		$rooms_list = array(
			array(
				'buildname' => '-1层',
				'room' => (string) '1001',
				'hx' => '标准车位',
				'area' => '9',
				'price' => '8000',
				'total' => '72000',
			),
			array(
				'buildname' => '-2层',
				'room' => '2001',
				'hx' => '子母车位',
				'area' => '16',
				'price' => '8000',
				'total' => '128000',
			),
		);
		
		//格式化数据
        $data = array();
        foreach ($rooms_list as $k => $rooms_info) {
            $data[$k]['buildname'] 	= $rooms_info['buildname'];
            $data[$k]['room'] 		= $rooms_info['room']." ";
            $data[$k]['hx']  		= $rooms_info['hx'];
            $data[$k]['area']  		= $rooms_info['area'];
            $data[$k]['price'] 		= $rooms_info['price'];
            $data[$k]['total'] 		= $rooms_info['total'];
        }
		
		//获取项目信息
		$project = D('Common/Project')->getOneById($project_id);

		$headArr = array(
			'title' => array(
				array('项目标识', '_type' => true),
				$project_id,
				'车位模板',
				array('项目名称', '_type' => true),
				$project['name'],
                '',
                array('说明', '_type' => true),
                '此行不可更改！'
			),
			'head'  => array(
				'楼层',
				'车位号',
				'车位类型',
				'面积',
				'单价',
				'总价',
			),
		);
		
        $filename = $project['name']."车位列表";

        $this->exportExcel($filename, $headArr, $data);
    }


   
	/**
	 * 导出表格
	 *
	 * @create 2016-10-9
	 * @author zlw
	 */
    private function exportExcel(
		$fileName, 
		$headArr, 
		$data,
        $pd
	) {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $date = date("YmdHis",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
		$objProps = $objPHPExcel->getProperties();

		//激活表格
        $objActSheet = $objPHPExcel->getActiveSheet();

        //设置表头
        $headColumn = 1;
        $objActSheet->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00dc93d5');
        if($pd===1){
            $objActSheet->mergeCells("H1:I1");
        }
        foreach ($headArr as $headKey => $headRows) { //行写入
            $headSpan = ord("A");
            foreach ($headRows as $headKeyName => $headValue) {// 列写入
                $headJ = chr($headSpan);
                $objActSheet->getStyle($headJ)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objActSheet->getColumnDimension($headJ)->setWidth(15);
				if (is_array($headValue)) {
					if (isset($headValue['_type'])) {
						/*$objActSheet->getStyle($headJ.$headColumn)
							->getFill()
							->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
							->getStartColor()
							->setRGB('EBE7DC');*/
					
						$objActSheet->getStyle($headJ.$headColumn)->applyFromArray(
							array(
								'font'    => array (
									'bold'      => true,
								),
								'borders' => array (
									'top'     => array (
										'style' => \PHPExcel_Style_Border::BORDER_THIN
									)
								),
							)
						);
						
						unset($headValue['_type']);
					} 
					
					$headValue = $headValue[0];
				}
				
				if ($headKey == 'head') {
					$objActSheet->getStyle($headJ.$headColumn)->applyFromArray(
						array(
							'font'    => array (
								'bold'      => true,
							),
							'borders' => array (
								'top'     => array (
									'style' => \PHPExcel_Style_Border::BORDER_THIN
								)
							),
							'fill' => array (
								'type'       => \PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR ,
								'rotation'   => 90,
								'startcolor' => array (
									'argb' => 'FFA0A0A0'
								),
								'endcolor'   => array (
									'argb' => 'FFFFFFFF'
								)
							)
						)
					);
					
					$objActSheet->getStyle($headJ.$headColumn)
						->getFill()
						->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
						->getStartColor()
						->setRGB('EBE7DC');
				}
				
                $objActSheet->setCellValue($headJ.$headColumn, $headValue);
                $headSpan++;
				
            }
            $headColumn++;
        }
		
		//重新赋值
        $column = $headColumn;

		//写入数据表格
        foreach ($data as $key => $rows) { //行写入
            $span = ord("A");
            foreach ($rows as $keyName => $value) {// 列写入
                $j = chr($span);
				
				if (is_string($value)) {
					$objActSheet->setCellValue($j.$column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
					$objActSheet->getStyle($j.$column)->getNumberFormat()->setFormatCode("@");
				} else {
					$objActSheet->setCellValue($j.$column, $value);
				}
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);
		
        //重命名表
        $objPHPExcel->getActiveSheet()->setTitle('项目填写模板');
		
        $objProps->setCreator("xk")  
            ->setLastModifiedBy("xk")  
            ->setTitle("googs_list")  
            ->setSubject("googs_list Subject")  
            ->setDescription("googs_list Description")  
            ->setKeywords("googs_list Keywords")  
            ->setCategory("googs_list Category");  
		
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
		
		//输出
		ob_clean();
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }
    
    
     //上传方法
    public function upload()
    {
        if (!IS_POST) {
                $this->error("访问错误，请确认后重试！");
        }

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   = 3145728 ;// 设置附件上传大小
        $upload->exts      = array('xls','xlsx','txt');// 设置附件上传类
        $upload->autoSub   = false;
        $upload->rootPath  = './Uploads/';
        $upload->savePath  = '/room/'; // 设置附件上传目录
        //$upload->saveName  = date('YmdHis');

        $info = $upload->uploadOne($_FILES['excel']);
        $filename = './Uploads'.$info['savepath'].$info['savename'];      
        $exts = $info['ext'];

        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->rooms_import($filename, $exts);
        }
    }
    //导入数据方法
    protected function rooms_import($filename, $exts='xls')
    {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel=new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }
        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet(0);
        //获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        //获取总行数
        $allRow=$currentSheet->getHighestRow();
        
        if (empty($allRow)||$allRow<3)
        {
            $this->error('文件内容为空');
        }
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        $buildlist="";
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
                //数据坐标
                $address=$currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                $data[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
                if ($currentColumn=='B')
                {
                    if ($currentRow==1)
                    {
                        $projid= $data[$currentRow][$currentColumn];
                    }
                }
                if ($currentColumn=='A')
                {
                    if($currentRow>2)
                    {
                        if (stristr($buildlist,$data[$currentRow][$currentColumn])<=0)
                        {       
                            $buildlist.=$data[$currentRow][$currentColumn]."|";
                        }
                    }
                }
                if ($currentColumn=='C')
                {
                    if ($currentRow==1)
                    {
                        $mbtype= $data[$currentRow][$currentColumn];
                    }
                }
            }
        }
        if ($mbtype=="房间模板")
        {
            $this->save_import($data,$projid,$buildlist);
        }
        if ($mbtype=="车位模板")
        {
            $this->save_importcw($data,$projid,$buildlist);
        }
        else
        {
            $this->error("数据模板错误！");
        }
    }

    //保存导入数据
    public function save_import($data,$projid,$buildlist)
    {  
        if (empty($projid)||$projid==0)
        {
            $this->error('项目标识有误,请重新导出模板11');
        }
        $Modelr = new \Think\Model(); 
        $projinfo=$Modelr->query("SELECT a.* FROM xk_project a where a.id=" .$projid. " and 66=66 " );
        if (empty($projinfo)||count($projinfo)==0)
        {
            $this->error('项目标识有误,请重新导出模板');
        }
        //生成楼栋信息
        $buildlist=rtrim($buildlist, "|");
        $bulids=explode("|",$buildlist);
        foreach ($bulids as $bulid_k => $bulid_v)
        {
            $bldinfo=$Modelr->query("SELECT a.* FROM xk_build a where a.proj_id=" .$projid. " and buildname='". $bulid_v ."' and 66=66 " );
            if (empty($bldinfo) || count($bldinfo)==0)
            {
                $data1['pc_id']=0;
                $data1['proj_id']=$projinfo[0]['id'];
                $data1['buildname']=$bulid_v;
                //$data1['buildcode']=substr($bulid_v,0,strlen($bulid_v)-1); 
                $data1['buildcode']=(int)$bulid_v;
                $bld = M("build");  
                $bld->add($data1);
            }
        }
        //清空临时表xk_roomtemp
        $sql = 'truncate table xk_roomtemp';
        M()->execute($sql);

        $rooms = M('roomtemp');
        //$add_time = date('Y-m-d H:i:s', time());
        foreach ($data as $k=>$v){
            if($k >= 3){
                $info[$k-2]['proj_id']=$projinfo[0]['id'];
                $info[$k-2]['pc_id']=-99;
                $info[$k-2]['bld_id']=-99;
                $info[$k-2]['cp_id']=$projinfo[0]['cp_id'];
                
                $info[$k-2]['buildname'] = $v['A']."";
                $info[$k-2]['unit'] = $v['B'];
                $info[$k-2]['floor'] = (string)$v['C'];
                $info[$k-2]['no'] = (int)$v['D'];
                $info[$k-2]['room'] =  (string)$v['C']. (string)$v['D'];
                $info[$k-2]['hx'] = $v['E'];
                
                $info[$k-2]['area'] = $v['F'];
                $info[$k-2]['tnarea'] = $v['G'];
                $info[$k-2]['price'] = $v['H'];
                $info[$k-2]['tnprice'] = $v['I'];
                $info[$k-2]['total'] = $v['J'];
                $info[$k-2]['discount'] = $v['K'];
                $info[$k-2]['isadd'] = 1;
                $rooms->add($info[$k-2]);
            }
        }
        //更新楼栋id和批次id
        $SQL="update  xk_roomtemp a,xk_build b set a.bld_id=b.id,a.pc_id=b.pc_id where  a.proj_id=b.proj_id and a.buildname=b.buildname and a.bld_id=-99 ";
        M()->execute($SQL);
        //判断是否为新增房间
        $SQL="update  xk_roomtemp a,xk_room b set a.isadd=0,room_id=b.id where  a.proj_id=b.proj_id and a.bld_id=b.bld_id and a.unit=b.unit and a.floor=b.floor and a.no=b.no ";
        M()->execute($SQL);
        
        $roomadd=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd=1 " );
        if (!empty($roomadd) && count($roomadd)>0)
        {
            //新增房间
            $SQLadd="insert into xk_room (proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total,discount) ";
            $SQLadd.=" select proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total,discount from xk_roomtemp where isadd=1 ";
            $resultadd=M()->execute($SQLadd);
        }
        $roomup=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd = 0 " );
        if (!empty($roomup) && count($roomup)>0)
        {
            //更新房间信息
            $SQLup="update  xk_room a,xk_roomtemp b set a.hx=b.hx,a.area=b.area, a.tnarea=b.tnarea, a.price=b.price, a.tnprice=b.tnprice,a.total=b.total,a.discount=b.discount  where a.id=b.room_id and  b.room_id<>0 and b.isadd=0 ";
            $resultup=M()->execute($SQLup);
        }
        $this->success('房间导入成功', 'room?cz=user&projid='.$projid);

    }
    
    //保存车位导入数据
    public function save_importcw($data,$projid,$buildlist)
    {  
        if (empty($projid)||$projid==0)
        {
            $this->error('项目标识有误,请重新导出模板11');
        }
        $Modelr = new \Think\Model(); 
        $projinfo=$Modelr->query("SELECT a.* FROM xk_project a where a.id=" .$projid. " and 66=66 " );
        if (empty($projinfo)||count($projinfo)==0)
        {
            $this->error('项目标识有误,请重新导出模板');
        }
        //生成楼栋信息
        $buildlist=rtrim($buildlist, "|");
        $bulids=explode("|",$buildlist);
        foreach ($bulids as $bulid_k => $bulid_v)
        {
            $bldinfo=$Modelr->query("SELECT a.* FROM xk_build a where a.proj_id=" .$projid. " and buildname='". $bulid_v ."' and 66=66 " );
            if (empty($bldinfo) || count($bldinfo)==0)
            {
                $data1['pc_id']=0;
                $data1['proj_id']=$projinfo[0]['id'];
                $data1['buildname']=$bulid_v;
                //$data1['buildcode']=substr($bulid_v,0,strlen($bulid_v)-1); 
                $data1['buildcode']=(int)$bulid_v;
                $data1['bldtype']=1; 
                $bld = M("build");  
                $bld->add($data1);
            }
        }
        //清空临时表xk_roomtemp
        $sql = 'truncate table xk_roomtemp';
        M()->execute($sql);

        $rooms = M('roomtemp');
        //$add_time = date('Y-m-d H:i:s', time());
        foreach ($data as $k=>$v){
            if($k >= 3){
                $info[$k-2]['proj_id']=$projinfo[0]['id'];
                $info[$k-2]['pc_id']=-99;
                $info[$k-2]['bld_id']=-99;
                $info[$k-2]['cp_id']=$projinfo[0]['cp_id'];
                
                $info[$k-2]['buildname'] = $v['A']."";
                $info[$k-2]['unit'] = "1";
                $info[$k-2]['floor'] = "1";
                $info[$k-2]['no'] = $k;
                $info[$k-2]['room'] = (string)$v['B'];//车位的房间号可能是按照顺序号生成
                $info[$k-2]['hx'] = (string)$v['C'];
                
                $info[$k-2]['area'] = (float)$v['D'];
                $info[$k-2]['tnarea'] = (float)$v['D'];
                $info[$k-2]['price'] = (float)$v['E'];
                $info[$k-2]['tnprice'] = (float)$v['E'];
                $info[$k-2]['total'] = (float)$v['F'];
                $info[$k-2]['isadd'] = 1;
                $rooms->add($info[$k-2]);
            }
        }
        //更新楼栋id和批次id
        $SQL="update  xk_roomtemp a,xk_build b set a.bld_id=b.id,a.pc_id=b.pc_id where  a.proj_id=b.proj_id and a.buildname=b.buildname and a.bld_id=-99 ";
        M()->execute($SQL);
        //判断是否为新增房间
        $SQL="update  xk_roomtemp a,xk_room b set a.isadd=0,room_id=b.id where  a.proj_id=b.proj_id and a.bld_id=b.bld_id and a.unit=b.unit and a.floor=b.floor and a.no=b.no  and a.room=b.room";
        M()->execute($SQL);
        
        $roomadd=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd=1 " );
        if (!empty($roomadd) && count($roomadd)>0)
        {
            //新增车位
            $SQLadd="insert into xk_room (proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total) ";
            $SQLadd.=" select proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total from xk_roomtemp where isadd=1 ";
            $resultadd=M()->execute($SQLadd);
        }
        $roomup=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd = 0 " );
        if (!empty($roomup) && count($roomup)>0)
        {
            //更新车位信息
            $SQLup="update  xk_room a,xk_roomtemp b set a.hx=b.hx,a.area=b.area, a.tnarea=b.tnarea, a.price=b.price, a.tnprice=b.tnprice,a.total=b.total  where a.id=b.room_id and  b.room_id<>0 and b.isadd=0 ";
            $resultup=M()->execute($SQLup);
        }
        $this->success('车位导入成功', 'room?cz=user&projid='.$projid);

    }
    
    //删除单个房间
    public function delroom(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $Modelr = new \Think\Model(); 
            $roominfo=$Modelr->query("SELECT a.* FROM xk_room a where  id= " .$id);
            if (!empty($roominfo) && count($roominfo)>0)
            {
                $bldid=$roominfo[0]['bld_id'];
                $bldrooms=$Modelr->query("SELECT a.* FROM xk_room a where  bld_id= " .$bldid);
                if (count($bldrooms)==1)
                {
                    $model = M("build");  
                    $model->where('id='.$bldid )->delete();
                }
                $model = M("room");  
                $model->where('id='.$id )->delete();
            }
        }
        $this->success('操作成功！', '',true);
    } 
    
    public function saveroom()
    {
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $total= I('total');
            $area = I('area');
            $price = I('price');
            $tnarea = I('tnarea');
            $tnprice = I('tnprice');
            $discount = I('discount');

            $data['total'] = $total;
            $data['area'] = $area;
            $data['price'] = $price;
            $data['tnarea'] = $tnarea;
            $data['tnprice'] = $tnprice;
            $data['discount'] = $discount;
//            echo json_encode($data);exit;
            $model = M("Room");  
            $chech_has_edit =$model->where('id='.$id)->save($data);
            if (false === $chech_has_edit) {
                $this->error("更改失败，请稍后重试！");
            } else {
                $this->success("更改成功！");
            }
        }
    }

    //批量删除
    public function delete_batch(){
        $id_arr=I("post.sz/a");
        $roominfo=M()->query("SELECT bld_id FROM xk_room  where  id= " .$id_arr[0]);
        $arr_string=implode(",",$id_arr);
        $model = M("room");
        $model->where("id in({$arr_string})")->delete();
        $bldrooms=M()->query("SELECT a.* FROM xk_room a where  bld_id= " .$roominfo[0]['bld_id']);
        if (count($bldrooms)==0)
        {
            $model = M("build");
            $model->where('id='.$roominfo[0]['bld_id'] )->delete();
        }
        $this->success('操作成功！', '',true);
    }
}
