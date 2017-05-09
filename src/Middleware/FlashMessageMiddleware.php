<?php
/****
 * Register in middleware
 * @see app\Http\Kernel.php
 *
 * -----------------------------------------------------
 * protected $middleware = [
 *    ...
 *    Kaoken\FlashMessage\FlashMessageMiddleware:class
 * -----------------------------------------------------
 * or
 * protected $middlewareGroups = [
 *    'web' => [
 *        ...
 *        Kaoken\FlashMessage\FlashMessageMiddleware:class
 * -----------------------------------------------------
 * or
 * protected $routeMiddleware = [
 *    ...
 *    'flash.message' => Kaoken\FlashMessage\FlashMessageMiddleware:class
 */
namespace Kaoken\FlashMessage\Middleware;

use FlashMessage;
use Closure;

class FlashMessageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('flashMessage', FlashMessage::getInstance());
        return $next($request);
    }
}