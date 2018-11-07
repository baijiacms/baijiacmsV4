<?php defined('SYSTEM_IN') or exit('Access Denied');

function alipay_getSignContent($params) {
		ksort($params);

		$stringToBeSigned = "";
		$i = 0;
		foreach ($params as $k => $v) {
			if (!empty($v) && "@" != substr($v, 0, 1)) {

				if ($i == 0) {
					$stringToBeSigned .= "$k" . "=" . "$v";
				} else {
					$stringToBeSigned .= "&" . "$k" . "=" . "$v";
				}
				$i++;
			}
		}

		unset ($k, $v);
		return $stringToBeSigned;
	}
	function alipay_sign($rsaPrivateKey,$data, $signType = "RSA") {

			$priKey=$rsaPrivateKey;
			$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
				wordwrap($priKey, 64, "\n", true) .
				"\n-----END RSA PRIVATE KEY-----";
			
			openssl_sign($data, $sign, $res);

		
		$sign = base64_encode($sign);
		return $sign;
	}