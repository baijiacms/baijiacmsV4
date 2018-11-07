<?php 
	if(empty($_GP['wechat_pay_mchId'])||empty($_GP['wechat_pay_paySignKey']))
	{
	message("请填写完整");	
	}
	


$pay_submit_data=array('wechat_pay_mchId'=>
$_GP['wechat_pay_mchId'],'wechat_pay_paySignKey'=>
$_GP['wechat_pay_paySignKey']);

mysqld_update('payment',array('order' => $_GP['pay_order'],'configs'=> serialize($pay_submit_data)) , array('code' => 'wechat',"beid"=>$_CMS['beid']));

	mysqld_update('payment', array('enabled' => '1') , array('code' => 'wechat',"beid"=>$_CMS['beid']));
	
	
?>