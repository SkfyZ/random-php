<?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    $cdnurl = "https://waifu-pics.cdn.ey.ax/";
	
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
    }
    else {
        $type = "sfw";
    }
	
    if (isset($_GET['cat'])) {
        $cat = $_GET['cat'];
    }	
    else {
        $cat = "neko";
    }

    if (($_GET['cat']) === "trap") {
        $type = "nsfw";
    }

    $nsfw = array("waifu", "neko", "trap", "blowjob");

    if (($_GET['type']) === "nsfw") {
        $cat = $nsfw[array_rand($nsfw)];
    }

    $json = file_get_contents('https://waifu-pics.api.ey.ax/' . $type . '/' . $cat);
    $data = json_decode($json);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error reading JSON data');
    }

    if (!isset($data->url)) {
        die('URL not found in JSON data');
    }
    
    $simgurl = $data->url;
    $path = parse_url($simgurl, PHP_URL_PATH);
    $filename = pathinfo($path, PATHINFO_BASENAME);
    $imgurl = $cdnurl . $filename;
    header('Location: ' . $imgurl, true, 302);
    exit;
?>
