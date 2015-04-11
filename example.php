<?php
header('Content-type: application/json');
require_once 'Runescape_API.class.php';

$rsapi = new Runescape_API;
//Hiscore
if($ressource = $rsapi->getHiscore("Glotzfrosch")){
    $result["getHiscore"] = $ressource;
}
//Combat Level
if($ressource = $rsapi->getCombatLevel("Glotzfrosch")){
    $result["getCombatLevel"] = $ressource;
}
//Player Clan
if($ressource = $rsapi->getClanByPlayer("Glotzfrosch")){
    $result["getClanByPlayer"] = $ressource;
}
//Clan Members
if($ressource = $rsapi->getClanMembers("Loyals")){
    $result["getClanMembers"] = $ressource;
}
//Events
if($ressource = $rsapi->getEvents('archived')){
    $result["getEvents"] = $ressource;
}
//Events By Player
if($ressource = $rsapi->getEventsByPlayer('Glotzfrosch','archived')){
    $result["getEventsByPlayer"] = $ressource;
}
//Beast
if($ressource = $rsapi->getBeastById(49)){
    $result["getBeastById"] = $ressource;
}
//Search Beasts
if($ressource = $rsapi->searchBeasts('kuh',1)){
    $result["searchBeasts"] = $ressource;
}
//Beast Cataloque
if($ressource = $rsapi->getBeastCataloque('a',1)){
    $result["getBeastCataloque"] = $ressource;
}
//Area Names
if($ressource = $rsapi->getAreaNames()){
    $result["getAreaNames"] = $ressource;
}
//Beasts area
if($ressource = $rsapi->getBeastsByArea("Bank")){
    $result["getBeastsByArea"] = $ressource;
}
//Slayer names
if($ressource = $rsapi->getSlayerCatNames("Bank")){
    $result["getSlayerCatNames"] = $ressource;
}
//Beasts by slayer cat
if($ressource = $rsapi->getBeastsBySlayerCat(96)){
    $result["getBeastsBySlayerCat"] = $ressource;
}
//memberStatus, returns true|false and null by failure
$ressource = $rsapi->getMemberStatus("Glotzfrosch");
if($ressource !== NULL){
    $result["getMemberStatus"] = $ressource;
}/*
//Quests
if($ressource = $rsapi->getQuests("Glotzfrosch")){
    $result["getQuests"] = $ressource;
}*/
//recent player events
if($ressource = $rsapi->getRecentPlayerEvents("Drumgun")){
    $result["getRecentPlayerEvents"] = $ressource;
}
//item information
if($ressource = $rsapi->getItemInformation(444,"br")){
    $result["getItemInformation"] = $ressource;
}
//item price
if($ressource = $rsapi->getPriceInformation(444,"br")){
    $result["getPriceInformation"] = $ressource;
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
if($ressource = $rsapi->getPlayerAvatars("Drumgun")){
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