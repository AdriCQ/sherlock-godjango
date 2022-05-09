<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserHasRole
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @param  string $role
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next, string $role)
  {
    if ($request->user()->hasRole($role) || $request->user()->hasRole('admin'))
      return $next($request);

    return \response()->json(null, 401);
  }
}
