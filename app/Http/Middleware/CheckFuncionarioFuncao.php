<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckFuncionarioFuncao
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::guard('funcionario')->user();
        if ($user && in_array($user->func_cod_funcao, [1, 6, 7, 13])) {
            return $next($request);
        }
        abort(403, 'Acesso não autorizado.');
    }
}
