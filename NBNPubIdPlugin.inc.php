<?php
/**
 * @file plugins/pubIds/nbn/NBNPubIdPlugin.inc.php
 *
 * Copyright (c) 2003-2012 John Willinsky
 * Contributed by CILEA
 * Upgraded to OJS3 by Alfredo Cosco (2019)
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class NBNPubIdPlugin
 * @ingroup plugins_pubIds_nbn
 *
 * @brief NBN registration plugin.
 * 
 */


import('classes.plugins.PubIdPlugin');

import('plugins.pubIds.nbn.classes.NbnDAO');

import('pages.search.SearchHandler');

import('classes.oai.ojs.JournalOAI');

// NBN API
define('NBN_API_URL', 'http://nbn.depositolegale.it/api/nbn_generator.pl');

// Configuration errors.
define('NBN_CONFIGERROR_SETTINGS', 0x01);

class NBNPubIdPlugin extends PubIdPlugin {
   
   	public function register($category, $path, $mainContextId = null) {
		$success = parent::register($category, $path, $mainContextId);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return $success;
		if ($success && $this->getEnabled($mainContextId)) {
			$this->_registerTemplateResource();
			HookRegistry::register('Submission::getProperties::summaryProperties', array($this, 'modifyObjectProperties'));
			HookRegistry::register('Issue::getProperties::summaryProperties', array($this, 'modifyObjectProperties'));
		}
		return $success;
	}


   /**
    * @see PKPPlugin::getDisplayName()
    */
   function getDisplayName() {
      return __('plugins.pubIds.nbn.displayName');
   }

   /**
    * @see PKPPlugin::getDescription()
    */
   function getDescription() {
      return __('plugins.pubIds.nbn.description');
   }

   // /**
   //  * @see PKPPlugin::getTemplatePath()
   //  */
   // function getTemplatePath() {
      // return parent::getTemplatePath().'templates/';
   // }  

	//
	// Implement template methods from PubIdPlugin.
	//
   /**
	 * @copydoc PKPPubIdPlugin::constructPubId()
	 */
	function constructPubId($pubIdPrefix, $pubIdSuffix, $contextId) {
		return $pubIdPrefix . ':' . $pubIdSuffix;
	}
   
   /**
    * @see PubIdPlugin::getPubIdType()
    */
   function getPubIdType() {
      return 'other::nbn';
   }

   /**
    * @see PubIdPlugin::getPubIdDisplayType()
    */
   function getPubIdDisplayType() {
      return 'NBN';
   }    

	/**
	 * @copydoc PKPPubIdPlugin::getPubIdFullName()
	 */
	function getPubIdFullName() {
		return 'National Bibliographic Number';
	}

   /**
    * @see PubIdPlugin::getResolvingURL()
    */
   function getResolvingURL($contextId, $pubId) {
      return 'http://nbn.depositolegale.it/'.urlencode($pubId);
   } 

	/**
	 * @copydoc PKPPubIdPlugin::getPubIdMetadataFile()
	 */
	function getPubIdMetadataFile() {
		//var_dump($this);
		return $this->getTemplateResource('nbnSuffixEdit.tpl');
	}

	/**
	 * @copydoc PKPPubIdPlugin::getPubIdAssignFile()
	 */
	function getPubIdAssignFile() {
		return null;//$this->getTemplatePath().'nbnAssign.tpl';
	}

	/**
	 * @copydoc PKPPubIdPlugin::instantiateSettingsForm()
	 */
	function instantiateSettingsForm($contextId) {
		$this->import('classes.form.NBNSettingsForm');
		return new NBNSettingsForm($this, $contextId);
	}
	
	/**
	 * @copydoc PKPPubIdPlugin::getFormFieldNames()
	 */
	function getFormFieldNames() {
		return array('urnSuffix');
	}
	
	/**
	 * @copydoc PKPPubIdPlugin::getAssignFormFieldName()
	 */
	function getAssignFormFieldName() {
		return 'assignNBN';
	}	
	
	/**
	 * @copydoc PKPPubIdPlugin::getPrefixFieldName()
	 */
	function getPrefixFieldName() {
		return 'nbnPrefix';
	}	

	/**
	 * @copydoc PKPPubIdPlugin::getSuffixFieldName()
	 */
	function getSuffixFieldName() {
		return 'nbnSuffix';
	}

	/**
	 * @copydoc PKPPubIdPlugin::getLinkActions()
	 */
	function getLinkActions($pubObject) {
		
		$linkActions = array();
		import('lib.pkp.classes.linkAction.request.AjaxAction');
		//import('lib.pkp.classes.linkAction.request.RemoteActionConfirmationModal');
		
		$request = Application::getRequest();
		
		/*$router = $request->getRouter();
		$dispatcher = $router->getDispatcher();
		$userVars = $request->getUserVars();
		$userVars['pubIdPlugIn'] = get_class($this);*/
		
		$contextId = $pubObject->getJournalId();
		$objectId = $pubObject->getId();
		
		// Edit object pub id

		$linkActions['editPubIdLinkActionNBN'] = new LinkAction(
			'editPubId',
			new AjaxAction(
						$request->url(
						null, 
						'grid.settings.plugins.settingsPluginGrid.Handler', 
						'manage', 
						null, 
						//$userVars
						array('verb' => 'resolve', 'plugin' => $this->getName(), 'category' => 'pubIds','context'=>$contextId, 'article'=>$objectId)
						)
					),
			__('plugins.pubIds.nbn.editor.editObjectsNBN'),
			'edit',
			__('plugins.pubIds.nbn.editor.editObjectsNBN')
		);

		$linkActions['editMultiplePubIdLinkActionNBN'] = new LinkAction(
			'editMultiplePubId',
			new AjaxAction(
						$request->url(
						null, 
						'grid.settings.plugins.settingsPluginGrid.Handler', 
						'manage', 
						null, 
						//$userVars
						array('verb' => 'multipleresolve', 'plugin' => $this->getName(), 'category' => 'pubIds','context'=>$contextId, 'issue'=>$objectId)
						)
					),
			__('plugins.pubIds.nbn.editor.editMultipleObjectsNBN'),
			'edit',
			__('plugins.pubIds.nbn.editor.editMultipleObjectsNBN')
		);

		// Clear object pub id
		/*$linkActions['clearPubIdLinkActionNBN'] = new LinkAction(
			'clearPubId',
			new RemoteActionConfirmationModal(
				$request->getSession(),
				__('plugins.pubIds.nbn.editor.clearObjectsNBN.confirm'),
				__('common.delete'),
				$request->url(null, null, 'clearPubId', null, $userVars),
				'modal_delete'
			),
			__('plugins.pubIds.nbn.editor.clearObjectsNBN'),
			'delete',
			__('plugins.pubIds.nbn.editor.clearObjectsNBN')
		);

		if (is_a($pubObject, 'Issue')) {
			// Clear issue objects pub ids
			$linkActions['clearIssueObjectsPubIdsLinkActionNBN'] = new LinkAction(
				'clearObjectsPubIds',
				new RemoteActionConfirmationModal(
					$request->getSession(),
					__('plugins.pubIds.nbn.editor.clearIssueObjectsNBN.confirm'),
					__('common.delete'),
					$request->url(null, null, 'clearIssueObjectsPubIds', null, $userVars),
					'modal_delete'
				),
				__('plugins.pubIds.nbn.editor.clearIssueObjectsNBN'),
				'delete',
				__('plugins.pubIds.nbn.editor.clearIssueObjectsNBN')
			);
		}*/

		return $linkActions;
	}
	
	/**
	 * Get the filename of the ADODB schema for this plugin.
	 * @return string Full path and filename to schema descriptor.
	 */
	function getInstallSchemaFile() {
		return $this->getPluginPath() . '/schema.xml';
	}

	/**
	 * @copydoc PKPPubIdPlugin::getSuffixPatternsFieldName()
	 */
	function getSuffixPatternsFieldNames() {
		return  array(
			'Issue' => 'nbnIssueSuffixPattern',
			'Submission' => 'nbnSubmissionSuffixPattern',
			'Representation' => 'nbnRepresentationSuffixPattern',
		);
	}

	/**
	 * @copydoc PKPPubIdPlugin::getDAOFieldNames()
	 */
	function getDAOFieldNames() {
		return array('pub-id::other::nbn');
	}

	/**
	 * @copydoc PKPPubIdPlugin::isObjectTypeEnabled()
	 */
	function isObjectTypeEnabled($pubObjectType, $contextId) {
		return (boolean) $this->getSetting($contextId, "enable${pubObjectType}NBN");
	}

	/**
	 * @copydoc PKPPubIdPlugin::isObjectTypeEnabled()
	 */
	function getNotUniqueErrorMsg() {
		return __('plugins.pubIds.nbn.editor.nbnSuffixCustomIdentifierNotUnique');
	}


	/**
	* @see PubIdPlugin::getPubId()
	*/   
	function getPubId($pubObject){

		$pubObjectType = $this->getPubObjectType($pubObject);
		$isPublished = $this->isPublished($pubObject);
		
		$journalId = $pubObject->getJournalId();
		
		//if ($pubObjectType == 'Issue' || $pubObjectType == 'Galley' || $pubObjectType == 'SuppFile') return null;	
		$nbnDAO = new NbnDAO();
		
		if ($pubObjectType == 'Issue'){
			// Set the status of any attendant queued articles to STATUS_PUBLISHED.
			$publishedArticleDao = DAORegistry::getDAO('PublishedArticleDAO');
			$publishedArticles = $publishedArticleDao->getPublishedArticles($pubObject->getId());
			
			foreach ($publishedArticles as $publishedArticle) {
				$articleId = $publishedArticle->getId();
				$nbn[$articleId] = $nbnDAO->getNBN($articleId, $journalId);		
			}	
		}
		elseif ($pubObjectType == 'Submission') {
			$articleId = $pubObject->getId();	
			$nbn = $nbnDAO->getNBN($articleId, $journalId);
			}
		else {
			return null;
			}		
		
		unset($nbnDAO);

      return $nbn;      
   }   
   
 
 	/**
	 * Retrieve a plugin setting within the given context
	 *
	 * @param $contextId int Context ID
	 * @param $name string Setting name
	 */
	function getSetting($contextId, $name) {
		if (!defined('RUNNING_UPGRADE') && !Config::getVar('general', 'installed')) return null;
		
		// Construct the argument list and call the plug-in settings DAO
		$arguments = array(
			$contextId,
			$this->getName(),
			$name,
		);
		
		$pluginName = strtolower_codesafe($this->getName());
		$pluginSettingsDao = DAORegistry::getDAO('PluginSettingsDAO');
		$cache = $pluginSettingsDao->_getCache($contextId, $pluginName);
		
		return $cache->get($name);
	}  

   //
   // Implement template methods from PubIdPlugin
   //
   /**
    * @see Plugin::manage()
    */
   	public function manage($args, $request) {
		//var_dump($request);
		$router = $request->getRouter();
		$journal = $router->getContext($request); 
		switch ($request->getUserVar('verb')) {
			case 'settings':
				$this->import('NBNSettingsForm');
				$form = new NBNSettingsForm($this, $contextId);

				if ($request->getUserVar('save')) {
					$form->readInputData();
					if ($form->validate()) {
						$form->execute($request);
						return new JSONMessage(true);
					}
				}

				$form->initData($request);
				return new JSONMessage(true, $form->fetch($request));
			case 'resolve':
				$this->generateNBN($journal,$args['article']);
				return new JSONMessage(true, 'NBN Generated');      
            break;
            case 'multipleresolve':

			$publishedArticleDao = DAORegistry::getDAO('PublishedArticleDAO');
			$publishedArticles = $publishedArticleDao->getPublishedArticles($args['issue']);
			foreach ($publishedArticles as $publishedArticle) {
				$articleId = $publishedArticle->getId();
				$this->generateNBN($journal,$articleId);

				}
			return new JSONMessage(true, 'NBN Generated');  		
            break;	
		}
		
		return parent::manage($args, $request);
	}
   
   
   
   /**
    * Generate NBN.
    *
    * @param $journal Journal
    * @param $article Article
    *
    * @return boolean|array True for success or an array of error messages.
    */   
	function generateNBN($journal, $articleId){
      
	    // Get username and password
	    $username = $this->getSetting($journal->getId(), 'username');
	    $password = $this->getSetting($journal->getId(), 'password');      
	
		$articleDao = DAORegistry::getDAO('PublishedArticleDAO'); 
		$article = $articleDao->getPublishedArticleById($articleId, $journal->getId(), true);	
	
		$request = Application::getRequest();
		$router = $request->getRouter();
		$context = $router->getContext($request);
		$dispatcher = $router->getDispatcher();
	    
	    // Retrieve Article URL
	    $articleURL = $dispatcher->url($request, ROUTE_PAGE, null, 'article', 'view', $articleId, null, null);
	    // Retrieve Article metadatas URL
	    $articleIdentifier = 'oai:' . Config::getVar('oai', 'repository_id') . ':' . 'article/' . $articleId;  
	    $params=array('verb'=>'GetRecord','metadataPrefix'=> 'oai_dc','identifier'=>urldecode($articleIdentifier));
	            
	    $metadataURL =$dispatcher->url($request,ROUTE_PAGE, null, 'oai',null, null, $params); 
	    
	    // Register NBN
	    $curlHandle = curl_init(NBN_API_URL);
	    $curl_post_data = json_encode(array(
			'action' => 'nbn_create' ,
			'url'    => $articleURL ,
	        'metadataurl' => $metadataURL
	    ));
	    $headers = array('Content-Type: application-json', 'charset: UTF-8');       
	       
	    curl_setopt($curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);  
	    curl_setopt($curlHandle, CURLOPT_USERPWD, $username . ':' . $password);
	    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($curlHandle, CURLOPT_POST, true);
	    curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $curl_post_data);
	
		$curl_response = json_decode(curl_exec($curlHandle));
	    $responseInfo  = curl_getinfo($curlHandle); 
	    curl_close($curlHandle);
	    
	    //Check response from resolver
	    if($responseInfo['http_code'] == 201){
			return $this->saveNBN($articleId, $journal->getId(), $curl_response->nbn);   
	    }elseif($responseInfo['http_code'] == 402){
			if($this->isRegistered($articleId, $journal->getId())){
	        return true;
	        }else{          
	        return $this->saveNBN($articleId, $journal->getId(), $curl_response->nbn);
			}
		}else{
			$dom = new DOMDocument();
	        $dom->loadHTML($curl_response);
	        $xpath = new DOMXpath($dom);
	        $elements = $xpath->query("//p");
	        $error = $elements->item(0)->nodeValue;
	        return array(
				array('plugins.pubIds.nbn.register.error.mdsError', "{$responseInfo['http_code']}  - $error")
	        );                 
		}
	}

   /**
    * Check whether the given article has a NBN.
    *
    * @param $articleId Article ID
    * @param $contextId Journal ID
    *
    * @return boolean
    */      
   function isRegistered($articleId, $contextId){
      $nbnDAO = new NbnDAO();
      $result = $nbnDAO->getNBN($articleId, $contextId);
      unset($nbnDAO);
      if($result){
         return true;
      }else{
         return false;
      }
   }
   
   /**
    * Save the given NBN.
    *
    * @param $articleId Article ID
    * @param $journalId Journal ID
    * @param $nbn string NBN to save
    *
    * @return boolean|array True for success or false otherwise.
    */     
   function saveNBN($articleId, $journalId, $nbn){
      $parts = explode('-', $nbn);
      $assignedString = end($parts);
      $subNamespace = str_replace('-' . $assignedString, '', $nbn);

      $nbnDAO = new NbnDAO();
      $result = true;

      if(!$nbnDAO->journalSubnamespaceExixts($journalId)){
         $result = $nbnDAO->insertJournalNamespace($journalId, $subNamespace);
      }
      if($result){
         $result = $nbnDAO->insertAssignedString($articleId, $journalId, $assignedString);
      }
      unset($nbnDAO);
      return $result;
   }   
   
   /*
    * Return articleId
    */
	function getArticleId($pubObject){
		$articleId = $pubObject->getId();
		return $articleId;
	}
   
   
   /*
    * Check if the issue or the submission is published 
    * 
    * */

	function isPublished($pubObject){
		$pubObjectType = $this->getPubObjectType($pubObject);
		
		if ($pubObjectType == 'Issue'){
			$isPublished = $pubObject->getPublished();
			}
		elseif ($pubObjectType == 'Submission'){ 
			if ($pubObject->getStatus() == STATUS_PUBLISHED){
				$isPublished = true;
				}
			else { $isPublished	= false;}
			}
				
		return $isPublished;	
	}
	
	/*
	 * Check if one or more submissions in an issue don't have a NBN:IT
	 * 
	 * */
	
	function issueArticlesDontHaveNBN($pubObject){
		$nbnDAO = new NbnDAO();
		
		$objectId=$pubObject->getId();
		$journalId = $pubObject->getJournalId();
		
		$publishedArticleDao = DAORegistry::getDAO('PublishedArticleDAO');
		$publishedArticles = $publishedArticleDao->getPublishedArticles($objectId);
		
		foreach ($publishedArticles as $publishedArticle) {
				$articleId = $publishedArticle->getId();
				//var_dump($articleId);
				$nbn[] = $nbnDAO->getNBN($articleId, $journalId);	
				//				
			}
			//var_dump($nbn);
			$issueArticlesDontHaveNBN=in_array(null, $nbn, true);
		return $issueArticlesDontHaveNBN;
		}
	
	
   
}

