<?php
  $targetFolder = $_SERVER['DOCUMENT_ROOT'].'/../storage/app/public';
	echo $targetFolder;
	echo "<br>";
  $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
	echo $linkFolder;
	echo "<br>";
  echo symlink($targetFolder,$linkFolder);
?>