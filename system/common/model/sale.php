<?php

if (!defined('IN_IA')) {
    exit('Access Denied');
}
if (!class_exists('SaleModel')) {
    function sort_enoughs($a, $b)
    {
        $enough1 = floatval($a['enough']);
        $enough2 = floatval($b['enough']);
        if ($enough1 == $enough2) {
            return 0;
        } else {
            return ($enough1 < $enough2) ? 1 : -1;
        }
    }
    class SaleModel
    {
    	public function getSet($key='sale')
    	{
    		
    	return globalSetting($key);	
    	}
        public function getEnoughs()
        {
            $set        = $this->getSet();
            $allenoughs = array();
            $enoughs    = $set['enoughs'];
            if (floatval($set['enoughmoney']) > 0 && floatval($set['enoughdeduct']) > 0) {
                $allenoughs[] = array(
                    'enough' => floatval($set['enoughmoney']),
                    'money' => floatval($set['enoughdeduct'])
                );
            }
            if (is_array($enoughs)) {
                foreach ($enoughs as $e) {
                    if (floatval($e['enough']) > 0 && floatval($e['give']) > 0) {
                        $allenoughs[] = array(
                            'enough' => floatval($e['enough']),
                            'money' => floatval($e['give'])
                        );
                    }
                }
            }
            usort($allenoughs, "sort_enoughs");
            return $allenoughs;
        }
       
        public function getRechargeActivity()
        {
            $set       = $this->getSet();
            $recharges = iunserializer($set['recharges']);
            if (is_array($recharges)) {
                usort($recharges, "sort_enoughs");
                return $recharges;
            }
            return false;
        }
        public function setRechargeActivity($log)
        {
            $set       = $this->getSet();
            $recharges = iunserializer($set['recharges']);
            $credit2   = 0;
            $enough    = 0;
            $give      = '';
            if (is_array($recharges)) {
                usort($recharges, "sort_enoughs");
                foreach ($recharges as $r) {
                    if (empty($r['enough']) || empty($r['give'])) {
                        continue;
                    }
                    if ($log['money'] >= floatval($r['enough'])) {
                        if (strexists($r['give'], '%')) {
                            $credit2 = round(floatval(str_replace('%', '', $r['give'])) / 100 * $log['money'], 2);
                        } else {
                            $credit2 = round(floatval($r['give']), 2);
                        }
                        $enough = floatval($r['enough']);
                        $give   = $r['give'];
                        break;
                    }
                }
            }
            if ($credit2 > 0) {
              
                
        	member_gold($log['openid'],$credit2,'addgold', '充值满' . $enough . '赠送' . $give);
                
                pdo_update('eshop_member_log', array(
                    'gives' => $credit2
                ), array(
                    'id' => $log['id']
                ));
            }
        }
    }
}