{**
 * @file plugins/pubIds/nbn/templates/nbnAssignCheckBox.tpl
 *
 * Copyright (c) 2014-2018 Simon Fraser University
 * Copyright (c) 2003-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Displayed only if the NBN can be assigned.
 * Assign NBN form check box included in nbnSuffixEdit.tpl and nbnAssign.tpl.
 *}
 
{capture assign=translatedObjectType}{translate key="plugins.pubIds.nbn.editor.nbnObjectType"|cat:$pubObjectType}{/capture}
{capture assign=assignCheckboxLabel}{translate key="plugins.pubIds.nbn.editor.assignNBNtoArticle" pubId=$pubId pubObjectType=$translatedObjectType}{/capture}
{fbvFormSection list=true}
	{fbvElement type="checkbox" id="assignNBN" checked="true" value="1" label=$assignCheckboxLabel translate=false disabled=$disabled}
{/fbvFormSection}
