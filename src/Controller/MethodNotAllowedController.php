<?php
/**
 * @copyright 2022 Anthon Pang
 */
namespace App\Controller;

use App\Controller\AbstractController;

/**
 * 405 Method Not Allowed
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class MethodNotAllowedController extends AbstractController
{
    public function defaultAction()
    {
        header('Method Not Allowed', true, 405);

        echo "Method Not Allowed";
    }
}
