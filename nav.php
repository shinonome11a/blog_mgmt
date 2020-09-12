<?php
/*
* ナビゲーションバー(include用)
*/

// 本文
$nav ='
<nav class="navigation-bar">
   <ul>
      <a href=""><li>Dashboard</li></a><!---
      --><a href=""><li>New note</li></a><!---
   --><a href=""><li>Series</li></a><!---
--><a href=""><li>Categorys</li></a><!---
--><a href=""><li>Tags</li></a><!---
--><a href=""><li>Comments</li></a><!---
--><a href=""><li>Media</li></a><!---
--><a href=""><li>Settings</li></a><!---
-->
   </ul>
</nav>';

// 直接呼び出すと404(クソコード)
$a = get_included_files();
$b = array_shift($a);
if ($b === __FILE__) {
   header('Content-Type: text/plain; charset=UTF-8', true, 404);
   die('404 Not found');
}
