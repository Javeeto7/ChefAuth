<?php namespace Reivaj86\ChefAuth\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Reivaj86\ChefAuth\Cooker;

class CookerMiddleware {

    /**
     * The Chef implementation.
     *
     * @var ChefAuth
     */
    protected $cooker;

    /**
     * Create a new filter instance.
     *
     * @param  Cooker  $cooker
     * @return void
     */
    public function __construct(Cooker $cooker)
    {
        $this->cooker = $cooker;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->cooker)
        {
            if ($request->ajax())
            {
                return response('Granted to.', 401);
            }
            else
            {
                return redirect()->guest('auth/login');
            }
        }

        return $next($request);
    }

}
