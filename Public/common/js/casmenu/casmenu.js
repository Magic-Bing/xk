/**
 * 联动插件
 *  
 * @edit 2016-10-28
 * @author zlw
 */
;(function(win) {
	
	//插件名称
	var linkage = {};
	
    linkage.each = function(arr, fn) {
        var i = 0, len = arr.length;
        for (;i < len; i++) {
            if (fn(i, arr[i]) === false) {
                break;
            }
        }
    };
    linkage.extend = function() {
        var _extend = function(dest, source) {
            for (var name in dest) {
                if (dest.hasOwnProperty(name)) {
                    //当前属性是否为对象,如果为对象，则进行递归
                    if (dest[name] instanceof Object && source[name] instanceof Object) {
                        _extend(dest[name], source[name]);
                    }
                    //检测该属性是否存在
                    if (source.hasOwnProperty(name)) {
                        continue;
                    } else {
                        source[name] = dest[name];
                    }
                }
            }
        };
        var _result = {}, arr = arguments;
        //遍历属性，至后向前
        if (!arr.length) return {};
        for (var i = arr.length - 1; i >= 0; i--) {
            _extend(arr[i], _result);
        }
        arr[0] = _result;
        return _result;
    };
    linkage.trim = function(str) {
        str = str || "";
        return str.replace(/^\s|\s$/g, "").replace(/\s+/g, " ");
    };
    linkage.attr = function(elem, key, val) {
        if (typeof key === "string" && typeof val === 'undefined') {
            return elem.getAttribute(key);
        } else {
            elem.setAttribute(key, val);
        }
        return this;
    };
    //查询样式是否存在
    linkage.hasClass = function(elem, cls) {
        elem = elem || {};
        return new RegExp("\\b" + cls + "\\b").test(elem.className);
    };
    //添加样式
    linkage.addClass = function(elem, cls) {
        elem = elem || {};
        jeDt.hasClass(elem, cls) || (elem.className += " " + cls);
        elem.className = jeDt.trim(elem.className);
        return this;
    };
    //删除样式
    linkage.removeClass = function(elem, cls) {
        elem = elem || {};
        if (jeDt.hasClass(elem, cls)) {
            elem.className = elem.className.replace(new RegExp("(\\s|^)" + cls + "(\\s|$)"), "");
        }
        return this;
    };
    //事件监听器
    linkage.on = function(obj, type, fn) {
        if (obj.addEventListener) {
            obj.addEventListener(type, fn, false);
        } else if (obj.attachEvent) {
            obj.attachEvent("on" + type, fn);
        } else {
            obj["on" + type] = fn;
        }
    };
    //阻断mouseup
    linkage.stopMosup = function(evt, elem) {
        if (evt !== "mouseup") {
            jeDt.on(elem, "mouseup", function(ev) {
                jeDt.stopmp(ev);
            });
        }
    };
    linkage.html = function(elem, value) {
        if (typeof value != "undefined" || value !== undefined && elem.nodeType === 1) {
            elem.innerHTML = value;
        } else {
            return elem.innerHTML;
        }
        return this;
    };
    linkage.text = function(elem, value) {
        if (value !== undefined && elem.nodeType === 1) {
            document.all ? elem.innerText = value :elem.textContent = value;
        } else {
            var emText = document.all ? elem.innerText :elem.textContent;
            return emText;
        }
        return this;
    };
    linkage.val = function(elem, value) {
        if (value !== undefined && elem.nodeType === 1) {
            elem.value = value;
        } else {
            return elem.value;
        }
        return this;
    };
    //判断元素类型
    linkage.isValHtml = function(that) {
        return /textarea|input/.test(that.tagName.toLocaleLowerCase());
    };
    linkage.isEmpty = function(object) {
		if (variable1 !== null 
			|| variable1 !== undefined 
			|| variable1 !== ''
		) { 
			return false; 
		} 

		return true;
	}
    //判断是否为数组
    linkage.isArray = function(object) {
		return Object.prototype.toString.call(o) === '[object Array]';
		
		/**
		return  object && typeof object==='object' &&    
            typeof object.length==='number' &&  
            typeof object.splice==='function' &&    
             //判断length属性是否是可枚举的 对于数组 将得到false  
            !(object.propertyIsEnumerable('length'));
		*/
    };
    //删除当前
    linkage.remove = function(elem) {
        if (elem == undefined) {
			return true;
		}
		
		elem.parentNode.removeChild(elem);
		return true;
    };
	
	linkage.config = {
		'data': [
			{
				'id': 'id1',
				'value': 'id1',
				'name': '一级',
				'items': [
					{
						'id': 'id2',
						'value': 'id2',
						'name': '二级',
						'items': [
							{
								'id': 'id3',
								'value': 'id3',
								'name': '三级级',
								'items': [
									'id3-item1',
									'id3-item2',
									'id3-item3',
								]
							},
						]
					},
			
					{
						'id': 'id2-2',
						'value': 'id2-2',
						'name': '二级2',
						'items': [
							{
								'id': 'id3',
								'value': 'id3',
								'name': '三级级',
								'items': [
									'id3-item1',
									'id3-item2',
									'id3-item3',
								]
							},
						]
					},
			
				]
			}
		]
	}

	/**
    <body>
        省：
        <select style="width: 100px;" id="id1" class="id1">
            <option value="-1">请选择</option>
        </select>
        市：
        <select style="width: 100px;" id="id2-item1" class="id2-item1"></select>
        区：
        <select style="width: 100px;" id="id3-item" class="id3-item"></select>
    </body>
	*/	
	
	linkage.init = function(config) {		
		this.config = this.extend(this.config, config || {});
		
		if (this.isEmpty(this.config.data)) {
			return false;
		}
 	}
	
	linkage.addObjectOption = function(object) {
		if (this.isEmpty(object)) {
			return false;
		}
		
		this.each(object, function(i, value) {
			var op = new Option(i, i);
			preEle.options.add(op);
		});
	}
	
	//设置一个省的公共下标
	var pIndex = -1;
	var preEle = document.getElementById("pre");
	var cityEle = document.getElementById("city");
	var areaEle = document.getElementById("area");
	//先设置省的值
	for (var i = 0; i < pres.length; i++) {
		//声明option.<option value="pres[i]">Pres[i]</option>
		var op = new Option(pres[i], i);
		//添加
		preEle.options.add(op);
	}
	function chg(obj) {
		if (obj.value == -1) {
			cityEle.options.length = 0;
			areaEle.options.length = 0;
		}
		//获取值
		var val = obj.value;
		pIndex = obj.value;
		//获取ctiry
		var cs = cities[val];
		//获取默认区
		var as = areas[val][0];
		//先清空市
		cityEle.options.length = 0;
		areaEle.options.length = 0;
		for (var i = 0; i < cs.length; i++) {
			var op = new Option(cs[i], i);
			cityEle.options.add(op);
		}
		for (var i = 0; i < as.length; i++) {
			var op = new Option(as[i], i);
			areaEle.options.add(op);
		}
	}
	function chg2(obj) {
		var val = obj.selectedIndex;
		var as = areas[pIndex][val];
		areaEle.options.length = 0;
		for (var i = 0; i < as.length; i++) {
			var op = new Option(as[i], i);
			areaEle.options.add(op);
		}
	}
		
})(window);