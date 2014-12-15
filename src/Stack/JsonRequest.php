<?php

namespace Stack;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\TerminableInterface;

class JsonRequest implements HttpKernelInterface, TerminableInterface
{
    private $app;
    private $contentType;

    public function __construct(HttpKernelInterface $app, $contentType = 'application/json')
    {
        $this->app = $app;
        $this->contentType = $contentType;
    }

    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        if (0 === strpos($request->headers->get('Content-Type'), $this->contentType)) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : array());
        }

        return $this->app->handle($request, $type, $catch);
    }

    public function terminate(Request $request, Response $response)
    {
        $request->headers->set('Content-Type', $this->contentType);
        $request->headers->set('Accept', $this->contentType);

        if ($this->app instanceof TerminableInterface) {
            $this->app->terminate($request, $response);
        }
    }
}
