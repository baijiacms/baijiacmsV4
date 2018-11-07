<?php
		if(class_exists("ZipArchive")==false)
		{
		message("在线更新需要zip的支持，您的php环境不支持zip功能，请修改配置。");	
		}
		$core_version=http_get("http://update.baijiacms.com/baijiacmsv4/update/core_version.html");
		$sapp_version=http_get("http://update.baijiacms.com/baijiacmsv4/update/sapp_version.html");
		$update_logjs=http_get("http://update.baijiacms.com/baijiacmsv4/update/update_log.html");
		$has_update=0;
		if(empty($core_version)||empty($sapp_version))
		{
			$has_update=0;
		}else
		{
			$local_core_version=intval(CORE_VERSION);
			$net_core_version=intval($core_version);
			if($local_core_version<$net_core_version)
			{
		$has_update=1;

				 if (checksubmit("submit")) {
	$newfile=http_get("http://update.baijiacms.com/baijiacmsv4/update/get_newfile.html");
	if(empty($newfile))
	{
	message("没有找到可用更新","refresh","error");	
	}

	mkdirs(WEB_ROOT . '/cache/update/');
	$tmpfile = WEB_ROOT . '/cache/update/'.$newfile;
		$extention = pathinfo($tmpfile, PATHINFO_EXTENSION);
	$extention=strtolower($extention);
		if($extention!='zip')
	{
	message("没有找到可用更新","refresh","error");	
	}
	
	$fp = fopen($tmpfile, 'w+');
	if(!$fp) {
			message("cache文件夹读写失败，请检查该文件夹权限");	
	}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://update.baijiacms.com/baijiacmsv4/update/version/".$newfile);
	curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
	if(!curl_exec($ch)) {
			message("下载更新补丁失败，请稍后再试！","refresh","error");	
	}
	curl_close($ch);
	fclose($fp);
	$newfilemd5=http_get("http://update.baijiacms.com/baijiacmsv4/update/get_newfile_md5.html");
	$md5file = md5_file($tmpfile);
	if(empty($md5file)||strtoupper($newfilemd5)!=strtoupper($md5file))
	{
	message($md5file."文件完整性检查失败，下载文件不完整！您可以手动下载离线文件解压替换进行更新！<br>离线文件地址：http://update.baijiacms.com/baijiacmsv4/update/version/".$newfile);	
	}
	$zip = new ZipArchive; 
 $res = $zip->open($tmpfile); 
 if ($res === TRUE) { 
    $zip->extractTo(WEB_ROOT); 
     $zip->close(); 
 } else { 
 	message("下载补丁解压安装失败。");
 } 
	
	message("已更新完成！系统正在退出，请重新登录系统！",create_url('mobile',array('act' => 'public','do' => 'logout')),"success");	
}
			}else
			{
						$has_update=2;
			}
			
		
		}
include page("online_update");