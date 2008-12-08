<?
/************************************************
*
* Html.php
* last updated: 2004-7-14
* web.php中的函数主要针对web页面元素的使用上
*
*
**************************************************/

class JS {

	/**
	* 弹出提示框
	*
	* @access public
	* @param string $txt 弹出一个提示框，$txt为要弹出的内容
	* @return void
	*/
	function popbox($txt) {
		echo "<script language='JavaScript'>alert('".$txt."')</script>";
	}

	/**
	* 非法操作警告
	*
	* @access public
	* @param string $C_alert   提示的错误信息
	* @param string $I_goback  返回后返回到哪一页,不指定则不返回
	* @return void
	*/
	function alert($C_alert,$I_goback='main.php') {
		if(!empty($I_goback)) {
			echo "<script>alert('$C_alert');window.location.href='$I_goback';</script>";
		} else {
			echo "<script>alert('$C_alert');</script>";
		}
	}

	/**
	* JAVASCRIPT实现页面跳转
	*
	* @access public
	* @param string $url 目标跳转页
	* @return void
	*/
	function jump($url){
        print '<html>'.
        '<head>'.
        '<title>html_jump</title>'.
        '<script>this.location="'.$url.'"</script>'.
        '</head>'.
        '<body></body>'.
        '</html>';
	}
}
?>