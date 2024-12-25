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
    /**
     * Constructor
     *
     * @param \Pimple\Psr11\Container $container
     * @param array                   $allowedMethods
     */
    public function __construct(
        protected Container $container,
        private array $allowedMethods = []
    ) {
    }

    public function defaultAction()
    {
        header('Allow: ' . implode(', ', $this->allowedMethods), true, 405);
    }
}
