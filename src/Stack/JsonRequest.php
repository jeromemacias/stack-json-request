<?php

namespace Stack;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class JsonRequest implements HttpKernelInterface
{
    private $app;
    private $contentTypes = array('application/json');

    public function __construct(HttpKernelInterface $app, array $contentTypes = array())
    {
        $this->app = $app;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (in_array($request->headers->get('Content-Type'), $this->contentTypes, true)) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }

        return $this->app->handle($request, $type, $catch);
    }
}
