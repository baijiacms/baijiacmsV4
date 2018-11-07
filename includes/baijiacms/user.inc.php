<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.baijiacms.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 百家cms <QQ:1987884799> <http://www.baijiacms.com>
// +----------------------------------------------------------------------
defined('SYSTEM_IN') or exit('Access Denied');
define('MOBILE_TEMP_SESSION_ID', SESSION_PREFIX."mobile_sessionAccount");
define('MOBILE_SESSION_ID', SESSION_PREFIX."mobile_account");
define('MOBILE_WEIXIN_OPENID', SESSION_PREFIX."mobile_weixin_openid");
define('MOBILE_USER_SHAREID', SESSION_PREFIX."mobile_user_shareid");

define('TM_COMMISSION_AGENT_NEW', 'commission_agent_new');
define('TM_COMMISSION_ORDER_PAY', 'commission_order_pay');
define('TM_COMMISSION_ORDER_FINISH', 'commission_order_finish');
define('TM_COMMISSION_APPLY', 'commission_apply');
define('TM_COMMISSION_CHECK', 'commission_check');
define('TM_COMMISSION_PAY', 'commission_pay');
define('TM_COMMISSION_UPGRADE', 'commission_upgrade');
define('TM_COMMISSION_BECOME', 'commission_become');
function is_login_account()
{
		if(!empty($_SESSION[MOBILE_SESSION_ID]))
		{
				return true;
		}
		return false;
}
function get_sysopenid($mustlogin)
{
	if(empty($_SESSION[MOBILE_SESSION_ID]))
	{
	
		if($mustlogin)
		{
			tosaveloginfrom();
			header("location:".create_url('mobile',array('act' => 'shopwap','do' => 'login')));	
			exit;
		}
	}

		if(!empty($_SESSION[MOBILE_SESSION_ID]))
		{
				return $_SESSION[MOBILE_SESSION_ID];
		}
		if($mustlogin)
		{
		message('无法获取用户id');	
		}
			if(!empty($_SESSION[MOBILE_TEMP_SESSION_ID]))
		{
				$sessionAccount=$_SESSION[MOBILE_TEMP_SESSION_ID];
		}else
		{
			$t_sessionid='_t'.date("mdHis").rand(10000000,99999999);
			$sessionAccount=$t_sessionid;
			$_SESSION[MOBILE_TEMP_SESSION_ID]=$sessionAccount;
		}
		
		
		return $sessionAccount;
}

function update_member_mobile($openid,$mobile,$toupdate=true)
{
	      global $_CMS;
	      if(!empty($mobile)&&!empty($openid)&&!empty($_CMS['beid']))
	      {
			 	 $member = mysqld_select("SELECT openid,mobile FROM ".table('base_member')." where  mobile=:mobile and beid=:beid  limit 1", array(':beid'=>$_CMS['beid'],':mobile' => $mobile));
					
					if(!empty($member['openid'])&&$member['openid']==$openid&&$member['mobile']==$mobile)
					{
									return 0;//已存在未修改
					}
					
					if(!empty($member['openid'])&&$member['openid']!=$openid)
					{
							return -1;//已存在其他账户使用
					}
					
					if($toupdate)
					{
						if(empty($member['openid'])||$member['openid']==$openid)
						{
							mysqld_update('base_member', array('mobile' => $mobile),array('openid' =>$openid,'beid'=>$_CMS['beid']));
							mysqld_update('eshop_member', array('mobile' => $mobile),array('openid' =>$openid,'uniacid'=>$_CMS['beid']));
							return 1;
						}
					}else
					{
							if(empty($member['openid'])||$member['openid']==$openid)
						{
							return 1;
						}
					}
				}
				return 0;//信息不全未修改
	
}

function get_member_info($openid )
{
        global $_CMS;
        $info = pdo_fetch('select * from ' . tablename('eshop_member') . ' where  openid=:openid and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_CMS['beid'],
                ':openid' => $openid
        ));
        return $info;
}
function member_login($mobile,$pwd)
{
				global $_CMS;
					if(empty($mobile)||empty($pwd))
			{
			return 0;	
			}
	$member = mysqld_select("SELECT * FROM ".table('base_member')." where mobile=:mobile and beid=:beid limit 1", array(':mobile' => $mobile,':beid'=>$_CMS['beid']));

		if(!empty($member['openid']))
		{
			$openid=$member['openid'];
			if($member['status']==-1)
			{
			return -1;	
			}
			if($member['pwd']==md5($pwd))
			{
				save_member_login($openid);
				return $openid;
			}
			
		}
		return '';
}


function gologinfromurl()
{
		if(empty($_SESSION["mobile_login_fromurl"]))
		{
					return create_url('mobile',array('act' => 'shopwap','do' => 'membercenter'));
		}else
		{
			$fromurl=$_SESSION["mobile_login_fromurl"];
			unset($_SESSION["mobile_login_fromurl"]);
			return $fromurl;
		}
	
}
function tosaveloginfrom()
{
$_SESSION["mobile_login_fromurl"]="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";	

}
function clearloginfrom()
{
$_SESSION["mobile_login_fromurl"]="";	
}
function getNewOpenid()
{
	
				$openid='U'.substr(date("Y",TIMESTAMP),-2).date("mdH",TIMESTAMP).rand(100,999).rand(100,999).rand(100,999).rand(0,9);
		  $hasmember = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE openid = :openid  ", array(':openid' => $openid));
			while(!empty($hasmember['openid']))
			{
							$openid='U'.substr(date("Y",TIMESTAMP),-2).date("mdH",TIMESTAMP).rand(100,999).rand(100,999).rand(100,999).rand(0,9);
							 $hasmember = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE openid = :openid  ", array(':openid' => $openid));
			}
			return $openid;
}
function member_create_new($mobile,$pwd)
{
		global $_CMS,$_W;
	if(empty($mobile)||empty($pwd))
	{
				message("信息不全");	
	}
 $hasmember = mysqld_select("SELECT * FROM " . table('base_member') . " WHERE mobile = :mobile and beid=:beid  ", array(':mobile' => $mobile,':beid'=>$_CMS['beid']));
		if(!empty($hasmember['openid']))
		{
		message($mobile."已被注册。");	
		}
			$openid=getNewOpenid();

			if(!empty($pwd))
			{
			$pwd=	md5($pwd);
			}

			$data = array(
					    'mobile' => $mobile,
                    'pwd' =>$pwd,
                    'createtime' => time(),
                    'openid' =>$openid,'beid'=>$_CMS['beid']);
				mysqld_insert('base_member', $data);
				

            
			$data = array(
					    'mobile' => $mobile,
                     'status' => 1,
                    'createtime' => time(),
                    'openid' =>$openid,'uniacid'=>$_CMS['beid']);
				mysqld_insert('eshop_member', $data);		
				return $openid;
}

function save_member_login($openid)
{
		global $_CMS;

		$member = mysqld_select("SELECT * FROM ".table('base_member')." where openid=:openid  and beid=:beid  limit 1", array(':openid' => $openid,':beid'=>$_CMS['beid']));
		if(!empty($member['openid']))
		{
			
			 pdo_update('eshop_member_cart', array( 'openid'=>$member['openid']), array(
                'openid'=>$_SESSION[MOBILE_TEMP_SESSION_ID],'uniacid' => $_CMS['beid']
            ));
			
			$_SESSION[MOBILE_SESSION_ID]=$member['openid'];
			$_SESSION[MOBILE_TEMP_SESSION_ID]=$member['openid'];
			checkAgent(0,$member['openid'],0,false);
			return $member['openid'];
		}
		message("登录失败");
}
function member_logout()
{
		global $_CMS;
		unset($_SESSION["mobile_login_fromurl"]);
	
		
 
		unset($_SESSION[MOBILE_TEMP_SESSION_ID]);
		unset($_SESSION[MOBILE_SESSION_ID]);
		header("location:".create_url('mobile',array('act' => 'center','do' => 'member','m'=>'eshop')));	
		exit;
}


function member_get($openid)
{
		global $_CMS;
		$member = mysqld_select("SELECT * FROM ".table('eshop_member')." where openid=:openid and uniacid=:uniacid ", array(':openid' => $openid,':uniacid'=>$_CMS['beid']));
			
	return $member;
}

function member_credit($openid,$fee,$type,$remark)
{
		global $_CMS;
	$member=member_get($openid);
		if(!empty($member['openid']))
		{
			if(!is_numeric($fee)||$fee<0)
					{
						message("输入数字非法，请重新输入");
					}
			if($type=='addcredit')
			{
			
				 $data= array('remark'=> $remark,'type'=>$type,'fee'=> intval($fee),'account_fee'=>$member['credit1']+$fee,'createtime' => TIMESTAMP,'openid'=>$openid);
				 mysqld_insert('eshop_member_paylog', $data);
		     mysqld_update('eshop_member', array('credit1' => $member['credit1']+$fee,'experience'=> $member['experience']+$fee ), array('openid' => $openid));
		     return true;
			}
			if($type=='usecredit')
			{
				if($member['credit1']>=$fee)
				{
				 $data= array('remark'=> $remark,'type'=>$type,'fee'=> intval($fee),'account_fee'=>$member['credit1']-$fee,'createtime' => TIMESTAMP,'openid'=>$openid);
				 mysqld_insert('eshop_member_paylog', $data);
		     mysqld_update('eshop_member', array('credit1' => $member['credit1']-$fee), array('openid' => $openid));
		      return true;
		    }
			}
		}
		return false;
}
function member_gold($openid,$fee,$type,$remark)
{
		global $_CMS;
			$member=member_get($openid);
	 if(!empty($member['openid']))
		{
			if(!is_numeric($fee)||$fee<0)
					{
					
				return false;
					}	
			if($type=='addgold')
			{
				 $data= array('remark'=> $remark,'type'=>$type,'fee'=> $fee,'account_fee' => $member['credit2']+$fee,'createtime' => TIMESTAMP,'openid'=>$openid,'beid'=>$_CMS['beid']);
				 mysqld_insert('eshop_member_paylog', $data);
		     mysqld_update('eshop_member', array('credit2' => $member['credit2']+$fee), array('openid' => $openid));
		       return true;
			}
			if($type=='usegold')
			{
				if($member['credit2']>=$fee)
				{
				 $data= array('remark'=> $remark,'type'=>$type,'fee'=> $fee,'account_fee' => $member['credit2']-$fee,'createtime' => TIMESTAMP,'openid'=>$openid,'beid'=>$_CMS['beid']);
				 mysqld_insert('eshop_member_paylog', $data);
		     mysqld_update('eshop_member', array('credit2' => $member['credit2']-$fee), array('openid' => $openid));
		       return true;
		    }
			}
		}
		return false;
}
function monitorAgent($shareid=0,$openid='',$needlogin=true)
{
  global $_CMS, $_GP;
  if(empty($shareid))
  {
  $shareid=$_SESSION[MOBILE_USER_SHAREID];
  if(($needlogin==true&&is_login_account()==false)||empty($shareid))
			{
				return;
			}
	}
			
			$set  = globalSetting('commission');
			if (empty($set['level'])) {
				return;
			}
			if($needlogin==true&&empty($openid))
 		 {
			$openid = get_sysopenid(true);
		}
			if (empty($openid)) {
				return;
			}
			$member = get_member_info($openid);
			if (empty($member)||!empty($member['isagent'])) {
				return;
			}
     $parent = false;
     $mid    = $shareid; 
     if (!empty($mid)) {
        $parent = get_member_info($mid);
      }
      if (!empty($parent['openid'])) {
      	if($parent['isagent'] == 0 || $parent['status'] == 0)
      	{
				return;
				}
			}
		
			if($member['fixagentid'] == 1|| ($member['id'] == $parent['id']) )
			{
			return;	
			}
                if ($parent['openid'] != $openid) {
                    $clickcount = pdo_fetchcolumn('select count(id) from ' . tablename('eshop_commission_clickcount') . ' where uniacid=:uniacid and openid=:openid and from_openid=:from_openid limit 1', array(
                        ':uniacid' => $_CMS['beid'],
                        ':openid' => $openid,
                        ':from_openid' => $parent['openid']
                    ));
                    if ($clickcount <= 0) {
                        $click = array(
                            'uniacid' => $_CMS['beid'],
                            'openid' => $openid,
                            'from_openid' => $parent['openid'],
                            'clicktime' => time()
                        );
                        pdo_insert('eshop_commission_clickcount', $click);
                        pdo_update('eshop_member', array(
                            'clickcount' => $parent['clickcount'] + 1
                        ), array(
                            'uniacid' => $_CMS['beid'],
                            'id' => $parent['id']
                        ));
                    }
                }
     
   
     $time = time();
			$become_child = intval($set['become_child']);
			  if ( empty($member['agentid'])) {
                if ($member['id'] != $parent['id']) {
                    if (empty($become_child)) {
                    		if (empty($member['fixagentid'])) {
                        pdo_update('eshop_member', array(
                            'agentid' => $parent['id'],
                            'childtime' => $time
                        ), array(
                            'uniacid' => $_CMS['beid'],
                            'id' => $member['id']
                        ));
                        $commission_set = globalSetting('commission');
												if(empty($commission_set['level']))
												{
													return;
												}
												$send_dat=array(
                            'nickname' => $member['nickname'],
                            'childtime' => $time
                        );
											  p('commission')->sendMessage($parent['openid'], $send_data, TM_COMMISSION_AGENT_NEW);

                        p('commission')->upgradeLevelByAgent($parent['id']);
                        
                        
                 		  }
                    } else {
                        pdo_update('eshop_member', array(
                            'inviter' => $parent['id']
                        ), array(
                            'uniacid' => $_CMS['beid'],
                            'id' => $member['id']
                        ));
                    }
                }
            }
      
		
}
function checkAgent($shareid=0,$openid='',$posterid=0,$needlogin=true)
{
$set  = globalSetting('commission');
if (empty($set['level'])) {
				return;
}
monitorAgent($shareid,$openid,$needlogin);	
checkUpAgent($shareid,$openid,$needlogin);
checkScan($shareid,$openid,$posterid,$needlogin);
}
function checkUpAgent($shareid=0,$openid='',$needlogin=true)
{
		  global $_CMS, $_GP;
 if($needlogin==true&&empty($openid))
  {
			if(is_login_account()==false)
			{
				return;
			}

	$openid = get_sysopenid(true);
	}

			if (empty($openid)) {
				return;
			}
			$member = get_member_info($openid);
			if (empty($member)||!empty($member['isagent'])) {
				return;
			}
			   $time = TIMESTAMP;
			$set  = globalSetting('commission');
			$condition_status=1;
					if(!empty($set['become_order']))
								{
									$condition_status=3;
								}
			$become_check = intval($set['become_check']);
						$changeagent=false;
			    if (empty($set['become'])) {
                if (empty($member['agentblack'])) {
                 $changeagent=true;
                }
            }	
            	
        	if ($set['become'] == '3'&&empty($member['isagent'])) {
        		if(!empty($set['become_moneycount']))
        		{
							$eshop_order = pdo_fetchcolumn('select sum(o.price) from '  . tablename('eshop_order') . ' o where o.openid=:openid and o.status>=:status and o.uniacid=:uniacid limit 1', array(':status'=>$condition_status,':uniacid' => $_CMS['beid'], ':openid' => $member['openid']));
							$changeagent = $eshop_order >= floatval($set['become_moneycount']);
						}
							if($changeagent==false&&!empty($set['become_xmoneycount']))
							{
								
									$_t1_realprice = pdo_fetchcolumn('select o.price from '  . tablename('eshop_order') . ' o where o.openid=:openid and o.status>=:status and o.uniacid=:uniacid order by o.price desc limit 1', array(':status'=>$condition_status,':uniacid' => $_CMS['beid'], ':openid' => $member['openid']));
									$changeagent= $_t1_realprice >= floatval($set['become_xmoneycount']);
							}
						}
							
						  if ($set['become'] == '2') {
                            $ordercount = pdo_fetchcolumn('select count(id) from ' . tablename('eshop_order') . ' where openid=:openid and status>=:status and uniacid=:uniacid limit 1', array(
                                ':status'=>$condition_status,':uniacid' => $_CMS['beid'],
                                ':openid' => $member['openid']
                            ));
                            
                            $changeagent        = $ordercount >= intval($set['become_ordercount']);
                        }
             			  if ($set['become'] == '4') {
                            $ordercount = pdo_fetchcolumn('select count(eog.id) from ' . tablename('eshop_order_goods') . ' eog left join ' . tablename('eshop_order') . ' eshop_order on eog.orderid=eshop_order.id where eshop_order.openid=:openid and eog.goodsid=:goodsid and eshop_order.status>=:status and eog.uniacid=:uniacid', array(
                               ':status'=>$condition_status, ':uniacid' => $_CMS['beid'],
                                ':goodsid' => $set['become_goodsid'],
                                ':openid' => $member['openid']
                            ));
                            $changeagent        = $ordercount >= 1;
                        }
                     
             if($changeagent)
             {
                pdo_update('eshop_member', array(
                        'isagent' => 1,
                        'status' => $become_check,
                        'agenttime' => $time
                    ), array(
                        'uniacid' => $_CMS['beid'],
                        'id' => $member['id']
                    ));
                    if ($become_check == 1) {
                       	$send_data=array(
                            'nickname' => $member['nickname'],
                            'agenttime' => $time
                        );
                        
                        $commission_set = globalSetting('commission');
												if(empty($commission_set['level']))
												{
													return;
												}
                        
                        p('commission')->sendMessage($openid, $send_data, TM_COMMISSION_BECOME);

                        if (!empty($parent['id'])) {
													$this->upgradeLevelByAgent($parent['id']);
												}
                    }
           }
	
}
function checkScan($shareid=0,$openid='',$posterid=0,$needlogin=true)
{

		//	unset($_SESSION[MOBILE_USER_SHAREID]);
            global $_CMS, $_GP;
            
            if(empty($posterid))
            {
            $posterid=$_GP['posterid'];
            }
 if(empty($shareid))
	{
	  $shareid=$_SESSION[MOBILE_USER_SHAREID];
	if(($needlogin==true&&is_login_account()==false)||empty($shareid)||empty($posterid))
			{
				return;
			}
		}
		 if($needlogin==true&&empty($openid))
	{
            $openid   =get_sysopenid(true);
            
          }
            $posterid = intval($posterid);
            if (empty($posterid)) {
                return;
            }
            $poster = pdo_fetch('select id,times from ' . tablename('eshop_poster') . ' where id=:id and uniacid=:uniacid limit 1', array(
                ':uniacid' => $_CMS['beid'],
                ':id' => $posterid
            ));
            if (empty($poster)) {
                return;
            }
            $mid = $shareid;
            if (empty($mid)) {
                return;
            }
            $parent = get_member_info($mid);
            if (empty($parent)) {
                return;
            }
            $from_openid=$parent['openid'];
            
            if ($openid == $from_openid) {
                return;
            }
            $scancount = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_poster_scan') . ' where openid=:openid  and posterid=:posterid and uniacid=:uniacid limit 1', array(
                ':openid' => $openid,
                ':posterid' => $poster['id'],
                ':uniacid' => $_CMS['beid']
            ));
            if ($scancount <= 0) {
                $scan = array(
                    'uniacid' => $_CMS['beid'],
                    'posterid' => $poster['id'],
                    'openid' => $openid,
                    'from_openid' => $from_openid,
                    'scantime' => time()
                );
                pdo_insert('eshop_poster_scan', $scan);
                pdo_update('eshop_poster', array(
                    'times' => $poster['times'] + 1
                ), array(
                    'id' => $poster['id']
                ));
            }
}