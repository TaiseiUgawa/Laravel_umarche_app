## ECサイト作成

##　ダウンロード方法
git clone
git clone https://github.com/TaiseiUgawa/Laravel_umarche_app.git

git clone ブランチを指定してダウンロードする場合
git clone -b ブランチ名　https://github.com/TaiseiUgawa/Laravel_umarche_app.git

もしくはzipファイルでダウンロードしてください。

## インストール方法

-cd laravel_umarche    |  cd ディレクトリ移動
-composer insatall     |　コンポーザー(PHPのパッケージ、ライブラリ管理)のインストール
-npm install           |　Node.jsのモジュール管理ツールのインストール
-npm run dev           |  css,jsのコンパイルコマンド

.env.example をコピーして .envファイルを作成

.envファイルの中の下記をご利用の環境に合わせて変更してください。
※開発者はMAMP環境

-DB_CONNECTIION=mysql 
-DB_HOST=127.0.0.1
-DB_PORT=3306
-DB_DATABASE=laravel_umarche
-DB_USERNAME=umarche
-DB_PASSWORD=password123

XAMPP/MAMPまたは他の開発環境でDBを起動した後に

php artisan migrate:fresh --seed

と実行してください。（データベーステーブルとダミーデータが追加されればOK）

最後に
php artisan key:generate
と入力してキーを生成後

php artisan serve
で簡易サーバーを立ち上げ、表示を確認してください。

## インストール後の実施事項

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg ~ sample6.jpgとして
保存しています。

php artisan storage:linkで
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
(productsフォルダがない場合は作成してください。)

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し
画像を保存してください。

## 決済機能について

決済のテストとしてstripeを利用しています。
必要な場合は .env にstripeの情報を追記してください。

## メール機能について

メールのテストとしてmailtrapを利用しています。
必要な場合は .env にmailtrapの情報を追記してください。

メール処理には時間がかかるので、非同期処置として
キューを使用しています。

必要な場合は php artisan queue:workで
ワーカーを立ち上げて動作確認するようにしてください。

