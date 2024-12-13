<?php

namespace App\Controllers;

use App\Models\FolderModel;
use CodeIgniter\RESTful\ResourceController;

class Folder extends ResourceController
{
    protected $modelName = FolderModel::class;
    protected $format    = 'json';

    public function getAllFolders()
    {
        $folders = $this->model->getAllFolders(); 
        return $this->respond($folders);  
    }

    public function getSubfolders($parentId)
    {
        $subfolders = $this->model->getSubfolders($parentId); 
        return $this->respond($subfolders);  
    }
}
