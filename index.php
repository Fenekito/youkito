<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width , initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Youkito Downloader</title>
    </head>
    <body class="w3-black">
        <div class="w3-padding w3-container w3-center w3-text-center">
            <h1>
                Welcome To Youkito Downloader!
            </h1>
            <h2 class="w3-text-yellow">
                It's 100% free and open for all!
            </h2>
            <form method="POST" action="" class="formSmall">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Insert the link here!</h3>
                    </div>
                    <div class="col-lg-12 w3-container w3-padding-small">
                        <input type="text" class="form-control w3-opacity w3-hover-opacity-off" name="link" placeholder="Paste the link of the video you want here">
                        <br>
                        <button class="w3-button w3-deep-orange w3-large" style="width: 210px;" name="submit" id="submit">GO</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
        require_once "class.youtube.php";
        $yt = new YouTubeDownloader();
        $downloadLinks = "";
        $error = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $videoLink = $_POST['link'];
            if(!empty($videoLink))
            {
                $vid = $yt->getYouTubeCode($videoLink);
                if($vid)
                {
                    $result = $yt->processVideo($vid);

                    if($result)
                    {
                        //print_r($result)
                        $info = $result['videos']['info'];
                        $formats = $result['videos']['formats'];
                        $adaptativeFormats = $result['videos']['adapativeFormats'];

                        $videoinfo = json_decode($info['player_response']);

                        $title = $videoinfo->videoDetails->title;
                        $thumbnail = $videoinfo->videoDetails->thumbnail->thumbnails{0}->url;
                    }
                    else
                    {
                        $error = "Video went wrong bro.";
                    }
                }
            }
            $error = "No link, please put link >:(";
        }
        ?>
        <?php if($formats):?>
            <div class="row w3-row formSmall">
                <div class="col-lg-3">
                    <img src="<?php print $thumbnail?>">
                </div>
                <div class="col-lg-9">
                    <?php print $title?>
                </div>
            </div>

            <div class="card formSmall w3-padding w3-container">
                <div class="card-header">
                    <strong>Download Options</strong>
            </div>
            <div class="card-body w3-padding w3-container w3-center">
                <table class="table">
                    <tr class>
                        <td>Type</td>
                        <td>Quality</td>
                        <td>Download</td>
                    </tr>
                    <?php foreach($formats as $video):?>
                        <tr>
                            <td><?php print $video['type']?></td>
                            <td><?php print $video['quality']?></td>
                            <td><a href='downloader.php?link=<?php print urlencode($video['link'])?>&title=<?php print urlencode($title)?>&type=<?php print urlencode($video['type'])?>'>Download</a></td>
                        </tr>
                    <?php endforeach;?>
            </div>
        <?php endif;?>
</html>