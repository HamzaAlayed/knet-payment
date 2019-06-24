<?php



namespace  DeveloperH\Knet\Facades;

use Illuminate\Support\Facades\Facade;



/**
 * Class ShoppingCartFacade
 * @package LaraShout\ShoppingCart
 */
class KNetFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'knet';
    }
}
