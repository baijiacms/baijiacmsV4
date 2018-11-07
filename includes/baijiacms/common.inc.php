<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Comments: mysql数据库操作
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
function tomedia($src, $local_path = false){
	global $_W;
	if (empty($src)) {
		return '';
	}
	if (strpos($src, './addons') === 0) {
		return $_W['siteroot'] . str_replace('./', '', $src);
	}
	$t = strtolower($src);
	if (strexists($t, 'http://') || strexists($t, 'https://')) {
		return $src;
	}

		$src = ATTACHMENT_WEBROOT. $src;
	return $src;
}
function message($msg, $redirect = '', $type = '',$successAutoNext=true,$sec=2) {
	global $_CMS,$_GP;
	$sec=intval($sec);
	if($redirect == 'refresh') {
		$redirect = refresh();
	}
	if($redirect == '') {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
	} else {
		$type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
	}
	if ($_CMS['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
		if($type != 'ajax' && !empty($_GP['target'])) {
			exit("
<script type=\"text/javascript\">
parent.require(['jquery', 'util'], function($, util){
	var url = ".(!empty($redirect) ? 'parent.location.href' : "''").";
	var modalobj = util.message('".$msg."', '', '".$type."');
	if (url) {
		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
	}
});
</script>");
		} else {
			$vars = array();
			$vars['message'] = $msg;
			$vars['redirect'] = $redirect;
			$vars['type'] = $type;
			exit(json_encode($vars));
		}
	}
	if (empty($msg) && !empty($redirect)) {
		header('location: '.$redirect);
	}
	$label = $type;
	if($type == 'error') {
		$label = 'danger';
	}
	if($type == 'ajax' || $type == 'sql') {
		$label = 'warning';
	}
	include page('message');
	exit();
}

function page($filename, $type = false) {
			global $_CMS,$_GP;
			    $do='';
        if($type==true)
        {
        $do=$_GP['do']."/";
      	}
			if(SYSTEM_ACT=='mobile') {
				
		
			$source=SYSTEM_ROOT . $_CMS['module']."/template/mobile/".$do."{$filename}.php";
			
			
					if (!is_file($source)) {
					$source=SYSTEM_ROOT ."common/template/mobile/".$do."{$filename}.php";
			
					}
		}else
		{
		
				$source=SYSTEM_ROOT . $_CMS['module']."/template/web/".$do."{$filename}.php";
					if (!is_file($source)) {
					$source=SYSTEM_ROOT ."common/template/web/".$do."{$filename}.php";
			
			}
		}
		return $source;
}
function getDomainBeid()
{
		global $_GP;

			$system_store = mysqld_select('SELECT id,isclose FROM '.table('system_store')." where (`website`=:website1 or `website`=:website2) and `deleted`=0 ",array(":website1"=>WEB_WEBSITE,":website2"=>'www.'.WEB_WEBSITE));
	

	
	if(empty($system_store['id']))
	{
		if(!empty($_GP['beid']))
		{
			$system_store = mysqld_select('SELECT id,isclose FROM '.table('system_store')." where `id`=:id  and `deleted`=0",array(":id"=>$_GP['beid']));
			if(empty($system_store['id']))
			{
				message("未找到相关店铺");
			}
			if(!empty($system_store['isclose']))
			{
			message("店铺已关闭无法访问");	
			}
		
			return $system_store['id'];	
		}else
		{
		return "";	
		}
	}else
	{
			if(!empty($system_store['isclose']))
			{
			message("店铺已关闭无法访问");	
			}
		
		return $system_store['id'];
	}
}
function getStoreBeid($beid)
{
	$system_store = mysqld_select('SELECT * FROM '.table('system_store')." store  where store.id=:id and `deleted`=0",array(":id"=>$beid));
	return $system_store;
}
function iserializer($value) {
	return serialize($value);
}


function iunserializer($value) {
	if (empty($value)) {
		return '';
	}
	if (!is_serialized($value)) {
		return $value;
	}
	$result = unserialize($value);
	if ($result === false) {
		$temp = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $value);
		return unserialize($temp);
	}
	return $result;
}


function is_serialized($data, $strict = true) {
	if (!is_string($data)) {
		return false;
	}
	$data = trim($data);
	if ('N;' == $data) {
		return true;
	}
	if (strlen($data) < 4) {
		return false;
	}
	if (':' !== $data[1]) {
		return false;
	}
	if ($strict) {
		$lastc = substr($data, -1);
		if (';' !== $lastc && '}' !== $lastc) {
			return false;
		}
	} else {
		$semicolon = strpos($data, ';');
		$brace = strpos($data, '}');
				if (false === $semicolon && false === $brace)
			return false;
				if (false !== $semicolon && $semicolon < 3)
			return false;
		if (false !== $brace && $brace < 4)
			return false;
	}
	$token = $data[0];
	switch ($token) {
		case 's' :
			if ($strict) {
				if ('"' !== substr($data, -2, 1)) {
					return false;
				}
			} elseif (false === strpos($data, '"')) {
				return false;
			}
				case 'a' :
		case 'O' :
			return (bool)preg_match("/^{$token}:[0-9]+:/s", $data);
		case 'b' :
		case 'i' :
		case 'd' :
			$end = $strict ? '$' : '';
			return (bool)preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
	}
	return false;
}

function checksubmit($action="submit", $allowget = false) {
	global $_CMS, $_GP;
	if (!empty($action)&&empty($_GP[$action])) {
		return FALSE;
	}
	if ($allowget)
	{
		return true;
	}
	if(!empty($_CMS['isajax']))
	{
			return true;
	}
	if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')|| (($_SERVER['REQUEST_METHOD'] == 'POST') && (empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])))) {
		return TRUE;
	}
	return FALSE;
}

function create_url($module, $params = array()) {
		global $_CMS,$_GP;
		if(empty($params['act']))
			{
		$params['act'] = strtolower($_CMS['module']);
			}
					if(empty($params['beid'])&&!empty($_CMS['beid']))
			{
		$params['beid'] = $_CMS['beid'];
			}
	
			
				if($_CMS['shopwap_member_isagent']==true)
				{
        			$params['shareid'] = get_sysopenid(false);
        }
        
	$queryString = http_build_query($params, '', '&');
	return 'index.php?mod='.$module. (empty($do) ? '' : '&do='.$do) . '&'. $queryString;
	
}

function web_url($do, $querystring = array()) {
			global $_CMS;
			if(empty($querystring['act']))
			{
		$querystring['act'] = strtolower($_CMS['module']);
			}
		$querystring['do'] = $do;
		return create_url('site', $querystring);
}
function mobile_url($do, $querystring = array()) {
		global $_CMS;
			if(empty($querystring['act']))
			{
		$querystring['act'] = strtolower($_CMS['module']);
			}
		$querystring['do'] = $do;
		return create_url('mobile', $querystring);
}
function refresh() {
	global $_GP, $_CMS;
	$_CMS['refresh'] =   $_SERVER['HTTP_REFERER'];
	$_CMS['refresh'] = substr($_CMS['refresh'], -1) == '?' ? substr($_CMS['refresh'], 0, -1) : $_CMS['refresh'];
	$_CMS['refresh'] = str_replace('&amp;', '&', $_CMS['refresh']);
	$reurl = parse_url($_CMS['refresh']);

	if(!empty($reurl['host']) && !in_array($reurl['host'], array($_SERVER['HTTP_HOST'], 'www.'.$_SERVER['HTTP_HOST'])) && !in_array($_SERVER['HTTP_HOST'], array($reurl['host'], 'www.'.$reurl['host']))) {
		$_CMS['refresh'] = WEBSITE_ROOT;
	} elseif(empty($reurl['host'])) {
		$_CMS['refresh'] = WEBSITE_ROOT.'./'.$_CMS['referer'];
	}
	return strip_tags($_CMS['refresh']);
}


function getClientIP() {
	static $ip = '';
	$ip = $_SERVER['REMOTE_ADDR'];
	if(isset($_SERVER['HTTP_CDN_SRC_IP'])) {
		$ip = $_SERVER['HTTP_CDN_SRC_IP'];
	} elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
		foreach ($matches[0] AS $xip) {
			if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
				$ip = $xip;
				break;
			}
		}
	}
	return $ip;
}

function is_mobile()   
{
  $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';   
  $mobile_browser = '0';   
  if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))   
    $mobile_browser++;   
  if((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') !== false))   
    $mobile_browser++;   
  if(isset($_SERVER['HTTP_X_WAP_PROFILE']))   
    $mobile_browser++;   
  if(isset($_SERVER['HTTP_PROFILE']))   
    $mobile_browser++;   
  $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'],0,4));   
  $mobile_agents = array(   
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',   
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',   
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',   
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',   
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',   
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',   
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',   
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',   
        'wapr','webc','winw','winw','xda','xda-'  
        );   
  if(in_array($mobile_ua, $mobile_agents))   
    $mobile_browser++;   
  if(strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)   
    $mobile_browser++;   
  // Pre-final check to reset everything if the user is on Windows   
  if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)   
    $mobile_browser=0;   
  // But WP7 is also Windows, with a slightly different characteristic   
  if(strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)   
    $mobile_browser++;   
  if($mobile_browser>0)   
    return true;   
 
 	if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
			return true;
		}
				if (isset($_SERVER['HTTP_VIA'])) {
					if(stristr($_SERVER['HTTP_VIA'], "wap"))
					{
						return  true;
					}
			}
 		if (isset ($_SERVER['HTTP_USER_AGENT'])) {
			$clientkeywords = array('nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp',
				'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 
				'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 
				'nexusone', 'cldc', 'midp', 'wap', 'mobile');
						if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
				return true;
			}
		}
				if (isset($_SERVER['HTTP_ACCEPT'])) {
						if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
				return true;
			}
		}
		return false;
}



function random($length, $numeric = FALSE) {
   	$seed = base_convert(md5(microtime() . $_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed) . '012340567890') : ($seed . 'zZ' . strtoupper($seed));
	if ($numeric) {
		$hash = '';
	} else {
		$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
		$length--;
	}
	$max = strlen($seed) - 1;
	for ($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}
function error($code, $msg = '') {
	return array(
		'errno' => $code,
		'message' => $msg,
	);
}
function is_error($data) {
	if (empty($data) || !is_array($data) || !array_key_exists('errno', $data) || (array_key_exists('errno', $data) && $data['errno'] == 0)) {
		return false;
	} else {
		return true;
	}
}

function pagination($total, $pageIndex, $pageSize = 15, $url = '', $context = array('before' => 5, 'after' => 4, 'ajaxcallback' => '')) {

	$pdata = array(
		'tcount' => 0,
		'tpage' => 0,
		'cindex' => 0,
		'findex' => 0,
		'pindex' => 0,
		'nindex' => 0,
		'lindex' => 0,
		'options' => ''
	);
	if ($context['ajaxcallback']) {
		$context['isajax'] = true;
	}

	$pdata['tcount'] = $total;
	$pdata['tpage'] = (empty($pageSize) || $pageSize < 0) ? 1 : ceil($total / $pageSize);
	if ($pdata['tpage'] <= 1) {
		return '';
	}
	$cindex = $pageIndex;
	$cindex = min($cindex, $pdata['tpage']);
	$cindex = max($cindex, 1);
	$pdata['cindex'] = $cindex;
	$pdata['findex'] = 1;
	$pdata['pindex'] = $cindex > 1 ? $cindex - 1 : 1;
	$pdata['nindex'] = $cindex < $pdata['tpage'] ? $cindex + 1 : $pdata['tpage'];
	$pdata['lindex'] = $pdata['tpage'];

	if ($context['isajax']) {
		if (!$url) {
			$url = 'index.php?' . '?' . http_build_query($_GET);
		}
		$pdata['faa'] = 'href="javascript:;" page="' . $pdata['findex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . 'index.php?' . $url . '\', \'' . $pdata['findex'] . '\', this);return false;"' : '');
		$pdata['paa'] = 'href="javascript:;" page="' . $pdata['pindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . 'index.php?' . $url . '\', \'' . $pdata['pindex'] . '\', this);return false;"' : '');
		$pdata['naa'] = 'href="javascript:;" page="' . $pdata['nindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . 'index.php?' . $url . '\', \'' . $pdata['nindex'] . '\', this);return false;"' : '');
		$pdata['laa'] = 'href="javascript:;" page="' . $pdata['lindex'] . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . 'index.php?' . $url . '\', \'' . $pdata['lindex'] . '\', this);return false;"' : '');
	} else {
		if ($url) {
			$pdata['faa'] = 'href="?' . str_replace('*', $pdata['findex'], $url) . '"';
			$pdata['paa'] = 'href="?' . str_replace('*', $pdata['pindex'], $url) . '"';
			$pdata['naa'] = 'href="?' . str_replace('*', $pdata['nindex'], $url) . '"';
			$pdata['laa'] = 'href="?' . str_replace('*', $pdata['lindex'], $url) . '"';
		} else {
			$_GET['page'] = $pdata['findex'];
			$pdata['faa'] = 'href="' . 'index.php' . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['pindex'];
			$pdata['paa'] = 'href="' . 'index.php' . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['nindex'];
			$pdata['naa'] = 'href="' . 'index.php' . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['lindex'];
			$pdata['laa'] = 'href="' . 'index.php' . '?' . http_build_query($_GET) . '"';
		}
	}

	$html = '<div><ul class="pagination pagination-centered">';
	if ($pdata['cindex'] > 1) {
		$html .= "<li><a {$pdata['faa']} class=\"pager-nav\">首页</a></li>";
		$html .= "<li><a {$pdata['paa']} class=\"pager-nav\">&laquo;上一页</a></li>";
	}
		if (!$context['before'] && $context['before'] != 0) {
		$context['before'] = 5;
	}
	if (!$context['after'] && $context['after'] != 0) {
		$context['after'] = 4;
	}

	if ($context['after'] != 0 && $context['before'] != 0) {
		$range = array();
		$range['start'] = max(1, $pdata['cindex'] - $context['before']);
		$range['end'] = min($pdata['tpage'], $pdata['cindex'] + $context['after']);
		if ($range['end'] - $range['start'] < $context['before'] + $context['after']) {
			$range['end'] = min($pdata['tpage'], $range['start'] + $context['before'] + $context['after']);
			$range['start'] = max(1, $range['end'] - $context['before'] - $context['after']);
		}
		for ($i = $range['start']; $i <= $range['end']; $i++) {
			if ($context['isajax']) {
				$aa = 'href="javascript:;" page="' . $i . '" '. ($callbackfunc ? 'onclick="'.$callbackfunc.'(\'' . 'index.php?' . $url . '\', \'' . $i . '\', this);return false;"' : '');
			} else {
				if ($url) {
					$aa = 'href="?' . str_replace('*', $i, $url) . '"';
				} else {
					$_GET['page'] = $i;
					$aa = 'href="?' . http_build_query($_GET) . '"';
				}
			}
			$html .= ($i == $pdata['cindex'] ? '<li class="active"><a href="javascript:;">' . $i . '</a></li>' : "<li><a {$aa}>" . $i . '</a></li>');
		}
	}

	if ($pdata['cindex'] < $pdata['tpage']) {
		$html .= "<li><a {$pdata['naa']} class=\"pager-nav\">下一页&raquo;</a></li>";
		$html .= "<li><a {$pdata['laa']} class=\"pager-nav\">尾页</a></li>";
	}
	$html .= '</ul></div>';
	return $html;
}

function file_move($filename, $dest) {
	mkdirs(dirname($dest));
	if(is_uploaded_file($filename)) {
		move_uploaded_file($filename, $dest);
	} else {
		rename($filename, $dest);
	}
	return is_file($dest);
}

function mkdirs($path) {
	if(!is_dir($path)) {
		mkdirs(dirname($path));
		if(!empty($path))
		{
		mkdir($path);
	}
	}
	return is_dir($path);
}

function rmdirs($path='',$isdir=false)
{
	    if(is_dir($path))
	    {
	            $file_list= scandir($path);
	            foreach ($file_list as $file)
	            {
	                if( $file!='.' && $file!='..')
	                {
	               		if($file!='qrcode')
	               		{
	                    rmdirs($path.'/'.$file,true);
	                  }
	                }
	            }
	            
	    	if($path!=WEB_ROOT.'/cache/')
	    	{
	            @rmdir($path);   
	               
	      }    
	    }
	    else
	    {
	        @unlink($path); 
	    }
	 
}


function file_upload($file, $type = 'image') {
	if(empty($file)) {
		return error(-1, '没有上传内容');
	}
	$limit=5000;
	$extention = pathinfo($file['name'], PATHINFO_EXTENSION);
	$extention=strtolower($extention);
	if(empty($type)||$type=='image')
	{
	$extentions=array('gif', 'jpg', 'jpeg', 'png');
	}
	if($type=='music')
	{
	$extentions=array('mp3','wma','wav','amr','mp4');
	}
		if($type=='other')
	{
	$extentions=array('gif', 'jpg', 'jpeg', 'png','mp3','wma','wav','amr','mp4','doc');
	}
	if(!in_array(strtolower($extention), $extentions)) {
		return error(-1, '不允许上传此类文件');
	}
	if($limit * 1024 < filesize($file['tmp_name'])) {
		return error(-1, "上传的文件超过大小限制，请上传小于 ".$limit."k 的文件");
	}

	$path = '/attachment/';
	$extpath="{$extention}/" . date('Y/m/');

		mkdirs(WEB_ROOT . $path . $extpath);
		do {
			$filename = random(15) . ".{$extention}";
		} while(is_file(SYSTEM_WEBROOT . $path . $extpath. $filename));

	$file_full_path = WEB_ROOT . $path . $extpath. $filename;
	$file_relative_path=$extpath. $filename;
	return file_save($file['tmp_name'],$filename,$extention,$file_full_path,$file_relative_path);
}
function file_upload_base64($post) {
	 $base64=base64_decode($post);

	$extention = "jpg";
	$path = '/attachment/';
	$extpath="{$extention}/" . date('Y/m/');

		mkdirs(WEB_ROOT . $path . $extpath);
		do {
			$filename = random(15) . ".{$extention}";
		} while(is_file(SYSTEM_WEBROOT . $path . $extpath. $filename));
	
	
	
	$file_tmp_name = SYSTEM_WEBROOT . $path . $extpath. $filename;
		$file_relative_path = $extpath. $filename;
	if (file_put_contents($file_tmp_name, $base64) == false) {
		$result['message'] = '提取失败.';
		return $result;
	}
		$file_full_path = WEB_ROOT .$path . $extpath. $filename;
	return file_save($file_tmp_name,$filename,$extention,$file_full_path,$file_relative_path);

}

function fetch_net_file_upload($url) {
	$url = trim($url);
	

	$extention = pathinfo($url,PATHINFO_EXTENSION );
	$path = '/attachment/';
	$extpath="{$extention}/" . date('Y/m/');

		mkdirs(WEB_ROOT . $path . $extpath);
		do {
			$filename = random(15) . ".{$extention}";
		} while(is_file(SYSTEM_WEBROOT . $path . $extpath. $filename));
	
	
	
	$file_tmp_name = SYSTEM_WEBROOT . $path . $extpath. $filename;
		$file_relative_path = $extpath. $filename;
	if (file_put_contents($file_tmp_name, file_get_contents($url)) == false) {
		$result['message'] = '提取失败.';
		return $result;
	}
		$file_full_path = WEB_ROOT .$path . $extpath. $filename;
	return file_save($file_tmp_name,$filename,$extention,$file_full_path,$file_relative_path);
}
function file_save($file_tmp_name,$filename,$extention,$file_full_path,$file_relative_path,$allownet=true)
{
	
	$settings=globaSystemSetting();
	
		if(!file_move($file_tmp_name, $file_full_path)) {
			return error(-1, '保存上传文件失败');
		}
		if(!empty($settings['image_compress_openscale']))
		{
			
			$scal=$settings['image_compress_scale'];
			$quality_command='';
			if(intval($scal)>0)
			{
				$quality_command=' -quality '.intval($scal);
			}
				system('convert'.$quality_command.' '.$file_full_path.' '.$file_full_path);
		}
	
	if($allownet&&!empty($settings['system_isnetattach']))
		{
			
			
				$filesource=$file_full_path;
		if($settings['system_isnetattach']==1)
		{
			require_once(WEB_ROOT.'/includes/lib/lib_ftp.php');
			$ftp=new baijiacms_ftp();
			$ftp->connect();
				$ftp->upload($filesource,$settings['system_ftp_ftproot']. $file_relative_path);
			if($ftp->error()) {
			return error(-1,'文件上传失败，错误号:'.$ftp->error());
			}
		}

			if($settings['system_isnetattach']==2)
		{
			require_once(WEB_ROOT.'/includes/lib/lib_oss.php');
			$oss=new baijiacms_oss();

					$oss->upload($filesource,$realfilename,$file_relative_path);
								if($oss->error()) {
			return error(-1,'文件上传失败，错误号:'.$oss->error());
			}
		}	
			
			
		}
	$result = array();
	$result['path'] =$file_relative_path;
	$result['filename'] =$filename;
	$result['extention'] =$extention;
	$result['success'] = true;
	return $result; 
	
}

function file_delete($file_relative_path) {

	if(empty($file_relative_path)) {
		return true;
	}
	
	$settings=globaSystemSetting();
	if(!empty($settings['system_isnetattach']))
		{
				if($settings['system_isnetattach']==1)
		{
		require_once(WEB_ROOT.'/includes/lib/lib_ftp.php');
			$ftp=new baijiacms_ftp();
		if (true === $ftp->connect()) {
			if ($ftp->ftp_delete($settings['system_ftp_ftproot']. $file_relative_path)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} 
		if($settings['system_isnetattach']==1)
		{
		require_once(WEB_ROOT.'/includes/lib/lib_oss.php');
		$oss=new baijiacms_oss();
		$oss->deletefile($file_relative_path);
		return true;
	}
}else
{
		if (is_file(SYSTEM_WEBROOT . '/attachment/' . $file_relative_path)) {
		unlink(SYSTEM_WEBROOT . '/attachment/' . $file_relative_path);
		return true;
	}
	
	}
	return true;
}
function http_get($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
}
function http_post($url,$post_data){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}
function attach_url($src){
	if (empty($src)) {
		return '';
	}
	$t = strtolower($src);
	if (strexists($t, 'http://') || strexists($t, 'https://')) {
		return $src;
	}
	return ATTACHMENT_WEBROOT.$src;
}

function keyexchange_set_key($evalue)
{
			global $_CMS;
	if(!empty($evalue))
	{
			keyexchange_check();
			$ekey='K'.date("YmdH",time()).rand(100,999).rand(100,999).rand(100,999).rand(0,9);
		  $has_key_exchange = mysqld_select("SELECT * FROM " . table('key_exchange') . " WHERE ekey = :ekey  and beid=:beid ", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
			while(!empty($has_key_exchange['ekey']))
			{
							$ekey='U'.date("YmdH",time()).rand(100,999).rand(100,999).rand(100,999).rand(0,9);
							$has_key_exchange = mysqld_select("SELECT * FROM " . table('key_exchange') . " WHERE ekey = :ekey  and beid=:beid", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
			}
		$evalue=iserializer($evalue);
		$evalue=base64_encode($evalue);
			$data=array('ekey'=>$ekey,'evalue'=>$evalue,'createtime'=>TIMESTAMP,'beid'=>$_CMS['beid']);
			mysqld_insert('key_exchange', $data);
			return $ekey;
	}
	return "";
}
function keyexchange_check()
{
	mysqld_query('delete from '. table('key_exchange').' where createtime<:createtime and beid=:beid', array(':createtime'=>TIMESTAMP-(1000*60*5),':beid'=>$_CMS['beid']));//五分钟过期
}
function keyexchange_get_key($ekey)
{
	global $_CMS;
	if(!empty($ekey))
	{
		keyexchange_check();
		$key_exchange = mysqld_select("SELECT * FROM ".table('key_exchange')." where ekey=:ekey and beid=:beid", array(':ekey' => $ekey,':beid'=>$_CMS['beid']));
		if(!empty($key_exchange['ekey']))
		{
			$evalue= $key_exchange['evalue'];
			mysqld_delete('key_exchange', array('ekey'=>$ekey,'beid'=>$_CMS['beid']));
			$evalue=base64_decode($evalue);
			$evalue=iunserializer($evalue);
			return $evalue;
		}
	}
	return "";
}
function show_json($status = 1, $return = '',$isdie=true)
{
    $ret = array(
        'status' => $status
    );
    if (!empty($return)) {
        $ret['result'] = $return;
    }
    if($isdie)
    {
    die(json_encode($ret));
  	}else
  	{
  	return 	json_encode($ret);
  	}
}
function common_qrcode($homeurl)
{
  	include WEB_ROOT.'/includes/lib/phpqrcode/phpqrcode/phpqrcode.php';//引入PHP QR库文件
		$value=$homeurl;
		$errorCorrectionLevel = "L";
		$matrixPointSize = "4";
		$rand_file = date("YmdH",time()).rand(100,999).rand(100,999).rand(100,999).rand(0,9)  . '.png';
		$att_target_file = 'qr-' .$rand_file;
		$qrcode_dir='/cache/qrcode/face/';
		if (!is_dir(WEB_ROOT.$qrcode_dir))
		{
			mkdirs(WEB_ROOT.$qrcode_dir);
		}
		$target_file = WEB_ROOT.$qrcode_dir. $att_target_file;
		
		QRcode::png($value, $target_file, $errorCorrectionLevel, $matrixPointSize);
  	return WEBSITE_ROOT.$qrcode_dir. $att_target_file;
}
function order_finish($type,$paytype,$orderid)
{
	$order = mysqld_select("SELECT * FROM " . table('eshop_order') . " WHERE id =:id and uniacid=:uniacid limit 1", array(':id' => $orderid,":uniacid"=>$GLOBALS['_CMS']['beid']));
	if(empty($order['id']))
	{
		 return false;
	}

	if(!empty($order['status']))
	{
		    return true;	
	}
		$record           = array();
        $record["status"] = "1";
        $record["type"]   = $type;
        pdo_update("core_paylog", $record, array(
            "tid" => $order['ordersn']
        ));
        pdo_update("eshop_order", array(
            "paytype" => $paytype
        ), array(
            "id" => $orderid
        ));
       
       $returnvalue= order_checkorder($orderid);
      if($returnvalue)
      {
      	return true;
      }
  
      return false;
}
function order_checkorder($orderid)
{

global $_W;
$orderid=$orderid;
$uniacid=$_W["uniacid"];
if (empty($orderid)) {
       return false;
}
$order = pdo_fetch("select * from " . tablename("eshop_order") . " where id=:id and uniacid=:uniacid limit 1", array(
        ":id" => $orderid,
        ":uniacid" => $uniacid
    ));
    
    
$core_paylog = pdo_fetch("select * from " . tablename("core_paylog") . " where tid=:tid limit 1", array(
        ":tid" => $order['ordersn']
    ));
    	if(empty($core_paylog['status']))
    	{
       	   return true;
      }	
if (empty($order['id'])) {
        return false;
}
	if($order['status']>=1)
    	{
       	  return true;
      }	
 if ($order['status'] == 0) {
    $pv = p('virtual');
       	     if (!empty($order['virtual']) && $pv) {
       	     	    pdo_update('eshop_order', array(
                            'status' => 1,
                            'paytime' => time()
                        ), array(
                            'id' => $orderid
                        ));
                        
                        $pv->pay($order);
                    } else {
                        pdo_update('eshop_order', array(
                            'status' => 1,
                            'paytime' => time()
                        ), array(
                            'id' => $orderid
                        ));
                     
                       	p('order')->setStocksAndCredits($orderid, 1);
			if ( !empty($order['couponid'])) {
				p('coupon')->backConsumeCoupon($order['id']);
		    	}
                        m('notice')->sendOrderMessage($orderid);
                       
                            p('commission')->checkOrderPay($order['id']);
                        
          
       	 }
       	 $order = pdo_fetch("select status from " . tablename("eshop_order") . " where id=:id and uniacid=:uniacid limit 1", array(
        ":id" => $orderid,
        ":uniacid" => $uniacid
    ));
    	if($order['status']>=1)
    	{
    		checkAgent();
  	    return true;
      }	else{
          	  return false;
      }
     }
      	 return false;
}
function order_checkgoldorder($logid)
{
	global $_W;
	$uniacid=$_W["uniacid"];
	if (empty($logid)) {
	     return false;
	}
$log   = pdo_fetch('SELECT * FROM ' . tablename('eshop_member_log') . ' WHERE `id`=:id and `uniacid`=:uniacid and type=0 limit 1', array(
        ':uniacid' => $uniacid,
        ':id' => $logid
    ));
    if (empty($log)) {
        return false;
}
    if (!empty($log) ) {
      
           
            m('notice')->sendMemberLogMessage($logid);
    }
      return true;
}
function goldorder_finish($orderid)
{
	  $order = mysqld_select("SELECT * FROM " . table('eshop_member_log') . " WHERE id = :id and uniacid=:uniacid limit 1", array(':id' => $orderid,":uniacid"=>$GLOBALS['_CMS']['beid']));
 	if(empty($order['id']))
	{
		 return false;
	}

	if(!empty($order['status']))
	{
		    return true;	
	}
	$openid=$order['openid'];
	       pdo_update('eshop_member_log', array(
                'status' => 1
            ), array(
                'id' => $order['id']
            ));
      member_gold($openid,$order['money'],'addgold',  $order['logno'].'余额支付充值' .$order['money']);
       $credit = 0;
        $set_trade=globalSetting('trade');
        if ($set_trade) {
            $tmoney  = floatval($set_trade['money']);
            $tcredit = intval($set_trade['credit']);
            if ($tmoney > 0) {
                if ($money % $tmoney == 0) {
                    $credit = intval($money / $tmoney) * $tcredit;
                } else {
                    $credit = (intval($money / $tmoney) + 1) * $tcredit;
                }
            }
        }
        if ($credit > 0) {
        	   member_credit($openid,$credit,'addcredit', '会员充值积分:credit2:' . $credit);
          
        }
       
         $returnvalue= order_checkgoldorder($order["id"]);
				    if($returnvalue)
				    {
				    	return true;
				    }
        
  
      return false;
}



function isWeixinPayFinish($out_trade_no,$ordertype)
{
	$payment = mysqld_select("SELECT id,configs FROM " . table('payment') . " WHERE code='wechat' and beid=:beid limit 1",array(":beid"=>$GLOBALS['_CMS']['beid']));
    if(empty($payment['id']))
    {
      return false;
      }
      		$configs=unserialize($payment['configs']);
    	$settings=globalSetting('weixin');
    	
//检查订单是否支付
    $package = array();
		$package['appid'] = $settings['weixin_appId'];
		$package['mch_id'] = $configs['wechat_pay_mchId'];
	
		$package['out_trade_no'] = $out_trade_no;
		
		$package['nonce_str'] = random(8);
				ksort($package, SORT_STRING);
		$string1 = '';
		foreach($package as $key => $v) {
			$string1 .= "{$key}={$v}&";
		}
		$string1 .= "key=".$configs['wechat_pay_paySignKey'];
		$package['sign'] = strtoupper(md5($string1));
		
							$xml = "<xml>";  
        foreach ($package as $key=>$val)
        {
     
        	 if (is_numeric($val))
        	 {
        	 	$xml.="<".$key.">".$val."</".$key.">"; 

        	 }
        	 else
        	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
        }
        $xml.="</xml>";
        				
				$data =http_post("https://api.mch.weixin.qq.com/pay/orderquery",$xml);
					$xml = @simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);

					if(!empty($xml)&&$xml->trade_state=='SUCCESS')
					{
						if(!empty($xml->transaction_id))
						{
						if($ordertype=='order')
						{
							//订单支付
							$out_trade_no=explode('-',$out_trade_no);
				$ordersn = $out_trade_no[0];
							
				pdo_update("eshop_order", array(
            "transid" =>$xml->transaction_id
        ), array(
            "ordersn" => $ordersn
        ));
        
						}
							if($ordertype=='gold')
						{
							//订单支付
				$ordersn = $out_trade_no;
							
							   pdo_update("eshop_member_log", array(
            "transid" =>$xml->transaction_id
        ), array(
            "logno" => $ordersn
        ));
						}
					}
      
      
      
			     return true;
					}	
					return false;
}
function isAliPayFinish($out_trade_no,$ordertype)
{
		$payment = mysqld_select("SELECT id,configs FROM " . table('payment') . " WHERE code='alipay' and beid=:beid limit 1",array(":beid"=>$GLOBALS['_CMS']['beid']));
    if(empty($payment['id'])||empty($out_trade_no))
    {
      return false;
      }
      		$configs=unserialize($payment['configs']);
require_once(WEB_ROOT."/system/modules/plugin/payment/alipay/common.php");
$sysParams=array();
		$sysParams["app_id"] = $configs['alipay_appid'];
		$sysParams["version"] = '1.0';
		$sysParams["format"] = 'json';
		$sysParams["sign_type"] = "RSA";
		$sysParams["method"] = "alipay.trade.query";
		$sysParams["timestamp"] = date("Y-m-d H:i:s");
		$sysParams["charset"] = 'UTF-8';
		$sysParams["biz_content"] = json_encode(array("out_trade_no"=>$out_trade_no));
$sysParams["sign"]=alipay_sign($configs['partner_dev_privatekey'],alipay_getSignContent($sysParams));

		$requestUrl = 'https://openapi.alipay.com/gateway.do' . "?";
		foreach ($sysParams as $sysParamKey => $sysParamValue) {
			$requestUrl .= "$sysParamKey=" . urlencode($sysParamValue) . "&";
		}
		$requestUrl = substr($requestUrl, 0, -1);
		$retuanvalue=http_get($requestUrl);
$result = json_decode($retuanvalue, true);
$result=$result['alipay_trade_query_response'];
					if(!empty($result)&&$result['trade_status']=="TRADE_SUCCESS")
					{
						
						if($ordertype=='order')
						{
							//订单支付
							$out_trade_no=explode('-',$out_trade_no);
				$ordersn = $out_trade_no[0];
							
				pdo_update("eshop_order", array(
            "transid" =>$result['trade_no']
        ), array(
            "ordersn" => $ordersn
        ));
        
						}
							if($ordertype=='gold')
						{
							//订单支付
				$ordersn = $out_trade_no;
							
							   pdo_update("eshop_member_log", array(
            "transid" =>$result['trade_no']
        ), array(
            "logno" => $ordersn
        ));
						}
					
			     return true;
					}	
					return false;
}
function allow_commission()
{
 $cset           = globalSetting('commission');
	 if(empty($cset['commission_limit']))
      {
      	return true;
      }
      if( $cset['commission_limit']==1&&is_weixin())
      {
      return false;	
      } 
         if( $cset['commission_limit']==2)
      {
      	if(strpos($_SERVER['HTTP_USER_AGENT'], 'DingTalk')!=false)
      	{
      	return true;	
      	}
      return false;	
      } 	
	return true;
}
        