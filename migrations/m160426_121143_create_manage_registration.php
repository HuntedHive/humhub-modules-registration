<?php

/**
 * Connected Communities Initiative
 * Copyright (C) 2016  Queensland University of Technology
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.org/licences GNU AGPL v3
 *
 */

use humhub\models\Setting;
use humhub\modules\registration\models\ManageRegistration;

class m160426_121143_create_manage_registration extends \yii\db\Migration
{
	public function up()
	{
		if(!\Yii::$app->db->schema->getTableSchema("manage_registration")) {
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
		}
		foreach (ManageRegistration::$type as $key => $value) {
			if(empty(Setting::find()->andWhere(["name" => 'type_manage'])->andWhere(['value' => $value])->one())) {
				$setting = new Setting;
				$setting->name = "type_manage";
				$setting->value = $value;
				$setting->value_text = 0;
				$setting->save(false);
			}
		}
	}

	public function down()
	{
		$this->dropTable("manage_registration");
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
