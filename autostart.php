<?php

Yii::app()->moduleManager->register(array(
    'id' => 'registration',
    'class' => 'application.modules.registration.RegistrationModule',
    'import' => array(
        'application.modules.registration.*',
        'application.modules.registration.models.*',
    ),
    'events' => array(
        array('class' => 'AdminMenuWidget', 'event' => 'onInit', 'callback' => array('RegistrationEvents', 'onAdminMenuInit')),
    ),
));
?>