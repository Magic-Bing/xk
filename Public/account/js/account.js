//通用
$(function() {
	"use strict";
    //千分位
    function comdify(n){
        var re=/\d{1,3}(?=(\d{3})+$)/g;
        var n1=n.replace(/^(\d+)((\.\d+)?)$/,function(s,s1,s2){return s1.replace(re,"$&,")+s2;});
        return n1;
    }
	/*用户权限设置-删除岗位*/
    //删除岗位
    $(document).on("click",".delete-station",function () {
        var t=$(this),id=t.attr("data-id");
        layer_confirm('是否删除该岗位,删除岗位后与之相关的数据也会全部删除！', function () {
            $.ajax({
                url: station.delete_station,
                data: {
                    id: id
                },
                type: 'POST',
                dataType: 'JSON',
                success: function (data, status) {
                    if (typeof(data.status) === undefined) {
                        layer_alert('请求失败，请重试！');
                        return false;
                    }
                    if (data.status === false) {
                        alert(data.info);
                        return false;
                    }
                    layer_msg(data.info);
                    setTimeout(function () {
                        window.location.reload();
                    },1000)
                },
                error: function (data, status, e) {
                    layer_alert('提交连接失败！');
                }
            });
        });

    });

    /*2017-12-15 qzb 优化和修改*/
    $(document).on("mouseover","#sample-table-choose .img-url",function () {
            var obj=$(this).offset();
            var img=$("#hx-img");
            var url=$.trim($(this).prev("td").text());
            img.css({'top':(obj.top-70),'left':(obj.left-150)});
            img.find("img").attr("src",url);
            img.show();
    });
    $(document).on("mouseout","#sample-table-choose .img-url",function () {
        var img=$("#hx-img");
        img.hide();
    });
    /*房间导入2018-3-9*/
    //用户信息 - 导入excel - 提交
    $(document).on('click', ".js-choose-room-excel-import-tpl-btn-room", function() {
        var $form = $(this).parent().parent().parent();
        var $formData = new FormData($form[0]);

        var options = {
            url: $form.attr('action'),
            type: 'POST',
            dataType: 'JSON',
            async: false,
            cache: false,
            data: $formData,
            // 告诉jQuery不要去处理发送的数据
            processData : false,
            // 告诉jQuery不要去设置Content-Type请求头
            contentType : false,
            success: function (data) {
                if (data['status'] === 0) {
                    layer_alert(data['info']);
                    return false;
                } else {
                    console.log(data);
                  if(data['info']['correct_count'] === 0){
                      $("#layui-layer100001").hide();
                      layer_alert("全部数据异常,点击确认后自动下载异常数据！",function () {
                          layer_close_all();
                          $(".layui-layer-shade").hide();
                          window.open("http://"+window.location.host+"/"+data['info']['error_url']);
                      })
                  }else if(data['info']['error_count'] === 0){
                      $("#layui-layer100001").hide();
                      layer_alert("一共"+data['info']['correct_count']+"条，添加成功"+data['info']['add']+"条，修改成功"+data['info']['update']+"条.",function () {
                          window.location.reload();
                      });
                  }else{
                      $("#layui-layer100001").hide();
                      layer_alert("一共"+(data['info']['correct_count']+data['info']['error_count'])+"条，添加成功"+data['info']['add']+"条，修改成功"+data['info']['update']+"条,存在异常数据"+data['info']['error_count']+"条，确认后自动下载",function () {
                          layer_close_all();
                          $(".layui-layer-shade").hide();
                          window.open("http://"+window.location.host+"/"+data['info']['error_url']);
                          window.location.reload();
                      })
                  }

                }
            },
            error: function () {
                gritter_alert("导入失败，请确认后重试！");
            }
        };
        $.ajax(options);
        return false;
    });

	/*         END            */
	/*2017-09 qzb*/
    /**===================== 交易管理 =======================**/

    //记录作废
	$(document).on("click",".js-choose-user-circle-btn",function () {
        var $id = $(this).attr("data-id");
        var tr=$(this).parents("tr");
        var callback = function() {
			$.ajax({
				type:"post",
				url:xsgl_url.update_off,
				data:{id:$id},
				success:function (data) {
					if(data=="false"){
                        layer_alert("作废失败，请刷新重试！");
					}else{
                        layer.msg("作废成功");
						window.location.reload();
					}
                }
			});
        };

        layer_confirm('确认作废吗，作废后将不能恢复？', callback);
    });

	//项目切换
    $(document).on("change",".js-trade-project-id",function () {
       
        $("#form-p").submit();
        // var project_id=$(".js-trade-project-id").val();
        // window.location.href="http://"+window.location.host+"/Account/Xsgllog/index/project_id/"+project_id;
	});
    $(document).on("change",".js-trade-zt-id,.js-trade-batch-id",function () {
        
        $("#form-b").submit();
		// group_select();
		// return false;
    });

    //搜索框的回车时间
    // $(document).on("keydown","#zt_cx",function () {
    // 	if(event.keyCode==13){
    //         group_select();
    //         return false;
		// }
    //
    // });

	//条件筛选
	function group_select() {
		var project_id=$(".js-trade-project-id").val();
		var word=$(".js-choose-jy-word").val();
		var batch_id=$(".js-trade-batch-id").val();
		var w='';
		if(word!=""){
			w="/word/"+word;
		};
		var pd=$(".js-trade-zt-id").val();
        var p="/pd/"+pd;
        window.location.href="http://"+window.location.host+"/Account/Xsgllog/index/project_id/"+project_id+w+p+'/batch_id/'+batch_id;
    }
    //修改状态和时间
    $(document).on("click",".update_zt",function (){
    	var vo=$.trim($(this).text());
    	var tr=$(this).parents("tr");
    	var pay=$.trim(tr.attr('data-pay'));
    	var tm=$.trim(tr.find("td").eq(7).text());
    	var bl=$.trim(tr.attr('data-bl'));
    	var je=$.trim(tr.attr('data-je'));
    	var id=$(this).attr("data-id");
    	var price=tr.find("td").eq(8).text();
    	// console.log(pay);
        price=Number(price.replace(/,/g,''));
        layer.open({
			title:['修改信息','text-align:center;margin-left:50px'],
            type: 1,
            skin: 'layui-layer-rim', //加上边框
            // area: ['350px', 'auto'], //宽高
            content:'' +
			'<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%">选购状态：<select name="zt" id="zt" style="width: 70%">' +
			'<option '+(vo==='选房'?"selected":"")+'>选房</option>' +
			'<option '+(vo==='认购'?"selected":"")+'>认购</option>' +
			'<option '+(vo==='签约'?"selected":"")+'>签约</option>' +
			'</select></label>' +
            '<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%;'+(vo==='选房'?"display: none":"")+'" id="label-1">付款方式：<select  name="pay" id="pay"   style="width: 70%">' +
            '<option value="" '+(vo===''?"selected":"")+'>请选择付款方式</option>' +
            '<option '+(pay==='一次性'?"selected":"")+'>一次性</option>' +
            '<option '+(pay==='公积金'?"selected":"")+'>公积金</option>' +
            '<option '+(pay==='按揭'?"selected":"")+'>按揭</option>' +
            '<option '+(pay==='分期'?"selected":"")+'>分期</option>' +
            '</select></label>' +
            '<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%;'+(pay==='一次性' || pay===''?"display: none":"")+'" id="label-2">贷款比例：' +
            '<input type="number" name="proportion" id="proportion"  placeholder="输入比例" style="width: 70%" value="'+bl+'">' +
            '<br/>贷款金额：<input type="number" name="money" id="money"  placeholder="输入金额" style="width: 70%;margin-top: 15px;margin-bottom: 0" value="'+je+'">' +
            '<input type="hidden" value="'+price+'"></label>' +
            '<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%;"><span style="float: left">选购时间：</span><input style="width: 70%" value="'+tm+'" type="text"  id="zt_time" placeholder="请选择时间" class="col-xs-8 col-sm-8 js-choose-activity-add-start-time" onfocus="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:ss\',skin:\'twoer\'})"></label>'+
			'',
			btn:['取消','修改'],
			btn2:function () {
				var zt=$("#zt").val();//状态
				var zt_time=$("#zt_time").val();//修改时间
				var pay=$("#pay").val();//付款方式
				var proportion=$("#proportion").val();
				var money=$("#money").val();
				if($.trim(zt_time)===''){
					layer_alert("时间不能为空！");
					return false;
				}
                if(zt === '选房'){
                    pay='';
                }else{
                    if ($.trim(pay)==='一次性'){
                        proportion=0;
                        money=0;
                    }else{
                        if(money === ''&& $.trim(pay) !==''){
                            layer_alert("付款金额不能为空！");
                            return false;
                        }
                    }
                }
                var res={id:id,zt:zt,tm:zt_time,pay:pay,proportion:proportion,money:money};
                // console.log(res);
				$.ajax({
					type:"post",
					url:xsgl_url.update_zt,
					data:res,
					success:function (data) {
					    if(data ==='true'){
                            layer.msg("修改成功");
                            window.location.reload();
                        }else{
                            layer.msg("修改失败，请刷新后重试！");
                        }

                    }
				});
            }
        });
	});
    //弹出框，里面选房状态的下拉事件
    $(document).on("change",'#zt',function () {
        var vo=$(this).val();
        // console.log(vo);
        if(vo !== '选房'){
            $("#label-1").show();
        }else{
            $("#label-1").hide();
            $("#label-2").hide();
            $('#pay').val('');
        }
    });
    //弹出框，里面付款方式状态的下拉事件
    $(document).on("change",'#label-1 select',function () {
        var vo=$(this).val();
        // console.log(vo);
        if(vo !== '一次性' && vo !== ''){
            $("#label-2").show();
        }else{
            $("#label-2").hide();
        }
    });
    //打印
    $(document).on("click",".print-log",function (){
        var pid=$(this).attr("data-pid");
        var bid=$(this).attr("data-bid");
        var pvid=$(this).attr("data-pvid");

        var tr=$(this).parents("tr");
        var vo=$.trim(tr.find("td").eq(5).text());
        $.post(xsgl_url.get_print,{pid:pid,bid:bid},function (data) {
            // console.log(data.length);
            if(data.length === 0){
                layer_alert("该项目还没有套打模板，请设置后再打印！");
                return false;
            }
            var id=tr.attr("data-id");
            if(data.length === 1 && vo !== '选房' ){
                window.open(xsgl_url.show_print+"?name="+data[0]['html_url']+"&id="+id);
            }else{
                var str='<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%;">选择模版：<select name="print" id="print"  style="width: 70%">';
                if(data.length === 1 && pvid === ''){
                    str+='';
                }else if(data.length === 1 && pvid !== ''){
                    window.open(xsgl_url.show_print+"?name="+data[0]['html_url']+"&id="+id);
                    return false;
                }else{
                    str+='<option value="">请选择一个模板</option>';
                }
                for(var i=0;i<data.length;i++){
                    str+='<option value="'+data[i]['html_url']+'">'+data[i]['name']+'</option>';
                }
                str+='</select></label>';
                var pay=$.trim(tr.attr('data-pay'));
                var tm=$.trim(tr.find("td").eq(7).text());
                var bl=$.trim(tr.attr('data-bl'));
                var je=$.trim(tr.attr('data-je'));
                var price=tr.find("td").eq(8).text();
                // console.log(pay);
                price=Number(price.replace(/,/g,''));
                layer.open({
                    title:['打印信息','text-align:center;margin-left:50px'],
                    type: 1,
                    skin: 'layui-layer-rim', //加上边框
                    // area: ['350px', 'auto'], //宽高
                    content:'' +
                    '<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%">选购状态：<select name="zt" id="zt"  style="width: 70%">' +
                    '<option '+(vo==='选房' && pvid !=='' ?"selected":"")+'>选房</option>' +
                    '<option '+(vo==='认购' || pvid ===''?"selected":"")+'>认购</option>' +
                    '<option '+(vo==='签约'?"selected":"")+'>签约</option>' +
                    '</select></label>' +
                    '<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%;'+(vo==='选房' && pvid !==''?"display: none":"")+'" id="label-1">付款方式：<select  name="pay" id="pay"  style="width: 70%">' +
                    '<option value=""'+(vo===''?"selected":"")+'>请选择付款方式</option>' +
                    '<option '+(pay==='一次性'?"selected":"")+'>一次性</option>' +
                    '<option '+(pay==='公积金'?"selected":"")+'>公积金</option>' +
                    '<option '+(pay==='按揭'?"selected":"")+'>按揭</option>' +
                    '<option '+(pay==='分期'?"selected":"")+'>分期</option>' +
                    '</select></label>' +
                    '<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%;'+(pay==='一次性' || pay===''?"display: none":"")+'" id="label-2">贷款比例：' +
                    '<input type="number" name="proportion" id="proportion"  placeholder="输入比例" style="width: 70%" value="'+bl+'">' +
                    '<br/>贷款金额：<input type="number" name="money" id="money"  placeholder="输入金额" style="width: 70%;margin-top: 15px;margin-bottom: 0" value="'+je+'">' +
                    '<input type="hidden" value="'+price+'"></label>' +
                    '<label style="float: left;margin-left: 27px;margin-top: 10px;width: 90%;"><span style="float: left">选购时间：</span><input value="'+(vo==='选房' && pvid ==='' ?"":tm)+'" type="text"  id="zt_time" placeholder="请选择时间" class="col-xs-8 col-sm-8 js-choose-activity-add-start-time" onfocus="WdatePicker({dateFmt:\'yyyy-MM-dd HH:mm:ss\',skin:\'twoer\'})" style="width: 70%"></label>'+
                    str+
                    '',
                    btn:['取消','打印'],
                    btn2:function () {
                        var print=$("#print").val();
                        // console.log(print);
                        if(print === ''){
                            layer_alert("请选择一个模版！");
                            return false;
                        }
                        var zt=$("#zt").val();//状态
                        var zt_time=$("#zt_time").val();//修改时间
                        var pay=$("#pay").val();//付款方式
                        var proportion=$("#proportion").val();
                        var money=$("#money").val();
                        if($.trim(zt_time)===''){
                            layer_alert("时间不能为空！");
                            return false;
                        }
                        if(zt === '选房'){
                            if(pvid === ''){
                                layer_alert("付款方式为必填项，请更改你的选房状态！");
                                return false;
                            }else{
                                pay='';
                            }
                        }else{
                            if(data[0]['vid'] === null){
                                if($.trim(pay)===''){
                                    layer_alert("付款方式不能为空！");
                                    return false;
                                } else if ($.trim(pay)==='一次性'){
                                    proportion=0;
                                    money=0;
                                }else{
                                    if(money === ''){
                                        layer_alert("付款金额不能为空！");
                                        return false;
                                    }
                                }
                            }else{
                                if ($.trim(pay)==='一次性'){
                                    proportion=0;
                                    money=0;
                                }else{
                                    if(money === '' && $.trim(pay)!==''){
                                        layer_alert("付款金额不能为空！");
                                        return false;
                                    }
                                }
                            }

                        }
                        var res={id:id,zt:zt,tm:zt_time,pay:pay,proportion:proportion,money:money};
                        // console.log(res);
                        $.ajax({
                            type:"post",
                            url:xsgl_url.update_zt,
                            data:res,
                            success:function (data) {
                                if(data ==='true'){
                                    window.location.reload();
                                    window.open(xsgl_url.show_print+"?name="+print+"&id="+id);
                                }else{
                                    layer.msg("数据变更失败，请刷新后重试！");
                                }

                            }
                        });
                    }
                });
            }
        },'json');
    });
    //比例算金额proportion
    $(document).on("input propertychange",'#proportion',function () {
        var price=Number($("#label-2 input[type='hidden']").val());
        var vo=Number($(this).val());
        if(vo > 100){
            layer_alert("比例不能大于100！");
            $(this).val(0);
            $("#money").val(0);
            return false;
        }
        var num=(price*(vo/100)).toFixed(2);
        $("#money").val(num);
    });
    //金额算比例
    $(document).on("input propertychange",'#money',function () {
        var price=Number($("#label-2 input[type='hidden']").val());
        var vo=Number($(this).val());
        if(vo > price){
            layer_alert("金额不能大于总金额！");
            $(this).val(0);
            $("#proportion").val(0);
            return false;
        }
        var num=(vo/price*100).toFixed(2);
        $("#proportion").val(num);
    });
    //给模态框传入用户id值
    $(document).on("click",".update_y",function (){
        // $("#yd_room").show();
        $("#q_room_id").val('').attr("rid",'').attr("room",'');
        var id=$(this).attr("data-id");
        var rid=$(this).attr("data-rid");
        var room=$(this).attr("data-room");
        var pid=$(this).attr("pid");
        var bid=$(this).attr("bid");
        if(rid!=null && rid!=""){
            var vo=$.trim($(this).text());
            $("#oldyd").show();
            $("#oldyd span").text(vo);
            $("#dqyd").hide();
            $("#dqyd span").text("");
            $("#croomtitle").text("修改房间");
        }else{
            $("#oldyd").hide();
            $("#oldyd span").text("");
            $("#dqyd").hide();
            $("#dqyd span").text("");
            $("#croomtitle").text("选择房间");
        }

        $("#yd_room input[type='hidden']").val(id);
        $("#q_room_id").val(room).attr("rid",rid).attr("room",room);
        $("#pid").text(pid);
        $("#bid").text(bid);
        // alert(id);
    });

	//点击空白隐藏
    $(document).click(function(e){
        var divTop = $('#q_room_id');   // 设置目标区域
        var divTop1 = $('#q_room_list');   // 设置目标区域
        if(!divTop.is(e.target) && divTop.has(e.target).length === 0 &&!divTop1.is(e.target) && divTop1.has(e.target).length === 0){
            divTop1.hide()
        }
    });
	//预定房间模糊查询
    $(document).on("input","#q_room_id",function (){
		var rm=$(this).attr("room");
		var vo=$.trim($(this).val());
        var $project_id = $.trim($("#pid").text());
        var $batch_id = $.trim($("#bid").text());
		if(vo.length>2){
            var check_rid="";
			if(Number(vo)==Number(rm)){
			    check_rid=$(".update_y[data-room='"+vo+"']").attr("data-rid");
			}else{
               check_rid="";
            }
                $.ajax({
                    type:"post",
                    url:choose_user_url.add_room,
                    data:{room:vo,pid:$project_id,bid:$batch_id,rid:check_rid},
                    dataType:"json",
                    success:function (data) {
                        $("#q_room_list").html("");
                        if(data.length==0){
                            //$("#q_room_id").attr("rid",'');
                            $("#q_room_list").append("<li style='color: red'>没有找到此房间</li>").show();
                            // $("#dqyd").hide();
                            //$("#dqyd span").text('');
                        }else{
                            for(var i=0;i<data.length;i++){
                                if(data[i]['isyyd']<=0 && data[i]['is_xf']<=0)
                                {
                                    $("#q_room_list").append("<li rid='"+data[i]['id']+"' room='"+data[i]['room']+"' style='height: 24px;line-height: 24px;max-width: 163px;text-align: left;border-bottom: 1px solid #eee;color: red;cursor: pointer'>"+data[i]['buildname']+"-"+data[i]['unit']+"单元-"+data[i]['floor']+"层-"+data[i]['room']+"</li>");
                                }else
                                {
                                    $("#q_room_list").append("<li rid='"+data[i]['id']+"' room='"+data[i]['room']+"'  class='isyyd' style='height: 24px;line-height: 24px;max-width: 163px;text-align: left;border-bottom: 1px solid #eee;color: #d6d0d0;cursor: default'>"+data[i]['buildname']+"-"+data[i]['unit']+"单元-"+data[i]['floor']+"层-"+data[i]['room']+"<span style ></span></li>");
                                }
		                        }
                            $("#q_room_list").show();
                            $("#q_room_list li").on("mouseover",function () {//鼠标移入变色
                                if(!$(this).hasClass("isyyd"))
                                {
                                    $(this).css("background-color","pink");
                                }
                            });
                            $("#q_room_list li").on("mouseout",function () {//鼠标移出还原
                                $(this).css("background-color","#FFF");
                            });
                            $("#q_room_list li").on("click",function () {
                                if(!$(this).hasClass("isyyd"))
                                {
                                    var rid=$(this).attr("rid");
                                    var vo=$(this).attr("room");
                                    var tx=$.trim($(this).text());
                                    if(vo!=""){
                                        $("#q_room_id").val(vo).attr("rid",rid);
                                        $("#q_room_list").html("");
                                        $("#dqyd").show();
                                        $("#dqyd span").text(tx);
                                    }
                                }
                            });
                            var a=-1;
                            var li=$("#q_room_list li");
                            if(li.length==1){
                                $("#q_room_list li").eq(0).trigger("click");
                            }
                            $(document).on("keyup","#q_room_id",function (){
                                if(event.keyCode==38){
                                    if(a!=-1 && a!=0){
                                        a--;
                                        li.eq(a).css("background-color","pink").attr("no","1");
                                        $("#q_room_list li").not(li.eq(a)).css("background-color","#FFF").attr("no","0");
                                    }
                                }
                                if(event.keyCode==40){
                                    if(a<(li.length-1)){
                                        a++;
                                        li.eq(a).css("background-color","pink").attr("no","1");
                                        $("#q_room_list li").not(li.eq(a)).css("background-color","#FFF").attr("no","0");
                                    }
                                }
                                if(event.keyCode==13){
                                    $("#q_room_list li[no='1']").trigger("click");
                                }
                            });

                        }
                    }
                });


		}else{
            $("#q_room_list").hide();
		}
		return false;
	});
    // $(document).on("blur","#q_room_id",function (){
     //        $("#q_room_list").hide();
	// });
    $(document).on("focus","#q_room_id",function (){
        var vo=$.trim($(this).val());
        if(vo.length>2 &&  $("#q_room_list li").length>0) {
            $("#q_room_list").show();
        }
    });

	//提交预定房间
    $(document).on("click","#update_yd",function (){
    	var uid=$("#yd_room input[type='hidden']").val();
    	var rid=$("#q_room_id").attr("rid");
    	var room=$("#q_room_id").attr("room");
    	var vo=$("#q_room_id").val();
    	if(rid=="" || rid==null || rid==undefined){
    		layer_alert("请输入正确的房号！");
			return false;
		}
		if(vo==room){
                    layer_alert("预定房间未变化，无需重新设置！");
                    return false;
		}
		$.ajax({
			type:"post",
			url:choose_user_url.update_yd,
			data:{uid:uid,rid:rid},
			success:function (data) {
				if(data=="true"){
                                    layer_msg("预定成功！");
                                    window.location.reload();
					
				}else {
                                    layer_alert(data);
				}
            }
			
		})
	});

    //清空预定房间
    $(document).on("click","#update_qx",function (){
    	var uid=$("#yd_room input[type='hidden']").val();
		$.ajax({
			type:"post",
			url:choose_user_url.update_qx,
			data:{uid:uid},
			success:function (data) {
				if(data=="true"){
                                    layer_msg("取消预定成功！");
                                    window.location.reload();	
				}else {
                                    layer_alert(data);
				}
            }
			
		})
	});

    //微信认购

    // //微信设置模糊搜索
    // $("#sz_ss").on('keyup', function() {
    //     var $word = $(this).val();
    //     if(event.keyCode==13){
    //         if($word !=="" && $word!==undefined){
    //            $("#form-b").submit();
    //         }else{
    //             $("#form-b").on("submit",function () {
    //                 return false;
    //             });
    //         }
    //     }
    // });
//微信设置页面批次切换
    $("#wx_sz").on('change', function() {
        $("#form-b").submit();
        // var $word = $(".js-choose-activity-word").val();
        // var pid=$(".js-choose-order_house-project-id").val();
        // var bid=$(".js-choose-activity-batch-id").val();
        // window.location.href="http://"+window.location.host+"/Account/WeixBuyset/index.html?project_id="+pid+"&word="+$word+"&batch_id="+bid;

    });

    //微信记录项目切换
    $("#jl_pid").on('change', function() {
        $("#form-p").submit();
        // var pid=$("#jl_pid").val();
        // window.location.href="http://"+window.location.host+"/Account/WeixBuylog/index.html?project_id="+pid;

    });
	//微信记录批次切换
    $("#jl_pc").on('change', function() {
        $("#form-b").submit();
        // var word = $("#jl_ss").val();
        // var pid=$("#jl_pid").val();
        // var bid=$("#jl_pc").val();
        // var status=$("#jl_status").val();
        // window.location.href="http://"+window.location.host+"/Account/WeixBuylog/index.html?project_id="+pid+"&word="+word+"&batch_id="+bid+"&status="+status;

    });
    //微信记录状态
    $("#jl_status").on('change', function() {
        $("#form-b").submit();
        // var word = $("#jl_ss").val();
        // var pid=$("#jl_pid").val();
        // var bid=$("#jl_pc").val();
        // var status=$("#jl_status").val();
        // window.location.href="http://"+window.location.host+"/Account/WeixBuylog/index.html?project_id="+pid+"&word="+word+"&batch_id="+bid+"&status="+status;

    });
    // //微信记录模糊搜索
    // $("#jl_ss").on('keyup', function() {
    //     var word = $("#jl_ss").val();
    //     if(event.keyCode==13){
    //         var pid=$("#jl_pid").val();
    //         var bid=$("#jl_pc").val();
    //         var status=$("#jl_status").val();
    //         window.location.href="http://"+window.location.host+"/Account/WeixBuylog/index.html?project_id="+pid+"&word="+word+"&batch_id="+bid+"&status="+status;
    //     }
    //
    // });

    //导出记录数据
	$("#check_jl").on("click",function () {
		var num=Number($("#sample-table-2_info span").text());
		if(num>0){
            var word = $("#jl_ss").val();
            var pid=$("#jl_pid").val();
            var bid=$("#jl_pc").val();
            window.location.href="http://"+window.location.host+"/Account/WeixBuylog/check_jl.html?project_id="+pid+"&word="+word+"&batch_id="+bid;
		}else{
			layer_alert("没有数据，不能导出！");
			return false;
		}

    });


    
    
    //销控LED项目切换
    $(".xkled-project-id").on('change', function() {
        // var pid=$(".xkled-project-id").val();
        // window.location.href="http://"+window.location.host+"/Account/xsglled/index.html?project_id="+pid;
        $("#form-p").submit();

    });
	//销控LED批次切换
    $(".xkled-batch-id").on('change', function() {
        // var pid=$(".xkled-project-id").val();
        // var bid=$(".xkled-batch-id").val();
        // window.location.href="http://"+window.location.host+"/Account/xsglled/index.html?project_id="+pid+"&batch_id="+bid;
        $("#form-b").submit();

    });
    
    /**=====================   end   =======================**/

	/*2017-10 qzb*/
    /**===================== 户型设置 =======================**/
    //项目切换
    $("#hx_pro").on('change', function() {
        // var pid=$("#hx_pro").val();
        // window.location.href="http://"+window.location.host+"/Account/Hxset/index.html?project_id="+pid;
        $("#form-p").submit();
    });
    //批次切换
    $("#hx_bch").on('change', function() {
        // var word = $("#hx_ss").val();
        // var pid=$("#hx_pro").val();
        // var bid=$("#hx_bch").val();
        // window.location.href="http://"+window.location.host+"/Account/Hxset/index.html?project_id="+pid+"&word="+word+"&batch_id="+bid;
        $("#form-b").submit();
    });
    //模糊搜索
    // $("#hx_ss").on('keyup', function() {
    //     if(event.keyCode==13){
    //         var word = $("#hx_ss").val();
    //         var pid=$("#hx_pro").val();
    //         var bid=$("#hx_bch").val();
    //         window.location.href="http://"+window.location.host+"/Account/Hxset/index.html?project_id="+pid+"&word="+word+"&batch_id="+bid;
    //     }
    //
    // });
	//户型添加
	$("#hx_add").on("click",function () {
		var bid=$("#hx_bch").val();
		if(Number(bid)>0){
            var pid=$("#hx_pro").val();
            var t1=$.trim($("#hx_pro").find("option:selected").text());
            var t2=$.trim($("#hx_bch").find("option:selected").text());
            // alert(t1);
            // alert(t2);
            $("#add_hx input[name='project_id']").val(pid);
            $("#add_hx input[name='batch_id']").val(bid);
            $("#hx_t1").val(t1);
            $("#hx_t2").val(t2);
            $("#hx_tj").modal("show");
		}else{
			layer_alert("请先选择项目批次！")
		}

    });
	//选择图片后加载预览图
    $("#hx_img").change(function(){//添加
        var file = this.files[0];
        if (window.FileReader) {
            var reader = new FileReader();
            // 图片文件转换为base64
            reader.readAsDataURL(file);
            reader.onload = function(){
                // 显示图片
                $("#show_img").attr("src",this.result);
            }
        }
    });

    $("#hx_imgs").change(function(){//修改
        var file = this.files[0];
        if (window.FileReader) {
            var reader = new FileReader();
            // 图片文件转换为base64
            reader.readAsDataURL(file);
            reader.onload = function(){
                // 显示图片
                $("#shows_img").attr("src",this.result);
            }
        }
    });


	//添加提交数据到后台
	$("#add_hx").on("submit",function () {
		var data=new FormData($("#add_hx")[0]);
		$.ajax({
			type:"post",
			url:hx_url.add_hx,
			data:data,
            contentType: false, // 注意这里应设为false
            processData: false,
			success:function (data) {
				if(data=="false"){
					layer_alert("添加失败请重试！")
				}else{
					layer.msg("添加成功");
					window.location.reload();
				}
            }
		});
		return false;
    });

	//删除户型设置
	$(".js-choose-hx-delete-btn").on("click",function () {
		var id=$(this).attr("data-id");
		var tr=$(this).parents("tr");
        var callback = function() {
        	$.ajax({
				type:"post",
				url:hx_url.delete_hx,
				data:{id:id},
				success:function (data) {
                    if (data== 'false') {
						gritter_alert("删除失败请重试！");
						return false;
					} else {
						gritter_alert_success('删除成功！');

						setTimeout(function() {
							tr.remove();
						}, 200);
					}
                }
			});
        }

        layer_confirm('确认删除吗，删除后将不能恢复？', callback);
    });

	//编辑户型设置
    $(".js-choose-hx-edit-btn").on("click",function () {
    	$("#update_hx input[name='area']").val($(this).attr("area"));
    	$("#update_hx input[name='tnarea']").val($(this).attr("tnarea"));
		var tr=$(this).parents("tr");
        $("#hx_t3").val($.trim(tr.find("td").eq(2).text()));
        $("#update_hx input[name='hx']").val($.trim(tr.find("td").eq(3).text()));
        $("#update_hx input[name='id']").val($.trim(tr.find("td").eq(1).text()));
        $("#update_hx input[name='hxmx']").val($.trim(tr.find("td").eq(4).text()));
        $("#shows_img").attr("src","/Uploads/"+$.trim(tr.find("td").eq(5).text()));
        $("#hx_imgs").val("");
       $("#hx_update").modal("show");
    });

    //修改提交数据到后台
    $("#update_hx").on("submit",function () {
        var data=new FormData($("#update_hx")[0]);
        $.ajax({
            type:"post",
            url:hx_url.update_hx,
            data:data,
            contentType: false, // 注意这里应设为false
            processData: false,
            success:function (data) {
            	// alert(data);
            	// return false;
                    layer.msg("修改成功！");
                    window.location.reload();

            }
        });
        return false;
    });
/**=====================   end   =======================**/

	//登录
	$(".js-account-login-btn").on('click', function() {
		var btn = $(this);
		//btn.button('loading');
		
		var $name = $(".js-account-login-name").val();
		var $password = $(".js-account-login-password").val();
		var $remember = $(".js-account-login-remember:checked").val();
		
		var $action = $(".js-account-login-form").attr("action");
		var $success_url = $(".js-account-login-form").attr("data-success-url");
		
		var $login_url = $action;
		
		var $data = {
			name: $name,
			password: $password,
			remember: $remember,
		}
		
		ajax_post_callback($login_url, $data, function(data, status) {
			if (data['status'] != 1) {
				//btn.button('reset');
				
				$(".js-account-login-error-info").text(data['info']);
				$(".js-account-login-error").fadeIn(300);
				
				setTimeout(function() {
					$(".js-account-login-error").fadeOut(500);
				}, 3500);
				
				return false;
			} else {
				// btn.button('reset');
				
				$(".js-account-login-success").fadeIn(300);
				
				setTimeout(function() {
					window.location.href = $success_url;
				}, 500);
			}			
		});
	});
	
	/**===================== 用户信息 =======================**/
	
	//用户信息 - 项目切换
	$(".js-choose-user-project-id").on('change', function() {
		$("#form-p").submit();
	});

    //选房状态切换
    $("#z_t").on('change', function() {
        $("#form-b").submit();
        // var $project_id = $(".js-choose-user-project-id").val();
        // var $batch_id = $(".js-choose-user-batch-id").val();
        // var word=$(".js-choose-user-word").val();
        // var zt=$("#z_t").val();
        // var uid=$("#error").attr("data-zt");
        // var status=$("#c_status").val();
        // window.location.href = choose_user_url.index + '?project_id=' + $project_id+"&zt="+zt+"&word="+word+"&bid="+$batch_id+"&uid="+uid+"&status="+status;
        // return false;
    });

    //批次查询
    $(".js-choose-user-batch-id").on('change', function() {
        $("#form-b").submit();
        // var $project_id = $(".js-choose-user-project-id").val();
        // var $batch_id = $(".js-choose-user-batch-id").val();
        // var word=$(".js-choose-user-word").val();
        // var zt=$("#z_t").val();
        // var uid=$("#error").attr("data-zt");
        // var status=$("#c_status").val();
        // window.location.href = choose_user_url.index + '?project_id=' + $project_id+"&zt="+zt+"&word="+word+"&bid="+$batch_id+"&uid="+uid+"&status="+status;
        // return false;
    });

    //用户状态
    $("#c_status").on('change', function() {
        $("#form-b").submit();
        // var $project_id = $(".js-choose-user-project-id").val();
        // var $batch_id = $(".js-choose-user-batch-id").val();
        // var word=$(".js-choose-user-word").val();
        // var zt=$("#z_t").val();
        // var uid=$("#error").attr("data-zt");
        // var status=$("#c_status").val();
        // window.location.href = choose_user_url.index + '?project_id=' + $project_id+"&zt="+zt+"&word="+word+"&bid="+$batch_id+"&uid="+uid+"&status="+status;
        // return false;
    });

    //导出用户数据到EXCEL
	$("#check_user").on("click",function () {
        var pid = $(".js-choose-user-project-id").val();
        var bid = $(".js-choose-user-batch-id").val();
        var word=$(".js-choose-user-word").val();
        var zt=$("#z_t").val();
        if(pid==0){
        	layer.msg('请选择项目');
            return false;
		}
         if(bid==''){
             layer.msg('请选择项目批次');
             return false;
        }
        window.location.href = choose_user_url.check_user + '?project_id=' + pid+"&bid="+bid+"&zt="+zt+"&word="+word;
		return false;
    });

	//用户信息 - 提交搜索
	$(".js-choose-user-word").on('keydown', function() {
		if(event.keyCode==13){
            // var $project_id = $(".js-choose-user-project-id").val();
            // var $batch_id = $(".js-choose-user-batch-id").val();
            var word=$(".js-choose-user-word").val();
            // var zt=$("#z_t").val();
            // var uid=$("#error").attr("data-zt");
            // var status=$("#c_status").val();
            if (word === '' || word === undefined) {
                window.location.reload();
            }else{
                $("#form-b").submit();
            }
            // var h= window.location.host;
            // window.location.href="http://"+h+"/Account/ChooseUser/index.html?project_id="+ $project_id+"&zt="+zt+"&word="+word+"&bid="+$batch_id+"&uid="+uid+"&status="+status;
		}

	});	

	//用户信息 - 导出excel - 提示
	$(".js-choose-user-excel-export").on('click', function() {
		var $html = $(".js-choose-user-excel-export-tpl").html();
		
		layer_html($html);
		
		return false;
	});

	//用户信息 - 导出excel - 提交
	$(document).on('click', '.js-choose-user-excel-export-tpl-btn', function() {
		var $project_id = $(".js-choose-user-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-user-batch-id").find("option:selected").val();
		
		if ($project_id == 0 || $project_id == undefined) {
			gritter_alert('请选择项目后重试！');
			return false;
		}
		
		if ($batch_id == 0 || $batch_id == undefined) {
			gritter_alert('请选择项目批次后重试！');
			return false;
		}
		
		layer_close_all();
		
		window.location.href = choose_user_url.export 
			+ '?project_id=' + $project_id 
			+ '&batch_id=' + $batch_id;
		
		return false;
	});

	//用户信息 - 导入excel - 提示
	$(".js-choose-user-excel-import").on('click', function() {
		var $html = $(".js-choose-user-excel-import-tpl").html();
		
		layer_html($html);
		
		return false;
	});
	
	//用户信息 - 导入excel - 提交
	$(document).on('click', ".js-choose-user-excel-import-tpl-btn", function() {
		var $form = $(this).parent().parent().parent();
		var $formData = new FormData($form[0]);
		var options = {
			url: $form.attr('action'),
			type: 'POST',
			dataType: 'JSON',
			async: false,  
			cache: false, 
			data: $formData,
			// 告诉jQuery不要去处理发送的数据
			processData : false, 
			// 告诉jQuery不要去设置Content-Type请求头
			contentType : false,
			success: function (data) {
			    // console.log(data);return false;
			    if(data.hasOwnProperty("in_error")){
                    layer.closeAll();
                    layer_alert('存在异常数据！，一共'+data['in_all']+'条，导入成功'+(data['in_all']-data['in_error'])+"条，点击确认后下载异常数据.",function () {
                        layer.closeAll();
                        window.open("http://"+window.location.host+data['error_path']);
                        window.location.reload();
                    });
                }else if(data.hasOwnProperty("in_all")){
                    layer.closeAll();
                    layer_msg('全部导入成功');
                    window.location.reload();
                }else{
                    layer_msg(data.info);
                }
			},
			error: function () {
				gritter_alert("导入失败，请确认后重试！");
			}
		};
		
		$.ajax(options);
	
		return false;
	});

    //用户信息 - 导入excel - 提交
    $(document).on('click', ".js-choose-room-excel-import-tpl-btn", function() {
        var $form = $(this).parent().parent().parent();
        var $formData = new FormData($form[0]);

        var options = {
            url: $form.attr('action'),
            type: 'POST',
            dataType: 'JSON',
            async: false,
            cache: false,
            data: $formData,
            // 告诉jQuery不要去处理发送的数据
            processData : false,
            // 告诉jQuery不要去设置Content-Type请求头
            contentType : false,
            success: function (data) {
                if (data['status'] != 1) {
                    layer_alert(data['info']);
                    return false;
                } else {
                    gritter_alert_success('导入成功！');
                    setTimeout(function() {
                        window.location.reload();
                    }, 200);
                }
            },
            error: function () {
                gritter_alert("导入失败，请确认后重试！");
            }
        };

        $.ajax(options);

        return false;
    });


	//用户信息 - 删除
	$(".js-choose-user-delete-btn").on('click', function() {
		var $id = $(this).attr("data-id");
		var callback = function() {
			var $url = choose_user_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {

				if (data['status'] != 1) {
					gritter_alert(data['info']);
					return false;
				} else {
					gritter_alert_success('删除成功！');
					
					setTimeout(function() {
						$(".choose-user-item-" + $id).remove();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callback);
	});

	//用户信息 - 批量删除
	$(".js-choose-user-delete-all-btn").on('click', function() {
		var $ids = [];
		var $item_list = $(".choose-user-item");
		
		for (var $i = 0; $i < $item_list.length; $i ++) {
			var $id = $($item_list[$i]).find(".choose-user-item-id:checked").attr("data-id");
			var pd = $($item_list[$i]).find(".choose-user-item-id:checked").attr("delete");
			if(pd==="false"){
                gritter_alert('存在房间绑定的用户，不能删除！');
                return false;
            }
			if ($id != undefined) {
				$ids.push($id);
			}
		}
		
		if ($ids.length <= 0) {
			gritter_alert('请选择要删除的信息！');
			return false;
		}
	
		var callback = function() {
			var $url = choose_user_url.delete_all;
			
			var $data = {
				ids: $ids,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					gritter_alert(data['info']);
					return false;
				} else {
					gritter_alert_success('批量删除成功！');
					
					setTimeout(function() {
						window.location.href = choose_user_url.index;
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认批量删除吗，删除后将不能恢复？', callback);
	});

	//用户信息 - 添加
	$(".js-choose-user-add-save-btn").on('click', function() {
		var btn = $(this);
		// btn.button('loading');
		
		var $project_id = $(".js-choose-user-add-project-id").find("option:selected").val();
		console.log($project_id);
		var $batch_id = $(".js-choose-user-add-batch-id").find("option:selected").val();
		var $customer_name = $(".js-choose-user-add-customer-name").val();
		var $customer_phone = $(".js-choose-user-add-customer-phone").val();
        var $cyjno = $(".js-choose-user-add-cyjno").val();
        var $cardno = $(".js-choose-user-add-cardno").val();
		var $row_number = $(".js-choose-user-add-row-number").val();
		var $money = $(".js-choose-user-add-money").val();
		/*var $area = $(".js-choose-user-add-area").val();
		var $price = $(".js-choose-user-add-price").val();
		var $house_type = $(".js-choose-user-add-house-type").val();
		var $floor = $(".js-choose-user-add-floor").val();*/
		var $room = $(".js-choose-user-add-room").val();
        var $ywy = $(".js-choose-user-add-ywy").val();
        var $ywyphone = $(".js-choose-user-add-ywyphone").val();
		//var $password = $(".js-choose-user-add-password").val();
		var $status = $(".js-choose-user-add-status").prop('checked') ? 1 : 0;
		var $remark = $(".js-choose-user-add-remark").val();
        var ys_time = $(".js-choose-user-add-ys_time").val();
		
		if ($project_id === '' || $project_id === undefined || $project_id === '0') {
			gritter_alert('项目不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($customer_name === '' || $customer_name === undefined) {
			gritter_alert('客户名称不能为空！');
			// btn.button('reset');
			return false;
		}
        if ($batch_id === '' || $batch_id === undefined) {
            gritter_alert('批次不能为空！');
            // btn.button('reset');
            return false;
        }
		if ($customer_phone === '' || $customer_phone === undefined) {
			gritter_alert('客户电话不能为空！');
			// btn.button('reset');
			return false;
		}
		if (!validate_mobile($customer_phone)) {
			//gritter_alert('客户电话填写错误！');
			//btn.button('reset');
			//return false;
		}
	/*	if ($cyjno === '' || $cyjno === undefined) {
			gritter_alert('诚意金编号不能为空！');
			// btn.button('reset');
			return false;
		}*/
		var $data = {
			project_id: $project_id,
			batch_id: $batch_id,
			customer_name: $customer_name,
			customer_phone: $customer_phone,
            cyjno: $cyjno,
            cardno: $cardno,
            money: $money,
			row_number: $row_number,
			/*area: $area,
			price: $price,
			house_type: $house_type,
			floor: $floor,*/
			room: $room,
            ywy: $ywy,
            ywyphone: $ywyphone,
			//password: $password,
			status: $status,
			remark: $remark,
            ys_time:ys_time,
		};
		
		var $url = choose_user_url.add;
		
		ajax_post_callback($url, $data, function(data, status) {
			// btn.button('reset');
			
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('添加成功！');
				
				setTimeout(function() {
					var $url = choose_user_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});

	//用户信息 - 编辑
	$(".js-choose-user-edit-save-btn").on('click', function() {		
		var btn = $(this);
		// btn.button('loading');

		var $id = $(".js-choose-user-edit-id").val();
		
		var $project_id = $(".js-choose-user-edit-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-user-edit-batch-id").find("option:selected").val();
		var $customer_name = $(".js-choose-user-edit-customer-name").val();
		var $customer_phone = $(".js-choose-user-edit-customer-phone").val();
        var $cardno = $(".js-choose-user-edit-cardno").val();
        var $cyjno = $(".js-choose-user-edit-cyjno").val();
		var $row_number = $(".js-choose-user-edit-row-number").val();
		var $money = $(".js-choose-user-edit-money").val();
		/*var $area = $(".js-choose-user-edit-area").val();
		var $price = $(".js-choose-user-edit-price").val();
		var $house_type = $(".js-choose-user-edit-house-type").val();
		var $floor = $(".js-choose-user-edit-floor").val();*/
		var $room = $(".js-choose-user-edit-room").val();
        var $ywy = $(".js-choose-user-edit-ywy").val();
        var $ywyphone = $(".js-choose-user-edit-ywyphone").val();
		//var $password = $(".js-choose-user-edit-password").val();
		var $status = $(".js-choose-user-edit-status").prop('checked') ? 1 : 0;
		var $remark = $(".js-choose-user-edit-remark").val();
		var ys_time = $(".js-choose-user-edit-ys_time").val();

		if ($id == '' || $id == undefined) {
			gritter_alert('ID错误，请刷新后重试！');
			// btn.button('reset');
			return false;
		}
		if ($project_id == '' || $project_id == undefined) {
			gritter_alert('项目不能为空！');
			// btn.button('reset');
			return false;
		}
        if ($batch_id == '' || $batch_id == undefined) {
            gritter_alert('批次不能为空！');
            // btn.button('reset');
            return false;
        }
		if ($customer_name == '' || $customer_name == undefined) {
			gritter_alert('客户名称不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($customer_phone == '' || $customer_phone == undefined) {
			gritter_alert('客户电话不能为空！');
			// btn.button('reset');
			return false;
		}
		if (!validate_mobile($customer_phone)) {
			//gritter_alert('客户电话填写错误！');
			//btn.button('reset');
			//return false;
		}
		// if ($cyjno == '' || $cyjno == undefined) {
		// 	gritter_alert('诚意金编号不能为空！');
		// 	// btn.button('reset');
		// 	return false;
		// }
		
		var $data = {
			id: $id,
			project_id: $project_id,
			batch_id: $batch_id,
			customer_name: $customer_name,
			customer_phone: $customer_phone,
            cyjno: $cyjno,
            cardno: $cardno,
			row_number: $row_number,
			money: $money,
			/*area: $area,
			price: $price,
			house_type: $house_type,
			floor: $floor,*/
			room: $room,
            ywy: $ywy,
            ywyphone: $ywyphone,
			//password: $password,
			status: $status,
			remark: $remark,
            ys_time:ys_time,
		}
		
		var $url = choose_user_url.edit;
		
		ajax_post_callback($url, $data, function(data, status) {
			// btn.button('reset');
			// console.log(data);
			// return false;
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('更改成功！');
				
				setTimeout(function() {
					var $url = choose_user_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});



	/**===================== 竞价活动 =======================**/
	
	//竞价活动 - 项目切换
	$(".js-choose-activity-project-id").on('change', function() {
		var $project_id = $(this).find("option:selected").val();

		window.location.href = choose_activity_url.index + '?project_id=' + $project_id;
		
		return false;
	});	
	
	//竞价活动 - 提交搜索
	$(".js-choose-activity-word").on('blur', function() {
		var $word = $(this).val();
		if ($word == '' || $word == undefined) {
			return false;
		}

		$(".js-choose-activity-form").submit();
	});

	//竞价活动 - 添加
	$(".js-choose-activity-add-save-btn").on('click', function() {		
		var btn = $(this);
		// btn.button('loading');
		
		var $name = $(".js-choose-activity-add-name").val();
		var $description = $(".js-choose-activity-add-description").val();
		var $project_id = $(".js-choose-activity-add-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-activity-add-batch-id").find("option:selected").val();
		
		var $sort = $(".js-choose-activity-add-sort").val();
		var $person_count = $(".js-choose-activity-add-person-count").val();
		
		var $start_time = $(".js-choose-activity-add-start-time").val();
		var $end_time = $(".js-choose-activity-add-end-time").val();
		var $long_time = $(".js-choose-activity-add-long-time").val();
		var $type = $(".js-choose-activity-add-type:checked").val();

		var $status = $(".js-choose-activity-add-status").prop('checked') ? 1 : 0;
		var $remark = $(".js-choose-activity-add-remark").val();
		
		if ($project_id == '' || $project_id == undefined) {
			gritter_alert('项目不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($batch_id == '' || $batch_id == undefined) {
			gritter_alert('项目批次不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($name == '' || $name == undefined) {
			gritter_alert('活动名称不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($start_time == '' || $start_time == undefined) {
			gritter_alert('开始时间不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($person_count == '' || $person_count == undefined) {
			gritter_alert('预定人数不能为空！');
			// btn.button('reset');
			return false;
		}
		
		var $data = {
			name: $name,
			description: $description,
			project_id: $project_id,
			batch_id: $batch_id,
			
			sort: $sort,
			person_count: $person_count,
			start_time: $start_time,
			end_time: $end_time,
			long_time: $long_time,
			type: $type,
			
			status: $status,
			remark: $remark,
		}
		
		var $url = choose_activity_url.add;
		
		ajax_post_callback($url, $data, function(data, status) {
			// btn.button('reset');
			
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('添加成功！');
				
				setTimeout(function() {
					var $url = choose_activity_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});

	//竞价活动 - 编辑
	$(".js-choose-activity-edit-save-btn").on('click', function() {		
		var btn = $(this);
		// btn.button('loading');
		
		var $id = $(".js-choose-activity-edit-id").val();
		
		var $name = $(".js-choose-activity-edit-name").val();
		var $description = $(".js-choose-activity-edit-description").val();
		var $project_id = $(".js-choose-activity-edit-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-activity-edit-batch-id").find("option:selected").val();
		
		var $sort = $(".js-choose-activity-edit-sort").val();
		var $person_count = $(".js-choose-activity-edit-person-count").val();
		
		var $start_time = $(".js-choose-activity-edit-start-time").val();
		var $end_time = $(".js-choose-activity-edit-end-time").val();
		var $long_time = $(".js-choose-activity-edit-long-time").val();
		var $type = $(".js-choose-activity-edit-type:checked").val();

		var $status = $(".js-choose-activity-edit-status").prop('checked') ? 1 : 0;
		var $remark = $(".js-choose-activity-edit-remark").val();
		
		if ($id == '' || $id == undefined) {
			gritter_alert('活动ID不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($project_id == '' || $project_id == undefined) {
			gritter_alert('项目不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($batch_id == '' || $batch_id == undefined) {
			gritter_alert('项目批次不能为空！');
			btn.button('reset');
			return false;
		}
		if ($name == '' || $name == undefined) {
			gritter_alert('活动名称不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($start_time == '' || $start_time == undefined) {
			gritter_alert('开始时间不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($person_count == '' || $person_count == undefined) {
			gritter_alert('预定人数不能为空！');
			// btn.button('reset');
			return false;
		}
		
		var $data = {
			id: $id,
			
			name: $name,
			description: $description,
			project_id: $project_id,
			batch_id: $batch_id,
			
			sort: $sort,
			person_count: $person_count,
			start_time: $start_time,
			end_time: $end_time,
			long_time: $long_time,
			type: $type,
			
			status: $status,
			remark: $remark,
		}
		
		var $url = choose_activity_url.edit;
		
		ajax_post_callback($url, $data, function(data, status) {
			// btn.button('reset');
			
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('编辑成功！');
				
				setTimeout(function() {
					var $url = choose_activity_url.index + '?project_id=' + $project_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});

	//竞价活动 - 删除
	$(".js-choose-activity-delete-btn").on('click', function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_activity_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});

	//竞价活动 - 批量删除
	$(".js-choose-activity-delete-all-btn").on('click', function() {
		var $ids = [];
		var $item_list = $(".choose-activity-item");
		
		for (var $i = 0; $i < $item_list.length; $i ++) {
			var $id = $($item_list[$i]).find(".choose-activity-item-id:checked").attr("data-id");
			if ($id != undefined) {
				$ids.push($id);
			}
		}
		var $ids_length = $ids.length;
		
		if ($ids.length <= 0) {
			gritter_alert('请选择要删除的信息！');
			return false;
		}
	
		var callback = function() {
			var $url = choose_activity_url.delete_all;
			
			var $data = {
				ids: $ids,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					gritter_alert(data['info']);
					return false;
				} else {
					gritter_alert_success('批量删除成功！');
					
					setTimeout(function() {
						window.location.href = choose_activity_url.index;
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认批量删除这'+$ids_length+'条记录吗，删除后将不能恢复？', callback);
	});
	
	/**===================== 快速开启活动 =======================**/
	
	//快速开启活动 - 项目切换
	$(".js-choose-fast-activity-project-id").on('change', function() {
		var $project_id = $(".js-choose-fast-activity-project-id").find("option:selected").val();

		window.location.href = choose_fast_activity_url.index 
			+ '?project_id=' + $project_id;
		
		return false;
	});	
	
	//快速开启活动 - 项目批次切换
	$(".js-choose-fast-activity-batch-id").on('change', function() {
		var $project_id = $(".js-choose-fast-activity-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-fast-activity-batch-id").find("option:selected").val();

		window.location.href = choose_fast_activity_url.index 
			+ '?project_id=' + $project_id
			+ '&batch_id=' + $batch_id;
		
		return false;
	});	

	//竞价活动 - 添加
	$(".js-choose-fast-activity-save-btn").on('click', function() {		
		var btn = $(this);
		// btn.button('loading');
		
		var $project_id = $(".js-choose-fast-activity-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-fast-activity-batch-id").find("option:selected").val();	
		var $person_count = $(".js-choose-fast-activity-person-count").val();
		
		var $long_time = $(".js-choose-fast-activity-long-time").val();
		var $type = $(".js-choose-fast-activity-type:checked").val();
		var $start_time = $(".js-choose-activity-add-start-time").val();
		if ($project_id == '' || $project_id == undefined) {
			gritter_alert('项目不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($batch_id == '' || $batch_id == undefined) {
			gritter_alert('项目批次不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($person_count == '' || $person_count == undefined) {
			gritter_alert('预定人数不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($long_time == '' || $long_time == undefined) {
			gritter_alert('时长不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($start_time == '' || $start_time  == undefined) {
			gritter_alert('开始时间不能为空！');
			// btn.button('reset');
			return false;
		}
		
		setTimeout(function() {
			// btn.button('reset');
		}, 1500);
		
		var $data = {
			project_id: $project_id,
			batch_id: $batch_id,			
			person_count: $person_count,
			long_time: $long_time,
			type: $type,
			start_time:$start_time,
		}
		
		var $url = choose_fast_activity_url.add;
		
		ajax_post_callback($url, $data, function(data, status) {
			// btn.button('reset');
			
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('添加成功！');
				
				setTimeout(function() {
					var $url = choose_fast_activity_url.index 
						+ '?project_id=' + $project_id
						+ '&batch_id=' + $batch_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});
	
	/**===================== 用户竞价记录 =======================**/
	
	//用户竞价记录 - 项目切换
	$(".js-choose-log-project-id").on('change', function() {
		var $project_id = $(".js-choose-log-project-id").find("option:selected").val();

		window.location.href = choose_log_url.index 
			+ '?project_id=' + $project_id;
		
		return false;
	});	
	
	//用户竞价记录 - 项目批次切换
	$(".js-choose-log-batch-id").on('change', function() {
		var $project_id = $(".js-choose-log-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-log-batch-id").find("option:selected").val();

		window.location.href = choose_log_url.index 
			+ '?project_id=' + $project_id
			+ '&batch_id=' + $batch_id;
		
		return false;
	});	

	//用户竞价记录 - 删除
	$(".js-choose-log-delete-btn").on('click', function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_log_url.delete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('删除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
	});

	//用户竞价记录 - 移除
	$(".js-choose-log-redelete-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_log_url.redelete;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('移除成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认移除吗，移除不会删除原文件？', callBack);
	});

	//用户竞价记录 - 恢复
	$(".js-choose-log-resave-btn").click(function() {
		var $id = $(this).attr("data-id");
		
		var callBack = function() {
			var $url = choose_log_url.resave;
			
			var $data = {
				id: $id,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				} else {
					layer_alert('恢复成功！');
					
					setTimeout(function() {
						window.location.reload();
					}, 200);
				}			
			});
		}
		
		layer_confirm('确认恢复该记录吗？', callBack);
	});

	//竞价活动 - 批量删除
	$(".js-choose-log-delete-all-btn").on('click', function() {
		var $ids = [];
		var $item_list = $(".choose-log-item");
		
		for (var $i = 0; $i < $item_list.length; $i ++) {
			var $id = $($item_list[$i]).find(".choose-log-item-id:checked").attr("data-id");
			if ($id != undefined) {
				$ids.push($id);
			}
		}
		var $ids_length = $ids.length;
		
		if ($ids.length <= 0) {
			gritter_alert('请选择要删除的信息！');
			return false;
		}
	
		var callback = function() {
			var $url = choose_log_url.delete_all;
			
			var $data = {
				ids: $ids,
			}
			
			ajax_post_callback($url, $data, function(data, status) {
				if (data['status'] != 1) {
					gritter_alert(data['info']);
					return false;
				} else {
					gritter_alert_success('批量删除成功！');
					
					setTimeout(function() {
						window.location.href = choose_log_url.index;
					}, 500);
				}			
			});
		}
		
		layer_confirm('确认批量删除这'+$ids_length+'条记录吗，删除后将不能恢复？', callback);
	});
	
	
	/**===================== 快速开启秒购 =======================**/
	//快速开启活动 - 项目切换
	$(".js-SpeedBuyfast-project-id").on('change', function() {
		var $project_id = $(".js-SpeedBuyfast-project-id").find("option:selected").val();

		window.location.href = SpeedBuy_fast_url.index 
			+ '?project_id=' + $project_id;
		
		return false;
	});	
	
	//快速开启活动 - 项目批次切换
	$(".js-SpeedBuyfast-batch-id").on('change', function() {
		var $project_id = $(".js-SpeedBuyfast-project-id").find("option:selected").val();
		var $batch_id = $(".js-SpeedBuyfast-batch-id").find("option:selected").val();

		window.location.href = SpeedBuy_fast_url.index 
			+ '?project_id=' + $project_id
			+ '&batch_id=' + $batch_id;
		
		return false;
	});	

	//竞价活动 - 添加
	$(".js-choose-fast-activity-save-btn").on('click', function() {		
		var btn = $(this);
		// btn.button('loading');
		
		var $project_id = $(".js-choose-fast-activity-project-id").find("option:selected").val();
		var $batch_id = $(".js-choose-fast-activity-batch-id").find("option:selected").val();	
		var $person_count = $(".js-choose-fast-activity-person-count").val();
		
		var $long_time = $(".js-choose-fast-activity-long-time").val();
		var $type = $(".js-choose-fast-activity-type:checked").val();
		var $start_time = $(".js-choose-activity-add-start-time").val();
		if ($project_id == '' || $project_id == undefined) {
			gritter_alert('项目不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($batch_id == '' || $batch_id == undefined) {
			gritter_alert('项目批次不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($person_count == '' || $person_count == undefined) {
			gritter_alert('预定人数不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($long_time == '' || $long_time == undefined) {
			gritter_alert('时长不能为空！');
			// btn.button('reset');
			return false;
		}
		if ($start_time == '' || $start_time  == undefined) {
			gritter_alert('开始时间不能为空！');
			// btn.button('reset');
			return false;
		}
		
		setTimeout(function() {
			// btn.button('reset');
		}, 1500);
		
		var $data = {
			project_id: $project_id,
			batch_id: $batch_id,			
			person_count: $person_count,
			long_time: $long_time,
			type: $type,
			start_time:$start_time,
		};
		
		alert($start_time);
		var $url = choose_fast_activity_url.add;
		
		ajax_post_callback($url, $data, function(data, status) {
			// btn.button('reset');
			
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('添加成功！');
				
				setTimeout(function() {
					var $url = choose_fast_activity_url.index 
						+ '?project_id=' + $project_id
						+ '&batch_id=' + $batch_id;
					window.location.href = $url;
				}, 500);
			}			
		});
		
		return false;
	});


    /**===================== 微信认购 =======================**/

    $(".js-choose-order_house-project-id").on('change', function() {
        $("#form-p").submit();
        // window.location.href = order_house.index + '?project_id=' + $project_id;
        // return false;
    });
    //编辑提交微信认购设置数据
    $("#wx-edit-from").submit(function () {
        // alert(1);
        // var project_id = $(".js-choose-order_house-add-project-id").find("option:selected").val();
        //
        // var batch_id = $(".js-choose-order_house-add-batch-id").find("option:selected").val();
        //
        // var name = $(".js-choose-order_house-add-name").val();
        // var desc = $(".js-choose-order_house-add-description").val();
        //
        // var start_time = $(".js-choose-order_house-add-start-time").val();
        // var end_time = $(".js-choose-order_house-add-end-time").val();
        // var maxcount = $(".js-choose-order_house-add-maxcount").val();
        // var states = $(".js-choose-order_house-add-states").prop('checked') ? 1 : 0;
        // var mark = $(".js-choose-order_house-add-remark").val();
        //
        // if (project_id === '' || project_id === undefined) {
        //     gritter_alert('项目不能为空！');
        //     // btn.button('reset');
        //     return false;
        // }
        // if (batch_id === '' || batch_id === undefined) {
        //     gritter_alert('项目批次不能为空！');
        //     // btn.button('reset');
        //     return false;
        // }
        // if (name === '' || name === undefined) {
        //     gritter_alert('活动名称不能为空！');
        //     // btn.button('reset');
        //     return false;
        // }
        // if (start_time === '' || start_time === undefined) {
        //     gritter_alert('开始时间不能为空！');
        //     // btn.button('reset');
        //     return false;
        // }
        // if (end_time === '' || end_time === undefined) {
        //     gritter_alert('结束时间不能为空！');
        //     // btn.button('reset');
        //     return false;
        // }
        //
        // var ks = Date.parse(new Date(start_time));
        // ks = ks / 1000;
        // var js = Date.parse(new Date(end_time));
        // js = js / 1000;
        // if(js<ks){
        //     gritter_alert('结束时间不能小于开始时间！');
        //     // btn.button('reset');
        //     return false;
        // }
        // // gritter_alert('成功！');
        // // return false;
        // var data = {
        //     name: name,
        //     desc: desc,
        //     project_id: project_id,
        //     batch_id: batch_id,
        //
        //     start_time: start_time,
        //     end_time: end_time,
			// 			maxcount: maxcount,
        //     states: states,
        //     mark: mark
        // };
        //
         var start_time = $(".js-choose-order_house-edit-start-time").val();
        var end_time = $(".js-choose-order_house-edit-end-time").val();
           var ks = Date.parse(new Date(start_time));
            ks = ks / 1000;
           var js = Date.parse(new Date(end_time));
           js = js / 1000;
           // console.log(ks);
           // console.log(js);
           if(js<ks){
           gritter_alert('结束时间不能小于开始时间！');
           // btn.button('reset');
            return false;
           }
        if(js===ks){
            gritter_alert('结束时间不能等于开始时间！');
            // btn.button('reset');
            return false;
        }
        var url = order_house.edit;
        var data=new FormData($("#wx-edit-from")[0]);
        $.ajax({
            type:"post",
            url:url,
            data:data,
            dataType:"json",
            contentType: false, // 注意这里应设为false
            processData: false,
            success:function (data) {
                // console.log(data);
                // return false;
                if (data.status != 1) {
                    gritter_alert(data.info);
                    return false;
                } else {
                    gritter_alert_success(data.info);
                    setTimeout(function() {
                        window.location.href = order_house.index;
                    }, 500);
                }
            }
        });
        return false;

    });

    //添加开盘
    $("#wx_add_form").on('submit', function() {
        var batch_id = $(".js-choose-order_house-add-batch-id").find("option:selected").val();
        var project_id = $(".js-choose-order_house-add-project-id").find("option:selected").val();
        if (project_id === '' || project_id === undefined) {
            gritter_alert('项目不能为空！');
            // btn.button('reset');
            return false;
        }
        if (batch_id === '' || batch_id === undefined) {
            gritter_alert('项目批次不能为空！');
            // btn.button('reset');
            return false;
        }
        var start_time = $(".js-choose-order_house-add-start-time").val();
        var end_time = $(".js-choose-order_house-add-end-time").val();
           var ks = Date.parse(new Date(start_time));
            ks = ks / 1000;
           var js = Date.parse(new Date(end_time));
           js = js / 1000;
           if(js<ks){
           gritter_alert('结束时间不能小于开始时间！');
           // btn.button('reset');
            return false;
           }
        if(js===ks){
            gritter_alert('结束时间不能等于开始时间！');
            // btn.button('reset');
            return false;
        }
        // return false;
        var url = order_house.add;
        var data=new FormData($("#wx_add_form")[0]);
        $.ajax({
            type:"post",
            url:url,
            data:data,
            dataType:"json",
            contentType: false, // 注意这里应设为false
            processData: false,
            success:function (data) {
                console.log(data);
                // return false;
                if (data.status != 1) {
                    gritter_alert(data.info);
                    return false;
                } else {
                    gritter_alert_success(data.info);
                    setTimeout(function() {
                        window.location.href = order_house.index;
                    }, 500);
                }
            }
        });
        return false;
    //     var btn = $(this);
    //     // btn.button('loading');
    //
    //     var id = $(".js-choose-order_house-edit-id").val();
    //
    //     var project_id = $(".js-choose-order_house-edit-project-id").find("option:selected").val();
    //
    //     var batch_id = $(".js-choose-order_house-edit-batch-id").find("option:selected").val();
    //
    //     var name = $(".js-choose-order_house-edit-name").val();
    //     var desc = $(".js-choose-order_house-edit-description").val();
    //
    //     var start_time = $(".js-choose-order_house-edit-start-time").val();
    //     var end_time = $(".js-choose-order_house-edit-end-time").val();
 	// 			var maxcount = $(".js-choose-order_house-edit-maxcount").val();
    //     var states = $(".js-choose-order_house-edit-states").prop('checked') ? 1 : 0;
    //     var mark = $(".js-choose-order_house-edit-remark").val();
    //
    //     if (project_id === '' || project_id === undefined) {
    //         gritter_alert('项目不能为空！');
    //         // btn.button('reset');
    //         return false;
    //     }
    //     if (batch_id === '' || batch_id === undefined) {
    //         gritter_alert('项目批次不能为空！');
    //         // btn.button('reset');
    //         return false;
    //     }
    //     if (name === '' || name === undefined) {
    //         gritter_alert('活动名称不能为空！');
    //         // btn.button('reset');
    //         return false;
    //     }
    //     if (start_time === '' || start_time === undefined) {
    //         gritter_alert('开始时间不能为空！');
    //         // btn.button('reset');
    //         return false;
    //     }
    //     if (end_time === '' || end_time === undefined) {
    //         gritter_alert('结束时间不能为空！');
    //         // btn.button('reset');
    //         return false;
    //     }
    //     var ks = Date.parse(new Date(start_time));
    //     ks = ks / 1000;
    //     var js = Date.parse(new Date(end_time));
    //     js = js / 1000;
    //     if(js<ks){
    //         gritter_alert('结束时间不能小于开始时间！');
    //         // btn.button('reset');
    //         return false;
    //     }
    //     var data = {
    //     	id : id,
    //
    //         name: name,
    //         desc: desc,
    //         project_id: project_id,
    //         batch_id: batch_id,
    //
    //         start_time: start_time,
    //         end_time: end_time,
		// 				maxcount: maxcount,
    //         states: states,
    //         mark: mark
    //     };
    //
    //     var url = order_house.edit;
    //
    //     ajax_post_callback(url, data, function(data, status) {
    //         //btn.button('reset');
    //
    //         if (data['status'] != 1) {
    //             gritter_alert(data['info']);
    //             return false;
    //         } else {
    //             gritter_alert_success('编辑成功！');
    //
    //             setTimeout(function() {
    //                 var url = order_house.index + '?project_id=' + project_id;
    //                 window.location.href = url;
    //             }, 500);
    //         }
    //     });
    //
    //     return false;
    });

    //微信认购 - 删除
    $(".js-choose-order_house-delete-btn").on('click', function() {
    	var $ids = [];
        $ids.push($(this).attr("data-id"));

        var callBack = function() {
            var $url = order_house.delete;

            var $data = {
                ids: $ids,
            };

            ajax_post_callback($url, $data, function(data, status) {
                if (data['status'] != 1) {
                    layer_alert(data['info']);
                    return false;
                } else {
                    // layer_alert('删除成功！');

                    setTimeout(function() {
                        window.location.reload();
                    }, 200);
                }
            });
        };

        layer_confirm('确认删除吗，删除后将不能恢复？', callBack);
    });

    //微信认购 - 批量
    $(".js-choose-order_house-delete-all-btn").on('click', function() {
        var $ids = [];
        var $item_list = $(".choose-activity-item");

        for (var $i = 0; $i < $item_list.length; $i ++) {
            var $id = $($item_list[$i]).find(".choose-activity-item-id:checked").attr("data-id");
            if ($id != undefined) {
                $ids.push($id);
            }
        }
        var $ids_length = $ids.length;

        if ($ids.length <= 0) {
            gritter_alert('请选择要删除的信息！');
            return false;
        }

        var callback = function() {
            var $url = order_house.delete;

            var $data = {
                ids: $ids,
            };

            ajax_post_callback($url, $data, function(data, status) {
                if (data['status'] != 1) {
                    gritter_alert(data['info']);
                    return false;
                } else {
                    gritter_alert_success('批量删除成功！');

                    setTimeout(function() {
                        window.location.href = order_house.index;
                    }, 500);
                }
            });
        };

        layer_confirm('确认批量删除这'+$ids_length+'条记录吗，删除后将不能恢复？', callback);
    });
    
    
        //房间信息 - 编辑
	$(".js-room-edit-save-btn").on('click', function() {
		var btn = $(this);
		// btn.button('loading');

		var $id = $(".js-room-edit-id").val();
		var $total = $("#total").val();
		var $area = $("#area").val();
        var $price = $("#price").val();
        var $tnarea = $("#tnarea").val();
        var $tnprice = $("#tnprice").val();
        var discount =$("#form-field-discount").val();
		var $data = {
                    id: $id,
                    total: $total,
                    area: $area,
                    price: $price,
                    tnarea: $tnarea,
                    tnprice: $tnprice,
                    discount: discount,
		};
		var $url = Jcsj_room_url.saveroom;
		ajax_post_callback($url, $data, function(data, status) {
		    // console.log(data);
			// btn.button('reset');
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('更改成功！');
                setTimeout(function() {
                    // window.history.go(-1);location.reload();
                    self.location=document.referrer;
                }, 1000);

			}			
		});
		return false;
	});
        
        //系统用户-添加-修改
	$(".js-user-add-save-btn").on('click', function() {		
		var btn = $(this);
		// btn.button('loading');
                var $userid=$(".js-user-id").val();
                var $company_id = $(".js-user-add-company-id").find("option:selected").val();
		var $name = $(".js-user-add-name").val();
                var $code = $(".js-user-add-code").val();
                var $mobile= $(".js-user-add-phone").val();
		var $pwd = $(".js-user-add-password").val();
		var $type = $(".js-user-add-type:checked").val();
		var $status = $(".js-user-add-status").prop('checked') ? 0 : 1;
		if ($company_id == '' || $company_id == undefined) {
			gritter_alert('请先选择公司！');
			// btn.button('reset');
                        $(".js-user-add-company-id").focus();
			return false;
		}
		if ($name == '' || $name == undefined) {
			gritter_alert('用户名称不能为空！');
			// btn.button('reset');
                        $(".js-user-add-name").focus();
			return false;
		}
		if ($code == '' || $code == undefined) {
			gritter_alert('用户代码不能为空！');
			// btn.button('reset');
                        $(".js-user-add-code").focus();
			return false;
		}
                if (!validate_mobile($mobile)) {
			//gritter_alert('用户手机填写错误！');
			//btn.button('reset');
                        //$(".js-user-add-phone").focus();
			//return false;
		}
		var $data = {
                        id: $userid,        
                        company_id: $company_id,	
                        name: $name,
			code: $code,
			mobile: $mobile,
			pwd: $pwd,
			type: $type,
			status: $status,
		}
		var $url = user_url.saveuser;
                
		ajax_post_callback($url, $data, function(data, status) {
			// btn.button('reset');
			
			if (data['status'] != 1) {
				gritter_alert(data['info']);
				return false;
			} else {
				gritter_alert_success('添加成功！');
				
				setTimeout(function() {
					window.location.href = user_url.index;
				}, 500);
			}			
		});

		return false;
	});
});
