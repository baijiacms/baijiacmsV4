<?php 

mysqld_update('payment',array('order' => $_GP['pay_order'],'configs'=> array()) , array('code' => 'credit',"beid"=>$_CMS['beid']));
	mysqld_update('payment', array('enabled' => '1') , array('code' => 'credit',"beid"=>$_CMS['beid']));
?>