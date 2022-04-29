<?php
/**
 * @copyright 2022 Anthon Pang
 */
namespace App\Controller;

use App\Controller\AbstractController;

/**
 * 404 Not Found
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class NotFoundController extends AbstractController
{
    public function defaultAction()
    {
        http_response_code(404);
    }
}
