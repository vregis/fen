<?php

use yii\db\Migration;

class m140819_113048_modules extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%modules}}', [
            'id' => $this->primaryKey(),
            'module' => $this->string(),
            'name' => $this->string(),
            'active' => $this->integer(1)->defaultValue(1)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%modules}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
