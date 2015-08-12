<?php
/**
 * Provides an API for Runescape.
 * @author Armin Supuk <supuk.armin@gmail.com>
 * @version 4.0.0
 * @copyright 2013-2015 Armin Supuk
 * @license GPLv3
 * @license http://www.gnu.org/licenses/gpl-3.0 GNU Public License, version 3
 * @todo add 3 beast methods
 * @todo update quest method
 */
class Runescape_API {

    /**
     * The URL to the Runescape hiscore
     * @var string
     */
    public static $HISCORE_URL = "http://hiscore.runescape.com/index_lite.ws?player=%s";
    /**
     * The URL to the Runescape item API
     * @var string
     */
    public static $ITEM_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/api/catalogue/detail.json?item=%d";
    /**
     * The URL to the Runescape item API for extended price information
     * @var string
     */
    public static $ITEM_PRICE_URL = "http://services.runescape.com/m=itemdb_rs/api/graph/%d.json";
    /**
     * The URL to the Runescape item cataloque API
     * @var string 
     */
    public static $ITEM_CATALOQUE_URL = "http://services.runescape.com/m=itemdb_rs/api/catalogue/category.json?category=%d";
    /**
     * The URL to the Runescape items sorted by cataloque
     * @var string 
     */
    public static $CATALOQUE_ITEMS_URL = "http://services.runescape.com/m=itemdb_rs/api/catalogue/items.json?category=%d&alpha=%s&page=%d";
    /**
     * The URL to a RSS-Feed with the recent events from a player
     * @var string
     */
    public static $RECENT_EVENTS_URL = "http://services.runescape.com/l=%d/m=adventurers-log/rssfeed?searchName=%s";
    /**
     * The URL to a player profil
     * @var string
     */
    public static $PLAYER_PROFIL_URL = "http://services.runescape.com/m=adventurers-log/profile?searchName=%s";
    /**
     * The URL to a player bust avatar
     * @var string
     */
    public static $PLAYER_AVATAR_BUST = "http://services.runescape.com/m=avatar-rs/%s/full.png";
    /**
     * The URL to a chat player avatar
     * @var string
     */
    public static $PLAYER_AVATAR_CHAT = "http://services.runescape.com/m=avatar-rs/%s/chat.png";
    /**
     * The URL to a clan banner by a player name
     * @var string
     */
    public static $PLAYER_CLAN_BANNER_URL = "http://services.runescape.com/m=avatar-rs/%s/ownclan.png";
    /**
     * The URL to a clan banner by the clan name
     * @var string
     */
    public static $CLAN_BANNER_URL = "http://services.runescape.com/m=avatar-rs/%s/clanmotif.png";
    /**
     * The URL to large skill pictures from the adveture log
     * @var string
     */
    public static $SKILL_PICTURE_ADVENTURE_URL = "http://www.runescape.com/l=1/img/adventurers-log/skills/%s.png";
    /**
     * The URL to the clan infos, like the description
     * @var string
     */
    public static $CLAN_INFO_URL = "http://services.runescape.com/m=clan-home/clan/%s";
    /**
     * The URL to the clan stats, like the total level
     * @var string
     */
    public static $CLAN_STATS_URL = "http://services.runescape.com/m=clan-hiscores/compare.ws?clanName=%s";
    /**
     * The URL to the clan mates
     * @var string
     */
    public static $CLAN_MATES_URL = "http://services.runescape.com/m=clan-hiscores/members.ws?clanName=%s&ranking=%d&pageSize=%d";

    public static $CLAN_MEMBERS_URL = "http://services.runescape.com/m=clan-hiscores/members_lite.ws?clanName=%s";
    /**
     * The URL to the RSS-News
     * @var string
     */
    public static $NEWS_URL = "http://services.runescape.com/l=%d/m=news/g=runescape/latest_news.rss";
    /**
     * The URL to the Oldschool Runescape hiscore
     * @var string
     */
    public static $HISCORE_07_URL = "http://services.runescape.com/m=hiscore_oldschool/hiscorepersonal.ws?user1=%s";

    public static $QUEST_URL = "http://services.runescape.com/m=adventurers-log/quests?searchName=%s";

    public static $USER_CLAN_RANK = "services.runescape.com/m=clan-hiscores/userClanRanking.json";

    public static $USER_CLAN_URL = "http://services.runescape.com/m=website-data/playerDetails.ws?names=[\"%s\"]";

    public static $EVENTS_URL = "services.runescape.com/l=%d/m=temp-hiscores/getHiscoreDetails.json?status=%s";

    public static $EVENTS_PLAYER_URL = "http://services.runescape.com/l=%d/m=temp-hiscores/getRankings.json?player=%s&status=%s";

    public static $BEAST_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/bestiary/beastData.json?beastid=%d";

    public static $BEAST_SEARCH_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/bestiary/beastSearch.json?term=%s";

    public static $BEAST_CATALOQUE_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/bestiary/bestiaryNames.json?letter=%s";

    public static $AREA_NAMES_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/bestiary/bestiary/areaNames.json";

    public static $AREA_BEASTS_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/bestiary/areaBeasts.json?identifier=%s";

    public static $SLAYER_BEASTS_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/bestiary/slayerBeasts.json?identifier=%d";

    public static $SLAYER_NAMES_URL = "http://services.runescape.com/l=%d/m=itemdb_rs/bestiary/bestiary/slayerCatNames.json";

    public static $SKILLS_NUMBER = 26;

    public static $ACTIVITIES_NUMBER = 24;

    private $cache;



    public function __construct($cache = TRUE){
        $this->curl = curl_init();
        curl_setopt($this->curl,CURLOPT_USERAGENT,'Runescape API/4.0.0 (https://github.com/ArminSupuk/Runescape-API)');
        if($cache){
            $this->cache = array();
        }else{
            $this->cache = FALSE;
        }
    }

    /**
     * @param int $lang
     * @return bool|mixed|string
     * @since 4.0.0
     * @api
     */
    public function getAreaNames($lang=0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$AREA_NAMES_URL,$lang);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param $area
     * @param int $lang
     * @return bool|mixed|string
     * @since 4.0.0
     * @api
     */
    public function getBeastsByArea($area,$lang=0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$AREA_BEASTS_URL,$lang,$area);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param $cat
     * @param int $lang
     * @return bool|mixed|string
     * @since 4.0.0
     * @api
     */
    public function getBeastsBySlayerCat($cat,$lang=0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$SLAYER_BEASTS_URL,$lang,$cat);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param int $lang
     * @return bool|mixed|string
     * @since 4.0.0
     * @api
     */
    public function getSlayerCatNames($lang=0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$SLAYER_NAMES_URL,$lang);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param $id
     * @param int $lang
     * @return bool|mixed|string
     * @since 4.0.0
     * @api
     */
    public function getBeastById($id,$lang=0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$BEAST_URL,$lang,$id);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param $letter
     * @param int $lang
     * @return bool|mixed|string
     * @since 4.0.0
     * @api
     */
    public function getBeastCataloque($letter,$lang=0){
        $lang = $this->langCode($lang);
        $letter = strtoupper($letter);
        $url = sprintf(self::$BEAST_CATALOQUE_URL,$lang,$letter);
        if($result = $this->startRequest($url)){
            $result = json_decode(utf8_encode($result));
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param $string
     * @param int $lang
     * @return bool|mixed|string
     * @since 4.0.0
     * @api
     */
    public function searchBeasts($string,$lang=0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$BEAST_SEARCH_URL,$lang,$string);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            if($result[0] == "none"){
                return false;
            }
            return $result;
        }else{
            return false;
        }
    }

    /**
     * Get the clan by player
     * @param string $playerName The name of the player in the game
     * @return array|boolean result as array on success or FALSE if the player doesn't exist
     * @since 4.0.0
     * @api
     */
    public function getClanByPlayer($playerName){
        $jquery = "jQuery000000000000000_0000000000";
        if(isset($this->cache[$playerName]["userclan"])){
            $result = $this->cache[$playerName]["userclan"];
        }else{
            $url = sprintf(self::$USER_CLAN_URL,$playerName);
            $url .= "&callback=".$jquery;
            if($result = $this->startRequest($url)){
                if($this->cache !== FALSE){
                    if(!isset($this->cache[$playerName])){
                        $this->cache[$playerName] = array();
                    }
                    $this->cache[$playerName]["userclan"] = $result;
                }
            }
        }
        if($result){
            $result = str_replace($jquery.'(',"",$result);
            $result = str_replace(');',"",$result);
            return json_decode($result);
        }
        return FALSE;
    }

    /**
     * Get the combat level (cb) by player
     * @param string $playerName The name of the player in the game
     * @return array|boolean result as array on success or FALSE if the player doesn't exist
     * @since 4.0.0
     * @api
     */
    public function getCombatLevel($playerName){
        if(isset($this->cache[$playerName]["profilepage"])){
            $result = $this->cache[$playerName]["profilepage"];
        }else{
            $url = sprintf(self::$PLAYER_PROFIL_URL,$playerName);
            if($result = $this->startRequest($url)){
                if($this->cache !== FALSE){
                    if(!isset($this->cache[$playerName])){
                        $this->cache[$playerName] = array();
                    }
                    $this->cache[$playerName]["profilepage"] = $result;
                }
            }
        }
        if($result){
            preg_match_all('/<section class="stats-box stats-box--small stats-box--combat-level">(.*?)<\/section>/s', $result, $cb);
            if(isset($cb[1][0])){
                preg_match_all('/<p class="stats-box__score-value">(?<level>[0-9]*)/s', $cb[1][0], $level);
                $level = $level["level"];
                return $level;
            }else{
                return FALSE;
            }
        }
        return FALSE;
    }

    /**
     * Get the hiscore information for a player
     * @param string $playerName The name of the player in the game
     * @return array|boolean result as array on success or FALSE if the player doesn't exist
     * @since 1.0.0
     * @api
     */
    public function getHiscore($playerName){
        $url = sprintf(self::$HISCORE_URL,$playerName);
        if($result = $this->startRequest($url)){
            $result = explode("\n",$result);
            $output = array();
            for($x=0;$x < self::$SKILLS_NUMBER + self::$ACTIVITIES_NUMBER + 1;$x++){
                $result[$x] = explode(",",$result[$x]);
                if($x < self::$SKILLS_NUMBER + 1){
                    $name = $this->skillID($x);
                    if($result[$x][0] == "-1" OR $result[$x][1] == "1" OR $result[$x][2] == "-1"){
                        unset($output[$name]);
                    }else{
                        $output[$name]["rank"] = $result[$x][0];
                        $output[$name]["lvl"] = $result[$x][1];
                        $output[$name]["totalxp"] = $result[$x][2];
                    }
                }else{
                    $name = $this->activityID($x-self::$SKILLS_NUMBER);
                    if($result[$x][0] == "-1" OR $result[$x][1] == "-1"){
                        unset($output[$name]);
                    }else{
                        $output[$name]["rank"] = $result[$x][0];
                        $output[$name]["score"] = $result[$x][1];
                    }
                }
            }
            return $output;
        }else{
            return false;
        }
    }

    /**
     * Get the Oldschool Runescape hiscore information for a player
     * @param string $playerName The name of the player in the game
     * @return array|boolean result as array on success or FALSE if the player doesn't exist
     * @since 3.2.0
     * @api
     */
    public function getHiscore07($playerName){
        $url = sprintf(self::$HISCORE_07_URL,$playerName);
        $playerName = utf8_encode($playerName);
        if($result = $this->startRequest($url)){
            preg_match_all('/<table cellpadding="3" cellspacing="0" border=0>(.*?)<\/table>/s', $result, $matches);
            preg_match_all('/<tr>(.*?)<\/tr>/s', $matches[0][0], $trs);
            $output = array();
            for($x = 3;$x < 27;$x++){
                preg_match_all('/<td align="left">(.*?)<\/td>/s', $trs[1][$x], $name);
                $name = strip_tags($name[0][0]);
                preg_match_all('/<td align="right">(.*?)<\/td>/s', $trs[1][$x], $lvlskillrank);
                if($x == 3){
                    $y = 0;
                }else{
                    $y = 1;
                }
                $rank = $lvlskillrank[1][$y];
                $lvl = $lvlskillrank[1][$y+1];
                $xp = $lvlskillrank[1][$y+2];
                $output[trim(strtolower($name))] = array(
                    'rank' => $rank,
                    'lvl' => $lvl,
                    'xp' => $xp
                );
            }
            return $output;
        }else{
            return false;
        }
    }
    
    /**
     * Check if a player is member or non-member (on failure it returns NULL) [doesn't work anymore]
     * @param string $playerName The name of the player
     * @return boolean|null TRUE if the player is member, FALSE for non-member and NULL if something goes wrong
     * @since 3.0.0
     * @deprecated 4.0.0
     */
    public function getMemberStatus($playerName){
        return NULL;
    }

    /**
     * returns the quest information for a palyer
     * @param string $playerName
     * @return boolean|array
     * @since 3.0.0
     * @api
     */
    public function getQuests($playerName){
        $url = sprintf(self::$QUEST_URL,$playerName);
        return false;
    }
    /**
     * Get the recent events of a player by his name
     * @param string $playerName The name of the player
     * @param boolean $sort Filter the information of the 50 items in groups and extract important data
     * @param string|int $lang The language, if this isn't english the $sort parameter won't work
     * @return array|boolean result as array on success or FALSE on failure
     * @since 3.0.0
     * @api
     */
    public function getRecentPlayerEvents($playerName,$sort = true,$lang = 0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$RECENT_EVENTS_URL,$lang,$playerName);
        $events = array();
        if($result = $this->startRequest($url)){
            $rss = new SimpleXmlElement($result);
            foreach($rss->channel->item as $event){
                $event = (array) $event;
                if($unix = strtotime($event["pubDate"])){
                    $event["pubDate"] = $unix;
                }
                $event["description"] = trim($event["description"]);
                if($sort && $lang == 0){
                    //stats
                        //lvl
                        if(preg_match("/Levelled/i",$event["title"]) || preg_match("/I levelled my|I am now level/i",$event["description"])){
                            $event["skill"] = preg_replace("/Levelled|up|[. ]/i","",$event["title"]);
                            $event["lvl"] = preg_replace("/[^0-9]/","",$event["description"]);
                            $events["stats"]["lvl"][] = $event;
                        }
                        //all skills
                        elseif(preg_match("/all skills over/i",$event["title"]) || preg_match("/in all skills/i",$event["description"])){
                            $event["lvl"] = preg_replace("/[^0-9]/","",$event["description"]);
                            $events["stats"]["allSkills"][] = $event;
                        }
                        //xp
                        elseif(preg_match("/XP in/i",$event["title"]) || preg_match("/experience points/i",$event["description"])){
                            $event["xp"] = preg_replace("/[^0-9]/","",$event["description"]);
                            $event["skill"] = preg_replace("/[0-9]+XP in /","",$event["title"]);
                            $events["stats"]["xp"][] = $event;
                        }
                        //qp
                        elseif(preg_match("/Quest Points/i",$event["title"]) || preg_match("/QP milestone|Quest Points/i",$event["description"])){
                            $event["qp"] = preg_replace("/[^0-9]/","",$event["title"]);
                            $event["quest"] = preg_replace("/Completing | has given me enough Quest Points to pass the [0-9]+ QP milestone./","",$event["description"]);
                            $events["stats"]["qp"][] = $event;
                        }
                        //songs
                        elseif(preg_match("/songs unlocked/i",$event["title"]) && preg_match("/the last of which/i",$event["description"])){
                            $event["total"] = preg_replace("/[^0-9]/","",$event["title"]);
                            $event["song"] = preg_replace("/I have unlocked a total of[ 0-9]+songs, the last of which was[ ]+|[.]/","",$event["description"]);
                            $events["stats"]["songs"][] = $event;
                        }
                    //quests
                        //completed
                        elseif(preg_match("/Quest complete/i",$event["title"]) || preg_match("/Quest Complete/i",$event["description"])){
                            $event["quest"] = preg_replace("/Quest complete: /i","",$event["title"]);
                            $events["quests"]["completed"][] = $event;
                        }
                    //monsters
                        //killed
                        elseif((preg_match("/I killed/i",$event["title"]) || preg_match("/I killed/i",$event["description"])) && !preg_match("/Daemonheim/i",$event["title"])){
                            $event["monster"] = preg_replace("/I killed[ 0-9an]+|[.]/","",$event["title"]);
                            if(preg_match("/[0-9]/",$event["title"])){
                                $event["total"] = preg_replace("/[^0-9]/","",$event["title"]);
                            }
                            $events["monsters"]["killed"][] = $event;
                        }
                        //defeated
                        elseif((preg_match("/I defeated/i",$event["title"]) || preg_match("/I defeated/i",$event["description"])) && !preg_match("/Daemonheim/i",$event["title"])){
                            $event["monster"] = preg_replace("/I defeated |[0-9]+[\w.]+|[.]/","",$event["title"]);
                            $event["total"] = preg_replace("/[^0-9]/","",$event["title"]);
                            $events["monsters"]["killed"][] = $event;
                        }
                        //drops
                        elseif(preg_match("/I found/i",$event["title"]) || preg_match("/it dropped|After killing a/i",$event["description"])){
                            preg_match("/I found (an|a|some){0,1} (?<drop>.*)/",$event["title"],$item);
                            $event["item"] = $item["drop"];
                            preg_match("/After killing a (?<monster>.*),/",$event["description"],$monster);
                            $event["monster"] = $monster["monster"];
                            $events["monsters"]["drops"][] = $event;
                        }
                    //daemonheim
                        //killed
                        elseif(preg_match("/boss monster/i",$event["title"]) && preg_match("/Daemonheim/i",$event["description"])){
                            $event["monster"] = preg_replace("/I killed [an0-9]+ boss monster[s]?[ ]+called:[ ]+|[ ]+in Daemonheim./","",$event["description"]);
                            if(preg_match("/monsters/",$event["title"])){
                                $event["monster"] = preg_split("/ , | and /",$event["monster"]);
                                $event["total"] = preg_replace("/[^0-9]/","",$event["title"]);
                            }
                            $events["daemonheim"]["killed"][] = $event;
                        }
                        //bought
                        elseif(preg_match("/bought/i",$event["title"]) && preg_match("/dungeoneering tokens/i",$event["description"])){
                            $event["item"] = preg_replace("/ bought./","",$event["title"]);
                            $event["tokens"] = preg_replace("/[^0-9]/","",$event["description"]);
                            $events["daemonheim"]["bought"][] = $event;
                        }
                        //floors
                        elseif(preg_match("/Dungeon floor/i",$event["title"]) || preg_match("/I have breached floor/i",$event["description"])){
                            $event["floor"] = preg_replace("/[^0-9]/","",$event["title"]);
                            $events["daemonheim"]["floors"][] = $event;
                        }
                        //history
                        elseif(preg_match("/history uncovered/i",$event["title"]) || preg_match("/uncovered volume/i",$event["description"])){
                            $event["volume"] = preg_replace("/[^0-9]/","",$event["title"]);
                            $events["daemonheim"]["history"][] = $event;
                        }
                    //minigames
                        //treasureTrails
                        elseif(preg_match("/treasure trail/i",$event["title"]) || preg_match("/treasure trail/i",$event["description"])){
                            $event["difficulty"] = preg_replace("/ treasure trail[\w .]+/","",$event["title"]);
                            $events["minigames"]["treasureTrails"][] = $event;
                        }
                        //fightKiln
                        elseif(preg_match("/Fight Kiln/i",$event["title"]) || preg_match("/Fight Kiln/i",$event["description"])){
                            $events["minigames"]["fightKiln"][] = $event;
                        }
                        //dominionTower
                        elseif(preg_match("/Killed/i",$event["title"]) || preg_match("/Dominion Tower/i",$event["description"])){
                            $events["minigames"]["dominionTower"][] = $event;
                        }
                        //charmSprites
                        elseif(preg_match("/charm sprites/i",$event["title"]) || preg_match("/charm sprites/i",$event["description"])){
                            $events["minigames"]["charmSprites"][] = $event;
                        }
                        //courtSummons
                            //found
                            elseif((preg_match("/Summoned for a case/i",$event["title"]) || preg_match("/court summons/i",$event["description"])) && !preg_match("/won/i",$event["description"])){
                                $event["case"] = preg_replace("/A court summons was dropped. The case is /","",$event["description"]);
                                $events["minigames"]["courtSummons"]["found"][] = $event;
                            }
                            //won
                            elseif(preg_match("/Won a case/i",$event["title"]) || preg_match("/I won the case/i",$event["description"])){
                                $event["case"] = preg_replace("/After finding a court summons, I won the case of[ ]+|[.]/","",$event["description"]);
                                $events["minigames"]["courtSummons"]["won"][] = $event;
                            }
                        //challenges
                            //found
                            elseif(preg_match("/Challenged by/i",$event["title"]) || preg_match("/message was dropped/i",$event["description"])){
                                $event["champion"] = preg_replace("/Challenged by the[ ]+|[.]/","",$event["title"]);
                                $events["minigames"]["challenges"]["found"][] = $event;
                            }
                            //won
                            elseif(preg_match("/Won a challenge/i",$event["title"]) || preg_match("/Won a challenge/i",$event["description"])){
                                $event["champion"] = preg_replace("/Won a challenge against the[ ]+|[.]/","",$event["description"]);
                                $events["minigames"]["challenges"]["won"][] = $event;
                            }
                    //others
                    else{
                        $events["others"][] = $event;
                    }
                }else{
                    $events[] = (array) $event;
                }
            }
            return $events;
        }else{
            return false;
        }
    }

    /**
     * Get the item information
     * @param int $itemID The unique id of the item
     * @param string|int $lang [optional] The language in which the information should be
     * @return array|boolean result as array on success or FALSE if the item doesn't exist
     * @since 3.0.0
     * @api
     */
    public function getItemInformation($itemID,$lang = 0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$ITEM_URL,$lang,$itemID);
        if($result = $this->startRequest($url)){
            $result = json_decode(utf8_encode($result),true);
        }else{
            return false;
        }
        return $result;
    }

    /**
     * Get the market information for an item
     * @param int $itemID The unique id of the item
     * @return array|boolean result as array on success or FALSE if the item doesn't exist
     * @since 3.0.0
     * @api
     */
    public function getPriceInformation($itemID){
        $url = sprintf(self::$ITEM_PRICE_URL,$itemID);
        if($result = $this->startRequest($url)){
            $result = $this->utf8DecodeArray(json_decode(utf8_encode($result),true));
        }else{
            return false;
        }
        return $result;
    }
    /**
     * Get the item cataloque information for a category
     * @param int|string $categoryID The category id or the category name
     * @param boolean $getItems If this is TRUE, it will return the item information for all items in the category
     * @return array|boolean result as array on success
     * @since 3.0.0
     * @api
     */
    public function getItemCataloque($categoryID,$getItems = false){
        $category = $this->itemCategoryID($categoryID);
        $categoryID = $category["categoryID"];
        $categoryName = $category["categoryName"];
        $url = sprintf(self::$ITEM_CATALOQUE_URL,$categoryID);
        $toalItems = 0;
        if($result = $this->startRequest($url)){
            $result = $this->utf8DecodeArray(json_decode(utf8_encode($result),true));
            unset($result["types"]);
            foreach($result["alpha"] as &$alpha){
                $alpha["total"] = $alpha["items"];
                $toalItems += $alpha["total"];
                if($getItems){
                    if($alpha["total"] > 0){
                        $alphaItems = $this->getItemsByCataloque($categoryID,$alpha["letter"],$alpha["total"]);
                        $alpha["items"] = $alphaItems["items"];
                    }else{
                        $alpha["items"] = array();
                    }
                }else{
                    unset($alpha["items"]);
                }
            }
            $result["info"] = array("id" => $categoryID,"name" => $categoryName, "total" => $toalItems);
            return $result;
        }else{
            return false;
        }
    }
    /**
     * Get the items from a category by name ($alpha)
     * @param int|string $categoryID The category id or the category name
     * @param string $alpha The name of the item, requires at minimum one letter
     * @param int $limit The number of items
     * @return array|boolean result as array on success
     * @since 3.0.0
     * @api
     */
    public function getItemsByCataloque($categoryID, $alpha, $limit = 12){
        $category = $this->itemCategoryID($categoryID);
        $categoryID = $category["categoryID"];
        $categoryName = $category["categoryName"];
        if($limit == "all"){
            $limit = 10000;
        }
        $items = array();
        $pages = ceil($limit/12);
        for($x=1;$x <= $pages;$x++){
            $url = sprintf(self::$CATALOQUE_ITEMS_URL,$categoryID,$alpha,$x);
            if($result = $this->startRequest($url)){
                $result = $this->utf8DecodeArray(json_decode(utf8_encode($result),true));
                $totalItems = $result["total"];
                if(ceil($totalItems/12) < $pages){
                    $pages = ceil($totalItems/12);
                    $limit = $totalItems;
                }
                unset($result["total"]);
                $max = $limit % 12;
                foreach($result["items"] as $item){
                    if($x = $pages && $max != 0){
                        $items[] = $item;
                        $max--;
                    }elseif($x = $pages){
                        break;
                    }else{
                        $items[] = $item;
                    }
                }
            }else{
                return false;
            }
        }
        $result["info"] = array("id" => $categoryID,"name" => $categoryName,"total" => $totalItems);
        $result["items"] = $items;
        return $result;
    }

    /**
     * Get the player avatars, actually it returns just the URLs
     * @param string $playerName
     * @return array
     * @since 3.0.0
     * @api
     */
    public function getPlayerAvatars($playerName){
        $output = array();
        $output["full"] = sprintf(self::$PLAYER_AVATAR_BUST,$playerName);
        $output["chat"] = sprintf(self::$PLAYER_AVATAR_CHAT,$playerName);
        return $output;
    }

    /**
     * Get the news
     * @param int|string $lang The language code
     * @return boolean|array
     * @since 3.1.0
     * @api
     */
    public function getNews($lang = 0){
        $lang = $this->langCode($lang);
        $url = sprintf(self::$NEWS_URL,$lang);
        if($result = $this->startRequest($url)){
            $rss = simplexml_load_string($result);
            $result = $rss->xpath("channel/item");
            $result  = json_encode($result);
            $result = json_decode($result, true);
            foreach($result as &$item){
                $item["description"] = trim($item["description"]);
            }
            return $result;
        }else{
            return false;
        }
    }

    /**
     * Returns all members of a given clan
     * @param string $clanName The name of the clan.
     * @return boolean|array
     * @since 4.0.0
     * @api
     */
    public function getClanMembers($clanName){
        $url = sprintf(self::$CLAN_MEMBERS_URL,$clanName);
        if($result = $this->startRequest($url)){
            $result = utf8_encode($result);
            $result = explode("\n",$result);
            array_shift($result);
            $output = array();
            foreach($result as $member){
                $member = explode(",",$member);
                if(count($member) == 4){
                    $output[] = array(
                        "name" => $member[0],
                        "rank" => $member[1],
                        "xp" => $member[2],
                        "kills" => $member[3]);
                }
            }
            return $output;
        }else{
            return false;
        }
    }

    /**
     * @param string $status The status of the events: active (standard), closed, archived or future.
     * @param string $lang
     * @return array|bool
     */
    public function getEvents($status="active",$lang='0'){
        $status = strtolower($status);
        $url = sprintf(self::$EVENTS_URL,$lang,$status);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            return $result;
        }else{
            return false;
        }
    }

    /**
     * @param $player
     * @param string $status
     * @return bool|mixed|string
     */
    public function getEventsByPlayer($player,$status="active",$lang='0'){
        $status = strtolower($status);
        $url = sprintf(self::$EVENTS_PLAYER_URL,$lang,$player,$status);
        if($result = $this->startRequest($url)){
            $result = json_decode($result);
            return $result;
        }else{
            return false;
        }
    }

    /**
     * Convert a skill id to the name
     * @param int|string $skillID
     * @return string The name of the skill
     */
    private function skillID($skillID){
        switch($skillID){
            case 0:$name = "overall";break;
            case 1:$name = "attack";break;
            case 2:$name = "defence";break;
            case 3:$name = "strength";break;
            case 4:$name = "constitution";break;
            case 5:$name = "ranged";break;
            case 6:$name = "prayer";break;
            case 7:$name = "magic";break;
            case 8:$name = "cooking";break;
            case 9:$name = "woodcutting";break;
            case 10:$name = "fletching";break;
            case 11:$name = "fishing";break;
            case 12:$name = "firemaking";break;
            case 13:$name = "crafting";break;
            case 14:$name = "smithing";break;
            case 15:$name = "mining";break;
            case 16:$name = "herblore";break;
            case 17:$name = "agility";break;
            case 18:$name = "thieving";break;
            case 19:$name = "slayer";break;
            case 20:$name = "farming";break;
            case 21:$name = "runecrafting";break;
            case 22:$name = "hunter";break;
            case 23:$name = "construction";break;
            case 24:$name = "summoning";break;
            case 25:$name = "dungeoneering";break;
            case 26:$name = "divination";break;
            default:$name = "unknown";break;
        }
        return $name;
    }
    /**
     * Convert a activity id to the name
     * @param int|string $activityID
     * @return string The name of the activity
     */
    private function activityID($activityID){
        switch($activityID){
            case 1:$name = "bountyHunters";break;
            case 2:$name = "bountyHuntersRogues";break;
            case 3:$name = "dominionTower";break;
            case 4:$name = "theCrucible";break;
            case 5:$name = "castlewarsGames";break;
            case 6:$name = "baAttackers";break;
            case 7:$name = "baDefenders";break;
            case 8:$name = "baCollectors";break;
            case 9:$name = "baHealers";break;
            case 10:$name = "duelTournament";break;
            case 11:$name = "mobilisingArmies";break;
            case 12:$name = "conquest";break;
            case 13:$name = "fistOfGuthix";break;
            case 14:$name = "ggRessourceRace";break;
            case 15:$name = "ggAthletics";break;
            case 16:$name = "we2Alc";break;
            case 17:$name = "we2Blc";break;
            case 18:$name = "we2Apk";break;
            case 19:$name = "we2Bpk";break;
            case 20:$name = "hgl";break;
            case 21:$name = "hrl";break;
            case 22:$name = "cfb5ga";break;
            case 23:$name = "af15Ct";break;
            case 24:$name = "af15Rk";break;
            default:$name = "unknown";break;
        }
        return $name;
    }
    /**
     * Convert a category id or name to the id and name
     * @param int|string $categoryID
     * @return array The categoryID and the categoryName
     */
    private function itemCategoryID($categoryID){
        switch($categoryID){
            case "0":case "Miscellaneous":default:$categoryID = 0; $categoryName = "Miscellaneous"; break;
            case "1":case "Ammo":$categoryID = 1; $categoryName = "Ammo"; break;
            case "2":case "Arrows":$categoryID = 2; $categoryName = "Arrows"; break;
            case "3":case "Bolts":$categoryID = 3; $categoryName = "Bolts"; break;
            case "4":case "Construction materials":$categoryID = 4; $categoryName = "Construction materials"; break;
            case "5":case "Construction projects":$categoryID = 5; $categoryName = "Construction projects"; break;
            case "6":case "Cooking ingredients":$categoryID = 6; $categoryName = "Cooking ingredients"; break;
            case "7":case "Costumes":$categoryID = 7; $categoryName = "Miscellaneous"; break;
            case "8":case "Crafting materials":$categoryID = 8; $categoryName = "Crafting materials"; break;
            case "9":case "Familiars":$categoryID = 9; $categoryName = "Familiars"; break;
            case "10":case "Farming produce":$categoryID = 10; $categoryName = "Farming produce"; break;
            case "11":case "Fletching materials":$categoryID = 11; $categoryName = "Fletching materials"; break;
            case "12":case "Food and drink":$categoryID = 12; $categoryName = "Food and drink"; break;
            case "13":case "Herblore materials":$categoryID = 13; $categoryName = "Herblore materials"; break;
            case "14":case "Hunting equipment":$categoryID = 14; $categoryName = "Miscellaneous"; break;
            case "15":case "Hunting produce":$categoryID = 15; $categoryName = "Hunting produce"; break;
            case "16":case "Jewellery":$categoryID = 16; $categoryName = "Jewellery"; break;
            case "17":case "Mage armour":$categoryID = 17; $categoryName = "Mage armour"; break;
            case "18":case "Mage weapons":$categoryID = 18; $categoryName = "Mage weapons"; break;
            case "19":case "Melee armour - low level":$categoryID = 19; $categoryName = "Melee armour - low level"; break;
            case "20":case "Melee armour - mid level":$categoryID = 20; $categoryName = "Melee armour - mid level"; break;
            case "21":case "Melee armour - high level":$categoryID = 21; $categoryName = "Melee armour - high level"; break;
            case "22":case "Melee weapons - low level":$categoryID = 22; $categoryName = "Melee weapons - low level"; break;
            case "23":case "Melee weapons - mid level":$categoryID = 23; $categoryName = "Melee weapons - mid level"; break;
            case "24":case "Melee weapons - high level":$categoryID = 24; $categoryName = "Melee weapons - high level"; break;
            case "25":case "Mining and smithing":$categoryID = 25; $categoryName = "Mining and smithing"; break;
            case "26":case "Potions":$categoryID = 26; $categoryName = "Potions"; break;
            case "27":case "Prayer armour":$categoryID = 27; $categoryName = "Prayer armour"; break;
            case "28":case "Prayer materials":$categoryID = 28; $categoryName = "Prayer materials"; break;
            case "29":case "Range armour":$categoryID = 29; $categoryName = "Range armour"; break;
            case "30":case "Range weapons":$categoryID = 30; $categoryName = "Range weapons"; break;
            case "31":case "Runecrafting":$categoryID = 31; $categoryName = "Runecrafting"; break;
            case "32":case "Runes, Spells and Teleports":$categoryID = 32; $categoryName = "Runes, Spells and Teleports"; break;
            case "33":case "Seeds":$categoryID = 33; $categoryName = "Seeds"; break;
            case "34":case "Summoning scrolls":$categoryID = 34; $categoryName = "Summoning scrolls"; break;
            case "35":case "Tools and containers":$categoryID = 35; $categoryName = "Tools and containers"; break;
            case "36":case "Woodcutting product":$categoryID = 36; $categoryName = "Woodcutting product"; break;
            case "37":case "Pocket items":$categoryID = 37; $categoryName = "Pocket items"; break;
        }
        return array("categoryID" => $categoryID,"categoryName" => $categoryName);
    }
    /**
     * Convert the language Code in a number
     * @param int|string $lang
     * @return int
     */
    private function langCode($lang){
        switch($lang){
            case "us":
            case "usa":
            case "en":
            case "eng":
            case "engs":
            case "0":
            default:
                $lang = 0;
                break;
            case "de":
            case "deu":
            case "ger":
            case "deus":
            case "1":
                $lang = 1;
                break;
            case "fr":
            case "fra":
            case "fre":
            case "fras":
            case "2":
                $lang = 2;
                break;
            case "br":
            case "bra":
            case "pt":
            case "prt":
            case "por":
            case "3":
                $lang = 3;
                break;
        }
        return $lang;
    }
    /**
     * Start a simpple curl request to an URL
     * @param string $url
     * @return string|boolean result as string on success or FALSE on failure
     */
    private function startRequest($url){
        $timeout = 30;
        curl_setopt($this->curl, CURLOPT_URL, utf8_encode($url));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $result = curl_exec($this->curl);
        $responseCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        if($responseCode == 200 && $result){
            return $result;
        }else{
            return false;
        }
    }
    /**
     * utf8_decode for arrays
     * @param array $array
     * @return array UTF-8 decoded Array
     */
    private function utf8DecodeArray($array) {
        $utf8DecodedArray = array();
        foreach($array as $key => $value){
            if(is_array($value)){
                $utf8DecodedArray[$key] = $this->utf8DecodeArray($value);
                continue;
            }
            $utf8DecodedArray[$key] = utf8_decode($value);
        }
        return $utf8DecodedArray;
    }

    public function __destruct(){
        curl_close($this->curl);
    }

}
?>
