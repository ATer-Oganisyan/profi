<?php
/**
 * Vendor: TerOganisyan
 * Author: arsen
 */

namespace Main;

/**
 * Class Controller
 *
 * @package Main
 */
class Controller
{

    /**
     * @var RequestHandler
     */
    private $handler;

    /**
     * @param Controller $controller
     *
     * @param $request
     *
     * @return array
     */
    static public function action(Controller $controller, $request)
    {
        if (isset($request['name']) && isset($request['post']) && $request['post']) {
            return $controller->submitAction($request);
        } else {
            return $controller->mainAction();
        }
    }

    /**
     * Controller constructor.
     *
     * @param RequestHandler $handler
     */
    public function __construct(RequestHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return array
     */
    public function mainAction()
    {
        return [
            'view' => "main",
            'result' => []
        ];
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function submitAction(array $request)
    {
        try {
            return [
                'view' => 'main',
                'result' => [
                    'SQL' => $this->handler->getSQL($request),
                    'tel' => $this->handler->getTelList($request['tel'])
                ],
                'request' => $request
            ];
        } catch (Displayable $e) {
            return [
                'view' => 'main',
                'error' => $e->display(),
                'request' => $request
            ];
        }
    }
}