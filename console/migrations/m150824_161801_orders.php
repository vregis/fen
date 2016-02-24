<?php

use yii\db\Migration;

class m150824_161801_orders extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'room_id' => $this->integer()->notNull(),
            'email' => $this->string()->notNull(),
            'message' => $this->text()->notNull(),
            'status' => $this->integer(1)->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->insert('modules', [
            'module' => 'orders',
            'name' => 'Заявки',
            'active' => 1
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%orders}}');
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
