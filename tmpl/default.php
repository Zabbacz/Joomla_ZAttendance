<?php
// No direct access
defined('_JEXEC') or die;
use Joomla\CMS\Date\Date;
use Joomla\CMS\HTML\HTMLHelper;
JHtml::stylesheet($root.'/modules/mod_zattendance/css/styl.css');
$currentTime = new Date('now');
$date_week = new Date('now -7 day');
?>
<form method="post">
<fieldset>
	<legend>Dochazka zadej</legend>	
<?php
echo JHTML::calendar(date("Y-m-d"),'datum', 'datum', '%Y-%m-%d',array('size'=>'8','maxlength'=>'10','class'=>' validate[\'required\']',));
?>     
			<select id="jmeno_filtr" name="jmeno_filtr">
			<optgroup label=" Jmeno ">
<?php	foreach($filtrjmeno as $row){ ?>
			<option value= <?= $row->gymnastic_id ?>><?= $row->gymnastic_name ?></option>
				<?php	} ?>
			</optgroup>
			</select>	
<!--	<fieldset id="jform_toppings" class="checkboxes">
	<ul>
<?php
	//	foreach($filtrjmeno as $row){ ?>
		<li>
	<input type="checkbox" name="jform[entry][<?php echo $row->gymnastic_id; ?>][name]" value="<?php echo $row->gymnastic_id; ?>"> <?php //echo $row->gymnastic_name; ?>
    			
			</li>			
				<?php	//} ?>			
	</ul>
	</fieldset>		
-->	
			<input type="text" name="note" placeholder="Poznámka">
			<input type='hidden' name="note_null" value="NULL">		
			<input type="submit" name="Uloz" class="tlacitko"  value="Ulož" >
</fieldset>	
			<p><?= $ulozeno ?></p>
<fieldset>
	<legend>Dochazka</legend>	

<?php
echo "od : ".JHTML::calendar($date_week,'datum_od', 'datum_od', '%Y-%m-%d',array('size'=>'8','maxlength'=>'10','class'=>' validate[\'required\']',));
echo "do : ".JHTML::calendar(date("Y-m-d"),'datum_do', 'datum_od', '%Y-%m-%d',array('size'=>'8','maxlength'=>'10','class'=>' validate[\'required\']',));
?>
			<select name="dochazka_gymnasta_filtr">
			<optgroup label=" Gymnasta ">
			<option value="">---- všichni -----</option>
<?php	foreach($filtrjmeno as $row){ ?>
			<option value= <?= $row->gymnastic_id ?>><?= $row->gymnastic_name ?></option>
				<?php	} ?>
			</optgroup>
			</select>

<input type="submit" name="Zobraz" class="tlacitko"  value="Zobraz" >
<table>
<tr>
<th>jmeno</th>
<th>datum</th>
</tr>

<?php	foreach($dochazka as $rows){ ?>
<?php
$originalDate = $rows->date ;
$newDate = date("l jS \of F Y", strtotime($originalDate));
?>

<tr>
<td><?= $rows->gymnastic_name ?></td>
<td><?= $newDate ?></td>
</tr>
<?php	} ?>
</table>			
				
</fieldset>	

</form>

