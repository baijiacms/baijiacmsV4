<?php

global $_W, $_GPC;
$set = globalSetting('sale');
$set["enoughs"]=iunserializer($set["enoughs"]);
if (checksubmit("submit")) {
    $data                = is_array($_GPC["data"]) ? $_GPC["data"] : array();
    $set =array();
    $set["enoughfree"]   = intval($data["enoughfree"]);
    $set["enoughorder"]  = round(floatval($data["enoughorder"]), 2);
    $set["enoughareas"]  = $data["enoughareas"];
    $set["enoughmoney"]  = round(floatval($data["enoughmoney"]), 2);
    $set["enoughdeduct"] = round(floatval($data["enoughdeduct"]), 2);
    $enoughs             = array();
    $postenoughs         = is_array($_GPC["enough"]) ? $_GPC["enough"] : array();
    foreach ($postenoughs as $key => $value) {
        $enough = floatval($value);
        if ($enough > 0) {
            $enoughs[] = array(
                "enough" => floatval($_GPC["enough"][$key]),
                "give" => floatval($_GPC["give"][$key])
            );
        }
    }
    $set["enoughs"] = iserializer($enoughs);
     refreshSetting($set,'sale');
    message("满额优惠设置成功!", referer(), "success");
}

    require_once WEB_ROOT . '/includes/lib/json/xml2json.php';
    $file    = ESHOP_AREA_XMLFILE;
    $content = file_get_contents($file);
    $json    = xml2json::transformXmlStringToJson($content);
    $areas   = json_decode($json, true);


include $this->template("enough");
?>