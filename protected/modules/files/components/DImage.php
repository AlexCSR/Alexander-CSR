<?php

# ver: 1.0.1.5
# com: Исправлена очередная ошибка миниатюризатора

//******************************************************************************
class DImage extends File
//******************************************************************************
{
	//----------------------------------------------------------------------------
	public static function image($modImage, $strThumb, $alt = '', $htmlOptions = '')
	//----------------------------------------------------------------------------
	// Учитывает то, что картинки может и не быть
	{
		if ($modImage != null && $modImage->isImage)
			return $modImage->image($strThumb, $alt, $htmlOptions);

		else return self::imgNoImage($strThumb, $alt, $htmlOptions);
	}

	//----------------------------------------------------------------------------
	public static function publish($modImage, $strThumb)
	//----------------------------------------------------------------------------
	// Учитывает то, что картинки может и не быть
	{
		if ($modImage != null && $modImage->isImage)
			return $modImage->publish($strThumb);

		else {
			$objImage = new File;
			return $objImage->publishNoImage($strThumb);
		}
	}


	//----------------------------------------------------------------------------
	public static function imgNoImage($strThumb, $alt = '', $htmlOptions = '')
	//----------------------------------------------------------------------------
	// Картинка "Нет картинки" в нужной миниатюре
	{
		$objImage = new File;
		return CHtml::image($objImage->publishNoImage($strThumb), $alt, $htmlOptions);
	}

	//----------------------------------------------------------------------------
	public static function resizeImage($file_src, $file_dest, $size_x, $size_y=0, $ex=0)
	//----------------------------------------------------------------------------  
	// 0 - обрезаем лишнее, подгоняем точно в формат
	// 1 - не обрезаем лишнее, заполняем белым до формата
	// 2 - просто уменьшаем чтобы влезло в формат, пропорции теряются
	// 3 - тупо копируем картинку
	{


		if ($ex == 3)
		{
			copy($file_src, $file_dest);
			return;
		}

		global $_error;
		$t=getimagesize($file_src);

		$us=0;
		if($t[2]==1)
		$us=@imagecreatefromgif($file_src);

		if($t[2]==2)
		$us=@imagecreatefromjpeg($file_src);

		if($t[2]==6)
		$us=@imagecreatefromwbmp($file_src);

		if($t[2] == IMAGETYPE_PNG)
		$us=@imagecreatefrompng($file_src);

		if(!$us){$_error['image']=1; return 0;}

		$w_src = imagesx($us);
		$h_src = imagesy($us);

		$f_src = $w_src / $h_src; // Исходное соотношение сторон


		if($size_y == 0) $size_y = $size_x/$f_src;
		if($size_x == 0) $size_x = $size_y*$f_src;

		$f_dest = $size_x / $size_y;

		// Если копия будет больше оригинала, скопировать
		if($size_x > $w_src && $size_y > $h_src) {
			copy($file_src,$file_dest);
			return 0;
		}


		if($ex==0)//inner cut
		{
			$f_dest = $size_x/$size_y;
			
			if($f_src < $f_dest)
			{
				// Ширина старая, обрезаем по высоте
				$w_dst = $w_src;
				$h_dst = $w_src / $f_dest;
				$x_dst = 0;
				$y_dst = ($h_src-$h_dst)/2;
			}
			else
			{
				// Высота старая, обрезаем по ширине
				$h_dst = $h_src;				
				$w_dst = $h_src * $f_dest;		
				$x_dst = ($w_src-$w_dst)/2;
				$y_dst = 0;
			}

			$rez=imagecreatetruecolor($size_x,$size_y);
			imagecopyresampled($rez,$us,0,0,$x_dst,$y_dst,$size_x+1,$size_y,$w_dst,$h_dst);
		}

		if($ex == 1)//outer fill
		{

			if($w_src > $h_src)
			{
				$w_dst = $size_x;
				$h_dst = $w_dst / $f_src;
				$x_dst = 0;
				$y_dst = ($size_y - $h_dst) / 2;
			}
			else
			{
				$h_dst = $size_y;
				$w_dst = $h_dst * $f_src;
				$y_dst = 0;
				$x_dst = ($size_x - $w_dst) / 2;
			}

			$rez=imagecreatetruecolor($size_x,$size_y);
			$bg=imagecolorallocate($rez, 255, 255, 255);
			imagefill ( $rez, 1, 1, $bg);
			imagecopyresampled ( $rez, $us, $x_dst, $y_dst, 0, 0, $w_dst, $h_dst, $w_src, $h_src);
		}

		if($ex==2)//outer
		{

			if($w_src>$h_src)
			{
			$w_dst=$size_x;
			$h_dst=$w_dst/$f_src;
			$x_dst=0;
			$y_dst=($size_y-$h_dst)/2;
			}
			else
			{
			$h_dst=$size_y;
			$w_dst=$h_dst*$f_src;
			$y_dst=0;
			$x_dst=($size_x-$w_dst)/2;
			}

			$rez=imagecreatetruecolor($w_dst,$h_dst);
			imagecopyresampled ( $rez, $us, 0, 0, 0, 0, $w_dst, $h_dst, $w_src, $h_src);
		}


		if($t[2] == IMAGETYPE_PNG) imagepng($rez, $file_dest);
		else imagejpeg($rez,$file_dest,100);
	}
	public static function model($className=__CLASS__) {return parent::model($className);}
}

