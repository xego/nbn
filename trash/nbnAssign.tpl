{**
 * @file plugins/pubIds/nbn/templates/nbnAssign.tpl
 *
 * Copyright (c) 2014-2018 Simon Fraser University
 * Copyright (c) 2003-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Assign NBN to an object option.
 *}

{assign var=pubObjectType value=$pubIdPlugin->getPubObjectType($pubObject)}
{assign var=enableObjectNBN value=$pubIdPlugin->getSetting($currentContext->getId(), "enable`$pubObjectType`NBN")}
{if $enableObjectNBN}
	{fbvFormArea id="pubIdNBNFormArea" class="border" title="plugins.pubIds.nbn.editor.nbn"}
	{if $pubObject->getStoredPubId($pubIdPlugin->getPubIdType())}
		{fbvFormSection}
			<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.assignNBN.assigned" pubId=$pubObject->getStoredPubId($pubIdPlugin->getPubIdType())}</p>
		{/fbvFormSection}
	{else}
		{assign var=pubId value=$pubIdPlugin->getPubId($pubObject)}
		{if !$canBeAssigned}
			{fbvFormSection}
				{if !$pubId}
					<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.assignNBN.emptySuffix"}</p>
				{else}
					<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.assignNBN.pattern" pubId=$pubId}</p>
				{/if}
			{/fbvFormSection}
		{else}
			{assign var=templatePath value=$pubIdPlugin->getTemplatePath()}
			{include file="`$templatePath`nbnAssignCheckBox.tpl" pubId=$pubId pubObjectType=$pubObjectType}
		{/if}
	{/if}
	{/fbvFormArea}
{/if}
