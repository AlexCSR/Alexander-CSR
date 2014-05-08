<?php

# ver: 1.0.p.2
# com: Добавлены форматы gBoolean и translit

class DFormatter extends CFormatter
{
	public $dateFormat = 'd.m.Y';
	public $datetimeFormat = 'd.m.Y, H:i';
	public $timeFormat = 'H:i';
	public $numberFormat = array('decimals' => 0, 'decimalSeparator' => ',', 'thousandSeparator' => ' ');  
	public $booleanFormat = array('Нет', 'Да');
	public $enumMonths = array(
		1 => 'Январь',
		2 => 'Февраль',
		3 => 'Март',
		4 => 'Апрель',
		5 => 'Май',
		6 => 'Июнь',
		7 => 'Июль',
		8 => 'Август',
		9 => 'Сентябрь',
		10 => 'Октябрь',
		11 => 'Ноябрь',
		12 => 'Декабрь',
		);

	public $enumDays = array(
		0 => 'Вс',
		1 => 'Пн',
		2 => 'Вт',
		3 => 'Ср',
		4 => 'Чт',
		5 => 'Пт',
		6 => 'Сб',
		);
	
	//----------------------------------------------------------------------------
	public function getEnumYears()
	//----------------------------------------------------------------------------
	{
		$arrRet = array();
		for ($i = (date('Y') + 1); $i > 2000; $i--) $arrRet[$i] = $i;
		return $arrRet;
	}

	//----------------------------------------------------------------------------
	public function formatDate($value)
	//----------------------------------------------------------------------------	
	{
		if ($value == 0) return '';
		return date($this->dateFormat, $value);
	}

	//----------------------------------------------------------------------------
	public function formatGBoolean($value)
	//----------------------------------------------------------------------------	
	{
		return ($value ? '<i class="icon icon-ok"></i>' : '');
	}

	//----------------------------------------------------------------------------
	public function formatDateDay($value)
	//----------------------------------------------------------------------------
	{
		return $this->formatDate($value) . ', ' . $this->enumDays[date('w', $value)];
	}

	//----------------------------------------------------------------------------
	public function formatTimeInterval($value)
	//----------------------------------------------------------------------------
	{
		if ($value == 0) return '';
		$seconds = $value % 60;
		$value -= $seconds;
		$minutes = ($value % 3600) / 60;
		$hours = ($value - ($minutes * 60)) / 3600;
		$value = sprintf('%02d:%02d', $hours, $minutes);
		// if ($seconds > 0) $value .= sprintf(':%02d', $seconds);
		return $value;
	}

	//----------------------------------------------------------------------------
	function priceText($num)
	//----------------------------------------------------------------------------
	// Сумма прописью
	// @author runcore
	// @uses morph(...)
	{
		$nul='ноль';
		$ten=array(
				array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
				array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
		);
		$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
		$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
		$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
		$unit=array( // Units
				array('копейка' ,'копейки' ,'копеек',  1),
				array('рубль'   ,'рубля'   ,'рублей'    ,0),
				array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
				array('миллион' ,'миллиона','миллионов' ,0),
				array('миллиард','милиарда','миллиардов',0),
		);
		//
		list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
		$out = array();
		if (intval($rub)>0) {
				foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
						if (!intval($v)) continue;
						$uk = sizeof($unit)-$uk-1; // unit key
						$gender = $unit[$uk][3];
						list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
						// mega-logic
						$out[] = $hundred[$i1]; # 1xx-9xx
						if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
						else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
						// units without rub & kop
						if ($uk>1) $out[]= $this->morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
				} //foreach
		}
		else $out[] = $nul;
		$out[] = $this->morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
		$out[] = $kop.' '.$this->morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
		return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
	}

	//----------------------------------------------------------------------------
	function morph($n, $f1, $f2, $f5) {
	//----------------------------------------------------------------------------
		$n = abs(intval($n)) % 100;
		if ($n>10 && $n<20) return $f5;
		$n = $n % 10;
		if ($n>1 && $n<5) return $f2;
		if ($n==1) return $f1;
		return $f5;
	} 

	/** 
	 * @var array the format used to format size (bytes). Two elements may be specified: "base" and "decimals".
	 * They correspond to the base at which KiloByte is calculated (1000 or 1024) bytes per KiloByte and 
	 * the number of digits after decimal point.
	 */
	public $sizeFormat=array('base'=>1024, 'decimals'=>2);


	/**
	 * Formats the value as a size in human readable form.
	 * @params integer value to be formatted
	 * @return string the formatted result
	 */
	public function formatSize($value)
	{
			$units=array('B&nbsp;','KB','MB','GB','TB');
			$base = $this->sizeFormat['base']; 
			for($i=0; $base<=$value; $i++) $value=$value/$base;
			return round($value, $this->sizeFormat['decimals']) . ' ' . $units[$i];
	} 	

	public function formatTranslit($str)
	{
		$_str_translit=array(
			'а' => 'a',	'б' => 'b',	'в' => 'v',	'г' => 'g',	'д' => 'd',	'е' => 'e',	'ё' => 'e',	'ж' => 'j',	'з' => 'z',	'и' => 'i',	'й' => 'i',	'к' => 'k',	'л' => 'l',	'м' => 'm',	'н' => 'n',	'о' => 'o',	'п' => 'p',	'р' => 'r',	'с' => 's',	'т' => 't',	'у' => 'y',	'ф' => 'f',	'х' => 'h',	'ц' => 'c',	'ч' => 'ch',	'ш' => 'sh',	'щ' => 'sh',	'ы' => 'i',	'э' => 'e',	'ю' => 'u',	'я' => 'ya',	
			'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Ё' => 'e', 'Ж' => 'j', 'З' => 'z', 'И' => 'i', 'Й' => 'i', 'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r', 'С' => 's', 'Т' => 't', 'У' => 'y', 'Ф' => 'f', 'Х' => 'h', 'Ц' => 'c', 'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'sh', 'Ы' => 'i', 'Э' => 'e', 'Ю' => 'u', 'Я' => 'ya', 'ь'=>'', 'ъ'=>'', 'Ь'=>'', 'Ъ'=>'',
		);

		$str=str_replace(' ','_',html_entity_decode($str));
		$str=preg_replace('/[^a-z0-9_\-]/','',strtolower(strtr($str,$_str_translit)));
		return $str;
	}	
}