<?php

class m150617_105552_add_depend extends EDbMigration
{

    public function up()
    {
        $this->addColumn("manage_registration", "depend", "INT(11) NOT NULL DEFAULT '0'");
    }

    public function down()
    {
        //not work!!
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