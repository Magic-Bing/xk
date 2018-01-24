<?php

namespace Lookey\Image;

use Exception;


/**
 * 基于GD库的图片类
 *
 * @create 2016-11-8
 * @author zlw
 */
class Image
{

    /* 缩略图相关常量定义 */
    const IMAGE_THUMB_SCALE     =   1 ; //常量，标识缩略图等比例缩放类型
    const IMAGE_THUMB_FILLED    =   2 ; //常量，标识缩略图缩放后填充类型
    const IMAGE_THUMB_CENTER    =   3 ; //常量，标识缩略图居中裁剪类型
    const IMAGE_THUMB_NORTHWEST =   4 ; //常量，标识缩略图左上角裁剪类型
    const IMAGE_THUMB_SOUTHEAST =   5 ; //常量，标识缩略图右下角裁剪类型
    const IMAGE_THUMB_FIXED     =   6 ; //常量，标识缩略图固定尺寸缩放类型

    /* 水印相关常量定义 */
    const IMAGE_WATER_NORTHWEST =   1 ; //常量，标识左上角水印
    const IMAGE_WATER_NORTH     =   2 ; //常量，标识上居中水印
    const IMAGE_WATER_NORTHEAST =   3 ; //常量，标识右上角水印
    const IMAGE_WATER_WEST      =   4 ; //常量，标识左居中水印
    const IMAGE_WATER_CENTER    =   5 ; //常量，标识居中水印
    const IMAGE_WATER_EAST      =   6 ; //常量，标识右居中水印
    const IMAGE_WATER_SOUTHWEST =   7 ; //常量，标识左下角水印
    const IMAGE_WATER_SOUTH     =   8 ; //常量，标识下居中水印
    const IMAGE_WATER_SOUTHEAST =   9 ; //常量，标识右下角水印
	
    /**
     * 图像资源对象
     * @var resource
     */
    private $img;
	

    /**
     * 图像信息，包括width,height,type,mime,size
     * @var array
     */
    private $info;

    /**
     * 构造方法，可用于打开一张图像
     * @param string $imgname 图像路径
     */
    public function __construct($imgname = null) 
	{
        $imgname && $this->open($imgname);
    }

    /**
     * 打开一张图像
     * @param  string $imgname 图像路径
     */
    public function open($imgname)
	{
        //检测图像文件
        if (!is_file($imgname)) {
			$this->exception("不存在的图像文件");
		}

        //获取图像信息
        $info = getimagesize($imgname);

        //检测图像合法性
        if (false === $info || (IMAGETYPE_GIF === $info[2] && empty($info['bits']))) {
            $this->exception('非法图像文件');
        }

        //设置图像信息
        $this->info = array(
            'width'  => $info[0],
            'height' => $info[1],
            'type'   => image_type_to_extension($info[2], false),
            'mime'   => $info['mime'],
        );

        //销毁已存在的图像
        empty($this->img) || imagedestroy($this->img);

        //打开图像
		$fun = "imagecreatefrom{$this->info['type']}";
		$this->img = $fun($imgname);
		
		return $this;
    }

    /**
     * 保存图像
     * @param  string  $imgname   图像保存名称
     * @param  string  $type      图像类型
     * @param  integer $quality   图像质量     
     * @param  boolean $interlace 是否对JPEG类型图像设置隔行扫描
     */
    public function save($imgname, $type = null, $quality = 80, $interlace = true)
	{
        if (empty($this->img)) $this->exception('没有可以被保存的图像资源');

        //自动获取图像类型
        if(is_null($type)){
            $type = $this->info['type'];
        } else {
            $type = strtolower($type);
        }
        //保存图像
        if ('jpeg' == $type || 'jpg' == $type) {
            //JPEG图像设置隔行扫描
            imageinterlace($this->img, $interlace);
            imagejpeg($this->img, $imgname,$quality);
        } elseif ('gif' == $type) {
            $this->exception('非法图片格式');
        } else {
            $fun  =   'image'.$type;
            $fun($this->img, $imgname);
        }
		
        return $this;
    }

    /**
     * 返回图像宽度
     * @return integer 图像宽度
     */
    public function width() 
	{
        if(empty($this->img)) $this->exception('没有指定图像资源');
        return $this->info['width'];
    }

    /**
     * 返回图像高度
     * @return integer 图像高度
     */
    public function height() 
	{
        if(empty($this->img)) $this->exception('没有指定图像资源');
        return $this->info['height'];
    }

    /**
     * 返回图像类型
     * @return string 图像类型
     */
    public function type()
	{
        if(empty($this->img)) $this->exception('没有指定图像资源');
        return $this->info['type'];
    }

    /**
     * 返回图像MIME类型
     * @return string 图像MIME类型
     */
    public function mime()
	{
        if(empty($this->img)) $this->exception('没有指定图像资源');
        return $this->info['mime'];
    }

    /**
     * 返回图像尺寸数组 0 - 图像宽度，1 - 图像高度
     * @return array 图像尺寸
     */
    public function size()
	{
        if(empty($this->img)) $this->exception('没有指定图像资源');
        return array($this->info['width'], $this->info['height']);
    }

    /**
     * 销毁图像资源
     */
    public function destroy() 
	{
        empty($this->img) || imagedestroy($this->img);
		
		return $this;
    }

    /**
     * 组合图片
	 *
	 * $option[0] - 宽内边距，
	 * $option[1] - 高内边距，
	 * $option[2] - 自定义宽，
	 * $option[3] - 自定义高，
	 *
	 * @create 2016-11-9
	 * @author zlw
     */
    public function water(
		$source, 
		$locate = Image::IMAGE_WATER_SOUTHEAST, 
		$scale = 0.20, 
		$option = '', 
		$alpha = 100
	) {
        //资源检测
        if (empty($this->img)) {
			$this->exception('没有可以被添加水印的图像资源');
		}
        if (!is_file($source)) {
			$this->exception('水印图像不存在');
		}

        //获取水印图像信息
        $info = getimagesize($source);
        if (false === $info || (IMAGETYPE_GIF === $info[2] && empty($info['bits']))) {
            $this->exception('非法水印文件');
        }
		
		//分析配置
		if (!is_array($option)) {
			$config = explode(',', trim($option, ','));
		} else {
			$config = $option;
		}
		if (isset($config[0]) && $config[0] > 0) {
			$configWidth = $config[0];
		} else {
			$configWidth = 0;
		}
		if (isset($config[1]) && $config[1] > 0) {
			$configHeight = $config[1];
		} else {
			$configHeight = 0;
		}
		
		//设置水印最大高度和宽度
		if (isset($config[2]) && $config[2] > 0) {
			$newWidth = $config[2];
		} else {
			$newWidth = $scale * $this->info['width'];
		}
		if (isset($config[3]) && $config[3] > 0) {
			$newHeight = $config[1];
		} else {
			$newHeight = $scale * $this->info['height'];
		}		
		
		$newSource = $this->thumb($source, $newWidth, $newHeight);
		
		//重设图片高度和宽度
		$info[0] = $newSource['width'];
		$info[1] = $newSource['height'];
		$water = $newSource['source'];

        //创建水印图像资源
		if (empty($water)) {
			$fun   = 'imagecreatefrom' . image_type_to_extension($info[2], false);
			$water = $fun($source);
		}

        //设定水印图像的混色模式
        imagealphablending($water, true);

        /* 设定水印位置 */
        switch ($locate) {
            /* 右下角水印 */
            case Image::IMAGE_WATER_SOUTHEAST:
                $x = $this->info['width'] - $info[0] - $configWidth;
                $y = $this->info['height'] - $info[1] - $configHeight;
                break;

            /* 左下角水印 */
            case Image::IMAGE_WATER_SOUTHWEST:
                $x = 0 + $configWidth;
                $y = $this->info['height'] - $info[1] - $configHeight;
                break;

            /* 左上角水印 */
            case Image::IMAGE_WATER_NORTHWEST:
                $x = 0 + $configWidth;
				$y = 0;
                break;

            /* 右上角水印 */
            case Image::IMAGE_WATER_NORTHEAST:
                $x = $this->info['width'] - $info[0] - $configWidth;
                $y = 0 + $configHeight;
                break;

            /* 居中水印 */
            case Image::IMAGE_WATER_CENTER:
                $x = ($this->info['width'] - $info[0])/2;
                $y = ($this->info['height'] - $info[1])/2;
                break;

            /* 下居中水印 */
            case Image::IMAGE_WATER_SOUTH:
                $x = ($this->info['width'] - $info[0])/2;
                $y = $this->info['height'] - $info[1];
                break;

            /* 右居中水印 */
            case Image::IMAGE_WATER_EAST:
                $x = $this->info['width'] - $info[0];
                $y = ($this->info['height'] - $info[1])/2;
                break;

            /* 上居中水印 */
            case Image::IMAGE_WATER_NORTH:
                $x = ($this->info['width'] - $info[0])/2;
                $y = 0;
                break;

            /* 左居中水印 */
            case Image::IMAGE_WATER_WEST:
                $x = 0;
                $y = ($this->info['height'] - $info[1])/2;
                break;

            default:
                /* 自定义水印坐标 */
                if(is_array($locate)){
                    list($x, $y) = $locate;
                } else {
                    $this->exception('不支持的水印位置类型');
                }
        }

		//添加水印
		$src = imagecreatetruecolor($info[0], $info[1]);
		// 调整默认颜色
		$color = imagecolorallocate($src, 255, 255, 255);
		imagefill($src, 0, 0, $color);

		imagecopy($src, $this->img, 0, 0, $x, $y, $info[0], $info[1]);
		imagecopy($src, $water, 0, 0, 0, 0, $info[0], $info[1]);
		imagecopymerge($this->img, $src, $x, $y, 0, 0, $info[0], $info[1], $alpha);

		//销毁零时图片资源
		imagedestroy($src);

        //销毁水印资源
        imagedestroy($water);
		
		return $this;
    }

    /**
     * 获取生成缩略图资源
     * @param  integer $source 图像资源
     * @param  integer $width  缩略图最大宽度
     * @param  integer $height 缩略图最大高度
     */
    public function thumb($source, $width, $height)
	{
        if (empty($this->img)) {
			$this->exception('没有可以被裁剪的图像资源');
		}
		
        if (!is_file($source)) {
			$this->exception('添加图像不存在');
		}
		
        $info = getimagesize($source);
		
        //原图宽度和高度
        $w = $info[0];
        $h = $info[1];

		//原图尺寸小于缩略图尺寸则不进行缩略
		if($w < $width && $h < $height) return;

		//计算缩放比例
		$scale = min($width/$w, $height/$h);
		
		//设置缩略图的坐标及宽度和高度
		$x = $y = 0;
		$width  = $w * $scale;
		$height = $h * $scale;

        /* 裁剪图像 */
        $source = $this->crop($source, $w, $h, $x, $y, $width, $height);
		
		$data = array(
			'width' => $width,
			'height' => $height,
			'source' => $source,
		);
		
		return $data;
    }

    /**
     * 裁剪图像
     * @param  integer $source 图像资源
     * @param  integer $w      裁剪区域宽度
     * @param  integer $h      裁剪区域高度
     * @param  integer $x      裁剪区域x坐标
     * @param  integer $y      裁剪区域y坐标
     * @param  integer $width  图像保存宽度
     * @param  integer $height 图像保存高度
     */
    public function crop(
		$source, 
		$w, 
		$h, 
		$x = 0, 
		$y = 0, 
		$width = null, 
		$height = null
	) {
        if (empty($source)) {
			$this->exception('没有可以被裁剪的图像资源');
		}
		
		//生成资源
        $info = getimagesize($source);
		$type = image_type_to_extension($info[2], false);
		$fun = "imagecreatefrom{$type}";
		$newImg = $fun($source);

        //设置保存尺寸
        empty($width)  && $width  = $w;
        empty($height) && $height = $h;

		//创建新图像
		$img = imagecreatetruecolor($width, $height);
		// 调整默认颜色
		$color = imagecolorallocate($img, 255, 255, 255);
		imagefill($img, 0, 0, $color);

		//裁剪
		imagecopyresampled($img, $newImg, 0, 0, $x, $y, $width, $height, $w, $h);
		imagedestroy($newImg); //销毁原图

		//返回新图像
		return $img;
    }
	
	/**
	 * 获取字体位置
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getTtfPath()
	{
		$ttfPath = dirname(__FILE__);
		
		return $ttfPath . '/ttfs';
	}

    /**
     * 图像添加文字
     * @param  string  $text   添加的文字
     * @param  string  $font   字体路径
     * @param  integer $size   字号
     * @param  string  $color  文字颜色
     * @param  integer $locate 文字写入位置
     * @param  integer $offset 文字相对当前位置的偏移量
     * @param  integer $angle  文字倾斜角度
     */
    public function text(
		$text, 
		$font, 
		$size, 
		$color = '#00000000', 
        $locate = Image::IMAGE_WATER_SOUTHEAST, 
		$offset = 0, 
		$angle = 0
	){
        //资源检测
        if (empty($this->img)) {
			$this->exception('没有可以被写入文字的图像资源');
		}
        if (!is_file($font)) {
			$this->exception("不存在的字体文件：{$font}");
		}

        //获取文字信息
        $info = imagettfbbox($size, $angle, $font, $text);
        $minx = min($info[0], $info[2], $info[4], $info[6]); 
        $maxx = max($info[0], $info[2], $info[4], $info[6]); 
        $miny = min($info[1], $info[3], $info[5], $info[7]); 
        $maxy = max($info[1], $info[3], $info[5], $info[7]); 

        /* 计算文字初始坐标和尺寸 */
        $x = $minx;
        $y = abs($miny);
        $w = $maxx - $minx;
        $h = $maxy - $miny;

        /* 设定文字位置 */
        switch ($locate) {
            /* 右下角文字 */
            case Image::IMAGE_WATER_SOUTHEAST:
                $x += $this->info['width']  - $w;
                $y += $this->info['height'] - $h;
                break;

            /* 左下角文字 */
            case Image::IMAGE_WATER_SOUTHWEST:
                $y += $this->info['height'] - $h;
                break;

            /* 左上角文字 */
            case Image::IMAGE_WATER_NORTHWEST:
                // 起始坐标即为左上角坐标，无需调整
                break;

            /* 右上角文字 */
            case Image::IMAGE_WATER_NORTHEAST:
                $x += $this->info['width'] - $w;
                break;

            /* 居中文字 */
            case Image::IMAGE_WATER_CENTER:
                $x += ($this->info['width']  - $w)/2;
                $y += ($this->info['height'] - $h)/2;
                break;

            /* 下居中文字 */
            case Image::IMAGE_WATER_SOUTH:
                $x += ($this->info['width'] - $w)/2;
                $y += $this->info['height'] - $h;
                break;

            /* 右居中文字 */
            case Image::IMAGE_WATER_EAST:
                $x += $this->info['width'] - $w;
                $y += ($this->info['height'] - $h)/2;
                break;

            /* 上居中文字 */
            case Image::IMAGE_WATER_NORTH:
                $x += ($this->info['width'] - $w)/2;
                break;

            /* 左居中文字 */
            case Image::IMAGE_WATER_WEST:
                $y += ($this->info['height'] - $h)/2;
                break;

            default:
                /* 自定义文字坐标 */
                if(is_array($locate)){
                    list($posx, $posy) = $locate;
                    $x += $posx;
                    $y += $posy;
                } else {
                    $this->exception('不支持的文字位置类型');
                }
        }

        /* 设置偏移量 */
        if (is_array($offset)) {
            $offset = array_map('intval', $offset);
            list($ox, $oy) = $offset;
        } else {
            $offset = intval($offset);
            $ox = $oy = $offset;
        }

        /* 设置颜色 */
        if (is_string($color) && 0 === strpos($color, '#')) {
            $color = str_split(substr($color, 1), 2);
            $color = array_map('hexdec', $color);
            if (empty($color[3]) || $color[3] > 127) {
                $color[3] = 0;
            }
        } elseif (!is_array($color)) {
            $this->exception('错误的颜色值');
        }

		/* 写入文字 */
		$col = imagecolorallocatealpha($this->img, $color[0], $color[1], $color[2], $color[3]);
		imagettftext($this->img, $size, $angle, $x + $ox, $y + $oy, $col, $font, $text);
    
		return $this;
	}

    /**
     * 析构方法，用于销毁图像资源
     */
    public function __destruct() 
	{
        empty($this->img) || imagedestroy($this->img);
    }

    /**
     * 错误提示
	 *
	 * @create 2016-11-9
	 * @author zlw
     */
    public function exception($info = '错误') 
	{
		throw new Exception($info);
    }
	
}
