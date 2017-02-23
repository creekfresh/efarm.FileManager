<?php

/**
 * 
 */
class Acme implements IFileSystem 
{
    
    /**
     * init _path variable to null 
     * @var $_path string | app /temp root folder path 
     */
    private $_path = null;
    private $_keys = array();
    
    
    
    /**
     * 
     * @param string $path
     */
    public function __construct($path)
    {
        $this->_path = $path;
    }

    
    
    /**
     * 
     * @param type $path
     * @param File $file
     * @return boolean
     */
    public function createFile($dirname, $file) 
    {
        if (is_dir($this->_path)) {
            if ($file instanceof File) {
                //write the file here;
                $handle = fopen($this->_path .'/'. $dirname .'/'. $file->name . '.' . $file->type, "w")
                        or die('Cannot open/write file:  '.$file->name . '.' . $file->type);
                fwrite($handle, $file->content);
                fclose($handle);
                return true;
            }
            
        }
        else {
            print ("directory path does not exist!");
        }
        return false;
    }
    
    
    
    /**
     * 
     * @param string $path
     * @param Folder $folder object
     * @return boolean true|false
     */
    public function createFolder($folder) 
    {
        if (is_dir($this->_path)) {
            if ($folder instanceof Folder) {
                //write the folder here;
                $newfolder = $this->_path . '/' . $folder->name;
                return mkdir($newfolder, FULL_WRITE_PERMISSION, TRUE) ? chmod($newfolder, FULL_WRITE_PERMISSION) : false;
            }
            
        }
        return false;
    }
    
    
    /**
     * List all the contents of $path including $path itself
     */
    public function listContents() 
    {
        if (is_dir($this->_path)) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->_path));
            while($it->valid()) {
                if (!$it->isDot()) {
                    $key = md5($it->key().$this->_path);
                    $this->_keys[$key] = $it->key();
                    print 'File:         <a href="' . __APPDIR . '/' . $it->getSubPathName() . '">' . $it->getSubPathName() . "</a>|";
                    print " [ <a href=?delete=1&k={$key}>remove</a> ]<br />";
                    #print 'SubDirectory: ' . $it->getSubPath() . "<br />";
                    print 'FullPath:     ' . $it->key() . "<br /><br />";
                }
                $it->next();
            }
        }
    }
    
    
    /**
     * wrapper for listContents()
     */
    public function listFolderContents()
    {
        $this->listContents();
    }
    
    /**
     * Delete (recursively) all the contents of folder $path, including $path itself
     * @param string $path
     */
    public function deleteFile($dirname=null)
    {
        
        $msg = null;
        if (is_dir($this->_path . '/' . $dirname)) {
            $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($this->_path .'/' . $dirname, RecursiveDirectoryIterator::SKIP_DOTS),
                                RecursiveIteratorIterator::CHILD_FIRST );

            foreach ($files as $file) {
                $callMethod = ($file->isDir() ? 'rmdir' : 'unlink');
                $hash = md5($file->getRealPath().$this->_path);
                if (isset($_REQUEST['k']) && $hash === $_REQUEST['k']) {
                    $callMethod($file->getRealPath());
                    $msg = MESSAGE_SUCCESS_FILEDELETE;
                }
            }
            
            isset($dirname) ? rmdir($this->_path . '/'. $dirname) : '';

        }
        
        return isset($msg) ? __successmsg(MESSAGE_SUCCESS_FILEDELETE) : null;
    }
    

    
    /**
     * 
     */
    public function uploadFile()
    {
        $msg = __errormsg(MESSAGE_ERROR_MISSINGFILE);
        
        if (isset($_FILES['fileUpload']['name'])) {
            
            if (($_FILES['fileUpload']['error']) == 0) {
                
                if ($_FILES['fileUpload']['size'] > MAX_FILE_UPLOAD_SIZE) {
                    return __errormsg(MESSAGE_ERROR_MAXFILESIZE);
                    
                }
                else {
                    $rand = rand(100, 999);
                    $filename =  "rand{$rand}_" . strtolower(basename($_FILES['fileUpload']['name']));
                    if (move_uploaded_file($_FILES['fileUpload']['tmp_name'], $this->_path.'/'.$filename)) {
                        chmod($this->_path.'/' .$filename, FULL_WRITE_PERMISSION);
                        return __successmsg(MESSAGE_SUCCESS_FILEUPLOAD);
                    }
                    
                }
                
            }
            
        }
        return $msg;
    }
    
    
}
