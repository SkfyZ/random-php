<?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    //$cdnurl = "https://cdn.waifu.im/";

    if (isset($_SERVER['QUERY_STRING'])) {
        $query = $_SERVER['QUERY_STRING'];
        parse_str($query, $params);

        $allowedParams = [
            'included_tags', 'excluded_tags', 'included_files', 'excluded_files',
            'is_nsfw', 'gif', 'order_by', 'orientation', 'many', 'full',
            'width', 'height', 'byte_size'
        ];

        foreach ($params as $name => $value) {
            if (!in_array($name, $allowedParams)) {
                unset($params[$name]);
            }
        }
        
        $query = http_build_query($params);
        
        if(empty($query)){
            $query = "gif=false&is_nsfw=false";
        }
    } else {
        $query = "gif=false&is_nsfw=false";
	}
    
    $json = file_get_contents('https://api.waifu.im/search?'. $query);
    $data = json_decode($json);
    $image_id = $data->images[0]->image_id;
    $extension = $data->images[0]->extension;
	
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error reading JSON data');
    }
	
    if (!isset($image_id)) {
        die('Not found in JSON data');
    }
	
    $imageContent = file_get_contents($data->images[0]->url);
    if ($imageContent === false) {
        die('Error fetching image');
    }
    
	$contentType = 'image/jpeg';

    header('Content-Type: ' . $contentType);
    echo $imageContent;
	
    //$imgurl = $cdnurl . $image_id . $extension;
    //header('Location: ' . $imgurl, true, 302);
    exit;
?>