<?php
/*
* DBにアクセスしてデータを取れるか確認するスクリプト
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

    // テーブル一覧表示
    $stmt = $pdo->query('show tables');
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
