<?php 

interface IFileSystem {
    public function createFile($dirname, $file);
    public function createFolder($folder);
    public function listContents();
    public function deleteFile($dirname='');
}
