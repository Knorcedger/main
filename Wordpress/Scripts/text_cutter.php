<?php
/**
 * Takes a text and cuts it to the point you want, and without cutting words in the middle.
 *
 * @version text_cutter v0.1.1
 *
 * @return string The cutten text
 * @param string $text The text to cut
 * @param string $length The length of the returned text
 */
function text_cutter($text, $length) {
    if (strlen($text) > $length) {
        //find where to cut
        $cut = strpos($text, " ", $length);
        //checked if the chars added to cut after length reached text end
        if ($cut >= $length) {
            $text = substr($text, 0, $cut);
            $text = $text.'...';
        }
    }
    return $text;
}

?>
