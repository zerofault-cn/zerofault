
<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
	<td align="left" valign="bottom" colspan="2"><a class="maintitle" href="{U_VIEW_TOPIC}">{TOPIC_TITLE}</a><br />
	  <span class="gensmall"><b>{PAGINATION}</b><br />
	  &nbsp; </span></td>
  </tr>
</table>

<table width="100%" cellspacing="2" cellpadding="2" border="0">
  <tr> 
	<td align="left" valign="bottom" nowrap><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
	<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
	  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
  </tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr> 
		<td width="0%" class="mainboxLefttop"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="100%" class="mainboxTop"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="0%" class="mainboxRighttop"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
	</tr>
	<tr> 
		<td width="0%" class="mainboxLeft"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="100%" class="viewTopicBox">
		
			<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
				<tr> 
					<td class="viewTopicBoxStart">	

						<table width="100%" cellspacing="0" cellpadding="3" border="0">
							<tr align="right">
								<td class="catHead" colspan="2" height="28"><span class="top"><a href="{U_VIEW_OLDER_TOPIC}" class="nav_top">{L_VIEW_PREVIOUS_TOPIC}</a> :: <a href="{U_VIEW_NEWER_TOPIC}" class="nav_top">{L_VIEW_NEXT_TOPIC}</a> &nbsp;</span></td>
							</tr>
						</table>
						
					</td>
				</tr>
			</table>
			
		</td>
		<td width="0%" class="mainboxRight"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
	</tr>
	<tr> 
		<td width="0%" class="mainboxMiddleleft"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="100%" class="mainboxMiddlecenter"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="0%" class="mainboxMiddleright"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
	</tr>	

								{POLL_DISPLAY}

<!-- BEGIN postrow -->

	<tr> 
		<td width="0%" class="mainboxLeft"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="100%" class="viewTopicBox">

			<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
				<tr> 
					<td class="viewTopicBoxStart">

						<table width="100%" cellspacing="1" cellpadding="3" border="0">				
							<tr> 
								<td width="0%" align="left" valign="top" class="{postrow.ROW_CLASS}"><span class="name"><a name="{postrow.U_POST_ID}"></a><b>{postrow.POSTER_NAME}</b></span><br /><span class="postdetails">{postrow.POSTER_RANK}<br />{postrow.RANK_IMAGE}{postrow.POSTER_AVATAR}<br /><br />{postrow.POSTER_JOINED}<br />{postrow.POSTER_POSTS}<br />{postrow.POSTER_FROM}</span><br />                  <img src="templates/Cobalt/images/spacer.gif" width="150" height="1"></td>
								<td class="{postrow.ROW_CLASS}" width="80%" height="28" valign="top">
								
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="100%">&nbsp;<a href="{postrow.U_MINI_POST}"><img src="{postrow.MINI_POST_IMG}" width="12" height="9" alt="{postrow.L_MINI_POST_ALT}" title="{postrow.L_MINI_POST_ALT}" border="0" /></a><span class="postdetails">{L_POSTED}: {postrow.POST_DATE}<span class="gen">&nbsp;</span>&nbsp; &nbsp;{L_POST_SUBJECT}: {postrow.POST_SUBJECT}</span></td>
											<td valign="top" align="right" nowrap="nowrap">{postrow.QUOTE_IMG} {postrow.EDIT_IMG} {postrow.DELETE_IMG} {postrow.IP_IMG} <a href="#top"><img src="templates/Cobalt/images/icon_top.gif" width="22" height="19" alt="Back to top" border="0" class="imgfade" onmouseover="this.className='imgfull'" onmouseout="this.className='imgfade'"></a></td>
										</tr>
										<tr> 
											<td colspan="2"><hr class="post" /></td>
										</tr>
										<tr>
											<td colspan="2" class="postbody"><span class="postbody">{postrow.MESSAGE}{postrow.SIGNATURE}</span><span class="gensmall">{postrow.EDITED_MESSAGE}</span></td>
										</tr>
									</table>
									
								</td>
							</tr>
							<tr> 
								<td class="{postrow.ROW_CLASS}" width="150" align="left" valign="middle">&nbsp;</td>
								<td class="{postrow.ROW_CLASS}" width="100%" height="28" valign="bottom" nowrap>
								
									<table cellspacing="0" cellpadding="0" border="0" height="18" width="18">
										<tr> 
											<td valign="middle" style="padding-top: 10px" nowrap>{postrow.PROFILE_IMG} {postrow.PM_IMG} {postrow.EMAIL_IMG} {postrow.WWW_IMG} {postrow.AIM_IMG} {postrow.YIM_IMG} {postrow.MSN_IMG} {postrow.ICQ_IMG}</td>
										</tr>
									</table>
							
								</td>
							</tr>
						</table>
						
					</td>
				</tr>
			</table>
						
		</td>
		<td width="0%" class="mainboxRight"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
	</tr>
	<tr> 
		<td width="0%" class="mainboxMiddleleft"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="100%" class="mainboxMiddlecenter"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="0%" class="mainboxMiddleright"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
	</tr>	
				
<!-- END postrow -->

	<tr> 
		<td width="0%" class="mainboxLeft"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="100%" class="viewTopicBox">
				
			<table border="0" cellspacing="0" cellpadding="0" width="100%" height="100%">
				<tr> 
					<td class="viewTopicBoxStart">

						<table width="100%" cellspacing="0" cellpadding="0">
							<tr align="center"> 
								<td class="catBottom" colspan="2" height="28" align="center">
								
									<table cellspacing="0" cellpadding="0" border="0" width="100%">
										<tr>
											<form method="post" action="{S_POST_DAYS_ACTION}">
												<td align="center">
													<span class="gensmall"><span class="bottom">
														{L_DISPLAY_POSTS}: {S_SELECT_POST_DAYS}&nbsp;{S_SELECT_POST_ORDER}&nbsp;<input type="submit" value="{L_GO}" class="liteoption" name="submit" />
													</span></span>
												</td>
											{S_HIDDEN_FIELDS}</form>
										</tr>
									</table>
									
								</td>
							</tr>
						</table>
					
					</td>
				</tr>
			</table>
		
		</td>
		<td width="0%" class="mainboxRight"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
	
	<tr> 
		<td width="0%" class="mainboxLeftbottom"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="100%" valign="top" class="mainboxBottom"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
		<td width="0%" class="mainboxRightbottom"><img src="templates/Cobalt/images/spacer.gif" width="6" height="6"></td>
	</tr>
</table>
				

			
			<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
			  <tr> 
				<td align="left" valign="middle" class="tdPostImgBottom" nowrap><span class="nav"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" align="middle" /></a>&nbsp;&nbsp;&nbsp;<a href="{U_POST_REPLY_TOPIC}"><img src="{REPLY_IMG}" border="0" alt="{L_POST_REPLY_TOPIC}" align="middle" /></a></span></td>
				<td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> 
				  -> <a href="{U_VIEW_FORUM}" class="nav">{FORUM_NAME}</a></span></td>
				<td align="right" valign="top" nowrap><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span> 
				  </td>
			  </tr>
			  <tr>
				<td align="left" colspan="3"><span class="nav">{PAGE_NUMBER}</span></td>
			  </tr>
			</table>
			
			<table width="100%" cellspacing="2" border="0" align="center">
			  <tr> 
				<td width="40%" valign="top" nowrap align="left"><span class="gensmall">{S_WATCH_TOPIC}</span><br />
				  &nbsp;<br />
				  {S_TOPIC_ADMIN}</td>
				<td align="right" valign="top" nowrap>{JUMPBOX}<span class="gensmall">{S_AUTH_LIST}</span></td>
			  </tr>
			</table>
			

