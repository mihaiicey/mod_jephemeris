<?php
/**
 * $Id: default.php 90 2012-10-12 13:41:40Z lszabo $
 * @Project		Ephemeris for Joomla Module
 * @author 		Laszlo Szabo
 * @package		Ephemeris
 * @copyright	Copyright (C) 2010 Saxum 2003 Bt. All rights reserved.
 * @license 	http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL version 3
*/
defined('_JEXEC') or die();

// Display sun zodiac
switch($ephemeris['option_sun_zodiac']) {

case '1':
	echo '<div style="text-align: center;">';
	echo JHTML::_('image', $ephemeris['sun_zodiac_image'] . '_110x110.png', $ephemeris['sun_zodiac'], 'title="'.$ephemeris['sun_zodiac'].'" width="110" height="110"');
	echo '<br />';
	echo JText::sprintf('MOD_JEPHEMERIS_SUN',$ephemeris['sun_zodiac']);
	echo '</div>';
	break;

case '0':
	if('0' == $ephemeris['option_alignment']) {
		echo '<table width="100%" border="0" style="border: none;">';
		echo 	'<tr>';
		echo 		'<td width="60">';
		echo 		JHTML::_('image',$ephemeris['sun_zodiac_image'] . '_55x55.png', $ephemeris['sun_zodiac'],'title="'.$ephemeris['sun_zodiac'].'" width="55" height="55"');
		echo		'<br/>';
		echo 		'</td>';
		echo 		'<td align="left" STYLE="vertical-align:middle">';
		echo 			JText::sprintf('MOD_JEPHEMERIS_SUN',$ephemeris['sun_zodiac']);
		echo 			'<br />';
		echo 			JText::plural('MOD_JEPHEMERIS_N_DEGREE',$ephemeris['sun_zodiac_longitude']);
		echo 		'</td>';
		echo 	'</tr>';
		echo '</table>';
	} else {
		echo '<table width="100%" border="0" style="border: none;">';
		echo 	'<tr>';
		echo 		'<td align="right" STYLE="vertical-align:middle">';
		echo 			JText::sprintf('MOD_JEPHEMERIS_SUN',$ephemeris['sun_zodiac']);
		echo 			'<br />';
		echo 			JText::plural('MOD_JEPHEMERIS_N_DEGREE',$ephemeris['sun_zodiac_longitude']);
		echo 		'</td>';
		echo 		'<td width="60">';
		echo 		JHTML::_('image', $ephemeris['sun_zodiac_image'] . '_55x55.png', $ephemeris['sun_zodiac'],'title="'.$ephemeris['sun_zodiac'].'" width="55" height="55"');
		echo		'<br/>';
		echo 		'</td>';
		echo 	'</tr>';
		echo '</table>';
	}
	break;
}

// Display moon zodiac
switch($ephemeris['option_moon_zodiac']) {

case '1':
	echo '<div style="text-align: center;">';
	echo 	JHTML::_('image', $ephemeris['moon_zodiac_image'] . '_110x110.png', $ephemeris['moon_zodiac'], 'title="'.$ephemeris['moon_zodiac'].'" width="110" height="110"');
	echo	'<br />';
	echo	JText::sprintf('MOD_JEPHEMERIS_MOON', $ephemeris['moon_zodiac']);
	echo 	'<br />';
	echo	JText::plural('MOD_JEPHEMERIS_N_DEGREE', $ephemeris['moon_zodiac_longitude']);
	echo '</div>';
	break;

case '0':
	if('0' == $ephemeris['option_alignment']) {
		echo '<table width="100%" border="0" style="border: none;">';
		echo 	'<tr>';
		echo 		'<td width="60">';
		echo 		JHTML::_('image',$ephemeris['moon_zodiac_image'] . '_55x55.png', $ephemeris['moon_zodiac'], 'title="'.$ephemeris['moon_zodiac'].'" width="55" height="55"');
		echo		'<br />';
		echo 		'</td>';
		echo 		'<td align="left" STYLE="vertical-align:middle">';
		echo		JText::sprintf('MOD_JEPHEMERIS_MOON', $ephemeris['moon_zodiac']);
		echo 			'<br />';
		echo		JText::plural('MOD_JEPHEMERIS_N_DEGREE', $ephemeris['moon_zodiac_longitude']);
		echo 		'</td>';
		echo 	'</tr>';
		echo '</table>';
	} else {
		echo '<table width="100%" border="0" style="border: none;">';
		echo 	'<tr>';
		echo 		'<td align="right" STYLE="vertical-align:middle">';
		echo		JText::sprintf('MOD_JEPHEMERIS_MOON', $ephemeris['moon_zodiac']);
		echo 			'<br />';
		echo		JText::plural('MOD_JEPHEMERIS_N_DEGREE', $ephemeris['moon_zodiac_longitude']);
		echo 		'</td>';
		echo 		'<td width="60">';
		echo 		JHTML::_('image', $ephemeris['moon_zodiac_image'] . '_55x55.png', $ephemeris['moon_zodiac'], 'title="'.$ephemeris['moon_zodiac'].'" width="55" height="55"');
		echo		'<br />';
		echo 		'</td>';
		echo 	'</tr>';
		echo '</table>';
	}
	break;
}

// Display moon phase
switch($ephemeris['option_moon_phase']) {

case '1':
	echo '<div style="text-align: center;">';
	echo 	JHTML::_('image', $ephemeris['moon_phase_image'] . '_110x110.png', $ephemeris['moon_phase'], 'title="'.$ephemeris['moon_phase'].'" width="110" height="110"');
	echo	'<br />';
	echo 	$ephemeris['moon_phase'] . '<br />';
	echo	JText::plural('MOD_JEPHEMERIS_N_DAY', $ephemeris['age']);
	echo 	'<br />';
	echo '</div>';
	break;

case '0':
	if('0' == $ephemeris['option_alignment']) {
		echo '<table width="100%" border="0" style="border: none;">';
		echo 	'<tr>';
		echo 		'<td width="60">';
		echo 		JHTML::_('image', $ephemeris['moon_phase_image'] . '_55x55.png', $ephemeris['moon_phase'], 'title="'.$ephemeris['moon_phase'].'" width="55" height="55"');
		echo		'<br />';
		echo 		'</td>';
		echo 		'<td align="left" STYLE="vertical-align:middle">';
		echo 			$ephemeris['moon_phase'] . '<br />';
		echo			JText::plural('MOD_JEPHEMERIS_N_DAY', $ephemeris['age']);
		echo 		'</td>';
		echo 	'</tr>';
		echo '</table>';
	} else {
		echo '<table width="100%" border="0" style="border: none;">';
		echo 	'<tr>';
		echo 		'<td align="right" STYLE="vertical-align:middle">';
		echo 			$ephemeris['moon_phase'] . '<br />';
		echo			JText::plural('MOD_JEPHEMERIS_N_DAY', $ephemeris['age']);
		echo 		'</td>';
		echo 		'<td width="60">';
		echo 			JHTML::_('image', $ephemeris['moon_phase_image'] . '_55x55.png',$ephemeris['moon_phase'],'title="'.$ephemeris['moon_phase'].'" width="55" height="55"');
		echo		'<br />';
		echo 		'</td>';
		echo 	'</tr>';
		echo '</table>';
	}
	break;
	}
?>
<div style="float:right;">
<small>
<?php echo $check['l'];?>
</small>
</div>