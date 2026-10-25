<?PHP
// Copyright 2006 Bill St. Clair
// All rights reserved
// You may use this code as long as you give me credit.
// http://billstclair.com/
// bill@billstclair.com
//
// Graphics in aic-sq.png are copyright Scott Bieser
//
// Usage: sq.php[?color=xxx&size=xxx]
// Color defaults to red. Size defaults to 12

error_reporting(E_ALL ^ E_NOTICE);

$color = hex2int(validHexColor($_REQUEST['color'], 'FF0000'));

$im = imageCreateFromPNG ( "aic-sq.png" );

$background = imageColorAllocate($im, 0, 0, 0);
$foreground = imageColorAllocate($im, $color['r'], $color['g'], $color['b']);
$fontfile = 'FreeSansBold.ttf';
$fontsize = 12;

$now = time();
$offset = 60 * 60 * 24;
$then = gmmktime (5, 0, 0, 11, 7, 2006);
$delta = $now - $then;
$days = floor($delta / $offset);
$text = "DAY " . $days;

// Left side of box is at 70
// Right side of box is at 155
$bbox = imageFTBBox($fontsize, 0, $fontfile, $text);
$x = 71 + (((155 - 70) - ($bbox[2] - $bbox[0])) / 2);
imageFTText($im, $fontsize, 0, $x, 43, $foreground, $fontfile, $text);

header('Content-type: image/png');

header("Cache-Control: must-revalidate");
$hours = 5 * 60 * 60;
$today = $now - fmod($now, $offset);
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", $today + $offset + $hours) . " GMT";
header($ExpStr);

imagePNG($im);

imageDestroy($im); 

/**
 * @param    $hex string        6-digit hexadecimal color
 * @return    array            3 elements 'r', 'g', & 'b' = int color values
 * @desc Converts a 6 digit hexadecimal number into an array of
 *       3 integer values ('r'  => red value, 'g'  => green, 'b'  => blue)
 */
function hex2int($hex) {
        return array( 'r' => hexdec(substr($hex, 0, 2)), // 1st pair of digits
                      'g' => hexdec(substr($hex, 2, 2)), // 2nd pair
                      'b' => hexdec(substr($hex, 4, 2))  // 3rd pair
                    );
}

/**
 * @param $input string     6-digit hexadecimal string to be validated
 * @param $default string   default color to be returned if $input isn't valid
 * @return string           the validated 6-digit hexadecimal color
 * @desc returns $input if it is a valid hexadecimal color, 
 *       otherwise returns $default (which defaults to black)
 */
function validHexColor($input = '000000', $default = '000000') {
    // A valid Hexadecimal color is exactly 6 characters long
    // and eigher a digit or letter from a to f
    return (eregi('^[0-9a-f]{6}$', $input)) ? $input : $default ;
}
