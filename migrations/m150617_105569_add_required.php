<?php

class m150617_105569_add_required extends EDbMigration
{

    public function up()
    {
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
        //not work!!
    }
}