local prizes = {
    [60001] = {level = 8, reward = {2152, 10}}
}

function onAdvance(cid, skill, oldlevel, newlevel)
    if(skill ~= SKILL__LEVEL)then    return TRUE end
    for i,t in ipairs(prizes) do
        if not(getCreatureStorage(cid, i)) and t.level <= newlevel then
            if type(t.reward[1] ~= "table") then
                local add = doPlayerAddItem(cid, t.reward[1], t.reward[2])
                if add then
					doPlayerSendTextMessage(cid, MESSAGE_EVENT_ADVANCE, "You recive " .. t.reward[2] .. "x " .. getItemNameById(t.reward[2]) .. "(s) for reaching " .. t.level .. " level.")
                    doCreatureSetStorage(cid, i, 1)
                end
            else    
                local bp = doCreateItemEx(1988, 1)
                for _,item in ipairs(t.reward) do
                    doAddContainerItem(bp, item[1], item[2])
                end
                local add = doPlayerAddItemEx(cid, bp)
                if add then
                    doPlayerSendTextMessage(cid, 19, "You have received backpack with items due to reaching level " .. t.level .. ".")
                    doCreatureSetStorage(cid, i, 1)
                end
            end
        end
    end
    return TRUE
end  