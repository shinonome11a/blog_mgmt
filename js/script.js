/*送信確認ダイアログ*/
// 新規作成
function check_insert(){
   if(window.confirm('新規作成します。よろしいですか？')){ // 確認ダイアログを表示
      return true; // 「OK」時は送信を実行
   }
   else{ // 「キャンセル」時の処理
      return false; // 送信を中止
   }
}
// 編集
function check_edit(){
   if(window.confirm('更新します。よろしいですか？')){ // 確認ダイアログを表示
      return true; // 「OK」時は送信を実行
   }
   else{ // 「キャンセル」時の処理
      window.alert('キャンセルされました'); // 警告ダイアログを表示
      return false; // 送信を中止
   }
}
// 削除
function check_delete(type, value){
   if(window.confirm('削除します。よろしいですか？')){ // 確認ダイアログを表示
      return true; // 「OK」時は送信を実行
   }
   else{ // 「キャンセル」時の処理
      return false; // 送信を中止
   }
}

/*編集メニュー開け閉じ*/
function open_editline(id){
   const p1 = document.getElementById(id);
   if(p1.style.display=="block"){
      // noneで非表示
      p1.style.display ="none";
   }else{
      // blockで表示
      p1.style.display ="block";
   }
}
