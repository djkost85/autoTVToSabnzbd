<?php
function resizeImage($filename, $percent) {

    //$percent = 0.5;

    list($width, $height) = getimagesize($filename);
    $newwidth = $width * $percent;
    $newheight = $height * $percent;

    // Load
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    $source = imagecreatefromjpeg($filename);

    // Resize
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // Output
    imagejpeg($thumb);
}

// Images must be local files, so for convenience we strip the domain if it's there
$image = preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $_GET['image']);

$size = $_GET['size'];

if (!is_numeric($size)) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Error: no percent is specifyed \'/\'';
    exit();
}


// For security, directories cannot contain ':', images cannot contain '..' or '<', and
// images must start with '/'
//if ($image{0} != '/' || strpos(dirname($image), ':') || preg_match('/(\.\.|<|>)/', $image)) {
if (strpos(dirname($image), ':') || preg_match('/(\.\.|<|>)/', $image)) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Error: malformed image path. Image paths must begin with \'/\'';
    exit();
}

$image = str_replace('images/', '', $image);
// If the image doesn't exist, or we haven't been told what it is, there's nothing
// that we can do
if (!$image || !is_readable($image)) {
    header('HTTP/1.1 400 Bad Request');
    var_dump($image);
    echo 'Error: no image was specified';
    exit();
}


function img_resize($tmpname, $size) {
    $gis       = GetImageSize($tmpname);
    $type       = $gis[2];
    switch($type) {
        case "1": $imorig = imagecreatefromgif($tmpname);
            break;
        case "2": $imorig = imagecreatefromjpeg($tmpname);
            break;
        case "3": $imorig = imagecreatefrompng($tmpname);
            break;
        default:  $imorig = imagecreatefromjpeg($tmpname);
    }

    $x = imageSX($imorig);
    $y = imageSY($imorig);
    if($gis[0] <= $size) {
        $av = $x;
        $ah = $y;
    }
    else {
        $yc = $y*1.3333333;
        $d = $x>$yc?$x:$yc;
        $c = $d>$size ? $size/$d : $size;
        $av = $x*$c;        //высота исходной картинки
        $ah = $y*$c;        //длина исходной картинки
    }
    $im = imagecreate($av, $ah);
    $im = imagecreatetruecolor($av,$ah);
    if (imagecopyresampled($im,$imorig , 0,0,0,0,$av,$ah,$x,$y))
        //if (imagejpeg($im, $save_dir.$save_name))
        if (imagejpeg($im))
            return true;
        else
            return false;
}

header('Content-type: image/jpeg');

//resizeImage($image, $size);
img_resize($image, $size);

