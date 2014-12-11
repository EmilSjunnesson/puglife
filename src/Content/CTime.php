<?php

namespace Anax\Content;

/**
 * Time functions.
 *
 */
class CTime
{
    use \Anax\TConfigure,
        \Anax\DI\TInjectionAware;
    
    /**
     * Get time ago from unix-timestap.
     *
     * @return string
     */
    function ago($time)
    {
    	$periods = array("sekund", "minut", "timme", "dag", "vecka", "månad", "år", "årtionde");
    	$lengths = array("60","60","24","7","4.35","12","10");
    
    	$now = time();
    
    	$difference     = $now - $time;
    	$tense         = "sedan";
    
    	if($difference < 10) {
    		return "alldeles nyss";
    	}
    
    	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
    		$difference /= $lengths[$j];
    	}
    
    	$difference = round($difference);
    
    	if($difference != 1) {
    		if ($periods[$j] == "timme") {
    			$periods[$j] = "timmar";
    		} elseif($periods[$j] == "dag") {
    			$periods[$j].= "ar";
    		} elseif($periods[$j] == "vecka") {
    			$periods[$j] = "veckor";
    		} elseif($periods[$j] == "år") {
    				
    		} elseif($periods[$j] == "årtionde") {
    			$periods[$j].= "n";
    		} else {
    			$periods[$j].= "er";
    		}
    	}
    
    	return "för $difference $periods[$j] $tense ";
    }
}