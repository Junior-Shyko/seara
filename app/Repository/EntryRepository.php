<?php

namespace Seara\Repository;

use Seara\FileLaunch;

class EntryRepository {

    static public function deleteFile($id)
    {
        
        //exclusao dos arquivos, caso tenha
        $files = FileLaunch::where('file_launches_id_entry', '=', $id)->get();
       
        foreach ($files as $key => $value) {
            FileLaunch::where('id', $value->id)->delete();
        }
    }

}