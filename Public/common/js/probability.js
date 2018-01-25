/**
 * 中奖算法
 *
 * @create 2-16-9-20
 * @author zlw
 */
function Probability(conf) {
	this.probArr = conf || [];
	this.range = [],
	this.len = this.probArr.length;
	if (this.len > 0) { 
		this.init();
	}
}

Probability.prototype = {
	init: function() {
		this.setRange();
	},
	get: function() { 
		var len = this.len,
			range = this.range,
			last,
			randNum, 
			i = 0;
	
		if (len === 0) {
			return;
		} else if(len === 1) {
			return 0;
		}
		
		last = range[len -1];
		randNum = Math.floor(last* Math.random());
	
		for (; i < len; i++) { 
			if (randNum < range[i]) {  
				break;
			}
		} 
		return i;
	},
	
	setRange: function() {
		var range = [],
			probArr = this.probArr,
			i = 0,
			len = probArr.length;
			 
		for(; i<len; i++) {
			var now = probArr[i],
				last = range[i-1] || 0; 
				
			range.push(now + last);
		} 
		
		this.range = range;
	}
};
