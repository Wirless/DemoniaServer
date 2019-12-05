---<movevent event="StepIn" actionid="47401" script="test.lua"/>
--data/movements/movements.xml^ actionid must match desired tile action id
local desiredposition = {x="32103",y="32172",z="8"}
-- desiredposition change that in dosummoncreature if you want customxyz
local monstertospawn = "rat"
local seconds = 0

local config =
{
makeExhaustion = 100, --make exhaust? put the exhaust time in seconds or false if it won't make exhaustion
exhaustionStorage = 51615, 
}

function onStepIn(cid, item, position, fromPosition, player)
if getPlayerLevel(cid) > 1 then
-- npcHandler:onThink() -- we are not handling anything via NPC so i guess it is not needed we will see
if (exhaustion.get (cid, config.exhaustionStorage)) then
		return doPlayerSendCancel (cid, "Wait "..exhaustion.get (cid, config.exhaustionStorage).. " seconds to do it again.")
	end
	
if (config.makeExhaustion ~= false and tonumber(config.makeExhaustion)) then
-- math.random in 1 out of 2 chances 50% or in 1,100 1% chance
chance = math.random(1,2)
if chance == 1 then
		exhaustion.set (cid, config.exhaustionStorage, config.makeExhaustion)
doSummonCreature(monstertospawn, position)
doSummonCreature(monstertospawn, position)
doPlayerSendTextMessage(cid,21,"You have been ambushed!")
stopEvent(event)
else
return doPlayerSendCancel (cid, "IT didnt happen this time maybe try again")
-- return false once its debugged
end
end
end
end
