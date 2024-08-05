<?php
$imagePath = "signature3.png";
$newPath = "../";
$ext = '.png';
$newName  = $newPath."a".$ext;

$copied = copy($imagePath , $newName);

if ((!$copied)) 
{
    echo "Error : Not Copied";
}
else
{ 
    echo "Copied Successful";
}
?>