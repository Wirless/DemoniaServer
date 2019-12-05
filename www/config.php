<?PHP
# Account Maker Config
$config['site']['serverPath'] = "/home/stylezz/test/";
$config['site']['serverLink'] = "Demonia.org";
$config['site']['useServerConfigCache'] = false;
$config['site']['worlds'] = array(0 => 'Demonia');
$towns_list[0] = array(1 => 'Ab\'dendriel',2 => 'Kazordoon',3 => 'Thais',4 => 'Venore',5 => 'Carlin',6 => 'Ankrahmun',7 => 'Darashia',9 => 'Edron',12 => 'Rookgaard');

$config['site']['outfit_images_url'] = 'http://outfit-images.ots.me/outfit.php';
$config['site']['item_images_url'] = 'http://127.0.0.1/images/74/';
$config['site']['item_images_extension'] = '.gif';
$config['site']['flag_images_url'] = 'http://flag-images.ots.me/';
$config['site']['flag_images_extension'] = '.png';
$config['site']['server_version'] = '1.00';
$config['site']['download_client'] = '?subtopic=download';

# Create Account Options
$config['site']['one_email'] = false;
$config['site']['create_account_verify_mail'] = false;
$config['site']['verify_code'] = true;
$config['site']['email_days_to_change'] = 3;
$config['site']['newaccount_premdays'] = 999;
$config['site']['send_register_email'] = false;

# Create Character Options
$config['site']['newchar_vocations'][0] = array(1 => 'Sorcerer Sample', 2 => 'Druid Sample', 3 => 'Paladin Sample', 4 => 'Knight Sample');
$config['site']['newchar_towns'][0] = array(3,9);
$config['site']['max_players_per_account'] = 7;


# Emails Config
$config['site']['send_emails'] = true;
$config['site']['mail_address'] = "realtibia.org@gmail.com";
$config['site']['smtp_enabled'] = true;
$config['site']['smtp_host'] = "ssl://smtp.gmail.com";
$config['site']['smtp_port'] = 465;
$config['site']['smtp_auth'] = true;
$config['site']['smtp_user'] = "realtibia.org@gmail.com";
$config['site']['smtp_pass'] = "yoyo123A";

# PAGE: whoisonline.php
$config['site']['private-servlist.com_server_id'] = 1;
/*
Server id on 'private-servlist.com' to show Players Online Chart (whoisonline.php page), set 0 to disable Chart feature.
To use this feature you must register on 'private-servlist.com' and add your server.
Format: number, 0 [disable] or higher
*/

# PAGE: characters.php
$config['site']['quests'] = array();
$config['site']['show_skills_info'] = true;
$config['site']['show_vip_storage'] = 0;

# PAGE: accountmanagement.php
$config['site']['send_mail_when_change_password'] = true;
$config['site']['send_mail_when_generate_reckey'] = true;
$config['site']['generate_new_reckey'] = false;
$config['site']['generate_new_reckey_price'] = 500;

# PAGE: guilds.php
$config['site']['guild_need_level'] = 15;
$config['site']['guild_need_pacc'] = false;
$config['site']['guild_image_size_kb'] = 50;
$config['site']['guild_description_chars_limit'] = 2000;
$config['site']['guild_description_lines_limit'] = 6;
$config['site']['guild_motd_chars_limit'] = 250;

# PAGE: adminpanel.php
$config['site']['access_admin_panel'] = 3;

# PAGE: latestnews.php
$config['site']['news_limit'] = 6;

# PAGE: killstatistics.php
$config['site']['last_deaths_limit'] = 40;

# PAGE: team.php
$config['site']['groups_support'] = array(2, 3, 4, 5, 6);

# PAGE: highscores.php
$config['site']['groups_hidden'] = array(4, 5, 6);
$config['site']['accounts_hidden'] = array(1);

# PAGE: shopsystem.php
$config['site']['shop_system'] = true;

# PAGE: lostaccount.php
$config['site']['email_lai_sec_interval'] = 180;

// Created by Kargen(ServerInfo/StagesLevel) & Archez (Player Commands and Idea)
$config['site']['serverInfo_width'] = '15'; // from 0% to 100% (recommended: 15)
$config['site']['aboutServer'] = '

- Balanced Vocations<br>
- Always listen to our community<br>
- Loot message [optional]<br>
- Task System is enabled!<br>
- 10k Promotion<br>
- Guild Wars<br>
- Party Share Experience<br>
- No Protection Zones on Boats, No Runes from NPC<br>
- All 7.4 features!<br>
- Blessing System<br>
- PoI Dragon Lords and Quest are added to the game (Soft boots can be obtained there)<br>
- Runes are double charged. You can leave your blank runes in your backpack while conjuring.<br>
- Automatical deletion for botters<br>
- Free Rashid and Djinns - No Quest!<br>
- 
'; // - New Line<br> (Use if your want make a new line "<br>")
$config['site']['commands'] = array(
  '!loot' => 'Use {!loot on} or {!loot off}, to enable or disable loot message; If your in party, open party channel to see the loot message!',
  '!online' => 'Show online players.',
  '!share' => 'To enable or disable Party Shared Experience.',
  '!frags' => 'View the amount of frags your character have and how long they need to disappear.',
  '/war' => 'Invite a guild to war check out <a href="?subtopic=guildwars">Guild War</a> section for more informations.',
  'alito som PlayerName' => 'Sell a house you own to another player. Keep in mind to stay in house while your trade partner is near to you.'
); // 'command' => 'description',
  /* Stage Level */
$config['site']['stageLevel'] = array(
  /* From Level To Level */
  '1-7' => 
  '30x',
  '8-30' => 
  '90x',
  '31-50' => 
  '70x',
  '51-70' => 
  '50x',
  '71-100' => 
  '23x',
  '101-120' => 
  '10x',
  '121-130' => 
  '5x',
  '131~' => 
  '3x'

);/* 'stages Level' => 'ExpRate', */
$config['site']['sInfoLoot'] ='2x';
# Layout Config
$config['site']['layout'] = 'tibiarl';
$config['site']['vdarkborder'] = '#505050';
$config['site']['darkborder'] = '#D4C0A1';
$config['site']['lightborder'] = '#F1E0C6';
$config['site']['download_page'] = true;
$config['site']['serverinfo_page'] = true;