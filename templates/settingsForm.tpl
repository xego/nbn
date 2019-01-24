{**
 * plugins/pubIds/nbn/templates/settingsForm.tpl
 *
 * Copyright (c) 2003-2012 John Willinsky
 * Contributed by CILEA
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * NBN plugin settings
 *
 *}

<div id="urnSettings">

<div id="description">{translate key="plugins.pubIds.nbn.manager.settings.description"}</div>

<div class="separator"></div>
<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#nbnSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>
<br />
<form class="pkp_form" id="nbnSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="pubIds" plugin="nbnpubidplugin" verb="save"}">

<table width="100%" class="data">
   <tr valign="top">
      <td width="20%" class="label">{fieldLabel name="username" required="true" key="plugins.pubIds.nbn.settings.form.username"}</td>
      <td width="80%" class="value">
         <input type="text" name="username" value="{$username|escape}" size="20" maxlength="50" id="username" class="textField" />
      </td>
   </tr>
   <tr><td colspan="2">&nbsp;</td></tr>
   <tr valign="top">
      <td width="20%" class="label">{fieldLabel name="password" required="true" key="plugins.pubIds.nbn.settings.form.password"}</td>
      <td width="80%" class="value">
         <input type="password" name="password" value="{$password|escape}" size="20" maxlength="50" id="password" class="textField" />
      </td>
   </tr>
   <!--
   <tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td width="20%" class="label">{fieldLabel name="urnPrefix" required="true" key="plugins.pubIds.nbn.manager.settings.urnPrefix"}</td>
		<td width="80%" class="value"><input type="text" name="urnPrefix" value="{$urnPrefix|escape}" size="20" maxlength="20" id="urnPrefix" class="textField" />
		<br />
		<span class="instruct">{translate key="plugins.pubIds.nbn.manager.settings.urnPrefix.description"}</span>
		</td>
	</tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr valign="top">
		<td class="label">&nbsp;</td>
		<td class="value">
			<span class="instruct">{translate key="plugins.pubIds.nbn.manager.settings.clearURNs.description"}</span>
			<br />
			<input type="submit" name="clearPubIds" value="{translate key="plugins.pubIds.nbn.manager.settings.clearURNs"}" onclick="return confirm('{translate|escape:"jsparam" key="plugins.pubIds.nbn.manager.settings.clearURNs.confirm"}')" class="action"/>
		</td>
	</tr>
   -->
</table>

<br/>

<input type="submit" name="save" class="button defaultButton" value="{translate key="common.save"}"/><input type="button" class="button" value="{translate key="common.cancel"}" onclick="history.go(-1)"/>
</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
</div>
