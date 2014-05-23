<?php
   $filename = "http://www.sport.es/es/rss/mundial-futbol/rss.xml";
   header("Content-type:text/xml");
   readfile ($filename);
?>
