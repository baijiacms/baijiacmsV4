<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

if (!class_exists('CommissionModel')) {
	class CommissionModel
	{
		
 			public function getSet($key='commission')
        {
                  return globalSetting($key);
        }
		public function calculate($_var_1 = 0, $_var_2 = true)
		{
			global $_W;
			$set = $this->getSet();
			$_var_3 = $this->getLevels();
			$_var_4 = pdo_fetchcolumn('select agentid from ' . tablename('eshop_order') . ' where id=:id limit 1', array(':id' => $_var_1));
			$_var_5 = pdo_fetchall('select og.id,og.realprice,og.total,g.hascommission,g.nocommission, g.commission1_rate,g.commission1_pay,g.commission2_rate,g.commission2_pay,g.commission3_rate,g.commission3_pay,og.commissions from ' . tablename('eshop_order_goods') . '  og ' . ' left join ' . tablename('eshop_goods') . ' g on g.id = og.goodsid' . ' where og.orderid=:orderid and og.uniacid=:uniacid', array(':orderid' => $_var_1, ':uniacid' => $_W['uniacid']));
			if ($set['level'] > 0) {
				foreach ($_var_5 as &$_var_6) {
					$_var_7 = $_var_6['realprice'];
					if (empty($_var_6['nocommission'])) {
						if ($_var_6['hascommission'] == 1) {
							$_var_6['commission1'] = array('default' => $set['level'] >= 1 ? ($_var_6['commission1_rate'] > 0 ? round($_var_6['commission1_rate'] * $_var_7 / 100, 2) . "" : round($_var_6['commission1_pay'] * $_var_6['total'], 2)) : 0);
							$_var_6['commission2'] = array('default' => $set['level'] >= 2 ? ($_var_6['commission2_rate'] > 0 ? round($_var_6['commission2_rate'] * $_var_7 / 100, 2) . "" : round($_var_6['commission2_pay'] * $_var_6['total'], 2)) : 0);
							$_var_6['commission3'] = array('default' => $set['level'] >= 3 ? ($_var_6['commission3_rate'] > 0 ? round($_var_6['commission3_rate'] * $_var_7 / 100, 2) . "" : round($_var_6['commission3_pay'] * $_var_6['total'], 2)) : 0);
							foreach ($_var_3 as $level) {
								$_var_6['commission1']['level' . $level['id']] = $_var_6['commission1_rate'] > 0 ? round($_var_6['commission1_rate'] * $_var_7 / 100, 2) . "" : round($_var_6['commission1_pay'] * $_var_6['total'], 2);
								$_var_6['commission2']['level' . $level['id']] = $_var_6['commission2_rate'] > 0 ? round($_var_6['commission2_rate'] * $_var_7 / 100, 2) . "" : round($_var_6['commission2_pay'] * $_var_6['total'], 2);
								$_var_6['commission3']['level' . $level['id']] = $_var_6['commission3_rate'] > 0 ? round($_var_6['commission3_rate'] * $_var_7 / 100, 2) . "" : round($_var_6['commission3_pay'] * $_var_6['total'], 2);
							}
						} else {
							$_var_6['commission1'] = array('default' => $set['level'] >= 1 ? round($set['commission1'] * $_var_7 / 100, 2) . "" : 0);
							$_var_6['commission2'] = array('default' => $set['level'] >= 2 ? round($set['commission2'] * $_var_7 / 100, 2) . "" : 0);
							$_var_6['commission3'] = array('default' => $set['level'] >= 3 ? round($set['commission3'] * $_var_7 / 100, 2) . "" : 0);
							foreach ($_var_3 as $level) {
								$_var_6['commission1']['level' . $level['id']] = $set['level'] >= 1 ? round($level['commission1'] * $_var_7 / 100, 2) . "" : 0;
								$_var_6['commission2']['level' . $level['id']] = $set['level'] >= 2 ? round($level['commission2'] * $_var_7 / 100, 2) . "" : 0;
								$_var_6['commission3']['level' . $level['id']] = $set['level'] >= 3 ? round($level['commission3'] * $_var_7 / 100, 2) . "" : 0;
							}
						}
					} else {
						$_var_6['commission1'] = array('default' => 0);
						$_var_6['commission2'] = array('default' => 0);
						$_var_6['commission3'] = array('default' => 0);
						foreach ($_var_3 as $level) {
							$_var_6['commission1']['level' . $level['id']] = 0;
							$_var_6['commission2']['level' . $level['id']] = 0;
							$_var_6['commission3']['level' . $level['id']] = 0;
						}
					}
					if ($_var_2) {
						$commissions = array('level1' => 0, 'level2' => 0, 'level3' => 0);
						if (!empty($_var_4)) {
							$_var_10 = m('member')->getMember($_var_4);
							if ($_var_10['isagent'] == 1 && $_var_10['status'] == 1) {
								$_var_11 = $this->getLevel($_var_10['openid']);
								$commissions['level1'] = empty($_var_11) ? round($_var_6['commission1']['default'], 2) : round($_var_6['commission1']['level' . $_var_11['id']], 2);
								if (!empty($_var_10['agentid'])) {
									$_var_12 = m('member')->getMember($_var_10['agentid']);
									$_var_13 = $this->getLevel($_var_12['openid']);
									$commissions['level2'] = empty($_var_13) ? round($_var_6['commission2']['default'], 2) : round($_var_6['commission2']['level' . $_var_13['id']], 2);
									if (!empty($_var_12['agentid'])) {
										$_var_14 = m('member')->getMember($_var_12['agentid']);
										$_var_15 = $this->getLevel($_var_14['openid']);
										$commissions['level3'] = empty($_var_15) ? round($_var_6['commission3']['default'], 2) : round($_var_6['commission3']['level' . $_var_15['id']], 2);
									}
								}
							}
						}
						pdo_update('eshop_order_goods', array('commission1' => iserializer($_var_6['commission1']), 'commission2' => iserializer($_var_6['commission2']), 'commission3' => iserializer($_var_6['commission3']), 'commissions' => iserializer($commissions), 'nocommission' => $_var_6['nocommission']), array('id' => $_var_6['id']));
					}
				}
				unset($_var_6);
			}
			return $_var_5;
		}

		public function getOrderCommissions($_var_1 = 0, $_var_16 = 0)
		{
			global $_W;
			$set = $this->getSet();
			$_var_4 = pdo_fetchcolumn('select agentid from ' . tablename('eshop_order') . ' where id=:id limit 1', array(':id' => $_var_1));
			$_var_5 = pdo_fetch('select commission1,commission2,commission3 from ' . tablename('eshop_order_goods') . ' where id=:id and orderid=:orderid and uniacid=:uniacid and nocommission=0 limit 1', array(':id' => $_var_16, ':orderid' => $_var_1, ':uniacid' => $_W['uniacid']));
			$commissions = array('level1' => 0, 'level2' => 0, 'level3' => 0);
			if ($set['level'] > 0) {
				$_var_17 = iunserializer($_var_5['commission1']);
				$_var_18 = iunserializer($_var_5['commission2']);
				$_var_19 = iunserializer($_var_5['commission3']);
				if (!empty($_var_4)) {
					$_var_10 = m('member')->getMember($_var_4);
					if ($_var_10['isagent'] == 1 && $_var_10['status'] == 1) {
						$_var_11 = $this->getLevel($_var_10['openid']);
						$commissions['level1'] = empty($_var_11) ? round($_var_17['default'], 2) : round($_var_17['level' . $_var_11['id']], 2);
						if (!empty($_var_10['agentid'])) {
							$_var_12 = m('member')->getMember($_var_10['agentid']);
							$_var_13 = $this->getLevel($_var_12['openid']);
							$commissions['level2'] = empty($_var_13) ? round($_var_18['default'], 2) : round($_var_18['level' . $_var_13['id']], 2);
							if (!empty($_var_12['agentid'])) {
								$_var_14 = m('member')->getMember($_var_12['agentid']);
								$_var_15 = $this->getLevel($_var_14['openid']);
								$commissions['level3'] = empty($_var_15) ? round($_var_19['default'], 2) : round($_var_19['level' . $_var_15['id']], 2);
							}
						}
					}
				}
			}
			return $commissions;
		}

		public function getInfo($openid, $options = null)
		{
			if (empty($options) || !is_array($options)) {
				$options = array();
			}
			global $_W;
			$set = $this->getSet();
			$level = intval($set['level']);
			$member = m('member')->getMember($openid);
			$agentLevel = $this->getLevel($openid);
			$time = time();
			$day_times = intval($set['settledays']) * 3600 * 24;
			$agentcount = 0;
			$ordercount0 = 0;
			$ordermoney0 = 0;
			$ordercount = 0;
			$ordermoney = 0;
			$ordercount3 = 0;
			$ordermoney3 = 0;
			$commission_total = 0;
			$commission_ok = 0;
			$commission_apply = 0;
			$commission_check = 0;
			$commission_lock = 0;
			$commission_pay = 0;
			$level1 = 0;
			$level2 = 0;
			$level3 = 0;
			$order10 = 0;
			$order20 = 0;
			$order30 = 0;
			$order1 = 0;
			$order2 = 0;
			$order3 = 0;
			$order13 = 0;
			$order23 = 0;
			$order33 = 0;
			$order13money = 0;
			$order23money = 0;
			$order33money = 0;
			if ($level >= 1) {
				if (in_array('ordercount0', $options)) {
					$_var_54 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid=:agentid and o.status>=0 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					$order10 += $_var_54['ordercount'];
					$ordercount0 += $_var_54['ordercount'];
					$ordermoney0 += $_var_54['ordermoney'];
				}
				if (in_array('ordercount', $options)) {
					$_var_54 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid=:agentid and o.status>=1 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					$order1 += $_var_54['ordercount'];
					$ordercount += $_var_54['ordercount'];
					$ordermoney += $_var_54['ordermoney'];
				}
				if (in_array('ordercount3', $options)) {
					$_var_55 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid=:agentid and o.status>=3 and og.status1>=0 and og.nocommission=0 and o.uniacid=:uniacid  limit 1', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					$order13 += $_var_55['ordercount'];
					$ordercount3 += $_var_55['ordercount'];
					$ordermoney3 += $_var_55['ordermoney'];
					$order13money += $_var_55['ordermoney'];
				}
				if (in_array('total', $options)) {
					$_var_56 = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					foreach ($_var_56 as $_var_57) {
						$commissions = iunserializer($_var_57['commissions']);
						$_var_58 = iunserializer($_var_57['commission1']);
						if (empty($commissions)) {
							$commission_total += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
						} else {
							$commission_total += isset($commissions['level1']) ? floatval($commissions['level1']) : 0;
						}
					}
				}
				if (in_array('ok', $options)) {
					$_var_56 = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . " where o.agentid=:agentid and o.status>=3 and og.nocommission=0 and ({$time} - o.createtime > {$day_times}) and og.status1=0  and o.uniacid=:uniacid", array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					foreach ($_var_56 as $_var_57) {
						$commissions = iunserializer($_var_57['commissions']);
						$_var_58 = iunserializer($_var_57['commission1']);
						if (empty($commissions)) {
							$commission_ok += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
						} else {
							$commission_ok += isset($commissions['level1']) ? $commissions['level1'] : 0;
						}
					}
				}
				if (in_array('lock', $options)) {
					$_var_59 = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . " where o.agentid=:agentid and o.status>=3 and og.nocommission=0 and ({$time} - o.createtime <= {$day_times})  and og.status1=0  and o.uniacid=:uniacid", array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					foreach ($_var_59 as $_var_57) {
						$commissions = iunserializer($_var_57['commissions']);
						$_var_58 = iunserializer($_var_57['commission1']);
						if (empty($commissions)) {
							$commission_lock += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
						} else {
							$commission_lock += isset($commissions['level1']) ? $commissions['level1'] : 0;
						}
					}
				}
				if (in_array('apply', $options)) {
					$_var_60 = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.status1=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					foreach ($_var_60 as $_var_57) {
						$commissions = iunserializer($_var_57['commissions']);
						$_var_58 = iunserializer($_var_57['commission1']);
						if (empty($commissions)) {
							$commission_apply += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
						} else {
							$commission_apply += isset($commissions['level1']) ? $commissions['level1'] : 0;
						}
					}
				}
				if (in_array('check', $options)) {
					$_var_60 = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.status1=2 and og.nocommission=0 and o.uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					foreach ($_var_60 as $_var_57) {
						$commissions = iunserializer($_var_57['commissions']);
						$_var_58 = iunserializer($_var_57['commission1']);
						if (empty($commissions)) {
							$commission_check += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
						} else {
							$commission_check += isset($commissions['level1']) ? $commissions['level1'] : 0;
						}
					}
				}
				if (in_array('pay', $options)) {
					$_var_60 = pdo_fetchall('select og.commission1,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid=:agentid and o.status>=3 and og.status1=3 and og.nocommission=0 and o.uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']));
					foreach ($_var_60 as $_var_57) {
						$commissions = iunserializer($_var_57['commissions']);
						$_var_58 = iunserializer($_var_57['commission1']);
						if (empty($commissions)) {
							$commission_pay += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
						} else {
							$commission_pay += isset($commissions['level1']) ? $commissions['level1'] : 0;
						}
					}
				}
				$level1_agentids = pdo_fetchall('select id from ' . tablename('eshop_member') . ' where agentid=:agentid and isagent=1 and status=1 and uniacid=:uniacid ', array(':uniacid' => $_W['uniacid'], ':agentid' => $member['id']), 'id');
				$level1 = count($level1_agentids);
				$agentcount += $level1;
			}
			if ($level >= 2) {
				if ($level1 > 0) {
					if (in_array('ordercount0', $options)) {
						$_var_62 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ')  and o.status>=0 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
						$order20 += $_var_62['ordercount'];
						$ordercount0 += $_var_62['ordercount'];
						$ordermoney0 += $_var_62['ordermoney'];
					}
					if (in_array('ordercount', $options)) {
						$_var_62 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ')  and o.status>=1 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
						$order2 += $_var_62['ordercount'];
						$ordercount += $_var_62['ordercount'];
						$ordermoney += $_var_62['ordermoney'];
					}
					if (in_array('ordercount3', $options)) {
						$_var_63 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct o.id) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ')  and o.status>=3 and og.status2>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
						$order23 += $_var_63['ordercount'];
						$ordercount3 += $_var_63['ordercount'];
						$ordermoney3 += $_var_63['ordermoney'];
						$order23money += $_var_63['ordermoney'];
					}
					if (in_array('total', $options)) {
						$_var_64 = pdo_fetchall('select og.commission2,og.commissions from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ')  and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_64 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission2']);
							if (empty($commissions)) {
								$commission_total += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_total += isset($commissions['level2']) ? $commissions['level2'] : 0;
							}
						}
					}
					if (in_array('ok', $options)) {
						$_var_64 = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ")  and ({$time} - o.createtime > {$day_times}) and o.status>=3 and og.status2=0 and og.nocommission=0  and o.uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
						foreach ($_var_64 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission2']);
							if (empty($commissions)) {
								$commission_ok += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_ok += isset($commissions['level2']) ? $commissions['level2'] : 0;
							}
						}
					}
					if (in_array('lock', $options)) {
						$_var_65 = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ")  and ({$time} - o.createtime <= {$day_times}) and og.status2=0 and o.status>=3 and og.nocommission=0 and o.uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
						foreach ($_var_65 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission2']);
							if (empty($commissions)) {
								$commission_lock += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_lock += isset($commissions['level2']) ? $commissions['level2'] : 0;
							}
						}
					}
					if (in_array('apply', $options)) {
						$_var_66 = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ')  and o.status>=3 and og.status2=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_66 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission2']);
							if (empty($commissions)) {
								$commission_apply += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_apply += isset($commissions['level2']) ? $commissions['level2'] : 0;
							}
						}
					}
					if (in_array('check', $options)) {
						$_var_67 = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ')  and o.status>=3 and og.status2=2 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_67 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission2']);
							if (empty($commissions)) {
								$commission_check += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_check += isset($commissions['level2']) ? $commissions['level2'] : 0;
							}
						}
					}
					if (in_array('pay', $options)) {
						$_var_67 = pdo_fetchall('select og.commission2,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid ' . ' where o.agentid in( ' . implode(',', array_keys($level1_agentids)) . ')  and o.status>=3 and og.status2=3 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_67 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission2']);
							if (empty($commissions)) {
								$commission_pay += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_pay += isset($commissions['level2']) ? $commissions['level2'] : 0;
							}
						}
					}
					$level2_agentids = pdo_fetchall('select id from ' . tablename('eshop_member') . ' where agentid in( ' . implode(',', array_keys($level1_agentids)) . ') and isagent=1 and status=1 and uniacid=:uniacid', array(':uniacid' => $_W['uniacid']), 'id');
					$level2 = count($level2_agentids);
					$agentcount += $level2;
				}
			}
			if ($level >= 3) {
				if ($level2 > 0) {
					if (in_array('ordercount0', $options)) {
						$_var_69 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ')  and o.status>=0 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
						$order30 += $_var_69['ordercount'];
						$ordercount0 += $_var_69['ordercount'];
						$ordermoney0 += $_var_69['ordermoney'];
					}
					if (in_array('ordercount', $options)) {
						$_var_69 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ')  and o.status>=1 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
						$order3 += $_var_69['ordercount'];
						$ordercount += $_var_69['ordercount'];
						$ordermoney += $_var_69['ordermoney'];
					}
					if (in_array('ordercount3', $options)) {
						$_var_70 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ')  and o.status>=3 and og.status3>=0 and og.nocommission=0 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid']));
						$order33 += $_var_70['ordercount'];
						$ordercount3 += $_var_70['ordercount'];
						$ordermoney3 += $_var_70['ordermoney'];
						$order33money += $_var_69['ordermoney'];
					}
					if (in_array('total', $options)) {
						$_var_71 = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ')  and o.status>=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_71 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission3']);
							if (empty($commissions)) {
								$commission_total += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_total += isset($commissions['level3']) ? $commissions['level3'] : 0;
							}
						}
					}
					if (in_array('ok', $options)) {
						$_var_71 = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ")  and ({$time} - o.createtime > {$day_times}) and o.status>=3 and og.status3=0  and og.nocommission=0 and o.uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
						foreach ($_var_71 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission3']);
							if (empty($commissions)) {
								$commission_ok += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_ok += isset($commissions['level3']) ? $commissions['level3'] : 0;
							}
						}
					}
					if (in_array('lock', $options)) {
						$_var_72 = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ")  and o.status>=3 and ({$time} - o.createtime > {$day_times}) and og.status3=0  and og.nocommission=0 and o.uniacid=:uniacid", array(':uniacid' => $_W['uniacid']));
						foreach ($_var_72 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission3']);
							if (empty($commissions)) {
								$commission_lock += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_lock += isset($commissions['level3']) ? $commissions['level3'] : 0;
							}
						}
					}
					if (in_array('apply', $options)) {
						$_var_73 = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ')  and o.status>=3 and og.status3=1 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_73 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission3']);
							if (empty($commissions)) {
								$commission_apply += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_apply += isset($commissions['level3']) ? $commissions['level3'] : 0;
							}
						}
					}
					if (in_array('check', $options)) {
						$_var_74 = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ')  and o.status>=3 and og.status3=2 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_74 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission3']);
							if (empty($commissions)) {
								$commission_check += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_check += isset($commissions['level3']) ? $commissions['level3'] : 0;
							}
						}
					}
					if (in_array('pay', $options)) {
						$_var_74 = pdo_fetchall('select og.commission3,og.commissions  from ' . tablename('eshop_order_goods') . ' og ' . ' left join  ' . tablename('eshop_order') . ' o on o.id = og.orderid' . ' where o.agentid in( ' . implode(',', array_keys($level2_agentids)) . ')  and o.status>=3 and og.status3=3 and og.nocommission=0 and o.uniacid=:uniacid', array(':uniacid' => $_W['uniacid']));
						foreach ($_var_74 as $_var_57) {
							$commissions = iunserializer($_var_57['commissions']);
							$_var_58 = iunserializer($_var_57['commission3']);
							if (empty($commissions)) {
								$commission_pay += isset($_var_58['level' . $agentLevel['id']]) ? $_var_58['level' . $agentLevel['id']] : $_var_58['default'];
							} else {
								$commission_pay += isset($commissions['level3']) ? $commissions['level3'] : 0;
							}
						}
					}
					$level3_agentids = pdo_fetchall('select id from ' . tablename('eshop_member') . ' where uniacid=:uniacid and agentid in( ' . implode(',', array_keys($level2_agentids)) . ') and isagent=1 and status=1', array(':uniacid' => $_W['uniacid']), 'id');
					$level3 = count($level3_agentids);
					$agentcount += $level3;
				}
			}
			$member['agentcount'] = $agentcount;
			$member['ordercount'] = $ordercount;
			$member['ordermoney'] = $ordermoney;
			$member['order1'] = $order1;
			$member['order2'] = $order2;
			$member['order3'] = $order3;
			$member['ordercount3'] = $ordercount3;
			$member['ordermoney3'] = $ordermoney3;
			$member['order13'] = $order13;
			$member['order23'] = $order23;
			$member['order33'] = $order33;
			$member['order13money'] = $order13money;
			$member['order23money'] = $order23money;
			$member['order33money'] = $order33money;
			$member['ordercount0'] = $ordercount0;
			$member['ordermoney0'] = $ordermoney0;
			$member['order10'] = $order10;
			$member['order20'] = $order20;
			$member['order30'] = $order30;
			$member['commission_total'] = round($commission_total, 2);
			$member['commission_ok'] = round($commission_ok, 2);
			$member['commission_lock'] = round($commission_lock, 2);
			$member['commission_apply'] = round($commission_apply, 2);
			$member['commission_check'] = round($commission_check, 2);
			$member['commission_pay'] = round($commission_pay, 2);
			$member['level1'] = $level1;
			$member['level1_agentids'] = $level1_agentids;
			$member['level2'] = $level2;
			$member['level2_agentids'] = $level2_agentids;
			$member['level3'] = $level3;
			$member['level3_agentids'] = $level3_agentids;
			if(empty($member['agenttime']))
			{
			if(!empty($member['isagent']))
			{
				$member['agenttime'] = time();
				mysqld_update("eshop_member",array("agenttime"=>$member['agenttime']),array('uniacid' => $_W['uniacid'],'id'=>$member['id']));
			}
			}
			$member['agenttime'] = date('Y-m-d H:i', $member['agenttime']);
			return $member;
		}

		public function getAgents($_var_1 = 0)
		{
			global $_W, $_GPC;
			$_var_76 = array();
			$_var_77 = pdo_fetch('select id,agentid,openid from ' . tablename('eshop_order') . ' where id=:id and uniacid=:uniacid limit 1', array(':id' => $_var_1, ':uniacid' => $_W['uniacid']));
			if (empty($_var_77)) {
				return $_var_76;
			}
			$_var_10 = m('member')->getMember($_var_77['agentid']);
			if (!empty($_var_10) && $_var_10['isagent'] == 1 && $_var_10['status'] == 1) {
				$_var_76[] = $_var_10;
				if (!empty($_var_10['agentid'])) {
					$_var_12 = m('member')->getMember($_var_10['agentid']);
					if (!empty($_var_12) && $_var_12['isagent'] == 1 && $_var_12['status'] == 1) {
						$_var_76[] = $_var_12;
						if (!empty($_var_12['agentid'])) {
							$_var_14 = m('member')->getMember($_var_12['agentid']);
							if (!empty($_var_14) && $_var_14['isagent'] == 1 && $_var_14['status'] == 1) {
								$_var_76[] = $_var_14;
							}
						}
					}
				}
			}
			return $_var_76;
		}

		public function isAgent($openid)
		{
			if (empty($openid)) {
				return false;
			}
			if (is_array($openid)) {
				return $openid['isagent'] == 1 && $openid['status'] == 1;
			}
			$member = m('member')->getMember($openid);
			return $member['isagent'] == 1 && $member['status'] == 1;
		}

		public function getCommission($_var_5)
		{
			global $_W;
			$set = $this->getSet();
			$_var_58 = 0;
			if ($_var_5['hascommission'] == 1) {
				$_var_58 = $set['level'] >= 1 ? ($_var_5['commission1_rate'] > 0 ? ($_var_5['commission1_rate'] * $_var_5['marketprice'] / 100) : $_var_5['commission1_pay']) : 0;
			} else {
				$openid = m('user')->getOpenid(true);
				$level = $this->getLevel($openid);
				if (!empty($level)) {
					$_var_58 = $set['level'] >= 1 ? round($level['commission1'] * $_var_5['marketprice'] / 100, 2) : 0;
				} else {
					$_var_58 = $set['level'] >= 1 ? round($set['commission1'] * $_var_5['marketprice'] / 100, 2) : 0;
				}
			}
			return $_var_58;
		}

	
		private function createImage($level1)
		{

			$level4 = http_get($level1);
			return imagecreatefromstring($level4);
		}

		public function createGoodsImage($_var_5, $level5)
		{
			global $_W, $_GPC;
			$_var_5 = set_medias($_var_5, 'thumb');
			$openid = m('user')->getOpenid(true);
			$level6 = m('member')->getMember($openid);
			$level7 = $level6;
			$level0 = IA_ROOT . '/addons/eshop/data/poster/' . $_W['uniacid'] . '/';
			if (!is_dir($level0)) {
		
				mkdirs($level0);
			}
			$level8 = empty($_var_5['commission_thumb']) ? $_var_5['thumb'] : tomedia($_var_5['commission_thumb']);
			$level9 = md5(json_encode(array('id' => $_var_5['id'], 'marketprice' => $_var_5['marketprice'], 'productprice' => $_var_5['productprice'], 'img' => $level8, 'openid' => $openid, 'version' => 4)));
			$level2 = $level9 . '.jpg';
			if (!is_file($level0 . $level2)) {
				set_time_limit(0);
				$commissions0 = IA_ROOT . '/assets/eshop/static/fonts/msyh.ttf';
				$commissions1 = imagecreatetruecolor(640, 1225);
				$commissions2 = imagecreatefromjpeg(IA_ROOT . '/assets/eshop/static/mobile/static/commission/images/poster.jpg');
				imagecopy($commissions1, $commissions2, 0, 0, 0, 0, 640, 1225);
				imagedestroy($commissions2);
				$commissions3 = preg_replace('/\\/0$/i', '/96', $level7['avatar']);
				$commissions4 = $this->createImage($commissions3);
				$commissions5 = imagesx($commissions4);
				$commissions6 = imagesy($commissions4);
				imagecopyresized($commissions1, $commissions4, 24, 32, 0, 0, 88, 88, $commissions5, $commissions6);
				imagedestroy($commissions4);
				$commissions7 = $this->createImage($level8);
				$commissions5 = imagesx($commissions7);
				$commissions6 = imagesy($commissions7);
				imagecopyresized($commissions1, $commissions7, 0, 160, 0, 0, 640, 640, $commissions5, $commissions6);
				imagedestroy($commissions7);
				$commissions8 = imagecreatetruecolor(640, 127);
				imagealphablending($commissions8, false);
				imagesavealpha($commissions8, true);
				$commissions9 = imagecolorallocatealpha($commissions8, 0, 0, 0, 25);
				imagefill($commissions8, 0, 0, $commissions9);
				imagecopy($commissions1, $commissions8, 0, 678, 0, 0, 640, 127);
				imagedestroy($commissions8);
				$_var_100 = tomedia(m('qrcode')->createGoodsQrcode($level7['id'], $_var_5['id']));
				$_var_101 = $this->createImage($_var_100);
				$commissions5 = imagesx($_var_101);
				$commissions6 = imagesy($_var_101);
				imagecopyresized($commissions1, $_var_101, 50, 835, 0, 0, 250, 250, $commissions5, $commissions6);
				imagedestroy($_var_101);
				$_var_102 = imagecolorallocate($commissions1, 0, 3, 51);
				$_var_103 = imagecolorallocate($commissions1, 240, 102, 0);
				$_var_104 = imagecolorallocate($commissions1, 255, 255, 255);
				$_var_105 = imagecolorallocate($commissions1, 255, 255, 0);
				$_var_106 = '我是';
				imagettftext($commissions1, 20, 0, 150, 70, $_var_102, $commissions0, $_var_106);
				imagettftext($commissions1, 20, 0, 210, 70, $_var_103, $commissions0, $level7['nickname']);
				$_var_107 = '我要为';
				imagettftext($commissions1, 20, 0, 150, 105, $_var_102, $commissions0, $_var_107);
				$_var_108 = $level5['name'];
				imagettftext($commissions1, 20, 0, 240, 105, $_var_103, $commissions0, $_var_108);
				$_var_109 = imagettfbbox(20, 0, $commissions0, $_var_108);
				$_var_110 = $_var_109[4] - $_var_109[6];
				$_var_111 = '代言';
				imagettftext($commissions1, 20, 0, 240 + $_var_110 + 10, 105, $_var_102, $commissions0, $_var_111);
				$_var_112 = mb_substr($_var_5['title'], 0, 50, 'utf-8');
				imagettftext($commissions1, 20, 0, 30, 730, $_var_104, $commissions0, $_var_112);
				$_var_113 = '￥' . number_format($_var_5['marketprice'], 2);
				imagettftext($commissions1, 25, 0, 25, 780, $_var_105, $commissions0, $_var_113);
				$_var_109 = imagettfbbox(26, 0, $commissions0, $_var_113);
				$_var_110 = $_var_109[4] - $_var_109[6];
				if ($_var_5['productprice'] > 0) {
					$_var_114 = '￥' . number_format($_var_5['productprice'], 2);
					imagettftext($commissions1, 22, 0, 25 + $_var_110 + 10, 780, $_var_104, $commissions0, $_var_114);
					$_var_115 = 25 + $_var_110 + 10;
					$_var_109 = imagettfbbox(22, 0, $commissions0, $_var_114);
					$_var_110 = $_var_109[4] - $_var_109[6];
					imageline($commissions1, $_var_115, 770, $_var_115 + $_var_110 + 20, 770, $_var_104);
					imageline($commissions1, $_var_115, 771.5, $_var_115 + $_var_110 + 20, 771, $_var_104);
				}
				imagejpeg($commissions1, $level0 . $level2);
				imagedestroy($commissions1);
			}
			return $_W['siteroot'] . 'cache/data/poster/' . $_W['uniacid'] . '/' . $level2;
		}

	
		public function checkOrderConfirm($_var_1 = '0')
		{
			global $_W, $_GPC;
			if (empty($_var_1)) {
				return;
			}
			$set = $this->getSet();
			if (empty($set['level'])) {
				return;
			}
			$_var_77 = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime from ' . tablename('eshop_order') . ' where id=:id and status>=0 and uniacid=:uniacid limit 1', array(':id' => $_var_1, ':uniacid' => $_W['uniacid']));
			if (empty($_var_77)) {
				return;
			}
			$openid = $_var_77['openid'];
			$member = m('member')->getMember($openid);
			if (empty($member)) {
				return;
			}
			$_var_123 = intval($set['become_child']);
			$_var_117 = false;
			if (empty($_var_123)) {
				$_var_117 = m('member')->getMember($member['agentid']);
			} else {
				$_var_117 = m('member')->getMember($member['inviter']);
			}
			$_var_118 = !empty($_var_117) && $_var_117['isagent'] == 1 && $_var_117['status'] == 1;
			$time = time();
			$_var_123 = intval($set['become_child']);
			if ($_var_118) {
				if ($_var_123 == 1) {
					if (empty($member['agentid']) && $member['id'] != $_var_117['id']) {
						if (empty($member['fixagentid'])) {
							$member['agentid'] = $_var_117['id'];
							pdo_update('eshop_member', array('agentid' => $_var_117['id'], 'childtime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
							$this->sendMessage($_var_117['openid'], array('nickname' => $member['nickname'], 'childtime' => $time), TM_COMMISSION_AGENT_NEW);
							$this->upgradeLevelByAgent($_var_117['id']);
						}
					}
				}
			}
			$_var_4 = $member['agentid'];
			if ($member['isagent'] == 1 && $member['status'] == 1) {
				if (!empty($set['selfbuy'])) {
					$_var_4 = $member['id'];
				}
			}
			if (!empty($_var_4)) {
				pdo_update('eshop_order', array('agentid' => $_var_4), array('id' => $_var_1));
			}
			$this->calculate($_var_1);
		}

		public function checkOrderPay($_var_1 = '0')
		{
			global $_W, $_GPC;
			if (empty($_var_1)) {
				return;
			}
			$set = $this->getSet();
			if (empty($set['level'])) {
				return;
			}
			$_var_77 = pdo_fetch('select id,openid,ordersn,goodsprice,agentid,paytime from ' . tablename('eshop_order') . ' where id=:id and status>=1 and uniacid=:uniacid limit 1', array(':id' => $_var_1, ':uniacid' => $_W['uniacid']));
			if (empty($_var_77)) {
				return;
			}
			$openid = $_var_77['openid'];
			$member = m('member')->getMember($openid);
			if (empty($member)) {
				return;
			}
			$_var_123 = intval($set['become_child']);
			$_var_117 = false;
			if (empty($_var_123)) {
				$_var_117 = m('member')->getMember($member['agentid']);
			} else {
				$_var_117 = m('member')->getMember($member['inviter']);
			}
			$_var_118 = !empty($_var_117) && $_var_117['isagent'] == 1 && $_var_117['status'] == 1;
			$time = time();
			$_var_123 = intval($set['become_child']);
			if ($_var_118) {
				if ($_var_123 == 2) {
					if (empty($member['agentid']) && $member['id'] != $_var_117['id']) {
						if (empty($member['fixagentid'])) {
							$member['agentid'] = $_var_117['id'];
							pdo_update('eshop_member', array('agentid' => $_var_117['id'], 'childtime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
							$this->sendMessage($_var_117['openid'], array('nickname' => $member['nickname'], 'childtime' => $time), TM_COMMISSION_AGENT_NEW);
							$this->upgradeLevelByAgent($_var_117['id']);
							if (empty($_var_77['agentid'])) {
								$_var_77['agentid'] = $_var_117['id'];
								pdo_update('eshop_order', array('agentid' => $_var_117['id']), array('id' => $_var_1));
								$this->calculate($_var_1);
							}
						}
					}
				}
			}
			$_var_125 = $member['isagent'] == 1 && $member['status'] == 1;
			if (!$_var_125 && empty($set['become_order'])) {
				$time = time();
				if ($set['become'] == 2 || $set['become'] == 3) {
					$_var_126 = true;
					if (!empty($member['agentid'])) {
						$_var_117 = m('member')->getMember($member['agentid']);
						if (empty($_var_117) || $_var_117['isagent'] != 1 || $_var_117['status'] != 1) {
							$_var_126 = false;
						}
					}
					if ($_var_126) {
						$_var_127 = false;
						if ($set['become'] == '2') {
							$ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_order') . ' where openid=:openid and status>=1 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
							$_var_127 = $ordercount >= intval($set['become_ordercount']);
						} else if ($set['become'] == '3') {
							$_var_128 = pdo_fetchcolumn('select sum(og.realprice) from ' . tablename('eshop_order_goods') . ' og left join ' . tablename('eshop_order') . ' o on og.orderid=o.id  where o.openid=:openid and o.status>=1 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
							$_var_127 = $_var_128 >= floatval($set['become_moneycount']);
						}
						if ($_var_127) {
							if (empty($member['agentblack'])) {
								$_var_124 = intval($set['become_check']);
								pdo_update('eshop_member', array('status' => $_var_124, 'isagent' => 1, 'agenttime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
								if ($_var_124 == 1) {
									$this->sendMessage($openid, array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);
									if ($_var_126) {
										$this->upgradeLevelByAgent($_var_117['id']);
									}
								}
							}
						}
					}
				}
			}
			if (!empty($member['agentid'])) {
				$_var_117 = m('member')->getMember($member['agentid']);
				if (!empty($_var_117) && $_var_117['isagent'] == 1 && $_var_117['status'] == 1) {
					if ($_var_77['agentid'] == $_var_117['id']) {
						$_var_129 = pdo_fetchall('select g.id,g.title,og.total,og.price,og.realprice, og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1 from ' . tablename('eshop_order_goods') . ' og ' . ' left join ' . tablename('eshop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $_var_77['id']));
						$_var_5 = '';
						$level = $_var_117['agentlevel'];
						$commission_total = 0;
						$_var_130 = 0;
						foreach ($_var_129 as $_var_131) {
							$_var_5 .= "" . $_var_131['title'] . '( ';
							if (!empty($_var_131['optiontitle'])) {
								$_var_5 .= ' 规格: ' . $_var_131['optiontitle'];
							}
							$_var_5 .= ' 单价: ' . ($_var_131['realprice'] / $_var_131['total']) . ' 数量: ' . $_var_131['total'] . ' 总价: ' . $_var_131['realprice'] . '); ';
							$_var_58 = iunserializer($_var_131['commission1']);
							$commission_total += isset($_var_58['level' . $level]) ? $_var_58['level' . $level] : $_var_58['default'];
							$_var_130 += $_var_131['realprice'];
						}
						$this->sendMessage($_var_117['openid'], array('nickname' => $member['nickname'], 'ordersn' => $_var_77['ordersn'], 'price' => $_var_130, 'goods' => $_var_5, 'commission' => $commission_total, 'paytime' => $_var_77['paytime'],), TM_COMMISSION_ORDER_PAY);
					}
				}
			}
		}

		public function checkOrderFinish($_var_1 = '')
		{
			global $_W, $_GPC;
			if (empty($_var_1)) {
				return;
			}
			$_var_77 = pdo_fetch('select id,openid, ordersn,goodsprice,agentid,finishtime from ' . tablename('eshop_order') . ' where id=:id and status>=3 and uniacid=:uniacid limit 1', array(':id' => $_var_1, ':uniacid' => $_W['uniacid']));
			if (empty($_var_77)) {
				return;
			}
			$set = $this->getSet();
			if (empty($set['level'])) {
				return;
			}
			$openid = $_var_77['openid'];
			$member = m('member')->getMember($openid);
			if (empty($member)) {
				return;
			}
			$time = time();
			$_var_125 = $member['isagent'] == 1 && $member['status'] == 1;
			if (!$_var_125 && $set['become_order'] == 1) {
				if ($set['become'] == 2 || $set['become'] == 3) {
					$_var_126 = true;
					if (!empty($member['agentid'])) {
						$_var_117 = m('member')->getMember($member['agentid']);
						if (empty($_var_117) || $_var_117['isagent'] != 1 || $_var_117['status'] != 1) {
							$_var_126 = false;
						}
					}
					if ($_var_126) {
						$_var_127 = false;
						if ($set['become'] == '2') {
							$ordercount = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
							$_var_127 = $ordercount >= intval($set['become_ordercount']);
						} else if ($set['become'] == '3') {
							$_var_128 = pdo_fetchcolumn('select sum(goodsprice) from ' . tablename('eshop_order') . ' where openid=:openid and status>=3 and uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
							$_var_127 = $_var_128 >= floatval($set['become_moneycount']);
						}
						if ($_var_127) {
							if (empty($member['agentblack'])) {
								$_var_124 = intval($set['become_check']);
								pdo_update('eshop_member', array('status' => $_var_124, 'isagent' => 1, 'agenttime' => $time), array('uniacid' => $_W['uniacid'], 'id' => $member['id']));
								if ($_var_124 == 1) {
									$this->sendMessage($member['openid'], array('nickname' => $member['nickname'], 'agenttime' => $time), TM_COMMISSION_BECOME);
									if ($_var_126) {
										$this->upgradeLevelByAgent($_var_117['id']);
									}
								}
							}
						}
					}
				}
			}
			if (!empty($member['agentid'])) {
				$_var_117 = m('member')->getMember($member['agentid']);
				if (!empty($_var_117) && $_var_117['isagent'] == 1 && $_var_117['status'] == 1) {
					if ($_var_77['agentid'] == $_var_117['id']) {
						$_var_129 = pdo_fetchall('select g.id,g.title,og.total,og.realprice,og.price,og.optionname as optiontitle,g.noticeopenid,g.noticetype,og.commission1 from ' . tablename('eshop_order_goods') . ' og ' . ' left join ' . tablename('eshop_goods') . ' g on g.id=og.goodsid ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $_W['uniacid'], ':orderid' => $_var_77['id']));
						$_var_5 = '';
						$level = $_var_117['agentlevel'];
						$commission_total = 0;
						$_var_130 = 0;
						foreach ($_var_129 as $_var_131) {
							$_var_5 .= "" . $_var_131['title'] . '( ';
							if (!empty($_var_131['optiontitle'])) {
								$_var_5 .= ' 规格: ' . $_var_131['optiontitle'];
							}
							$_var_5 .= ' 单价: ' . ($_var_131['realprice'] / $_var_131['total']) . ' 数量: ' . $_var_131['total'] . ' 总价: ' . $_var_131['realprice'] . '); ';
							$_var_58 = iunserializer($_var_131['commission1']);
							$commission_total += isset($_var_58['level' . $level]) ? $_var_58['level' . $level] : $_var_58['default'];
							$_var_130 += $_var_131['realprice'];
						}
						$this->sendMessage($_var_117['openid'], array('nickname' => $member['nickname'], 'ordersn' => $_var_77['ordersn'], 'price' => $_var_130, 'goods' => $_var_5, 'commission' => $commission_total, 'finishtime' => $_var_77['finishtime'],), TM_COMMISSION_ORDER_FINISH);
					}
				}
			}
			$this->upgradeLevelByOrder($openid);
		}

		function getShop($_var_132)
		{
			global $_W;
			$member = m('member')->getMember($_var_132);
			$_var_133 = pdo_fetch('select * from ' . tablename('eshop_commission_shop') . ' where uniacid=:uniacid and mid=:mid limit 1', array(':uniacid' => $_W['uniacid'], ':mid' => $member['id']));
			$set = m('common')->getSysset('shop');
			$_var_135 = m('common')->getSysset('share');
			$_var_136 = $_var_135['desc'];
			if (empty($_var_136)) {
				$_var_136 = $set['description'];
			}
			if (empty($_var_136)) {
				$_var_136 = $set['name'];
			}
			$_var_137 = $this->getSet();
			if (empty($_var_133)) {
				$_var_133 = array('name' => $member['nickname'] . '的小店', 'logo' => $member['avatar'], 'desc' => $_var_136, 'img' => tomedia($set['img']),);
			} else {
				if (empty($_var_133['name'])) {
					$_var_133['name'] = $member['nickname'] . '的小店' ;
				}
				if (empty($_var_133['logo'])) {
					$_var_133['logo'] = tomedia($member['avatar']);
				}
				if (empty($_var_133['img'])) {
					$_var_133['img'] = tomedia($set['img']);
				}
				if (empty($_var_133['desc'])) {
					$_var_133['desc'] = $_var_136;
				}
			}
			return $_var_133;
		}

		function getLevels($_var_138 = true)
		{
			global $_W;
			if ($_var_138) {
				return pdo_fetchall('select * from ' . tablename('eshop_commission_level') . ' where uniacid=:uniacid order by commission1 asc', array(':uniacid' => $_W['uniacid']));
			} else {
				return pdo_fetchall('select * from ' . tablename('eshop_commission_level') . ' where uniacid=:uniacid and (ordermoney>0 or commissionmoney>0) order by commission1 asc', array(':uniacid' => $_W['uniacid']));
			}
		}

		function getLevel($openid)
		{
			global $_W;
			if (empty($openid)) {
				return false;
			}
			$member = m('member')->getMember($openid);
			if (empty($member['agentlevel'])) {
				return false;
			}
			$level = pdo_fetch('select * from ' . tablename('eshop_commission_level') . ' where uniacid=:uniacid and id=:id limit 1', array(':uniacid' => $_W['uniacid'], ':id' => $member['agentlevel']));
			return $level;
		}

		function upgradeLevelByOrder($openid)
		{
			global $_W;
			if (empty($openid)) {
				return false;
			}
			$set = $this->getSet();
			if (empty($set['level'])) {
				return false;
			}
			$_var_132 = m('member')->getMember($openid);
			if (empty($_var_132)) {
				return;
			}
			$_var_139 = intval($set['leveltype']);
			if ($_var_139 == 4 || $_var_139 == 5) {
				if (!empty($_var_132['agentnotupgrade'])) {
					return;
				}
				$_var_140 = $this->getLevel($_var_132['openid']);
				if (empty($_var_140['id'])) {
					$_var_140 = array('levelname' => empty($set['levelname']) ? '普通等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);
				}
				$_var_141 = pdo_fetch('select sum(og.realprice) as ordermoney,count(distinct og.orderid) as ordercount from ' . tablename('eshop_order') . ' o ' . ' left join  ' . tablename('eshop_order_goods') . ' og on og.orderid=o.id ' . ' where o.openid=:openid and o.status>=3 and o.uniacid=:uniacid limit 1', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
				$ordermoney = $_var_141['ordermoney'];
				$ordercount = $_var_141['ordercount'];
				if ($_var_139 == 4) {
					$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$ordermoney} >= ordermoney and ordermoney>0  order by ordermoney desc limit 1", array(':uniacid' => $_W['uniacid']));
					if (empty($_var_142)) {
						return;
					}
					if (!empty($_var_140['id'])) {
						if ($_var_140['id'] == $_var_142['id']) {
							return;
						}
						if ($_var_140['ordermoney'] > $_var_142['ordermoney']) {
							return;
						}
					}
				} else if ($_var_139 == 5) {
					$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$ordercount} >= ordercount and ordercount>0  order by ordercount desc limit 1", array(':uniacid' => $_W['uniacid']));
					if (empty($_var_142)) {
						return;
					}
					if (!empty($_var_140['id'])) {
						if ($_var_140['id'] == $_var_142['id']) {
							return;
						}
						if ($_var_140['ordercount'] > $_var_142['ordercount']) {
							return;
						}
					}
				}
				pdo_update('eshop_member', array('agentlevel' => $_var_142['id']), array('id' => $_var_132['id']));
				$this->sendMessage($_var_132['openid'], array('nickname' => $_var_132['nickname'], 'oldlevel' => $_var_140, 'newlevel' => $_var_142,), TM_COMMISSION_UPGRADE);
			} else if ($_var_139 >= 0 && $_var_139 <= 3) {
				$_var_76 = array();
				if (!empty($set['selfbuy'])) {
					$_var_76[] = $_var_132;
				}
				if (!empty($_var_132['agentid'])) {
					$_var_10 = m('member')->getMember($_var_132['agentid']);
					if (!empty($_var_10)) {
						$_var_76[] = $_var_10;
						if (!empty($_var_10['agentid']) && $_var_10['isagent'] == 1 && $_var_10['status'] == 1) {
							$_var_12 = m('member')->getMember($_var_10['agentid']);
							if (!empty($_var_12) && $_var_12['isagent'] == 1 && $_var_12['status'] == 1) {
								$_var_76[] = $_var_12;
								if (empty($set['selfbuy'])) {
									if (!empty($_var_12['agentid']) && $_var_12['isagent'] == 1 && $_var_12['status'] == 1) {
										$_var_14 = m('member')->getMember($_var_12['agentid']);
										if (!empty($_var_14) && $_var_14['isagent'] == 1 && $_var_14['status'] == 1) {
											$_var_76[] = $_var_14;
										}
									}
								}
							}
						}
					}
				}
				if (empty($_var_76)) {
					return;
				}
				foreach ($_var_76 as $_var_143) {
					$_var_144 = $this->getInfo($_var_143['id'], array('ordercount3', 'ordermoney3', 'order13money', 'order13'));
					if (!empty($_var_144['agentnotupgrade'])) {
						continue;
					}
					$_var_140 = $this->getLevel($_var_143['openid']);
					if (empty($_var_140['id'])) {
						$_var_140 = array('levelname' => empty($set['levelname']) ? '普通等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);
					}
					if ($_var_139 == 0) {
						$ordermoney = $_var_144['ordermoney3'];
						$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid and {$ordermoney} >= ordermoney and ordermoney>0  order by ordermoney desc limit 1", array(':uniacid' => $_W['uniacid']));
						if (empty($_var_142)) {
							continue;
						}
						if (!empty($_var_140['id'])) {
							if ($_var_140['id'] == $_var_142['id']) {
								continue;
							}
							if ($_var_140['ordermoney'] > $_var_142['ordermoney']) {
								continue;
							}
						}
					} else if ($_var_139 == 1) {
						$ordermoney = $_var_144['order13money'];
						$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid and {$ordermoney} >= ordermoney and ordermoney>0  order by ordermoney desc limit 1", array(':uniacid' => $_W['uniacid']));
						if (empty($_var_142)) {
							continue;
						}
						if (!empty($_var_140['id'])) {
							if ($_var_140['id'] == $_var_142['id']) {
								continue;
							}
							if ($_var_140['ordermoney'] > $_var_142['ordermoney']) {
								continue;
							}
						}
					} else if ($_var_139 == 2) {
						$ordercount = $_var_144['ordercount3'];
						$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$ordercount} >= ordercount and ordercount>0  order by ordercount desc limit 1", array(':uniacid' => $_W['uniacid']));
						if (empty($_var_142)) {
							continue;
						}
						if (!empty($_var_140['id'])) {
							if ($_var_140['id'] == $_var_142['id']) {
								continue;
							}
							if ($_var_140['ordercount'] > $_var_142['ordercount']) {
								continue;
							}
						}
					} else if ($_var_139 == 3) {
						$ordercount = $_var_144['order13'];
						$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$ordercount} >= ordercount and ordercount>0  order by ordercount desc limit 1", array(':uniacid' => $_W['uniacid']));
						if (empty($_var_142)) {
							continue;
						}
						if (!empty($_var_140['id'])) {
							if ($_var_140['id'] == $_var_142['id']) {
								continue;
							}
							if ($_var_140['ordercount'] > $_var_142['ordercount']) {
								continue;
							}
						}
					}
					pdo_update('eshop_member', array('agentlevel' => $_var_142['id']), array('id' => $_var_143['id']));
					$this->sendMessage($_var_143['openid'], array('nickname' => $_var_143['nickname'], 'oldlevel' => $_var_140, 'newlevel' => $_var_142,), TM_COMMISSION_UPGRADE);
				}
			}
		}

		function upgradeLevelByAgent($openid)
		{
			global $_W;
			if (empty($openid)) {
				return false;
			}
			$set = $this->getSet();
			if (empty($set['level'])) {
				return false;
			}
			$_var_132 = m('member')->getMember($openid);
			if (empty($_var_132)) {
				return;
			}
			$_var_139 = intval($set['leveltype']);
			if ($_var_139 < 6 || $_var_139 > 9) {
				return;
			}
			$_var_144 = $this->getInfo($_var_132['id'], array());
			if ($_var_139 == 6 || $_var_139 == 8) {
				$_var_76 = array($_var_132);
				if (!empty($_var_132['agentid'])) {
					$_var_10 = m('member')->getMember($_var_132['agentid']);
					if (!empty($_var_10)) {
						$_var_76[] = $_var_10;
						if (!empty($_var_10['agentid']) && $_var_10['isagent'] == 1 && $_var_10['status'] == 1) {
							$_var_12 = m('member')->getMember($_var_10['agentid']);
							if (!empty($_var_12) && $_var_12['isagent'] == 1 && $_var_12['status'] == 1) {
								$_var_76[] = $_var_12;
							}
						}
					}
				}
				if (empty($_var_76)) {
					return;
				}
				foreach ($_var_76 as $_var_143) {
					$_var_144 = $this->getInfo($_var_143['id'], array());
					if (!empty($_var_144['agentnotupgrade'])) {
						continue;
					}
					$_var_140 = $this->getLevel($_var_143['openid']);
					if (empty($_var_140['id'])) {
						$_var_140 = array('levelname' => empty($set['levelname']) ? '普通等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);
					}
					if ($_var_139 == 6) {
						$_var_145 = pdo_fetchall('select id from ' . tablename('eshop_member') . ' where agentid=:agentid and uniacid=:uniacid ', array(':agentid' => $_var_132['id'], ':uniacid' => $_W['uniacid']), 'id');
						$_var_146 += count($_var_145);
						if (!empty($_var_145)) {
							$_var_147 = pdo_fetchall('select id from ' . tablename('eshop_member') . ' where agentid in( ' . implode(',', array_keys($_var_145)) . ') and uniacid=:uniacid', array(':uniacid' => $_W['uniacid']), 'id');
							$_var_146 += count($_var_147);
							if (!empty($_var_147)) {
								$_var_148 = pdo_fetchall('select id from ' . tablename('eshop_member') . ' where agentid in( ' . implode(',', array_keys($_var_147)) . ') and uniacid=:uniacid', array(':uniacid' => $_W['uniacid']), 'id');
								$_var_146 += count($_var_148);
							}
						}
						$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$_var_146} >= downcount and downcount>0  order by downcount desc limit 1", array(':uniacid' => $_W['uniacid']));
					} else if ($_var_139 == 8) {
						$_var_146 = $_var_144['level1'] + $_var_144['level2'] + $_var_144['level3'];
						$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$_var_146} >= downcount and downcount>0  order by downcount desc limit 1", array(':uniacid' => $_W['uniacid']));
					}
					if (empty($_var_142)) {
						continue;
					}
					if ($_var_142['id'] == $_var_140['id']) {
						continue;
					}
					if (!empty($_var_140['id'])) {
						if ($_var_140['downcount'] > $_var_142['downcount']) {
							continue;
						}
					}
					pdo_update('eshop_member', array('agentlevel' => $_var_142['id']), array('id' => $_var_143['id']));
					$this->sendMessage($_var_143['openid'], array('nickname' => $_var_143['nickname'], 'oldlevel' => $_var_140, 'newlevel' => $_var_142,), TM_COMMISSION_UPGRADE);
				}
			} else {
				if (!empty($_var_132['agentnotupgrade'])) {
					return;
				}
				$_var_140 = $this->getLevel($_var_132['openid']);
				if (empty($_var_140['id'])) {
					$_var_140 = array('levelname' => empty($set['levelname']) ? '普通等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);
				}
				if ($_var_139 == 7) {
					$_var_146 = pdo_fetchcolumn('select count(*) from ' . tablename('eshop_member') . ' where agentid=:agentid and uniacid=:uniacid ', array(':agentid' => $_var_132['id'], ':uniacid' => $_W['uniacid']));
					$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$_var_146} >= downcount and downcount>0  order by downcount desc limit 1", array(':uniacid' => $_W['uniacid']));
				} else if ($_var_139 == 9) {
					$_var_146 = $_var_144['level1'];
					$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$_var_146} >= downcount and downcount>0  order by downcount desc limit 1", array(':uniacid' => $_W['uniacid']));
				}
				if (empty($_var_142)) {
					return;
				}
				if ($_var_142['id'] == $_var_140['id']) {
					return;
				}
				if (!empty($_var_140['id'])) {
					if ($_var_140['downcount'] > $_var_142['downcount']) {
						return;
					}
				}
				pdo_update('eshop_member', array('agentlevel' => $_var_142['id']), array('id' => $_var_132['id']));
				$this->sendMessage($_var_132['openid'], array('nickname' => $_var_132['nickname'], 'oldlevel' => $_var_140, 'newlevel' => $_var_142,), TM_COMMISSION_UPGRADE);
			}
		}

		function upgradeLevelByCommissionOK($openid)
		{
			global $_W;
			if (empty($openid)) {
				return false;
			}
			$set = $this->getSet();
			if (empty($set['level'])) {
				return false;
			}
			$_var_132 = m('member')->getMember($openid);
			if (empty($_var_132)) {
				return;
			}
			$_var_139 = intval($set['leveltype']);
			if ($_var_139 != 10) {
				return;
			}
			if (!empty($_var_132['agentnotupgrade'])) {
				return;
			}
			$_var_140 = $this->getLevel($_var_132['openid']);
			if (empty($_var_140['id'])) {
				$_var_140 = array('levelname' => empty($set['levelname']) ? '普通等级' : $set['levelname'], 'commission1' => $set['commission1'], 'commission2' => $set['commission2'], 'commission3' => $set['commission3']);
			}
			$_var_144 = $this->getInfo($_var_132['id'], array('pay'));
			$_var_149 = $_var_144['commission_pay'];
			$_var_142 = pdo_fetch('select * from ' . tablename('eshop_commission_level') . " where uniacid=:uniacid  and {$_var_149} >= commissionmoney and commissionmoney>0  order by commissionmoney desc limit 1", array(':uniacid' => $_W['uniacid']));
			if (empty($_var_142)) {
				return;
			}
			if ($_var_140['id'] == $_var_142['id']) {
				return;
			}
			if (!empty($_var_140['id'])) {
				if ($_var_140['commissionmoney'] > $_var_142['commissionmoney']) {
					return;
				}
			}
			pdo_update('eshop_member', array('agentlevel' => $_var_142['id']), array('id' => $_var_132['id']));
			$this->sendMessage($_var_132['openid'], array('nickname' => $_var_132['nickname'], 'oldlevel' => $_var_140, 'newlevel' => $_var_142,), TM_COMMISSION_UPGRADE);
		}

		public function sendMessage($openid = '', $_var_150 = array(), $_var_151 = '')
		{
			global $_W, $_GPC;
			$set = $this->getSet();
			$_var_152 = $set;
			$_var_153 = $_var_152['weixin_templateid'];
			$member = m('member')->getMember($openid);
			$_var_154 = unserialize($member['noticeset']);
			if (!is_array($_var_154)) {
				$_var_154 = array();
			}
			if ($_var_151 == TM_COMMISSION_AGENT_NEW && !empty($_var_152['weixin_commission_agent_new']) && empty($_var_154['commission_agent_new'])) {
				$_var_155 = $_var_152['weixin_commission_agent_new'];
				$_var_155 = str_replace('[昵称]', $_var_150['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_agent_newtitle']) ? $_var_152['weixin_commission_agent_newtitle'] : '新增下线通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $_var_155, 'color' => '#73a68d'));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			} else if ($_var_151 == TM_COMMISSION_ORDER_PAY && !empty($_var_152['weixin_commission_order_pay']) && empty($_var_154['commission_order_pay'])) {
				$_var_155 = $_var_152['weixin_commission_order_pay'];
				$_var_155 = str_replace('[昵称]', $_var_150['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', $_var_150['paytime']), $_var_155);
				$_var_155 = str_replace('[订单编号]', $_var_150['ordersn'], $_var_155);
				$_var_155 = str_replace('[订单金额]', $_var_150['price'], $_var_155);
				$_var_155 = str_replace('[佣金金额]', $_var_150['commission'], $_var_155);
				$_var_155 = str_replace('[商品详情]', $_var_150['goods'], $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_order_paytitle']) ? $_var_152['weixin_commission_order_paytitle'] : '下线付款通知'), 'keyword2' => array('value' => $_var_155));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			} else if ($_var_151 == TM_COMMISSION_ORDER_FINISH && !empty($_var_152['weixin_commission_order_finish']) && empty($_var_154['commission_order_finish'])) {
				$_var_155 = $_var_152['weixin_commission_order_finish'];
				$_var_155 = str_replace('[昵称]', $_var_150['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', $_var_150['finishtime']), $_var_155);
				$_var_155 = str_replace('[订单编号]', $_var_150['ordersn'], $_var_155);
				$_var_155 = str_replace('[订单金额]', $_var_150['price'], $_var_155);
				$_var_155 = str_replace('[佣金金额]', $_var_150['commission'], $_var_155);
				$_var_155 = str_replace('[商品详情]', $_var_150['goods'], $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_order_finishtitle']) ? $_var_152['weixin_commission_order_finishtitle'] : '下线确认收货通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $_var_155, 'color' => '#73a68d'));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			} else if ($_var_151 == TM_COMMISSION_APPLY && !empty($_var_152['weixin_commission_apply']) && empty($_var_154['commission_apply'])) {
				$_var_155 = $_var_152['weixin_commission_apply'];
				$_var_155 = str_replace('[昵称]', $member['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_var_155);
				$_var_155 = str_replace('[金额]', $_var_150['commission'], $_var_155);
				$_var_155 = str_replace('[提现方式]', $_var_150['type'], $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_applytitle']) ? $_var_152['weixin_commission_applytitle'] : '提现申请提交成功', 'color' => '#73a68d'), 'keyword2' => array('value' => $_var_155, 'color' => '#73a68d'));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			} else if ($_var_151 == TM_COMMISSION_CHECK && !empty($_var_152['weixin_commission_check']) && empty($_var_154['commission_check'])) {
				$_var_155 = $_var_152['weixin_commission_check'];
				$_var_155 = str_replace('[昵称]', $member['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_var_155);
				$_var_155 = str_replace('[金额]', $_var_150['commission'], $_var_155);
				$_var_155 = str_replace('[提现方式]', $_var_150['type'], $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_checktitle']) ? $_var_152['weixin_commission_checktitle'] : '提现申请审核处理完成', 'color' => '#73a68d'), 'keyword2' => array('value' => $_var_155, 'color' => '#73a68d'));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			} else if ($_var_151 == TM_COMMISSION_PAY && !empty($_var_152['weixin_commission_pay']) && empty($_var_154['commission_pay'])) {
				$_var_155 = $_var_152['weixin_commission_pay'];
				$_var_155 = str_replace('[昵称]', $member['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_var_155);
				$_var_155 = str_replace('[金额]', $_var_150['commission'], $_var_155);
				$_var_155 = str_replace('[提现方式]', $_var_150['type'], $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_paytitle']) ? $_var_152['weixin_commission_paytitle'] : '佣金打款通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $_var_155, 'color' => '#73a68d'));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			} else if ($_var_151 == TM_COMMISSION_UPGRADE && !empty($_var_152['weixin_commission_upgrade']) && empty($_var_154['commission_upgrade'])) {
				$_var_155 = $_var_152['weixin_commission_upgrade'];
				$_var_155 = str_replace('[昵称]', $member['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', time()), $_var_155);
				$_var_155 = str_replace('[旧等级]', $_var_150['oldlevel']['levelname'], $_var_155);
				$_var_155 = str_replace('[旧一级分销比例]', $_var_150['oldlevel']['commission1'] . '%', $_var_155);
				$_var_155 = str_replace('[旧二级分销比例]', $_var_150['oldlevel']['commission2'] . '%', $_var_155);
				$_var_155 = str_replace('[旧三级分销比例]', $_var_150['oldlevel']['commission3'] . '%', $_var_155);
				$_var_155 = str_replace('[新等级]', $_var_150['newlevel']['levelname'], $_var_155);
				$_var_155 = str_replace('[新一级分销比例]', $_var_150['newlevel']['commission1'] . '%', $_var_155);
				$_var_155 = str_replace('[新二级分销比例]', $_var_150['newlevel']['commission2'] . '%', $_var_155);
				$_var_155 = str_replace('[新三级分销比例]', $_var_150['newlevel']['commission3'] . '%', $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_upgradetitle']) ? $_var_152['weixin_commission_upgradetitle'] : '分销等级升级通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $_var_155, 'color' => '#73a68d'));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			} else if ($_var_151 == TM_COMMISSION_BECOME && !empty($_var_152['weixin_commission_become']) && empty($_var_154['commission_become'])) {
				$_var_155 = $_var_152['weixin_commission_become'];
				$_var_155 = str_replace('[昵称]', $_var_150['nickname'], $_var_155);
				$_var_155 = str_replace('[时间]', date('Y-m-d H:i:s', $_var_150['agenttime']), $_var_155);
				$_var_156 = array('keyword1' => array('value' => !empty($_var_152['weixin_commission_becometitle']) ? $_var_152['weixin_commission_becometitle'] : '成为分销商通知', 'color' => '#73a68d'), 'keyword2' => array('value' => $_var_155, 'color' => '#73a68d'));
				if (!empty($_var_153)) {
					m('message')->sendTplNotice($openid, $_var_153, $_var_156);
				} else {
					m('message')->sendCustomNotice($openid, $_var_156);
				}
			}
		}

	
	}
}