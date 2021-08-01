<?php
/*
* 記事一覧ページ
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
   //記事全件取得 メタデータ込み
   $stmt = $pdo->query('SELECT `notes`.`note_id` AS `id`,`title`,`title`,`publish_datetime`,`update_datetime`,`publish_status` FROM `notes` LEFT OUTER JOIN `notes_metadata` ON notes.note_id = notes_metadata.note_id');
   $rows = $stmt->fetchAll();
   var_dump($rows);

   /* 取得したデータから出力用のhtmlを生成する処理 */
   $table_body = "";
   foreach ($rows as $key => $value) {
      $publish_status;
      switch ($value['publish_status']) {
         case 0:
         $publish_status = "公開中";
         break;
         case 1:
         $publish_status = "限定公開";
         break;
         case 2:
         $publish_status = "非公開";
         break;
         case 3:
         $publish_status = "論理削除";
         break;

         default:
         $publish_status = "取得失敗";
         break;
      }
      $table_body .= '
         <div class="table_body">
            <span class="id">'. $value['id'] .'</span>
            <span class="name" title="'. $value['title'] .'">'. $value['title'] .'</span>
            <span class="number"><p>comming soon</p></span>
            <span class="status"><p>'.$publish_status.'</p></span>
            <span class="edit">
               <a href="javascript:void(0)" onClick="open_editline(\'table_body_'. $value['id'] .'\');return false;" id="openclose_editline">編集</a>
            </span>
         </div>
         ';
   }

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
   <title>Note</title>
</head>
<body>
   <?php include 'nav.php'; ?>
   <div class="main">
      <div class="h1_title">
         記事一覧
      </div>
      <div class="list" >
         <div class="table">
            <div class="table_head">
               <span class="id">ID</span>
               <span class="name">記事名</span>
               <span class="number">コメント数</span>
               <span class="status">公開状態</span>
               <span class="edit">操作</span>
            </div>
            <?php echo $table_body ?>
         </div>
      </div>
   </body>
