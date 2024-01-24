<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponse;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function me()
    {
        $user = Auth::user();
        return response()->json([
            "user"=>$user,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('login', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->errorResponse('Unauthorized', [], 403);
        }

        $user = Auth::user();

        return $this->successResponse([
            'user' => $user,
            'token' => $token,
        ], 'User successfully logged in');
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function getpermissions() {
        try {
            $user = auth()->user();

            $categories = [];
            
            foreach ($user->charge->appRouteCategories as $category) {
                $categoryData = $category->toArray();
                $categoryData['routes'] = $category->routes->toArray();
                $categories[$category->id] = $categoryData;
            }
            
            foreach ($user->charge->appRoutes as $route) {
                // Asegúrate de que $route->route_categorie sea un objeto, no un array
                $category = (object) $route->route_categorie;
            
                $categoryId = $category->id;
            
                if (array_key_exists($categoryId, $categories)) {
                    $categories[$categoryId]['routes'][] = $route->toArray();
                } else {
                    $categories[$categoryId] = [
                        'id' => $category->id,
                        'icon' => $category->icon,
                        'label' => $category->label,
                        'route' => $category->route,
                        'separator' => $category->separator,
                        'routes' => [$route->toArray()],
                    ];
                }
            }

            $routes = collect($categories)->sortBy('id')->values()->map(function($categorie) {
                $category['id'] = $categorie['id'];
                $category['icon'] = $categorie['icon'];
                $category['label'] = $categorie['label'];
                $category['route'] = $categorie['route'];
                $category['separator'] = $categorie['separator'];
                $category['routes'] = collect($categorie['routes'])->sortBy('id')->unique('id')->values()->map(function($route) {
                    $newRoute['id'] = $route['id'];
                    $newRoute['label'] = $route['label'];
                    $newRoute['route'] = $route['route'];
                    return $newRoute;
                });
                return $category;
            });
            return $this->successResponse(['routes' =>$routes, 'permissions' => []], 'The record was showed success');
        } catch (\Throwable $th) {
            return $this->errorResponse('The record could not be showed', $th->getMessage(), 422);
        }
    }
}
