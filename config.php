<?php

use humhub\modules\admin\widgets\AdminMenu;

return [
    'id' => 'registration',
    'class' => 'humhub\modules\registration\Module',
    'namespace' => 'humhub\modules\registration',
    'events' => array(
        array('class' => AdminMenu::className(), 'event' => AdminMenu::EVENT_INIT, 'callback' => array('humhub\modules\registration\Events', 'onAdminMenuInit')),
    ),
];
?>