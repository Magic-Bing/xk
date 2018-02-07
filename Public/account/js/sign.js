/**
 * Created by Administrator on 2018/1/22 0022.
 */
var num=1;
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
        num=1;
        var row=$('#new_rows').val();
        $("#search-one").val('');
        var op=$("#hidden-select option[pid='"+id+"']");
        var str="";
        if(op.length === 1){
            // alert(1);
            str+="<option value='"+op.attr('value')+"' selected>"+op.text()+"</option>";
            $("#batch-one").html(str);
        }else{
            str+="<option value=''>全部</option>";
            if(op.length > 1) {
                // alert(2);
                for(var i=0;i<op.length;i++){
                    str+="<option value='"+op.eq(i).attr('value')+"'>"+op.eq(i).text()+"</option>";
                }
            }
            // alert(0);
            $("#batch-one").html(str);
        }
        $.post(sign.user_list,{pid:id,num:row,zt:zt},function (data) {
            $("#user_list").html(data);
            user_ajax();
        });
    });


    //选择批次
    $("#batch-one").on('change',function () {
        var pid=$('#project-not-sign').val();
        var bid=$('#batch-one').val();
        num=1;
        var row=$('#new_rows').val();
        $("#search-one").val('');
        $.post(sign.user_list,{pid:pid,bid:bid,num:row,zt:zt},function (data) {
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
            $.post(sign.user_list,{pid:pid,bid:bid,search:search,num:row,zt:zt},function (data) {
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
            $('#new_rows').val(2);
            return false;
        }else if(isNaN(Number(row))){
            layer_alert("请输入数字类型！");
            $('#new_rows').blur();
            $('#new_rows').val(2);
            return false;
        }
        var all_count=$("#all_count").text();

        var all_page=Math.ceil(all_count/row);
       $("#all_page").text(all_page);
        $('#new_page').val(1);
        num=1;
        if(event.keyCode === 13){
            $.post(sign.user_list,{pid:pid,bid:bid,search:search,page:(num-1),num:row,zt:zt},function (data) {
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
            $.post(sign.user_list,{pid:pid,bid:bid,search:search,page:(num-1),num:row,zt:zt},function (data) {
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
        $.post(sign.user_list,{pid:pid,bid:bid,search:search,page:(num-1),num:row,zt:zt},function (data) {
            $("#user_list").html(data);
            user_ajax();
        });
    });
    /*====================END=====================*/
    /*====================公用=====================*/
    //当用列表被ajax赋值后调用

    //tr的点击事件
    $(document).on("click",".user-tr",function (event) {
        event.stopPropagation();
        $(".user-tr").removeClass("tr-selected");
        $(this).addClass("tr-selected");
        var td=$(this).find('td');
        var pd=Number($(this).attr("data-is-sign"));
        var id=Number($(this).attr("data-id"));
        var bid=$(this).attr("data-bid");
        var pid=$(this).attr("data-pid");
        $("#pname").val($.trim($("#project-not-sign option[value='"+pid+"']").text()));
        $("#bname").val($.trim($("#batch-one option[value='"+bid+"']").text()));
        $("#uname").val($.trim(td.eq(1).text()));
        $("#uphone").val($.trim(td.eq(2).text()));
        $("#card").val($.trim(td.eq(3).text()));
        $("#cyjno").val($.trim(td.eq(4).text()));
        $("#money").val($(this).attr('money'));
        $("#ywy").val($.trim(td.eq(5).text()));
        $("#yphone").val($(this).attr('data-yp'));
        if(pd === 0){
            $("#button-sign").show().attr("data-id",id);
            $("#sign-reset").hide();
        }else{
            $("#sign-reset").show().attr("data-id",id);
            $("#button-sign").hide();
        }
    });
    //签到
    $(document).on("click",'.sign-check,#button-sign',function () {
        var id=$(this).attr('data-id');
        $.post(sign.sign,{id:id,zt:1},function (data) {
            if(data === "true"){
                layer_msg("签到成功！");
                $("#batch-one").trigger("change");
                $("#sign-reset").show().attr('data-id',$("#button-sign").attr('data-id'));
                $("#button-sign").hide();
                // setTimeout(function () {
                //     window.location.reload();
                // },1000)
            }else{
                layer_alert('异常错误，请刷新重试');
            }
        });
    });
    //取消签到
    $(document).on("click",'.sign-cancel,#sign-reset',function () {
        var id=$(this).attr('data-id');
        $.post(sign.sign,{id:id,zt:0},function (data) {
            if(data === "true"){
                layer_msg("取消签到成功！");
                $("#batch-one").trigger("change");
                $("#sign-reset").hide();
                $("#button-sign").show().attr('data-id',$("#sign-reset").attr('data-id'));;
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
        window.location.href=sign.check_excel+"?pid="+pid+"&bid="+bid+"&search="+search+"&zt="+zt;
    });
    /*====================END=====================*/
});