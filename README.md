Runescape-API
=============

An unofficial Runescape API class written in PHP.

Public Method Summary:<br />
array|boolean getHiscore (string $playerName)<br />
array|boolean getItemCataloque (int|string $categoryID, [boolean $getItems = false])<br />
array|boolean getItemInformation (int $itemID, [string|int $lang = 0])<br />
array|boolean getItemsByCataloque (int|string $categoryID, string $alpha, [int $limit = 12])<br />
boolean|null getMemberStatus (type $playerName)<br />
array getPlayerAvatars (string $playerName)<br />
array|boolean getPriceInformation (int $itemID)<br />
boolean|array getQuests (string $playerName)<br />
array|boolean getRecentPlayerEvents (string $playerName, [boolean $sort = true], [string|int $lang = 0])

Todo:<br />
*add clan methods<br />
*get clan by playername<br />
