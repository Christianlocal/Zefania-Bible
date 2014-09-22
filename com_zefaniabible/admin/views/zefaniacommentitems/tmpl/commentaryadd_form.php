<?php
/**                               ______________________________________________
*                          o O   |                                              |
*                 (((((  o      <  Generated with Cook           (100% Vitamin) |
*                ( o o )         |______________________________________________|
* --------oOOO-----(_)-----OOOo---------------------------------- www.j-cook.pro --- +
* @version		1.6
* @package		ZefaniaBible
* @subpackage	Zefaniacomment
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

defined('_JEXEC') or die('Restricted access');



$isNew		= ($this->zefaniacommentitems->id < 1);
$actionText = $isNew ? JText::_( "ZEFANIABIBLE_NEW" ) : JText::_( "ZEFANIABIBLE_EDIT" );
?>

<fieldset class="fieldsform">
	<legend><?php echo $actionText;?></legend>
	<?php 
		$app = JFactory::getApplication();
		$app->enqueueMessage(JText::_('ZEFANIABIBLE_WARNING_COMMENTARY_INSTALL'));	
	?>    
<a href="http://www.zefaniabible.com/documentation/documentation/36-making-commentaries.html" target="_blank"><?php echo JText::_('COM_ZEFANIABIBLE_COMMENTARY_MAKE');?></a><br />
<a href="http://www.zefaniabible.com/documentation/documentation/5-bible-installation-instrutions.html" target="_blank"><?php echo JText::_('COM_ZEFANIABIBLE_COMMENTARY_HELP');?></a>

	<table class="admintable">

		<tr>
			<td align="right" class="key">
				<label for="title">
					<?php echo JText::_( "ZEFANIABIBLE_FIELD_TITLE" ); ?> :
				</label>
			</td>
			<td>
	            <input id="title" class="inputbox " type="text" size="32" value="<?php echo $this->zefaniacommentitems->title; ?>" name="title" onblur="validateFields('title','<?php echo JText::_( "ZEFANIABIBLE_FIELD_TITLE" ); ?>')" />
			</td>
            <td>
            	<div id="title_valid" ></div>
            </td>              
		</tr>
		<tr>
			<td align="right" class="key">
				<label for="alias">
					<?php echo JText::_( "ZEFANIABIBLE_FIELD_ALIAS" ); ?> :
				</label>
			</td>
			<td>
            	<input id="alias" class="inputbox " type="text" maxlength="5" size="32" value="<?php echo $this->zefaniacommentitems->alias ?>" name="alias" onblur="validateFields('alias','<?php echo JText::_( "ZEFANIABIBLE_FIELD_ALIAS" ); ?>')" />
			</td>
            <td>
            	<div id="alias_valid" ></div>
            </td>              
		</tr>
		<tr>
			<td align="right" class="key">
				<label for="full_name">
					<?php echo JText::_( "ZEFANIABIBLE_FIELD_FULL_NAME" ); ?> :
				</label>
			</td>
			<td>
            	<input id="full_name" name="full_name" class="inputbox " value="<?php echo $this->zefaniacommentitems->full_name; ?>" size="32" type="text" onblur="validateFields('full_name','<?php echo JText::_( "ZEFANIABIBLE_FIELD_FULL_NAME" ); ?>')"> 
			</td>
            <td>
            	<div id="full_name_valid" ></div>
            </td>              
		</tr>
		<?php if ($this->access->get('core.edit.state')): ?>
		<tr>
			<td align="right" class="key">
				<label for="publish">
					<?php echo JText::_( "ZEFANIABIBLE_FIELD_PUBLISH" ); ?> :
				</label>
			</td>
			<td>
            	<input type="radio" name='publish' value="0" required="required" <?php if(!$this->zefaniacommentitems->publish){?>checked="checked" <?php } ?>/><?php echo JText::_( "JNO" ); ?>
            	<input type="radio" name='publish' value="1" required="required" <?php if($this->zefaniacommentitems->publish){?>checked="checked" <?php } ?>/><?php echo JText::_( "JYES" ); ?>
			</td>
		</tr>

		<?php endif; ?>
		<?php if ($this->access->get('core.edit') || $this->access->get('core.edit.state')): ?>
		<tr>
			<td align="right" class="key">
				<label for="ordering">
					<?php echo JText::_( "ZEFANIABIBLE_FIELD_ORDERING" ); ?> :
				</label>
			</td>
			<td>
				<?php echo JDom::_('html.form.input.ordering', array(
												'dataKey' => 'ordering',
												'dataObject' => $this->zefaniacommentitems,
												'items' => $this->lists["ordering"],
												'labelKey' => 'title',
												'aclAccess' => '',
												'validatorHandler' => "numeric"
												)); ?>
			</td>
		</tr>

		<?php endif; ?>
		<tr>
			<td align="right" class="key" valign="top">
				<label for="file_location">
					<?php echo JText::_( "ZEFANIABIBLE_FIELD_FILE_LOCATION" ); ?> :
				</label>
			</td>
			<td valign="top">
				<?php 
               	 	$params = JComponentHelper::getParams( 'com_zefaniabible' );
              		$str_commentary_path = $params->get('xmlCommentaryPath', 'media/com_zefaniabible/commentary/');
					$str_file_list = '';
					foreach($this->arr_file_list as $obj_file_list)
					{
						$str_file_list = $str_file_list .'<option value="'.$obj_file_list.'">'.$obj_file_list.'</option>';
					}
                ?>
                    <div style="float:left">			
                        <?php if($isNew){ ?>
                            <div class="input-prepend input-append">
                                <div id="file_location_icon" class="btn add-on icon-checkmark" onclick="toggleElement('file_location','file_location_folder');"> </div>
                                    <input name="file_location" id="file_location_text" class="bible_input" value="<?php echo $this->zefaniacommentitems->file_location; ?>" type="text">
                                </div>
                                <br />
                                <div class="input-prepend input-append">
                                <div id="file_location_folder_icon" class="btn add-on icon-cancel" onclick="toggleElement('file_location_folder','file_location');"> </div>
                                    <select name="file_location_folder" id="file_location_folder_text" class="bible_input" disabled="disabled"><?php echo $str_file_list; ?></select>
                                </div>
                            </div>
                        <?php }else{?>
                            <input name="file_location" id="file_location_text" value="<?php echo $this->zefaniacommentitems->file_location; ?>" size="75"  disabled="disabled" type="text">
                         <?php }?>
                    </div>                        
                <?php 
    
                if($isNew){ 
                        $params	= JComponentHelper::getParams('com_zefaniabible');
                ?>
                    <tr>
                        <td>            	
                        </td>
                        <td>
                            <div id="infoUpload1" class="intend">
                                <span id="btnUpload1"></span>
                                <button id="btnCancel1" type="button" onclick="cancelQueue(upload1);" class="ss-hide upload_button" disabled="disabled">Cancel</button>
                                <span id="biblepathinfo" class="pathinfo ss-hide hasTip" title="<?php echo JText::_('ZEFANIABIBLE_FIELD_XML_UPLOAD_UPLOADINFO_TOOLTIP'); ?>">
                                        <?php echo JText::_('ZEFANIABIBLE_FIELD_XML_UPLOAD_UPLOADINFO').' /'.trim($params->get('xmlCommentaryPath', 'media/com_zefaniabible/commentary/'), '/').'/'; ?>
                                </span>
                            </div>
                        </td>
                    </tr>
                <?php }?> 
			</td>
		</tr>
	</table>
</fieldset>
