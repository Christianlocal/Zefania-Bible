<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <    Generated with Cook Self Service  V2.6.4   |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		3.2
* @package		ZefaniaBible
* @subpackage	Zefaniacomment
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



/**
* Zefaniabible Table class
*
* @package	Zefaniabible
* @subpackage	Zefaniacommentitems
*/
class ZefaniabibleCkTableZefaniacommentitems extends ZefaniabibleClassTable
{
	/**
	* Constructor
	*
	* @access	public
	* @param	object	&$db	Database connector object
	* @param	string	$tbl	Table name
	* @param	string	$key	Primary key
	* @return	void
	*/
	public function __construct(&$db, $tbl = '#__zefaniabible_zefaniacomment', $key = 'id')
	{
		parent::__construct($tbl, $key, $db);
	}


}

// Load the fork
ZefaniabibleHelper::loadFork(__FILE__);

// Fallback if no fork has been found
if (!class_exists('ZefaniabibleTableZefaniacommentitems')){ class ZefaniabibleTableZefaniacommentitems extends ZefaniabibleCkTableZefaniacommentitems{} }

