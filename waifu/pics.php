<?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    //$cdnurl = "https://i.waifu.pics/";

    if (isset($_GET['type'])) {
        $type = $_GET['type'];
    } else {
        $type = "sfw";
    }

    if (($_GET['cat']) === "trap") {
        $type = "nsfw";
    }

    if (($_GET['type']) === "nsfw") {
        $nsfw = array("waifu", "neko", "trap", "blowjob");
        $cat = $nsfw[array_rand($nsfw)];
    }

    if (isset($_GET['cat'])) {
        $cat = $_GET['cat'];
    } else {
        if ($type === "sfw") {
            $cat = "neko";
        }
    }

    $json = file_get_contents('https://api.waifu.pics/' . $type . '/' . $cat);
    $data = json_decode($json);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error reading JSON data');
    }

    if (!isset($data->url)) {
        die('URL not found in JSON data');
    }
	
	$imageContent = file_get_contents($data->url);
	if ($imageContent === false) {
		die('Error fetching image');
		}
		
	$contentType = 'image/jpeg';

	header('Content-Type: ' . $contentType);
	echo $imageContent;
	
    //$simgurl = $data->url;
    //$path = parse_url($simgurl, PHP_URL_PATH);
    //$filename = pathinfo($path, PATHINFO_BASENAME);
    //$imgurl = $cdnurl . $filename;
    //header('Location: ' . $imgurl, true, 302);
	exit;
?>