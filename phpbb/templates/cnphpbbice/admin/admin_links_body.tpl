
<h1>{PAGE_TITLE}</h1>
<p>{PAGE_EXPLAIN}</p>

<table width="100%" cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<form method="post" action="{PAGE_ACTION}">
	<tr>
	  <td class="row1" nowrap="nowrap">{L_SEARCH_SITE}</td>
	  <td class="row1" colspan="8" nowrap="nowrap" align="right">{L_SEARCH_SITE_TITLE}<input type="text" style="width: 200px" class="post" name="search_keywords" size="30" />&nbsp;<input type="submit" name="submit" value="{L_SUBMIT}" class="catbutton" /></td>
	</tr>
	</form>
	<tr>
		<th class="thCornerL" nowrap="nowrap">{L_LINK_TITLE}</th>
		<th class="thTop" nowrap="nowrap">{L_LINK_CATEGORY}</th>
		<th class="thTop" nowrap="nowrap">{L_LINK_USER}</th>
		<th class="thTop" nowrap="nowrap">{L_LINK_JOINED}</th>
		<th class="thTop" nowrap="nowrap">{L_LINK_USER_IP}</th>
		<th class="thTop" nowrap="nowrap">{L_LINK_ACTIVE}</th>
		<th class="thTop" nowrap="nowrap">{L_LINK_HITS}</th>
		<th class="thCornerR" colspan="2">&nbsp;</th>
	</tr>
	<!-- BEGIN linkrow -->
	<tr>
		<td class="{linkrow.ROW_CLASS}" nowrap="nowrap"><a href="{linkrow.LINK_URL}" target="_blank">{linkrow.LINK_TITLE}</a></td>
		<td class="{linkrow.ROW_CLASS}" align="center" nowrap="nowrap">{linkrow.LINK_CATEGORY}</td>
		<td class="{linkrow.ROW_CLASS}" align="center" nowrap="nowrap">{linkrow.U_LINK_USER}</td>
		<td class="{linkrow.ROW_CLASS}" nowrap="nowrap">{linkrow.LINK_JOINED}</td>
		<td class="{linkrow.ROW_CLASS}" align="center" nowrap="nowrap">{linkrow.LINK_USER_IP}</td>
		<td class="{linkrow.ROW_CLASS}" align="center" nowrap="nowrap">{linkrow.LINK_ACTIVE}</td>
		<td class="{linkrow.ROW_CLASS}" align="center" nowrap="nowrap">{linkrow.LINK_HITS}</td>
		<td class="{linkrow.ROW_CLASS}" nowrap="nowrap">
		<a href="{U_LINK}?mode=edit&link_id={linkrow.LINK_ID}">{L_EDIT}</a>
		<a href="{U_LINK}?mode=delete&link_id={linkrow.LINK_ID}">{L_DELETE}</a>	
		</td>
	</tr>
	<!-- END linkrow -->
</table><br />
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
		<td align="right"><span class="nav">{PAGINATION}</span></td>
	</tr>
</table>
<br clear="all" />
<div align="center"><span class="copyright">Links MOD v1.2.1 by <a href="http://www.phpbb2.de" target="_blank">phpBB2.de</a> and OOHOO and CRLin</span></div>
<br clear="all" />
