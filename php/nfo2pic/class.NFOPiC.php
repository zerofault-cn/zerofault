<?php

/**
 * ����GD��̬����NFO�ļ���ͼƬ
 *
 * ����ÿ��GD�汾������Ч����һ���Ĳ����ѡ��GD 2.0���ϵİ汾
 *
 * �ó���ĵ�����ʵ�����ģ���һ������һ�������ʱ���뵽��������Ͽ��������ؿ��� NFO ����������أ�
 * ����������صĴ���Ƭ�ϣ�������ôҲ�Ҳ��ţ���Ϊ NFO �ļ����ڵ������ԣ����Ա�д��ط�������Ҳ���
 * ���٣����Ҿ�Ŀǰ֪���ļ���վ��֧�� NFO �ļ�ת��ΪͼƬ�Ĵ���Ҳû���ܵõ������Ǿ�Ψ���Լ����ַ���
 * ��ʳ�ˣ�ϣ����� Module �Ĺ���֮�󣬿��Լ��ٺ������ߵ���·��
 *
 * @����         Hessian(solarischan@21cn.com)
 * @�汾         1.1
 * @��Ȩ����     Hessian / NETiS
 * @ʹ����Ȩ     LGPL��δ������ͬ�ⲻ���޸Ĵ��룬���Ҳ���Ӧ�����κ���ҵ��;�����´�������ο���ѧϰ֮�ã�
 * @�ر���л     wwashington������ OEM_DOS �� TTF �ֿ⣩ / Unknow���ṩ UTF8 ���ַ�Ӱ���㷨��
 * @��ʼ         2003-03-30
 * @����         ����
 * 
 * ���¼�¼
 * 
 * ver 1.1 2003-03-31
 * ��� GD2.DLL һ�𷢲���
 * �޸�/����ĳЩ�ط�����Ϣ��ע�͡� 
 * 
 * ver 1.0 2003-03-30
 * һ������������ʾ NFO �� PHP �����ʽ�����ˣ�ֻ������������ʾ������������ȱ�ݣ�ʵ�������в��㡣
 * 
 */
class NFOPiC
{

	/**
	 * ��� ISO-8859-2 UNICODE�ַ������ַ����ձ�
	 * 
	 * @��������  ����
	 * @��ʼ      1.0
	 * @����      �ڲ�
	 */
	var $code_table = array();

	/**
	 * ����Ѿ������õ�ͼƬ��HTML��ǩ����
	 * 
	 * @��������  �ַ���
	 * @��ʼ      1.0
	 * @����      ����
	 */
	var $image_tag = "";

	/**
	 * ����ͼƬ������
	 * 
	 * @��������  ����
	 * @��ʼ      1.0
	 * @����      ����
	 */
	var $config  =  array(
		'server_save_dir' => './nfo_pic/',          //  ����Ѿ�������ɵ� NFO �ļ���ͼƬ��Ŀ¼
		'browser_pic_dir' => 'nfo_pic/',   //  ʹ����������ͼƬʱ��ͼƬ��ŵ����Ŀ¼
		'codetable-dir'   => "./config/",           //  ISO-8859-2 UNICODE�ַ������Ĵ�ŵ�Ŀ¼
		'nfo-dir'         => "./nfo_sample/",       //  NFO �Ĵ�ŵ�Ŀ¼
		'font-dir'        => "./config/",           //  �����ŵ�Ŀ¼
		'nfo_name'        => '',                    //  NFO �ļ������ƣ�֧�ִ�Ŀ¼·�������磺c:/rls/aaa.nfo ���� http://aaa.com/bbb/ccc.nfo
		'pic_name'        => '',                    //  ͼƬ����
		'iso88592_name'   => '8859-2.TXT',          //  ISO-8859-2 UNICODE�ַ������ļ�����
		'font-name'       => "OEM_DOS_Std.TTF",     //  ѡ�����壨֧�ִ�Ŀ¼·����
		'prefix'          => 'nfopic',              //  ͼƬ���Ƶ�ǰ��
		'extension'       => 'png',                 //  ���ͼƬ�ĸ�ʽ��'png'��'jpeg'��Ĭ��Ϊpng��ʽ
		'jepg_quality'    => 75,                    //  ���ͼƬΪ JPEG ʱ��JPEGͼƬ��ѹ������
		'width'           => 644,                   //  ͼƬ�Ŀ�� (����)
		'height'          => '',                    //  ͼƬ�ĸ߶� (����)
		'top'             => 0,                     //  �Ϸ��ı߾�
		'left'            => 0,                     //  �󷽵ı߾�
		'fontcolor'       => array(0,0,0),          //  ���ֵ���ɫ(R��G��B), ���磺'000033' / array(0,0,51)
//		'fontcolor'       => array(255,255,255),          //  ���ֵ���ɫ(R��G��B), ���磺'000033' / array(0,0,51)
		'bgcolor'         => array(255,255,255),    //  ������ɫ(R��G��B), ���磺'000033' / array(0,0,51)
//		'bgcolor'         => array(0,0,0),    //  ������ɫ(R��G��B), ���磺'000033' / array(0,0,51)
		'font-size'       => 10,                    //  ���ʹ�С
		'line-space'      => 13,                    //  �м��
		'tbg'             => true                   //  �Ƿ�͸������
	);
	/**
	 * NFOPiC ��Ϥ������
	 *
	 * ��ϸ˵��
	 * @�β�      �ַ��� $parameter Ϊ NFO �ļ������ƣ�֧�ִ��λ��
	 * @��ʼ      1.0
	 * @����      ����
	 * @����ֵ    ��
	 * @throws
	 */
	function NFOPiC( $parameter = '' )
	{
		// ��� $parameter �Ƿ�Ϊ�գ������������ nfo_name
		if ($parameter != '') {
		    $this->config['nfo_name'] = $parameter;
		}

		// �� unicode Ӱ���Ȼ����ȡԭʼֵ��Ӱ��ֵ������
		$tmp=@file($this->config['codetable-dir'].$this->config['iso88592_name']);
		if (!$tmp) {
			echo "��ISO-8859-2 UNICODE�ַ����ļ�ʧ�ܣ�";
		    exit;
		}
		while(list($key,$value)=each($tmp))
			$this->code_table[hexdec(substr($value,0,4))]=hexdec(substr($value,5,6));

	} // ���� NFOPiC ��Ϥ������


	/**
	 * ���ñ�����ֵ
	 *
	 * ��ϸ˵��
	 * @�β�      
	 * @��ʼ      1.0
	 * @����      ����
	 * @����ֵ    ��
	 * @throws
	 */
	function setvar( $parameter , $value )
	{
		if(!trim($parameter))
			return $parameter;

		$this->config[$parameter] = $value;

	} // ���� setvar ����

	/**
	 * ���ַ�����ʽΪ utf8 ����
	 *
	 * ��ϸ˵��
	 * @�β�      �ַ��� $parameter �ȴ���ʽ��Ϊ utf8 ���ַ���
	 * @��ʼ      1.0
	 * @����      �ڲ�
	 * @����ֵ    ��������� utf8 �ַ���
	 * @throws
	 */
	function format_text( $parameter )
	{
		// ��� $parameter �Ƿ�Ϊ��
		if(!trim($parameter))
			return $parameter;

		$ret="";
		$utf8="";

		// ѭ����ȡ $parameter��ֱ��Ϊ��
		while($parameter)
		{
			// ��ȡ $parameter �ĵ�һ���ַ������ҽ����ַ���10����ֵ���� $num
			$num=ord(substr($parameter,0,1));

			// ���� $num ��unicode table�е�Ӱ��ֵ
			$num=$this->code_table[$num];

			// ����ȡӰ���10���ƺ󣬾�ת�����õ��ĵ��ַ�׷�ӵ��ȴ����صı�����
			$ret.=$this->code2utf($num);

			// ȥ�� $parameter �ĵ�һ���ַ�
			$parameter=substr($parameter,1,strlen($parameter));
		}

		// ���ؾ���ת�����ַ�������
		return $ret;
	} // ���� format_text ����


	/**
	 * ���������10���Ƶ���ֵ���utf8�ַ�
	 *
	 * ��ϸ˵��
	 * @�β�      10�������ֵ� $num
	 * @��ʼ      1.0
	 * @����      �ڲ�
	 * @����ֵ    ���������utf8�ַ�
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
	} // ���� code2utf ����

	/**
	 * ֱ����ʾͼƬ
	 *
	 * ��ϸ˵��
	 * @��ʼ      1.0
	 * @����      ����
	 * @����ֵ    ��
	 * @throws
	 */
	function nfo2pic($pic_format, $convertto='')
	{

		// ��ָ��λ�õ� NFO �ļ�
		$nfoa = @file($this->config['nfo-dir'].$this->config['nfo_name']);

		// ��� NFO �ļ������ڣ����ߴ�ʧ��
		if (!$nfoa) {
			echo "�򿪴�NFO�ļ�ʧ�ܣ�";
		    exit;
		}

		// ����ͼƬ�ĸ߶�
		$this->setvar("height",(count($nfoa) * $this->config["line-space"]));

		// ����ͼƬ��
		$im = imagecreate ($this->config["width"], $this->config["height"]);

		// ��ȡ����ɫ
		list ($bgR,  $bgG,  $bgB)  =  $this->config['bgcolor'];
		// ���ñ���ɫ
		$background_color = imagecolorallocate ($im, $bgR, $bgG, $bgB);

		// ��ȡ������ɫ
		list ($fgR,  $fgG,  $fgB)  =  $this->config['fontcolor'];
		// ����������ɫ
		$font_color = imagecolorallocate ($im, $fgR, $fgG, $fgB);

		// ����Ƿ���Ҫ������ɫ͸��
		if ($this->config["tbg"]) {
			ImageColorTransparent($im, $background_color);
		}

		// ÿһ�е��о����
		$pheight=0;

		// ��� NFO ������
		for ($i=0; $i<count($nfoa); $i++) {
			$pheight = $pheight + $this->config["line-space"];
			imagettftext ($im, $this->config["font-size"], 0, $this->config["left"], $pheight, $font_color, $this->config['font-dir'].$this->config["font-name"], $this->format_text($nfoa[$i]));
		}

		// ��������ʽ
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
		// ��������ʽ
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
		// �ͷ�ͼƬ��
		imagedestroy ($im);

	} // ���� show_nfo ����

} // �������

?>
