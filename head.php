<?php
/*
* HTMLヘッダ(include用)
*/

// 直接呼び出すと404(クソコード)
$a = get_included_files();
$b = array_shift($a);
if ($b === __FILE__) {
   header('Content-Type: text/plain; charset=UTF-8', true, 404);
   die('404 Not found');
}

// 以下本文
?>
<link rel="stylesheet" href="./css/reset.css" />
<link rel="stylesheet" href="./css/style.css" />
<script src="js/script.js" async></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
