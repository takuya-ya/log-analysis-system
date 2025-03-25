<?php

namespace LogAnalysisSystem;

use Dotenv;
use PDOException;
use PDO;

class DBConnector
{
    public PDO $pdo;
    public function __construct()
    {
        // .env ファイルを読み込むためのライブラリを使用
        $dotenv = Dotenv\Dotenv::createImmutable('/var/www/html');
        $dotenv->load();

        // PDO のオプション設定
        $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // エラーモードを例外（Exception）に設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // デフォルトのデータ取得形式を連想配列に設定
        ];

        try {
            // 環境変数からデータベース接続情報を取得し、PDOインスタンスを作成
            $this->pdo = new PDO(
                getenv('DB_DSN'),    // DSN（データソース名）
                getenv('DB_USER'),   // ユーザー名
                getenv('DB_PASSWORD'),  // パスワード
                $option                // オプション
            );
            echo 'OK' . PHP_EOL; // 成功メッセージ
        } catch (PDOException $e) {
            // エラー発生時にメッセージを表示
            error_log('データベース接続に失敗しました: ' . $e->getMessage());
            echo 'データベース接続に失敗しました。ログを確認して下さい' . PHP_EOL;
        }
    }

    // 責任分離の為にメソッドを分離しているが、小規模開発では必須ではない
    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
