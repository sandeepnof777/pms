<?php
$fileName = explode('/', $_GET['src']);
$fileName = $fileName[count($fileName) - 1];
$file = './ajax_uploader/client/uploads/' . $fileName;
$imageInfo = getimagesize($file);
$type = str_replace('image/', '', $imageInfo['mime']);
$fn = 'imagecreatefrom' . $type;
$big_im = $fn($file);
$ratio_w = $_GET['w1'] / $_GET['w2'];
$ratio_h = $_GET['h1'] / $_GET['h2'];
$ratio_x = $_GET['w1'] / $_GET['x1'];
$ratio_y = $_GET['h1'] / $_GET['y1'];
$w = $imageInfo[0];
$h = $imageInfo[1];
$neww = floor($w / $ratio_w);
$newh = floor($h / $ratio_h);
$x = floor($w / $ratio_x);
$y = floor($h / $ratio_y);
$im2 = imagecreatetruecolor($neww, $newh);
imagecopyresampled($im2, $big_im, 0, 0, $x, $y, $neww, $newh, $neww, $newh);
//add white space and calculate stuff
$finalRatio = 2.464;
$currentRatio = $neww / $newh;
$destX = 0;
$destY = 0;
if ($currentRatio > $finalRatio) {
    //width too big - preserve width and add vertical paddings
    $final_w = $neww;
    $final_h = floor($final_w / $finalRatio);
    $destY = floor(abs($final_h - $newh) / 2);
} else {
    //height too big - preserve height and add horizontal paddings
    $final_h = $newh;
    $final_w = floor($final_h * $finalRatio);
    $destX = floor(abs($final_w - $neww) / 2);
}
$finalImage = imagecreatetruecolor($final_w, $final_h);
$white = imagecolorallocate($finalImage, 255, 255, 255);
imagefill($finalImage, 0, 0, $white);
$xLocation = floor(abs($final_h - $newh) / 2);
$yLocation = floor(abs($final_w - $neww) / 2);
//$im2 = $finalImage;
imagecopyresampled($finalImage, $im2, $destX, $destY, 0, 0, $neww, $newh, $neww, $newh);

$im2 = $finalImage;
$fn = md5(microtime()) . '.jpg';
$logofile = './uploads/clients/logos/logo-' . $_GET['company'] . '.jpg';
if (file_exists($logofile)) {
    @unlink($logofile);
}
imagejpeg($im2, $logofile);
//save file
file_get_contents('http://pms2.rapidinjection.com/api/setLogo/' . $_GET['company'] . '/logo-' . $_GET['company'] . '.jpg');