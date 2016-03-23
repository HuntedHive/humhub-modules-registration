<?php

class m150617_104142_initial extends EDbMigration
{

    public function up()
    {
        $this->createTable('manage_registration', [
            'id' => 'pk',
            'name' => 'varchar(100) NOT NULL',
            'type' => 'int(11) NOT NULL',
            'default' => 'int(11) NOT NULL',
            'created_at' => 'datetime NOT NULL',
            'created_by' => 'int(11) NOT NULL',
            'updated_at' => 'int(11) NOT NULL',
            'updated_by' => 'int(11) NOT NULL',
            ], ''
        );

        foreach (ManageRegistration::$type as $key => $value) {
            $this->insert('setting', [
                    'name' => 'type_manage',
                    'value' => $value,
                    'value_text' => 0,
                ]
            );
        }
    }

    public function down()
    {
        $this->dropTable("manage_registration");
        HSetting::model()->deleteAll('name="type_manage"');
    }
    /*
      // Use safeUp/safeDown to do migration with transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}