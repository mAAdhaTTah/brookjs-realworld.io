<?php
namespace App\Http\Controller;

use App\View\Handlebars;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

class HomeController
{
    /**
     * View service.
     *
     * @var Handlebars
     */
    private $view;

    /**
     * HomeController constructor.
     *
     * @param Handlebars $view
     */
    public function __construct(Handlebars $view)
    {
        $this->view = $view;
    }

    /**
     * Index route handler.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, 'layout', [
            'title' => 'realworld.io',
            'state' => new stdClass,
            'props' => new stdClass,
        ]);
    }
}