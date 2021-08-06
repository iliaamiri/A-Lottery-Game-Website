<?php
// HTTP
define('HTTP_SERVER',"http://arashproject.ow");

// HTTPS
define('HTTPS_SERVER',"http://arashproject.ow");

// PHP VERSION
if (version_compare(PHP_VERSION, "5.4.7", "<")) {
    echo "<P style='text-align: center;margin-top: 100px;'><B>WITCHER FRAMEWORK</B> requires PHP version 5.4.7 or later.</P>";
    die("<P style='text-align: center;margin-top:30%;font-size: 9px;'>POWERED BY REDBOLDER ".date("Y")." <B>WITCHER FRAMEWORK</B></P>");
}

// REQUIRED EXTENSIONS
$requiredExtensions = ['curl'];
foreach($requiredExtensions as $requiredExtension) {
    if (!extension_loaded($requiredExtension)) {
        echo "<P style='text-align: center;margin-top: 100px;'>You require PHP's \"" . $requiredExtension . "\" extension. Please install/enable it on your server and try again.</P>";
        die("<P style='text-align: center;margin-top:30%;font-size: 9px;'>POWERED BY REDBOLDER ".date("Y")." <B>WITCHER FRAMEWORK</B></P>");
    }
}

// DIR
define('DIR_MODELS',"F:/xampp/htdocs/arash-project/witcher/app/model/");
define('DIR_APPLICATION',"F:/xampp/htdocs/arash-project/witcher/app/");
define('DIR_ROOT',"F:/xampp/htdocs/arash-project/");
define('DIR_PUBLIC',"F:/xampp/htdocs/arash-project/public_html/");
define('DIR_LOADER',"F:/xampp/htdocs/arash-project/witcher/app/autoloader.php");
if (file_exists(DIR_ROOT) and file_exists(DIR_LOADER) and file_exists(DIR_MODELS) and file_exists(DIR_APPLICATION)) {
    require_once(DIR_LOADER);
    $witcher = new witcher();
    $witcher->Run();
} else {
    echo "<P style='text-align: center;font-size: 26px;margin-top: 100px;'><B>Unknown directories in config file.</B> set them in configuration.php</P>";
    die("<P style='text-align: center;margin-top:30%;font-size: 9px;'>POWERED BY REDBOLDER ".date("Y")." <B>WITCHER FRAMEWORK</B></P>");
}