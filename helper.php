<?php
	use Joomla\CMS\Factory;
	use Joomla\CMS\Date\Date;


/**
 * Helper class for ZAttendance module
 * 
 * @subpackage Modules
 * @link http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
 * @license        GNU/GPL, see LICENSE.php
 * mod_zattendance is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class ModZAttendanceHelper
{

public function getFiltr_jmeno() 
		{
			$db = JFactory::getDbo();
// Retrieve the shout

			$query = $db->getQuery(true)
            ->select($db->quoteName(array('gymnastic_id', 'gymnastic_name')))
            ->from($db->quoteName('#__gymnastics'))
				->group($db->quoteName('gymnastic_id'))  ;
// Prepare the query
			$db->setQuery($query);
			$results = $db->loadObjectList();
// Return the filtr

			return $results; 
	}

public function getInsert() 
	{
 		$app = Factory::getApplication();
 		$input = $app->input;
		$odeslano = $input->post->get('Uloz', '', 'STRING');
 		if (!empty($odeslano)) 
 		 {    
			$gymnastic_id = $input->post->get('jmeno_filtr', '', 'INT');
			$date = $input->post->get('datum', '', 'STRING');
			
 			$strdate = new Date($date);
			$strdate = $strdate->toSQL();
 			$strdate = '"'.$strdate.'"';
			
			$date_only = substr($date,0,10);
			$date_min_str = $date_only.' 00:00:00';
			$date_max_str = $date_only.' 23:59:59';
			$note =  $input->post->get('note_null', '', 'STRING');			
			$note_not_null = $input->post->get('note', '', 'STRING');
 			if(strlen($note_not_null)>0)
				{
							$note = '"'.$note_not_null.'"';
							}
			$db = JFactory::getDbo();
			$query = $db
		    ->getQuery(true)
		    ->select('COUNT(*)')
    		->from($db->quoteName('#__attendance'))
    		->where($db->quoteName('gymnastic_id') . " = " . $db->quote($gymnastic_id))
			->where ($db->quoteName('date') . " >= " . $db->quote($date_min_str))
			->where ($db->quoteName('date') . " <= " . $db->quote($date_max_str));
// Reset the query using our newly populated query object.
			$db->setQuery($query);
			$count = $db->loadResult();

// Retrieve the shout
		if($count == 0) {	
			$query = $db->getQuery(true);
			$columns = array('gymnastic_id',note,'date');
			$values = array($gymnastic_id,$note,$strdate);
			$query
    			->insert($db->quoteName('#__attendance'))
    			->columns($db->quoteName($columns))
    			->values(implode(',', $values));
// Set the query using our newly populated query object and execute it.
			$db->setQuery($query);
			$db->execute();
		$result="Ulozeno";
				}
			else {
				$result="Gymnasta neni stachanovec, nemuze byt na jednom treninku 2x !";
					}
			}
		return $result;				
		
	}
	public function getAttendance() 
	{
 		$app = Factory::getApplication();
 		$input = $app->input;
		$odeslano = $input->post->get('Zobraz', '', 'STRING');
		if (!empty($odeslano)) 
 		 {  
/*			$seznam = $input->post->get('jform','','ARRAY');
			echo '<pre>'; print_r($seznam); echo '</pre>';
		*/
		$gymnasta_filtr=$input->post->get('dochazka_gymnasta_filtr','%','STRING');
		   if(empty($gymnasta_filtr))
   			{
   	   		$gymnasta = '%';
   	   	}	
   	   	else
   	   	{ 
   				$gymnasta = ($gymnasta_filtr);
   			}	
			$date_od = $input->post->get('datum_od', '', 'STRING');
 			$date_do = $input->post->get('datum_do', '', 'STRING');
			$date_od_str = $date_od.' 00:00:00';
			$date_do_str = $date_do.' 23:59:59';
 		 	$db = JFactory::getDbo();
			$query = $db
		    	->getQuery(true)
		    	->select($db->quoteName(array('s.gymnastic_id','a.date','s.gymnastic_name')))
    			->from($db->quoteName('#__gymnastics','s'))
				->join('LEFT',$db->quoteName('#__attendance', 'a').' on ' . $db->quoteName('s.gymnastic_id').' = '. $db->quoteName('a.gymnastic_id'))  			
    			->where ($db->quoteName('a.date') . " >= " . $db->quote($date_od_str))
				->where ($db->quoteName('a.date') . " <= " . $db->quote($date_do_str))
				->where ($db->quoteName('s.gymnastic_id')." LIKE ".$db->quote($gymnasta))
				->order($db->quoteName('a.date') . ' DESC')
				->order($db->quoteName('s.gymnastic_id') . ' DESC');
// Reset the query using our newly populated query object.
			$db->setQuery($query);
			$results = $db->loadObjectList();
			return $results; 
 		}
	
	}
}
