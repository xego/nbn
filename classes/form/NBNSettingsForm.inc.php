<?php
/**
 * @file plugins/pubIds/nbn/URNSettingsForm.inc.php
 *
 * Copyright (c) 2003-2012 John Willinsky
 * Contributed by CILEA
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class NBNSettingsForm
 * @ingroup plugins_pubIds_nbn
 *
 * @brief Form for journal managers to setup NBN plugin
 */


import('lib.pkp.classes.form.Form');

class NBNSettingsForm extends Form {

   //
   // Private properties
   //
   	/** @var integer */
	var $_contextId;
   
	/**
	 * Get the context ID.
	 * @return integer
	 */
	function _getContextId() {
		return $this->_contextId;
	}
	
	/** @var NBNPubIdPlugin */
	var $_plugin;

	/**
	 * Get the plugin.
	 * @return NBNPubIdPlugin
	 */
	function _getPlugin() {
		return $this->_plugin;
	}


   //
   // Constructor
   //
   /**
    * Constructor
    * @param $plugin NBNPubIdPlugin
    * @param $journalId integer
    */
   function __construct($plugin, $contextId) {
	   
      $this->_contextId = $contextId;
      $this->_plugin = $plugin;


      parent::__construct("../../../" . $plugin->getTemplateResource('settingsForm.tpl'));

      $this->addCheck(new FormValidatorRegExp($this, 'username', 'required', 'plugins.pubIds.nbn.manager.settings.form.usernameRequired', '/^[^:]+$/'));
      $this->addCheck(new FormValidatorRegExp($this, 'password', 'required', 'plugins.pubIds.nbn.manager.settings.form.passwordRequired', '/^[^:]+$/'));
      $this->addCheck(new FormValidatorPost($this));
   }
   


   /**
    * @see Form::initData()
    */
	function initData() {
		
		$contextId = $this->_getContextId();
		 //var_dump($contextId);
		$plugin = $this->_getPlugin();
		
		foreach($this->_getFormFields() as $fieldName => $fieldType) {
			//var_dump($this);
			$this->setData($fieldName, $plugin->getSetting($contextId, $fieldName));
		}
	}

   /**
    * @see Form::readInputData()
    */
   function readInputData() {
      $this->readUserVars(array_keys($this->_getFormFields()));
   }

   /**
    * @see Form::validate()
    */
   	function execute() {
		$contextId = $this->_getContextId();
		$plugin = $this->_getPlugin();
		foreach($this->_getFormFields() as $fieldName => $fieldType) {
			$plugin->updateSetting($contextId, $fieldName, $this->getData($fieldName), $fieldType);
		}
	}

   //
   // Private helper methods
   //
   function _getFormFields() {
      return array(
         'username' => 'string',
         'password' => 'string'
      );
   }
   
   /**
    * Check whether a given setting is optional.
    * @param $settingName string
    * @return boolean
    */
   function isOptional($settingName) {
      return in_array($settingName, array());
   }   
   
}

?>
