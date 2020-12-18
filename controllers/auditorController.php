<?php

declare(strict_types=1);

namespace app\controllers;

use app\Router;
use app\models\User;
use app\utility\Redirect;
use app\utility\Permissions;

class auditorController
{

    public function addInvoice($router)
    {
        //Permissions::check("user");
        $router->render("pages/components/invoiceForm");
    }

}