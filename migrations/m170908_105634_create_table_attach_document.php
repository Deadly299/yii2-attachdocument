<?php

use yii\db\Migration;
use yii\db\Schema;


class m170908_105634_create_table_attach_document extends Migration
{
    public function safeUp() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $connection = Yii::$app->db;
        try {

            $this->createTable('{{%attach_document}}', [
                'id' => Schema::TYPE_PK . "",
                'model' => Schema::TYPE_STRING . "(255)",
                'item_id' => Schema::TYPE_INTEGER . "(11)",
                'name' => Schema::TYPE_STRING . "(200) NOT NULL",
                'file_name' => Schema::TYPE_STRING . "(250) NOT NULL",
                'created_at' => Schema::TYPE_INTEGER . "(11)",
                'updated_at' => Schema::TYPE_INTEGER . "(11)",
            ], $tableOptions);

        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage() . ' ';
        }
    }

    public function safeDown()
    {
        $connection = Yii::$app->db;
        try {
            $this->dropTable('{{%attach_document}}');
        } catch (Exception $e) {
            echo 'Catch Exception ' . $e->getMessage();
        }
    }
}
