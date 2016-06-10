<?php

class m160610_145153_manage_file_add extends EDbMigration
{
	public function up()
	{
		$this->addColumn("manage_registration", "file_name", "TEXT NULL");
		$this->addColumn("manage_registration", "file_path", "TEXT NULL");
		$this->addColumn("profile", "teacher_type", "TEXT NULL");
	}

	public function down()
	{
		$this->dropColumn("manage_registration", "file_name");
		$this->dropColumn("manage_registration", "file_path");
		$this->dropColumn("profile", "teacher_type");
	}
}