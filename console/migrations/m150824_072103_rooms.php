<?php

use yii\db\Migration;

class m150824_072103_rooms extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rooms}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(0),
            'gallery_cat_id' => $this->integer()->defaultValue(0),
            'alias' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'title' => $this->text()->notNull(),
            'description' => $this->text()->notNull(),
            'keywords' => $this->text()->notNull(),
            'publish' => $this->integer(1)->defaultValue(1),
            'pos' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->insert('modules', [
            'module' => 'rooms',
            'name' => 'Номера',
            'active' => 1
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%rooms}}');
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

