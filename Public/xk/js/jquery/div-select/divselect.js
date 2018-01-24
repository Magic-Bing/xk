/**
 * 模拟下拉框
 * 
 *	Html:
 * 		<div class="div-select">
 *			<cite>请选择特效分类1</cite>
 *			<ul>
 *				<li><a href="javascript:;" select-id="1">导航菜单1</a></li>
 *				<li><a href="javascript:;" select-id="2">焦点幻灯片1</a></li>
 *				<li><a href="javascript:;" select-id="3">广告代码1</a></li>
 *				<li><a href="javascript:;" select-id="4">网页特效1</a></li>
 *				<li><a href="javascript:;" select-id="5">jquery 特效1</a></li>
 * 			</ul>
 *			<input name="" type="hidden" value="" class="div-input"/>
 * 		</div>
 *
 *  JS:
 *		$(".div-select").divselect(function(data) {
 * 			var $thiz = $(this);
 *			$thiz.find(".div-input").val(data.selected_id);
 *			return false;
 *		});
 *
 *
 * @create 2016-8-25
 * @author zlw
 */
 
;(function ($, window) {
	$.fn.divselect = function(callback) {
		return this.each(function(index) {
			var $thiz = this,
				$this = $(this),
				$cite = $this.find(".cite"),
				$list = $this.find("ul");

			$this.on("click", ".cite", function() {
				$list.is(":hidden") ? $list.slideDown("fast") : $list.slideUp("fast");
				return false
			});
			
			$list.on("click", "a", function() {
				var $that = $(this);
				$cite.text($that.text());
		
				$selected_id = $that.attr("select-id");
				callback.call($thiz, {
					"selected_id": selected_id,
				});
				
				$list.hide();
				return false
			});
			
			$(document).on("click.select" + index, function() {
				$list.hide();
			});
		})
	}
})(jQuery, window);