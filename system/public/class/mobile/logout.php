<?php

$is_system=$_SESSION[WEB_SESSION_ACCOUNT]['is_system'];
		unset($_SESSION[WEB_SESSION_ACCOUNT]);
		
		unset($_SESSION["addons_check"]);
		unset($_SESSION);
		
session_destroy(); 




		header("location:".create_url('mobile', array('act' => 'public','do' => 'index')));


