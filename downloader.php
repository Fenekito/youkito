<?php
    $downloadURL = urldecode($_GET['link']);
    //print  $downloadURL;exit;
    $type = urldecode($_GET['type']);
    $title = urldecode($_GET['title']);

    $typearr = explode("/",$type);
    $extension = $typearr[1];

    $filename = $title.'.'.$extension;

    if(!empty($downloadURL))
    {
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Transfer-Encoding: binary");

        readfile($downloadURL);
    }
?>