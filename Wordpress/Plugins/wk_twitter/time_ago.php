<?php
/**
 * Tells us the time passed by a given time
 *
 * @version v0.2.0
 *
 * @return string The time ago in greel
 * @param string $time
 * @param string $language
 */

function time_ago($time, $language) {
	if($language == 'en'){
		$weeks = 'weeks';
		$week = 'week';
		$days = 'days';
		$day = 'day';
		$hours = 'hours';
		$hour = 'hour';
		$minutes = 'minutes';
		$minute = 'minute';
		$seconds = 'seconds';
		$second = 'second';
	}elseif($language == 'gr'){
		$weeks = 'εβδομάδες';
		$week = 'εβδομάδα';
		$days = 'μέρες';
		$day = 'μέρα';
		$hours = 'ώρες';
		$hour = 'ώρα';
		$minutes = 'λεπτά';
		$minute = 'λεπτό';
		$seconds = 'δευτερόλεπτα';
		$second = 'δευτερόλεπτο';
	}
    $ts = time()-strtotime(str_replace("-", "/", $time));
    //change to our timezone
    $ts = $ts+3600*(0);
    //
    if ($ts > 604800) {
        $val = round($ts/604800, 0);
        if ($val > 1) {
            $val .= " $weeks";
        } else {
            $val .= " $week";
        }
    } elseif ($ts > 86400) {
        $val = round($ts/86400, 0);
        if ($val > 1) {
            $val .= " $days";
        } else {
            $val .= " $day";
        }
    } elseif ($ts > 3600) {
        $val = round($ts/3600, 0);
        if ($val > 1) {
            $val .= " $hours";
        } else {
            $val .= " $hour";
        }
    } elseif ($ts > 60) {
        $val = round($ts/60, 0);
        if ($val > 1) {
            $val .= " $minutes";
        } else {
            $val .= " $minute";
        }
    } else {
        $val = $ts;
        if ($val > 1) {
            $val .= " $seconds";
        } else {
            $val .= " $second";
        }
    }

    return $val;
}
?>
