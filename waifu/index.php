<?php
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    $requestUri = strtok($_SERVER['REQUEST_URI'], '?');

// 根据请求的URI决定引导到哪个PHP文件
    switch ($requestUri) {
        case '/pics':
        // 引导到pics.php
            require 'pics.php';
            break;
        case '/im':
        // 引导到im.php
            require 'im.php';
            break;
        case '/pixiv':
            // 引导到im.php
                require 'pixiv.php';
                break;
        default:
        // 未知路径，可以选择显示404错误或者引导到某个默认页面
            header("HTTP/1.0 404 Not Found");
            echo "404 Not Found";
        // 或者引导到一个默认页面
        // require 'default.php';
            break;
    }

    // 注意：确保pics.php和im.php文件存在于同一目录中，或者提供正确的相对/绝对路径。
?>