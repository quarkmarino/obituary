<?php

return [

    'initialize' => function($authority){
        $user = $authority->getCurrentUser();
        $authority->addAlias('post', ['create']);
        $authority->addAlias('moderate', ['post', 'read', 'update']);
        $authority->addAlias('manage', ['index', 'moderate', 'delete']);

        if($user->hasRole('admin')) {
            Authority::allow('manage', 'all');
        }

        if($user->hasRole('promoter')) {
            Authority::allow('manage', 'Obituary', function($self, $obituary){
                return $self->getCurrentUser()->id === $obituary->promoter_id && $obituary->owner_id === null;
            });

            Authority::allow('moderate', 'Condolence', function($self, $condolence){
                return $self->getCurrentUser()->id === $condolence->obituary->promoter_id && $condolence->obituary->owner_id === null;
            });
        }

        if($user->hasRole('owner')) {
            Authority::allow('moderate', 'Obituary', function($self, $obituary){
                return $self->getCurrentUser()->id === $obituary->owner_id;
            });

            Authority::allow('moderate', 'Condolence', function($self, $condolence){
                return $self->getCurrentUser()->id === $condolence->obituary->owner_id;
            });
        }

        if($user->hasRole('guest')) {
            Authority::allow('post', 'Condolence');
        }
    }
];