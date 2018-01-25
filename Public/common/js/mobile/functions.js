/***================= 公共方法 =================***/

/**
 * svg实现环形进度条
 *
 * <circle cx="100" cy="100" r="82" fill="#FFF" />
 * 
 * path参数为绘图面板id，progress为进度值0-100，r为半径
 *
 * @create 2016-9-18
 * @author zlw
 */
function draw(path, progress, r) {
    path.setAttribute('transform', 'translate('+r+','+r+')');
    var degrees = progress * (360/100);  
    var rad = degrees* (Math.PI / 180);
    var x = (Math.sin(rad) * r).toFixed(2);
    var y = -(Math.cos(rad) * r).toFixed(2);
    var lenghty = window.Number(degrees > 180);
    var descriptions = ['M', 0, 0, 'v', -r, 'A', r, r, 0, lenghty, 1, x, y, 'z'];
    path.setAttribute('d', descriptions.join(' '));
}   