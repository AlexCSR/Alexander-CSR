<?php

# ver: 1.0.0

//------------------------------------------------------------------------------
class BackuperArchiveZip      
//------------------------------------------------------------------------------
{
	//----------------------------------------------------------------------------
	function unpack($str_archive_name, $str_dir, $entries = '')
	//----------------------------------------------------------------------------  
	{
		$this->obj_zip = new ZipArchive();
		if ($this->obj_zip->open($str_archive_name) !== true) 
		{
			fwrite(STDERR, "Error while creating archive file");
			exit(1);
		}
		
		if ($entries == '') $this->obj_zip->extractTo($str_dir); 
		else $this->obj_zip->extractTo($str_dir, $entries);
		$this->obj_zip->close();  
	}

	//----------------------------------------------------------------------------
	function pack($str_dir, $arr_files, $str_arch_name, $arr_file_types = array(), $flg_deny = 0)
	//----------------------------------------------------------------------------  
	// Полный путь к адресам. Полный путь к имени архива.
	{
		$this->obj_zip = new ZipArchive();    
		if ($this->obj_zip->open($str_arch_name, ZIPARCHIVE::CREATE) !== true) 
		{
			fwrite(STDERR, "Error while creating archive file");
			exit(1);
		}
		
		// Перебираем файлы и папки
		foreach ($arr_files as $file)
			$this->pack_r($str_dir, $file, $arr_file_types, $flg_deny);

		// Закрываем архив
		return $this->obj_zip->close();
		
	}
	
	//----------------------------------------------------------------------------
	function pack_r($str_dir, $str_arch_link, $arr_file_types = array(), $flg_deny = 0)
	//----------------------------------------------------------------------------
	// Рекурсивно упаковывает папку или файл, проверяет фильтр
	{  
		if (is_file($str_dir . $str_arch_link))
		{
			$str_type = substr($str_arch_link, strrpos($str_arch_link, '.') + 1);
			if ($arr_file_types == array() || ($flg_deny == 0 && in_array($str_type, $arr_file_types)) || ($flg_deny == 1 && !in_array($str_type, $arr_file_types)))
				$this->obj_zip->addFile($str_dir . $str_arch_link, $str_arch_link);     
		}
		elseif (is_dir($str_dir . $str_arch_link))
		{
			$this->obj_zip->addEmptyDir($str_arch_link);    
			$hdl_dir = opendir($str_dir . $str_arch_link);
			while(($file = readdir($hdl_dir)) !== false) 
				if ($file != '.' && $file != '..') 
					$this->pack_r($str_dir, $str_arch_link . '/' . $file, $arr_file_types, $flg_deny);   
		} 
	}

	//----------------------------------------------------------------------------  
	function read($str_arch_name, $str_entry_name)
	//----------------------------------------------------------------------------  
	{
		$this->obj_zip = new ZipArchive();
		if ($this->obj_zip->open($str_arch_name) !== true) return false;

		$str_contents = $this->obj_zip->getFromName($str_entry_name);
		$this->obj_zip->close();  
		return $str_contents;
	}

	//----------------------------------------------------------------------------  
	function getFileList($str_arch_name)
	//----------------------------------------------------------------------------  
	{
		$arr_files = array();
		$this->obj_zip = new ZipArchive();
		if ($this->obj_zip->open($str_arch_name) !== true) 
		{
			fwrite(STDERR, "Error while creating archive file");
			exit(1);
		}

		 for($i = 0; $i < $this->obj_zip->numFiles; $i++)
				$arr_files[] = $this->obj_zip->getNameIndex($i);

		$this->obj_zip->close();  
		return $arr_files;
	
	}
}




?>
