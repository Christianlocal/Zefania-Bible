<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.6.4   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		3.2
* @package		ZefaniaBible
* @subpackage	Zefaniaverseofday
* @copyright	Missionary Church of Grace
* @author		Andrei Chernyshev - www.propoved.org - andrei.chernyshev1@gmail.com
* @license		GNU/GPL
*
*             .oooO  Oooo.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

if (!class_exists('ZefaniabibleClassFormField'))
	require_once(JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR. 'components' .DIRECTORY_SEPARATOR. 'com_zefaniabible' .DIRECTORY_SEPARATOR. 'helpers' .DIRECTORY_SEPARATOR. 'loader.php');


/**
* Form field for Zefaniabible.
*
* @package	Zefaniabible
* @subpackage	Form
*/
class ZefaniabibleCkJFormFieldModal_Zefaniaverseofdayitem extends ZefaniabibleClassFormFieldModal
{
	/**
	* Default label for the picker.
	*
	* @var string
	*/
	protected $_nullLabel = 'ZEFANIABIBLE_DATA_PICKER_SELECT_ZEFANIAVERSEOFDAY_ITEM';

	/**
	* Option in URL
	*
	* @var string
	*/
	protected $_option = 'com_zefaniabible';

	/**
	* Modal Title
	*
	* @var string
	*/
	protected $_title;

	/**
	* View in URL
	*
	* @var string
	*/
	protected $_view = "zefaniaverseofday";

	/**
	* Field type
	*
	* @var string
	*/
	protected $type = 'modal_zefaniaverseofdayitem';

	/**
	* Method to get the field input markup.
	*
	* @access	protected
	*
	* @return	string	The field input markup.
	*
	* @since	11.1
	*/
	protected function getInput()
	{
		$db	= JFactory::getDBO();
		$db->setQuery(
			'SELECT `book_name`' .
			' FROM #__zefaniabible_zefaniaverseofday' .
			' WHERE id = '.(int) $this->value
		);
		$this->_title = $db->loadResult();

		if ($error = $db->getErrorMsg()) {
			JError::raiseWarning(500, $error);
		}


		return parent::getInput();
	}


}

// Load the fork
ZefaniabibleHelper::loadFork(__FILE__);

// Fallback if no fork has been found
if (!class_exists('JFormFieldModal_Zefaniaverseofdayitem')){ class JFormFieldModal_Zefaniaverseofdayitem extends ZefaniabibleCkJFormFieldModal_Zefaniaverseofdayitem{} }
