<?php

use yii\db\Migration;

class m150819_130758_gallery extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%gallery}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(0),
            'name' => $this->string()->notNull(),
            'publish' => $this->integer(1)->defaultValue(1),
            'pos' => $this->integer()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ], $tableOptions);

        $this->createTable('{{%gallery_images}}', [
            'id' => $this->primaryKey(),
            'gallery_cat_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'alt' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'basename' => $this->string()->notNull(),
            'ext' => $this->string()->notNull(),
            'publish' => $this->integer(1)->defaultValue(1),
            'pos' => $this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->insert('modules', [
            'module' => 'gallery',
            'name' => 'Галерея',
            'active' => 1
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%gallery}}');
        $this->dropTable('{{%gallery_images}}');
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
