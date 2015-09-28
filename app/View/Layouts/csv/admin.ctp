<?php
header("Pragma: no-cache");
header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
header('Content-Type: text/csv');
//header("Content-Disposition:inline;filename=".$filename_for_layout.".csv");
header("Content-Disposition:attachment;filename=".$filename_for_layout.".csv");

Configure::write('debug', 1);

echo $content_for_layout;
?>