<?php

/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <  Generated with Cook           (100% Vitamin) |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		1.6
* @package		ZefaniaBible
* @subpackage	Zefaniabible
* @copyright	Missionary Church of Grace
* @author		Andrei Chernyshev - www.missionarychurchofgrace.org - andrei.chernyshev1@gmail.com
* @license		GNU/GPL
*
* /!\  Joomla! is free software.
* This version may have been modified pursuant to the GNU General Public License,
* and as distributed it includes or is derivative of works licensed under the
* GNU General Public License or other free or open source software licenses.
*
*             .oooO  Oooo.     See COPYRIGHT.php for copyright notices and details.
*             (   )  (   )
* -------------\ (----) /----------------------------------------------------------- +
*               \_)  (_/
*/



// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

/**
 * HTML View class for the Zefaniabible component
 *
 * @static
 * @package		Joomla
 * @subpackage	Zefaniabible
 *
 */
class ZefaniabibleViewStandard extends JViewLegacy
{
	/*
	 * Define here the default list limit
	 */
	protected $_default_limit = null;

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$config = JFactory::getConfig();
		$option	= JRequest::getCmd('option');
		$view	= JRequest::getCmd('view');
		$layout = $this->getLayout();
		switch($layout)
		{
			case 'default':
				$fct = "display_" . $layout;
				$this->$fct($tpl);
				break;
		}
	}
	function display_default($tpl = null)
	{
		/*
			Standard Bible
			a = bible
			b = book
			c = chapter
			d = commentary	
		*/		
		$app = JFactory::getApplication();
		$option	= JRequest::getCmd('option');
		$user 	= JFactory::getUser();
		
	
		// menu item overwrites
		$params = JComponentHelper::getParams( 'com_zefaniabible' );
		$menuitemid = JRequest::getInt( 'Itemid' );
		if ($menuitemid)
		{
			$menu = JSite::getMenu();
			$menuparams = $menu->getParams( $menuitemid );
			$params->merge( $menuparams );
		}
        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

		require_once(JPATH_COMPONENT_SITE.'/models/standard.php');
		$biblemodel = new ZefaniabibleModelStandard;
		
		require_once(JPATH_COMPONENT_SITE.'/models/default.php');
		$mdl_default = new ZefaniabibleModelDefault;
		$str_primary_bible = $params->get('primaryBible', $mdl_default->_buildQuery_first_record());
		$flg_show_audio_player = $params->get('show_audioPlayer', '0');
		$flg_show_references = $params->get('show_references', '0');
		$flg_show_commentary = $params->get('show_commentary', '0');
		$int_primary_book_front_end = $params->get('primary_book_frontend');
		$int_primary_chapter_front_end = $params->get('int_front_start_chapter',1);
							  
		$str_Bible_Version = JRequest::getCmd('a',$str_primary_bible);	
		$int_Bible_Book_ID = JRequest::getInt('b', $int_primary_book_front_end);
		$int_Bible_Chapter = JRequest::getInt('c', $int_primary_chapter_front_end);	
		
		$int_max_chapter = 	$biblemodel-> _buildQuery_Max_Chapter($int_Bible_Book_ID);
		$str_collation = $mdl_default->_buildQuery_collation();
		
		// redirect to last chapter
		if($int_Bible_Chapter > $int_max_chapter)
		{
			$str_redirect_url = "index.php?option=com_zefaniabible&view=".JRequest::getCmd('view')."&a=".$str_Bible_Version."&b=".$int_Bible_Book_ID.'-'.str_replace(" ","-",mb_strtolower(JText::_('ZEFANIABIBLE_BIBLE_BOOK_NAME_'.$int_Bible_Book_ID)))."&c=".$int_max_chapter.'-'.mb_strtolower(JText::_('ZEFANIABIBLE_BIBLE_CHAPTER'),'UTF-8');
			if($flg_show_commentary)
			{
				$str_redirect_url = $str_redirect_url."&d=".JRequest::getCmd('d');
			}
			$str_redirect_url = JRoute::_($str_redirect_url);
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.$str_redirect_url); 			
		}		
		$arr_Bibles = 		$biblemodel-> _buildQuery_Bibles();
		$arr_Chapter = 		$biblemodel-> _buildQuery_Chapter($str_Bible_Version,$int_Bible_Book_ID,$int_Bible_Chapter);
		$arr_References = 	$biblemodel-> _buildQuery_References($int_Bible_Book_ID,$int_Bible_Chapter);
		$int_max_verse = 	$biblemodel-> _buildQuery_Max_Verse($int_Bible_Book_ID,$int_Bible_Chapter);

		if($flg_show_references)
		{
			$obj_references = $biblemodel->_buildQuery_References($int_Bible_Book_ID,$int_Bible_Chapter);
		}
		
		if($flg_show_audio_player)
		{
			require_once(JPATH_COMPONENT_SITE.'/helpers/audioplayer.php');
			$mdl_audio = new ZefaniaAudioPlayer;
			$obj_player_one = $mdl_audio->fnc_audio_player($str_Bible_Version,$int_Bible_Book_ID,$int_Bible_Chapter, 1);
		}
		
		// commentary code
		
		$obj_commentary_dropdown = '';
		if($flg_show_commentary)
		{
			require_once(JPATH_COMPONENT_SITE.'/models/commentary.php');
			$mdl_commentary = new ZefaniabibleModelCommentary;			
			$str_primary_commentary = $params->get('primaryCommentary');
			$str_commentary = JRequest::getCmd('d', $str_primary_commentary);
			$arr_commentary =	$mdl_commentary-> _buildQuery_commentary_chapter($str_commentary,$int_Bible_Book_ID,$int_Bible_Chapter);
			$arr_commentary_list =	$mdl_commentary-> _buildQuery_commentary_list();	
			foreach($arr_commentary_list as $obj_comm_list)
			{
				if($obj_comm_list->alias == "")
				{
					JError::raiseWarning('',str_replace('%s','<b>'.$obj_comm_list->title.'</b>',JText::_('ZEFANIABIBLE_ERROR_BLANK_ALIAS_COMMENTARY')));
				}
				if($str_commentary == $obj_comm_list->alias)
				{
					$obj_commentary_dropdown = $obj_commentary_dropdown.'<option value="'.$obj_comm_list->alias.'" selected>'.$obj_comm_list->title.'</option>';
				}
				else
				{
					$obj_commentary_dropdown = $obj_commentary_dropdown.'<option value="'.$obj_comm_list->alias.'">'.$obj_comm_list->title.'</option>';
				}
			}
		}
		
		//Filters
		$config	= JComponentHelper::getParams( 'com_zefaniabible' );
		$user = JFactory::getUser();
		$this->assignRef('user',				$user);
		$this->assignRef('access',				$access);
		$this->assignRef('arr_Chapter',			$arr_Chapter);
		$this->assignRef('int_max_chapter',		$int_max_chapter);
		$this->assignRef('int_max_verse',		$int_max_verse);
		$this->assignRef('lists',				$lists);
		$this->assignRef('arr_Bibles',			$arr_Bibles);
		$this->assignRef('int_Bible_Book_ID',	$int_Bible_Book_ID);
		$this->assignRef('int_Bible_Chapter',	$int_Bible_Chapter);
		$this->assignRef('str_Bible_Version',	$str_Bible_Version);
		$this->assignRef('obj_player',			$obj_player_one);
		$this->assignRef('config',				$config);
		$this->assignRef('arr_commentary',		$arr_commentary);
		$this->assignRef('obj_commentary_dropdown',	$obj_commentary_dropdown);	
		$this->assignRef('obj_references',		$obj_references);
		$this->assignRef('str_collation',		$str_collation);	

		parent::display($tpl);
	}
}