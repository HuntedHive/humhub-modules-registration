<?php

use humhub\models\Setting;
use humhub\modules\registration\models\ManageRegistration;

class m160426_121230_create_manage_depend extends \yii\db\Migration
{
	public function up()
	{
		$this->addColumn("manage_registration", "depend", "INT(11) NOT NULL DEFAULT '0'");
		foreach (ManageRegistration::$type as $key => $value) {
			if(empty(Setting::find()->andWhere(["name" => 'required_manage'])->andWhere(['value' => $value])->one())) {
				$setting = new Setting;
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