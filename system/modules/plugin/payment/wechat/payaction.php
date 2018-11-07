<?php
header("Location:".WEBSITE_ROOT.create_url("mobile",array("act"=>"modules","do"=>"weixin_bridgepay","osn"=>urlencode(base64_encode($order['ordersn'])), "gtitle"=>urlencode(base64_encode($goodtitle)))));
exit;