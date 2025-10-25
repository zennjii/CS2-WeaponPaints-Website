<?php

/*****************/
/* Default Setup */
/*****************/

// Set HTTPS environment variables for proper detection
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        $_SERVER['HTTPS'] = 'on';
        $_SERVER['SERVER_PORT'] = 443;
    }
}

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');

if(session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

function Path($key = null) {
    strrpos($_GET['path'] ?? "", '/')===0?$_GET['path'] = substr($_GET['path'], 1):false;
    
    $path = array_values(array_filter(explode("/", $_GET['path'] ?? 'signin')));
    if(is_null($key)) {
        return $path;
    }

    empty($path[0])?$path[0] = 'signin':false;

    return $path[$key] ?? '';
}

function GetPrefix() {
    $path = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
    
    return $path;
}

function GetBaseURL() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
                (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $path = GetPrefix();
    
    return $protocol . '://' . $host . $path;
}

/****************/
/* Config setup */
/****************/

if(!file_exists('./config.php')) {
    if(file_exists('./config-gen.php')) {
        include_once './config-gen.php';
    }else {
        $documentError_Code = 'config';
        include_once "./errorpage.php";
    }
    exit;
}

include_once './config.php';

if($Website_Settings['language'] && isset($_COOKIE['cs2weaponpaints_lielxd_language'])
&& file_exists(realpath("./translation/".$_COOKIE['cs2weaponpaints_lielxd_language'].".json"))) {
    $translations = json_decode(file_get_contents("./translation/".$_COOKIE['cs2weaponpaints_lielxd_language'].".json"));
}else if($Website_Settings['language'] && !isset($_COOKIE['cs2weaponpaints_lielxd_language'])
&& file_exists(realpath("./translation/$Website_Translate.json"))) {
    $translations = json_decode(file_get_contents("./translation/$Website_Translate.json"));
}else if(file_exists(realpath("./translation/en.json"))) {
    $translations = json_decode(file_get_contents("./translation/en.json"));
}else {
    $documentError_Code = 'translatefile';
}

if(!isset($documentError_Code)) {
    $bodyStyle = "";
    if($translations->invert_direction) {
        $bodyStyle .= "direction:rtl;";
    }
    if($Website_Settings['theme'] && isset($_COOKIE['cs2weaponpaints_lielxd_theme'])) {
        $Website_MainColor = $_COOKIE['cs2weaponpaints_lielxd_theme'];
        $bodyStyle .= "--main-color: $Website_MainColor;";
    }else if($Website_MainColor == true) {
        $Website_MainColor = rand(111111, 999999);
        $bodyStyle .= "--main-color: #$Website_MainColor;";
    }else {
        if(isset($Website_MainColor) && !empty($Website_MainColor)) {
            $bodyStyle .= "--main-color: $Website_MainColor;";
        }
    }
    if(!empty($bodyStyle)) {
        $bodyStyle = "style='$bodyStyle'";
    }
}

if(!isset($documentError_Code)) {
    if(!isset($SteamAPI_KEY) || empty($SteamAPI_KEY)) {
        $documentError_Code = 'steamapi';
    }else if(!isset($DatabaseInfo['host']) || empty($DatabaseInfo['host']) ||
    !isset($DatabaseInfo['database']) || empty($DatabaseInfo['database'])) {
        $documentError_Code = 'database';
    }
}

if(isset($documentError_Code)) {
    include_once "./errorpage.php";
}else if(file_exists("./pages/".Path(0).".php")) {
    include_once "./pages/".Path(0).".php";
}else {
    $documentError_Code = 404;
    include_once "./errorpage.php";
}