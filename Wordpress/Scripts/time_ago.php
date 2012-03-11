<?php
/**
 * Tells us the time passed by a given time
 *
 * @version v0.1.1
 *
 * @return string The time ago in greel
 * @param string $time
 */

function time_ago($time) {
    $ts = time()-strtotime(str_replace("-", "/", $time));
    //change to our timezone
    $ts = $ts+3600*(0);
    //
    if ($ts > 604800) {
        $val = round($ts/604800, 0);
        if ($val > 1) {
            $val .= ' εβδομάδες';
        } else {
            $val .= ' εβδομάδα';
        }
    } elseif ($ts > 86400) {
        $val = round($ts/86400, 0);
        if ($val > 1) {
            $val .= ' μέρες';
        } else {
            $val .= ' μέρα';
        }
    } elseif ($ts > 3600) {
        $val = round($ts/3600, 0);
        if ($val > 1) {
            $val .= ' ώρες';
        } else {
            $val .= ' ώρα';
        }
    } elseif ($ts > 60) {
        $val = round($ts/60, 0);
        if ($val > 1) {
            $val .= ' λεπτά';
        } else {
            $val .= ' λεπτό';
        }
    } else {
        $val = $ts;
        if ($val > 1) {
            $val .= ' δευτερόλεπτα';
        } else {
            $val .= ' δευτερόλεπτο';
        }
    }

    return $val;
}
?>
