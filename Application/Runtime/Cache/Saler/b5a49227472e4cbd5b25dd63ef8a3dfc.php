<?php if (!defined('THINK_PATH')) exit();?>
<h1 style="font-size: 16px;background-color: #FFF;padding: 5px;letter-spacing: 1px">
     <div style="position: absolute;right: 10px;z-index: 99999;font-size: 12px;font-weight: 400;"> 
        <i class="fa fa-stop" style="color:rgba(255, 188, 23, 0.69);"></i>房源  <i class="fa fa-stop" style="margin-left: 5px;color:rgba(255, 67, 52, 0.69);"></i>收藏
    </div>
    <span style="padding: 0 2px;background: #ff7d73;margin-right: 10px;"> </span>
    楼栋动态供需单
</h1>
<div id="container-build" style="min-width:100%;height:200px;margin-bottom: 10px;"></div>
<h1 class="fl wm100" style="font-size: 16px;background-color:#FFF;padding: 5px;letter-spacing: 1px">
    <span style="padding: 0 2px;background: #ff7d73;margin-right: 10px;"> </span>
    户型动态供需单
    <select  id="build-list" class="fr">
        <option value="">全部</option>
        <?php if(is_array($group_room_build)): $k = 0; $__LIST__ = $group_room_build;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($vo['bld_id']); ?>"><?php echo ($vo['buildname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
    </select>
</h1>
<div id="container-hx" style="min-width:100%;height:200px;margin-bottom: 10px;"></div>
<h1 style="font-size: 16px;background-color: #FFF;margin-top: 45px;padding: 5px;letter-spacing: 1px">
     <span style="padding: 0 2px;background: #ff7d73;margin-right: 10px;"> </span>意向热度统计</h1>
<div class="wm100" id="imgPage" style="background-color: #fff">
    <div id="container" class="fl wm50" style="height:150px"></div>
    <div id="explain" class="fl wm50" style="height:150px;background-color: #FFF">
        <table class="wm100" style="height: 100%;">
            <tr>
                <td class="wm30">
                    <span class="hot-one-span"></span> 高
                </td>
                <td class="wm70"><?php echo ($hot_count["hot_one"]["num"]); ?>套 <?php echo ($hot_count["hot_one"]["zb"]); ?>%</td>
            </tr>
            <tr>
                <td class="wm30">
                    <span class="hot-two-span"></span> 中高
                </td>
                <td class="wm70"> <?php echo ($hot_count["hot_two"]["num"]); ?>套 <?php echo ($hot_count["hot_two"]["zb"]); ?>%</td>
            </tr>
            <tr>
                <td class="wm30">
                    <span class="hot-three-span"></span> 中
                </td>
                <td class="wm70"><?php echo ($hot_count["hot_three"]["num"]); ?>套 <?php echo ($hot_count["hot_three"]["zb"]); ?>%</td>
            </tr>
            <tr>
                <td class="wm30">
                    <span class="hot-four-span"></span> 中低
                </td>
                <td class="wm70"><?php echo ($hot_count["hot_four"]["num"]); ?>套 <?php echo ($hot_count["hot_four"]["zb"]); ?>%</td>
            </tr>
            <tr>
                <td class="wm30">
                    <span class="hot-five-span"></span> 低
                </td>
                <td class="wm70"><?php echo ($hot_count["hot_five"]["num"]); ?>套 <?php echo ($hot_count["hot_five"]["zb"]); ?>%</td>
            </tr>

        </table>
    </div>
</div>

<script>
//    var chart = null;//用于环形图中间标题显示
    $(function () {
        //房源热度饼图
        $('#container').highcharts({
            colors: "rgba(255, 67, 52, 0.69);rgba(255, 159, 98, 0.69);rgba(255,188,23,0.69);rgba(45,202,94,0.53); #6aba6e".split(";"),
            credits:{
                enabled: 0//是否显示右下角的超链接
            },
            exporting:{
                enabled:false //用来设置是否显示‘打印’,'导出'等功能按钮，不设置时默认为显示
            },
            chart: {
                type:'pie',
                spacing: [0, 0, 0, 0],//设置图形上下左右的距离
                options3d: {
                    enabled: false,//打开3D
                    alpha: 25//立体高度
                }
            },
            title: {
                floating:true,
                text: '',
                style:{fontSize:'10px'}
            },

            tooltip: {
                enabled: 1,//关闭点击图形弹出的小框
//                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    depth: 25,//立体高度
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false,//关闭图形的线条和文字提示
//                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
//                        style: {
//                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
//                        }
                    },
                    point: {
                        events: {
//                            click: function(e) { // 点击图形改变中途title的值
//                                chart.setTitle({
//                                    text: e.point.name+ '\t'+ e.point.y + ' %'
//                                });
//                            }
                        }
                    },
                }
            },
           
            series: [{
                type: 'pie',
                innerSize: '0%',//中间区域占比大小
                name: '占比',
                data: [
                    {
                        name:'高',
                        y:<?php echo ($hot_count["hot_one"]["zb"]); ?>,
                        sliced: true,
                        selected: true
                    },
                    ['中高',<?php echo ($hot_count["hot_two"]["zb"]); ?>],
                    {name: '中', y: <?php echo ($hot_count["hot_three"]["zb"]); ?>},
                    ['中低',    <?php echo ($hot_count["hot_four"]["zb"]); ?>],
                    {
                        name:'低',
                        y: <?php echo ($hot_count["hot_five"]["zb"]); ?>
                    }
                ]
            }]
        }, function(c) {
            var s = c.series[0],
                points = s.points,
                lastPoint = points[0];
            c.tooltip.shared = false;
            c.tooltip.refresh(lastPoint);
        });
        //楼栋下房间收藏柱状图
        $('#container-build').highcharts({
            colors: "rgba(255,188,23,0.69);rgba(255, 67, 52, 0.69)".split(";"),
            credits:{
                enabled: 0//是否显示右下角的超链接
            },
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            exporting:{
                enabled:false //用来设置是否显示‘打印’,'导出'等功能按钮，不设置时默认为显示
            },
            xAxis: {
                categories: <?php echo json_encode($arr_name);?>,
                crosshair: true
            },
            yAxis: {//左侧提示标题
                min: 0,
                title: {
                    text: ''
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    borderWidth: 0,
                    dataLabels:{
                            enabled:true, // dataLabels设为true
                        }
                }
            },
            series: [{
                name: '房源',
                data: <?php echo json_encode($arr_room_count);?>
            }, {
                name: '收藏',
                data:  <?php echo json_encode($arr_sc_count);?> //直接放数组是不行的，必须转成json格式
            }],
            legend: {                                                                    
                enabled: false                                                           
            }  
        });
        //户型分组柱状图
        $('#container-hx').highcharts({
            colors: "rgba(255,188,23,0.69);rgba(255, 67, 52, 0.69)".split(";"),
            credits:{
                enabled: 0//是否显示右下角的超链接
            },
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            exporting:{
                enabled:false //用来设置是否显示‘打印’,'导出'等功能按钮，不设置时默认为显示
            },
            xAxis: {
                categories: <?php echo json_encode($hx_name);?>,
        crosshair: true
    },
        yAxis: {//左侧提示标题
            min: 0,
                title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:1f} </b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
        },
        plotOptions: {
            column: {
                borderWidth: 0,
                dataLabels:{
                            enabled:true, // dataLabels设为true
                        }
            }
        },
        series: [{
            name: '房源',
            data: <?php echo json_encode($hx_room_count);?>
    }, {
            name: '收藏',
                data:  <?php echo json_encode($hx_sc_count);?> //直接放数组是不行的，必须转成json格式
        }],
        legend: {                                                                    
                enabled: false                                                           
        }  
    });
    });

</script>