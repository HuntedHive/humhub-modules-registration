<?php

class RegistrationEvents {
    /** 
     * Add the Q&A menu item to 
     * the top menu 
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        /**
         * User registration of new input
         */
        $event->sender->addItem(array(
            'label' => Yii::t('AdminModule.widgets_AdminMenuWidget', 'Registration'),
            'url' => Yii::app()->createUrl('registration/registration/index'),
            'icon' => '<i class="fa fa-user-plus"></i>',
            'sortOrder' => 10000,
            'group' => 'manage',
            'newItemCount' => 0,
            'isActive' => (Yii::app()->controller->module && Yii::app()->controller->module->id == 'admin' && Yii::app()->controller->id == 'registration'),
            'isVisible' => Yii::app()->user->isAdmin(),
        ));
    }

}