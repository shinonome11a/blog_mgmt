<?php
/*
* ダッシュボードページ
* 実質的にはトップページ
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
   $stmt = $pdo->query('select count(note_id) from notes where publish_status<2;'); //公開している記事のみ取得(非公開・論理削除は含まない)
   $rows = $stmt->fetchAll();
   // var_dump($rows);
   $notes = $rows[0]['count(note_id)'];

   // コメント数取得
   $stmt = $pdo->query('select count(comment_id) from comments where publish_status<2;');//公開しているコメントのみ取得(非公開・論理削除は含まない)
   $rows = $stmt->fetchAll();
   $comments = $rows[0]['count(comment_id)'];

   // 閲覧数取得
   $stmt = $pdo->query('select sum(view_counter) from note_counter;');
   $rows = $stmt->fetchAll();
   $views = $rows[0]['sum(view_counter)'];
   if ($views === NULL) $views = 0;
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
   <title>Dashboard</title>
</head>
<body>
   <?php include 'nav.php'; ?>
   <div class="main">
      <div class="h1_title">
         ダッシュボード
      </div>
      <div class="message_box" id="overview">
         <div class="message_box_title">
            <h2>概要</h2>
         </div>
         <div class="message_box_body">
            <ul>
               <li>総記事数: <?php echo $notes; ?></li>
               <li>総コメント数: <?php echo $comments; ?></li>
               <li>総閲覧数: <?php echo $views; ?></li>
            </ul>
         </div>
      </div>
      <div class="message_box" id="new_comments">
         <div class="message_box_title">
            <h2>最新コメント</h2>
         </div>
         <div class="message_box_body">
            hoge
         </div>
      </div>
      <div class="message_box" id="view">
         <div class="message_box_title">
            <h2>最新コメント</h2>
         </div>
         <div class="message_box_body">
            hoge
         </div>
      </div>
   </body>
