<?php

namespace Guetteman\LaravelTinkerServer;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Guetteman\LaravelTinkerServer\Skeleton\SkeletonClass
 */
class LaravelTinkerServerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-tinker-server';
    }
}
