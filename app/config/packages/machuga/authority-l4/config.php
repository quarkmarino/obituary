<?php

return array(

    'initialize' => function($authority) {
    	$user = $authority->getCurrentUser();
    	
        $authority->addAlias('manage', array('create', 'read', 'update', 'delete'));
        $authority->addAlias('moderate', array('read', 'update', 'delete'));

        if($user->hasRole('manage')) {
          Authority::allow('manage', 'Condolence', function($self, $condolence){
		        return $self->getCurrentUser()->id === $condolence->obituary->owner_id;
			    });
        }

        
    }

);
