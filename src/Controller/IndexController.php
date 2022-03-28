<?php
/**
 * @copyright 2022 Anthon Pang
 */
namespace App\Controller;

use App\Controller\AbstractController;

/**
 * Home page
 *
 * @author Anthon Pang <apang@softwaredevelopment.ca>
 */
class IndexController extends AbstractController
{
    public function defaultAction()
    {
        $this->render(__METHOD__);
    }
}
