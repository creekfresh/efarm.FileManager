<?php

/**
 * Autoload classes here
 * @param string $class name
 */
function bootstrap($class) {
    include 'library/' . $class . '.php';
}
spl_autoload_register('bootstrap');









/**
 * define constants here
 */

/*** define the application directory ***/
defined('__APPDIR') || define ('__APPDIR', '/temp');

// set permissions and upload file size limit
define('FULL_WRITE_PERMISSION', 0777);
define('MAX_FILE_UPLOAD_SIZE', 51200);


// error emssages
define('MESSAGE_ERROR_MAXFILESIZE', 'upload file size must be 50Kb or less');
define('MESSAGE_ERROR_MISSINGFILE', 'we are missing the upload file');
define('MESSAGE_ERROR_CREATEFOLDER', 'cannot create folder');


// success messages
define('MESSAGE_SUCCESS_FILEUPLOAD', 'uploaded file');
define('MESSAGE_SUCCESS_FILEDELETE', 'deleted file');







/**
 *  set some configs here
 */
$config = array();
$config['debug'] = true;








/**
 * format the error message
 * 
 * @param string $msg
 * @return string formatted $msg
 */
function __errormsg($msg)
{
    return "<div style='color:#F44;line-height:20px;margin-bottom:10px;'>Error: {$msg}</div>";
}


/**
 * format the success message
 * 
 * @param string $msg
 * @return string formatted $msg
 */
function __successmsg($msg)
{
    return "<div style='color:#9E9;line-height:20px;margin-bottom:10px;'>Success: {$msg}</div>";
}
