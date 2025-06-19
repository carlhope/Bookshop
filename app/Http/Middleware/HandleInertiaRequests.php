<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use Throwable;


class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'layouts.app';



    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */

public function share(Request $request): array
{
    return [
        ...parent::share($request),
        'cart' => session('cart', []),
        'errors' => Session::get('errors') ? Session::get('errors')->getBag('default')->toArray() : [],
        'auth' => [
            'user' => fn () => Auth::check() ? Auth::user()->only('id', 'name', 'email') : null,
        ],
    ];
}


}
