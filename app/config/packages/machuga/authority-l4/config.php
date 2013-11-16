<?php

return [

    'initialize' => function($authority){
        $user = $authority->getCurrentUser();

        /*$authority->addAlias('post', ['create']);
        $authority->addAlias('moderate', ['post', 'read', 'update']);
        $authority->addAlias('manage', ['index', 'moderate']);
        $authority->addAlias('admin', ['manage', 'delete']);*/

        $authority->addAlias('post', ['create']);
        $authority->addAlias('moderate', ['create', 'read', 'update']);
        $authority->addAlias('manage', ['index', 'create', 'read', 'update']);
        $authority->addAlias('admin', ['index', 'create', 'read', 'update', 'delete']);

        if($user->hasRole('admin')) {
            $authority->allow('admin', 'all');
        }

        if($user->hasRole('promoter')) {
            $authority->allow('manage', 'Deceased', function($self, $deceased){
                return $self->getCurrentUser()->id === $deceased->mortuary->owner_id;
            });

            $authority->allow('manage', 'Obituary', function($self, $obituary){
                return $self->getCurrentUser()->id === $obituary->promoter_id && $obituary->owner_id === null;
            });

            $authority->allow('moderate', 'Condolence', function($self, $condolence){
                return $self->getCurrentUser()->id === $condolence->obituary->promoter_id && $condolence->obituary->owner_id === null;
            });

            $authority->allow('moderate', 'Event', function($self, $event){
                return $self->getCurrentUser()->id === $event->obituary->promoter_id && $event->obituary->owner_id === null;
            });

            $authority->allow('moderate', 'Memory', function($self, $memory){
                return $self->getCurrentUser()->id === $memory->obituary->promoter_id && $memory->obituary->owner_id === null;
            });
        }

        if($user->hasRole('owner')) {
            $authority->allow('manage', 'Obituary', function($self, $obituary){
                return $self->getCurrentUser()->id === $obituary->owner_id;
            });

            $authority->allow('moderate', 'Condolence', function($self, $condolence){
                return $self->getCurrentUser()->id === $condolence->obituary->owner_id;
            });

            $authority->allow('moderate', 'Event', function($self, $event){
                return $self->getCurrentUser()->id === $event->obituary->owner_id;
            });

            $authority->allow('moderate', 'Memory', function($self, $memory){
                return $self->getCurrentUser()->id === $memory->obituary->owner_id;
            });
        }

        if($user->hasRole('guest')) {
            $authority->allow('post', 'Condolence');
        }


        // loop through each of the users permissions, and create rules
        foreach($user->permissions as $perm) {
            if($perm->type == 'allow') {
                $authority->allow($perm->action, $perm->resource);
            } else {
                $authority->deny($perm->action, $perm->resource);
            }
        }
    }
];