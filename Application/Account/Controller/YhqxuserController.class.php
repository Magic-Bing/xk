<?php

namespace Account\Controller;
use Think\Upload as Upload;
/**
 * 用户权限设置
 *
 * @create 2017-04-17
 * @author jxw
 */
class YhqxuserController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '用户权限设置');

        //设置当前方法
        $this->set_current_action('yhqx_user', 'yhqx');
    }

    /**
     * 用户信息
     *
     * @create 2016-12-19
     * @author zlw
     */
    public function index() {
         
        $Model = new \Think\Model(); 
        $companys = $this->get_user_company();
        //查询
        if(isset($_POST['cp_id'])){
            $cp_id = I('cp_id', 0, 'intval');
            session("selected_company",$cp_id);
        }else{
            $cp_id = session("selected_company");
        }
        $where = " where a.is_all<>1 ";
        $name=I("name","","trim");
        $code=I("code","","trim");
        $mobile=I("mobile","","trim");
        if (!empty($name) && $name<>"")
           $where .=" and a.name like '%". $name ."%' " ;
        if (!empty($code) && $code<>"")
           $where .=" and a.code like '%". $code ."%' " ;
        if (!empty($mobile) && $mobile<>"")
           $where .=" and a.mobile like '%". $mobile ."%' " ;
        if (!empty($cp_id) && $cp_id<>0)
        {
            $where .=" and a.cp_id = ". $cp_id ." " ;
        }
        else
        {
            $cp_id=$companys[0]['id'];
            $where .=" and a.cp_id = ". $cp_id ." " ;
        }
        
        $alluser=$Model->query("SELECT b.name as compname,a.* FROM xk_user a left join xk_company b on a.cp_id=b.id  " .  $where );
        $count=count($alluser);
		
        //分页
        $Page = $this->bootstrapPage($count, 15);
        $page_show  = $Page->show();	
        $total_pages = $Page->totalPages;
        
        $limit = " LIMIT ".$Page->firstRow.','.$Page->listRows;
        $userlist=$Model->query("SELECT b.name as compname,a.* FROM xk_user a left join xk_company b on a.cp_id=b.id " . $where . " ORDER BY b.id asc ,a.id ASC ".$limit." " );
        
        $this->assign('companys', $companys); 
        $this->assign('cp_id', $cp_id); 
        $this->assign('name', $name);
        $this->assign('code', $code);
        $this->assign('mobile', $mobile);
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('page_show', $page_show); 
        $this->assign('count', $count);
        $this->assign('listRows', 15);;
        $this->assign('userlist', $userlist);
        $this->set_seo_title("用户资料设置");
        $this->display();
     }
     
     public function add(){
        $Model = new \Think\Model(); 
        $companys = $this->get_user_company();
         $gs=session("selected_company");
        $this->assign('companys', $companys);
        $this->assign('gs', $gs);
         $this->set_seo_title("用户资料设置");
        $this->display();
    }
    
    public function edit(){
        $id=I("get.id");
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = D(User); 
        $userinfo=$Model->getOneById($id);
        $this->assign('userinfo', $userinfo); 
        $companys = $this->get_user_company();
        $this->assign('companys', $companys);
        $this->set_seo_title("用户资料设置");
        $this->display();
    }
    
     public function deluser(){
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
            $model = M("user");  
            $model->where('id='.$id )->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    
    
    public function pldeluser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $userlist = I('userlist');
        if (empty($userlist)||$userlist==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("user");  
            $model->where('id in('. str_replace("|",",",$userlist) .')' )->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    public function plcloseuser(){
        if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $userlist = I('userlist');
        if (empty($userlist)||$userlist==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("user"); 
            $data['status']=1;
            $model->where('id in('. str_replace("|",",",$userlist) .')' )->save($data);
        }
        $this->success('操作成功！', '',true);
    } 
    
    
    public function saveuser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $cp_id = I('company_id', '', 'trim');
        $name = I('name', '', 'trim');
        $code = I('code', '', 'trim');
        $mobile = I('mobile', '', 'trim');
        $pwd = I('pwd', '', 'trim');
        $type = I('type', '', 'trim');
        $status = I('status', '', 'trim');
        
        if (empty($id)||$id==0)
        {
            //校验是否有重复的手机和用户代码
            $Model = new \Think\Model(); 
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.code ='". $code ."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('用户代码重复，请修改！');
            }
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.mobile='".$mobile."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('手机号码重复，请修改！');
            }
            if (empty($pwd)||$pwd=='')
            {
               $pwd='123456';//默认值
            }
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['code']=$code;
            $data['mobile']=$mobile;
            $data['password']=md5(md5($pwd));
            $data['type']=$type;
            $data['status']=$status;
            $model = M("user");  
            $model->add($data);
        }
        else
        {
            //校验是否有重复的手机和用户代码
            $Model = new \Think\Model(); 
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.code ='". $code ."' and a.id<>'".$id ."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('用户代码重复，请修改！');
            }
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.mobile='".$mobile."' and a.id<>'".$id ."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('手机号码重复，请修改！');
            }
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['code']=$code;
            $data['mobile']=$mobile;
            $data['type']=$type;
            $data['status']=$status;
            if (!empty($pwd)||$pwd<>0)
            {
                $data['password']=md5(md5($pwd));
            }
            $model = M("user");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
    }
    //导出用户模版
    public function check_out_user(){
        $cid=I("cid/d");
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        //激活表格
        $filename = "用户导入模版-" . date('YmdHis') . ".xls";
        $PHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID); // 背景填充方式
        $PHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('00dc93d5'); // 背景色
//        $PHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $PHPExcel->getActiveSheet()->setCellValue('A1', '所属公司');
        $PHPExcel->getActiveSheet()->setCellValue('B1', rsa_encode($cid,getChoosekey()));
        $PHPExcel->getActiveSheet()->setCellValue('C1', '说明');
        $PHPExcel->getActiveSheet()->setCellValue('D1', "此行不可更改！");
        $PHPExcel->getActiveSheet()->setCellValue('A2', '用户名称');
        $PHPExcel->getActiveSheet()->setCellValue('B2', "用户代码");
        $PHPExcel->getActiveSheet()->setCellValue('C2', '用户电话');
        $PHPExcel->getActiveSheet()->setCellValue('D2', "用户密码");
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        $filename=urlencode($filename);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        exit;
    }

    //读取EXCEL表中数据
    public function importGet($filename)
    {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        import("Org.Util.PHPExcel.Reader.Excel5");
        $PHPReader = new \PHPExcel_Reader_Excel5();
        //载入文件
        $PHPExcel = $PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel->getSheet(0);
        //获取总列数
        $allColumn = $currentSheet->getHighestColumn();
        //获取总行数
        $allRow = $currentSheet->getHighestRow();

        if (empty($allRow)) {
            $this->error = '文件内容为空';
            return false;
        }

        // 循环获取表中的数据，
        // $currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        $data = array();
        $data[0]=$currentSheet->getCell("B1")->getValue();
        for ($currentRow = 3; $currentRow <= $allRow; $currentRow++) {
            //从哪列开始，A表示第一列
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                //数据坐标
                $address = $currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                $data[$currentRow][$currentColumn] =(string) $currentSheet->getCell($address)->getValue();
            }
        }

        return $data;
    }
    //导入数据
    public function check_in_user(){
        if (!IS_POST) {
            $this->error("访问错误，请确认后重试！");
        }

        $upload = new Upload();// 实例化上传类
        $upload->maxSize   = 3145728 ;// 设置附件上传大小
        $upload->exts      = array('xls','xlsx','txt');// 设置附件上传类
        $upload->autoSub   = false;
        $upload->rootPath  = './Uploads/';
        $upload->savePath  = '/user/'; // 设置附件上传目录
        $upload->saveName  = date('YmdHis');

        $info = $upload->uploadOne($_FILES['excel']);
        if (!$info) {
            $this->error($upload->getError());
        }
        $filename = './Uploads'.$info['savepath'].$info['savename'];
        $data=$this->importGet($filename);
//        echo json_encode($data);exit;
       $back_data=[];
        $cid=rsa_decode($data[0],getChoosekey());
        unset($data[0]);
        $model=M();
        $data=array_merge($data);
        if(!$data){
            $this->error("没有数据！");
        }
        $back_data['in_all']=count($data);
        $codes=$model->table("xk_user")->field("code")->where("cp_id=$cid")->select();
        $key_arr=[];
        for($k=0;$k<count($data);$k++){
            for($c=0;$c<count($codes);$c++){
                if((string)$data[$k]['B']===$codes[$c]['code']){
                    $key_arr[]=$k;
                }
            }
            for($i=0;$i<$k;$i++){
                if((string)$data[$k]['B']===(string)$data[$i]['B'] || (string)$data[$k]['C']===(string)$data[$i]['C']){
                    $key_arr[]=$k;
                    $key_arr[]=$i;
                }
            }
        }
        $key_arr=array_merge($key_arr);
        $repeat_arr=[];

        for($i=0;$i<count($key_arr);$i++){
           $repeat_arr[]=$data[$key_arr[$i]];
           unset($data[$key_arr[$i]]);
        }
//        echo json_encode($repeat_arr);exit;
        if($repeat_arr){
            $back_data['in_error']=count($repeat_arr);
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");
            //创建PHPExcel对象，注意，不能少了\
            $PHPExcel = new \PHPExcel();
            //激活表格
            $filename = "error-" . date('YmdHis') . ".xls";
            $PHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID); // 背景填充方式
            $PHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('00dc93d5'); // 背景色
//        $PHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
            $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $PHPExcel->getActiveSheet()->setCellValue('A1', '所属公司');
            $PHPExcel->getActiveSheet()->setCellValue('B1', $cid);
            $PHPExcel->getActiveSheet()->setCellValue('C1', '说明');
            $PHPExcel->getActiveSheet()->setCellValue('D1', "此行不可更改！");
            $PHPExcel->getActiveSheet()->setCellValue('A2', '用户名称');
            $PHPExcel->getActiveSheet()->setCellValue('B2', "用户代码");
            $PHPExcel->getActiveSheet()->setCellValue('C2', '用户电话');
            $PHPExcel->getActiveSheet()->setCellValue('D2', "用户密码");
            for ($i = 0; $i < count($repeat_arr); $i++) {
                $PHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 3), $repeat_arr[$i]['A'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("B" . ($i + 3), $repeat_arr[$i]['B'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("C" . ($i + 3), $repeat_arr[$i]['C'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("D" . ($i + 3), $repeat_arr[$i]['D'], \PHPExcel_Cell_DataType::TYPE_STRING);
            }
            $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
            $filePath = './Uploads/user/user_error/' . $filename;
            $objWriter->save($filePath);
            $back_data['error_path'] = $filePath;
        }
        if(count($repeat_arr)===(int)$back_data['in_all']){
            echo json_encode($back_data);exit;
        }
//        echo json_encode($excels);exit;
        $in_data = array();
        foreach ($data as $key => $excel) {
            $in_data[] = array(
                'name' => $excel['A'],
                'code' => $excel['B'],
                'mobile' =>$excel['C'], //备注
                'password' => md5(md5($excel['D'])),
                'cp_id' => $cid,
            );
        }
        $check_has_add = $model->table('xk_user')->addAll($in_data);
        if($check_has_add){
            echo json_encode($back_data);exit;
        }
    }

    //修改单个状态
    public function updateStatus(){
        $status=I("status",0,"intval");
        $id=I("id",0,"intval");
        $res=M()->table("xk_user")->where("id=$id")->save(["status"=>$status]);
        echo $res?"true":"false";exit;
    }

    //导出数据
    public function check_out_user_data(){

        $Model = new \Think\Model();
        $companys = $this->get_user_company();
        //查询
        $where = " where 1=1 ";
        $name=I("name","","trim");
        $code=I("code","","trim");
        $mobile=I("mobile","","trim");
        $cp_id=I("cp_id",0,"intval");
        if (!empty($name) && $name<>"")
            $where .=" and a.name like '%". $name ."%' " ;
        if (!empty($code) && $code<>"")
            $where .=" and a.code like '%". $code ."%' " ;
        if (!empty($mobile) && $mobile<>"")
            $where .=" and a.mobile like '%". $mobile ."%' " ;
        if (!empty($cp_id) && $cp_id<>0)
        {
            $where .=" and a.cp_id = ". $cp_id ." " ;
        }
        else
        {
            $cp_id=$companys[0]['id'];
            $where .=" and a.cp_id = ". $cp_id ." " ;
        }
        $userlist=$Model->query("SELECT b.name as compname,a.* FROM xk_user a left join xk_company b on a.cp_id=b.id " . $where . " ORDER BY b.id asc ,a.id ASC ");
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        //激活表格
        $filename = "用户数据-" . date('YmdHis') . ".xls";
        $PHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
        $PHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $PHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID); // 背景填充方式
        $PHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->getStartColor()->setRGB('17A3FF'); // 背景色
        $PHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);
        $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $PHPExcel->getActiveSheet()->setCellValue('A1', '公司名称');
        $PHPExcel->getActiveSheet()->setCellValue('B1', '用户名称');
        $PHPExcel->getActiveSheet()->setCellValue('C1', "用户代码");
        $PHPExcel->getActiveSheet()->setCellValue('D1', '用户电话');
        $PHPExcel->getActiveSheet()->setCellValue('E1', "账号状态");
        for ($i = 0; $i < count($userlist); $i++) {
            $PHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 2), $userlist[$i]['compname'], \PHPExcel_Cell_DataType::TYPE_STRING);
            $PHPExcel->getActiveSheet()->setCellValueExplicit("B" . ($i + 2), $userlist[$i]['name'], \PHPExcel_Cell_DataType::TYPE_STRING);
            $PHPExcel->getActiveSheet()->setCellValueExplicit("C" . ($i + 2), $userlist[$i]['code'], \PHPExcel_Cell_DataType::TYPE_STRING);
            $PHPExcel->getActiveSheet()->setCellValueExplicit("D" . ($i + 2), $userlist[$i]['mobile'], \PHPExcel_Cell_DataType::TYPE_STRING);
            $PHPExcel->getActiveSheet()->setCellValueExplicit("E" . ($i + 2), $userlist[$i]['D']?"禁用":"启用", \PHPExcel_Cell_DataType::TYPE_STRING);
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        $filename=urlencode($filename);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        exit;
    }
}
