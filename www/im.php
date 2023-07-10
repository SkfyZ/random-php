<?php
    $cdnurl = "https://waifu-im.cdn.ey.ax/";

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
            $query = "gif=false&id_nsfw=false";
        }
    } else {
        $query = "gif=false&id_nsfw=false";
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
