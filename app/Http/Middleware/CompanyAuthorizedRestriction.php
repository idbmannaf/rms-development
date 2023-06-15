<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Company;

class CompanyAuthorizedRestriction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        dd($request->companyId);
        $user =$request->user();
        $company_id = is_object($request->company) ? $request->company->id :  $request->company;
        if($user){
            if(!$user->isAdmin() && $company_id) {
                $company =Company::find($company_id);
                if(!$company){
                    abort(404);
                }
                if ($company->user_id != $user->id) {
                    abort(401, 'Unauthorized');
                }
            }elseif($company_id){
                $company =Company::find($company_id);
                if(!$company){
                    abort(404);
                }
            }
        }
        return $next($request);
    }
}
