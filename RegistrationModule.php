<?php
class RegistrationModule extends HWebModule{
 
    /**
     * Inits the Module
     */
    public function init()
    {

        $this->setImport(array(
            'registration.models.*',
        ));
    }
    
}