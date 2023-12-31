<?php

namespace Manifesthq\Translation;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Manifesthq\Translation\Skeleton\SkeletonClass
 */
class TranslationFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'translation';
    }
}
