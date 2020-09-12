<?php
/*
* HTMLヘッダ(include用)
*/

// 本文
$head ='
<head>
   <link rel="stylesheet" href="./css/style.css" />
   <link rel="stylesheet" href="./css/reset.css" />
</head>';

// 直接呼び出すと404(クソコード)
$a = get_included_files();
$b = array_shift($a);
if ($b === __FILE__) {
   header('Content-Type: text/plain; charset=UTF-8', true, 404);
   die('404 Not found');
}
