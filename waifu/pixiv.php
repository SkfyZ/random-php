<?php
/*
    $apiUrl = 'https://api.lolicon.app/setu/v2';

    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    
    if (empty($_GET['tag'])) {
        $_GET['tag'] = 'めぐみん';
    }

    if (empty($_GET['r18'])) {
        $_GET['r18'] = 0;
    }

    if (empty($GET['excludeAI'])) {
        $GET['excludeAI'] = true;
    }

    $queryParams = http_build_query($_GET);

    $apiUrl .= '?' . $queryParams;
    
    $retryLimit = 2;
    $retryCount = 0;

    while($retryCount < $retryLimit){
        $json = file_get_contents($apiUrl);
        $data = json_decode($json);

        $imageContent = file_get_contents($data->data[0]->urls->original);
        if ($imageContent !== false) {
            break;
        }
        $retryCount++;
    }

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        die('Error reading JSON data');
    }

    if (!isset($data->data[0]->urls->original)) {
        die('URL not found in JSON data');
    }

	if ($imageContent === false) {
		die('Error fetching image');
	}

    $imageInfo = getimagesizefromstring($imageContent);
    if ($imageInfo === false) {
        die('Unable to determine image type.');
    }

    $contentType = $imageInfo['mime'];

	header('Content-Type: ' . $contentType);
	echo $imageContent;
	
	exit;
*/
    $apiUrl = 'https://api.lolicon.app/setu/v2';

    // Set headers to prevent caching
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    // Append the original query string to the API URL
    $apiUrl .= '?' . $_SERVER['QUERY_STRING'];

    $retryLimit = 2;
    $retryCount = 0;

    // Attempt to fetch the image with retries
    while ($retryCount < $retryLimit) {
        $json = file_get_contents($apiUrl);
        $data = json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE) {
            die('Error reading JSON data');
        }

        if (empty($data->data[0]->urls->original)) {
            die('URL not found in JSON data');
        }

        $imageContent = file_get_contents($data->data[0]->urls->original);

        if ($imageContent !== false) {
            break;
        }

        $retryCount++;
    }

    if ($imageContent === false) {
        die('Error fetching image after retries.');
    }

    // Determine the image type
    $imageInfo = getimagesizefromstring($imageContent);
    if ($imageInfo === false) {
        die('Unable to determine image type.');
    }

    // Set the content type header for the image
    $contentType = $imageInfo['mime'];
    header('Content-Type: ' . $contentType);
    echo $imageContent;
    
    exit;
?>
