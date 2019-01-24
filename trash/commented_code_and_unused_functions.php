<?php
   //
   // Constructor
   //
   /*function NBNPubIdPlugin() {
      parent::PubIdPlugin();
   }*/   
   
   //
   // Implement template methods from PKPPlugin.
   //
   /**
    * @see PubIdPlugin::register()
    */
   /*function register($category, $path) {
      $success = parent::register($category, $path);
      $this->addLocaleData();
      return $success;
   }*/
	function getPippo(){
		return 'pippo';
	}
	
				var_dump($storedPubId);
			var_dump($nbn);
			//$this->issueArticlesCanBeAssigned($pubObject);
			//$issueArticlesDontHaveNBN=in_array(null, $nbn, true);
			//var_dump($issueArticlesDontHaveNBN);
			//$nbn=$nbn[0];
			//
			//var_dump($nbn);
			/*if($pub==='0'){
				e "Unpublished Issue";
				}*/
				
					//var_dump($articleId);
		
		
		//$issueDao = DAORegistry::getDAO('IssueDAO');
		//$issues = $issueDao->getPublishedIssuesByNumber($journalId);



      //var_dump($issue);
      // Determine the type of the publishing object
      //$


     
      // NBNs are not enabled for issues and Galleys
      //$pubObjectType == 'Issue' || 
      
      
      //$contextId = $pubObject->getJournalId();
      
      

		//foreach($articleId as $aId){
			//var_dump($aId);

		//}
      
      
      //var_dump($contextId);
      //var_dump($articleId);
      //var_dump($nbn);
      //var_dump();
		//var_dump($this->getSetting($contextId, 'username'));
		//var_dump($this->getSetting($contextId, 'password'));
	
		$request = Application::getRequest();
		$router = $request->getRouter();
		$dispatcher = PKPApplication::getDispatcher();
		$routerShortcuts = $dispatcher->getRouterNames();
		$operation = $request->getRouter()->getRequestedOp($request);
	
			
	
      //return $nbn;
      
   //
   // Private helper methods
   //   
   /**
    * Display a list of articles for registration.
    * @param $templateMgr TemplateManager
    * @param $journal Journal
    */
   /*function _displayArticleList(&$templateMgr, &$journal, &$request) {
      $this->_setBreadcrumbs(array(), true);

      // Reagistration without account .
      $username = $this->getSetting($journal->getId(), 'username');
      $password = $this->getSetting($journal->getId(), 'password');
      $templateMgr->assign('hasCredentials', !(empty($username) && empty($password)));        
           
      // Paginate articles.
      $rangeInfo = Handler::getRangeInfo('articles');
      $search = $request->getUserVar('search');
      
      $editorSubmissionDao =& DAORegistry::getDAO('EditorSubmissionDAO');
      
      // If a search was performed, get the necessary info.      
      if(!empty($search)){         
         
         // Get the user's search conditions, if any
         $searchField = (int)$request->getUserVar('searchField');
         $searchField = $request->getUserVar('searchField');
         $searchMatch = $request->getUserVar('searchMatch');
         
         $sort = isset($sort) ? $sort : 'id';
         $sortDirection = $request->getUserVar('sortDirection');
         $sortDirection = (isset($sortDirection) && ($sortDirection == 'ASC' || $sortDirection == 'DESC')) ? $sortDirection : 'ASC';
         
         $rawSubmissions =& $editorSubmissionDao->_getUnfilteredEditorSubmissions(
            $journal->getId(),
            null,
            0,
            $searchField,
            $searchMatch,
            $search,
            null,
            null,
            null,
            null,
            $rangeInfo,
            $sort,
            $sortDirection
         );
         $articles = new DAOResultFactory($rawSubmissions, $editorSubmissionDao, '_returnEditorSubmissionFromRow', array('article_id'));       
         
		 while ($article =& $articles->next()) {
            $articleIds[] = $article->getId();
            unset($article); // Safer, because we're using references
         }
      }else{         
         // Retrieve all published articles.
         $publishedArticleDao =& DAORegistry::getDAO('PublishedArticleDAO'); 
         // @var $publishedArticleDao PublishedArticleDAO 
         $articleIds = $publishedArticleDao->getPublishedArticleIdsByJournal($journal->getId());                       
      }

      // Whether filter is on, show only not registered articles.
      $filter        = $request->getUserVar('registeredFilter');
      $filterForm    = $request->getUserVar('filterForm');
      $filterChecked = $request->getUserVar('registeredFilterChecked');
      if(!empty($filter) && $filterForm){
         $registeredFilter = true;   
      }elseif($filterChecked && empty($filterForm)){
         $registeredFilter = true;
      }else{
         $registeredFilter = false;
      }
      if($registeredFilter){
         foreach($articleIds as $index => $articleId){
            if($this->isRegistered($articleId, $journal->getId())){
               unset($articleIds[$index]);   
            }   
         }
         $templateMgr->assign('registeredFilterChecked', 'checked="checked"');
      }else{
         $templateMgr->assign('registeredFilterChecked', '');
      }
      
      $totalArticles = count($articleIds);
      if ($rangeInfo->isValid()) {
         $articles = array_slice(ArticleSearch::formatResults($articleIds), $rangeInfo->getCount() * ($rangeInfo->getPage()-1), $rangeInfo->getCount());
      }       
      
      // Instantiate article iterator.
      import('lib.pkp.classes.core.VirtualArrayIterator');
      $iterator = new VirtualArrayIterator($articles, $totalArticles, $rangeInfo->getPage(), $rangeInfo->getCount());  
      
      // Prepare and display the article template.      
      $templateMgr->assign('fieldOptions', $this->_getSearchFieldOptions());      
      $templateMgr->assign('journalId', $journal->getId());
      $templateMgr->assign_by_ref('nbn', new NbnDAO());
      $templateMgr->assign_by_ref('articles', $iterator);
      $templateMgr->display($this->getTemplatePath() . 'articles.tpl');
   }   
*/

   /**
    * Set the page's breadcrumbs, given the plugin's tree of items
    * to append.
    * @param $crumbs Array ($url, $name, $isTranslated)
    * @param $subclass boolean
    *
   function _setBreadcrumbs($crumbs = array(), $isSubclass = false) {
      $templateMgr =& TemplateManager::getManager();
      $pageCrumbs = array(
         array(
            Request::url(null, 'user'),
            'navigation.user'
         ),
         array(
            Request::url(null, 'manager'),
            'user.role.manager'
         ),
         array(
            Request::url(null, 'manager', 'plugins'),
            'manager.plugins'
         )
      );
      if ($isSubclass) $pageCrumbs[] = array(
         Request::url(null, 'manager', 'plugin', array('pubIds', $this->getName(), 'generate')),
         $this->getDisplayName(),
         true
      );

      $templateMgr->assign('pageHierarchy', array_merge($pageCrumbs, $crumbs));
   }
   
   /**
    * Display a list of issues for registration.
    * @param $templateMgr TemplateManager
    * @param $journal Journal
    */
   function _displayIssueList(&$templateMgr, &$journal) {
      $this->_setBreadcrumbs(array(), true);

      // Export without account.
      $username = $this->getSetting($journal->getId(), 'username');
      $templateMgr->assign('hasCredentials', !empty($username));  
      
      // Retrieve all published issues.
      AppLocale::requireComponents(array(LOCALE_COMPONENT_OJS_EDITOR));
      $issueDao =& DAORegistry::getDAO('IssueDAO'); /* @var $issueDao IssueDAO */
      $issues =& $issueDao->getPublishedIssues($journal->getId(), Handler::getRangeInfo('issues'));

      // Prepare and display the issue template.
      $templateMgr->assign_by_ref('issues', $issues);
      $templateMgr->display($this->getTemplatePath() . 'issues.tpl');
   }
   
   //
   // Private helper methods
   //
   /**
    * Display the plug-in home page.
    * @param $templateMgr TemplageManager
    * @param $journal Journal
    *
   function _displayPluginHomePage(&$templateMgr, &$journal) {
      $this->_setBreadcrumbs();    

      // Check for configuration errors:
      $configurationErrors = array();

      // missing plug-in setting.
      $form =& $this->_instantiateSettingsForm($journal);
      foreach($form->_getFormFields() as $fieldName => $fieldType) {
         if ($form->isOptional($fieldName)) continue;

         $setting = $this->getSetting($journal->getId(), $fieldName);
         if (empty($setting)) {
            $configurationErrors[] = NBN_CONFIGERROR_SETTINGS;
            break;
         }
      }

      $templateMgr->assign_by_ref('configurationErrors', $configurationErrors);

      // Prepare and display the index page template.
      $templateMgr->assign_by_ref('journal', $journal);
      $templateMgr->display($this->getTemplatePath() . 'index.tpl');
   }   
	
	
	   /**
    * Register publishing objects.
    *
    * @param $target Target 
    * @param $objectIds array An array with object IDs to register.
    * @param $journal Journal
    *
    * @return boolean|array True for success or an array of error messages.
    */
   function registerObjects($target, $objectIds, $journal) {
      // Registering can take a long time.
      set_time_limit(0);
      $articles = array();
      $articleDao = DAORegistry::getDAO('PublishedArticleDAO'); /* @var $articleDao PublishedArticleDAO */      
      foreach($objectIds as $objectId){
         if($target == 'issue'){
            $a = $articleDao->getPublishedArticles($objectId);
            $articles += $articleDao->getPublishedArticles($objectId);   
         }else{      
            $articles[] =& $articleDao->getPublishedArticleByArticleId($objectId, $journal->getId(), true);
         }         
      }
      // Generate NBNs.
      foreach($articles as $article) {
         $result = $this->generateNBN($journal, $article);
         if ($result !== true) {
            return $result;
         }
      }

      return true;
   }      
/*   public function manage($args,$request) {
	   
      //return 
		
      $router = $request->getRouter();
      $journal = $router->getContext($request); 
      $templateMgr = TemplateManager::getManager();
      //var_dump($request->getUserVar('verb'));     
      switch ($request->getUserVar('verb')) {
         case 'issues':
            $this->_displayIssueList($templateMgr, $journal);
            return true;
         case 'registerIssue':
            $target = 'issue';
            $objectIds = $args;
            break;
         case 'registerIssues':
            $target = 'issue';
            $objectIds = $request->getUserVar($target . 'Id');
            $request->cleanUserVar();
            break;             
         case 'articles':
            $this->_displayArticleList($templateMgr, $journal, $request);            
            return true;
         case 'registerArticle':
            $target = 'article';
            $objectIds = $args;      
            break;
         case 'registerArticles':
            $target = 'article';
            $objectIds = $request->getUserVar($target . 'Id');
            break;                    
         case 'generate':
            $this->_displayPluginHomePage($templateMgr, $journal);
            return true;
         default:
            return parent::manage($args, $request);              
            
      }
      
      // Register selected objects.
      $result = $this->registerObjects($target, $objectIds, $journal);      
      
      // Provide the user with some visual feedback that
      // registration was successful.
      if ($result === true) {
         $this->_sendNotification(
            $request,
            'plugins.pubIds.nbn.register.success',
            NOTIFICATION_TYPE_SUCCESS
         );
      }elseif ($result !== true) {
         // registration was not successful
         if (is_array($result) && !empty($result)) {
            foreach($result as $error) {
               assert(is_array($error) && count($error) >= 1);
               $this->_sendNotification(
                  $request,
                  $error[0],
                  NOTIFICATION_TYPE_ERROR,
                  (isset($error[1]) ? $error[1] : null)
               );
            }
         }
      }
      $listAction = $target . 's';
      $request->redirect(
         null, 'manager', 'plugin',
         array('pubIds', $this->getName(), $listAction), null
      );      
            
   }*/
   
   /**
    * @see PubIdPlugin::getManagementVerbs()
    */
   function getManagementVerbs() {
      $verbs = parent::getManagementVerbs();
      if ($this->getEnabled()) {
         $verbs[] = array('generate', __('plugins.pubIds.nbn.register'));
      }
      return $verbs;
   }     		
   /**
    * Add a notification.
    * @param $request Request
    * @param $message string An i18n key.
    * @param $notificationType integer One of the NOTIFICATION_TYPE_* constants.
    * @param $param string An additional parameter for the message.
    */
   function _sendNotification(&$request, $message, $notificationType, $param = null) {
      static $notificationManager = null;

      if (is_null($notificationManager)) {
         import('classes.notification.NotificationManager');
         $notificationManager = new NotificationManager();
      }

      if (!is_null($param)) {
         $params = array('param' => $param);
      } else {
         $params = null;
      }

      $user =& $request->getUser();
      $notificationManager->createTrivialNotification(
         $user->getId(),
         $notificationType,
         array('contents' => __($message, $params))
      );
   }
   
   /**
    * Get the list of fields that can be searched by contents.
    * @return array
    */
   function _getSearchFieldOptions() {

      return array(
         SUBMISSION_FIELD_TITLE => 'article.title',
         SUBMISSION_FIELD_AUTHOR => 'user.role.author'
      );
   }   

   /**
    * @see PKPPlugin::getLocaleFilename($locale)
    *
   function getLocaleFilename($locale) {
      $localeFilenames = parent::getLocaleFilename($locale);

      // Add shared locale keys.
      $localeFilenames[] = $this->getPluginPath() . DIRECTORY_SEPARATOR . 'locale' . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR . 'common.xml';

      return $localeFilenames;
   }*/
   /**
    * @see PubIdPlugin::getSettingsFormName()
    *
   function getSettingsFormName() {
      return 'classes.form.NBNSettingsForm';
   }*/   
   
/*A fail in trying to implement NBN:IT to All articles in an issue*/
/*
function issueArticlesCanBeAssigned($pubObject) {
		$nbnDAO = new NbnDAO();
		
		$objectId=$pubObject->getId();
		
		$journalId = $pubObject->getJournalId();
		
		$publishedArticleDao = DAORegistry::getDAO('PublishedArticleDAO');
		$publishedArticles = $publishedArticleDao->getPublishedArticles($objectId);

		foreach ($publishedArticles as $publishedArticle) {
			$articleId = $publishedArticle->getId();
			$pubObjectType = $this->getPubObjectType($publishedArticle);			
			$storedPubId[] = $publishedArticle->getStoredPubId('other::nbn');			
		}
		
	$issueArticlesCanBeAssigned=in_array(null, $storedPubId, true);			
	return $issueArticlesCanBeAssigned;
	}
*/   
 //From nbnSuffixExit.tpl
/*	<!--{assign var=issueArticlesCanBeAssigned value=$pubIdPlugin->issueArticlesCanBeAssigned($pubObject)}
	{if $issueArticlesCanBeAssigned}
	<p class="pkp_help">{translate key="plugins.pubIds.nbn.editor.issueArticlesCanBeAssigned"}</p>
	{include file="`$templatePath`nbnAssignCheckBox.tpl" pubId="" pubObjectType=$pubObjectType}
	{else}-->
	
	<!--{/if}-->   
	*/  

   //
   // Implement template methods from DOIExportPlugin
   //
   /**
    * @see DOIExportPlugin::getPluginId()
    *
   function getPluginId() {
      return 'NBN';
   } 

   /**
    * Return the class name of the plug-in's settings form.
    * @return string
    *
   function getSettingsFormClassName() {
      return 'NBNSettingsForm';
   }  */ 
   
	/*$urn = $pubIdPrefix . $pubIdSuffix;
	$suffixFieldName = $this->getSuffixFieldName();
	$suffixGenerationStrategy = $this->getSetting($contextId, $suffixFieldName);
	// checkNo is already calculated for custom suffixes
	if ($suffixGenerationStrategy != 'customId' && $this->getSetting($contextId, 'urnCheckNo')) {
		$urn .= $this->_calculateCheckNo($urn);
	}
	return $urn;*/	



//FROM NBNDAO.PHP
	/**
	 * Constructor.
	 */
	/*function NbnDAO() {
		parent::DAO();
	}*/
