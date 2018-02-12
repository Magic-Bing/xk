/** 销控JS ***/
var divshow = false;
$(window).load(function () {
    var $width = $(".marketing-control-select-project-id").width();
    $("#ul-select-bld").css("width", $width);
});
(function ($) {
    $.extend({
        /**
         * 数字千分位格式化
         * @public
         * @param mixed mVal 数值
         * @param int iAccuracy 小数位精度(默认为2)
         * @return string
         */
        formatMoney: function (mVal, iAccuracy) {
            var fTmp = 0.00;//临时变量
            var iFra = 0;//小数部分
            var iInt = 0;//整数部分
            var aBuf = new Array(); //输出缓存
            var bPositive = true; //保存正负值标记(true:正数)
            /**
             * 输出定长字符串，不够补0
             * <li>闭包函数</li>
             * @param int iVal 值
             * @param int iLen 输出的长度
             */
            function funZero(iVal, iLen) {
                var sTmp = iVal.toString();
                var sBuf = new Array();
                for (var i = 0, iLoop = iLen - sTmp.length; i < iLoop; i++)
                    sBuf.push('0');
                sBuf.push(sTmp);
                return sBuf.join('');
            };

            if (typeof(iAccuracy) === 'undefined')
                iAccuracy = 2;
            bPositive = (mVal >= 0);//取出正负号
            fTmp = (isNaN(fTmp = parseFloat(mVal))) ? 0 : Math.abs(fTmp);//强制转换为绝对值数浮点
            //所有内容用正数规则处理
            iInt = parseInt(fTmp); //分离整数部分
            iFra = parseInt((fTmp - iInt) * Math.pow(10, iAccuracy) + 0.5); //分离小数部分(四舍五入)

            do {
                aBuf.unshift(funZero(iInt % 1000, 3));
            } while ((iInt = parseInt(iInt / 1000)));
            aBuf[0] = parseInt(aBuf[0]).toString();//最高段区去掉前导0
            return ((bPositive) ? '' : '-') + aBuf.join(',') + '.' + ((0 === iFra) ? '00' : funZero(iFra, iAccuracy));
        },
        /**
         * 将千分位格式的数字字符串转换为浮点数
         * @public
         * @param string sVal 数值字符串
         * @return float
         */
        unformatMoney: function (sVal) {
            var fTmp = parseFloat(sVal.replace(/,/g, ''));
            return (isNaN(fTmp) ? 0 : fTmp);
        },
    });
})(jQuery);
//通用
$(function () {

    "use strict";
    //点击非弹出框区域关闭弹出框
    // $(document).click(function(){
    //        if($('#div-qzxfdhk').is(":visible")){
    //            $("#div_xfinfo").show();
    //            $(".marketing-control-content-room-info-option").css("height","106px");
    //            $(".marketing-control-content-room-confirm").show();
    //        }
    //        $('#div-qzxfdhk').hide();
    //    });
    $('#div-qzxfdhk').click(function (event) {
        event.stopPropagation();
    });
    $(document).click(function () {
        $('#ul-select-bld').hide();
    });
    $('#ul-select-bld').click(function (event) {
        event.stopPropagation();
    });
    $('#div-select-bld1').click(function (event) {
        event.stopPropagation();
    });

    //设置高度
    /*resize_layout(".marketing-control-content-rooms-list-wrapper, .marketing-control-content-room-info-box", 55);
     if ($(".marketing-control-content-rooms-list-wrapper").outerHeight() < 650) {
     $("#div_roominfo").hide();
     } else {
     $("#div_roominfo").show();
     }
     $(window).resize(function() {
     resize_layout(".marketing-control-content-rooms-list-wrapper, .marketing-control-content-room-info-box", 55);

     if ($(".marketing-control-content-rooms-list-wrapper").outerHeight() < 650) {
     $("#div_roominfo").hide();
     } else {
     $("#div_roominfo").show();
     }*/
    // });

    //滚动条
    $('.marketing-control-content-rooms-list-wrapper').perfectScrollbar();

    //项目选择
    $(".marketing-control-select-project-id").change(function () {
        var $project_id = $(".marketing-control-select-project-id").find("option:selected").val();
        var $url = room_url.room_index + '?info=p' + $project_id;

        location.href = $url;
    });

    //选择楼栋1
    $(".select-build-list-li-select").click(function () {
        var $build_id = $(this).attr("data-build-id");
         var $build = $("#span_build_id_" + $build_id);

         if ($build.hasClass('span-build-list-name-selected')) {
         $build.removeClass("span-build-list-name-selected");
         $build.addClass("span-build-list-name");
         $(".marketing-control-content-rooms-list-" + $build_id).hide();
         } else {
         $build.removeClass("span-build-list-name");
         $build.addClass("span-build-list-name-selected");
         $(".marketing-control-content-rooms-list-" + $build_id).show();
         }

        // var blist = $("#build_q").find(".bspan");
        // var lilist = $("#build_q").find("li");
        // blist.removeClass("span-build-list-name-selected").addClass("span-build-list-name");
        // $(this).find(".bspan").addClass("span-build-list-name-selected").removeClass("span-build-list-name");
        // if ($(this).attr("id") === "selectall") {
        //     for (var i = 0; i < lilist.length; i++) {
        //         var $build_id = lilist.eq(i).attr("data-build-id");
        //         $(".marketing-control-content-rooms-list-" + $build_id).show();
        //     }
        // }
        // else {
        //     for (var i = 0; i < lilist.length; i++) {
        //         var $build_id = lilist.eq(i).attr("data-build-id");
        //         if ($build_id === $(this).attr("data-build-id")) {
        //             $(".marketing-control-content-rooms-list-" + $build_id).show().css({"transform": "translate3d(0px, 0px, 0px)"});
        //         } else {
        //             $(".marketing-control-content-rooms-list-" + $build_id).hide();
        //         }
        //     }
        // }//此代码独栋显示用

        return false;
    });
    //选择楼栋2
    $(".marketing-control-select-build-list-input-select").change(function () {
        var $build_id = $(this).attr("data-build-id");
        var $build = $(".marketing-control-select-build-list-li-" + $build_id);
        var $input = $build.find(".marketing-control-select-build-list-input-select");

        if ($input.is(':checked')) {
            $(".marketing-control-content-rooms-list-" + $build_id).show();
        } else {
            $(".marketing-control-content-rooms-list-" + $build_id).hide();
        }
        return false;
    });
    //显示楼栋
    $("#div-select-bld1").click(function () {
        var $list = $("#ul-select-bld");
        $list.is(":hidden") ? $list.slideDown("fast") : $list.slideUp("fast");
    });

    //按房间编号搜索搜索房间
    $("#in1").focus();

    $("#in1").bind('input propertychange', function () {
        var $input_str = $("#in1").val();
        if ($input_str == '') {
            $(".marketing-control-search-room-list").html("");
            return false;
        }
        var leftone = $input_str.substr(0, 1);
        var k = 2;
        if (leftone < 4) k = 4; else k = 3;
        if ($input_str.length < k) {
            $(".marketing-control-search-room-list").html("");
            return false;
        }

        var $rooms = $(".marketing-control-content-rooms-list-wrapper").find(".marketing-control-content-rooms-box-room-num");

        var $html = [
            '<li class="marketing-control-search-room-list-li js-marketing-control-content-rooms-box-room-num marketing-control-content-rooms-box-room-{ROOM_ID}" data-room-id="{ROOM_ID}" data-room-no="{ROOM_NO}" roominfo="{ROOM_INFO}">',
            '<label>',
            '{ROOM_NAME}',
            '</label>',
            '</li>',
        ].join("");

        var $room_li = '';
        var $kk = 0;
        if ($rooms.length > 0) {
            for (var $i = 0; $i < $rooms.length; $i++) {
                if ($rooms.eq($i).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().is(":hidden")) {
                    continue;
                }
                var $name1 = $rooms.eq($i).attr("roominfo");
                var $id1 = $rooms.eq($i).attr("data-room-id");
                var $no = $rooms.eq($i).attr("data-room-id");
                var $room = $rooms.eq($i).attr("room");
                //判断查询内容是否存在(统一转化为小写)
                if ($name1 != undefined) {
                    if ($name1.toLocaleLowerCase().indexOf($input_str.toLocaleLowerCase()) >= 0) {
                        if (leftone > 3) {
                            if ($room.length < 4) {
                                $room_li += $html
                                    .replace(/{ROOM_ID}/i, $id1)
                                    .replace(/{ROOM_ID}/i, $id1)
                                    .replace(/{ROOM_NAME}/i, $name1)
                                    .replace(/{ROOM_NO}/i, $no)
                                    .replace(/{ROOM_INFO}/i, $name1);
                                $kk = $kk + 1;
                            }
                        }
                        else {
                            if ($room.length >= 4) {
                                $room_li += $html
                                    .replace(/{ROOM_ID}/i, $id1)
                                    .replace(/{ROOM_ID}/i, $id1)
                                    .replace(/{ROOM_NAME}/i, $name1)
                                    .replace(/{ROOM_NO}/i, $no)
                                    .replace(/{ROOM_INFO}/i, $name1);
                                $kk = $kk + 1;
                            }
                        }

                    }
                }
            }
            if ($room_li == "") {
                $(".marketing-control-search-room-list")
                    .html('<li style="width:100%;color:red">无此房间</li>')
                    .show();
                //layer_alert_two('无此房间！');
            } else {
                $(".marketing-control-search-room-list")
                    .html($room_li)
                    .show();
                if ($kk == 1) {
                    $(".marketing-control-search-room-list").find("li").eq(0).trigger("click");
                    // var $room_id = $(".marketing-control-search-room-list").find("li").eq(0).attr('data-room-id');
                    // var $roominfo =  $(".marketing-control-search-room-list").find("li").eq(0).attr('roominfo');
                    // showfqz($roominfo,$room_id);
                    $(".marketing-control-search-room-list").html("");
                }
            }
        }
        // if (key == 37) alert("按了←键！");
        // if (key == 38) alert("按了↑键！");
        // if (key == 39) alert("按了→键！");
        // if (key == 40) alert("按了↓键！");
        var $li = $(".marketing-control-search-room-list li");
        if ($li.length > 0) {
            var a = -1;
            $(document).on("keydown", "#in1", function () {
                if (event.keyCode == 38) {
                    if (a != 0 && a != -1) {
                        a--;
                        $(".marketing-control-search-room-list li").eq(a).css({
                            'fontWeight': "bold",
                            'backgroundColor': 'pink'
                        }).attr("on", "1");
                        $(".marketing-control-search-room-list li").not($(".marketing-control-search-room-list li").eq(a)).css({
                            'fontWeight': "normal",
                            'backgroundColor': '#FFF'
                        }).attr("on", "0");
                        ;
                    }
                } else if (event.keyCode == 40) {
                    if (a < ($li.length - 1)) {
                        a++;
                    }
                    $(".marketing-control-search-room-list li").eq(a).css({
                        'fontWeight': "bold",
                        'backgroundColor': 'pink'
                    }).attr("on", "1");
                    ;
                    $(".marketing-control-search-room-list li").not($(".marketing-control-search-room-list li").eq(a)).css({
                        'fontWeight': "normal",
                        'backgroundColor': '#FFF'
                    }).attr("on", "0");
                }
                if (event.keyCode == 13 && a != -1) {
                    $(".marketing-control-search-room-list li[on='1']").trigger("click");
                    // var $room_id =$(".marketing-control-search-room-list li").eq(a).attr('data-room-id');
                    // var $roominfo = $(".marketing-control-search-room-list li").eq(a).attr('roominfo');
                    // showfqz($roominfo,$room_id);
                    $(".marketing-control-search-room-list").html("");
                }
            })
        }
        return false;
    });
    //按用户名称搜索
    $("#in2").bind('input propertychange', function () {
        var $input_str = $("#in2").val();

        if ($input_str == '') {
            $(".marketing-control-search-room-list").html("");
            return false;
        }
        if ($input_str.length < 2) {
            $(".marketing-control-search-room-list").html("");
            return false;
        }
        // var p = /[0-9a-z.]/i;
        // if(p.test($input_str)){
        // layer_msg("请不要输入字母或者数字和符号");
        //    $("#in2").val($input_str.replace(p,""));
        // 	return false;
        // }
        $.ajax({
            type: "post",
            url: room_url.search_room_name,
            data: {custname: $input_str},
            // dataType:"json",
            success: function (data) {
                $(".marketing-control-search-room-list").html("");
                if (data == "false1") {
                    $(".marketing-control-search-room-list")
                        .html('<li style="width:100%;color:red">无此房间</li>')
                        .show();
                } else {
                    data = JSON.parse(data);
                    if (data.length == 1) {
                        $(".marketing-control-search-room-list").append('<li class="marketing-control-search-room-list-li js-marketing-control-content-rooms-box-room-num marketing-control-content-rooms-box-room-' + data[0]['id'] + '" data-room-id="' + data[0]['id'] + '" data-room-no="' + data[0]['id'] + '" roominfo="' + data[0]['room'] + '"><label>' + data[0]['room'] + '</label></li>').show();
                        $(".marketing-control-search-room-list").find("li").eq(0).trigger("click");
                    } else {
                        for (var i = 0; i < data.length; i++) {
                            $(".marketing-control-search-room-list").append('<li class="marketing-control-search-room-list-li js-marketing-control-content-rooms-box-room-num marketing-control-content-rooms-box-room-' + data[i]['id'] + '" data-room-id="' + data[i]['id'] + '" data-room-no="' + data[i]['id'] + '" roominfo="' + data[i]['room'] + '"><label>' + data[i]['room'] + '</label></li>');
                        }
                        $(".marketing-control-search-room-list").show();
                        var a = -1;
                        $(document).on("keydown", "#in2", function () {

                            if (event.keyCode == 38) {
                                if (a != 0 && a != -1) {
                                    a--;
                                    $(".marketing-control-search-room-list li").eq(a).css({
                                        'fontWeight': "bold",
                                        'backgroundColor': 'pink'
                                    }).attr("on", "1");
                                    $(".marketing-control-search-room-list li").not($(".marketing-control-search-room-list li").eq(a)).css({
                                        'fontWeight': "normal",
                                        'backgroundColor': '#FFF'
                                    }).attr("on", "0");
                                }
                            } else if (event.keyCode == 40) {
                                if (a == (data.length - 1)) {
                                    a = (data.length - 1)
                                } else {
                                    a++;
                                }
                                // alert(a);
                                $(".marketing-control-search-room-list li").eq(a).css({
                                    'fontWeight': "bold",
                                    'backgroundColor': 'pink'
                                }).attr("on", "1");
                                $(".marketing-control-search-room-list li").not($(".marketing-control-search-room-list li").eq(a)).css({
                                    'fontWeight': "normal",
                                    'backgroundColor': '#FFF'
                                }).attr("on", "0");
                            }
                            if (event.keyCode == 13 && a != -1) {
                                // console.log(a);
                                $(".marketing-control-search-room-list li[on='1']").trigger("click");
                                // var $room_id =$(".marketing-control-search-room-list li").eq(a).attr('data-room-id');
                                // var $roominfo = $(".marketing-control-search-room-list li").eq(a).attr('roominfo');
                                // showfqz($roominfo,$room_id);
                                $(".marketing-control-search-room-list").html("");
                            }

                        })
                    }
                }
            }
        });
        return false;
    });

    //移到搜索框
    $(document).on("mouseover", ".marketing-control-search-input", function () {
        var $li = $(".marketing-control-search-room-list li");
        if ($li.length > 0) {
            $(".marketing-control-search-room-list").show();
        }
    });

    //搜索提交
    $(".marketing-control-search-btn").click(function () {
        var $li = $(".marketing-control-search-room-list li");
        if ($li.length > 0) {
            $(".marketing-control-search-room-list").show();
        }
    });


    //离开元素
    $(".marketing-control-search-room-list, .marketing-control-title").mouseleave(function () {
        // $(".marketing-control-search-room-list").html("");
        $(".marketing-control-search-room-list").hide();
    });


    //搜索客户
    $(document).on('input propertychange',".search-input-kh", function () {
        // alert();
        var $input_str = $(this).val();
        if ($input_str == '') {
            $("#cstid1").val("");
            $("#vip1").val("");
            $("#cstname1").val("");
            $("#phone1").val("");
            $("#cardno1").val("");
            return false;
        }
        /*if ($input_str.length<2) {
         return false;
         }*/
        var $stype = 0;
        if ($(this).attr("id") == "cstname1") {
            $stype = 1;
        }
        if ($(this).attr("id") == "phone1") {
            $stype = 2;
        }
        if ($(this).attr("id") == "cardno1") {
            $stype = 3;
        }
        var $project_id = $(".marketing-control-select-project-id").find("option:selected").val();
        var $room_id = $("#roominfo1").attr("data_id");
        $.ajax({
            url: room_url.search_cst,
            data: {
                info: $input_str,
                stype: $stype,
                project_id: $project_id,
                room_id: $room_id,
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data, status) {
                if (typeof(data.status) == 'undefined') {
                    layer_alert_two('请求失败，请重试！');
                    return false;
                }
                if (data.status === false) {
                    layer_alert_two(data.info);
                    return false;
                }
                //var $is_havecst=data.info[0];

                var $csts = data.info[1];
                if ($csts.length > 0) {
                    // console.log(JSON.stringify($csts));
                     if ($csts.length === 1) {
                        $("#cstid1").val($csts[0].id);
                        $("#vip1").val($csts[0].cyjno);
                        $("#cstname1").val($csts[0].customer_name);
                        $("#phone1").val($csts[0].customer_phone);
                        $("#cardno1").val($csts[0].cardno);
                     }else{
                         var str="";
                         for(var i=0;i<$csts.length;i++){
                             str+="<label style='display: block;white-space: nowrap;margin-top: 5px;overflow: hidden;text-overflow: ellipsis;text-align: left' title='"+$csts[i].customer_name+"("+$csts[i].cardno+")'><input type='radio' name='card'  value='"+i+"'>&nbsp;"+$csts[i].customer_name+"("+$csts[i].cardno+")</label>";
                         }
                         // str+="</div>";
                         layer.confirm(str, {
                             btn: ['取消', '确认'], //按钮
                             skin: 'layui-layer-qz',
                             shade: [0.5, 'black'],
                             title:'请选择客户',
                             area:'315px',
                             shadeClose:true
                         }, function (index) {
                             layer.close(index);
                         }, function () {
                             var vo=$("input[name='card']:checked").val();
                             if(vo === undefined){
                                 layer_alert_two("请选择一个身份证！",function () {
                                     $("#cardno1").trigger("input");
                                 })
                             }else{
                                vo=Number(vo);
                                 $("#cstid1").val($csts[vo].id);
                                 $("#vip1").val($csts[vo].cyjno);
                                 $("#cstname1").val($csts[vo].customer_name);
                                 $("#phone1").val($csts[vo].customer_phone);
                                 $("#cardno1").val($csts[vo].cardno);
                             }
                         });
                         // layer.open({
                         //     title:['温馨提示','color:#fff;background-color:#ff9610'],
                         //     type: 1,
                         //     area: ['250px', 'auto'], //宽高
                         //     content:str,
                         //     btn:['取消','确定'],
                         //     btn2:function () {
                         //
                         //     }
                         // });
                        // console.log($csts);
                     }
                }
                else {
                    // console.log($stype);
                    if($stype ===0){
                        $("#cstid1").val("");
                        //$("#vip1").val("");
                        $("#cstname1").val("");
                        $("#phone1").val("");
                        $("#cardno1").val("");
                    }else if($stype ===1){
                        $("#cstid1").val("");
                        $("#vip1").val("");
                        // $("#cstname1").val("");
                        $("#phone1").val("");
                        $("#cardno1").val("");
                    } else if($stype ===2){
                        $("#cstid1").val("");
                        $("#vip1").val("");
                        $("#cstname1").val("");
                        // $("#phone1").val("");
                        $("#cardno1").val("");
                    } else if($stype ===3){
                        $("#cstid1").val("");
                        $("#vip1").val("");
                        $("#cstname1").val("");
                        $("#phone1").val("");
                        // $("#cardno1").val("");
                    }
                }
            },
            error: function (data, status, e) {
                layer_alert_two('提交连接失败！');
            }
        });

        return false;

    });


    //显示更多楼栋修改后取消使用
    /*$("body").on("click","#show_ld",function () {
     // alert();
     var pd=$(this).attr("on");
     if(Number(pd)==0){
     $("#ld_div").show();
     $(this).html("︽").attr("on","1");
     }else{
     $("#ld_div").hide();
     $(this).html("︾").attr("on","0");

     }

     });*/
    //搜索客户1
    // $(".search-input-kh1").bind('input propertychange', function() {
    // 	var $input_str = $(this).val();
    // 	if ($input_str == '') {
    //                    $(".marketing-control-room-info-cstid").val("");
    //                    $(".marketing-control-room-info-vip").val("");
    //                    $(".marketing-control-room-info-cstname").val("");
    //                    $(".marketing-control-room-info-phone").val("");
    //                    $(".marketing-control-room-info-cardno").val("");
    // 		return false;
    // 	}
    // 	/*if ($input_str.length<2) {
    // 		return false;
    // 	}*/
    //            var $stype=0;
    //            var $strqz="marketing-control-room-info-";
    // 	if ($(this).hasClass($strqz+"cstname"))
    //            {
    //                $stype=1;
    //            }
    //            if ($(this).hasClass($strqz+"phone"))
    //            {
    //                $stype=2;
    //            }
    //            if ($(this).hasClass($strqz+"cardno"))
    //            {
    //                $stype=3;
    //            }
    //            var $project_id = $(".marketing-control-select-project-id").find("option:selected").val();
    //            var $room_id=$(".marketing-control-room-info-id").val();
    // 	$.ajax({
    // 		url: room_url.search_cst,
    // 		data: {
    // 			info: $input_str,
    //                            stype: $stype,
    //                            project_id: $project_id,
    //                            room_id: $room_id,
    // 		},
    // 		type: 'POST',
    // 		dataType: 'JSON',
    // 		success: function (data, status) {
    // 			if (typeof(data.status) == 'undefined') {
    // 				layer_alert_two('请求失败，请重试！');
    // 				return false;
    // 			}
    // 			if (data.status == false) {
    //                                    layer_alert_two(data.info);
    // 				return false;
    // 			}
    //                            var $is_havecst=data.info[0];
    //                            var $csts = data.info[1];
    //                            if($csts.length >0)
    //                            {
    //
    //                                if($csts.length ==1)
    //                                {
    //                                    $(".marketing-control-room-info-cstid").val($csts[0].id);
    //                                    $(".marketing-control-room-info-vip").val($csts[0].cyjno);
    //                                    $(".marketing-control-room-info-cstname").val($csts[0].customer_name);
    //                                    $(".marketing-control-room-info-phone").val($csts[0].customer_phone);
    //                                    $(".marketing-control-room-info-cardno").val($csts[0].cardno);
    //                                }
    //                                else
    //                                {
    //
    //                                }
    //                            }
    //                            else
    //                            {
    //                                $(".marketing-control-room-info-cstid").val("");
    //                                //$(".marketing-control-room-info-vip").val("");
    //                                $(".marketing-control-room-info-cstname").val("");
    //                                $(".marketing-control-room-info-phone").val("");
    //                                $(".marketing-control-room-info-cardno").val("");
    //                            }
    // 		},
    // 		error: function (data, status, e) {
    // 			layer_alert_two('提交连接失败！');
    // 		}
    // 	});
    //
    // 	return false;
    //
    // });

    //显示楼栋
    $(document).on("click", "#show_build", function () {
        var pd = $(this).attr("on");
        if (Number(pd) == 0) {
            $("#ld_div").show();
            $(this).attr("on", "1");
        } else {
            $("#ld_div").hide();
            $(this).attr("on", "0");
        }
    });
    $(document).on("click", ".show_divselect", function () {
        $(this).prev().click();
    });

    //切换搜索模式
    $(document).on("click", "#qh_ss", function () {
        var pd = $(this).attr("on");
        $(".marketing-control-search-room-list").html("");
        if (Number(pd) == 0) {
            $("#in1").hide();
            $("#in2").show();
            $(this).attr("on", "1");
        } else {
            $("#in1").show();
            $("#in2").hide();
            $(this).attr("on", "0");
        }
    });
    //选中
    $(document).on('click', '.js-marketing-control-content-rooms-box-room-num', function () {
        $("#xfcgys").hide();
        //$("#ystitle").hide();
        $("#xftitle").hide();
        var $room_id = $(this).attr('data-room-id');
        var $roominfo = $(this).attr('roominfo');

        if ($(this).prop("tagName") == 'LI') {
            $('.js-marketing-control-content-rooms-box-room-num').removeClass("marketing-control-content-rooms-box-room-click");
            $(" .marketing-control-content-rooms-box-room-" + $room_id).addClass("marketing-control-content-rooms-box-room-click");
            $(this).removeClass("marketing-control-content-rooms-box-room-click").removeClass("marketing-control-content-rooms-box-room-" + $room_id);
        } else {
            $('.js-marketing-control-content-rooms-box-room-num').removeClass("marketing-control-content-rooms-box-room-click");
            $(" .marketing-control-content-rooms-box-room-" + $room_id).addClass("marketing-control-content-rooms-box-room-click");

        }

        if ($room_id == undefined) {
            layer_alert_two('房间号不存在！');
            return false;
        }
        var $roomqz = ".marketing-control-content-rooms-box-room-";

        var $zb = $($roomqz + $room_id).offset();
        var s_top = $('.marketing-control-content-rooms-list-wrapper').scrollTop();
        $('.marketing-control-content-rooms-list-wrapper').scrollTop(0);
        var $zgd = $('.marketing-control-content-rooms-list-wrapper').outerHeight();
        // alert(  $('.marketing-control-content-rooms-list-wrapper').scrollTop());
        // alert($zgd);
        if (($zb.top + s_top) > $zgd) {
            $('.marketing-control-content-rooms-list-wrapper').scrollTop(($zb.top + s_top) - 350);
        }
        if (($zb.top + s_top) < 0) {
            $('.marketing-control-content-rooms-list-wrapper').scrollTop(0);
        }
        // alert(  $('.marketing-control-content-rooms-list-wrapper').scrollTop());
        showfqz($room_id);
        var room_str = $("#spanid_" + $room_id).attr("infolist");
        var room_arr = room_str.split("|");
        // console.log(room_str);
        // console.log(room_arr);
        if (Number(room_arr[1]) === 0) {
            $("#tb").hide();
            $(".marketing-control-room-info-" + 'zt').val("待售");
            $("#select-pay").val("");
            $("#pdz1").show();
            $("#pdz").show();
            $("#pdt").hide();
            $("#pdt1").hide();
            //$("#roominfo1").val(room_arr[7]+"单元-"+room_arr[8]+"层-"+room_arr[9]);
            $("#roominfo1").val($roominfo);
            $("#ppf input").prop("readonly", false);
            $("#ystitle").hide();
            $("#room-qt>ul>li").hide();
            if(Number(room_arr[2])!==0){
                $(".jzmj").show();
                $("#jzmj").val(room_arr[2]);
            }
            if(Number(room_arr[3])!==0){
                $(".tnmj").show();
                $("#tnmj").val(room_arr[2]);
            }
            if(Number(room_arr[4])!==0){
                $(".jz-price").show();
                $("#jz-price").val($.formatMoney(room_arr[4],2));
            }
            if(Number(room_arr[5])!==0){
                $(".tn-price").show();
                $("#tn-price").val($.formatMoney(room_arr[5],2));
            }
            if(Number(room_arr[6])!==0){
                $(".all-price").show();
                $("#all-price").val($.formatMoney(room_arr[6],2));
            }
            if(Number(room_arr[10])!==0){
                $(".ycx-price").show();
                $("#ycx-price").val($.formatMoney(room_arr[10],2));
            }
            if(Number(room_arr[11])!==0){
                $(".fq-price").show();
                $("#fq-price").val($.formatMoney(room_arr[11],2));
            }
            if(Number(room_arr[12])!==0){
                $(".aj-price").show();
                $("#aj-price").val($.formatMoney(room_arr[12],2));
            }
            if(Number(room_arr[13])!==0){
                $(".gjj-price").show();
                $("#gjj-price").val($.formatMoney(room_arr[13],2));
            }
            if(Number(room_arr[14])!==0){
                $(".yh-price").show();
                $("#yh-price").val($.formatMoney(room_arr[14],2));
            }

        } else {
            $("#tb").show();
            $(".marketing-control-room-info-" + 'zt');
            $("#pdz1").hide();
            $("#pdz").hide();
            $("#pdt").show();
            $("#pdt1").show();
            $('#cstname1').val(room_arr[7]).attr("readonly", "readonly");
            $('#xftime1').val(room_arr[8]).attr("readonly", "readonly");
            $('#vip1').val(room_arr[9]).attr("readonly", "readonly");
            $('#phone1').val(room_arr[10]).attr("readonly", "readonly");
            $('#cardno1').val(room_arr[11]).attr("readonly", "readonly");
            // $("#roominfo1").val(room_arr[12]+"单元-"+room_arr[13]+"层-"+room_arr[14]);
            $("#roominfo1").val($roominfo);
            $("#room-qt>ul>li").hide();
            if(Number(room_arr[2])!==0){
                $(".jzmj").show();
                $("#jzmj").val(room_arr[2]);
            }
            if(Number(room_arr[3])!==0){
                $(".tnmj").show();
                $("#tnmj").val(room_arr[2]);
            }
            if(Number(room_arr[4])!==0){
                $(".jz-price").show();
                $("#jz-price").val($.formatMoney(room_arr[4],2));
            }
            if(Number(room_arr[5])!==0){
                $(".tn-price").show();
                $("#tn-price").val($.formatMoney(room_arr[5],2));
            }
            if(Number(room_arr[6])!==0){
                $(".all-price").show();
                $("#all-price").val($.formatMoney(room_arr[6],2));
            }
            if(Number(room_arr[15])!==0){
                $(".ycx-price").show();
                $("#ycx-price").val($.formatMoney(room_arr[15],2));
            }
            if(Number(room_arr[16])!==0){
                $(".fq-price").show();
                $("#fq-price").val($.formatMoney(room_arr[16],2));
            }
            if(Number(room_arr[17])!==0){
                $(".aj-price").show();
                $("#aj-price").val($.formatMoney(room_arr[17],2));
            }
            if(Number(room_arr[18])!==0){
                $(".gjj-price").show();
                $("#gjj-price").val($.formatMoney(room_arr[18],2));
            }
            if(Number(room_arr[19])!==0){
                $(".yh-price").show();
                $("#yh-price").val($.formatMoney(room_arr[19],2));
            }
        }
        // $(".marketing-control-room-info-" + 'id').val($room_id);

        $(".marketing-control-room-info-" + 'hx').val(room_arr[0]);
        // $(".marketing-control-room-info-" + 'area').val(room_arr[2]);
        // $(".marketing-control-room-info-" + 'tnarea').val(room_arr[3]);
        // $(".marketing-control-room-info-" + 'price').val(room_arr[4]);
        // $(".marketing-control-room-info-" + 'tnprice').val(room_arr[5]);
        $(".marketing-control-room-info-" + 'total').val($.formatMoney(room_arr[6], 2));
        // return false;


        $(".marketing-control-search-room-list").hide();
        //异步获取
        $.ajax({
            url: room_url.get_oneroom,
            data: {
                id: $room_id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data, status) {
                // console.log(data);
                if (typeof(data.status) == 'undefined') {
                    layer_alert_two('请求失败，请重试！');
                    return false;
                }
                if (data.status == false) {
                    layer_alert_two(data.info);
                    return false;
                }
                var $room = data.info;
                // alert(JSON.stringify($room));
                var $text_pre = ".marketing-control-room-info-";
                $($text_pre + 'id').val($room_id);

                // $($text_pre + 'name').val($roominfo);
                $($text_pre + 'hx').val(($room['hxmx'] ? $room['hx'] + "(" + $room['hxmx'] + ")" : $room['hx']));
                // $($text_pre + 'area').val($room['area']);
                // $($text_pre + 'tnarea').val($room['tnarea']);
                // $($text_pre + 'price').val($room['price']);
                // $($text_pre + 'tnprice').val($room['tnprice']);
                $($text_pre + 'total').val($.formatMoney($room['total'], 2));
                if ($room['is_xf'] == 1) {
                    $("#roominfo1").val($room['buildname'] + "-" + $room['unit'] + "单元-" + $room['floor'] + "层-" + $room['room']);
                    $("#select-pay").val($room['pay']);
                    // hidefqz();
                    $("#pdz").hide();
                    $("#pdz1").hide();
                    $("#pdt1").show();
                    $("#pdt").show();
                    $("#tb").show();
                    $($text_pre + 'zt').val("已售");
                    $($text_pre + 'zt').removeClass("input_ws");
                    $($text_pre + 'zt').addClass("input_ys");
                    $($text_pre + 'is-sf').val('1');
                    $("#div_xfinfo").show();
                    $("#ystitle").show();
                    $(".marketing-control-content-room-info-option").css("height", "106px");
                    //用户权限控制
                    if (Number($.trim($("#usertype").val())) === 1) {
                        $(".marketing-control-content-room-cancel").show();
                    }else{
                        $(".marketing-control-content-room-cancel").hide();
                    }
                    $(".marketing-control-content-room-confirm").hide();
                    $(".marketing-control-content-room-confirm-btn").attr("disabled", true);

                    $('#cstname1').val($room['cstname']).attr("readonly", "readonly");
                    $('#xftime1').val($room['xftime']).attr("readonly", "readonly");
                    $('#vip1').val($room['cyjno']).attr("readonly", "readonly");
                    $('#phone1').val($room['phone']).attr("readonly", "readonly");
                    $('#cardno1').val($room['cardno']).attr("readonly", "readonly");
                    // $($text_pre + 'cstname').attr("readonly", "readonly");
                    // $($text_pre + 'cstname').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");
                    // $($text_pre + 'vip').attr("readonly", "readonly");
                    // $($text_pre + 'vip').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");
                    // $($text_pre + 'phone').attr("readonly", "readonly");
                    // $($text_pre + 'phone').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");
                    // $($text_pre + 'cardno').attr("readonly", "readonly");
                    // $($text_pre + 'cardno').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");
                    // $("#div_roominfo").css("box-shadow","0 0 10px rgba(5, 74, 83, 0.95)");
                    // $("#div_roominfo").css("border-left","2px solid red");
                    // $("#div_roominfo").css("marginLeft","-5px");
                    if (!$(".marketing-control-content-rooms-box-room-" + $room_id).hasClass("marketing-control-content-rooms-box-room-selected")) {
                        $(".marketing-control-content-rooms-box-room-" + $room_id).addClass("marketing-control-content-rooms-box-room-selected");
                        layer_alert_two('此房间已经售出，请选择其他房间！');
                    }
                    $("#ystitle").show();
                }
                else {

                    $("#roominfo1").val($room['buildname'] + "-" + $room['unit'] + "单元-" + $room['floor'] + "层-" + $room['room']);
                    $("#div_xfinfo").hide();
                    $("#pdz").show();
                    $("#pdz1").show();
                    $("#pdt1").hide();
                    $("#pdt").hide();
                    $("#tb").hide();
                    $("#ppf input").prop("readonly", false);
                    $(".marketing-control-content-room-info-option").css("height", "221px");
                    $($text_pre + 'zt').val("待售");
                    $($text_pre + 'zt').removeClass("input_ys");
                    $($text_pre + 'zt').addClass("input_ws");
                    $($text_pre + 'is-sf').val('0');
                    $(".marketing-control-content-room-confirm").show();
                    $(".marketing-control-content-room-cancel").hide();
                    $(".marketing-control-content-room-confirm-btn").attr("disabled", false);

                    $('#cstname1').val("").attr("readonly", false);
                    $('#xftime1').val("").attr("readonly", false);
                    $('#vip1').val("").attr("readonly", false);
                    $('#phone1').val("").attr("readonly", false);
                    $('#cardno1').val("").attr("readonly", false);
                    $("#ystitle").hide();
                    // $($text_pre + 'cstname').val("");
                    // $($text_pre + 'xftime').val("");
                    // $($text_pre + 'vip').val("");
                    // $($text_pre + 'phone').val("");
                    // $($text_pre + 'cardno').val("");
                    // $($text_pre + 'cstname').attr("readonly", false);
                    // $($text_pre + 'cstname').css("border-bottom", "1px solid rgb(0, 204, 204)");
                    //  $($text_pre + 'vip').attr("readonly", false);
                    // $($text_pre + 'vip').css("border-bottom",  "1px solid rgb(0, 204, 204)");
                    // $($text_pre + 'phone').attr("readonly", false);
                    // $($text_pre + 'phone').css("border-bottom",  "1px solid rgb(0, 204, 204)");
                    // $($text_pre + 'cardno').attr("readonly", false);
                    // $($text_pre + 'cardno').css("border-bottom",  "1px solid rgb(0, 204, 204)");
                    // $("#div_roominfo").css("box-shadow","0 0 0 0");
                    // $("#div_roominfo").css("border-left","2px solid #00BCD4");
                    // $("#div_roominfo").css("marginLeft","");
                    $(".marketing-control-content-rooms-box-room-" + $room_id).removeClass("marketing-control-content-rooms-box-room-selected");

                }
            },
            error: function (data, status, e) {
                layer_alert_two('提交连接失败！');
            }
        });

        //HTML查询
        /*var $room = $("#spanid_"+$room_id).attr("infolist").split("|")
         var $text_pre = ".marketing-control-room-info-";
         $($text_pre + 'id').val($room_id);
         $($text_pre + 'name').val($roominfo);

         $($text_pre + 'hx').val($room[0]);
         $($text_pre + 'area').val($room[2]);
         $($text_pre + 'tnarea').val($room[3]);
         $($text_pre + 'price').val($room[4]);
         $($text_pre + 'tnprice').val($room[5]);
         $($text_pre + 'total').val($room[6]);

         if ($room[1]==1)
         {
         hidefqz();
         $($text_pre + 'zt').val("已售");
         $($text_pre + 'zt').removeClass("input_ws");
         $($text_pre + 'zt').addClass("input_ys");

         $($text_pre + 'is-sf').val('1');
         $("#div_xfinfo").show();
         $(".marketing-control-content-room-info-option").css("height","106px");
         if ($("#usertype").val()>2)
         {
         $(".marketing-control-content-room-cancel").show();
         }
         $(".marketing-control-content-room-confirm").hide();
         $(".marketing-control-content-room-confirm-btn").attr("disabled", true);

         $($text_pre + 'cstname').val($room[7]);
         $($text_pre + 'xftime').val($room[8]);
         $($text_pre + 'vip').val($room[9]);
         $($text_pre + 'phone').val($room[10]);
         $($text_pre + 'cardno').val($room[11]);
         $($text_pre + 'cstname').attr("readonly", "readonly");
         $($text_pre + 'cstname').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");
         $($text_pre + 'vip').attr("readonly", "readonly");
         $($text_pre + 'vip').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");
         $($text_pre + 'phone').attr("readonly", "readonly");
         $($text_pre + 'phone').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");
         $($text_pre + 'cardno').attr("readonly", "readonly");
         $($text_pre + 'cardno').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");

         $("#div_roominfo").css("box-shadow","0 0 10px rgba(5, 74, 83, 0.95)");
         $("#div_roominfo").css("border-left","2px solid red");
         $("#div_roominfo").css("marginLeft","-5px");
         }
         else
         {
         showfqz($roominfo,$room_id);
         $("#div_xfinfo").hide();
         $(".marketing-control-content-room-info-option").css("height","221px");
         $($text_pre + 'zt').val("待售");
         $($text_pre + 'zt').removeClass("input_ys");
         $($text_pre + 'zt').addClass("input_ws");

         $($text_pre + 'is-sf').val('0');
         $(".marketing-control-content-room-confirm").hide();
         $(".marketing-control-content-room-cancel").hide();

         $(".marketing-control-content-room-confirm-btn").attr("disabled", false);
         $($text_pre + 'cstname').val("");
         $($text_pre + 'xftime').val("");
         $($text_pre + 'vip').val("");
         $($text_pre + 'phone').val("");
         $($text_pre + 'cardno').val("");
         $($text_pre + 'cstname').attr("readonly", false);
         $($text_pre + 'cstname').css("border-bottom", "1px solid rgb(0, 204, 204)");
         $($text_pre + 'vip').attr("readonly", false);
         $($text_pre + 'vip').css("border-bottom",  "1px solid rgb(0, 204, 204)");
         $($text_pre + 'phone').attr("readonly", false);
         $($text_pre + 'phone').css("border-bottom",  "1px solid rgb(0, 204, 204)");
         $($text_pre + 'cardno').attr("readonly", false);
         $($text_pre + 'cardno').css("border-bottom",  "1px solid rgb(0, 204, 204)");
         $("#div_roominfo").css("box-shadow","0 0 0 0");
         $("#div_roominfo").css("border-left","2px solid #00BCD4");
         $("#div_roominfo").css("marginLeft","");
         }*/
        $('.marketing-control-select-build-list').hide();
        $('.marketing-control-search-input').val("");
        $('#ul-select-bld').hide();


        return false;
    });

    //关闭弹出框
    // $("body").on("click","#close_tc",function () {
    // 	alert();
    //    hidefqz();
    // });
    //确认选房
    $(".marketing-control-content-room-confirm-btn").click(function () {
        // hidefqz();
        var $room_id = $(".marketing-control-room-info-id").val();
        var $cstname = $("#cstname1").val();
        var $cstid = $("#cstid1").val();
        var $cjyno = $("#vip1").val();
        var $room_name = $("#roominfo1").val();
        var pay = $("#select-pay").val();
        var $is_sf = $(".marketing-control-room-info-is-sf").val();
        if ($is_sf == '1') {
            layer_alert_two('该房间已经选择过，请选择其他房间！');
            return false;
        }
        var qx=$("#num_auth").text();
        var qx_two=$("#pay_auth").text();
        // console.log(typeof  qx);
        if(qx === '' || qx === undefined){
            if ($cjyno === '' || $cjyno === undefined) {
                layer_alert_two('诚意金编号不能为空！');
                return false;
            }
        }
        if(qx_two === '' || qx_two === undefined){
            if (pay === '' || pay === undefined) {
                layer_alert_two('付款方式不能为空！');
                return false;
            }
        }
        if ($room_id === '' || $room_id === undefined) {
            layer_alert_two('房间信息不存在！');
            return false;
        }

        if ($cstid === '' || Number($cstid) === 0) {
            layer_alert_two('客户信息错误！');
            return false;
        }
        $.ajax({
            url: room_url.choose_room,
            data: {
                id: $room_id,
                cstname: $cstname,
                cstid: $cstid,
                pay:pay
            },
            type: 'POST',
            dataType: 'JSON',
            success: function (data, status) {
                if (typeof(data.status) == 'undefined') {
                    layer_alert_two('请求失败，请重试！');
                    return false;
                }
                if (data.status == false) {
                    /*if (data.info=="房间已经售出，请选择其他房间！")
                     {
                     layer.confirm('此房间已经售出，请选择其他房间！', {
                     btn: ['取消', '确认'], //按钮
                     skin: 'layui-layer-molv',
                     shade: false,
                     }, function(index){
                     layer.close(index);
                     }, function(){
                     window.location.reload();
                     });
                     if (confirm("房间已经售出，重新刷新页面！"))
                     {
                     window.location.reload();
                     }
                     }
                     else
                     layer_alert_two(data.info);
                     return false;
                     */
                    layer_alert_two(data.info);
                    return false;
                }
                var $is_havexf = data.info[0];
                $("#div_xfinfo").show();
                $("#ppf input").prop("readonly", true);
                var $text_pre = ".marketing-control-room-info-";
                // $($text_pre + 'cstname').attr("readonly", "readonly");
                // $($text_pre + 'cstname').css("border-bottom", "1px solid rgba(79, 83, 83, 0.2)");

                $(".marketing-control-content-room-confirm-btn").attr("disabled", true);
                $(".marketing-control-content-room-cancel-btn").attr("disabled", false);
                //$(".marketing-control-content-room-cancel").show();
                //$(".marketing-control-content-room-confirm").hide();
                if ($is_havexf == 0) {
                    //hidefqz();
                    //layer_alert_two_one('<p style="font-weight: bold">房间：' + $room_name + '</p><p style="font-weight: bold">客户：'+$cstname+'</p>',["恭喜选房成功","background-color:red;text-align:center;color:#FFF;font-size:18px;padding:0;font-weight:bold;"]);

                    $("#xfcgys").show();
                    $("#ystitle").hide();
                    $("#xftitle").show();

                    $("#pdz").hide();
                    $("#pdz1").hide();
                    $("#pdt1").show();
                    $("#pdt").show();
                    $("#tb").show();
                    var $text_pre = ".marketing-control-room-info-";
                    $($text_pre + 'zt').val("已售");
                    $($text_pre + 'zt').removeClass("input_ws");
                    $($text_pre + 'zt').addClass("input_ys");
                    $($text_pre + 'is-sf').val('1');

                    $(".marketing-control-content-room-cancel").show();
                    $(".marketing-control-content-room-confirm").hide();

                    $('#cstname1').attr("readonly", "readonly");
                    $('#xftime1').attr("readonly", "readonly");
                    $('#vip1').attr("readonly", "readonly");
                    $('#phone1').attr("readonly", "readonly");
                    $('#cardno1').attr("readonly", "readonly");
                    //$(".marketing-control-content-rooms-box-room-"+$room_id).click();
                }
                else {
                    $("#xfcgys").hide();
                    $("#ystitle").show();
                    $("#xftitle").hide();
                    layer_alert_two('此房间已经售出，请选择其他房间！');
                }
                //同步最新销售数据
                var $zxrooms = data.info[1];
                var count = data.info[2];
                var xftime = data.info[3];
                $("#yg_count").text(count[0]['zc']);
                $("#user_count").text(count[0]['uc']);
                $('#xftime1').val(xftime);
                if ($zxrooms.length > 0) {
                    var $room1 = "";
                    var $id1 = 0;
                    for (var $i = 0; $i < $zxrooms.length; $i++) {
                        $id1 = $zxrooms[$i].id;
                        if ($zxrooms[$i].is_xf == 1) {
                            if (!$('.marketing-control-content-rooms-box-room-' + $id1).hasClass("marketing-control-content-rooms-box-room-selected")) {
                                $(".marketing-control-content-rooms-box-room-" + $id1).addClass("marketing-control-content-rooms-box-room-selected");
                            }
                        }
                        else {
                            if ($('.marketing-control-content-rooms-box-room-' + $id1).hasClass("marketing-control-content-rooms-box-room-selected")) {
                                $('.marketing-control-content-rooms-box-room-' + $id1).removeClass("marketing-control-content-rooms-box-room-selected");

                            }
                        }
                        // if($id1==$room_id)
                        // {
                        //     $('#cstname1').val($zxrooms[$i].cstname);
                        //     $('#cstid1').val($zxrooms[$i].cstid);
                        //     $('#phone1').val($zxrooms[$i].phone);
                        //     $('#cardno1').val($zxrooms[$i].cardno);
                        //     $('#vip1').val($zxrooms[$i].cyjno);
                        //     $('#xftime1').val($zxrooms[$i].xftime1);
                        //     $($text_pre + 'is-sf').val(1);
                        //     $($text_pre + 'zt').val("已售");
                        //     $($text_pre + 'zt').addClass("input_ys");
                        //     $($text_pre + 'zt').removeClass("input_ws");
                        // }
                    }
                }
            },
            error: function (data, status, e) {
                layer_alert_two('提交连接失败！');
            }
        });

        return false;
    });


    //取消选房
    $(".marketing-control-content-room-cancel-btn").click(function () {
        $("#xfcgys").hide();
        //$("#ystitle").hide();
        //$("#xftitle").hide();
        var $room_id = $(".marketing-control-room-info-id").val();
        var $cstname = $("#cstname1").val();
        var $room_name = $("#roominfo1").val();
        var $is_sf = $(".marketing-control-room-info-is-sf").val();

        if ($is_sf == '0') {
            layer_alert_two('该房间已经取消，请选择其他房间！');
            return false;
        }

        if ($room_id == '') {
            layer_alert_two('房间信息不存在！');
            return false;
        }
        //确认函数
        var $confirm = function () {
            $.ajax({
                url: room_url.not_choose_room,
                data: {
                    id: $room_id,
                },
                type: 'POST',
                dataType: 'JSON',
                success: function (data, status) {
                    // alert(JSON.stringify(data));
                    if (typeof(data.status) == 'undefined') {
                        layer_alert_two('请求失败，请重试！');
                        return false;
                    }
                    if (data.status == false) {
                        layer_alert_two(data.info);
                        return false;
                    }

                    hidefqz();
                    if (data.info == 1) {
                        $("#yg_count").text(Number($("#yg_count").text()) - 1);
                        $("#user_count").text(Number($("#user_count").text()) - 1);
                    } else {
                        $("#yg_count").text(Number($("#yg_count").text()) - 1);
                    }

                    layer_msg('取消选房成功');
                    /*var $room = $($text_pre + 'hx').val()+"|";
                     $room+="0|";
                     $room+=$($text_pre + 'area').val()+"|";
                     $room+=$($text_pre + 'tnarea').val()+"|";
                     $room+=$($text_pre + 'price').val()+"|";
                     $room+=$($text_pre + 'tnprice').val()+"|";
                     $room+=$($text_pre + 'total').val();
                     $("#spanid_"+$room_id).attr("infolist",$room);


                     $($text_pre + 'cstname').attr("readonly", false);
                     $($text_pre + 'cstname').css("border-bottom", "1px solid rgb(0, 204, 204)");
                     $(".marketing-control-content-room-confirm-btn").attr("disabled", false);
                     $(".marketing-control-content-room-cancel-btn").attr("disabled", true);
                     $(".marketing-control-content-room-cancel").hide();
                     $(".marketing-control-content-room-confirm").show();*/

                    $(".marketing-control-content-rooms-box-room-" + $room_id).removeClass("marketing-control-content-rooms-box-room-selected");
                },
                error: function (data, status, e) {
                    layer_alert_two('提交连接失败！');
                }
            });
        }

        layer.confirm($room_name + '，取消选房，请确认！', {
            btn: ['取消', '确认'], //按钮
            skin: 'layui-layer-qz',
            shade: [0.5, 'black'],
        }, function (index) {
            layer.close(index);
        }, function () {
            $confirm();
        });

        return false;
    });

    $(".qzxf-input-btn").focus(function () {
        $(this).css("color", "red");
    });
    $(".qzxf-input-btn").blur(function () {
        $(this).css("color", "rgba(5, 74, 83, 0.95)");
    });

    $(".marketing-control-content-room-confirm-btn").focus(function () {
        $(this).css("color", "red");
    });
    $(".marketing-control-content-room-confirm-btn").blur(function () {
        $(this).css("color", "");
    });

    $("#zxproj_bld").mouseover(function () {
        $(this).css("box-shadow", "0 0 10px rgba(5, 74, 83, 0.95)");
        $(this).css("border-left", "2px solid red");
        $(this).css("marginLeft", "-5px");
        var $width = $(".marketing-control-select-project-id").width();
        $("#ul-select-bld").css("width", $width);
    });

    $("#zxproj_bld").mouseout(function () {
        $(this).css("box-shadow", "0 0 0 0");
        $(this).css("border-left", "2px solid #00BCD4");
        $(this).css("marginLeft", "");
        var $width = $(".marketing-control-select-project-id").width();
        $("#ul-select-bld").css("width", $width);
    });

    // $("#div_search").mouseover(function(){
    // 	$(this).css("box-shadow","0 0 10px rgba(5, 74, 83, 0.95)");
    // 	$(this).css("border-left","2px solid red");
    // 	$(this).css("marginLeft","-5px");
    // 	$('#ul-select-bld').hide();
    // });
    //
    // $("#div_search").mouseout(function(){
    // 	$(this).css("box-shadow","0 0 0 0");
    // 	$(this).css("border-left","2px solid red");
    // 	$(this).css("marginLeft","");
    // });

    // $("#div_roominfo").mouseover(function(){
    // 	// $(this).css("box-shadow","0 0 10px rgba(5, 74, 83, 0.95)");
    // 	// $(this).css("border-left","2px solid red");
    // 	// $(this).css("marginLeft","-5px");
    // 	$('#ul-select-bld').hide();
    // });

    // $("#div_roominfo").mouseout(function(){
    // 	$(this).css("box-shadow","0 0 0 0");
    // 	$(this).css("border-left","2px solid #00BCD4");
    // 	$(this).css("marginLeft","");
    // });

    $("#div_xfinfo").mouseover(function () {
        $(this).css("box-shadow", "0 0 10px rgba(5, 74, 83, 0.95)");
        $(this).css("border-left", "2px solid red");
        $(this).css("marginLeft", "-5px");
        $('#ul-select-bld').hide();
    });

    $("#div_xfinfo").mouseout(function () {
        $(this).css("box-shadow", "0 0 0 0");
        $(this).css("border-left", "2px solid #00BCD4");
        $(this).css("marginLeft", "");
    });

    $(".marketing-control-content-room-cancel-btn").mouseover(function () {
        $(this).css("box-shadow", "0 0 10px rgba(5, 74, 83, 0.95)");
        $('#ul-select-bld').hide();
    });

    $(".marketing-control-content-room-cancel-btn").mouseout(function () {
        $(this).css("box-shadow", "0 0 0 0");
    });

    $(".marketing-control-content-room-confirm-btn").mouseover(function () {
        $(this).css("box-shadow", "0 0 10px rgba(5, 74, 83, 0.95)");
        $(this).css("color", "red");
        $('#ul-select-bld').hide();
    });
    $(".marketing-control-content-rooms-box-unit-list").mouseover(function () {
        $('#ul-select-bld').hide();
    });

    $(".marketing-control-content-room-confirm-btn").mouseout(function () {
        $(this).css("box-shadow", "0 0 0 0");
        $(this).css("color", "");
    });

    $(".qzxf-input-btn").mouseover(function () {
        $(this).css("color", "red");
    });

    $(".qzxf-input-btn").mouseout(function () {
        $(this).css("color", "");

    });

    $(".marketing-control-select-build-list-li").mouseover(function () {
        $(this).css("background", "#2196F3");
        $(this).css("color", "#FFF");
    });
    $(".marketing-control-select-build-list-li").mouseout(function () {
        $(this).css("background", "#FFF");
        $(this).css("color", "");
    });


    //右侧导航
    $(".suspend").mouseover(function () {
        $(this).stop();
        $(this).animate({width: 145}, 200);
    })

    $(".suspend").mouseout(function () {
        $(this).stop();
        $(this).animate({width: 45}, 200);
    });

});

//最新购房数据刷新
function showzxrooms($projid) {
    var rooms_url = {get_gfrooms: '<{:U("room/get_gfrooms")}>',}
    $.ajax({
        url: rooms_url.get_gfrooms,
        data: {
            info: "showzxrooms",
            projid: $projid,
        },
        type: 'POST',
        dataType: 'JSON',
        success: function (data, status) {
            if (typeof(data.status) == 'undefined') {
                //layer_alert_two('请求失败，请重试！');
                return false;
            }
            if (data.status == false) {
                layer_alert_two(data.info);
                return false;
            }
            var $zxrooms = data.info;
            if ($zxrooms.length > 0) {
                for (var $i = 0; $i < $zxrooms.length; $i++) {
                    var $id = $zxrooms[$i].id;
                    if ($('.marketing-control-content-rooms-box-room-' + $id).hasClass("marketing-control-content-rooms-box-room-selected")) {
                        continue;
                    }
                    else {
                        $(".marketing-control-content-rooms-box-room-" + $id).addClass("marketing-control-content-rooms-box-room-selected");
                        var $room = $zxrooms[$i].hx + "|";
                        $room += "1|";
                        $room += $zxrooms[$i].area + "|";
                        $room += $zxrooms[$i].tnarea + "|";
                        $room += $zxrooms[$i].price + "|";
                        $room += $zxrooms[$i].tnprice + "|";
                        $room += $zxrooms[$i].total + "|";
                        $room += $zxrooms[$i].cstname + "|";
                        $room += $zxrooms[$i].xftime1;
                        $("#spanid_" + $id).attr("infolist", $room);
                    }
                }
            }
        },
        error: function (data, status, e) {
            //layer_alert_two('提交连接失败！');
        }
    });
}

//显示弹出框
function showfqz($id) {
    $("#div-qzxfdhk").css("top", 0);//原地
    $("#div-qzxfdhk").css("left", 0);//原地
    var $roomqz = ".marketing-control-content-rooms-box-room-";
    var $zb = $($roomqz + $id).offset();
    var $width = $($roomqz + $id).outerWidth();
    var $height = $($roomqz + $id).outerHeight();
    var bw = $('body').width();
    var bh = $('body').height();
    var $zgd = $('.marketing-control-content-rooms-list-wrapper').outerHeight();
    //console.log($zgd);
    //console.log($height);
    // console.log($zb);
    // console.log(bh);
    if ($zb.top > 0) { //console.log(bh-$zb.top-$height);
        if (bh - $zb.top - $height > 274)//显示在元素下面
        {
            // console.log('下面');
            $("#div-qzxfdhk").css("top", $zb.top + $height + 10);//原地
            if (parseInt($zb.left) < 250) {
                $("#div-qzxfdhk").css("left", $zb.left);//原地
            } else if ((bw - $zb.left - 53) < 250) {
                $("#div-qzxfdhk").css("left", ($zb.left - 500));//原地
            } else {
                $("#div-qzxfdhk").css("left", (($zb.left + 27) - 280));//原地
            }

        }
        else//显示在元素上面
        {
            // console.log('上面');
            // console.log($zb.top-274);
            $("#div-qzxfdhk").css("top", $zb.top - 274);//原地
            if (parseInt($zb.left) < 250) {
                $("#div-qzxfdhk").css("left", $zb.left);//原地
            } else if ((bw - $zb.left - $height) < 250) {
                $("#div-qzxfdhk").css("left", ($zb.left - 500));//原地
            } else {
                $("#div-qzxfdhk").css("left", (($zb.left + 27) - 280));//原地
            }
            // console.log($("#div-qzxfdhk").css("left"));
            // console.log($("#div-qzxfdhk").css("top"));
        }
        // $("#roominfo1").val($roominfo);
        $("#roominfo1").attr("data_id", $id);

        $("#div-qzxfdhk").fadeIn(300);
        var qx=$("#num_auth").text();
        // console.log(typeof  qx);
        if(qx === '' || qx === undefined){
            $("#vip1").val("").focus();
        }else{
            $("#phone1").val("").focus();
        }

        $("#cstname1").val("");
        $("#phone1").val("");
        $("#cardno1").val("");
        $(".marketing-control-search-room-list").html("");
    }
}


//隐藏弹出框
function hidefqz() {
    $(".marketing-control-content-rooms-box-room-click").removeClass("marketing-control-content-rooms-box-room-click");
    $("#roominfo1").val("");
    $("#cstid1").val("");
    $("#vip1").val("");
    $("#phone1").val("");
    $("#cardno").val("");
    $("#div-qzxfdhk").hide();
    $("#xfcgys").hide();
    $("#ystitle").show();
    $("#xftitle").hide();
    $("#in1").focus();
    $("#in2").focus();

}

function xfqz() {
    $("#div-qzxfdhk").hide();
    var $text_pre = ".marketing-control-room-info-";
    $($text_pre + 'cstname').val($("#cstname1").val());
    $($text_pre + 'cstid').val($("#cstid1").val());
    $($text_pre + 'phone').val($("#phone1").val());
    $($text_pre + 'cardno').val($("#cardno1").val());
    $($text_pre + 'vip').val($("#vip1").val());
    $(".marketing-control-content-room-confirm-btn").click();
    //$("#div_xfinfo").show();
}


//时间戳转日期
function UnixToDate(unixTime, isFull, timeZone) {
    if (typeof(timeZone) == 'number') {
        unixTime = parseInt(unixTime) + parseInt(timeZone) * 60 * 60;
    }
    var time = new Date(unixTime * 1000);
    var ymdhis = "";
    ymdhis += time.getUTCFullYear() + "-";
    ymdhis += (time.getUTCMonth() + 1) + "-";
    ymdhis += time.getUTCDate();
    if (isFull === true) {
        ymdhis += " " + time.getUTCHours() + ":";
        ymdhis += time.getUTCMinutes();
        //ymdhis += time.getUTCSeconds();

    }
    return ymdhis;

}






