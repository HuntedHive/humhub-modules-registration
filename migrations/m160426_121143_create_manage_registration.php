<?php

class m160426_121143_create_manage_registration extends EDbMigration
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
			if(empty(HSetting::model()->find("name='type_manage' AND value = '$value'"))) {
				$setting = new HSetting;
				$setting->name = "type_manage";
				$setting->value = $value;
				$setting->value_text = 0;
				$setting->save(false);
			}
		}
	}

	public function down()
	{
		echo "m160426_121143_create_manage_registration does not support migration down.\n";
		return false;
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