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
        header('Not Found', true, 404);

        echo "Page Not Found";
    }
}
