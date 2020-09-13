<?php
/*
* ナビゲーションバー(include用)
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
<nav class="navigation-bar">
   <ul>
      <a href=""><li>ダッシュボード</li></a><!---
      --><a href=""><li>新規記事</li></a><!---
   --><a href=""><li>シリーズ</li></a><!---
--><a href=""><li>カテゴリー</li></a><!---
--><a href=""><li>タグ</li></a><!---
--><a href=""><li>コメント</li></a><!---
--><a href=""><li>メディア</li></a><!---
--><a href=""><li>設定</li></a><!---
-->
   </ul>
</nav>
