<?php
namespace App\Library\FlashMessage;

use Illuminate\Support\ServiceProvider;

class FlashMessageServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('kaoken.flash_message', function ($app) {
            return $this->cast(new FlashMessageManager($app));
        });
    }

    /**
     * Cast to the interface
     * @param IFlashMessageManager $i
     * @return IFlashMessageManager
     */
    private function cast(IFlashMessageManager $i) { return $i; }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'kaoken.flash_message'
        ];
    }
}
