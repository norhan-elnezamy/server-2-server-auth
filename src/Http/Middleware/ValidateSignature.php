<?php

namespace Auth\SignedRequest\Http\Middleware;

use Auth\SignedRequest\Classes\Signature;
use Illuminate\Http\Request;
use Closure;

class ValidateSignature
{
    private Signature $signature;

    public function __construct(Signature $signature)
    {
        $this->signature = $signature;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requestSignature = request()->header('Signature');

        $this->signature->validate($request->all(), $requestSignature);

        return $next($request);
    }
}
