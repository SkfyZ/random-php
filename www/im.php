<?php
    $cdnurl = "https://waifu-im.cdn.ey.ax/";
	
    if (isset($_SERVER['QUERY_STRING'])) {
        $query = $_SERVER['QUERY_STRING'];
    }
	
    else {
        $query = "included_tags=ass&gif=false";
    }
	
    $json = file_get_contents('https://waifu-im.api.ey.ax/search?'. $query);
    $data = json_decode($json);
    $image_id = $data->images[0]->image_id;
	$extension = $data->images[0]->extension;
	
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error reading JSON data');
    }
	
    if (!isset($image_id)) {
        die('Not found in JSON data');
    }
	
    $imgurl = $cdnurl . $image_id . $extension;
    header('Location: ' . $imgurl, true, 302);
    exit;
?>
