<?php

namespace App\Models;

use CodeIgniter\Model;

class FolderModel extends Model
{
    protected $table = 'folders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'parent_id'];

    public function getAllFolders()
    {
        return $this->findAll(); 
    }

    public function getSubfolders($parentId)
    {
        return $this->where('parent_id', $parentId)->findAll();  
    }
}
