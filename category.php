<?php
/*
* カテゴリー新規作成・一覧ページ
*/
try {
   /* リクエストから得たスーパーグローバル変数をチェックするなどの処理 */

   // 変数宣言
   $user = ""; // DBアクセスユーザ名
   $pass = ""; // DBアクセスパスワード
   $host = ""; // DBホスト名(IPアドレス) IPv6アドレスは[]で囲う
   $db_name = ""; // DB名
   $file = "./json_db.json"; // 保存するjsonファイル名
   // jsonファイル存在確認
   if(!file_exists($file)){
      echo "ファイルがありません";
   } else {
      // jsonファイル読み込み
      $json = file_get_contents($file);
      // jsonから連想配列に変換
      $array = json_decode($json,true);
      $user = $array['user'];
      $pass = $array['pass'];
      $host = $array['host'];
      $db_name = $array['db_name'];
   }

   // データベースに接続
   $pdo = new PDO(
      'mysql:dbname=' . $db_name . ';host=' . $host . ';charset=utf8mb4',
      $user,
      $pass,
      [
         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]
   );

   /* データベースから値を取ってきたり， データを挿入したりする処理 */
   // 記事数取得
   $stmt = $pdo->query('select * from categories'); //カテゴリー全件取得
   $rows = $stmt->fetchAll();
   var_dump($rows);

} catch (PDOException $e) {

   /* エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
   * - もし手抜きしたくない場合は普通にHTMLの表示を継続する
   * - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
   */
   header('Content-Type: text/plain; charset=UTF-8', true, 500);
   exit($e->getMessage());

}
/*以下本文*/
?>
<!DOCTYPE html>
<html>
<head>
   <?php include 'head.php'; ?>
   <title>Category</title>
</head>
<body>
   <?php include 'nav.php'; ?>
   <div class="main">
      <div class="h1_title">
         カテゴリー
      </div>
      <div class="new" id="new_category">
         <h2>新規カテゴリー作成</h2>
         <form action="new_category.php" method="post">
            <div class="input" id="text">
               <input type="text" class="text" name="category_name" value="" placeholder="カテゴリー名を入力" required>
            </div>
            <div class="input" id="button">
               <input type="submit" class="button" value="作成">
            </div>
         </form>
      </div>
      <div class="list" >
         <h2>カテゴリー</h2>
         <div class="table">
            <div class="table_head">
               <span class="id">ID</span>
               <span class="name">名前</span>
               <span class="number">記事数</span>
            </div>
            <div class="table_body">
               <span class="id">0000</span>
               <span class="name" title="hogefugaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa">hogefugaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
               <span class="number">0000</span>
            </div>
         </div>
      </div>
   </body>
