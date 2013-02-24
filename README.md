Runescape-API
=============

An unofficial Runescape API class written in PHP.

Public Method Summary:
array|boolean getHiscore (string $playerName)
array|boolean getItemCataloque (int|string $categoryID, [boolean $getItems = false])
array|boolean getItemInformation (int $itemID, [string|int $lang = 0])
array|boolean getItemsByCataloque (int|string $categoryID, string $alpha, [int $limit = 12])
boolean|null getMemberStatus (type $playerName)
array getPlayerAvatars (string $playerName)
array|boolean getPriceInformation (int $itemID)
boolean|array getQuests (string $playerName)
array|boolean getRecentPlayerEvents (string $playerName, [boolean $sort = true], [string|int $lang = 0])

Variable Summary:
static string $CATALOQUE_ITEMS_URL
static string $CLAN_BANNER_URL
static string $CLAN_INFO_URL
static string $CLAN_MATES_URL
static string $CLAN_STATS_URL
static string $HISCORE_URL
static string $ITEM_CATALOQUE_URL
static string $ITEM_PRICE_URL
static string $ITEM_URL
static string $PLAYER_AVATAR_BUST
static string $PLAYER_AVATAR_CHAT
static string $PLAYER_CLAN_BANNER_URL
static string $PLAYER_PROFIL_URL
static string $RECENT_EVENTS_URL
static string $SKILL_PICTURE_ADVENTURE_URL

Todo:
*add clan methods
*get clan by playername
