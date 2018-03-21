/**
 * Created by Administrator on 2018/1/22 0022.
 */
var num=1;
//当用列表被ajax赋值后调用
function user_ajax() {
    var tr=$("#sample-table-choose .user-tr");
    if(tr.length === 1){
        tr.trigger('click');
    }
    // console.log(tr.length);
}
//分页公用方法
function pageNum(txt,num) {
    // alert(txt);
    // alert(len);
    // alert(num);
    var pageCount=$("#all_page").text();
    if(txt==="«"){
        if(num>1){
            num=Number(num)-1;
        }else{
            num=1;
        }
    }else if(txt==="»"){
        if(num===Number(pageCount)){
            num=Number(pageCount);
        }else{
            num=Number(num)+1;
        }
    }else{
        console.log(txt);
        if(Number(txt) > Number(pageCount)){
            layer_alert("因为调整了显示条数，当前页数大于了总页数！请选择小于"+pageCount+'的页数');
            return false;
        }
        num=txt;
    }
    return num;
}
$(function () {
    /*==================sign===================*/
    var zt=$("#sign-zt").text();//状态码，判断是否签到
    // console.log(zt);
    //选择项目
    $("#project-not-sign").on('change',function () {
        var id=$(this).val();
        // num=1;
        // var row=$('#new_rows').val();
        // $("#search-one").val('');
        var op=$("#hidden-select option[pid='"+id+"']");
        var str="";
        if(op.length === 1){
            // alert(1);
            str+="<option value='"+op.attr('value')+"' selected>"+op.text()+"</option>";
            $("#batch-one").html(str);
            $("#batch-one").trigger('change');
        }else{
            str+="<option value='0'>请选择批次</option>";
            if(op.length > 1) {
                // alert(2);
                for(var i=0;i<op.length;i++){
                    str+="<option value='"+op.eq(i).attr('value')+"'>"+op.eq(i).text()+"</option>";
                }
            }
            // alert(0);
            $("#batch-one").html(str);
            if(Number(brid)!==0){
                $("#batch-one").val(brid);
            }
        }
        if(Number(brid)!==0){
            $("#batch-one").trigger('change');
        }
        // $.post(admission.user_list,{pid:id,num:row,zt:zt},function (data) {
        //     $("#user_list").html(data);
        //     user_ajax();
        // });
    });
    // $("#project-not-sign").trigger('change');
    //选择批次
    $("#batch-one").on('change',function () {
        var pid=$('#project-not-sign').val();
        var bid=$('#batch-one').val();
        if(Number(bid) === 0){
            $("#user_list").html('<table id="sample-table-choose" class="table table-striped table-bordered table-hover dataTable"><thead> <tr> <th class="center hidden-480" style="min-width: 20px"> 序号 </th> <th>客户姓名</th> <th> <i class="icon-phone bigger-110 hidden-480"></i> 客户手机 </th> <th>身份证号码</th> <th>诚意单号</th> <th>置业顾问</th> <th>分组</th> <th>入场序号</th> <th>生成时间</th> <th>操作</th> </tr> </thead> <tbody> <tr><td colspan="11" class="center">请先选择项目和批次...</td> </tr> <tr> <td colspan="11"> <button class="btn btn-xs btn-primary" style="float: right" id="check_user1"> <i class="icon-cloud-download bigger-110"></i> </button> </td> </tr> </tbody> </table><div class="row"> <div class="col-sm-6"> <div class="dataTables_info" id="sample-table-2_info">第 <input id="new_page" type="tel" value="0" style="width:30px" class="tzpage"> 页/ <span id="all_page">0</span>页，每页<input id="new_rows" type="tel" value="10" style="width:30px" class="tzrows"> 条/共 <span id="all_count">0</span> 条 </div> </div> <div class="col-sm-6"> </div> </div> </div>');
            return false;
        }
        num=1;
        var row=$('#new_rows').val();
        $("#search-one").val('');
        $.post(admission.user_list,{pid:pid,bid:bid,num:row,zt:zt},function (data) {
            $("#user_list").html(data);
            user_ajax();
        });
    });

    //搜索框
    $("#search-one").on("keyup",function () {
        var search=$(this).val();
        var pid=$('#project-not-sign').val();
        var bid=$('#batch-one').val();
        num=1;
        var row=$('#new_rows').val();
        if(event.keyCode === 13){
            if(Number(bid) === 0){
                $(this).val('');
                $(this).blur();
                layer_alert("请先选择项目和批次！");
                return false;
            }
            $.post(admission.user_list,{pid:pid,bid:bid,search:search,num:row,zt:zt},function (data) {
                $("#user_list").html(data);
                user_ajax();
            });
        }
    });

    //自定义跳转页数和显示条数
    $(document).on("keyup",'#new_rows',function () {
        var search=$("#search-one").val();
        var pid=$('#project-not-sign').val();
        var bid=$('#batch-one').val();

        var row=$('#new_rows').val();
        if(Number(row) < 1){
            layer_alert("查询的条数不能小于1！");
            $('#new_rows').blur();
            $('#new_rows').val(10);
            return false;
        }else if(isNaN(Number(row))){
            layer_alert("请输入数字类型！");
            $('#new_rows').blur();
            $('#new_rows').val(10);
            return false;
        }
        var all_count=$("#all_count").text();

        var all_page=Math.ceil(all_count/row);
       $("#all_page").text(all_page);
        $('#new_page').val(1);
        num=1;
        if(event.keyCode === 13){
            $.post(admission.user_list,{pid:pid,bid:bid,search:search,page:(num-1),num:row,zt:zt},function (data) {
                $("#user_list").html(data);
                user_ajax();
            });
        }
    });
    $(document).on("keyup",'#new_page',function () {
        var search=$("#search-one").val();
        var pid=$('#project-not-sign').val();
        var bid=$('#batch-one').val();
        num=$('#new_page').val();
        var row=$('#new_rows').val();
        var all_page=Number($("#all_page").text());
        if(Number(num) < 1){
            layer_alert("查询的页数不能小于1！");
            $('#new_page').blur();
            $('#new_page').val(1);
            return false;
        }else if(Number(num) > all_page){
            layer_alert("查询的页数不能大于总的页数！");
            $('#new_page').blur();
            $('#new_page').val(1);
            return false;
        }else if(isNaN(Number(num))){
            layer_alert("请输入数字类型！");
            $('#new_page').blur();
            $('#new_page').val(1);
            return false;
        }
        if(event.keyCode === 13){
            $.post(admission.user_list,{pid:pid,bid:bid,search:search,page:(num-1),num:row,zt:zt},function (data) {
                $("#user_list").html(data);
                user_ajax();
            });
        }
    });

    //分页
    $(document).on("click","#not-sign>li",function(){
        var search=$("#search-one").val();
        var pid=$('#project-not-sign').val();
        var bid=$('#batch-one').val();
        var row=$('#new_rows').val();
        var tx=$(this).text();
        num=pageNum(tx,num);
        console.log(num);
        $.post(admission.user_list,{pid:pid,bid:bid,search:search,page:(num-1),num:row,zt:zt},function (data) {
            $("#user_list").html(data);
            user_ajax();
        });
    });
    /*====================END=====================*/
    /*====================公用=====================*/

    //关闭弹出框
    $("#shadow,#off-alert").on("click",function () {
        $("#shadow").hide();
        $("#admission").hide();
    });
    //tr的点击事件
    $(document).on("click",".user-tr",function (event) {
        event.stopPropagation();
        $("#shadow").show();
        $("#admission").show();
        $(".user-tr").removeClass("tr-selected");
        $(this).addClass("tr-selected");
        var td=$(this).find('td');
        var pd=Number($(this).attr("data-is-admission"));
        var id=Number($(this).attr("data-id"));
        $("#admission-txt h1").text($.trim(td.eq(1).text()));
        $("#admission-txt p span:first").text($.trim(td.eq(2).text()));
        $("#admission-txt p span").eq(1).text($.trim(td.eq(4).text()));
        $("#admission-txt p").eq(1).text($.trim(td.eq(3).text()));
        $("#admission-group p").eq(0).find('span').text($.trim(td.eq(6).text()));
        $("#admission-group p").eq(1).find('span').text($.trim(td.eq(7).text()));
        if(pd === 0){
            $("#button-sign").show().attr("data-id",id).attr("data-name",$.trim(td.eq(1).text()));
            $("#sign-reset").hide();
        }else{
            $("#sign-reset").show().attr("data-id",id).attr("data-name",$.trim(td.eq(1).text()));
            $("#button-sign").hide();
        }
    });

    //入场
    $(document).on("click",'.sign-check,#button-sign',function (event) {
        event.stopPropagation();
        var id=$(this).attr('data-id');
        var name=$(this).attr('data-name');
        $.post(admission.admission,{id:id,zt:1,name:name},function (data) {
            if(data === "true"){
                speckText("入场成功！");
                layer_msg("入场成功！");
                $("#batch-one").trigger("change");
                $("#sign-reset").show().attr('data-id',$("#button-sign").attr('data-id')).attr('data-name',$("#button-sign").attr('data-name'));
                $("#button-sign").hide();
                $("#shadow").hide();
                $("#admission").hide();
                // setTimeout(function () {
                //     window.location.reload();
                // },1000)
            }else{
                layer_alert('异常错误，请刷新重试');
            }
        });
    });
    //取消入场
    $(document).on("click",'.sign-cancel,#sign-reset',function (event) {
        event.stopPropagation();
        var id=$(this).attr('data-id');
        var name=$(this).attr('data-name');
        $.post(admission.admission,{id:id,zt:0,name:name},function (data) {
            if(data === "true"){
                layer_msg("取消入场成功！");
                $("#batch-one").trigger("change");
                $("#sign-reset").hide();
                $("#button-sign").show().attr('data-id',$("#sign-reset").attr('data-id')).attr('data-name',$("#sign-reset").attr('data-name'));
                $("#shadow").hide();
                $("#admission").hide();
                // setTimeout(function () {
                //     window.location.reload();
                // },1000)
            }else{
                layer_alert('异常错误，请刷新重试');//data就是异常信息
            }
        });
    });
    $(document).on("click","#check-excel",function () {
        var search=$("#search-one").val();
        var pid=$('#project-not-sign').val();
        var bid=$('#batch-one').val();
        window.location.href=admission.check_excel+"?pid="+pid+"&bid="+bid+"&search="+search+"&zt="+zt;
    });
    /*====================END=====================*/
});