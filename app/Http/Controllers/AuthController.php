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
            $routes = array_merge([
                [
                    "icon" => 'home',
                    "label" => 'Inicio',
                    "route" => 'admin',
                    "separator" => 1,
                ],
                [
                    "icon" => "settings",
                    "label" => "Configuración",
                    "separator" => 1,
                    "routes" => [
                        [
                            "label" => 'Personas',
                            "route" => 'personas',
                        ],
                        [
                            "label" => 'Usuarios',
                            "route" => 'usuarios',
                        ],
                        [
                            "label" => 'Expendios',
                            "route" => 'expendios',
                        ],
                        [
                            "label" => 'Guías',
                            "route" => 'guias',
                        ],
                        [
                            "label" => 'Rutas',
                            "route" => 'rutas',
                        ],
                        [
                            "label" => 'Vehiculos',
                            "route" => 'vehiculos',
                        ],
                        [
                            "label" => 'Firmas',
                            "route" => 'firmas',
                        ],
                    ]
                ],
                [
                    "icon" => "fact_check",
                    "label" => "Recepción",
                    "separator" => 1,
                    "routes" => [
                        [
                            "label" => 'Planilla Ingreso',
                            "route" => 'planillaingreso',
                        ],
                        [
                            "label" => 'Planilla Diaria',
                            "route" => 'planilladiaria',
                        ],
                        [
                            "label" => 'Sacrificios Pendientes',
                            "route" => 'sacrificiospendientes',
                        ],
                    ]
                ],
                [
                    "icon" => "history",
                    "label" => "Ante-Mortem",
                    "separator" => 1,
                    "routes" => [
                        [
                            "label" => 'Inspección Antemortem',
                            "route" => 'inspeccionantemortem',
                        ],
                        [
                            "label" => 'Hallazgos / Antemortem',
                            "route" => 'inspeccionantemortemsospechosos',
                        ],
                        [
                            "label" => 'Registro Hembras Paridas',
                            "route" => 'registrohembrasparidas',
                        ],
                        [
                            "label" => 'Animales Sospechosos',
                            "route" => 'animalessospechosos',
                        ],
                        [
                            "label" => 'Ingreso Bobinos Emergencia',
                            "route" => 'ingresobobinosemergencia',
                        ],
                    ]
                ],
                [
                    "icon" => "feed",
                    "label" => "Verificación Post-Mortem",
                    "separator" => 1,
                    "routes" => [
                        [
                            "label" => 'Ruta Diaria',
                            "route" => 'rutadiaria',
                        ],
                        [
                            "label" => 'Planilla Orden Beneficio',
                            "route" => 'planillaordenbeneficio',
                        ],
                        [
                            "label" => 'Inspección Post Mortem',
                            "route" => 'inspeccionpostmortem',
                        ],
                        [
                            "label" => 'Tolerancia Cero Visceras',
                            "route" => 'toleranciacerovisceras',
                        ],
                        [
                            "label" => 'Inspección Cero Tolerancia',
                            "route" => 'inspeccioncerotolerancia',
                        ],
                        [
                            "label" => 'Acondicionamiento De La Canal',
                            "route" => 'acondicionamientodelacanal',
                        ],
                        [
                            "label" => 'Despacho Visceras',
                            "route" => 'despachovisceras',
                        ],
                        [
                            "label" => 'Comparación Decomisos',
                            "route" => 'comparaciondecomisos',
                        ],
                    ]
                ],
                [
                    "icon" => "local_shipping",
                    "label" => "Despacho",
                    "separator" => 1,
                    "routes" => [
                        [
                            "label" => 'Guía de despacho',
                            "route" => 'guiadespacho',
                        ],
                    ]
                ],
                [
                    "icon" => "fact_check",
                    "label" => "Reportes",
                    "route" => "reportes",
                    "separator" => 1
                ]
            ], []);
            

            return $this->successResponse(['routes' =>$routes, 'permissions' => []], 'The record was showed success');
        } catch (\Throwable $th) {
            return $this->errorResponse('The record could not be showed', $th->getMessage(), 422);
        }
    }
}
