<?php

/**
 * 利用GD动态生成NFO文件的图片
 *
 * 鉴于每个GD版本出来的效果有一定的差别，请选用GD 2.0以上的版本
 *
 * 该程序的诞生其实很无聊，有一天在做一个程序的时候，想到如何在网上可以完美地看到 NFO 里面的内容呢，
 * 后来就找相关的代码片断，可是怎么也找不着，因为 NFO 文件存在的特殊性，所以编写相关范例的人也相对
 * 的少，而且就目前知道的几个站点支持 NFO 文件转换为图片的代码也没可能得到，于是就唯有自己动手丰衣
 * 足食了，希望这个 Module 的公布之后，可以减少后人所走的弯路。
 *
 * @作者         Hessian(solarischan@21cn.com)
 * @版本         1.1
 * @版权所有     Hessian / NETiS
 * @使用授权     LGPL（未经作者同意不得修改代码，并且不能应用于任何商业用途，以下代码仅供参考及学习之用）
 * @特别鸣谢     wwashington（制作 OEM_DOS 的 TTF 字库） / Unknow（提供 UTF8 的字符影射算法）
 * @起始         2003-03-30
 * @访问         公开
 * 
 * 更新记录
 * 
 * ver 1.1 2003-03-31
 * 添加 GD2.DLL 一起发布。
 * 修改/增加某些地方的信息及注释。 
 * 
 * ver 1.0 2003-03-30
 * 一个可以正常显示 NFO 的 PHP 类库正式诞生了，只不过在字体显示清晰度上略有缺陷，实在是美中不足。
 * 
 */
class NFOPiC
{

	/**
	 * 存放 ISO-8859-2 UNICODE字符集的字符对照表
	 * 
	 * @变量类型  数组
	 * @起始      1.0
	 * @访问      内部
	 */
	var $code_table = array();

	/**
	 * 存放已经创建好的图片的HTML标签代码
	 * 
	 * @变量类型  字符串
	 * @起始      1.0
	 * @访问      公开
	 */
	var $image_tag = "";

	/**
	 * 创建图片的配置
	 * 
	 * @变量类型  数组
	 * @起始      1.0
	 * @访问      公开
	 */
	var $config  =  array(
		'server_save_dir' => './nfo_pic/',          //  存放已经创建完成的 NFO 文件的图片的目录
		'browser_pic_dir' => 'nfo_pic/',   //  使用浏览器浏览图片时，图片存放的相对目录
		'codetable-dir'   => "./config/",           //  ISO-8859-2 UNICODE字符集的文存放的目录
		'nfo-dir'         => "./nfo_sample/",       //  NFO 文存放的目录
		'font-dir'        => "./config/",           //  字体存放的目录
		'nfo_name'        => '',                    //  NFO 文件的名称（支持带目录路径）例如：c:/rls/aaa.nfo 或者 http://aaa.com/bbb/ccc.nfo
		'pic_name'        => '',                    //  图片名称
		'iso88592_name'   => '8859-2.TXT',          //  ISO-8859-2 UNICODE字符集的文件名称
		'font-name'       => "OEM_DOS_Std.TTF",     //  选用字体（支持带目录路径）
		'prefix'          => 'nfopic',              //  图片名称的前序
		'extension'       => 'png',                 //  输出图片的格式，'png'，'jpeg'，默认为png格式
		'jepg_quality'    => 75,                    //  输出图片为 JPEG 时，JPEG图片的压缩质量
		'width'           => 644,                   //  图片的宽度 (像素)
		'height'          => '',                    //  图片的高度 (像素)
		'top'             => 0,                     //  上方的边距
		'left'            => 0,                     //  左方的边距
		'fontcolor'       => array(0,0,0),          //  文字的颜色(R，G，B), 例如：'000033' / array(0,0,51)
//		'fontcolor'       => array(255,255,255),          //  文字的颜色(R，G，B), 例如：'000033' / array(0,0,51)
		'bgcolor'         => array(255,255,255),    //  背景颜色(R，G，B), 例如：'000033' / array(0,0,51)
//		'bgcolor'         => array(0,0,0),    //  背景颜色(R，G，B), 例如：'000033' / array(0,0,51)
		'font-size'       => 10,                    //  字型大小
		'line-space'      => 13,                    //  行间距
		'tbg'             => true                   //  是否透明背景
	);
	/**
	 * NFOPiC 的悉构函数
	 *
	 * 详细说明
	 * @形参      字符串 $parameter 为 NFO 文件的名称，支持存放位置
	 * @起始      1.0
	 * @访问      公开
	 * @返回值    无
	 * @throws
	 */
	function NFOPiC( $parameter = '' )
	{
		// 检查 $parameter 是否为空，如果不是则赋予 nfo_name
		if ($parameter != '') {
		    $this->config['nfo_name'] = $parameter;
		}

		// 打开 unicode 影射表，然后提取原始值及影射值到数组
		$tmp=@file($this->config['codetable-dir'].$this->config['iso88592_name']);
		if (!$tmp) {
			echo "打开ISO-8859-2 UNICODE字符集文件失败！";
		    exit;
		}
		while(list($key,$value)=each($tmp))
			$this->code_table[hexdec(substr($value,0,4))]=hexdec(substr($value,5,6));

	} // 结束 NFOPiC 的悉构函数


	/**
	 * 设置变量的值
	 *
	 * 详细说明
	 * @形参      
	 * @起始      1.0
	 * @访问      公开
	 * @返回值    无
	 * @throws
	 */
	function setvar( $parameter , $value )
	{
		if(!trim($parameter))
			return $parameter;

		$this->config[$parameter] = $value;

	} // 结束 setvar 函数

	/**
	 * 将字符串格式为 utf8 编码
	 *
	 * 详细说明
	 * @形参      字符串 $parameter 等待格式化为 utf8 的字符串
	 * @起始      1.0
	 * @访问      内部
	 * @返回值    经过编码的 utf8 字符串
	 * @throws
	 */
	function format_text( $parameter )
	{
		// 检查 $parameter 是否为空
		if(!trim($parameter))
			return $parameter;

		$ret="";
		$utf8="";

		// 循环读取 $parameter，直至为空
		while($parameter)
		{
			// 提取 $parameter 的第一个字符，并且将该字符的10进制值赋予 $num
			$num=ord(substr($parameter,0,1));

			// 查找 $num 在unicode table中的影射值
			$num=$this->code_table[$num];

			// 将获取影射的10进制后，经转换所得到的的字符追加到等待返回的变量中
			$ret.=$this->code2utf($num);

			// 去除 $parameter 的第一个字符
			$parameter=substr($parameter,1,strlen($parameter));
		}

		// 返回经过转换的字符串变量
		return $ret;
	} // 结束 format_text 函数


	/**
	 * 根据输入的10进制的数值输出utf8字符
	 *
	 * 详细说明
	 * @形参      10进制数字的 $num
	 * @起始      1.0
	 * @访问      内部
	 * @返回值    经过编码的utf8字符
	 * @throws
	 */
	function code2utf($num)
	{
		if($num<128)
			return chr($num);

		if($num<1024)
			return chr(($num>>6)+192).chr(($num&63)+128);

		if($num<32768)
			return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);

		if($num<2097152)
			return chr($num>>18+240).chr((($num>>12)&63)+128).chr(($num>>6)&63+128). chr($num&63+128);

		return '';
	} // 结束 code2utf 函数

	/**
	 * 直接显示图片
	 *
	 * 详细说明
	 * @起始      1.0
	 * @访问      公开
	 * @返回值    无
	 * @throws
	 */
	function nfo2pic($pic_format, $convertto='')
	{

		// 打开指定位置的 NFO 文件
		$nfoa = @file($this->config['nfo-dir'].$this->config['nfo_name']);

		// 如果 NFO 文件不存在，或者打开失败
		if (!$nfoa) {
			echo "打开打开NFO文件失败！";
		    exit;
		}

		// 计算图片的高度
		$this->setvar("height",(count($nfoa) * $this->config["line-space"]));

		// 建立图片流
		$im = imagecreate ($this->config["width"], $this->config["height"]);

		// 获取背景色
		list ($bgR,  $bgG,  $bgB)  =  $this->config['bgcolor'];
		// 设置背景色
		$background_color = imagecolorallocate ($im, $bgR, $bgG, $bgB);

		// 获取文字颜色
		list ($fgR,  $fgG,  $fgB)  =  $this->config['fontcolor'];
		// 设置字体颜色
		$font_color = imagecolorallocate ($im, $fgR, $fgG, $fgB);

		// 检查是否需要将背景色透明
		if ($this->config["tbg"]) {
			ImageColorTransparent($im, $background_color);
		}

		// 每一行的行距变量
		$pheight=0;

		// 输出 NFO 的内容
		for ($i=0; $i<count($nfoa); $i++) {
			$pheight = $pheight + $this->config["line-space"];
			imagettftext ($im, $this->config["font-size"], 0, $this->config["left"], $pheight, $font_color, $this->config['font-dir'].$this->config["font-name"], $this->format_text($nfoa[$i]));
		}

		// 检查输出格式
		if ($pic_format=="png") {
			if ($convertto == 'write') {
				$this->config["pic_name"] = $this->config["prefix"]."_".md5(mktime()).".png";
    			imagepng ($im, $this->config["server_save_dir"].$this->config["pic_name"]);
			}
			if ($convertto == 'gentag') {
				$this->config["pic_name"] = $this->config["prefix"]."_".md5(mktime()).".png";
    			imagepng ($im, $this->config["server_save_dir"].$this->config["pic_name"]);
				$this->image_tag = "<IMG SRC='".$this->config["browser_pic_dir"].$this->config["pic_name"]."' WIDTH='".$this->config["width"]."' HEIGHT='".$this->config["height"]."' TITLE='".substr($this->config["nfo_name"], 0, -4)."' ALIGN='absmiddle' BORDER='0'>";
			}
			if ($convertto == '') {
				header ("Content-type: image/png");
				imagepng ($im);
			}
		}
		// 检查输出格式
		if ($pic_format=="jpeg") {
			if ($convertto == 'write') {
				$this->config["pic_name"] = $this->config["prefix"]."_".md5(mktime()).".jpg";
    			@imagejpeg($im, $this->config["server_save_dir"].$this->config["pic_name"], $this->config["jepg_quality"]);
			}
			if ($convertto == 'gentag') {
				$this->config["pic_name"] = $this->config["prefix"]."_".md5(mktime()).".jpg";
    			imagejpeg ($im, $this->config["server_save_dir"].$this->config["pic_name"], $this->config["jepg_quality"]);
				$this->image_tag = "<IMG SRC='".$this->config["browser_pic_dir"].$this->config["pic_name"]."' WIDTH='".$this->config["width"]."' HEIGHT='".$this->config["height"]."' TITLE='".substr($this->config["nfo_name"], 0, -4)."' ALIGN='absmiddle' BORDER='0'>";
			}
			if ($convertto == '') {
				header ("Content-type: image/jpeg");
				imagejpeg ($im,"",$this->config["jepg_quality"]);
			}
		}

		$this->color_total = ImageColorsTotal($im);
		// 释放图片流
		imagedestroy ($im);

	} // 结束 show_nfo 函数

} // 结束类库

?>
