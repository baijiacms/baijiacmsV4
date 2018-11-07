<?php 



$pay_submit_data=array('alipay_account'=>
trim($_GP['alipay_account']),'alipay_appid'=>
trim($_GP['alipay_appid']),'partner_dev_privatekey'=>
trim($_GP['wap_dev_privatekey'])
,'partner_alipay_publickey'=>
trim($_GP['wap_alipay_publickey'])
,'wap_dev_privatekey'=>
trim($_GP['wap_dev_privatekey'])
,'wap_alipay_publickey'=>
trim($_GP['wap_alipay_publickey'])
,'alipay_payfee'=>
0,'pay_order'=>
$_GP['pay_order']);

mysqld_update('payment',array('order' => $_GP['pay_order'],'configs'=> serialize($pay_submit_data)) , array("beid"=>$_CMS['beid'],'code' => 'alipay'));


	mysqld_update('payment', array('enabled' => '1') , array("beid"=>$_CMS['beid'],'code' => 'alipay'));
?>