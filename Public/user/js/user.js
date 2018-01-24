//通用
$(function () {
    "use strict";

    //========================qzb改===========================
    //取消备选
    $(document).on("click",".del-div",function () {
       var id=$(this).attr("cid");
       var d=$(this);
        layer_footer_confirm1('您是否取消备选该房间？', function(){
            $.ajax({
                type:"post",
                url:user_url.delete_collected,
                data:{id:id},
                success:function (data) {
                    if(data=="false"){
                        layer_alert("取消失败，请刷新后重试！");
                    }else{
                        layer_tip("取消成功！");
                        window.location.reload();
                    }
                }
            });
        }, function(){

        });

    });
    //调整排序
    //升fa-arrow-up
    $(document).on("click",".fa-angle-double-up",function (){
        
        var $dqul=$(this).parent().parent().parent();
        var $prevul=$dqul.prev();
        var id=$(this).attr("cid");
        var apx=$(this).attr("apx");
        var pid=Number($("#xmid").text());
        //var xh=$(this).parent("p").prev("div").text();
        var allul= $(".speedbuy-content").find(".bxf-ul");
        var len=allul.length;
        allul.css("border-color",'#cecfd1');
        if(Number(apx)==1){
            return false;
        }
        $.ajax({
            type:"post",
            url:user_url.update_px,
            data:{cid:id,apx:apx,pd:"sx",pid:pid},
            success:function (data) {
                if(data=="false"){
                    layer_alert("调整失败，请刷新后重试！");
                }else{
                    //layer_tip("调整成功！");
                    //window.location.reload();
                    $dqul.css("border-color",'red');
                    $prevul.before($dqul);
                    $dqul.find("i").attr("apx",Number(apx)-1);
                    $prevul.find("i").attr("apx",apx);
                    if(Number(apx)==2)
                    {
                        $prevul.find("p").show();
                        $prevul.find("p").last().css("margin-top","20px");
                        $dqul.find("p").first().hide();
                        $dqul.find("p").last().css("margin-top","45px");
                    }
                    else if(Number(apx)==len)
                    {
                        $prevul.find("p").last().hide();

                        $dqul.find("p").show();
                        $dqul.find("p").last().css("margin-top","20px");
                    }
                }
            }
        });

    });
    //降
    $(document).on("click",".fa-angle-double-down",function (){
        var $dqul=$(this).parent().parent().parent();
        var $nextul=$dqul.next();
        var id=$(this).attr("cid");
        var apx=$(this).attr("apx");
        var pid=Number($("#xmid").text());

        var allul= $(".speedbuy-content").find(".bxf-ul");
        var len=allul.length;
        allul.css("border-color",'#cecfd1');
        if(Number(apx)==len){
            return false;
        }
        $.ajax({
            type:"post",
            url:user_url.update_px,
            data:{cid:id,apx:apx,pd:"jx",pid:pid},
            success:function (data) {
                if(data=="false"){
                    layer_alert("调整失败，请刷新后重试！");
                }else{
                    //layer_tip("调整成功！");
                    //window.location.reload();
                    $dqul.css("border-color",'red');
                    $nextul.after($dqul);
                    $dqul.find("i").attr("apx",Number(apx)+1);
                    $nextul.find("i").attr("apx",apx);
                    if(Number(apx)==len-1)
                    {
                        $nextul.find("p").show();
                        $nextul.find("p").last().css("margin-top","20px");
                        
                        $dqul.find("p").last().hide();
                    }
                    else if(Number(apx)==1)
                    {
                        $dqul.find("p").show();
                        $dqul.find("p").last().css("margin-top","20px");
                        $nextul.find("p").first().hide();
                        $nextul.find("p").last().css("margin-top","45px");
                    }
                }
            }
        });
    });
    //搜索房间
    $(document).on("click","#room_ser",function (){
        var vo=$(this).prev("input").val();
        if($.trim(vo)==""){
            return false;
        }else{
            var td=$(".user-project-view-content-rooms-table td");
            for(var i=0;i<td.length;i++){
                if(i%2!==0){
                    var li=td.eq(i).find("div>ul>li");
                    for (var k=0;k<li.length;k++){
                        if($.trim(li.eq(k).find(".user-project-view-content-rooms-room-name").text())==vo){
                               window.location.href=(li.eq(k).find("a").attr("href"));
                               return false;
                        }
                    }
                }
            }
            layer_alert("房间号不存在，请重新输入！");
            $(this).prev("input").val('');
            return false;
        }
    });
    //========================结束============================



    //导航显示
    $(".js-common-header-content").click(function () {
        var $unit = $(".js-common-header-unit-wrapper");
        var $height = $unit.outerHeight();

        if ($unit.css("display") == 'none') {
            $unit
                    .css({"top": "-" + $height + "px"})
                    .show()
                    .animate({"top": "44px"});
        } else {
            $unit
                    .animate({"top": "-" + $height + "px"}, function () {
                        $unit.hide();
                    });
        }
    });

    //房源对比
    $(".js-user-project-view-content-search-compare-btn").click(function () {
        var $thiz = $(this);
        $(this).removeClass("roomduib_selected");
        if ($thiz.hasClass("user-project-view-content-search-compare-btn-click")) {
            $(".js-user-project-view-content-selected-wrapper")
                    .animate({"right": "-66px"}, function () {
                        $(this).hide();
                    });

            $(".js-user-project-view-content-rooms-room-box-shadow").fadeOut("fast");

            $thiz.removeClass("user-project-view-content-search-compare-btn-click");

            $(".room-bottom-block").hide();
        } else {
            $(".room-bottom-block").show();
						$(this).addClass("roomduib_selected");
            $(".js-user-project-view-content-selected-wrapper")
                    .css({"right": "-66px"})
                    .show()
                    .animate({"right": "5px"});
            $(".js-user-project-view-content-rooms-room-box-shadow").fadeIn("fast");

            var $room_checked_num = $(".user-project-view-content-rooms-room-select:checked").length;
            $(".user-project-view-content-selected-num").text($room_checked_num);

            $thiz.addClass("user-project-view-content-search-compare-btn-click");
        }

    });

    //选中
    $(".user-project-view-content-rooms-table").on("click", ".js-user-project-view-content-rooms-room-box-shadow", function () {
        var $room_id = $(this).attr("data-room-id");
        
        var $room_checked_num = $(".user-project-view-content-rooms-room-select:checked").length;
        
        var $room_checked = $(".user-project-view-content-rooms-room-select-" + $room_id);
        if (!$room_checked.is(":checked")) {
            if($room_checked_num>=5)
            {
                layer_alert("每次最多只能对比5个");
                return false;
            }
            $room_checked.prop("checked", true);
        } else {
            $room_checked.prop("checked",false);
        }

        $room_checked_num = $(".user-project-view-content-rooms-room-select:checked").length;
        
        $(".user-project-view-content-selected-num").text($room_checked_num);
    });

    //比对
    $(".js-user-project-view-content-selected-compare").click(function () {
        var $select_room_list = $(".user-project-view-content-rooms-room-select:checked");

        var $room_ids = [];
        for (var $i = 0; $i < $select_room_list.length; $i++) {
            $room_ids.push($($select_room_list[$i]).attr("data-room-id"));
        }
        $room_ids = array_unique($room_ids);
        var $room_ids_str = $room_ids.join(",");
        
        if ($room_ids_str == '') {
            layer_alert("请选择要对比的房源！");
            return false;
        }
        // alert(eventId);
        var $url = window.location.protocol+"//"+window.location.host + "/user/compare/room"+ (typeof (eventId) != 'undefined' ? '/eventId/' + eventId : '')+"/ids/" + $room_ids_str +"?time="+((new Date()).getTime());
        window.location.href = $url;
    });

    $("#pt_db").click(function () {
        var $select_room_list = $(".user-project-view-content-rooms-room-select:checked");

        var $room_ids = [];
        for (var $i = 0; $i < $select_room_list.length; $i++) {
            $room_ids.push($($select_room_list[$i]).attr("data-room-id"));
        }

        $room_ids = array_unique($room_ids);

        var $room_ids_str = $room_ids.join(",");
        if ($room_ids_str == '') {
            layer_alert("请选择要对比的房源！");
            return false;
        }
        
        // alert(eventId);
        var $url = user_url.compare_room_two + '?ids=' + $room_ids_str + (typeof (eventId) != 'undefined' ? '&eventId=' + eventId : '');

        window.location.href = $url;
    });

    //查看户型
    $(".js-user-project-view-content-right-nav-btn").click(function () {
        var $house_type = $(".js-user-project-view-content-right-nav-house-type");

        if ($house_type.css("display") == 'none') {
            $house_type.slideDown("150");
        } else {
            $house_type.slideUp("150");
        }
    });

    //查看户型 - 选择
    $(".js-user-project-view-content-right-nav-house-type-one").on("click", 'a', function () {
        var $thiz = $(this).parent();
        if ($thiz.hasClass("user-project-view-content-right-nav-house-type-all")) {
            $(".js-user-project-view-content-right-nav-house-type-one").removeClass("user-project-view-content-right-nav-house-type-one-select");
            $thiz.addClass("user-project-view-content-right-nav-house-type-one-select");
        } else {
            $(".user-project-view-content-right-nav-house-type-all").removeClass("user-project-view-content-right-nav-house-type-one-select");
            if ($thiz.hasClass("user-project-view-content-right-nav-house-type-one-select")) {
                $thiz.removeClass("user-project-view-content-right-nav-house-type-one-select");
            } else {
                $thiz.addClass("user-project-view-content-right-nav-house-type-one-select");
            }
        }
        if ($(".user-project-view-content-right-nav-house-type-one-select").length < 1) {
            $(".js-user-project-view-content-right-nav-house-type-one").removeClass("user-project-view-content-right-nav-house-type-one-select");
            $(".user-project-view-content-right-nav-house-type-all").addClass("user-project-view-content-right-nav-house-type-one-select");
        }

        var $type = $(".user-project-footer-tabs-btn-select").attr("data-type");
        var $hxs = [];

        var $hx_select = $(".user-project-view-content-right-nav-house-type-one-select");
        for (var $i = 0; $i < $hx_select.length; $i++) {
            if (!$($hx_select[$i]).hasClass("user-project-view-content-right-nav-house-type-all")) {
                $hxs.push($($hx_select[$i]).find('a').attr("data-hx"));
            }
        }

        var $project_id = $(".user-project-view-base").attr("data-project-id");
        var $info = 'p' + $project_id;
        var $hx = $hxs.join(",");

        var $data = {
            type: $type,
            hx: $hx,
            info: $info,
        }
        var $url = user_url.hot_sale;
        get_hot_sale_room($data, $url);

        return false;
    });


    //类型切换
    $(".js-user-project-footer-tabs-btn").click(function () {
        $(".js-user-project-footer-tabs-btn").removeClass("user-project-footer-tabs-btn-select");
        $(this).addClass("user-project-footer-tabs-btn-select");

        var $type = $(this).attr("data-type");
        var $title = $(this).text().trim();
        var $hxs = [];

        $(".user-project-view-content-sort-title-info").text($title);

        var $hx_select = $(".user-project-view-content-right-nav-house-type-one-select");
        for (var $i = 0; $i < $hx_select.length; $i++) {
            if (!$($hx_select[$i]).hasClass("user-project-view-content-right-nav-house-type-all")) {
                $hxs.push($($hx_select[$i]).find('a').attr("data-hx"));
            }
        }

        var $project_id = $(".user-project-view-base").attr("data-project-id");
        var $info = 'p' + $project_id;
        var $hx = $hxs.join(",");

        var $data = {
            type: $type,
            hx: $hx,
            info: $info,
        }
        var $url = user_url.hot_sale;
        get_hot_sale_room($data, $url);

        return false;
    });
    $(".weui-tabbar a").click(function(){
         $(".weui-tabbar a").removeClass("weui-bar__item_on");
         $(this).addClass("weui-bar__item_on");
    });
    //搜索 - 多条件筛选
    $(".js-user-search-form-choose-btn,.roomseach").click(function () {
        
        $(".user-project-view-content-rooms-table").show();
        $(".speedbuy-content").hide();
        $(".user-project-footer").show();
        $(".user-project-view-content-gwc-wrapper").show();
        $(".user-header-zw").show();
        $(".user-header-return").hide();
        
        var $thiz = $(this);
        var $choose_option = $(".js-user-search-form-choose-option");
        var $choose_option_shadow = $(".js-user-search-form-choose-option-shadow");

        
            $choose_option
                    .css({"left": "-350px"})
                    .show()
                    .animate({"left": "0"});

            $choose_option_shadow.show();
            $thiz.addClass("user-search-form-choose-btn-click");

            //对比和筛选互斥
            $(".js-user-project-view-content-selected-wrapper")
                    .animate({"right": "-66px"}, function () {
                        $(this).hide();
                    });
            $(".js-user-project-view-content-rooms-room-box-shadow").fadeOut("fast");
            $(".js-user-project-view-content-search-compare-btn").removeClass("user-project-view-content-search-compare-btn-click");
            $(".room-bottom-block").hide();
						$(".roomduib").removeClass("roomduib_selected");
    });

    //隐藏
    $(".js-user-search-form-choose-option-shadow").click(function () {
        $(this).hide();

        $(".js-user-search-form-choose-option")
                .animate({"left": "-350px"}, function () {
                    $(this).hide();
                });
        $(".js-user-search-form-choose-btn").removeClass("user-search-form-choose-btn-click");
        $("#moreunitdiv").html("").hide();
    });

$(".closediv").click(function(){
        $(".js-user-search-form-choose-option-shadow").hide();
        $(".js-user-search-form-choose-option")
               .animate({"left": "-350px"}, function () {
                   $(this).hide();
               });
        $(".js-user-search-form-choose-btn").removeClass("user-search-form-choose-btn-click");
    });

    //搜索 - 楼栋选择
    $(".js-user-search-form-choose-option-a").click(function () {
        if ($(this).hasClass("user-search-form-choose-option-a-select")) {
            $(this).removeClass("user-search-form-choose-option-a-select");
        } else {
            $(this).addClass("user-search-form-choose-option-a-select");
        }

    });

    //搜索 - 确认
    $(".js-user-search-form-choose-option-footer-btn").click(function () {
        $(".user-search-form-choose-option-shadow").hide();

        $(".js-user-search-form-choose-option")
                .animate({"left": "-350px"}, function () {
                    $(this).hide();
                });
        $(".js-user-search-form-choose-btn").removeClass("user-search-form-choose-btn-click");

        get_user_room_list(user_url.room);

        return false;
    });

    //无缓存页面条件筛选
    $("#sure").click(function () {
        var hx=$(".user-search-form-choose-option-a-select");
        var lck=$("#lck").val();
        var lcj=$("#lcj").val();
        var mjk=$("#mjk").val();
        var mjj=$("#mjj").val();
        var monk=$("#monk").val();
        var monj=$("#monj").val();
        var arr=new Array();
        var td=$(".user-project-view-content-rooms-table td");
        var allli=$(".user-project-view-content-rooms-table").find("td>div>ul>li")
        if (hx.length==0 && lck=="" && lcj=="" && mjk=="" && mjj=="" && monk=="" && monj=="")
        {
           td.show();
           allli.show();
           $(".roomseach").removeClass("roomseach_selected")
        }
        else
        {
            $(".roomseach").addClass("roomseach_selected")
        }
        
       if(hx.length>0){
           for(var h=0;h<hx.length;h++){
                arr.push($.trim(hx.eq(h).text()));
           }
       }
       // alert(JSON.stringify(arr));
       // return false;
       if(lck!="" && lcj!=""){//楼层
           if(Number(lck)>Number(lcj)){
                var a=lcj;
                lcj=lck;
                lck=a;
           }
           
         for(var i=0;i<td.length;i++){
            if(Number(td.eq(i).attr('data-floor-id'))>=Number(lck) && Number(td.eq(i).attr('data-floor-id'))<=Number(lcj)){
                td.eq(i).show();
            }else{
                td.eq(i).hide();
            }
         }
       }
        if(mjk!="" && mjj!="" && monk!="" && monj!="" ){//面积价格都不为空
            if(Number(monk)>Number(mjj)){
                var c=monj;
                monj=monk;
                monk=c;
            }
            if(Number(mjk)>Number(mjj)){
                var b=mjj;
                mjj=mjk;
                mjk=b;
            }
            //var td=$(".user-project-view-content-rooms-table td");
            for(var i=0;i<td.length;i++){
                if(i%2!==0){
                    var li=td.eq(i).find("div>ul>li");
                    for (var k=0;k<li.length;k++){
                        var hxs=li.eq(k).attr('hx');
                        var vo=$.trim(li.eq(k).find(".user-project-view-content-rooms-room-cost").text());
                        vo=vo.slice(1);
                        vo=(vo/10000).toFixed(2);
                        if(hx.length>0){
                            if(vo>=parseFloat(monk) && vo<=parseFloat(monj) && parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text())>=parseFloat(mjk) && parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text())<=parseFloat(mjj) && $.inArray(hxs,arr)!=-1){
                                li.eq(k).show();
                            }else{
                                li.eq(k).hide();
                            }
                        }else{
                            if(vo>=parseFloat(monk) && vo<=parseFloat(monj) && parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text())>=parseFloat(mjk) && parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text())<=parseFloat(mjj)){
                                li.eq(k).show();
                            }else{
                                li.eq(k).hide();
                            }
                        }

                    }
                }
            }
        }else if(mjk!="" && mjj!="" && ( monk=="" || monj=="")){//只有面积不为空
            if(Number(mjk)>Number(mjj)){
                var b=mjj;
                mjj=mjk;
                mjk=b;
            }
            //var td=$(".user-project-view-content-rooms-table td");
            for(var i=0;i<td.length;i++){
                if(i%2!==0){
                    var li=td.eq(i).find("div>ul>li");
                    for (var k=0;k<li.length;k++){
                        var hxs=li.eq(k).attr('hx');
                        if(hx.length>0){
                            if (parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text()) >= parseFloat(mjk) && parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text()) <= parseFloat(mjj) && $.inArray(hxs,arr)!=-1) {
                                li.eq(k).show();
                            } else {
                                li.eq(k).hide();
                            }
                        }else {
                            if (parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text()) >= parseFloat(mjk) && parseFloat(li.eq(k).find(".user-project-view-content-rooms-room-area").text()) <= parseFloat(mjj)) {
                                li.eq(k).show();
                            } else {
                                li.eq(k).hide();
                            }
                        }
                    }
                }
            }
        }else if(monk!="" && monj!="" && (mjk=="" || mjj=="")){//面积不为空
            if(Number(monk)>Number(monj)){
                var c=monj;
                monj=monk;
                monk=c;
            }
            //var td=$(".user-project-view-content-rooms-table td");
            for(var i=0;i<td.length;i++){
                if(i%2!==0){
                    var li=td.eq(i).find("div>ul>li");
                    for (var k=0;k<li.length;k++){
                        var hxs=li.eq(k).attr('hx');
                        var vo=$.trim(li.eq(k).find(".user-project-view-content-rooms-room-cost").text());
                        vo=vo.slice(1);
                        vo=(vo/10000).toFixed(2);
                        if(hx.length>0){
                            if (vo >= parseFloat(monk) && vo <= parseFloat(monj) && $.inArray(hxs,arr)!=-1) {
                                li.eq(k).show();
                            } else {
                                li.eq(k).hide();
                            }
                        }else {
                            if (vo >= parseFloat(monk) && vo <= parseFloat(monj)) {
                                li.eq(k).show();
                            } else {
                                li.eq(k).hide();
                            }
                        }
                    }
                }
            }
        }else{
            if(hx.length>0){
                //var td=$(".user-project-view-content-rooms-table td");
                for(var i=0;i<td.length;i++){
                    if(i%2!==0){
                        var li=td.eq(i).find("div>ul>li");
                        for (var k=0;k<li.length;k++){
                            var hxs=li.eq(k).attr('hx');
                            if ($.inArray(hxs,arr)!=-1) {
                                li.eq(k).show();
                            } else {
                                li.eq(k).hide();
                            }
                        }
                    }
                }
            }

        }



        $(".user-search-form-choose-option-shadow").hide();
        $(".js-user-search-form-choose-option")
            .animate({"left": "-350px"}, function () {
                $(this).hide();
        });
       return false;
    });
    
    //搜索 - 查看房间详情
    $(".user-search-filter-table").on('click', '.js-user-search-filter-table-tr', function () {
        var $room_id = $(this).attr("data-id");
        var $url = room_url.room_index + '?id=' + $room_id;

        window.location.href = $url;
    });

    //收藏 - 我的收藏
    $(".js-user-project-view-content-search-collection-btn").click(function () {
        var $url = user_url.collection;
        var $pid = $("#dpproj_id").val();
        window.location.href = $url + '?pid=' + $pid;
    });

    

    //收藏 - 确认收藏
    $("body").on("click", ".js-user-collection-room-btn,.js-user-addbx-room-btn", function () {
     //$(".js-user-collection-room-btn,.js-user-addbx-room-btn").click(function () {
        var $thiz = $(this);
        var $room_id = $(this).attr("data-room-id");
        var pd = $(this).attr("no");
        var eventId=$(this).attr("eventId");
       
        if ($room_id == '' || $room_id == undefined) {
            layer_alert('请选择要收藏的房间！');
        }


        var $data = {
            room_id: $room_id,
            pd:pd
        };

        if (typeof (eventId) != "undefined") {;
            $data = {
                room_id: $room_id,
                pd:pd,
                eventId: eventId
            }
        }

        var $url = user_url.collection_add;
        $('#loading').show();

        ajax_post_callback($url, $data, function (data, status) {
            // alert(JSON.stringify(data));
            // return;
            if (data['status'] != 1) {
                layer_alert(data['info']);
                return false;
            } else {
                if ($thiz.hasClass("js-user-addbx-room-btn"))
                {
                    layer_alert("添加备选房源成功！");
                } else {
                    layer_alert("添加备选房源成功！");
                }
            }
            $('#loading').hide();
            // $(".js-user-addbx-room-btn").addClass("ybx");
            $(".js-user-addbx-room-btn").find("i").removeClass("fa-heart-o").addClass("fa-heart").css("color","#09bb07");;
            $(".js-user-addbx-room-btn").find("p").text("已备选").css("color","#09bb07");
            
            var $oldgs=$(".user-project-view-content-gwc-num").text();
            $(".user-project-view-content-gwc-num").show().text(parseInt($oldgs) + 1);

            if ($thiz.hasClass("js-user-collection-room-btn")){
                $thiz.text("取消备选");
                $thiz.removeClass("js-user-collection-room-btn")
                        .addClass("js-user-uncollection-room-btn");
            }
            if ($thiz.hasClass("js-user-addbx-room-btn"))
            {
                $thiz.removeClass("js-user-addbx-room-btn")
                        .addClass("js-user-removebx-room-btn");
            }
        });
        return false;
    });

    //收藏 - 取消收藏
    $("body").on("click", ".js-user-uncollection-room-btn,.js-user-removebx-room-btn", function (event) {
        var $thiz = $(this);
        var $room_id = $(this).attr("data-room-id");

        if ($room_id == '' || $room_id == undefined) {
            layer_alert('请选择要取消收藏的房间！');
        }

        var $data = {
            room_id: $room_id,
        };

        if (typeof (eventId) != "undefined") {
            $data = {
                room_id: $room_id,
                eventId: eventId
            }
        }

        var $url = user_url.collection_delete;
        $('#loading').show();
        ajax_post_callback($url, $data, function (data, status) {
            if (data['status'] != 1) {
                layer_alert(data['info']);
                return false;
            } else {
                if ($thiz.hasClass("js-user-removebx-room-btn"))
                {
                    layer_alert("移除备选房源成功！");
                } else {
                    layer_alert("移除备选房源成功！");
                }
            }
            $('#loading').hide();
            if ($thiz.hasClass("js-user-removebx-room-btn"))
            {
                $thiz.find("p").text("加入备选");
                $thiz.find("i").removeClass("fa-heart").addClass("fa-heart-o");
                $thiz.removeClass("js-user-removebx-room-btn")
                        .addClass("js-user-addbx-room-btn");
            } else {
                $thiz.text("加入备选");
                $thiz.removeClass("js-user-uncollection-room-btn")
                        .addClass("js-user-collection-room-btn");
            }
            var $oldgs=$(".user-project-view-content-gwc-num").text();
            $(".user-project-view-content-gwc-num").show().text(parseInt($oldgs) - 1);
        });

        return false;
    });

    //收藏 - 取消多条收藏
    $("body").on("click", ".js-user-uncollection-room-list-btn", function (event) {
        var $thiz = $(this);

        var $select_room_list = $(".js-user-collection-room-checkbox:checked");

        var $room_ids = [];
        for (var $i = 0; $i < $select_room_list.length; $i++) {
            $room_ids.push($($select_room_list[$i]).attr("data-room-id"));
        }

        var $room_ids_str = $room_ids.join(",");
        if ($room_ids_str == '') {
            layer_alert("请选择要取消收藏的房间！");
            return false;
        }

        var $data = {
            room_ids: $room_ids_str,
        };
        var $url = user_url.collection_delete_list;

        ajax_post_callback($url, $data, function (data, status) {
            if (data['status'] != 1) {
                layer_alert(data['info']);
                return false;
            } else {
                layer_alert(data['info']);
            }

            for (var $i = 0; $i < $room_ids.length; $i++) {
                $(".user-search-collection-table-tr-" + $room_ids[$i]).remove();
            }

            $(".js-user-collection-room-checkbox-all").prop("checked", false);

            return false;
        });

        return false;
    });

    //收藏 - 查看房间详情
    $(".user-search-collection-rooms-list").on('click', '.js-user-search-collection-table-td', function () {
        var $room_id = $(this).attr("data-id");
        var $url = user_url.room_index + '?id=' + $room_id;

        window.location.href = $url;
    });

    //收藏 - 房间比对
    $(".js-user-collection-compare-btn").click(function () {
        var $select_room_list = $(".js-user-collection-room-checkbox:checked");

        var $room_ids = [];
        for (var $i = 0; $i < $select_room_list.length; $i++) {
            $room_ids.push($($select_room_list[$i]).attr("data-room-id"));
        }

        var $room_ids_str = $room_ids.join(",");
        if ($room_ids_str == '') {
            layer_alert("请选择要对比的房源！");
            return false;
        }

        var $url = user_url.compare_room + '?ids=' + $room_ids_str;

        window.location.href = $url;
    });

    //收藏 - 选中
    $(".js-user-collection-room-checkbox").click(function () {
        var $thiz = $(this);
        var $room_id = $thiz.attr("data-room-id");
        var $select_tr = $(".user-search-collection-table-tr-" + $room_id);

        if (!$thiz.prop("checked")) {
            $select_tr.removeClass("user-search-collection-table-tr-selected");
        } else {
            $select_tr.addClass("user-search-collection-table-tr-selected");
        }

        is_checked_all(".js-user-collection-room-checkbox:checkbox", ".js-user-collection-room-checkbox-all");
    });

    //收藏 - 整行点击选中
    $(".js-user-collection-room-table-td-checkbox").click(function () {
        var $room_id = $(this).attr("data-id");
        var $checkbox = $(".user-search-collection-table-room-checkbox-" + $room_id);
        var $select_tr = $(".user-search-collection-table-tr-" + $room_id);
        var $checkbox_selected = $($checkbox);

        if (!$checkbox_selected.is(":checked")) {
            $checkbox_selected.prop("checked", true);
            $select_tr.addClass("user-search-collection-table-tr-selected");
        } else {
            $checkbox_selected.prop("checked", false);
            $select_tr.removeClass("user-search-collection-table-tr-selected");
        }

        is_checked_all(".js-user-collection-room-checkbox:checkbox", ".js-user-collection-room-checkbox-all");
    });

    //收藏 - 全选
    $(".js-user-collection-room-checkbox-all").click(function () {
        var $checkbox_all = $(".js-user-collection-room-checkbox-all");
        var $room_checkbox = $(".js-user-collection-room-checkbox[type='checkbox']");
        var $room_select_tr = $(".user-search-collection-table-tr");

        if ($(this).is(":checked")) {
            $room_checkbox.prop("checked", true);
            $room_select_tr.addClass("user-search-collection-table-tr-selected");

            $checkbox_all.prop("checked", true);
        } else {
            $room_checkbox.prop("checked", false);
            $room_select_tr.removeClass("user-search-collection-table-tr-selected");

            $checkbox_all.prop("checked", false);
        }
    });

    //奖励 - 提取
    $(".js-user-reward-btns-btn").click(function () {
        var $code = $(this).attr("data-code");
        if ($code == '') {
            layer_alert("操作错误，请重试！");
            return false;
        }

        var $data = {
            code: $code,
        };
        var $url = reward_url.get;

        ajax_post_callback($url, $data, function (data, status) {
            if (data['status'] != 1) {
                layer_alert(data['info']);
                return false;
            } else {
                layer_alert(data['info']);

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }

            return false;
        });

        return false;

    });

    /*#--------------- 代金券 ---------------#*/

    //代金券 - 领取代金券
    $(".js-voucher-item").on("click", function () {
        var $item_get = $(this).parent().find(".js-voucher-item-get");
        if ($item_get.css("display") == 'none') {
            $item_get.slideDown();
        } else {
            $item_get.slideUp();
        }

    });

    //代金券 - 领取代金券
    $(".js-voucher-item-get-btn").on("click", function () {
        var $voucher_id = $(this).attr("data-voucher-id");
        if ($voucher_id == '') {
            layer_alert("操作错误，请重试！");
            return false;
        }

        var $data = {
            id: $voucher_id,
        };
        var $url = voucher_url.buy;

        ajax_post_callback($url, $data, function (data, status) {
            if (data['status'] != 1) {
                layer_alert(data['info']);
                return false;
            } else {
                layer_alert("领取代金券成功！");

                setTimeout(function () {
                    window.location.reload();
                }, 1000);
            }

            return false;
        });

        return false;
    });

    //代金券 - 抢购
    $(".js-voucher-grab-btn").on("click", function () {
        var $data = {};
        var $url = voucher_url.grab;

        ajax_post_callback($url, $data, function (data, status) {
            if (data['status'] != 1) {
                layer_alert(data['info']);
                return false;
            } else {
                layer_user_html(data['info']['html']);
            }

            return false;
        });

        return false;
    });

    //显示备选房源
    $(".js-user-project-view-content-bxfy-btn,.user-project-view-content-gwc-contrasts-btn").click(function () {
        $(".user-project-view-content-rooms-table").hide();
        $(".speedbuy-content").show();
        $(".user-project-footer").hide();
        $(".user-project-view-content-gwc-wrapper").hide();
        $(".user-header-zw").hide();
        $(".user-header-return").show();
        
        var $thiz = $(".js-user-search-form-choose-btn");
        var $choose_option = $(".js-user-search-form-choose-option");
        var $choose_option_shadow = $(".js-user-search-form-choose-option-shadow");
        if ($thiz.hasClass("user-search-form-choose-btn-click")) {
            $choose_option
                    .animate({"left": "-350px"}, function () {
                        $(this).hide();
                    });

            $choose_option_shadow.hide();
            $thiz.removeClass("user-search-form-choose-btn-click");
        } 
    });
    //返回
    $(".common-header-return-btn1").click(function () {
        window.location.href = document.referrer;
    });
    //返回
    $(".common-header-return-btn").click(function () {
        $(".user-project-view-content-rooms-table").show();
        $(".speedbuy-content").hide();
        $(".user-project-footer").show();
        $(".user-project-view-content-gwc-wrapper").show();
        $(".user-header-zw").show();
        $(".user-header-return").hide();
    });

    //显示认购信息
    $("body").on('click', ".buy-suc", function () {
        var $thiz = $(this).parent().parent().parent();
        $(".div-success-no").text($thiz.find(".roominfo").text());
        $(".div-success-area").text($thiz.find(".roomarea").text());
        $(".div-success-total").text($thiz.find(".roomtotal").text());
        $(".div-success-rgm").text("签约码："+$thiz.find(".qycode").text());
        $(".div-success-ddinfo").find("a").attr("href",$thiz.find(".show-suc-btn1").find("a").attr("href")); 
        $(".div-success").show();
        $(".div-zz").show();
    });

    //显示认购信息
    $("body").on('click', ".show-suc-btn", function () {
        var $thiz = $(this).parent();
        $(".div-success-no").text($thiz.find(".roominfo").text());
        $(".div-success-area").text($thiz.find(".roomarea").text());
        $(".div-success-total").text($thiz.find(".roomtotal").text());
        $(".div-success").show();
        $(".div-zz").show();
    });

    //隐藏认购信息
    $("body").on('click', ".div-success-btn", function () {
        $(".div-success").hide();
        $(".div-zz").hide();
    });

    //取消备选房间
    $("body").on("click", ".sc-bxfy-btn", function (event) {
        var $thiz = $(this).parent();
        var $room_id = $thiz.attr("data-room-id");
        if ($room_id == '' || $room_id == undefined) {
            layer_alert('请先选择房间！');
            return false;
        }
        if ($thiz.find(".buy-suc").length > 0)
        {
            layer_alert('不能删除已认购的房间！');
            return false;
        }

        var $data = {
            room_id: $room_id,
        };
        if (typeof (eventId) != "undefined") {
            $data = {
                room_id: $room_id,
                eventId: eventId
            }
        }
        var $url = user_url.collection_delete;
        $('#loading').show();
        ajax_post_callback($url, $data, function (data, status) {
            if (data['status'] != 1) {
                layer_alert(data['info']);
                return false;
            } else {
                //layer_alert(data['info']);
            }
            $('#loading').hide();
            $thiz.remove();
            var $ullist=$(".speedbuy-content-li").find(".bxf-ul");
            if ($ullist.length>0)
            {
                $ullist.removeClass("bxf-ds").removeClass("bxf-ss");
                for(var i=0;i<$ullist.length;i++)
                {
                    if(i % 2 == 0)
                        $ullist.eq(i).addClass("bxf-ds");
                    else
                        $ullist.eq(i).addClass("bxf-ss");
                }
            }
            var $oldgs=$(".user-project-view-content-gwc-num").text();
            $(".user-project-view-content-gwc-num").show().text(parseInt($oldgs) - 1);
        });
        
        return false;
    });
    

    //微信认购
    $("body").on("click", ".wxrgbuy-button", function (event) {
        var $thiz = $(this).parent().parent().parent();
        //var $dqys=$(this);
        var $room_id = $thiz.attr("data-room-id");
        if ($room_id == '' || $room_id == undefined) {
            layer_alert('请先选择房间！');
        }
        $("#showroom").text($thiz.find(".roominfo").text());
        $("#showhx").text($thiz.find(".roomarea").text());
        $("#showtotal").text($thiz.find(".roomtotal").text());
        $("#qrddbtn").attr("room_id",$room_id);
        $(this).attr("id","libtn_"+$room_id);
        $(".div-zz").show();
        $("#qrdddiv").show();
        location.hash = "qrdd";
        /*var $data = {
            room_id: $room_id,
            eventId: eventId
        };
        var $url = orderHouse.add;
        $('#loading').show();
        ajax_post_callback($url, $data, function (data, status) {
            if (data.info[1] && data.info[1] != "人" && data.info !="房间已被认购") {
                $(".div-success-rgm").html('认购码：' + data.info[1]);
                $(".div-success-no").text($thiz.find(".roominfo").text());
                $(".div-success-area").text($thiz.find(".roomarea").text());
                $(".div-success-total").text($thiz.find(".roomtotal").text());
                $(".div-success").show();
                $(".div-zz").show();
                
                var $html='<a href="/User/OrderHouse/ordershow/id/'+eventId+'.html"><div class="show-suc-div">查</div><div style="margin-top:-40px;height:55px;border-right:1px solid #2196F3;"></div></a>';
                $thiz.children(":first").removeClass("sc-bxfy-btn").addClass("show-suc-btn1").html($html);
                $dqys.text("成功").removeClass("wxrgbuy-button").addClass("buy-suc");
                
                orderedRooms = data.info[2];
                renderRoom(orderedRooms);
                
            } else {
                var $data = {
                    eventId: eventId
                };
                ajax_post_callback('/user/OrderHouse/getAllOrderedRooms', $data, function (data, status) {
                    orderedRooms = data.info[1];
                    renderRoom(orderedRooms);
                });
                layer_alert(data.info);
            }
        });

        return false;*/
    });

    //房间中直接微信认购
    $("body").on("click", ".js-room-buy-btn", function () {
        var $room_id = $(this).attr("data-room-id");
        if ($room_id == '' || $room_id == undefined) {
            layer_alert('请先选择房间！');
        }

        $("#showroom").text($(".user-project-room-name-box").text());
        $("#showhx").text("户型："+$(".room-hx").text());
        $("#showtotal").text($(".room-total").text());
        $("#qrddbtn").attr("room_id",$room_id)
        $(this).attr("id","libtn_"+$room_id);
        $(".div-zz").show();
        $("#qrdddiv").show();
        location.hash = "qrdd";
    });

    //房间中显示认购信息
    $("body").on('click', ".js-room-show-btn", function () {
        $(".div-success").show();
        $(".div-zz").show();
    });

    $(".div-success-btn").click(function () {
        //window.location.href = window.location.href;
    });
    
    //搜索
    $(".user-content-search-input").focus(function() {  
            var $pid = $(this).attr("data-id");
            var $url = "/user/search/index/info/p" + $pid+ '.html';
            window.location.href = $url;
    });
    
    
    //搜索 - 查询
    $(".js-saler-search-form-input-box-input").bind('input propertychange', function() {
            get_search_room_list(search_url.room,"ptss");
            return false;
    });

    //搜索 - 查询(获取焦点是查询)
    $(".js-saler-search-form-input-box-input").focus(function()  {
            get_search_room_list(search_url.room,"ptss");
            return false;
    });

    /**
    * 房间搜索
    *
    **/
   function get_search_room_list($url,$type) {
           var $input_str = $(".js-saler-search-form-input-box-input").val();
           if ($type=="ptss")
           {
                   if ($input_str == '' || $input_str.length<2) {
                           $(".saler-search-filter-table-tr").remove();
                           return false;
                   }
           }
           else
           {
                   //$(".js-saler-search-form-input-box-input").val("");
           }
           var $is_xf = $(".saler-search-filter-sale:checked").val();

           var $build_ids = [];
           var $build_list = $(".saler-search-form-choose-option-build.saler-search-form-choose-option-a-select");
           for (var $i = 0; $i < $build_list.length; $i ++) {
                   $build_ids.push($($build_list[$i]).attr("data-id"));
           }

           var $project_id = $(".saler-search-project-id").attr("data-id");

           var $floor_start = $(".saler-search-form-choose-option-floor-start").val();
           var $floor_end = $(".saler-search-form-choose-option-floor-end").val();

           var $area_start = $(".saler-search-form-choose-option-area-start").val();
           var $area_end = $(".saler-search-form-choose-option-area-end").val();

           var $price_start = $(".saler-search-form-choose-option-price-start").val();
           var $price_end = $(".saler-search-form-choose-option-price-end").val();

           var $hx_ids = [];
           var $hx_list = $(".saler-search-form-choose-option-hx.saler-search-form-choose-option-a-select");
           for (var $i = 0; $i < $hx_list.length; $i ++) {
                   $hx_ids.push($($hx_list[$i]).attr("data-id"));
           }
           if ($type=="dtj1")
           {
                   if ($build_ids=="" && $floor_start=="" && $floor_end=="" && $area_start=="" && $area_end==""&& $price_start=="" &&$price_end=="" &&$hx_ids=="")
                           return false;
           }
           $.ajax({
                   url: $url || search_url.room,
                   data: {
                           type:$type,
                           info: $input_str,
                           project_id: $project_id,
                           is_xf: $is_xf,
                           build_ids: $build_ids.join(','),
                           floor_start: $floor_start,
                           floor_end: $floor_end,
                           area_start: $area_start,
                           area_end: $area_end,
                           price_start: $price_start,
                           price_end: $price_end,
                           hx_ids: $hx_ids.join(','),
                   },
                   type: 'POST',
                   dataType: 'JSON',
                   success: function (data, status) {
                           if (data['status'] != 1) {
                                   layer_alert(data['info']);
                                   return false;
                           } 

                           var $rooms = data.info;

                           $(".saler-search-filter-table-tr").remove();
                           $(".saler-search-filter-table-tr-title").after($rooms.trim());
                   },
                   error: function (data, status, e) {
                           layer_alert('提交连接失败！');
                   }
           }); 
   }
   
   //搜索 - 查看房间详情
    $(".saler-search-filter-table").on('click', '.js-saler-search-filter-table-tr', function() {
            var $room_id = $(this).attr("data-id");
            var $url = "/User/room/index/id/" + $room_id +".html";
            window.location.href = $url;
    });	
    
    //搜索 - 多条件筛选
	$(".js-saler-search-form-choose-btn").click(function() {
		$(".js-saler-search-form-input-box-input").val("");
		var $thiz = $(this);
		var $choose_option = $(".js-saler-search-form-choose-option");
		var $choose_option_shadow = $(".js-saler-search-form-choose-option-shadow");
		
		if ($thiz.hasClass("saler-search-form-choose-btn-click")) {
			$choose_option
				.animate({"right": "-350px"}, function() {
					$(this).hide();
				});
				
			$choose_option_shadow.hide();
			$thiz.removeClass("saler-search-form-choose-btn-click");
		} else {
			$choose_option
				.css({"right": "-350px"})
				.show()
				.animate({"right": "0"});
				
			$choose_option_shadow.show();			
			$thiz.addClass("saler-search-form-choose-btn-click");
		}
	});
        //搜索 - 确认
	$(".js-saler-search-form-choose-option-footer-btn").click(function() {
		$(".saler-search-form-choose-option-shadow").hide();
		
		$(".js-saler-search-form-choose-option")
			.animate({"right": "-350px"}, function() {
				$(this).hide();
			});		
		$(".js-saler-search-form-choose-btn").removeClass("saler-search-form-choose-btn-click");
		get_search_room_list(search_url.room,"dtj1");
		
		return false;
	});
        //搜索 - 楼栋选择
	$(".js-saler-search-form-choose-option-a").click(function() {
		if ($(this).hasClass("saler-search-form-choose-option-a-select")) {
			$(this).removeClass("saler-search-form-choose-option-a-select");
		} else {
			$(this).addClass("saler-search-form-choose-option-a-select");
		}
		
	});
        
        //隐藏
	$(".js-saler-search-form-choose-option-shadow").click(function() {
		$(this).hide();
		
		$(".js-saler-search-form-choose-option")
			.animate({"right": "-350px"}, function() {
				$(this).hide();
			});		
		$(".js-saler-search-form-choose-btn").removeClass("saler-search-form-choose-btn-click");
	});
    
});
 