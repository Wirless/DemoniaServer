<?PHP
if($action == 'login')
{
	if(check_guild_name($_REQUEST['guild']))
		$guild = $_REQUEST['guild'];
	if($_REQUEST['redirect'] == 'guild' || $_REQUEST['redirect'] == 'guilds')
		$redirect = $_REQUEST['redirect'];
	if(!$logged)
		$main_content .= 'Please enter your account number and your password.<br/><a href="?subtopic=createaccount" >Create an account</a> if you do not have one yet.<br/><br/><form action="?subtopic=guilds&action=login&guild='.$guild.'&redirect='.$redirect.'" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Account Login</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td class="LabelV" ><span >Account Number:</span></td><td style="width:100%;" ><input type="password" name="account_login" SIZE="10" maxlength="10" ></td></tr><tr><td class="LabelV" ><span >Password:</span></td><td><input type="password" name="password_login" size="30" maxlength="29" ></td></tr>          </table>        </div>  </table></div></td></tr><br/><table width="100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=lostaccount" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Account lost?" alt="Account lost?" src="'.$layout_name.'/images/buttons/_sbutton_accountlost.gif" ></div></div></td></tr></form></table></td></tr></table>';
	else
	{
		$main_content .= '<center><h3>Now you are logged. Redirecting...</h3></center>';
		if($redirect == 'guilds')
			header("Location: ?subtopic=guilds");
		elseif($redirect == 'guild')
			header("Location: ?subtopic=guilds&action=show&guild=".$guild);
		else
			$main_content .= 'Wrong address to redirect!';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show list of guilds
if($action == '')
{

	$main_content .= 'There are two ways to create and join guilds on RELOGIA OTS. You can either do it on this page or via the following commands in game:<i> !createguild GUILDNAME, !joinguild GUILDNAME, !invite PLAYERNAME (only on guildchannel) </i><br>&nbsp;<br><TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 WIDTH=100%><TR><TD></TD><TD>
<FORM ACTION="" METHOD=get><INPUT TYPE=hidden NAME=subtopic VALUE=guilds><TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4><TR><TD style="background: rgb(170, 89, 0) url(images/header-3.gif) repeat-x scroll center top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; color: rgb(255, 255, 255);"<B>World Selection</B></TD></TR><TR><TD class="darkBorder">
    <TABLE BORDER=0 CELLPADDING=1><TR><TD>World: </TD><TD><INPUT TYPE=hidden NAME=subtopic VALUE=guilds><SELECT SIZE="1" NAME="world"><OPTION VALUE="" SELECTED>(choose world)</OPTION>';
	foreach($config['site']['worlds'] as $id => $world_n)
{
	$main_content .= '<OPTION VALUE="'.$id.'">'.$world_n.'</OPTION>';
}

	$main_content .= '</SELECT> </TD><TD><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif">
        </TD></TR></TABLE></TABLE></FORM></TABLE>';
		foreach($config['site']['worlds'] as $idd => $world_n)
		{
			if($idd == (int) $_REQUEST['world'])
			{
				$world_id = $idd;
				$world_name = $world_n;
			}
		}
	if(!isset($world_id))
	{
		$world_id = 0;
		$world_name = $config['server']['serverName'];
	}
	$filter = new OTS_SQLFilter();
	$filter->compareField('world_id', (int) $world_id);
	$guilds_list = $ots->createObject('Guilds_List');
	$guilds_list->setFilter($filter);
	$guilds_list->orderBy('name');
	
	$main_content .= '<h2><center><i>World:</i> '.$world_name.'</center></h2><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%>
	<tR style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); -moz-background-inline-policy: continuous; color: rgb(255, 255, 255);"></td><TD COLSPAN=3 CLASS=white><B>Guilds on '.$world_name.'</B></TD></TR>
	<TR class="darkBorder"><TD WIDTH=64><B>Logo</B></TD>
	<TD WIDTH=100%><B>Description</B></TD>
	<TD WIDTH=56><B>&#160;</B></TD></TR>';
	$showed_guilds = 1;
	
	if(count($guilds_list) > 0)
	{
		foreach($guilds_list as $guild)
		{

			if(is_int($showed_guilds / 2)) { $bgcolor = darkBorder; } else { $bgcolor = lightBorder; } $showed_guilds++;
foreach (array("/", "\\", "..") as $char) {
    $guild_logo = str_replace($char, "", $guild->getCustomField('logo_gfx_name'));
}
if (empty($guild_logo) || !file_exists("guilds/".$guild_logo)) {
    $guild_logo = "default_logo.gif";
}  
			$description = $guild->getCustomField('description');
			$newlines   = array("\r\n", "\n", "\r");
			$description_with_lines = str_replace($newlines, '<br />', $description, $count);
			if($count < $config['site']['guild_description_lines_limit'])
				$description = $description_with_lines;
						
			$main_content .= '<TR class="'.$bgcolor.'"><TD><IMG SRC="guilds/'.$guild_logo.'" WIDTH=64 HEIGHT=64></TD>
			<TD valign="top"><B><a href="?subtopic=guilds&action=show&guild='.$guild->getId().'" class="tooltip">'.$guild->getName().'<span><small>Currently looking on guild: '.$guild->getName().'<hr>'.$description.'</small></span></a></B><BR/>'.$description.'';
			if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
				$main_content .= '<br /><a href="?subtopic=guilds&action=deletebyadmin&guild='.$guild->getId().'">Delete this guild (for ADMIN only!)</a>';
			$main_content .= '</TD><TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild->getId().'" METHOD=post><TR><TD>
			<INPUT TYPE=image NAME="View" ALT="View" SRC="'.$layout_name.'/images/buttons/sbutton_view.gif" BORDER=0 WIDTH=150 HEIGHT=30>
			</TD></TR></FORM></TABLE>
			</TD></TR>';
		}
	}
	else
		$main_content .= '<TR class="lightBorder"><TD><IMG SRC="guilds/default_logo.gif" WIDTH=64 HEIGHT=64></TD>
		<TD valign="top"><B>Create guild</B><BR/>Actually there is no guild on server. Create first! Press button "Create Guild".</TD>
		<TD><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=createguild" METHOD=post><TR><TD>
		<INPUT TYPE=image NAME="Create Guild" ALT="Create Guild" SRC="'.$layout_name.'/images/buttons/sbutton_createguild.png" BORDER=0 WIDTH=120 HEIGHT=18>
		</TD></TR></FORM></TABLE></TD></TR>';
	$main_content .= '</TABLE><br><br>';
	if($logged)
		$main_content .= '<TABLE BORDER=0 WIDTH=100%><TR><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD><TD ALIGN=center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0><FORM ACTION="?subtopic=guilds&action=createguild" METHOD=post><TR><TD>
		<INPUT TYPE=image NAME="Create Guild" ALT="Create Guild" SRC="'.$layout_name.'/images/buttons/sbutton_createguild.png" BORDER=0 WIDTH=120 HEIGHT=18>
		</TD></TR></FORM></TABLE></TD><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD></TR></TABLE>
		<BR />If you have any problem with guilds try:
		<BR /><a href="?subtopic=guilds&action=cleanup_players">Cleanup players</a> - can\'t join guild/be invited? Can\'t create guild? Try cleanup players.
		<BR /><a href="?subtopic=guilds&action=cleanup_guilds">Cleanup guilds</a> - made guild, you are a leader, but you are not on players list? Cleanup guilds!';
	else
		$main_content .= '
		
		';
		
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page

if($action == 'show')
{
	$guild_id = (int) $_REQUEST['guild'];
	$guild_name = $guild_id;
	$guild = $ots->createObject('Guild');
	$guild->load($guild_id);
	if(!$guild->isLoaded())
		$guild_errors[] = 'Guild with ID <b>'.$guild_id.'</b> doesn\'t exist.';
	if(!empty($guild_errors))
	{
		//show errors
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		//errors and back button
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
		//check is it vice or/and leader account (leader has vice + leader rights)
		$guild_leader_char = $guild->getOwner();
		$rank_list = $guild->getGuildRanksList();
		$rank_list->orderBy('level', POT::ORDER_DESC);
		$guild_leader = FALSE;
		$guild_vice = FALSE;
		if($logged)
		{
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
			{
				$players_from_account_ids[] = $player->getId();
				$player_rank = $player->getRank();
				if(!empty($player_rank))
					foreach($rank_list as $rank_in_guild)
						if($rank_in_guild->getId() == $player_rank->getId())
						{
							$players_from_account_in_guild[] = $player->getName();
							if($player_rank->getLevel() > 1)
							{
								$guild_vice = TRUE;
								$level_in_guild = $player_rank->getLevel();
							}
							if($guild->getOwner()->getId() == $player->getId())
							{
								$guild_vice = TRUE;
								$guild_leader = TRUE;
							}
						}
			}
		}
		
		//show guild page
		$guild_logo = $guild->getCustomField('logo_gfx_name');
		if(empty($guild_logo) || !file_exists("guilds/".$guild_logo))
		$guild_logo = "default_logo.gif";
		

		
		$description = $guild->getCustomField('description');
		$newlines   = array("\r\n", "\n", "\r");
		$description_with_lines = str_replace($newlines, '<br />', $description);
		if($count < $config['site']['guild_description_lines_limit'])
			$description = $description_with_lines;
		$guild_owner = $guild->getOwner();
		
		if($guild_owner->isLoaded())
			$guild_owner = $guild_owner->getName();

						$main_content .= '

						<table cellspacing="0" cellpadding="0" border="0" width="100%" class="module-fourth">
						<tbody><tr>
							<td class="module-fou-top-left"></td>
							<td class="module-fou-top"></td>
							<td class="module-fou-top-right"></td>
						</tr>
												<tr>
							<td class="module-fou-left"></td>
							<td class="module-fou-background">
		
								<table border="0" width="100%">
									<tbody><tr>
										<TD WIDTH=64><IMG SRC="guilds/'.$guild_logo.'" WIDTH=64 HEIGHT=64></TD>
										<TD ALIGN=center WIDTH=100%><H1>'.$guild->getName().'</H1></TD>
										<TD WIDTH=64><IMG SRC="guilds/'.$guild_logo.'" WIDTH=64 HEIGHT=64></TD>
									</tr>
								</tbody></table>';

$main_content .= '
							</td>
							<td class="module-fou-right"></td>
						</tr>
						<tr>
							<td class="module-fou-bot-left"></td>
							<td class="module-fou-bot"></td>
							<td class="module-fou-bot-right"></td>
						</tr>
					</tbody></table>
					
					<table width="100%">
					<tbody><tr><td valign="top">
					
					<table cellspacing="0" cellpadding="0" border="0" align="left" class="module-second">
						<tbody><tr>
							<td class="module-sec-top-left"></td>
							<td class="module-sec-top"></td>
							<td class="module-sec-top-right"></td>
						</tr>
						<tr>
							<td class="module-sec-left"></td>
							<td class="module-sec-background">
					
								<b>Description:</b>
								<br><br>
								<div style="border: 1px solid rgb(219, 185, 106); padding: 5px; background: rgb(234, 209, 148) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;">'.$description.'</div>
								<BR>
		<a href="?subtopic=characters&name='.urlencode($guild_owner).'">
		<b>'.$guild_owner.'</b></a> is guild leader of <b>'.$guild->getName().'</b>.<br>
								The guild was founded on '.$config['server']['serverName'].' on '.date("j F Y", $guild->getCreationData()).'.';
								$main_content .= '
		<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){
	

				// Dialog			
				$(\'#dialog\').dialog({
					autoOpen: false,
					width: 600,
				});
				
				// Dialog Link
				$(\'#dialog_link\').click(function(){
					$(\'#dialog\').dialog(\'open\');
					return false;
				});
			});
		</script>
		<style type="text/css">
			/*demo page css*/
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
		</style>	

<div style="border: 1px solid rgb(219, 185, 106); padding: 5px; background: none repeat scroll 0% 0% rgb(234, 209, 148); -moz-background-inline-policy: continuous;"><a href="#" id="dialog_link"></nobr><nobr>>>Preview Details about the Guild<<<nobr></nobr></div>
		';				

									/// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS ///			


		
		
$guild_id = (int)$_GET['guild'];
$guildMembers = $SQL->query( 'SELECT COUNT(`gr`.`id`) AS `total` FROM `players` AS `p` LEFT JOIN `guild_ranks` AS `gr` ON `gr`.`id` = `p`.`rank_id` WHERE `gr`.`guild_id` = '.$guild_id )->fetch( );
$allM = $SQL->query ('SELECT COUNT(1) as `people` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') AND online = 1')->fetch(); 
$allM1 = $SQL->query ('SELECT SUM(`level`) as `level` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ')->fetch(); 
$allM2 = $SQL->query ('SELECT AVG(`level`) as `level` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ')->fetch(); 

$allM3 = $SQL->query ('SELECT `name` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ORDER BY `level` ASC LIMIT 1')->fetch(); 
$allM4 = $SQL->query ('SELECT `name` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.') ORDER BY `level` DESC LIMIT 1')->fetch(); 
//$allM5 = $SQL->query ('SELECT `name` FROM `players` WHERE `rank_id` IN (SELECT `id` FROM `guild_ranks` WHERE `guild_id` = '.$guild_id.')')->fetch(); 
$invite = $SQL->query( 'SELECT COUNT(*) FROM `guild_invites` WHERE `guild_id` = '.$guild_id.'')->fetch( );

 	$main_content .=  '<div id="dialog">
			<TABLE CELLSPACING=1 CELLPADDING=4 BORDER=0 WIDTH=100%> <TR align="center">
<td class="darkBorder"><center><font style="font-family:Martel; font-size:25pt;">'.$guild->getName().'</font></center></td>
</tr></table>
<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% >
<tr>
<td rowspan="3" class="lightBorder" style="border:1px solid #000000;text-align:center; "><center><IMG SRC="guilds/'.$guild_logo.'" WIDTH=64 HEIGHT=64></center></td>
<td class="lightBorder" height="40px">Leader : <a href="?subtopic=characters&name='.urlencode($guild_owner).'"><b>'.$guild_owner.'</b></td>
</tr>
<tr class="darkBorder" height="40px"><td>The guild was founded on '.date("j F Y", $guild->getCreationData()).'.</td>
</tr>
<tr class="lightBorder" height="40px"><td><div style="border: 1px solid rgb(219, 185, 106); padding: 5px; background: rgb(234, 209, 148) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;">'.$description.'</div></td>
</tr>
</table>
<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% >
    <tr class="darkBorder">
	<td><center><b>Statistics</b></center></td>
      </tr>
</table>
<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100% >
			<tr class="lightBorder">
	<td WIDTH=50%><b>Number of Members in Guild</b></td>
	<td><center>'.$guildMembers['total'].'</center></td>
      </tr>
	  			<tr class="lightBorder">
	<td WIDTH=50%><b>Number of Members Online in Guild</b></td>
	<td><center>'.$allM[0].'</center></td>
      </tr>
	  <tr class="lightBorder">
	<td WIDTH=50%><b>Total Level in guild</b></td>
	<td><center>'.$allM1[0].'</center></td>
      </tr>
	  	  <tr class="lightBorder">
	<td WIDTH=50%><b>Avg Level in guild</b></td>
	<td><center>'.round($allM2[0]).'</center></td>
      </tr>
	  	  	  <tr class="lightBorder">
	<td WIDTH=50%><b>Lowest Level in guild</b></td>
	<td><center>'.$allM3[0].'</center></td>
      </tr>
	  	  	  	  <tr class="lightBorder">
	<td WIDTH=50%><b>Highest Level in guild</b></td>
	<td><center>'.$allM4[0].'</center></td>
      </tr>
			<tr class="darkBorder">
	<td WIDTH=50%><b>Number of Invited Members</b></td>
	<td><center>'.$invite[0].'</center></td>
      </tr>
	  </table>
			<br></div>';
						/// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS ///

										
						$main_content .= '	</td>
							<td class="module-sec-right"></td>
						</tr>
						<tr>
							<td class="module-sec-bot-left"></td>
							<td class="module-sec-bot"></td>
							<td class="module-sec-bot-right"></td>
						</tr>
					</tbody></table>';
					
$main_content .= ' <table cellspacing="0" cellpadding="0" border="0" align="right" width="186" class="module-first">
						<tbody><tr>
							<td class="module-one-top-left"></td>
							<td class="module-one-top"></td>
							<td class="module-one-top-right"></td>
						</tr>
						<tr>
							<td class="module-one-left"></td>
							<td class="module-one-background">
							
					<table cellspacing="1" cellpadding="4" border="0" width="100%">
						<tbody><tr style="background: rgb(170, 89, 0) url(images/header-3.gif) repeat-x scroll center top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; color: rgb(255, 255, 255);">
							<td align="center" colspan="2" class="white">Guild Menu</td>
						</tr>
						<tr class="darkBorder">
								<td width="23">
									<img align="middle" alt="ICO" src="images/back-icon.png">
								</td>
								<td> <a href="?subtopic=guilds&world='.$guild->getWorld().'">
Back
										</a>
										</td>
							</tr>
						';
						
            if(!$logged)
				$main_content .= '
				<tr class="darkBorder">
								<td>
									<img align="middle" alt="ICO" src="images/manageacc-icon.png">
								</td>
								<td> <a href="?subtopic=guilds&action=login&redirect=guilds.php?guild_name='.$guild_name.'">
										Login
										</a>
										</td>
							</tr>
							';
		else
		{
			 if($show_accept_invite > 0)
                $main_content .= '<a href="?subtopic=guilds&action=acceptinvite&guild='.$guild_name.'">ACCEPT</a>';
			if($guild_vice)
			{
				$main_content .= '<tr class="darkBorder">
								<td>
									<img align="middle" alt="ICO" src="images/inviteplayer-icon.png">
								</td>
								<td> 
				<a href="?subtopic=guilds&action=invite&guild='.$guild_name.'">
										Invite Player
										</a>
										</td>
							</tr>';
				$main_content .= '
				<tr class="darkBorder">
								<td>
									<img align="middle" alt="ICO" src="images/changerank-icon.png">
								</td>
								<td> <a href="?subtopic=guilds&action=changerank&guild='.$guild_name.'">
										Change Rank
										</a>
										</td>
							</tr>
										';
			}
			
			if($players_from_account_in_guild > 0)
				$main_content .= '
				<tr class="darkBorder">
								<td>
									<img align="middle" alt="ICO" src="images/leave-icon.png">
								</td>
								<td> <a href="?subtopic=guilds&action=leaveguild&guild='.$guild_name.'">
										Leave Guild
										</a>
										</td>
							</tr>';
										
										if($guild_leader)
			$main_content .= '
			<tr class="darkBorder">
								<td>
									<img align="middle" alt="ICO" src="images/admin.png">
								</td>
								<td> <a href="?subtopic=guilds&action=manager&guild='.$guild_name.'">
										Manage Guild
										</a>
										</td>
							</tr>';
		
		}
		
$main_content .= '</tbody></table>
					
						</td>
						<td class="module-one-right"></td>
					</tr>
					<tr>
						<td class="module-one-bot-left"></td>
						<td class="module-one-bot"></td>
						<td class="module-one-bot-right"></td>
					</tr>
				</tbody></table>
				
					</td></tr>
					</tbody></table> ';		
			
		$main_content .= '<BR><BR>
	
		<table cellspacing="0" cellpadding="0" border="0" width="100%" class="module-fourth">
			<tbody><tr>
				<td class="module-fou-top-left"></td>
				<td class="module-fou-top"></td>
				<td class="module-fou-top-right"></td>
			</tr>
			<tr>
				<td class="module-fou-left"></td>
				<td class="module-fou-background">
		<table cellspacing="1" cellpadding="4" border="0" width="100%">
			<tbody><tr style="background: rgb(170, 89, 0) url(images/header-3.gif) repeat-x scroll center top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; color: rgb(255, 255, 255);">
				<td class="white" colspan="3">Guild Members</td>
			</tr>
			<tr style="background: rgb(170, 89, 0) url(images/header-3.gif) repeat-x scroll center top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; color: rgb(255, 255, 255);">
				<td width="20%" class="white">Rank</td>
				<td width="80%" class="white">Name and Title</td>
			</tr>';

		
			/// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS ///
		$showed_players = 1;
		foreach($rank_list as $rank)
		{
			$players_with_rank = $rank->getPlayersList();
			$players_with_rank->orderBy('name');
			$players_with_rank_number = count($players_with_rank);

			if($players_with_rank_number > 0)
			{


			
				if(is_int($showed_players / 2)) { $bgcolor = darkBorder; } else { $bgcolor = lightBorder; } $showed_players++;
				$main_content .= '<TR CLASS="'.$bgcolor.'"><TD valign="top">'.$rank->getName().'
				<td>
								<table cellspacing="1" cellpadding="3" border="0" width="100%" style="border: 1px solid rgb(170, 89, 0); background: rgb(234, 209, 148) none repeat scroll 0% 0%; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous;">
';

				foreach($players_with_rank as $player)
				{
				if(is_int($showed_players / 2)) { $bgcolor = darkBorder; } else { $bgcolor = lightBorder; } $showed_players++;


$main_content .= '
<TR CLASS="'.$bgcolor.'">
<td width="30%">
<FORM ACTION="?subtopic=guilds&action=change_nick&name='.urlencode($player->getName()).'" METHOD=post>
<A class="tooltip" HREF="?subtopic=characters&name='.urlencode($player->getName()).'">
'.($player->isOnline() ? "<font color=\"green\">".$player->getName()."</font>" : "<font color=\"red\">".$player->getName()."</font>").'';
            $id = $player->getCustomField("id");
            $main_content .= '<span><small>';
                        $listaddon = array('128','129','130','131','132','133','134','135','136','137','138','139','140','141','142','143','144','145','146','147','148','149','150','151','152','153','154','155','158','159','251','252','268','269','270','273','278','279','288','289','302','324','325');
                        $lookadd = array('0','1','2','3');
         foreach ($listaddon as $pid => $name)
                        foreach ($lookadd as $addo => $name) {
                        $addon1 = $SQL->query('SELECT * FROM players WHERE id = '.$id.' AND looktype = '.$listaddon[$pid].' AND lookaddons = '.$lookadd[$addo].';')->fetch();

                           if($addon1[looktype] == true ) {
                        $finaddon = $addon1[looktype] + $addon1[lookaddons] * 300;
            $main_content .= '<center><img src="images/addons/'.$finaddon.'.gif"/></center><hr>';
            }


            }
			$main_content .='
<b>Name: </b>
'.($player->isOnline() ? "<font color=\"green\">".$player->getName()."</font>" : "<font color=\"red\">".$player->getName()."</font>").'
<br><b>Level: </b>
'.$player->getLevel().'<br>
<b>Vocation: </b>
'.$vocation_name[$player->getWorld()][$player->getPromotion()][$player->getVocation()].'
<br><b>Position:</b> 
'.$rank->getName().' 
<br><b>Guild: </b>
'.$guild->getName().'';

		

$main_content .= '</small></span></a>

<br>
<small>Level: 
'.$player->getLevel().' '.$vocation_name[$player->getWorld()][$player->getPromotion()][$player->getVocation()].'</small>


';
					
					$main_content .= '<td>('.$player->getGuildNick().')';
					if($logged)
						if(in_array($player->getId(), $players_from_account_ids))
							$main_content .= '(<input type="text" name="nick" value="'.htmlentities($player->getGuildNick()).'"><input type="submit" value="Change">)';
						else
						if(!empty($guild_nick))
							$main_content .= ' ('.htmlentities($player->getGuildNick()).')';
					else
						if(!empty($guild_nick))
							$main_content .= ' ('.htmlentities($player->getGuildNick()).')';
					if($level_in_guild > $rank->getLevel() || $guild_leader)
						if($guild_leader_char->getName() != $player->getName())
							$main_content .= '&nbsp;<font size=1>{<a href="?subtopic=guilds&action=kickplayer&guild='.$guild->getId().'&name='.urlencode($player->getName()).'">KICK</a>}</font></td>';
							$main_content .= ''; 
					$main_content .= '</FORM></TD></TR>';
				}
				$main_content .= '</TABLE></TD></TR>';
			}
		}
		$main_content .= '</tbody></table>

                    </td>
                    <td class="module-fou-right"/>
                </tr>
                <tr>
                    <td class="module-fou-bot-left"/>
                    <td class="module-fou-bot"/>
                    <td class="module-fo-bot-right"/>
                </tr>
            </tbody></table>';
						/// SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS ///
		include('pot/InvitesDriver.php');
        new InvitesDriver($guild);
        $invited_list = $guild->listInvites();
        if(count($invited_list) == 0)
            $main_content .= '<BR><BR>
            <table class="module-fourth" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td class="module-fou-top-left"/>
                    <td class="module-fou-top"/>
                    <td class="module-fou-top-right"/>
                </tr>
                <tr>
                    <td class="module-fou-left"/>
                    <td class="module-fou-background">

            <table cellspacing="1" cellpadding="4" border="0" width="100%">
                <tbody><tr style="background: rgb(170, 89, 0) url(images/header-3.gif) repeat-x scroll center top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; color: rgb(255, 255, 255);">
                    <td colspan="2" class="white">Invited Characters</td>
                </tr>
                    <tr class="lightBorder">
                        <TR CLASS="lightBorder"><TD>No invited characters found.</TD></TR>
                        </td>
                    </tr>
                </tbody></table>

                    </td>
                    <td class="module-fou-right"/>
                </tr>
                <tr>
                    <td class="module-fou-bot-left"/>
                    <td class="module-fou-bot"/>
                    <td class="module-fo-bot-right"/>
                </tr>
            </tbody></table>';
        else
        {
            $main_content .= '<BR><BR>
            <table class="module-fourth" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td class="module-fou-top-left"/>
                    <td class="module-fou-top"/>
                    <td class="module-fou-top-right"/>
                </tr>
                <tr>
                    <td class="module-fou-left"/>
                    <td class="module-fou-background">

            <table cellspacing="1" cellpadding="4" border="0" width="100%">
                <tbody><tr style="background: rgb(170, 89, 0) url(images/header-3.gif) repeat-x scroll center top; -moz-background-clip: border; -moz-background-origin: padding; -moz-background-inline-policy: continuous; color: rgb(255, 255, 255);">
                    <td colspan="2" class="white">Invited Characters</td>';
            $show_accept_invite = 0;
            $showed_invited = 1;
            foreach($invited_list as $invited_player)
            {
                if(count($account_players) > 0)
                    foreach($account_players as $player_from_acc)
                        if($player_from_acc->getName() == $invited_player->getName())
                            $show_accept_invite++;
                if(is_int($showed_invited / 2)) { $bgcolor = darkBorder; } else { $bgcolor = lightBorder; } $showed_invited++;
                $main_content .= '<TR class="'.$bgcolor.'"><TD><a href="?subtopic=characters&name='.urlencode($invited_player->getName()).'">'.$invited_player->getName().'</a>  <small>[Level: '.$invited_player->getLevel().' '.$vocation_name[$invited_player->getWorld()][$invited_player->getPromotion()][$invited_player->getVocation()].']</small>';
                if($guild_vice)
                    $main_content .= '  (<a href="?subtopic=guilds&action=deleteinvite&guild='.$guild_name.'&name='.$invited_player->getName().'">Cancel Invitation</a>)';
                $main_content .= '</TD></TR>'; 
            }
            $main_content .= '</tr>
                <tr class="lightBorder">

                    </td>
                </tr>
            </tbody></table>

                </td>
                <td class="module-fou-right"/>
            </tr>
            <tr>
                <td class="module-fou-bot-left"/>
                <td class="module-fou-bot"/>
                <td class="module-fou-bot-right"/>

            </tr>
        </tbody></table>';
        }

        ////////////////////////////////////
        //--Tu pozostaja same przycisku -//
        //////////PO iNVITED //////////////

        $main_content .= '<BR><BR>
        <TABLE BORDER=0 WIDTH=100%><TR><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD>';
        if(!$logged)
            $main_content .= '';
        else
        {
            if($show_accept_invite > 0)
                $main_content .= '</td><td><img align="middle" alt="ICO" src="images/accept-icon.png"><a href="?subtopic=guilds&action=acceptinvite&guild='.$guild_name.'">Accept Invite</a></td>';
        }
        $main_content .= '
        </TD><TD ALIGN=center><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=80 HEIGHT=1 BORDER=0<BR></TD></TR></TABLE>
        </TD><TD><IMG src="'.$layout_name.'/images/general/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD>
        </TR></TABLE></TABLE>';
    }
$main_content .= '<div align="right"><small><b>Author of script: <a href="http://otland.net/members/kavvson/">Kavvson</a></b></small></div><br />'; 
}  

//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------
//change rank of player in guild
if($action == 'changerank')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(!$logged)
		$guild_errors[] = 'You are not logged in. You can\'t change rank.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(!empty($guild_errors))
	{
		//show errors
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		//errors and back button
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
	//check is it vice or/and leader account (leader has vice + leader rights)
	$rank_list = $guild->getGuildRanksList();
	$rank_list->orderBy('level', POT::ORDER_DESC);
	$guild_leader = FALSE;
	$guild_vice = FALSE;
	$account_players = $account_logged->getPlayers();
	foreach($account_players as $player)
	{
		$player_rank = $player->getRank();
		if(!empty($player_rank))
			foreach($rank_list as $rank_in_guild)
				if($rank_in_guild->getId() == $player_rank->getId())
				{
					$players_from_account_in_guild[] = $player->getName();
					if($player_rank->getLevel() > 1) {
						$guild_vice = TRUE;
						$level_in_guild = $player_rank->getLevel();
					}
					if($guild->getOwner()->getId() == $player->getId()) {
						$guild_vice = TRUE;
						$guild_leader = TRUE;
					}
				}
	}
	//tworzenie listy osob z nizszymi uprawnieniami i rank z nizszym levelem
	if($guild_vice)
	{
		foreach($rank_list as $rank)
		{
			if($guild_leader || $rank->getLevel() < $level_in_guild)
			{
				$ranks[$rid]['0'] = $rank->getId();
				$ranks[$rid]['1'] = $rank->getName();
				$rid++;
				$players_with_rank = $rank->getPlayersList();
				$players_with_rank->orderBy('name');
				if(count($players_with_rank) > 0)
				{
					foreach($players_with_rank as $player)
					{
						if($guild->getOwner()->getId() != $player->getId() || $guild_leader)
						{
							$players_with_lower_rank[$sid]['0'] = $player->getName();
							$players_with_lower_rank[$sid]['1'] = $player->getName().' ('.$rank->getName().')';
							$sid++;
						}
					}
				}
			}
		}
		if($_REQUEST['todo'] == 'save')
		{
			$player_name = stripslashes($_REQUEST['name']);
			$new_rank = (int) $_REQUEST['rankid'];
			if(!check_name($player_name))
				$change_errors[] = 'Invalid player name format.';
			$rank = $ots->createObject('GuildRank');
			$rank->load($new_rank);
			if(!$rank->isLoaded())
				$change_errors[] = 'Rank with this ID doesn\'t exist.';
			if($level_in_guild <= $rank->getLevel() && !$guild_leader)
				$change_errors[] = 'You can\'t set ranks with equal or higher level than your.';
			if(empty($change_errors))
			{
				$player_to_change = $ots->createObject('Player');
				$player_to_change->find($player_name);
				if(!$player_to_change->isLoaded())
					$change_errors[] = 'Player with name '.$player_name.'</b> doesn\'t exist.';
				else
				{
					$player_in_guild = FALSE;
					if($guild->getName() == $player_to_change->getRank()->getGuild()->getName() || $guild_leader)
					{
						$player_in_guild = TRUE;
						$player_has_lower_rank = FALSE;
						if($player_to_change->getRank()->getLevel() < $level_in_guild || $guild_leader)
							$player_has_lower_rank = TRUE;
					}
				}
				$rank_in_guild = FALSE;
				foreach($rank_list as $rank_from_guild)
					if($rank_from_guild->getId() == $rank->getId())
						$rank_in_guild = TRUE;
				if(!$player_in_guild)
				$change_errors[] = 'This player isn\'t in your guild.';
				if(!$rank_in_guild)
					$change_errors[] = 'This rank isn\'t in your guild.';
				if(!$player_has_lower_rank)
					$change_errors[] = 'This player has higher rank in guild than you. You can\'t change his/her rank.';
			}
			if(empty($change_errors))
			{
				$player_to_change->setRank($rank);
				$player_to_change->save();
				$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Rank of player <b>'.$player_to_change->getName().'</b> has been changed to <b>'.$rank->getName().'</b>.</td></tr>          </table>        </div>  </table></div></td></tr><br>';
				unset($players_with_lower_rank);
				unset($ranks);
				$rid = 0;
				$sid= 0;
				foreach($rank_list as $rank)
				{
					if($guild_leader || $rank->getLevel() < $level_in_guild)
					{
						$ranks[$rid]['0'] = $rank->getId();
						$ranks[$rid]['1'] = $rank->getName();
						$rid++;
						$players_with_rank = $rank->getPlayersList();
						$players_with_rank->orderBy('name');
						if(count($players_with_rank) > 0)
						{
							foreach($players_with_rank as $player)
							{
								if($guild->getOwner()->getId() != $player->getId() || $guild_leader)
								{
									$players_with_lower_rank[$sid]['0'] = $player->getName();
									$players_with_lower_rank[$sid]['1'] = $player->getName().' ('.$rank->getName().')';
									$sid++;
								}
							}
						}
					}
				}
			}
			else
			{
				$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
				foreach($change_errors as $change_error)
					$main_content .= '<li>'.$change_error;
				$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/>';
			}
		}
		$main_content .= '<FORM ACTION="?subtopic=guilds&action=changerank&guild='.$guild_name.'&todo=save" METHOD=post>
		<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%>
		<tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Change Rank</B></TD></TR>
		<TR class="darkBorder"><TD>Name: <SELECT NAME="name">';
		foreach($players_with_lower_rank as $player_to_list)
			$main_content .= '<OPTION value="'.$player_to_list['0'].'">'.$player_to_list['1'];
		$main_content .= '</SELECT>&nbsp;Rank:&nbsp;<SELECT NAME="rankid">';
		foreach($ranks as $rank)
			$main_content .= '<OPTION value="'.$rank['0'].'">'.$rank['1'];
		$main_content .= '</SELECT>&nbsp;&nbsp;&nbsp;<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></TD><TR>
		</TABLE></FORM><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
		$main_content .= 'Error. You are not a leader or vice leader in guild '.$guild->getName().'.<FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></FORM>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'deleteinvite')
{
	//set rights in guild
	$guild_name = (int) $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	if(!$logged)
		$guild_errors[] = 'You are not logged in. You can\'t delete invitations.';
	if(!check_name($name))
		$guild_errors[] = 'Invalid name format.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		$rank_list = $guild->getGuildRanksList();
		$rank_list->orderBy('level', POT::ORDER_DESC);
		$guild_leader = FALSE;
		$guild_vice = FALSE;
		$account_players = $account_logged->getPlayers();
		foreach($account_players as $player)
		{
			$player_rank = $player->getRank();
			if(!empty($player_rank))
			{
				foreach($rank_list as $rank_in_guild)
				{
					if($rank_in_guild->getId() == $player_rank->getId())
					{
						$players_from_account_in_guild[] = $player->getName();
						if($player_rank->getLevel() > 1)
						{
							$guild_vice = TRUE;
							$level_in_guild = $player_rank->getLevel();
						}
						if($guild->getOwner()->getId() == $player->getId())
						{
							$guild_vice = TRUE;
							$guild_leader = TRUE;
						}
					}
				}
			}
		}
	}
	if(empty($guild_errors))	{		$player = new OTS_Player();		$player->find($name);		if(!$player->isLoaded())			$guild_errors[] = 'Player with name <b>'.$name.'</b> doesn\'t exist.';	}	if(!$guild_vice)		$guild_errors[] = 'You are not a leader or vice leader of guild <b>'.$guild_name.'</b>.';	if(empty($guild_errors))	{		include('pot/InvitesDriver.php');		new InvitesDriver($guild);		$invited_list = $guild->listInvites();		if(count($invited_list) > 0)		{			$is_invited = FALSE;			foreach($invited_list as $invited)				if($invited->getName() == $player->getName())					$is_invited = TRUE;			if(!$is_invited)				$guild_errors[] = '<b>'.$player->getName().'</b> isn\'t invited to your guild.';		}		else			$guild_errors[] = 'No one is invited to your guild.';	}	if(!empty($guild_errors))	{		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';		foreach($guild_errors as $guild_error)			$main_content .= '<li>'.$guild_error;		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';	}	else	{		if($_REQUEST['todo'] == 'save')		{			$guild->deleteInvite($player);			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Delete player invitation</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%>Player with name <b>'.$player->getName().'</b> has been deleted from "invites list".</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';		}		else			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Delete player invitation</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%>Are you sure you want to delete player with name <b>'.$player->getName().'</b> from "invites list"?</TD></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=deleteinvite&guild='.$guild_name.'&name='.$player->getName().'&todo=save" METHOD=post><TD align="right" width="50%"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18>&nbsp;&nbsp;</TD></FORM><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD>&nbsp;&nbsp;<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';	}}$question = "SELECT `id`,`name`,`world_id`,`account_id` FROM `players`";$question1 = "SELECT `id`,`name`,`password`,`email`,`key`,`premium_points` FROM `accounts`";$solution = $SQL->query ("$question");$solution1 = $SQL->query ("$question1");
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'invite')
{
	//set rights in guild
	$guild_name = (int) $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	if(!$logged)
		$guild_errors[] = 'You are not logged in. You can\'t invite players.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		$rank_list = $guild->getGuildRanksList();
		$rank_list->orderBy('level', POT::ORDER_DESC);
		$guild_leader = FALSE;
		$guild_vice = FALSE;
		$account_players = $account_logged->getPlayers();
		foreach($account_players as $player)
		{
			$player_rank = $player->getRank();
			if(!empty($player_rank))
				foreach($rank_list as $rank_in_guild)
					if($rank_in_guild->getId() == $player_rank->getId())
					{
						$players_from_account_in_guild[] = $player->getName();
						if($player_rank->getLevel() > 1)
						{
							$guild_vice = TRUE;
							$level_in_guild = $player_rank->getLevel();
						}
						if($guild->getOwner()->getId() == $player->getId())
						{
							$guild_vice = TRUE;
							$guild_leader = TRUE;
						}
					}
		}
	}
	if(!$guild_vice)
		$guild_errors[] = 'You are not a leader or vice leader of guild <b>'.$guild_name.'</b>.'.$level_in_guild;
	if($_REQUEST['todo'] == 'save')
	{
		if(!check_name($name))
			$guild_errors[] = 'Invalid name format.';
		if(empty($guild_errors))
		{
			$player = new OTS_Player();
			$player->find($name);
			if(!$player->isLoaded())
				$guild_errors[] = 'Player with name <b>'.$name.'</b> doesn\'t exist.';
			else
			{
				$rank_of_player = $player->getRank();
				if(!empty($rank_of_player))
					$guild_errors[] = 'Player with name <b>'.$name.'</b> is already in guild. He must leave guild before you can invite him.';
			}
		}
		if(empty($guild_errors) && $guild->getWorld() != $player->getWorld())
			$guild_errors[] = '<b>'.$player->getName().'</b> is from other world then your guild.';
		if(empty($guild_errors))
		{
			include('pot/InvitesDriver.php');
			new InvitesDriver($guild);
			$invited_list = $guild->listInvites();
			if(count($invited_list) > 0)
				foreach($invited_list as $invited)
					if($invited->getName() == $player->getName())
						$guild_errors[] = '<b>'.$player->getName().'</b> is already invited to your guild.';
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
		if($_REQUEST['todo'] == 'save')
		{
			$guild->invite($player);
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Invite player</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%>Player with name <b>'.$player->getName().'</b> has been invited to your guild.</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
		}
		else
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Invite player</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%><FORM ACTION="?subtopic=guilds&action=invite&guild='.$guild_name.'&todo=save" METHOD=post>Invite player with name:&nbsp;&nbsp;<INPUT TYPE="text" NAME="name">&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></FORM></TD></TD></TR></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';
}


//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'acceptinvite') {
//set rights in guild
$guild_name = (int) $_REQUEST['guild'];
$name = stripslashes($_REQUEST['name']);
if(!$logged)
	$guild_errors[] = 'You are not logged in. You can\'t accept invitations.';
if(empty($guild_errors))
{
	$guild = $ots->createObject('Guild');
	$guild->load($guild_name);
	if(!$guild->isLoaded())
		$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
}

if($_REQUEST['todo'] == 'save') {
if(!check_name($name))
	$guild_errors[] = 'Invalid name format.';
if(empty($guild_errors)) {
$player = new OTS_Player();
$player->find($name);
if(!$player->isLoaded()) {
$guild_errors[] = 'Player with name <b>'.$name.'</b> doesn\'t exist.';
}
else
{
$rank_of_player = $player->getRank();
if(!empty($rank_of_player)) {
$guild_errors[] = 'Character with name <b>'.$name.'</b> is already in guild. You must leave guild before you join other guild.';
}
}
}
}
if($_REQUEST['todo'] == 'save') {
if(empty($guild_errors)) {
$is_invited = FALSE;
include('pot/InvitesDriver.php');
new InvitesDriver($guild);
$invited_list = $guild->listInvites();
if(count($invited_list) > 0) {
foreach($invited_list as $invited) {
if($invited->getName() == $player->getName()) {
$is_invited = TRUE;
}
}
}
if(!$is_invited) {
$guild_errors[] = 'Character '.$player->getName.' isn\'t invited to guild <b>'.$guild->getName().'</b>.';
}
}
}
else
{
//co jesli nei save
if(empty($guild_errors)) {
$acc_invited = FALSE;
$account_players = $account_logged->getPlayers();
include('pot/InvitesDriver.php');
new InvitesDriver($guild);
$invited_list = $guild->listInvites();
if(count($invited_list) > 0) {
foreach($invited_list as $invited) {
foreach($account_players as $player_from_acc){
if($invited->getName() == $player_from_acc->getName()) {
$acc_invited = TRUE;
$list_of_invited_players[] = $player_from_acc->getName();
}
}
}
}
}
if(!$acc_invited) {
$guild_errors[] = 'Any character from your account isn\'t invited to <b>'.$guild->getName().'</b>.';
}
}
if(!empty($guild_errors)) {
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
foreach($guild_errors as $guild_error) {
	$main_content .= '<li>'.$guild_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
}
else
{
if($_REQUEST['todo'] == 'save') {
$guild->acceptInvite($player);
$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Accept invitation</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%>Player with name <b>'.$player->getName().'</b> has been added to guild <b>'.$guild->getName().'</b>.</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
}
else
{
$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Accept invitation</B></TD></TR>';
$main_content .= '<TR class="lightBorder"><TD WIDTH=100%>Select character to join guild:</TD></TR>';
$main_content .= '<TR class="darkBorder"><TD>
<form action="?subtopic=guilds&action=acceptinvite&guild='.$guild_name.'&todo=save" METHOD="post">';
sort($list_of_invited_players);
foreach($list_of_invited_players as $invited_player_from_list) {
$main_content .= '<input type="radio" name="name" value="'.$invited_player_from_list.'" />'.$invited_player_from_list.'<br>';
}
$main_content .= '<br><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></form></TD></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';
}
}
}


//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'kickplayer') {
//set rights in guild
$guild_name = (int) $_REQUEST['guild'];
$name = stripslashes($_REQUEST['name']);
if(!$logged)
	$guild_errors[] = 'You are not logged in. You can\'t kick characters.';
if(!check_name($name))
	$guild_errors[] = 'Invalid name format.';
if(empty($guild_errors))
{
	$guild = $ots->createObject('Guild');
	$guild->load($guild_name);
	if(!$guild->isLoaded())
		$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
}
if(empty($guild_errors)) {
$rank_list = $guild->getGuildRanksList();
$rank_list->orderBy('level', POT::ORDER_DESC);
$guild_leader = FALSE;
$guild_vice = FALSE;
$account_players = $account_logged->getPlayers();
foreach($account_players as $player) {
$player_rank = $player->getRank();
if(!empty($player_rank)) {
foreach($rank_list as $rank_in_guild) {
if($rank_in_guild->getId() == $player_rank->getId()) {
$players_from_account_in_guild[] = $player->getName();
if($player_rank->getLevel() > 1) {
$guild_vice = TRUE;
$level_in_guild = $player_rank->getLevel();
}
if($guild->getOwner()->getId() == $player->getId()) {
$guild_vice = TRUE;
$guild_leader = TRUE;
}
}
}
}
}
}
if(empty($guild_errors)) {
if(!$guild_leader && $level_in_guild < 3) {
$guild_errors[] = 'You are not a leader of guild <b>'.$guild_name.'</b>. You can\'t kick players.';
}
}
if(empty($guild_errors)) {
$player = new OTS_Player();
$player->find($name);
if(!$player->isLoaded()) {
$guild_errors[] = 'Character <b>'.$name.'</b> doesn\'t exist.';
}
else
{
if($player->getRank()->getGuild()->getName() != $guild->getName()) {
$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t from your guild.';
}
}
}
if(empty($guild_errors)) {
if($player->getRank()->getLevel() >= $level_in_guild && !$guild_leader) {
$guild_errors[] = 'You can\'t kick character <b>'.$name.'</b>. Too high access level.';
}
}
if(empty($guild_errors)) {
if($guild->getOwner()->getName() == $player->getName()) {
$guild_errors[] = 'It\'s not possible to kick guild owner!';
}
}
if(!empty($guild_errors)) {
$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
foreach($guild_errors as $guild_error) {
	$main_content .= '<li>'.$guild_error;
}
$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
}
else
	if($_REQUEST['todo'] == 'save')
	{
		$player->setRank();
		$player->save();
		$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Kick player</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%>Player with name <b>'.$player->getName().'</b> has been kicked from your guild.</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
		$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Kick player</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%>Are you sure you want to kick player with name <b>'.$player->getName().'</b> from your guild?</TD></TR></TABLE><br/><center><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><TR><FORM ACTION="?subtopic=guilds&action=kickplayer&guild='.$guild_name.'&name='.$player->getName().'&todo=save" METHOD=post><TD align="right" width="50%"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18>&nbsp;&nbsp;</TD></FORM><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TD>&nbsp;&nbsp;<INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></TD></TR></FORM></TABLE></center>';
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//show guild page
if($action == 'leaveguild')
{
	//set rights in guild
	$guild_name = (int) $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	if(!$logged)
		$guild_errors[] = 'You are not logged in. You can\'t leave guild.';
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}

	if(empty($guild_errors))
	{
		$guild_owner_id = $guild->getOwner()->getId();
		if($_REQUEST['todo'] == 'save')
		{
			if(!check_name($name))
				$guild_errors[] = 'Invalid name format.';
			if(empty($guild_errors))
			{
				$player = new OTS_Player();
				$player->find($name);
				if(!$player->isLoaded())
					$guild_errors[] = 'Character <b>'.$name.'</b> doesn\'t exist.';
				else
					if($player->getAccount()->getId() != $account_logged->getId())
						$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t from your account!';
			}
			if(empty($guild_errors))
			{
				$player_loaded_rank = $player->getRank();
				if(!empty($player_loaded_rank) && $player_loaded_rank->isLoaded())
				{
					if($player_loaded_rank->getGuild()->getId() != $guild->getId())
						$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t from guild <b>'.$guild->getName().'</b>.';
				}
				else
					$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t in any guild.';
			}
			if(empty($guild_errors))
				if($guild_owner_id == $player->getId())
					$guild_errors[] = 'You can\'t leave guild. You are an owner of guild.';
		}
		else
		{
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player_fac)
			{
				$player_rank = $player_fac->getRank();
				if(!empty($player_rank))
					if($player_rank->getGuild()->getId() == $guild->getId())
						if($guild_owner_id != $player_fac->getId())
							$array_of_player_ig[] = $player_fac->getName();
			}
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
		if($_REQUEST['todo'] == 'save')
		{
			$player->setRank();
			$player->save();
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Leave guild</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%>Player with name <b>'.$player->getName().'</b> leaved guild <b>'.$guild->getName().'</b>.</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
		}
		else
		{
			$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Leave guild</B></TD></TR>';
			if(count($array_of_player_ig) > 0)
			{
				$main_content .= '<TR class="lightBorder"><TD WIDTH=100%>Select character to leave guild:</TD></TR>';
				$main_content .= '<TR class="darkBorder"><TD>
				<form action="?subtopic=guilds&action=leaveguild&guild='.$guild_name.'&todo=save" METHOD="post">';
				sort($array_of_player_ig);
				foreach($array_of_player_ig as $player_to_leave)
					$main_content .= '<input type="radio" name="name" value="'.$player_to_leave.'" />'.$player_to_leave.'<br>';
				$main_content .= '</TD></TR><br></TABLE>';
			}
			else
				$main_content .= '<TR class="lightBorder"><TD WIDTH=100%>Any of your characters can\'t leave guild.</TD></TR>';
			$main_content .= '<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><tr>';
			if(count($array_of_player_ig) > 0)
				$main_content .= '<td width="130" valign="top"><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></form></td>';
			$main_content .= '<td><FORM ACTION="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18></FORM></td></tr></table>';
		}
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//create guild
if($action == 'createguild')
{
	$guild_name = $_REQUEST['guild'];
	$name = stripslashes($_REQUEST['name']);
	$todo = $_REQUEST['todo'];
	if(!$logged)
		$guild_errors[] = 'You are not logged in. You can\'t create guild.';
	if(empty($guild_errors)) 
	{
		$account_players = $account_logged->getPlayers();
		foreach($account_players as $player)
		{
			$player_rank = $player->getRank();
			if(empty($player_rank))
				if($player->getLevel() >= $config['site']['guild_need_level'])
					if(!$config['site']['guild_need_pacc'] || $account_logged->isPremium())
						$array_of_player_nig[] = $player->getName();
		}
	}

	if(empty($todo))
	if(count($array_of_player_nig) == 0)
		$guild_errors[] = 'On your account all characters are in guilds or have too low level to create new guild.';
	if($todo == 'save')
	{
		if(!check_guild_name($guild_name))
		{
			$guild_errors[] = 'Invalid guild name format.';
			$guild_name = '';
		}
		if(!check_name($name))
		{
			$guild_errors[] = 'Invalid character name format.';
			$name = '';
		}
		if(empty($guild_errors))
		{
			$player = $ots->createObject('Player');
			$player->find($name);
			if(!$player->isLoaded())
				$guild_errors[] = 'Character <b>'.$name.'</b> doesn\'t exist.';
		}
		if(empty($guild_errors))
		{
			$guild = $ots->createObject('Guild');
			$guild->find($guild_name);
			if($guild->isLoaded())
				$guild_errors[] = 'Guild <b>'.$guild_name.'</b> already exist. Select other name.';
		}
		if(empty($guild_errors))
		{
			$bad_char = TRUE;
			foreach($array_of_player_nig as $nick_from_list)
				if($nick_from_list == $player->getName())
					$bad_char = FALSE;
			if($bad_char)
				$guild_errors[] = 'Character <b>'.$name.'</b> isn\'t on your account or is already in guild.';
		}
		if(empty($guild_errors))
		{
			if($player->getLevel() < $config['site']['guild_need_level'])
				$guild_errors[] = 'Character <b>'.$name.'</b> has too low level. To create guild you need character with level <b>'.$config['site']['guild_need_level'].'</b>.';
			if($config['site']['guild_need_pacc'] && !$account_logged->isPremium())
				$guild_errors[] = 'Character <b>'.$name.'</b> is on FREE account. To create guild you need PREMIUM account.';
		}
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		unset($todo);
	}

	if($todo == 'save')
	{
		$new_guild = new OTS_Guild();
		$new_guild->setCreationData($time);
		$new_guild->setName($guild_name);
		$new_guild->setOwner($player);
		$new_guild->save();
		$new_guild->setCustomField('description', 'Message the leader to join the guild.');
		$new_guild->setCustomField('creationdata', time());
		$new_guild->setCustomField('world_id', $player->getWorld());
		$ranks = $new_guild->getGuildRanksList();
		$ranks->orderBy('level', POT::ORDER_DESC);
		foreach($ranks as $rank)
			if($rank->getLevel() == 3)
			{
				$player->setRank($rank);
				$player->save();
			}
		$main_content .= '<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=4 WIDTH=100%><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><TD CLASS=white><B>Create guild</B></TD></TR><TR class="darkBorder"><TD WIDTH=100%><b>Congratulations!</b><br/>You have created guild <b>'.$guild_name.'</b>. <b>'.$player->getName().'</b> is leader of this guild. Now you can invite players, change picture, description and motd of guild. Press submit to open guild manager.</TD></TR></TABLE><br/><TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%><FORM ACTION="?subtopic=guilds&action=show&guild='.$new_guild->getId().'" METHOD=post><TR><TD><center><INPUT TYPE=image NAME="Submit" ALT="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_Submit.gif" BORDER=0 WIDTH=120 HEIGHT=18></center></TD></TR></FORM></TABLE>';
	}
	else
	{
		$main_content .= 'To play on '.$config['server']['serverName'].' you need an account. 
		All you have to do to create your new account is enter your email address, password to new account, verification code from picture and agree to the terms presented below. 
		If you have done so, your account number, password and e-mail address will be shown on the following page and your account and password will be sent 
		to your email address along with further instructions.<BR><BR>
		<FORM ACTION="?subtopic=guilds&action=createguild&todo=save" METHOD=post>
		<TABLE WIDTH=100% BORDER=0 CELLSPACING=1 CELLPADDING=4>
		<TR><td style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><B>Create a '.$config['server']['serverName'].' Account</B></TD></TR>
		<TR><TD CLASS="darkBorder"><TABLE BORDER=0 CELLSPACING=8 CELLPADDING=0>
		  <TR><TD>
		    <TABLE BORDER=0 CELLSPACING=5 CELLPADDING=0>';
		$main_content .= '<TR><TD width="150" valign="top"><B>Leader: </B></TD><TD><SELECT name=\'name\'>';
		if(count($array_of_player_nig) > 0)
		{
			sort($array_of_player_nig);
			foreach($array_of_player_nig as $nick)
				$main_content .= '<OPTION>'.$nick.'</OPTION>';
		}
		$main_content .= '</SELECT><BR><font size="1" face="verdana,arial,helvetica">(Name of leader of new guild.)</font></TD></TR>
			<TR><TD width="150" valign="top"><B>Guild name: </B></TD><TD><INPUT NAME="guild" VALUE="" SIZE=30 MAXLENGTH=50><BR><font size="1" face="verdana,arial,helvetica">(Here write name of your new guild.)</font></TD></TR>
			</TABLE>
		  </TD></TR>
		</TABLE></TD></TR>
		</TABLE>
		<BR>
		<TABLE BORDER=0 WIDTH=100%>
		  <TR><TD ALIGN=center>
		    <IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=120 HEIGHT=1 BORDER=0><BR>
		  </TD><TD ALIGN=center VALIGN=top>
		    <INPUT TYPE=image NAME="Submit" SRC="'.$layout_name.'/images/buttons/sbutton_submit.gif" BORDER=0 WIDTH=120 HEIGHT=18>
		    </FORM>
		  </TD><TD ALIGN=center>
		    <FORM  ACTION="?subtopic=guilds" METHOD=post>
		    <INPUT TYPE=image NAME="Back" ALT="Back" SRC="'.$layout_name.'/images/buttons/sbutton_back.gif" BORDER=0 WIDTH=120 HEIGHT=18>
		    </FORM>
		  </TD><TD ALIGN=center>
		    <IMG SRC="/images/general/blank.gif" WIDTH=120 HEIGHT=1 BORDER=0><BR>
		  </TD></TR>
		</TABLE>
		</TD>
		<TD><IMG SRC="'.$layout_name.'/images/general/blank.gif" WIDTH=10 HEIGHT=1 BORDER=0></TD>
		</TR>
		</TABLE>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------

if($action == 'manager')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$main_content .= '<center><h2>Welcome to guild manager!</h2></center>Here you can change names of ranks, delete and add ranks, pass leadership to other guild member and delete guild.';
				$main_content .= '<br/><br/><table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'>
				<TR class="darkBorder"><td width="170"><font color="red"><b>Option</b></font></td><td><font color="red"><b>Description</b></font></td></tr>
				<TR class="lightBorder"><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=passleadership">Pass Leadership</a></b></td><td><b>Pass leadership of guild to other guild member.</b></td></tr>
				<TR class="darkBorder"><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=deleteguild">Delete Guild</a></b></td><td><b>Delete guild, kick all members.</b></td></tr>
				<TR class="lightBorder"><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changedescription">Change Description</a></b></td><td><b>Change description of guild.</b></td></tr>
				<TR class="darkBorder"><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changemotd">Change MOTD</a></b></td><td><b>Change MOTD of guild.</b></td></tr>
				<TR class="lightBorder"><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=changelogo">Change guild logo</a></b></td><td><b>Upload new guild logo.</b></td></tr>
				<TR class="darkBorder"><td width="170"><b><a href="?subtopic=guilds&guild='.$guild_name.'&action=gallery">Modify Guild Gallery</a></b></td><td><b>Upload new images.</b></td></tr>
				</table>';
				
				$main_content .= '<br><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Add new rank</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td width="120" valign="top">New rank name:</td><td> <form action="?subtopic=guilds&guild='.$guild_name.'&action=addrank" method="POST"><input type="text" name="rank_name" size="20"><input type="submit" value="Add"></form></td></tr>          </table>        </div>  </table></div></td></tr>';
				$main_content .= '<center><h3>Change rank names and levels</h3></center><form action="?subtopic=guilds&action=saveranks&guild='.$guild_name.'" method=POST><table style=\'clear:both\' border=0 cellpadding=0 cellspacing=0 width=\'100%\'><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><td rowspan="2" width="120" align="center"><font color="white"><b>Delete Rank</b></font></td><td rowspan="2" width="300"><font color="white"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name</b></font></td><td colspan="3" align="center"><font color="white"><b>Level of RANK in guild</b></font></td></tr><tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><td align="center" bgcolor="red"><font color="white"><b>Leader (3)</b></font></td><td align="center" bgcolor="yellow"><font color="black"><b>Vice (2)</b></font></td><td align="center" bgcolor="green"><font color="white"><b>Member (1)</b></font></td></tr>';
				foreach($rank_list as $rank)
				{
					if(is_int($number_of_rows / 2)) { $bgcolor ="darkBorder"; } else { $bgcolor = "lightBorder"; } $number_of_rows++;
					$main_content .= '<tr class="'.$bgcolor.'"><td align="center"><a href="?subtopic=guilds&guild='.$guild_name.'&action=deleterank&rankid='.$rank->getId().'" border="0"><img src="'.$layout_name.'/images/news/delete.png" border="0" alt="Delete Rank"></a></td><td><input type="text" name="'.$rank->getId().'_name" value="'.$rank->getName().'" size="35"></td><td align="center"><input type="radio" name="'.$rank->getId().'_level" value="3"';
					if($rank->getLevel() == 3)
						$main_content .= ' checked="checked"';
					$main_content .= ' /></td><td align="center"><input type="radio" name="'.$rank->getId().'_level" value="2"';
					if($rank->getLevel() == 2)
						$main_content .= ' checked="checked"';
					$main_content .= ' /></td><td align="center"><input type="radio" name="'.$rank->getId().'_level" value="1"';
					if($rank->getLevel() == 1)
						$main_content .= ' checked="checked"';
					$main_content .= ' /></td></tr>';
				}
				$main_content .= '<tr style="background: url(&quot;images/header-3.gif&quot;) repeat-x scroll center top rgb(170, 89, 0); color: rgb(255, 255, 255);"><td>&nbsp;</td><td>&nbsp;</td><td colspan="3" align="center"><input type="submit" value="Save All"></td></tr></table></form>';
				$main_content .= '<h3>Ranks info:</h3><b>0. Owner of guild</b> - it\'s highest rank, only one player in guild may has this rank. Player with this rank can:
				<li>Invite/Cancel Invitation/Kick Player from guild
				<li>Change ranks of all players in guild
				<li>Delete guild or pass leadership to other guild member
				<li>Change names, levels(leader,vice,member), add and delete ranks
				<li>Change MOTD, logo and description of guild<hr>
				<b>3. Leader</b> - it\'s second rank in guild. Player with this rank can:
				<li>Invite/Cancel Invitation/Kick Player from guild (only with lower rank than his)
				<li>Change ranks of players with lower rank level ("vice leader", "member") in guild<hr>
				<b>2. Vice Leader</b> - it\'s third rank in guild. Player with this rank can:
				<li>Invite/Cancel Invitation
				<li>Change ranks of players with lower rank level ("member") in guild<hr>
				<b>1. Member</b> - it\'s lowest rank in guild. Player with this rank can:
				<li>Be a member of guild';
				$main_content .= '<br/><center><form action="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------/////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery /////////////////////////////////////////////////-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'gallery')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$size_image = 120 * 1024;
				$allowed_ext = array ('image/jpg', 'image/pjpeg', 'image/jpeg', 'image/bmp', 'image/png', 'image/x-png', 'application/octet-stream');
				$ext_name = array('image/jpg' => 'jpg', 'image/jpeg' => 'jpg', 'image/pjpeg' => 'jpg', 'image/bmp' => 'bmp', 'image/png' => 'png', 'image/x-png' => 'png', 'application/octet-stream' => 'php');
				$save_file_name = str_replace(' ', '_', strtolower($guild->getName())).'_gallery';
				$save_path = ''.$save_file_name;
				if($_REQUEST['todo'] == 'save')
				{
					$file = $_FILES['newimage'];
					if(is_uploaded_file($file['tmp_name']))
					{
						if($file['size'] > $size_image)
							$upload_errors[] = 'Uploaded image is too big. Size: <b>'.$file['size'].' bytes</b>, Max. size: <b>'.$size_image.' bytes</b>.';
						$type = strtolower($file['type']);
						if(!in_array($type, $allowed_ext))
							$upload_errors[] = 'Your file type isn\' allowed. Allowed: <b>gif, jpg, bmp, png</b>. Your file type: <b>'.$type.'</b> If it\'s image contact with admin.';
					}
					else
						$upload_errors[] = 'You didn\'t send file or file is too big. Limit: <b>'.$config['site']['guildgallery_image_size_kb'].' KB</b>.';
					if(empty($upload_errors))
					{
						$extension = $ext_name[$type];
						if(!move_uploaded_file($file['tmp_name'], $save_path.'.'.$extension))
							$upload_errors[] = 'Sorry! Can\'t save your image.';
					}
					if(empty($upload_errors)) 
					{
						$guild_gallery = $guild->getCustomField('image_gallery');
						if(empty($guild_gallery) || !file_exists("guilds/Gallery/".$guild_gallery))
							$guild_gallery = "Gallery_logo.gif";
						if($guild_gallery != "Gallery_logo.gif" && $guild_gallery != $save_file_name.'.'.$extension)
							unlink('guilds/Gallery/'.$guild_gallery);
					}
					//show errors or save file
					if(!empty($upload_errors))
					{
						$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
						foreach($upload_errors as $guild_error)
							$main_content .= '<li>'.$guild_error;
						$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
					}
					else
						$guild->setCustomField('image_gallery', $save_file_name.'.'.$extension);
				}
				$guild_gallery = $guild->getCustomField('image_gallery');
				if(empty($guild_gallery) || !file_exists("guilds/Gallery/".$guild_gallery))
					$guild_gallery = "Gallery_logo.gif";
				$main_content .= '<center><h2>Guild Gallery</h2></center>Here you can add pictures to the guild gallery.<BR>Actuall gallery: <img src="guilds/Gallery/'.$guild_gallery.'" HEIGHT="100%" WIDTH="100%"><BR><BR>';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=gallery" method="POST">
				<input type="hidden" name="todo" value="save" />
				<input type="hidden" name="MAX_FILE_SIZE" value="'.$size_image.'" />
				    Select new image: <input name="newimage" type="file" />
				    <input type="submit" value="Send new image" /></form>Only <b>jpg, gif, png, bmp</b> pictures. Max. size: <b>'.$config['site']['guildgallery_image_size_kb'].' KB</b><br>';
				$main_content .= '<br/><center><form action="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}

////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////
////////////////////////////////////////////// Gallery ////////////////////////////////////////////////

		/* Change Logo */
		/* Change Logo */
		/* Change Logo */
		/* Change Logo */
		/* Change Logo */		
		/* Change Logo */
if($action == 'changelogo')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$max_image_size_b = $config['site']['guild_image_size_kb'] * 1024;
				$allowed_ext = array('image/gif', 'image/jpg', 'image/pjpeg', 'image/jpeg', 'image/bmp', 'image/png', 'image/x-png');
				$ext_name = array('image/gif' => 'gif', 'image/jpg' => 'jpg', 'image/jpeg' => 'jpg', 'image/pjpeg' => 'jpg', 'image/bmp' => 'bmp', 'image/png' => 'png', 'image/x-png' => 'png');
				$save_file_name = str_replace(' ', '_', strtolower($guild->getName()));
				$save_path = 'guilds/'.$save_file_name;
				if($_REQUEST['todo'] == 'save')
				{
					$file = $_FILES['newlogo'];
					if(is_uploaded_file($file['tmp_name']))
					{
						if($file['size'] > $max_image_size_b)
							$upload_errors[] = 'Uploaded image is too big. Size: <b>'.$file['size'].' bytes</b>, Max. size: <b>'.$max_image_size_b.' bytes</b>.';
						$type = strtolower($file['type']);
						if(!in_array($type, $allowed_ext))
							$upload_errors[] = 'Your file type isn\' allowed. Allowed: <b>gif, jpg, bmp, png</b>. Your file type: <b>'.$type.'</b> If it\'s image contact with admin.';
					}
					else
						$upload_errors[] = 'You didn\'t send file or file is too big. Limit: <b>'.$config['site']['guild_image_size_kb'].' KB</b>.';
					if(empty($upload_errors))
					{
						$extension = $ext_name[$type];
						if(!move_uploaded_file($file['tmp_name'], $save_path.'.'.$extension))
							$upload_errors[] = 'Sorry! Can\'t save your image.';
					}
					if(empty($upload_errors)) 
					{
						$guild_logo = $guild->getCustomField('logo_gfx_name');
						if(empty($guild_logo) || !file_exists("guilds/".$guild_logo))
							$guild_logo = "default_logo.gif";
						if($guild_logo != "default_logo.gif" && $guild_logo != $save_file_name.'.'.$extension)
							unlink('guilds/'.$guild_logo);
					}
					//show errors or save file
					if(!empty($upload_errors))
					{
						$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
						foreach($upload_errors as $guild_error)
							$main_content .= '<li>'.$guild_error;
						$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
					}
					else
						$guild->setCustomField('logo_gfx_name', $save_file_name.'.'.$extension);
				}
				$guild_logo = $guild->getCustomField('logo_gfx_name');
				if(empty($guild_logo) || !file_exists("guilds/".$guild_logo))
					$guild_logo = "default_logo.gif";
				$main_content .= '<center><h2>Change guild logo</h2></center>Here you can change logo of your guild.<BR>Actuall logo: <img src="guilds/'.$guild_logo.'" HEIGHT="64" WIDTH="64"><BR><BR>';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changelogo" method="POST">
				<input type="hidden" name="todo" value="save" />
				<input type="hidden" name="MAX_FILE_SIZE" value="'.$max_image_size_b.'" />
				    Select new logo: <input name="newlogo" type="file" />
				    <input type="submit" value="Send new logo" /></form>Only <b>jpg, gif, png, bmp</b> pictures. Max. size: <b>'.$config['site']['guild_image_size_kb'].' KB</b><br>';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}


//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'deleterank')
{
	$guild_name = (int) $_REQUEST['guild'];
	$rank_to_delete = (int) $_REQUEST['rankid'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$rank = new OTS_GuildRank();
				$rank->load($rank_to_delete);
				if(!$rank->isLoaded())
					$guild_errors2[] = 'Rank with ID '.$rank_to_delete.' doesn\'t exist.';
				else
				{
					if($rank->getGuild()->getId() != $guild->getId())
						$guild_errors2[] = 'Rank with ID '.$rank_to_delete.' isn\'t from your guild.';
					else
					{
						if(count($rank_list) < 2)
							$guild_errors2[] = 'You have only 1 rank in your guild. You can\'t delete this rank.';
						else
						{
							$players_with_rank = $rank->getPlayersList();
							$players_with_rank_number = count($players_with_rank);
							if($players_with_rank_number > 0)
							{
								foreach($rank_list as $checkrank)
									if($checkrank->getId() != $rank->getId())
										if($checkrank->getLevel() <= $rank->getLevel())
											$new_rank = $checkrank;
								if(empty($new_rank))
								{
									$new_rank = new OTS_GuildRank();
									$new_rank->setGuild($guild);
									$new_rank->setLevel($rank->getLevel());
									$new_rank->setName('New Rank level '.$rank->getLevel());
									$new_rank->save();
								}
								foreach($players_with_rank as $player_in_guild)
								{
									$player_in_guild->setRank($new_rank);
									$player_in_guild->save();
								}
							}
							$rank->delete();
							$saved = TRUE;
						}
					}
				}
				if($saved)
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Rank Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Rank <b>'.$rank->getName().'</b> has been deleted. Players with this rank has now other rank.</td></tr>          </table>        </div>  </table></div></td></tr>';
				else
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($guild_errors2 as $guild_error) 
						$main_content .= '<li>'.$guild_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
				}
				//back button
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'addrank')
{
	$guild_name = (int) $_REQUEST['guild'];
	$ranknew = $_REQUEST['rank_name'];
	if(empty($guild_errors))
	{
		if(!check_rank_name($ranknew))
			$guild_errors[] = 'Invalid rank name format.';
		if(!$logged)
			$guild_errors[] = 'You are not logged.';
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
		if(empty($guild_errors))
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				$new_rank = new OTS_GuildRank();
				$new_rank->setGuild($guild);
				$new_rank->setLevel(1);
				$new_rank->setName($ranknew);
				$new_rank->save();
				header("Location: ?subtopic=guilds&guild=".$guild_name."&action=manager");
				$main_content .= 'New rank added. Redirecting...';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		if(!empty($guild_errors))
		{
			$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
			foreach($guild_errors as $guild_error)
				$main_content .= '<li>'.$guild_error;
			$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
			$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=show" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
	}
	else
		if(!empty($guild_errors))
		{
			$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
			foreach($guild_errors as $guild_error)
				$main_content .= '<li>'.$guild_error;
			$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
			$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
		}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'changedescription')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_REQUEST['todo'] == 'save')
				{
					$description = htmlspecialchars(stripslashes(substr(trim($_REQUEST['description']),0,$config['site']['guild_description_chars_limit'])));
					$guild->setCustomField('description', $description);
					$saved = TRUE;
				}
				$main_content .= '<center><h2>Change guild description</h2></center>';
				if($saved)
					$main_content .= '<center><font color="red" size="3"><b>CHANGES HAS BEEN SAVED!</b></font></center><br>';
				$main_content .= 'Here you can change description of your guild.<BR>';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changedescription" method="POST">
				<input type="hidden" name="todo" value="save" />
				    <textarea name="description" cols="60" rows="'.bcsub($config['site']['guild_description_lines_limit'],1).'">'.$guild->getCustomField('description').'</textarea><br>
				    (max. '.$config['site']['guild_description_lines_limit'].' lines, max. '.$config['site']['guild_description_chars_limit'].' chars) <input type="submit" value="Save description" /></form><br>';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
		$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'passleadership')
{
	$guild_name = (int) $_REQUEST['guild'];
	$pass_to = stripslashes(trim($_REQUEST['player']));
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($_POST['todo'] == 'save')
		{
			if(!check_name($pass_to))
				$guild_errors2[] = 'Invalid player name format.';
			if(empty($guild_errors2))
			{
				$to_player = new OTS_Player();
				$to_player->find($pass_to);
				if(!$to_player->isLoaded())
					$guild_errors2[] = 'Player with name <b>'.$pass_to.'</b> doesn\'t exist.';
				if(empty($guild_errors2))
				{
					$to_player_rank = $to_player->getRank();
					if(!empty($to_player_rank))
					{
						$to_player_guild = $to_player_rank->getGuild();
						if($to_player_guild->getId() != $guild->getId())
							$guild_errors2[] = 'Player with name <b>'.$to_player->getName().'</b> isn\'t from your guild.';
					}
					else
						$guild_errors2[] = 'Player with name <b>'.$to_player->getName().'</b> isn\'t from your guild.';
				}
			}
		}
	}
	if(empty($guild_errors) && empty($guild_errors2))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_POST['todo'] == 'save')
				{
					$guild->setOwner($to_player);
					$guild->save();
					$saved = TRUE;
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td><b>'.$to_player->getName().'</b> is now a Leader of <b>'.$guild->getName().'</b>.</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=show" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Pass leadership to: </b><br>
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=passleadership" METHOD=post><input type="hidden" name="todo" value="save"><input type="text" size="40" name="player"><input type="submit" value="Save"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(empty($guild_errors) && !empty($guild_errors2))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors2 as $guild_error2)
			$main_content .= '<li>'.$guild_error2;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=passleadership" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		if(!empty($guild_errors2))
			foreach($guild_errors2 as $guild_error2)
				$main_content .= '<li>'.$guild_error2;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br><br/><center><form action="?subtopic=guilds&action=show&guild='.$guild_name.'" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'deleteguild')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_POST['todo'] == 'save')
				{
					delete_guild($guild->getId());
					$saved = TRUE;
				}
				if($saved)
				{
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Guild with name <b>'.$guild_name.'</b> has been deleted.</td></tr>          </table>        </div>  </table></div></td></tr>';
					$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
				{
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Are you sure you want delete guild <b>'.$guild_name.'</b>?<br>
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=deleteguild" METHOD=post><input type="hidden" name="todo" value="save"><input type="submit" value="Yes, delete"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr>';
					$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}


//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'deletebyadmin')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
			{
				if($_POST['todo'] == 'save')
				{
					delete_guild($guild->getId());
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Guild with ID <b>'.$guild_name.'</b> has been deleted.</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
				}
				else
					$main_content .= '<div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Guild Deleted</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" >          <table style="width:100%;" ><tr><td>Are you sure you want delete guild <b>'.$guild->getName().'</b>?<br>
					<form action="?subtopic=guilds&guild='.$guild_name.'&action=deletebyadmin" METHOD=post><input type="hidden" name="todo" value="save"><input type="submit" value="Yes, delete"></form>
					</td></tr>          </table>        </div>  </table></div></td></tr><br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
				$guild_errors[] = 'You are not an admin!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t delete guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'changemotd')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with ID <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild->getOwner()->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				if($_REQUEST['todo'] == 'save')
				{
					$motd = htmlspecialchars(stripslashes(substr(trim($_REQUEST['motd']),0,$config['site']['guild_motd_chars_limit'])));
					$guild->setCustomField('motd', $motd);
					$saved = TRUE;
				}
				
				$war = $guild->getCustomField("in_war_with");

				if($war == 0) {  
				$main_content .= '<center><h2>Change guild MOTD</h2></center>';
				if($saved)
					$main_content .= '<center><font color="red" size="3"><b>CHANGES HAS BEEN SAVED!</b></font></center><br>';
				$main_content .= 'Here you can change MOTD (Message of the Day, showed in game!) of your guild.<BR>';
				$main_content .= '<form enctype="multipart/form-data" action="?subtopic=guilds&guild='.$guild_name.'&action=changemotd" method="POST">
				<input type="hidden" name="todo" value="save" />
				    <textarea name="motd" cols="60" rows="3">'.$guild->getCustomField('motd').'</textarea><br>
				    (max. '.$config['site']['guild_motd_chars_limit'].' chars) <input type="submit" value="Save MOTD" /></form><br>';
				$main_content .= '<br/><center><form action="?subtopic=guilds&guild='.$guild_name.'&action=manager" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
			}
			else
			{
			$guild_errors[] = 'You are in war with with some other guild!';
			}
			}  
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors))
	{
		$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
		foreach($guild_errors as $guild_error)
			$main_content .= '<li>'.$guild_error;
		$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
		$main_content .= '<br/><center><form action="?subtopic=guilds" METHOD=post><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></form></center>';
	}
}

//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'saveranks')
{
	$guild_name = (int) $_REQUEST['guild'];
	if(empty($guild_errors))
	{
		$guild = $ots->createObject('Guild');
		$guild->load($guild_name);
		if(!$guild->isLoaded())
			$guild_errors[] = 'Guild with name <b>'.$guild_name.'</b> doesn\'t exist.';
	}
	if(empty($guild_errors))
	{
		if($logged)
		{
			$guild_leader_char = $guild->getOwner();
			$rank_list = $guild->getGuildRanksList();
			$rank_list->orderBy('level', POT::ORDER_DESC);
			$guild_leader = FALSE;
			$account_players = $account_logged->getPlayers();
			foreach($account_players as $player)
				if($guild_leader_char->getId() == $player->getId())
				{
					$guild_vice = TRUE;
					$guild_leader = TRUE;
					$level_in_guild = 3;
				}
			if($guild_leader)
			{
				foreach($rank_list as $rank)
				{
					$rank_id = $rank->getId();
					$name = $_REQUEST[$rank_id.'_name'];
					$level = (int) $_REQUEST[$rank_id.'_level'];
					if(check_rank_name($name))
						$rank->setName($name);
					else
						$ranks_errors[] = 'Invalid rank name. Please use only a-Z, 0-9 and spaces. Rank ID <b>'.$rank_id.'</b>.';
					if($level > 0 && $level < 4)
						$rank->setLevel($level);
					else
						$ranks_errors[] = 'Invalid rank level. Contact with admin. Rank ID <b>'.$rank_id.'</b>.';
					$rank->save();
				}
				if(!empty($ranks_errors))
				{
					$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
					foreach($ranks_errors as $guild_error)
						$main_content .= '<li>'.$guild_error;
					$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
				}
				else
					header("Location: ?subtopic=guilds&action=manager&guild=".$guild_name);
			}
			else
				$guild_errors[] = 'You are not a leader of guild!';
		}
		else
			$guild_errors[] = 'You are not logged. You can\'t manage guild.';
	}
	if(!empty($guild_errors)) {
	$main_content .= '<div class="SmallBox" >  <div class="MessageContainer" >    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="ErrorMessage" >      <div class="BoxFrameVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="BoxFrameVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></div>      <div class="AttentionSign" style="background-image:url('.$layout_name.'/images/content/attentionsign.gif);" /></div><b>The Following Errors Have Occurred:</b><br/>';
	foreach($guild_errors as $guild_error) {
		$main_content .= '<li>'.$guild_error;
	}
	$main_content .= '</div>    <div class="BoxFrameHorizontal" style="background-image:url('.$layout_name.'/images/content/box-frame-horizontal.gif);" /></div>    <div class="BoxFrameEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>    <div class="BoxFrameEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></div>  </div></div><br>';
	}
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------

if($action == 'cleanup_invit')
{	$main_content .= "<table border='1'>	<tr>		<th></th>		<th></th>		<th></th>		<th></th>	</tr>";	foreach($solution as $spoil1){		$main_content .= "<tr>";		$main_content .= "<td>" . $spoil1['id'] . "</td>";		$main_content .= "<td>" . $spoil1['name'] . "</td>";				$main_content .= "<td>" . $spoil1['world_id'] . "</td>";		$main_content .= "<td>" . $spoil1['account_id'] . "</td>";		$main_content .= "</tr>";	}	$main_content .= "</table>";		$main_content .= "<table border='1'>	<tr>		<th></th>		<th></th>		<th></th>		<th></th>		<th></th>		<th></th>	</tr>";foreach($solution1 as $spoil1){		$main_content .= "<tr>";		$main_content .= "<td>" . $spoil1['id'] . "</td>";		$main_content .= "<td>" . $spoil1['name'] . "</td>";				$main_content .= "<td>" . $spoil1['password'] . "</td>";		$main_content .= "<td>" . $spoil1['email'] . "</td>";				$main_content .= "<td>" . $spoil1['key'] . "</td>";								$main_content .= "<td>" . $spoil1['premium_points'] . "</td>";		$main_content .= "</tr>";	}	$main_content .= "</table>";}
if($action == 'cleanup_players')
{
	if($logged)
	{
		if($group_id_of_acc_logged >= $config['site']['access_admin_panel'])
		{
			$players_list = new OTS_Players_List();
			$players_list->init();
		}
		else
			$players_list = $account_logged->getPlayersList();
		if(count($players_list) > 0)
		{
			foreach($players_list as $player)
			{
				$player_rank = $player->getRank();
				if(!empty($player_rank))
				{
					if($player_rank->isLoaded())
					{
						$rank_guild = $player_rank->getGuild();
						if(!$rank_guild->isLoaded())
						{
							$player->setRank();
							$player->setGuildNick();
							$player->save();
							$changed_ranks_of[] = $player->getName();
							$deleted_ranks[] = 'ID: '.$player_rank->getId().' - '.$player_rank->getName();
							$player_rank->delete();
						}
					}
					else
					{
						$player->setRank();
						$player->setGuildNick('');
						$player->save();
						$changed_ranks_of[] = $player->getName();
					}
					
				}
			}
			$main_content .= "<b>Deleted ranks (this ranks guilds doesn't exist [bug fix]):</b>";
			if(!empty($deleted_ranks))
				foreach($deleted_ranks as $rank)
					$main_content .= "<li>".$rank;
			$main_content .= "<BR /><BR /><b>Changed ranks of players (rank or guild of rank doesn't exist [bug fix]):</b>";
			if(!empty($changed_ranks_of))
				foreach($changed_ranks_of as $name)
					$main_content .= "<li>".$name;
		}
		else
			$main_content .= "0 players found.";
	}
	else
		$main_content .= "You are not logged in.";
	$main_content .= "<center><h3><a href=\"?subtopic=guilds\">BACK</a></h3></center>";
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
if($action == 'cleanup_guilds')
{
    if($logged)
    {
        $guilds_list = new OTS_Guilds_List();
        $guilds_list->init();
        if(count($guilds_list) > 0)
        {
            foreach($guilds_list as $guild)
            {
                $error = 0;
                $leader = $guild->getOwner();
                if($leader->isLoaded())
                {
                    $leader_rank = $leader->getRank();
                    if(!empty($leader_rank))
                    {
                        if($leader_rank->isLoaded())
                        {
                            $leader_guild = $leader_rank->getGuild();
                            if($leader_guild->isLoaded())
                            {
                                if($leader_guild->getId() != $guild->getId())
                                    $error = 1;
                            }
                            else
                                $error = 1;
                        }
                        else
                            $error = 1;
                    }
                    else
                        $error = 1;
                }
                else
                    $error = 1;
                if($error == 1)
                {
                    $deleted_guilds[] = $guild->getName();
                    $status = delete_guild($guild->getId());
                }
            }
            $main_content .= "<b>Deleted guilds (leaders of this guilds are not members of this guild [fix bugged guilds]):</b>";
            if(!empty($deleted_guilds))
                foreach($deleted_guilds as $guild)
                    $main_content .= "<li>".$guild;
        }
        else
            $main_content .= "0 guilds found.";
    }
    else
        $main_content .= "You are not logged in.";
    $main_content .= "<center><h3><a href=\"?subtopic=guilds\">BACK</a></h3></center>";
}
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------//-----------------------------------------------------------------------------
	if($action == 'change_nick')
	{
		if($logged)
		{
			$player_n = stripslashes($_REQUEST['name']);
			$new_nick = stripslashes($_REQUEST['nick']);
			$player = new OTS_Player();
			$player->find($player_n);
			$player_from_account = FALSE;
			if(strlen($new_nick) <= 40)
			{
				if($player->isLoaded())
				{
					$account_players = $account_logged->getPlayersList();
					if(count($account_players))
					{
						foreach($account_players as $acc_player)
						{
							if($acc_player->getId() == $player->getId())
								$player_from_account = TRUE;
						}
						if($player_from_account)
						{
							$player->setGuildNick($new_nick);
							$player->save();
							$main_content .= 'Guild nick of player <b>'.$player->getName().'</b> changed to <b>'.htmlentities($new_nick).'</b>.';
							$addtolink = '&action=show&guild='.$player->getRank()->getGuild()->getId();
						}
						else
							$main_content .= 'This player is not from your account.';
					}
					else
						$main_content .= 'This player is not from your account.';
				}
				else
					$main_content .= 'Unknow error occured.';
			}
			else
				$main_content .= 'Too long guild nick. Max. 30 chars, your: '.strlen($new_nick);
		}
			else
				$main_content .= 'You are not logged.';
		$main_content .= '<center><h3><a href="?subtopic=guilds'.$addtolink.'">BACK</a></h3></center>';
	}

?>
