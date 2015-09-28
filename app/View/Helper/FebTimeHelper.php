<?php 
class FebTimeHelper extends AppHelper  {

    public $helpers = array('Time');
	

    function niceShort($dateString = null, $userOffset = null, $options = array()) {
        setlocale(LC_ALL, 'ru-RU.utf8', 'ru_RU.UTF8', 'ru_RU.utf8', 'ru_RU.UTF-8', 'ru_RU.utf-8', 'russian_RUSSIAN.UTF8', 'russian_RUSSIAN.utf8', 'ru.UTF8', 'russian.UTF8', 'russian-ru.UTF8', 'RU.UTF8', 'russian.utf8', 'russian-ru.utf8', 'RU.utf8','russian');
//        setlocale(LC_TIME, 'ru_RU.UTF-8', 'russian', 'ru.UTF-8', 'pol.UTF-8');
//        setlocale(LC_ALL, 'ru_RU.UTF-8');
//        setlocale(LC_ALL,"US");
        $timeFalse = (isset($options['time']) and !$options['time']); 
        
        $HM = $timeFalse?'':'%H:%M,';
        
        
		$date = $dateString ? $this->Time->fromString($dateString, $userOffset) : time();

		$y = $this->Time->isThisYear($date) ? '' : ' %Y';

		if ($this->Time->isToday($date)) {
			$ret = __('dzisiaj, %s', strftime("%H:%M", $date));
		} elseif ($this->Time->wasYesterday($date)) {
			$ret = __('wczoraj, %s', strftime("%H:%M", $date));
		} else {
			$format = $this->Time->convertSpecifiers("{$HM} %d %b {$y}", $date);
			$ret = strftime($format, $date);
                        
			$format = $this->Time->convertSpecifiers("{$HM} %d %b {$y}", $date);
//			$ret = strftime($format, $date);
//			$ret = iconv('iso-8859-2', 'utf-8', strftime($format, $date));
		}

		return $ret;
	}
    
}
?>