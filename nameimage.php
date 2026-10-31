<?PHP


error_reporting(E_ALL ^ E_NOTICE);

/*
simplepng.php
Generates a 50 x 50 pixel png of the color passed in parameter 'color'
*/

// Step 1. Create a new blank image
$im = imageCreateFromPNG ( "aic-wide.png" );

// Step 2. Set background to 'color'
$background = imageColorAllocate($im, 0, 0, 0);
$foreground = imageColorAllocate($im, 255, 0, 0);
$fontfile = '/nfsn/content/billstclair/htdocs/freefont/FreeSerifBold.ttf';
$fontsize = 18;
$text = "DAY 1000";

// Left side of box is at 150
// Right side of box is at 265
$bbox = imageFTBBox($fontsize, 0, $fontfile, $text);
$x = 153 + (((265 - 150) - ($bbox[2] - $bbox[0])) / 2);
imageFTText($im, $fontsize, 0, $x, 45, $foreground, $fontfile, $text);

// Step 3. Send the headers (at last possible time)
header('Content-type: image/png');

// Step 4. Output the image as a PNG 
imagePNG($im);

// Step 5. Delete the image from memory
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

?>
