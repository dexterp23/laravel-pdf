<?php

namespace App\Services;

use Storage;

class FileService
{

    public function GetData( string $file = '' ): array {
		
		if ($file && Storage::exists($file)) {
			$time = Storage::lastModified($file);
			$basename = basename($file);
			$extension = pathinfo(Storage::path($file), PATHINFO_EXTENSION);
			
			$basename_arr = explode ("-", $basename);
			$id_key = $basename_arr[0]."-".$basename_arr[1];
			$title_org = str_replace($id_key."-", "", $basename);
			$title = str_replace(".".$extension, "", $title_org);
				
			return array ('title' => $title, 'time' => $time, 'basename' => $basename, 'title_org' => $title_org, 'id_key' => $id_key, 'extension' => $extension);
		} else {
			return array();	
		}
    }

}
