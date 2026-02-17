<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
declare(strict_types=1);

namespace App\Policy;

use Authorization\IdentityInterface;
use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;

class RequestPolicy implements RequestPolicyInterface
{

    /**
     * Method to check if the request can be accessed
     *
     * @param
     * \ Authorization \ IdentityInterface | null Identity
     * @param \ Cake \ Http \ ServerRequest $ request
     * Server Request
     * @return bool
     */
    public function canAccess(?IdentityInterface $user, ServerRequest $request)
    {

        /*
         * Debugkit bypass authorize
         */
        if (($request->getParam('plugin') === 'DebugKit')) {
            return true;
        }

        /*
         * bypass other required functions such as pagesController
         */
        if ($request->getParam('controller') === 'Pages') {
            return true;
        }
        
        // Default deny access
        return false;

    }

}
