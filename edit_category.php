<?php
/*
* カテゴリー新規作成・一覧ページ
*/


try {
   header('Content-Type: text/plain; charset=UTF-8');
   header('Location: category.php');
   /* リクエストから得たスーパーグローバル変数をチェックするなどの処理 */
   /*POSTでない場合は404*/
   // if($_SERVER["REQUEST_METHOD"] != "POST"){
   //    header('Content-Type: text/plain; charset=UTF-8', true, 404);
   //    die('404 Not found');
   // }

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
   // カテゴリIDの最大値を取得
   $stmt = $pdo->query('SELECT category_id FROM `categories` ORDER BY category_id DESC LIMIT 1'); //カテゴリー全件取得
   $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
   var_dump($rows);
   $category_id_last = $rows[0];
   echo $category_id_last; // $category_id_last: 取得したカテゴリIDの最大値

   // カテゴリ編集本番
   switch ($_GET["method"]) {
      case 'insert': // 新規追加
      if (empty($_GET['category_name'])) {
         return;
      }
      $query = "INSERT INTO `categories` (`category_id`, `category_name`) VALUES (:id, :name)";
      $sth = $pdo -> prepare($query); // この一連、SQLインジェクション対策
      $sth -> bindValue(':id', $category_id_last + 1);
      $sth -> bindValue(':name', $_GET['category_name']);
      $sth -> execute();
      break;

      case 'delete': // 削除
      $query = "DELETE FROM `categories` WHERE `categories`.`category_id` = :id;";
      $sth = $pdo -> prepare($query); // この一連、SQLインジェクション対策
      $sth -> bindValue(':id', $_GET['category_id']);
      $sth -> execute();
      break;

      case 'update': // 名前変更
      if (empty($_GET['category_name'])) {
         return;
      }
      $query = "UPDATE `categories` SET `category_name` = :name WHERE `categories`.`category_id` = :id";
      $sth = $pdo -> prepare($query); // この一連、SQLインジェクション対策
      $sth -> bindValue(':id', $_GET['category_id']);
      $sth -> bindValue(':name', $_GET['category_name']);
      $sth -> execute();
      break;
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
