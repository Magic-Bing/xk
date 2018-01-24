/**
 * 美化input标签
 *
 * @create 2016-11-18
 * @author zlw
 */
/**
 * 例子:
 * 
 * [1]上传input
 *
 * Html:
 * ======================================
	<div class="input-box">
		<a href="javascript:;" class="a-upload">
			<input type="file" class="upload admin-weixin-poster-input" name="poster" value="" />
			<span class="a-upload-tip">点击这里上传文件</span>
		</a>
		<div class="a-upload-file" style="display:none;">
			没有选择文件
		</div>
	</div>
 * ======================================
 * 
 * JS:
 * ======================================
	beautiful_input.init().upload();
 * ======================================
 *
 */
;(function (window, $) {

	var http = {
		get_path: function() {
			var js = document.scripts, 
				jsPath = js[js.length - 1].src;
			return jsPath.substring(0, jsPath.lastIndexOf("/") + 1);
		}
	};
	
	var scripts_path = http.get_path();
	
	var scripts = {
		skins: [],
		add_css: function(lib) {
			if (this.skins[lib] != undefined) {
				return true;
			}
			this.skins[lib] = true;
			
			var link = document.createElement('link');
			link.type = 'text/css';
			link.rel = 'stylesheet';
			link.href = scripts_path + lib + '.css';
			$('head').append(link);
			link = null;
		}
	};

	var beautiful_input = {
		init: function() {
			scripts.add_css("beautiful-input");
			
			return this;
		},
		is_upload: false,
		upload: function() {
			if (this.is_upload == true) {
				return this;
			} else {
				this.is_upload = true;
			}
			
			$(".input-box .a-upload").on("change", "input[type='file']", function() {
				var filePath = $(this).val();
				var inputBox = $(this).parents(".input-box");
				if (filePath.indexOf("jpg") != -1 
					|| filePath.indexOf("png") != -1
					|| filePath.indexOf("jpeg") != -1
				) {
					var arr = filePath.split('\\');
					var fileName = arr[arr.length-1];
					inputBox.find(".a-upload-file").html(fileName).show();
				} else {
					inputBox.find(".a-upload-file").html("").hide();
					return false 
				}
			});
			
			return this;
		}
	};

	window.beautiful_input = beautiful_input;
})(window, jQuery);
