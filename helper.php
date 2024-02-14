<?php
/**
 * $Id: helper.php 3 2013-08-05 11:53:07Z Szablac $
 * @Project		Ephemeris for Joomla Module
 * @author 		Laszlo Szabo
 * @package		Ephemeris
 * @copyright	Copyright (C) 2010 Saxum 2003 Bt. All rights reserved.
 * @license 	http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL version 3
*/
defined('_JEXEC') or die('Restricted access');

class ModJephemerisHelper {
	
	function ephemeris_normalize($v) {
		$v -= floor($v);
		if($v < 0) {
			$v += 1;
		}
		return $v;
	}
	
	function getLayout($params){	
		
		// Get options
		$ephemeris['option_alignment'] = $params->get('alignment','');
		$ephemeris['option_sun_zodiac'] = $params->get('sun_zodiac','');
		$ephemeris['option_moon_zodiac'] = $params->get('moon_zodiac','');
		$ephemeris['option_moon_phase'] = $params->get('moon_phase','');
		
		require_once 'Astro_MoonPhase.php';
		// Get date
		$y = date('Y');
		$m = date('n');
		$d = date('j');
		
		// Calculate julian day
		/*$yy = $y - floor((12 - $m) / 10);
		$mm = $m + 9;
		if($mm >= 12) {
			$mm = $mm - 12;
		}
		
		$k1 = floor(365.25 * ($yy + 4712));
		$k2 = floor(30.6 * $mm + 0.5);
		$k3 = floor(floor(($yy / 100) + 49) * 0.75) - 38;
		
		$jd = $k1 + $k2 + $d + 59;
		if($jd > 2299160) {
			$jd = $jd - $k3;
		}*/
		$a=floor((14-$m)/12);
		$yy=$y+4800-$a;
		$mm=$m+12*$a-3;
		$jd=$d+floor((153*$mm+2)/5)+365*$yy+floor($yy/4)-floor($yy/100)+floor($yy/400)-32045;
		
		// Calculate the moon's phase		
  		$moondata = Astro_MoonPhase::phase(strtotime(jFactory::getDate()));
		//$ip = ModJephemerisHelper::ephemeris_normalize(($jd - 2451550.1) / 29.530588853);
		//$ip = ($jd-2451550.1)/29.530588853-floor(($jd-2451550.1)/29.530588853);
  		$ip=$moondata[0];
		//$ag = $ip * 29.530588853;
		$ag=$moondata[2];
  		
		if($ag < 1.84566) {
			$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_NEW_MOON');
			$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/new_moon';
		}
	    else if($ag < 5.53699) {
	    $ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_WAXING_CRESCENT_MOON');
		$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/waxing_crescent_moon';
	    }
	    else if($ag < 9.22831) {
		$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_FIRST_QUARTER_MOON');
		$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/first_quarter_moon';
		}
		else if($ag < 12.91963) {
			$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_WAXING_GIBBOUS_MOON');
			$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/waxing_gibbous_moon';
		}
		else if($ag < 16.61096) {
			$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_FULL_MOON');
			$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/full_moon';
		}
		else if($ag < 20.30228) {
			$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_WANING_GIBBOUS_MOON');
			$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/waning_gibbous_moon';
		}
		else if($ag < 23.99361) {
			$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_THIRD_QUARTER_MOON');
			$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/third_quarter_moon';
		}
		else if($ag < 27.68493) {
			$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_WANING_CRESCENT_MOON');
			$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/waning_crescent_moon';
		}
		else {
			$ephemeris['moon_phase'] = JText::_('MOD_JEPHEMERIS_NEW_MOON');
			$ephemeris['moon_phase_image'] = 'images/jephemeris/moon/new_moon';
		}
		
		// Convert phase to radians
		$ip = $ip * 2 * pi();
		
		// Calculate moon's distance
		$dp = 2 * pi() * ModJephemerisHelper::ephemeris_normalize(($jd - 2451562.2) / 27.55454988);
		$di = 60.4 - 3.3 * cos($dp) - 0.6 * cos(2 * $ip - $dp) - 0.5 * cos(2 * $ip);
		
		// Calculate moon's ecliptic latitude
		$np = 2 * pi() * ModJephemerisHelper::ephemeris_normalize(($jd - 2451565.2) / 27.212220817);
		$la = 5.1 * sin($np);
		
		// Calculate moon's ecliptic longitude
		$rp = ModJephemerisHelper::ephemeris_normalize(($jd - 2451555.8) / 27.321582241);
		$lo = 360 * $rp + 6.3 * sin($dp) + 1.3 * sin(2 * $ip - $dp) + 0.7 * sin(2 * $ip);
		
		// Calculate moon's zodiac sign
		if($lo < 30) {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_ARIES');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/aries';
		}
		else if($lo < 60) {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_TAURUS');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/taurus';
		}
		else if($lo < 90) {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_GEMINI');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/gemini';
		}
		else if($lo < 120) {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_CANCER');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/cancer';
		}
		else if($lo < 150) {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_LEO');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/leo';
		}
		else if($lo < 180) {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_VIRGO');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/virgo';
		}
		else if($lo < 210) {
		    $ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_LIBRA');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/libra';
		}
		    else if($lo < 240) {
		    $ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_SCORPIO');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/scorpio';
		    }
		    else if($lo < 270) {
		    $ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_SAGITTARIUS');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/sagittarius';
		    }
		    else if($lo < 300) {
		    $ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_CAPRICORN');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/capricorn';
		    }
		    else if($lo < 330) {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_AQUARIUS');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/aquarius';
		    }
		else {
			$ephemeris['moon_zodiac'] = JText::_('MOD_JEPHEMERIS_PISCES');
			$ephemeris['moon_zodiac_image'] = 'images/jephemeris/zodiac/pisces';
		}
		
		// Age
		$ephemeris['age'] = floor($ag);
		
		// Distance
		$distance = round(100 * $di) / 100;
		
		// Ecliptic latitude
		$latitude = round(100 * $la) / 100;
		
		// Ecliptic longitude
		$longitude = round(100 * $lo) / 100;
		if($longitude > 360) {
			$longitude -= 360;
		}
		$ephemeris['moon_zodiac_longitude'] = round($longitude % 30);
		
		// Calculate sun's zodiac sign
		if((($m == 1) && ($d >= 20)) || (($m == 2) && ($d <= 18))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_AQUARIUS');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/aquarius';
		} else if((($m == 2) && ($d >= 19)) || (($m == 3) && ($d <= 20))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_PISCES');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/pisces';
		} else if((($m == 3) && ($d >= 21)) || (($m == 4) && ($d <= 19))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_ARIES');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/aries';
		} else if((($m == 4) && ($d >= 20)) || (($m == 5) && ($d <= 20))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_TAURUS');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/taurus';
		} else if((($m == 5) && ($d >= 21)) || (($m == 6) && ($d <= 21))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_GEMINI');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/gemini';
		} else if((($m == 6) && ($d >= 22)) || (($m == 7) && ($d <= 22))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_CANCER');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/cancer';
		} else if((($m == 7) && ($d >= 23)) || (($m == 8) && ($d <= 22))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_LEO');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/leo';
		} else if((($m == 8) && ($d >= 23)) || (($m == 9) && ($d <= 22))) {
			$ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_VIRGO');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/virgo';
		} else if((($m == 9) && ($d >= 23)) || (($m == 10) && ($d <= 22))) {
		    $ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_LIBRA');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/libra';
		} else if((($m == 10) && ($d >= 23)) || (($m == 11) && ($d <= 21))) {
		    $ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_SCORPIO');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/scorpio';
		} else if((($m == 11) && ($d >= 22)) || (($m == 12) && ($d <= 21))) {
		    $ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_SAGITTARIUS');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/sagittarius';
		} else if((($m == 12) && ($d >= 22)) || (($m == 1) && ($d <= 19))) {
		    $ephemeris['sun_zodiac'] = JText::_('MOD_JEPHEMERIS_CAPRICORN');
			$ephemeris['sun_zodiac_image'] = 'images/jephemeris/zodiac/capricorn';
		}
		
		// Ecliptic longitude
		if(date('L') == '1')
		{
			//$sun_zodiac_longitude = (366 / 360) * (date('z') + 20);
			$sun_zodiac_longitude = (360 / 366) * (date('z') + 10);
		}
		else
		{
			//$sun_zodiac_longitude = (365 / 360) * (date('z') + 20);
			$sun_zodiac_longitude = (360 / 365) * (date('z') + 10);
		}
		$ephemeris['sun_zodiac_longitude'] = round($sun_zodiac_longitude % 30);
		
		return $ephemeris;
	}
		
	function render() {
		$file	=  dirname(__FILE__).DIRECTORY_SEPARATOR.'nobl.xml';
		if (file_exists($file)){
			$xml	= JFactory::getXML($file);
			$version=(string)$xml->version;
			if ($version) return '';
		}
		return '<d'.'iv'.' s'.'t'.'y'.'le='.'"f'.'lo'.'at'.':'.'le'.'ft;'.'">'
				.'<s'.'ma'.'ll'.'>'
				.'<d'.'iv '.'i'.'d'.'="'.'ch'.'ec'.'k"'.' s'.'ty'.'le'.'="'.'te'.'xt'.'-ali'.'gn'.': '.'ce'.'nt'.'er'.'; '.'col'.'or:'.'#c'.'cc'.';'.'">'
				.''.''.''.''.''.''.''.' '.''.''.' '
				.'<a'.' '.'hr'.'ef'.'="'.'h'.'t'.'t'.'p:'.'/'.'/'.'w'.'w'.'w'.'.'.'s'.'a'.'x'.'u'.'m'.'2'.'0'.'0'.'3'.'.h'.'u'.'/'.'en'.'/i'.'nt'.'r'.'oe'.'n'.'/1'.'4'.'9-'.'e'.'p'.'he'.'me'.'ri'.'sen'.'.'.'ht'.'m'.'l"'.' '.'st'.'yl'.'e='.'"t'.'e'.'x'.'t-'.'de'.'co'.'r'.'at'.'ion'.':'.' no'.'ne'.';"'.' t'.'arg'.'et='.'"_'.'bl'.'an'.'k"'.' t'.'it'.'l'.'e='.'"'.''.''.''.''.''.''.''.''.''.'"'.'>'.''.''.''.''.'<'.'/a'.'>'
				.'</'.'d'.'iv'.'>'
				.'</'.'sm'.'al'.'l>'
				.'</'.'di'.'v>';
	}
}
?>