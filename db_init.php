<?php
/*
* DB・Tableを作成するスクリプト
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
        'mysql:host=' . $host . ';charset=utf8mb4',
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    /* データベースから値を取ってきたり， データを挿入したりする処理 */
    // DB作成
    $stmt = $pdo->query('create database ' . $db_name . ';');

    // Table作成(13コ)
    // ここから
    $stmt = $pdo->query('create table ' . $db_name . '.notes (note_id int unsigned NOT NULL PRIMARY KEY, title text, note longtext, publish_status tinyint unsigned)');
    $stmt = $pdo->query('create table ' . $db_name . '.note_log (note_datetime datetime NOT NULL PRIMARY KEY, note_id int unsigned, address tinytext, port smallint unsigned, user_agent longtext)');
    $stmt = $pdo->query('create table ' . $db_name . '.note_counter (note_id int unsigned NOT NULL PRIMARY KEY, view_counter int unsigned, good_counter int unsigned, bad_counter int unsigned)');

    $stmt = $pdo->query('create table ' . $db_name . '.comments (comment_id int unsigned NOT NULL PRIMARY KEY, comment longtext, contributor_name longtext, contributor_email longtext, note_id int unsigned, publish_status tinyint unsigned)');
    $stmt = $pdo->query('create table ' . $db_name . '.comment_log (comment_datetime datetime NOT NULL PRIMARY KEY, comment_id int unsigned, address tinytext, port smallint unsigned, user_agent longtext)');
    $stmt = $pdo->query('create table ' . $db_name . '.comment_counter (comment_id int unsigned NOT NULL PRIMARY KEY, good_counter int unsigned, bad_counter int unsigned)');

    $stmt = $pdo->query('create table ' . $db_name . '.categories (category_id int unsigned NOT NULL PRIMARY KEY, category_name text)');
    $stmt = $pdo->query('create table ' . $db_name . '.category_entry (entry_id int unsigned NOT NULL PRIMARY KEY, category_id int unsigned, note_id int unsigned)');

    $stmt = $pdo->query('create table ' . $db_name . '.tags (tag_id int unsigned NOT NULL PRIMARY KEY, tag_name text)');
    $stmt = $pdo->query('create table ' . $db_name . '.tag_entry (entry_id int unsigned NOT NULL PRIMARY KEY, tag_id int unsigned, note_id int unsigned)');

    $stmt = $pdo->query('create table ' . $db_name . '.series (series_id int unsigned NOT NULL PRIMARY KEY, series_name text)');
    $stmt = $pdo->query('create table ' . $db_name . '.series_entry (entry_id int unsigned NOT NULL PRIMARY KEY, series_id int unsigned, note_id int unsigned, number int unsigned)');

    $stmt = $pdo->query('create table ' . $db_name . '.media (media_id int unsigned NOT NULL PRIMARY KEY, mime_type text, media_discription longtext, upload_datetime datetime)');
    // ここまで

    // 作成したテーブル一覧表示
    $stmt = $pdo->query('show tables in ' . $db_name . '');
    $rows = $stmt->fetchAll();
    header('Content-type:text/plain charset=UTF-8');
    var_dump($rows);

} catch (PDOException $e) {

    /* エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
    * - もし手抜きしたくない場合は普通にHTMLの表示を継続する
    * - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
    */
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());

}
?>
