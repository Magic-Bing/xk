$(function(){

	var txt0=["(垃圾)","(太烂了)","(太菜了)","(不够好)","(一般)","(还可以)","(还好)","(很不错)","(超赞)","(极品)"];
	var txt1=["(垃圾)","(瞎扯)","(俗)","(菜)","(一般)","(还行)","(生动)","(精彩)","(超赞)","(极品)"];
	var txt2=["(太监)","(百年不动)","(等不了了)","(太慢了)","(有点慢哦)","(正常)","(挺快)","(像刘翔那么快)","(灰机一样快)","(完本)"];
	var txt3=["(小学没毕业)","(文盲)","(太烂了)","(不敢恭维)","(跟我差不多水平)","(洋洋洒洒)","(文采飞扬)","(行云流水)","(妙笔生花)","(极品)"];
	
	$("#doPoint .rating-star small").each(function(index){
		$(this).mouseover(function() {
			id = index + 1;
			var obj = $(this).parent().parent().next().children("em");
			if (id<=10) {
				obj.html(txt1[id-1]);
			} else if (id>10 && id<=20) {
				id = id-10;
				obj.html(txt2[id-1]);
			} else if (id>20 && id<=30) {
				id = id-20;
				obj.html(txt3[id-1]);
			}
			
			$(this).parent().removeClass();
			$(this).parent().addClass("star"+id);
			$(this).parent().parent().next().children("strong").html(id);
		});
	  
		var Point1=5;
		var Point2=5;
		var Point3=5;
		
		$(this).click(function() {
			id = index + 1;
			if (id<=10) {
				$("#pointV1").val(id);
			} else if (id>10 && id<=20) {
				id = id-10;
				$("#pointV2").val(id);
			}else if (id>20 && id<=30){
				id = id-20;
				$("#pointV3").val(id);
			}
			$(this).parent().attr("v", id);

			var v1 = parseInt($("#item1").attr("v"));
			var v2 = parseInt($("#item2").attr("v"));
			var v3 = parseInt($("#item3").attr("v"));
			var temp_v = (v1+v2+v3)/3;
			var temp_v = Math.round(temp_v*Math.pow(10,1))/Math.pow(10,1);

			var num = temp_v;
			var integer = parseInt(num);
			var flt = num - integer;
			var fltln = (num.toString()).length-(integer.toString()).length-1;
			var fltint = (flt.toString()).substring(2,(fltln+2));
			var fltint = fltint > 0 ? fltint : 0;   

			$("#myPoint").find(".rating-big-star")
				.removeClass()
				.addClass("rating-big-star rating-big-star"+integer);

			$("#myPoint big").html(integer);
			$("#myPoint small").html("."+fltint);
			$("#myPoint em").html(txt0[integer-1]);
			$("#pointTotal").val(integer+"."+fltint);
			
			if (integer == 10) {
				$("#myPoint small").hide();
			} else {
				$("#myPoint small").show();
			}
		});
	  
		$(this).parent().mouseout(function() {
			var ids = $(this).attr("v");
				id = index + 1;
			var obj = $(this).parent().next().children("em");
			if (id <= 10) {
				obj.html(txt1[ids-1]);
			} else if (id>10 && id<=20) {
				id = id-10;
				obj.html(txt2[ids-1]);
			} else if (id>20 && id<=30) {
				id = id-20;
				obj.html(txt3[ids-1]);
			}
			
			$(this).parent().next().children("strong").html(ids);
			$(this).removeClass();
			$(this).addClass("star"+ids);
		});
	});
	
	//提交数据
	$(".js-user-rating-form-btn").click(function() {
		var $url = rating_url.save;
		
		var $total = $(".user-rating-point-total").val();
		var $rating1 = $(".user-rating-point-v1").val();
		var $rating2 = $(".user-rating-point-v2").val();
		var $rating3 = $(".user-rating-point-v3").val();
		var $content = $(".user-rating-point-content").val();
		
		if ($total == '' || $rating1 == '' || $rating2 == '' || $rating3 == '') {
			layer_alert('评分不能为空，请重试！');
			return false;
		}
		
		var $data = {
				total: $total,
				rating1: $rating1,
				rating2: $rating2,
				rating3: $rating3,
				content: $content,
			};
		
		$.ajax({
			url: $url,
			data: $data,
			type: 'POST',
			dataType: 'JSON',
			success: function(data, e) {
				if (data['status'] != 1) {
					layer_alert(data['info']);
					return false;
				}
				
				layer_alert('评价成功！');
				return false;
			},
			error: function (data, status, e) {
				layer_alert('提交连接失败！');
			}
		}); 
	});

});
