{**
 * plugins/pubIds/nbn/templates/nbnSuffixEdit.tpl
 *
 * Copyright (c) 2014-2018 Simon Fraser University
 * Copyright (c) 2003-2018 John Willinsky
 * Contributed by Alfredo Cosco (2019)
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Edit custom NBN suffix for an object (issue, submission, file)
 *
 *}
{assign var=isPublished value=$pubIdPlugin->isPublished($pubObject)}
{assign var=pubObjectType value=$pubIdPlugin->getPubObjectType($pubObject)}
{assign var=enableObjectNBN value=$pubIdPlugin->getSetting($currentContext->getId(), "enabled")}
{assign var=contextId value=$currentContext->getId()}
{assign var=articleId value=$pubIdPlugin->getArticleId($pubObject)}
{assign var=templatePath value=$pubIdPlugin->getTemplatePath()}

<!--p>pubObjectType: {$pubObjectType}</p>
<p>isPub: {$isPublished}</p-->
<!--p>Journal/ContextId:{$currentContext->getId()}</p>
<p>Article Id: {$pubIdPlugin->getArticleId($pubObject)}</p-->

<!--If the plug in is enabled show the form-->
{if $enableObjectNBN}
<!--p>enableObjectNBN:{$enableObjectNBN}</p-->
	<!--if the record (Issue or Article in an Issue) is published-->
	{if $isPublished}
		<!-- if you want an NBN:IT for a submission/article-->
		{if $pubObjectType == 'Submission'}
		{assign var=storedPubId value=$pubObject->getStoredPubId($pubIdPlugin->getPubIdType())}
		<!--p>storedPubId:{$storedPubId}</p-->
		{fbvFormArea id="pubIdNBNFormArea" class="border" title="plugins.pubIds.nbn.editor.nbn"}
		{assign var=formArea value=true}
		
		<!--if the record NBN has not an assigned nbn-->
			{if !$pubIdPlugin->getPubId($pubObject)}
				
			<!--p>templatePath:{$templatePath}</p-->
				{include file="linkAction/linkAction.tpl" action=$editPubIdLinkActionNBN contextId="publicIdentifiersForm"}
			<!--else the record has an NBN-->	
			{else} {* pub id preview *}
			
			<p>{translate key="plugins.pubIds.nbn.editor.nbnIs"}: {$pubIdPlugin->getPubId($pubObject)|escape}</p>
				
				{if $canBeAssigned}
				<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.canBeAssigned"}</p>
				{include file="`$templatePath`nbnAssignCheckBox.tpl" pubId="" pubObjectType=$pubObjectType}
				{else}
				<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.stillAssigned"}</p>
				{/if}			
			{/if}
		{/fbvFormArea}
		{else}
		{fbvFormArea id="pubIdNBNFormArea" class="border" title="plugins.pubIds.nbn.editor.nbn"}
		{assign var=formArea value=true}
		<!-- if you want an NBN:IT for all the submissions/articles in an ISSUE-->
		{assign var=issueArticlesDontHaveNBN value=$pubIdPlugin->issueArticlesDontHaveNBN($pubObject)}
		
			{if $issueArticlesDontHaveNBN}
			<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.issueArticlesDontHaveNBN"}</p>
			{include file="linkAction/linkAction.tpl" action=$editMultiplePubIdLinkActionNBN contextId="publicIdentifiersForm"}
			{else}
			<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.issueAllArticlesHaveNBN"}</p>
	
			{/if}
		{/fbvFormArea}	
		{/if}
	{else}
	<!--if the record is NOT published you get an advise -->
		<p><strong>{translate key=plugins.pubIds.nbn.editor.nbn}</strong></p>
		<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.unPublishedIssue"}</p>
	{/if}
{/if}
<!-- if NBN:IT is not enables you don't see nothing-->
