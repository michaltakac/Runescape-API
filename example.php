<?php
header('Content-type: application/json');
require_once 'Runescape_API.class.php';

$rsapi = new Runescape_API;
//Hiscore
if($ressource = $rsapi->getHiscore("Glotzfrosch")){
    $result["getHiscore"] = $ressource;
}
//memberStatus, returns true|false and null by failure
$ressource = $rsapi->getMemberStatus("Glotzfrosch");
if($ressource !== NULL){
    $result["getMemberStatus"] = $ressource;
}
//Quests
if($ressource = $rsapi->getQuests("Glotzfrosch")){
    $result["getQuests"] = $ressource;
}
//recent player events
if($ressource = $rsapi->getRecentPlayerEvents("Glotzfrosch")){
    $result["getRecentPlayerEvents"] = $ressource;
}
//item information
if($ressource = $rsapi->getItemInformation(444,"de")){
    $result["getItemInformation"] = $ressource;
}
//item cataloque
if($ressource = $rsapi->getItemCataloque(2)){
    $result["getItemCataloque"] = $ressource;
}
//items by cataloque
if($ressource = $rsapi->getItemsByCataloque(12,"a",20)){
    $result["getItemsByCataloque"] = $ressource;
}
//player avatar urls
if($ressource = $rsapi->getPlayerAvatars("Bertsch")){
    $result["getPlayerAvatars"] = $ressource;
}
//news
if($ressource = $rsapi->getNews(2)){
    $result["getNews"] = $ressource;
}
//Hiscore for oldschool runescape
if($ressource = $rsapi->getHiscore07("xMorgan")){
    $result["getHiscore07"] = $ressource;
}
echo json_encode($result);
?>