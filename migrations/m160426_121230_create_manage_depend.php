<?php

class m160426_121230_create_manage_depend extends EDbMigration
{
	public function up()
	{
		$this->addColumn("manage_registration", "depend", "INT(11) NOT NULL DEFAULT '0'");
		
		Yii::import("application.modules.registration.models.ManageRegistration");
		foreach (ManageRegistration::$type as $key => $value) {
			if(empty(HSetting::model()->find("name='required_manage' AND value = '$value'"))) {
				$setting = new HSetting;
				$setting->name = "required_manage";
				$setting->value = $value;
				$setting->value_text = 0;
				$setting->save(false);
			}
		}
	}

	public function down()
	{
		$this->dropColumn("manage_registration", "depend");
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