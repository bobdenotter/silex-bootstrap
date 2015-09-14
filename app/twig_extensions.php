<?php


/**
 * The class for Bolt' Twig tags, functions and filters.
 */
class TwigExtension extends \Twig_Extension
{
    /** @var \Silex\Application */
    private $app;

    /**
     * @param \Silex\Application $app
     * @param \Pimple            $handlers
     * @param boolean            $safe
     */
    public function __construct(Silex\Application $app)
    {
        $this->app      = $app;
        // $this->handlers = $handlers;
        // $this->safe     = $safe;
    }

    public function getName()
    {
        return 'SilexBootstrap';
    }


    public function getFunctions()
    {
        $safe = ['is_safe' => ['html']];
        $env  = ['needs_environment' => true];

        return [
            new \Twig_SimpleFunction('asset', [$this, 'asset']),
            new \Twig_SimpleFunction('dump', [$this, 'dump']),
        ];
    }

    public function getFilters()
    {
        $safe = ['is_safe' => ['html', 'asset']];
        $env  = ['needs_environment' => true];

        return [];
    }

    public function asset($asset)
    {
        return $this->app['request_stack']->getMasterRequest()->getBasepath().'/'.ltrim($asset, '/');
    }

    public function dump($var)
    {
        if ($this->app['config']['debug']) {
            dump($var);
        }
    }

}

