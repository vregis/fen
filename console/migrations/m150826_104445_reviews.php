<?php

use yii\db\Migration;

class m150826_104445_reviews extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'module_id' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'publish' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->insert('modules', [
            'module' => 'reviews',
            'name' => 'Отзывы',
            'active' => 1
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%reviews}}');
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
