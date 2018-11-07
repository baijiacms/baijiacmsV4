<?php


if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('MemberModel')) {
class MemberModel
{
    public function getInfo($openid = '')
    {
        global $_W;
        $info=member_get($openid);
        if (!empty($info['birthyear']) && !empty($info['birthmonth']) && !empty($info['birthday'])) {
            $info['birthday'] = $info['birthyear'] . '-' . (strlen($info['birthmonth']) <= 1 ? '0' . $info['birthmonth'] : $info['birthmonth']) . '-' . (strlen($info['birthday']) <= 1 ? '0' . $info['birthday'] : $info['birthday']);
        }
        if (empty($info['birthday'])) {
            $info['birthday'] = '';
        }
        return $info;
    }

        public function getMember($openid )
    {
        global $_W,$_CMS;
    	$tmpid=intval($openid );
          if(empty($tmpid))
          {
       	 return member_get($openid);
        }else
        {
        	$member = mysqld_select("SELECT * FROM ".table('eshop_member')." where id=:id and uniacid=:uniacid ", array(':id' => $tmpid,':uniacid'=>$_CMS['beid']));
					
			return $member;
        }
    }
    public function getMid()
    {
        global $_W;
          if(is_login_account()==false)
				{
					return 0;
				}
        $openid = m('user')->getOpenid(true);
        $member = member_get($openid);
        return $member['id'];
    }
   
    public function getCredit($openid = '', $credittype = 'credit1')
    {
        global $_W;
        
     
            return pdo_fetchcolumn("SELECT {$credittype} FROM " . tablename('eshop_member') . " WHERE  openid=:openid and uniacid=:uniacid limit 1", array(
                ':uniacid' => $_W['uniacid'],
                ':openid' => $openid
            ));
    }
    public function getCredits($openid = '', $credittypes = array('credit1', 'credit2'))
    {
        global $_W;
        
        $types = implode(',', $credittypes);
 
            return pdo_fetch("SELECT {$types} FROM " . tablename('eshop_member') . " WHERE  openid=:openid and uniacid=:uniacid limit 1", array(
                ':uniacid' => $_W['uniacid'],
                ':openid' => $openid
            ));
    }
  
    function getLevels()
    {
        global $_W;
        return pdo_fetchall('select * from ' . tablename('eshop_member_level') . ' where uniacid=:uniacid order by level asc', array(
            ':uniacid' => $_W['uniacid']
        ));
    }
    function getLevel($openid)
    {
        global $_W;
        if (empty($openid)) {
            return false;
        }
        $shop   = globalSetting('shop');
        $member = m('member')->getMember($openid);
        if (empty($member['level'])) {
            return array(
            );
        }
        $level = pdo_fetch('select * from ' . tablename('eshop_member_level') . ' where id=:id and uniacid=:uniacid order by level asc', array(
            ':uniacid' => $_W['uniacid'],
            ':id' => $member['level']
        ));
        if (empty($level)) {
            return array(
            );
        }
        return $level;
    }
    function upgradeLevel($openid)
    {
        global $_W;
        if (empty($openid)) {
            return;
        }
        $shopset   =globalSetting('shop');
        $leveltype = intval($shopset['leveltype']);
        $member    = m('member')->getMember($openid);
        if (empty($member)) {
            return;
        }
        $level = false;
        if (empty($leveltype)) {
            $ordermoney = pdo_fetchcolumn('select ifnull( sum(og.realprice),0) from ' . tablename('eshop_order_goods') . ' og ' . ' left join ' . tablename('eshop_order') . ' o on o.id=og.orderid ' . ' where o.openid=:openid and o.status=3 and o.uniacid=:uniacid ', array(
                ':uniacid' => $_W['uniacid'],
                ':openid' => $member['openid']
            ));
            $level      = pdo_fetch('select * from ' . tablename('eshop_member_level') . " where uniacid=:uniacid  and {$ordermoney} >= ordermoney and ordermoney>0  order by level desc limit 1", array(
                ':uniacid' => $_W['uniacid']
            ));
        } else if ($leveltype == 1) {
            $ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_order') . ' where openid=:openid and status=3 and uniacid=:uniacid ', array(
                ':uniacid' => $_W['uniacid'],
                ':openid' => $member['openid']
            ));
            $level      = pdo_fetch('select * from ' . tablename('eshop_member_level') . " where uniacid=:uniacid  and {$ordercount} >= ordercount and ordercount>0  order by level desc limit 1", array(
                ':uniacid' => $_W['uniacid']
            ));
        }
        if (empty($level)) {
            return;
        }
        if ($level['id'] == $member['level']) {
            return;
        }
        $oldlevel   = $this->getLevel($openid);
        $canupgrade = false;
        if (empty($oldlevel['id'])) {
            $canupgrade = true;
        } else {
            if ($level['level'] > $oldlevel['level']) {
                $canupgrade = true;
            }
        }
        if ($canupgrade) {
            pdo_update('eshop_member', array(
                'level' => $level['id']
            ), array(
                'id' => $member['id']
            ));
            m('notice')->sendMemberUpgradeMessage($openid, $oldlevel, $level);
        }
    }
    function getGroups()
    {
        global $_W;
        return pdo_fetchall('select * from ' . tablename('eshop_member_group') . ' where uniacid=:uniacid order by id asc', array(
            ':uniacid' => $_W['uniacid']
        ));
    }
    function getGroup($openid)
    {
        if (empty($openid)) {
            return false;
        }
        $member = m('member')->getMember($openid);
        return $member['groupid'];
    }
    function setRechargeCredit($openid = '', $money = 0)
    {
        if (empty($openid)) {
            return;
        }
        global $_W;
        $credit = 0;
        $set_trade=globalSetting('trade');
        $set_shop=globalSetting('shop');
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
        	   member_credit($openid,$credit,'addcredit',$set_shop['name'] . '会员充值积分:credit2:' . $credit);
          
        }
    }
}
}