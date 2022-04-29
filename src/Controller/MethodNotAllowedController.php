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
        http_response_code(405);
    }
}
