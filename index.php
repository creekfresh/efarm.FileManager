<?php 

/*** define the application directory ***/
defined('__SITE_PATH') || define ('__SITE_PATH', realpath(dirname(__FILE__)));

// Load/bootstrap files
require __SITE_PATH . "/includes/bootstrap.php";




/*** enable application error reporting if DEBUG is ON ***/
if ($config['debug']) {
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
}


// Set the file path for this test
// Note:: no need for a forward slash '/' at the end of __APPDIR.
$path = __SITE_PATH.__APPDIR;










/**
 * instantiate file manager called Acme. 
 * Note: named Acme for whatever reason, i guess I am more Symfony biased, 
 * could have used a better name for the class here???
 */
$manager = new Acme($path);
$response = '';


// upload file here
if ( isset($_POST['submit']) ) {
    
        $response = $manager->uploadFile();
}
else {

        // delete specific file here if 'remove' has been clicked
        if ( isset($_REQUEST['delete']) ) {
            $response = $manager->deleteFile();
        }
        
}





?>
<h3>Freddie File Manager</h3>
<hr />
<h4>List Folder Contents</h4>
<?php



// display/list all files and folders in parent "/temp" folder
$manager->listFolderContents();




?>

<hr />
<h4>Upload File</h4>

<div >
    <div id='message'><?php echo $response;?></div>
    <form action="" method="post" enctype="multipart/form-data">
        Select file to upload:<br/>
        <!--input type="hidden" name="MAX_FILE_SIZE" value="51200"/-->
        <input type="file" name="fileUpload" id="fileUpload"><br/><br/>
        <input type="hidden" name="action" value="upload"/>
        <input type="submit" value="Upload File" name="submit">
    </form>
</div>
