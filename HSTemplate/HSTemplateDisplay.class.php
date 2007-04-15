<?php
/**
 * Class HSTemplate
 *
 * High Speed Template
 *
 * @author   AntonShevchuk (AntonShevchuk@gmail.com)
 * @access   public
 * @package  HSTemplate
 * @version  0.1
 * @created  Fri Mar 30 10:48:31 EEST 2007
 */

define("HSTEMPLATE_DISPLAY_MAIN",  "HSTEMPLATE_MAIN");

/*
display_1 -> template_1 -> var_1
                        -> var_2
                        
          -> template_2 -> var_1
                        -> var_2
                        -> var_3

*/

class HSTemplateDisplay 
{
    
    /**
     * HSTemplate
     *
     * @var HSTemplate
     */
    var $_HSTemplate;
    
    /**
     * display name
     *
     * @var string
     */
    var $_name;
    
    /**
     * options array
     *
     * @var array
     */
    var $_options = array();

    /**
     * templates array
     *
     * @var array
     */
    var $_templates = array();
    
    /**
     * var for templates
     *
     * @var array
     */
    var $_vars = array();
    
	/**
	 * Constructor of HSTemplate
	 *
	 * @param   HSTemplate $aHSTemplate
	 * @access  public
	 */
	function HSTemplateDisplay(&$aHSTemplate, $aName) 
	{
	    $this->_HSTemplate = & $aHSTemplate;
	    $this->_name       = $aName;
	}

	/**
	 * Destructor of HSTemplate 
	 *
	 * @access  public
	 */
	 function _HSTemplateDisplay()
	 {
	 	
	 }	

	 /**
	  * addTemplate
	  *
	  * add template to stack
	  *
	  * @author  dark
	  * @class   HSTemplateDisplay
	  * @access  public
	  * @param   string     $aTemplateName  template name
	  * @param   string     $aTemplateFile  template file
	  * @param   string     $aTemplatePath  template path
	  * @return  bool
	  */
	 function addTemplate($aTemplateName, $aTemplateFile, $aTemplatePath = null) 
	 {
	     if (!$aTemplatePath) {
	         $aTemplatePath = $this->_HSTemplate->_options['template_path'] . DIRECTORY_SEPARATOR . $this->_name . DIRECTORY_SEPARATOR;
	     }
	     
	     if (isset($this->_templates[$aTemplateName])) {
	         $this->_HSTemplate->setError(HSTEMPLATE_DISPLAY_ERROR_TEMPLATE_DEFINED, $aTemplateName);
	         return false;
	     } elseif (!file_exists($aTemplatePath . $aTemplateFile)) {	         
	         $this->_HSTemplate->setError(HSTEMPLATE_DISPLAY_ERROR_TEMPLATE_DEFINED, $aTemplatePath . $aTemplateFile);
	         return false;
	     } else {
	         $this->_templates[$aTemplateName] = $aTemplatePath . $aTemplateFile;
	         if (!isset($this->_vars[$aTemplateName])) {
	              $this->_vars[$aTemplateName] = array();
	         }
	         return true;
	     }
	 }

	 /**
	  * assign
	  *
	  * assign variable to all displays and templates
	  *
	  * @access  public
	  * @param   string     $aName   variable name
	  * @param   mixed      $aValue  variable value
	  * @param   string     $aTemplate template name
	  * @return  rettype  return
	  */
	 function assign($aName, $aValue, $aTemplate = HSTEMPLATE_DISPLAY_MAIN) 
	 {
	 	$this->_vars[$aTemplate][$aName] = & $aValue;
	 }
	 
	 /**
	  * clear
	  *
	  * assign variable to all displays and templates
	  *
	  * @access  public
	  * @param   string     $aName   variable name
	  * @param   string     $aTemplate template name
	  * @return  rettype  return
	  */
	 function clear($aName, $aTemplate = HSTEMPLATE_DISPLAY_MAIN) 
	 {
	     if (isset($this->_vars[$aTemplate][$aName])) {
	         unset($this->_vars[$aTemplate][$aName]);
	     }
	 }
	 
	 /**
	  * clearAll
	  *
	  * assign variable to all displays and templates
	  *
	  * @access  public
	  * @param   string     $aName   variable name
	  * @return  rettype  return
	  */
	 function clearAll($aName) 
	 {
	    $this->_vars = array();	     
	 }
	 
	 
	 /**
	  * display
	  *
	  * display all (or selected) template
	  *
	  * @access  public
	  * @param   string     $aTemplate  template name
	  * @return  rettype  return
	  */
	 function display($aTemplate = null) 
	 {
	    $oldErrorReporting = error_reporting();

	    if ($this->_HSTemplate->_options['debug']) {
	        error_reporting(E_ALL);
	    }  else {
	        error_reporting(E_ALL ^ E_NOTICE);
	    }
	    
	 	if ($aTemplate) {
            if (!isset($this->_templates[$aTemplate])) {
                $this->_HSTemplate->setError(HSTEMPLATE_DISPLAY_ERROR_TEMPLATE_NOT_DEFINED, $aTemplate);
                return false;
            }
	 	   $this->_display($aTemplate);
	 	} else {
            if (sizeof($this->_templates) == 0) {
                $this->_HSTemplate->setError(HSTEMPLATE_DISPLAY_ERROR_TEMPLATE_NOT_DEFINED, $aTemplate);
                return false;
            }
	 	    foreach ($this->_templates as $aTemplateName => $aTemplateFile) {
	 	        $this->_display($aTemplateName);
	 	    }
	 	}
	 	
	 	error_reporting($oldErrorReporting);
	 	return true;
	 }
	 
	 /**
	  * _display
	  *
	  * _display selected template
	  *
	  * @access  private
	  * @param   string     $aTemplate  template name
	  * @return  rettype  return
	  */
	 function _display($aTemplate) 
	 {
	    if (sizeof($this->_HSTemplate->_vars) > 0) {
	       extract($this->_HSTemplate->_vars);
	    }
	    
	    if (sizeof($this->_vars[HSTEMPLATE_DISPLAY_MAIN]) > 0) {
	       extract($this->_vars[HSTEMPLATE_DISPLAY_MAIN]);
	    }
	    
	    if (sizeof($this->_vars[$aTemplate]) > 0) {
	 	   extract($this->_vars[$aTemplate]);
	    }

	 	include_once($this->_templates[$aTemplate]);
	 	
	 	if (sizeof($this->_vars[HSTEMPLATE_DISPLAY_MAIN]) > 0)
	 	foreach ($this->_vars[HSTEMPLATE_DISPLAY_MAIN] as $aKey => $aValue) {
	 	    unset ($$aKey);
	 	}
	 	
	 	if (sizeof($this->_vars[$aTemplate]) > 0)
	 	foreach ($this->_vars[$aTemplate] as $aKey => $aValue) {
	 	    unset ($$aKey);
	 	}
	 }
}
?>