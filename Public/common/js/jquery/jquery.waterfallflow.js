/**
 * 瀑布流插件
 *
 * @create 2016-10-14
 * @author zlw
 *
 */
;(function($){
 $.fn.extend({
   waterfallflow: function(options) {
     var defaults = {
        col: 3,
        target: 'div'
     },
     options = $.extend(defaults, options);
     return this.each(function (){
       var $this = $(this),
           $items = $this.children(options.target),
           count = $items.length,
           count_row = Math.ceil(count/options.col),
           _items = [];
           for(var i =0; i < count; i++){
             _items[i] = {top: 0, left: 0, width: $items.eq(i).innerWidth(), height: $items.eq(i).innerHeight()};
           }
           $(_items).each(function(index){
            var
                i = Math.floor(index/options.col), /*row numvber*/
                j =  index % options.col, /*col numvber*/
                top_index = (i * options.col + j) <  options.col ? (i * options.col + j) : i * options.col + j - options.col,
                top_item = _items[top_index],
                pre_index = (i * options.col + j) % options.col == 0 ? i * options.col + j : i * options.col + j - 1,
                pre_item = _items[pre_index],
                top = top_item.top+( i==0 ? 0 : 1 ) * top_item.height,
                left = pre_item.left+( j==0 ? 0 : 1 )* pre_item.width;  
         
                this.top = top;
                this.left = left;
                //console.log(this);
           });
           $items.each(function(i){
               var $this = $(this),
                   top = _items[i].top + 'px',
                   left = _items[i].left + 'px';
             var bodyStyle = document.body.style;
			if(('transition' in bodyStyle) 
				|| ('webkitTransition' in bodyStyle) 
				|| ('mozTransition' in bodyStyle)
			){
               $this.css({
                   top: top,
                   left: left
               });
               return;
			};
			$this.animate({
                   top: top,
                   left: left
               }, 1000);
			});
     });     
   },
 });    
})(jQuery);