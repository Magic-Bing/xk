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
//         if(!IS_POST){
//             $this->error("非法操作！");
//         }
        
        //当前用户有权限查看的项目
        $user_project_ids = $this->get_user_project_ids();
        //当前用户有权限查看的批次
        $user_batch_ids = $this->get_user_batch_ids();
        
        //当前项目
        if(isset($_POST['projid'])){
            $search_project_id = I('projid', 0, 'intval');
        }
        else{
            $search_project_id = session("selected_project");
        }
        
        if ($search_project_id != 0) {
            if (!in_array($search_project_id, $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
            else
            {
                 session("selected_project",$search_project_id);
            }
        }
        

        $projid = $search_project_id;
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
        $strproj=implode(",", $user_project_ids);
        $strpc=implode(",", $user_batch_ids);
        
        if (!empty($projid)) {
            $where .=" and a.proj_id = $projid and  b.pc_id in('" . str_replace(",","','", $strpc) . "')" ;
        }else
        {
            $where .=" and b.pc_id in('" . str_replace(",","','", $strpc) . "')" ;
        }
        if($excel===1){
            $roomlist=$Model->query("SELECT concat_ws('-',c.name,b.buildname,a.unit,a.room) dz,a.hx,a.area,Format(a.price,2) p1,a.tnarea,Format(a.tnprice,2) p2,Format(a.total,2) p3,Format(a.discount,2) p4,CASE WHEN a.is_xf=0 THEN  '待售' ELSE  '已售' END zt "
                    . ",Format(a.ycx_price,2) p5,Format(a.fq_price,2) p6,Format(a.aj_price,2) p7,Format(a.gjj_price,2) p8,Format(a.ycx_dj,2) p9,Format(a.fq_dj,2) p10,Format(a.aj_dj,2) p11,Format(a.gjj_dj,2) p12 "
                    . " FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ".$where  . "  order by a.id asc ");
            $this->exportExcel("房间数据",['head'=>['房间名称','户型','建筑面积','建筑单价','套内面积','套内单价','标准总价','优惠后总价','销售状态','一次性总价','分期总价','按揭总价','公积金总价','一次性单价','分期单价','按揭单价','公积金单价']],$roomlist,0);
        }
        //可选项目取值

        //获取项目列表
        $project_where = array();
        //$project_where['status'] = 1;
        if (!empty($user_project_ids)) {
            $project_where['id'] = array('in', $user_project_ids);
        } else {
            $project_where['id'] = '-99999';
        }
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        $project_list='';
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_list_key => $project_list_value) {
                $project_list[] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('projlist', $project_list);
            //房间列表
            $allroom=$Model->query("SELECT a.* FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ".$where );
            $count = count($allroom);
            $listRows = I('r', '10', 'intval');
		
            //分页
            $Page = $this->bootstrapPage($count, $listRows);
            $page_show  = $Page->show();
            $total_pages = $Page->totalPages;

            //房间列表
            $limit = 'limit '.$Page->firstRow.','.$Page->listRows;
            $roomlist=$Model->query('SELECT a.*,b.buildname,c.name as projname FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ' .$where . 'order by a.id asc '.$limit );

            $this->assign('projid', $projid); 
            $p = I('p', '1', 'intval');
            $this->assign('p', $p);
            $this->assign('total_pages', $total_pages);
            $this->assign('page_show', $page_show); 
            $this->assign('count', $count);
            $this->assign('listRows', $listRows);;
            $this->assign('roomlist', $roomlist);

        $this->set_seo_title("房间管理");
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
        $this->set_seo_title("房间管理");
        $this->display();
    }
     
     /**
	 * 导出房间模板
	 *
	 * @create 2016-10-9
	 * @author zlw
	 */
	public function exportfj()
    {
		$project_id = I("projid", '', 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error('项目不存在，请重试！',U('Jcsjroom/room'));
		}
		
		//房间信息
		$rooms_list = array(
			array(
				'buildname' => '10栋',
				'unit' => '2',
				'floor' => '11',
				'no' => (string) '01',
				'hx' => 'A1',
				'area' => '100',
				'tnarea' => '90',
				'price' => '8000.00',
				'tnprice' => '8888.89',
				'total' => '800000',
                                'discount' => '800000',
				'ycx_price' => '750000',
                                'ycx_dj' => '7500',
				'fq_price' => '770000',
                                'fq_dj' => '7700',
				'aj_price' => '790000',
                                'aj_dj' => '7900',
				'gjj_price' => '800000',  
                                'gjj_dj' => '8000',
			),
			array(
				'buildname' => '6栋',
				'unit' => '1',
				'floor' => '13',
				'no' => '02',
				'hx' => 'A2',
				'area' => '100',
				'tnarea' => '90',
				'price' => '8000.00',
				'tnprice' => '8888.89',
				'total' => '800000',
                                'discount' => '800000',
				'ycx_price' => '750000',
                                'ycx_dj' => '7500',
				'fq_price' => '770000',
                                'fq_dj' => '7700',
				'aj_price' => '790000',
                                'aj_dj' => '7900',
				'gjj_price' => '800000',  
                                'gjj_dj' => '8000',
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
            $data[$k]['ycx_price'] 	= $rooms_info['ycx_price'];
            $data[$k]['fq_price'] 	= $rooms_info['fq_price'];
            $data[$k]['aj_price'] 	= $rooms_info['aj_price'];
            $data[$k]['gjj_price'] 	= $rooms_info['gjj_price'];
            $data[$k]['ycx_dj'] 	= $rooms_info['ycx_dj'];
            $data[$k]['fq_dj']          = $rooms_info['fq_dj'];
            $data[$k]['aj_dj']          = $rooms_info['aj_dj'];
            $data[$k]['gjj_dj'] 	= $rooms_info['gjj_dj'];
        }
		
		//获取项目信息
		$project = D('Common/Project')->getOneById($project_id);

		$headArr = array(
			'title' => array(
				array('项目标识', '_type' => true),
                rsa_encode($project_id,getChoosekey()),
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
				'优惠后总价',
				'一次性总价',
				'分期总价',
				'按揭总价',
				'公积金总价',
                                '一次性单价',
				'分期总单价',
				'按揭单价',
				'公积金单价',
			),
		);
		
        $filename = $project['name']."房间列表";

        $this->exportExcel($filename, $headArr, $data,1);
    }
   
    /**
	 * 导出车位模板
	 *
	 * @create 2016-10-9
	 * @author zlw
	 */
	public function exportcw()
    {
		$project_id = I("projid", '', 'intval');
		if (empty($project_id) || $project_id == 0) {
            $this->error('项目不存在，请重试！',U('Jcsjroom/room'));
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
                'ycx_price' => '72000',
                'fq_price' => '73000',
                'aj_price' => '74000',
                'gjj_price' => '75000',
			),
			array(
				'buildname' => '-2层',
				'room' => '2001',
				'hx' => '子母车位',
				'area' => '16',
				'price' => '8000',
				'total' => '128000',
                'ycx_price' => '128000',
                'fq_price' => '129000',
                'aj_price' => '130000',
                'gjj_price' => '131000',
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
            $data[$k]['ycx_price'] 	= $rooms_info['ycx_price'];
            $data[$k]['fq_price'] 	= $rooms_info['fq_price'];
            $data[$k]['aj_price'] 	= $rooms_info['aj_price'];
            $data[$k]['gjj_price'] 	= $rooms_info['gjj_price'];
        }
		
		//获取项目信息
		$project = D('Common/Project')->getOneById($project_id);

		$headArr = array(
			'title' => array(
				array('项目标识', '_type' => true),
                rsa_encode($project_id,getChoosekey()),
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
                '一次性总价',
                '分期总价',
                '按揭总价',
                '公积金总价',
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
    $fileName, $headArr, $data, $pd
    ) {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $date = date("YmdHis", time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

        //激活表格
        $objActSheet = $objPHPExcel->getActiveSheet();

        //设置表头
        $headColumn = 1;
        $objActSheet->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00dc93d5');
        if ($pd === 1) {
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
                        /* $objActSheet->getStyle($headJ.$headColumn)
                          ->getFill()
                          ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                          ->getStartColor()
                          ->setRGB('EBE7DC'); */

                        $objActSheet->getStyle($headJ . $headColumn)->applyFromArray(
                                array(
                                    'font' => array(
                                        'bold' => true,
                                    ),
                                    'borders' => array(
                                        'top' => array(
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
                    $objActSheet->getStyle($headJ . $headColumn)->applyFromArray(
                            array(
                                'font' => array(
                                    'bold' => true,
                                ),
                                'borders' => array(
                                    'top' => array(
                                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                                    )
                                ),
                                'fill' => array(
                                    'type' => \PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
                                    'rotation' => 90,
                                    'startcolor' => array(
                                        'argb' => 'FFA0A0A0'
                                    ),
                                    'endcolor' => array(
                                        'argb' => 'FFFFFFFF'
                                    )
                                )
                            )
                    );

                    $objActSheet->getStyle($headJ . $headColumn)
                            ->getFill()
                            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setRGB('EBE7DC');
                }

                $objActSheet->setCellValue($headJ . $headColumn, $headValue);
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
                    $objActSheet->setCellValue($j . $column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $objActSheet->getStyle($j . $column)->getNumberFormat()->setFormatCode("@");
                } else {
                    $objActSheet->setCellValue($j . $column, $value);
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
                $this->error("访问错误，请确认后重试！",U('Jcsjroom/room'));
        }
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   = 3145728 ;// 设置附件上传大小
        $upload->exts      = array('xls','xlsx','txt');// 设置附件上传类
        $upload->autoSub   = false;
        $upload->rootPath  = './Uploads/';
        $upload->savePath  = '/room/'; // 设置附件上传目录
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
        }else {
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
        $projid= rsa_decode($currentSheet->getCell('B1')->getValue(),getChoosekey());
        $mbtype= $currentSheet->getCell('C1')->getValue();
        $pid=$currentSheet->getCell('B1')->getValue();
        $pname=$currentSheet->getCell('E1')->getValue();
        if (empty($projid)||$projid==0)
        {
            $this->error('项目标识有误,请重新导出模板');
        }
        $Modelr = new \Think\Model();
        $projinfo=$Modelr->query("SELECT a.* FROM xk_project a where a.id=" .$projid. " and 66=66 " );
        if (empty($projinfo)||count($projinfo)==0)
        {
            $this->error('项目标识有误,请重新导出模板');
        }
        $data=[];
        $error=[];
        for($currentRow=3;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
                //数据坐标
                $address=$currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                if ($mbtype=="房间模板")
                {
                   if(
                       empty($currentSheet->getCell('A'.$currentRow)->getValue()) ||
                       empty($currentSheet->getCell('B'.$currentRow)->getValue()) ||
                       empty($currentSheet->getCell('C'.$currentRow)->getValue()) ||
                       empty($currentSheet->getCell('D'.$currentRow)->getValue()) ||
                       (empty($currentSheet->getCell('F'.$currentRow)->getValue()) && empty($currentSheet->getCell('G'.$currentRow)->getValue())) ||
                       (empty($currentSheet->getCell('H'.$currentRow)->getValue()) && empty($currentSheet->getCell('I'.$currentRow)->getValue())) ||
                       (empty($currentSheet->getCell('J'.$currentRow)->getValue()) && empty($currentSheet->getCell('K'.$currentRow)->getValue()))
                   ){
                       $error[$currentRow-3][$currentColumn]=$currentSheet->getCell($address)->getValue();
                   }else{
                       $data[$currentRow][$currentColumn]=(string)$currentSheet->getCell($address)->getValue();
                       if (stristr($buildlist,$data[$currentRow]['A'])<=0) $buildlist.=$data[$currentRow]['A']."|";
                   }
                }else{
                    if(
                        empty($currentSheet->getCell('A'.$currentRow)->getValue()) ||
                        empty($currentSheet->getCell('B'.$currentRow)->getValue()) ||
                        empty($currentSheet->getCell('C'.$currentRow)->getValue()) ||
                        empty($currentSheet->getCell('D'.$currentRow)->getValue()) ||
                        empty($currentSheet->getCell('E'.$currentRow)->getValue()) ||
                        empty($currentSheet->getCell('F'.$currentRow)->getValue())

                    ){
                        $error[$currentRow-3][$currentColumn]=$currentSheet->getCell($address)->getValue();
                    }else{
                        $data[$currentRow][$currentColumn]=(string)$currentSheet->getCell($address)->getValue();
                        if (stristr($buildlist,$data[$currentRow]['A'])<=0) $buildlist.=$data[$currentRow]['A']."|";
                    }
                }
            }
        }
        $result=[];
        $result['correct_count']=count($data);
        $result['error_count']=count($error);
        $error=array_merge($error);
//        echo json_encode($data);exit;
        if ($mbtype=="房间模板")
        {
            if($result['error_count']>0){
                $result['error_url']=$this->room_error($error,$pid,$pname);
                if($result['correct_count']===0){
                    $this->success($result);
                }
            }
            $this->save_import($data,$projid,$buildlist,$result,$projinfo);
        }
        if ($mbtype=="车位模板")
        {
            if($result['error_count']>0){
                $result['error_url']=$this->car_error($error,$pid,$pname);
                if($result['correct_count']===0){
                    $this->success($result);
                }
            }
            $this->save_importcw($data,$projid,$buildlist,$result,$projinfo);
        }
        else
        {
            $this->error("数据模板错误！");
        }
    }
    //房间导入异常数据
    public function room_error($data,$pid,$pname){
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        //激活表格
        $filename = "error_room" . date('YmdHis') . ".xls";
        $PHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("L")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("M")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("N")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("O")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("P")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("Q")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("R")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("S")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00dc93d5');
        $PHPExcel->getActiveSheet()->getStyle("A2:S2")->applyFromArray(
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
        $PHPExcel->getActiveSheet()->getStyle("A2:S2")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('EBE7DC');
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(15);

        $PHPExcel->getActiveSheet()->setCellValue('A1', '项目标识');
        $PHPExcel->getActiveSheet()->setCellValue('B1', $pid);
        $PHPExcel->getActiveSheet()->setCellValue('C1', '房间模版');
        $PHPExcel->getActiveSheet()->setCellValue('D1', '项目名称');
        $PHPExcel->getActiveSheet()->setCellValue('E1', $pname);
        $PHPExcel->getActiveSheet()->setCellValue('G1', '说明');
        $PHPExcel->getActiveSheet()->setCellValue('H1', "此行不能修改！");
        $PHPExcel->getActiveSheet()->setCellValue('A2', '楼栋');
        $PHPExcel->getActiveSheet()->setCellValue('B2', '单元');
        $PHPExcel->getActiveSheet()->setCellValue('C2', '楼层');
        $PHPExcel->getActiveSheet()->setCellValue('D2', "房号");
        $PHPExcel->getActiveSheet()->setCellValue('E2', '户型');
        $PHPExcel->getActiveSheet()->setCellValue('F2', '建筑面积');
        $PHPExcel->getActiveSheet()->setCellValue('G2', '套内面积');
        $PHPExcel->getActiveSheet()->setCellValue('H2', '建筑单价');
        $PHPExcel->getActiveSheet()->setCellValue('I2', '套内单价');
        $PHPExcel->getActiveSheet()->setCellValue('J2', '标准总价');
        $PHPExcel->getActiveSheet()->setCellValue('K2', '优惠后总价');
        $PHPExcel->getActiveSheet()->setCellValue('L2', '一次性总价');
        $PHPExcel->getActiveSheet()->setCellValue('M2', '分期总价');
        $PHPExcel->getActiveSheet()->setCellValue('N2', '按揭总价');
        $PHPExcel->getActiveSheet()->setCellValue('O2', '公积金总价');
        
        $PHPExcel->getActiveSheet()->setCellValue('P2', '一次性单价');
        $PHPExcel->getActiveSheet()->setCellValue('Q2', '分期单价');
        $PHPExcel->getActiveSheet()->setCellValue('R2', '按揭单价');
        $PHPExcel->getActiveSheet()->setCellValue('S2', '公积金单价');
        for ($i = 0; $i < count($data); $i++) {
            $PHPExcel->getActiveSheet()->setCellValue("A" . ($i + 3), $data[$i]['A']);
            $PHPExcel->getActiveSheet()->setCellValue("B" . ($i + 3), $data[$i]['B']);
            $PHPExcel->getActiveSheet()->setCellValue("C" . ($i + 3), $data[$i]['C']);
            $PHPExcel->getActiveSheet()->setCellValue("D" . ($i + 3), $data[$i]['D']);
            $PHPExcel->getActiveSheet()->setCellValue("E" . ($i + 3), $data[$i]['E']);
            $PHPExcel->getActiveSheet()->setCellValue("F" . ($i + 3), $data[$i]['F']);
            $PHPExcel->getActiveSheet()->setCellValue("G" . ($i + 3), $data[$i]['G']);
            $PHPExcel->getActiveSheet()->setCellValue("H" . ($i + 3), $data[$i]['H']);
            $PHPExcel->getActiveSheet()->setCellValue("I" . ($i + 3), $data[$i]['I']);
            $PHPExcel->getActiveSheet()->setCellValue("J" . ($i + 3), $data[$i]['J']);
            $PHPExcel->getActiveSheet()->setCellValue("K" . ($i + 3), $data[$i]['K']);
            $PHPExcel->getActiveSheet()->setCellValue("L" . ($i + 3), $data[$i]['L']);
            $PHPExcel->getActiveSheet()->setCellValue("M" . ($i + 3), $data[$i]['M']);
            $PHPExcel->getActiveSheet()->setCellValue("N" . ($i + 3), $data[$i]['N']);
            $PHPExcel->getActiveSheet()->setCellValue("O" . ($i + 3), $data[$i]['O']);
            
            $PHPExcel->getActiveSheet()->setCellValue("P" . ($i + 3), $data[$i]['P']);
            $PHPExcel->getActiveSheet()->setCellValue("Q" . ($i + 3), $data[$i]['Q']);
            $PHPExcel->getActiveSheet()->setCellValue("R" . ($i + 3), $data[$i]['R']);
            $PHPExcel->getActiveSheet()->setCellValue("S" . ($i + 3), $data[$i]['S']);
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
//                        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//                        header('Content-Disposition: attachment;filename='.$filename1);
//                        header('Cache-Control: max-age=0');
        $filePath = './Uploads/room/error/' . $filename;
        $objWriter->save($filePath);
        return 'Uploads/room/error/' . $filename;
    }
    //车位导入异常数据
    public function car_error($data,$pid,$pname){
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        //激活表格
        $filename = "error_car" . date('YmdHis') . ".xls";
        $PHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('00dc93d5');
        $PHPExcel->getActiveSheet()->getStyle("A2:J2")->applyFromArray(
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
        $PHPExcel->getActiveSheet()->getStyle("A2:J2")
            ->getFill()
            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()
            ->setRGB('EBE7DC');
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $PHPExcel->getActiveSheet()->setCellValue('A1', '项目标识');
        $PHPExcel->getActiveSheet()->setCellValue('B1', $pid);
        $PHPExcel->getActiveSheet()->setCellValue('C1', '车位模版');
        $PHPExcel->getActiveSheet()->setCellValue('D1', '项目名称');
        $PHPExcel->getActiveSheet()->setCellValue('E1', $pname);
        $PHPExcel->getActiveSheet()->setCellValue('G1', '说明');
        $PHPExcel->getActiveSheet()->setCellValue('H1', "此行不能修改！");
        $PHPExcel->getActiveSheet()->setCellValue('A2', '楼层');
        $PHPExcel->getActiveSheet()->setCellValue('B2', '车位号');
        $PHPExcel->getActiveSheet()->setCellValue('C2', '车位类型');
        $PHPExcel->getActiveSheet()->setCellValue('D2', "面积");
        $PHPExcel->getActiveSheet()->setCellValue('E2', '单价');
        $PHPExcel->getActiveSheet()->setCellValue('F2', '总价');
        $PHPExcel->getActiveSheet()->setCellValue('G2', '一次性总价');
        $PHPExcel->getActiveSheet()->setCellValue('H2', '分期总价');
        $PHPExcel->getActiveSheet()->setCellValue('I2', '按揭总价');
        $PHPExcel->getActiveSheet()->setCellValue('J2', '公积金总价');
        for ($i = 0; $i < count($data); $i++) {
            $PHPExcel->getActiveSheet()->setCellValue("A" . ($i + 3), $data[$i]['A']);
            $PHPExcel->getActiveSheet()->setCellValue("B" . ($i + 3), $data[$i]['B']);
            $PHPExcel->getActiveSheet()->setCellValue("C" . ($i + 3), $data[$i]['C']);
            $PHPExcel->getActiveSheet()->setCellValue("D" . ($i + 3), $data[$i]['D']);
            $PHPExcel->getActiveSheet()->setCellValue("E" . ($i + 3), $data[$i]['E']);
            $PHPExcel->getActiveSheet()->setCellValue("F" . ($i + 3), $data[$i]['F']);
            $PHPExcel->getActiveSheet()->setCellValue("G" . ($i + 3), $data[$i]['G']);
            $PHPExcel->getActiveSheet()->setCellValue("H" . ($i + 3), $data[$i]['H']);
            $PHPExcel->getActiveSheet()->setCellValue("I" . ($i + 3), $data[$i]['I']);
            $PHPExcel->getActiveSheet()->setCellValue("J" . ($i + 3), $data[$i]['J']);
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
        $filePath = './Uploads/room/cw_error/' . $filename;
        $objWriter->save($filePath);
        return 'Uploads/room/cw_error/' . $filename;
    }
    //保存导入数据
    public function save_import($data,$projid,$buildlist,$result,$projinfo)
    {
        $Modelr = new \Think\Model();
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
        $data=array_merge($data);
        //$add_time = date('Y-m-d H:i:s', time());
        foreach ($data as $k=>$v){

                $info[$k]['proj_id']=$projinfo[0]['id'];
                $info[$k]['pc_id']=-99;
                $info[$k]['bld_id']=-99;
                $info[$k]['cp_id']=$projinfo[0]['cp_id'];
                $info[$k]['buildname'] = $v['A']."";
                $info[$k]['unit'] = $v['B'];
                $info[$k]['floor'] = (string)$v['C'];
                $info[$k]['no'] = (int)$v['D'];
                $info[$k]['room'] =  (string)$v['C']. (string)$v['D'];
                $info[$k]['hx'] = $v['E'];
                $info[$k]['area'] = $v['F'];
                $info[$k]['tnarea'] = $v['G'];
                $info[$k]['price'] = $v['H'];
                $info[$k]['tnprice'] = $v['I'];
                if(empty( $v['J'])){
                    $info[$k]['total'] = $v['K'];
                }else{
                    $info[$k]['total'] = $v['J'];
                }
                $info[$k]['discount'] = $v['K'];
                /*if(empty( $v['K'])){
                    $info[$k]['discount'] = $v['J'];
                }else{
                    $info[$k]['discount'] = $v['K'];
                }*/
                $info[$k]['ycx_price'] = $v['L'];
                $info[$k]['fq_price'] = $v['M'];
                $info[$k]['aj_price'] = $v['N'];
                $info[$k]['gjj_price'] = $v['O'];
                //单价
                $info[$k]['ycx_dj'] = $v['P'];
                $info[$k]['fq_dj'] = $v['Q']; 
                $info[$k]['aj_dj'] = $v['R'];
                $info[$k]['gjj_dj'] = $v['S'];
               
               
                $info[$k]['isadd'] = 1;
                $rooms->add($info[$k]);

        }
        //更新楼栋id和批次id
        $SQL="update  xk_roomtemp a,xk_build b set a.bld_id=b.id,a.pc_id=b.pc_id where  a.proj_id=b.proj_id and a.buildname=b.buildname and a.bld_id=-99 ";
        M()->execute($SQL);
        //判断是否为新增房间
        $SQL="update  xk_roomtemp a,xk_room b set a.isadd=0,room_id=b.id where  a.proj_id=b.proj_id and a.bld_id=b.bld_id and a.unit=b.unit and a.floor=b.floor and a.no=b.no ";
        M()->execute($SQL);

        $roomadd=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd=1 " );
//        echo json_encode($roomadd);exit;
        $resultadd=0;
        $resultup=0;
        if (!empty($roomadd) && count($roomadd)>0)
        {
            //新增房间
            $SQLadd="insert into xk_room (proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total,discount,ycx_price,fq_price,gjj_price,aj_price,ycx_dj,fq_dj,gjj_dj,aj_dj ) ";
            $SQLadd.=" select proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total,discount,ycx_price,fq_price,gjj_price,aj_price,ycx_dj,fq_dj,gjj_dj,aj_dj from xk_roomtemp where isadd=1 ";
            $resultadd=M()->execute($SQLadd);

        }
//        echo '123';exit;
        $roomup=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd = 0 " );
        if (!empty($roomup) && count($roomup)>0)
        {
            //更新房间信息
            $SQLup="update  xk_room a,xk_roomtemp b set a.hx=b.hx,a.area=b.area, a.tnarea=b.tnarea, a.price=b.price, a.tnprice=b.tnprice,a.total=b.total,a.discount=b.discount,"
                    . "a.ycx_price=b.ycx_price,a.fq_price=b.fq_price,a.gjj_price=b.gjj_price,a.aj_price=b.aj_price,"
                    . "a.ycx_dj=b.ycx_dj,a.fq_dj=b.fq_dj,a.gjj_dj=b.gjj_dj,a.aj_dj=b.aj_dj  "
                    . "where a.id=b.room_id and  b.room_id<>0 and b.isadd=0 ";
            $resultup=M()->execute($SQLup);
        }
        $result['add']=$resultadd;
        $result['update']=$resultup;
        $this->success($result);

    }
    
    
    //保存车位导入数据
    public function save_importcw($data,$projid,$buildlist,$result,$projinfo)
    {  

        $Modelr = new \Think\Model();
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
                $info[$k-2]['ycx_price'] = $v['G'];
                $info[$k-2]['fq_price'] = $v['H'];
                $info[$k-2]['gjj_price'] = $v['I'];
                $info[$k-2]['aj_price'] = $v['J'];
  
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
        $resultadd=0;
        $resultup=0;
        if (!empty($roomadd) && count($roomadd)>0)
        {
            //新增车位
            $SQLadd="insert into xk_room (proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total,ycx_price,fq_price,gjj_price,aj_price,ycx_dj,fq_dj,gjj_dj,aj_dj) ";
            $SQLadd.=" select proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total,ycx_price,fq_price,gjj_price,aj_price,ycx_dj,fq_dj,gjj_dj,aj_dj from xk_roomtemp where isadd=1 ";
            $resultadd=M()->execute($SQLadd);
        }
        $roomup=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd = 0 " );
        if (!empty($roomup) && count($roomup)>0)
        {
            //更新车位信息
            $SQLup="update  xk_room a,xk_roomtemp b set a.hx=b.hx,a.area=b.area, a.tnarea=b.tnarea, a.price=b.price, a.tnprice=b.tnprice,a.total=b.total,"
                    . "a.ycx_price=b.ycx_price,a.fq_price=b.fq_price,a.gjj_price=b.gjj_price,a.aj_price=b.aj_price,"
                    . "a.ycx_dj=b.ycx_dj,a.fq_dj=b.fq_dj,a.gjj_dj=b.gjj_dj,a.aj_dj=b.aj_dj  "
                    . "where a.id=b.room_id and  b.room_id<>0 and b.isadd=0 ";
            $resultup=M()->execute($SQLup);
        }
        $result['add']=$resultadd;
        $result['update']=$resultup;
        $this->success($result);
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
            $total= I('total',0);
            $area = I('area',0);
            $price = I('price',0);
            $tnarea = I('tnarea',0);
            $tnprice = I('tnprice',0);
            $discount = I('discount',0);
            $gjj_price = I('gjj_price',0);
            $fq_price = I('fq_price',0);
            $ycx_price = I('ycx_price',0);
            $aj_price = I('aj_price',0);


            if(empty($total) || $total==="0.00"){
                $data['total'] = $discount;
            }else{
                $data['total'] = $total;
            }
            $data['area'] = $area;
            $data['price'] = $price;
            $data['tnarea'] = $tnarea;
            $data['tnprice'] = $tnprice;
            if(empty($discount) || $discount==="0.00" ){
                $data['discount'] = $total;
            }else{
                $data['discount'] = $discount;
            }
            $data['gjj_price'] = $gjj_price;
            $data['fq_price'] = $fq_price;
            $data['ycx_price'] = $ycx_price;
            $data['aj_price'] = $aj_price;
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
