<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/26 0026
 * Time: 15:45
 */

namespace Account\Controller;

class AdmissionController extends BaseController
{
    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '电子开盘');
    }

    //页面
    public function index(){
        $zt=I("zt",0,"intval");
        //当前用户的项目
        $user_project_ids = $this->get_user_project_ids();
        //获取项目列表
        $project_where = array();
        $project_where['status'] = 1;
        $project_where['id'] = array('in', $user_project_ids);
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        $this->assign('project_list', $project_old_list);
        //当前用户的批次
        $user_batch_ids = $this->get_user_batch_ids();
        //批次
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $batch_list = D('Batch')->getList($user_batch_where, '*','id ASC');
        $this->assign('batch_list', $batch_list);
        $this->assign('zt', $zt);
        $this->set_seo_title('入场审核');
        $this->display();
    }

    //获取客户列表
    public  function user_list(){
        if(!IS_AJAX){
            $this->error("非法操作",U("index/index"));
        }
        $page_num=I("num",C("SIGN_PAGE_NUM"),"intval");
        $pid=I("pid",0,"intval");
        $bid=I("bid",0,"intval");
        $search=I("search",'',"trim");
        $page=I("page",0,"intval");
        $zt=I("zt",0,"intval");
        $p='';
        $b='';
        $s='';
        if($pid !== 0){
            $p="AND c.project_id =$pid";
        }
        if($bid !== 0){
            $b="AND c.batch_id =$bid";
        }
        if($search !== ''){
            $s="AND (c.customer_name like '%$search%' OR c.like_p like '%".strencode($search)."%' OR c.like_c like '%".strencode($search)."%' )";
        }
        if($zt<2){
            $z="AND c.is_admission=$zt";
        }else{
            $z='';
        }
        $count=M()->table("xk_choose c")->join("xk_yaohresult y ON y.cstid=c.id")->where("1 = 1 $z $p $b $s")->count();
        $all_page=ceil($count/$page_num);
        $res=M()->table("xk_choose c")->field("c.*,y.group,y.no,y.createdtime")->join("xk_yaohresult y ON y.cstid=c.id")->where("y.is_yx = 1 $z $p $b $s")->limit($page*$page_num,$page_num)->select();
        $this->assign('page_num', $page_num);
        $this->assign('page', $page+1);
        $this->assign('pages', $page);
        $this->assign('count', $count);
        $this->assign('all_page', $all_page);
        $this->assign('res', $res);
        echo $this->fetch();
    }

    //入场和取消入场
    public  function sign(){
        if(!IS_AJAX){
            $this->error("非法操作",U("index/index"));
        }
        date_default_timezone_set('prg');
        M()->startTrans();//开启事务
        $id=I("id",0,'intval');
        $zt=I("zt",1,'intval');

        if($zt===0){
            $data['log_type']='取消入场';
        }else{
            $data['log_type']='入场';
        }
        $data['choose_id']=$id;
        $data['user_id']=$this->get_user_id();
        $data['log_time']=time();
        $data['log_ip']=$this->getIP();
        try{
            M()->table('xk_choose')->where("id=$id")->save(['is_admission'=>$zt,'admission_time' => time()]);
            M()->table('xk_yaohresult')->where("cstid=$id")->save(['status'=>$zt]);
            M()->table("xk_choose2user_log")->add($data);
            M()->commit();
            echo 'true';
        }catch (\Think\Exception $e) {
            M()->rollback();
            echo $e->getMessage();exit;
        }
    }

    //导出EXCEL
    public function check_excel(){
        $pid=I("pid",0,"intval");
        $bid=I("bid",0,"intval");
        $search=I("search",'',"trim");
        $zt=I("zt",0,"intval");
        $p='';
        $b='';
        $s='';
        if($pid !== 0){
            $p="AND c.project_id =$pid";
        }
        if($bid !== 0){
            $b="AND c.batch_id =$bid";
        }
        if($search !== ''){
            $s="AND (c.customer_name like '%$search%' OR c.like_p like '%".strencode($search)."%' OR c.like_c like '%".strencode($search)."%' )";
        }
        if($zt<2){
            $z="AND c.is_sign=$zt";
        }else{
            $z='';
        }
        $res=M()->table("xk_choose c")->field("c.customer_name,c.customer_phone,c.cardno,c.cyjno,c.ywy,c.is_admission,y.group,y.no,y.createdtime")->join("xk_yaohresult y ON y.cstid=c.id")->where("y.is_yx = 1 $z $p $b $s")->select();
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        if ($zt === 1) {
            $filename = '客户数据-已入场-' . time() . ".xls";
        } elseif ($zt ===0){
            $filename = '客户数据-未入场-' . time() . ".xls";
        }else{
            $filename = '客户数据-全部-' . time() . ".xls";
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '客户名称');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '手机号码');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '身份证号码');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '诚意金编号');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '置业顾问');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '分组');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '入场序号');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '生成时间');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '状态');
        for ($k = 0; $k < count($res); $k++) {
            if($res[$k]['is_admission'] == 0){
                $p="未入场";
            }else{
                $p="已入场";
            }
//            $objActSheet->setCellValue($j.$column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($k + 2), $res[$k]['customer_name']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . ($k + 2), rsa_decode($res[$k]['customer_phone'], getChoosekey()), \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . ($k + 2), rsa_decode($res[$k]['cardno'], getChoosekey()), \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($k + 2), $res[$k]['cyjno']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($k + 2), $res[$k]['ywy']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($k + 2), $res[$k]['group']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($k + 2), $res[$k]['no']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($k + 2), date('Y-m-d h:i:s',$res[$k]['createdtime']));
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($k + 2), $p);
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        $filename = urlencode($filename);
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