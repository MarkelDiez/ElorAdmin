<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;

/**
 * @OA\Info(title="API", version="1.0"),
 * @OA\SecurityScheme(
 * in="header",
 * scheme="bearer",
 * bearerFormat="JWT",
 * securityScheme="bearerAuth",
 * type="http",
 * ),
 */
class AuthController extends Controller
{
    
    /**
 * Actualiza los detalles del usuario.
 *
 * @OA\Put(
 *     path="/api/users/{user}",
 *     operationId="updateUser",
 *     tags={"Users"},
 *     summary="Actualiza los detalles del usuario",
 *     description="Actualiza los detalles del usuario identificado por su ID.",
 *     security={ {"bearerAuth": {} } },
 *     @OA\Parameter(
 *         name="user",
 *         in="path",
 *         description="ID del usuario a actualizar",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="surname", type="string"),
 *             @OA\Property(property="email", type="string", format="email"),
 *             @OA\Property(property="password", type="string", minLength=8),
 *             @OA\Property(property="address", type="string"),
 *             @OA\Property(property="phone", type="integer"),
 *             @OA\Property(property="dni", type="string"),
 *             @OA\Property(property="curso", type="integer"),
 *             @OA\Property(property="department_id", type="integer"),
 *             @OA\Property(property="cycle_id", type="integer")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=202,
 *         description="Usuario actualizado exitosamente",
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="surname", type="string"),
 *             @OA\Property(property="email", type="string", format="email"),
 *             @OA\Property(property="password", type="string"),
 *             @OA\Property(property="address", type="string"),
 *             @OA\Property(property="phone", type="integer"),
 *             @OA\Property(property="dni", type="string"),
 *             @OA\Property(property="curso", type="integer"),
 *             @OA\Property(property="department_id", type="integer"),
 *             @OA\Property(property="cycle_id", type="integer")
 *         )
 *     ),
 *     @OA\Response(response=400, description="Solicitud incorrecta"),
 *     @OA\Response(response=404, description="Recurso no encontrado"),
 *     @OA\Response(response=422, description="Entidad no procesable"),
 *     @OA\Response(response=500, description="Error interno del servidor"),
 * )
 */
    public function update(Request $request, User $user)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'address' => 'required|string|max:255',
                'phone' => 'required|integer',
                'dni' => 'required|string|max:255',
                'curso' => 'integer',
                'department_id' => 'integer',
                'cycle_id' => 'integer'
            ]);

            if (!$user) {
                return response()->json(['error' => 'Recurso no encontrado'], Response::HTTP_NOT_FOUND);
            }

            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->dni = $request->dni;
            $user->curso = $request->curso;
            $user->department_id = $request->department_id;
            $user->cycle_id = $request->cycle_id;
            $user->save();

            return response()->json([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'password' => $request->password,
                'address' => $request->address,
                'phone' => $request->phone,
                'dni' => $request->dni,
                'curso' => $request->curso,
                'department_id' => $request->department_id,
                'cycle_id' => $request->cycle_id

            ], Response::HTTP_ACCEPTED);


        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
   * @OA\Post(
   * path="/api/register",
   * operationId="Register",
   * tags={"Auth"},
   * summary="User Register",
   * description="User Register here",
   *     @OA\RequestBody(
   *         @OA\JsonContent(),
   *         @OA\MediaType(
   *            mediaType="multipart/form-data",
   *            @OA\Schema(
   *               type="object",
   *               required={"name","email", "password", "password_confirmation"},
   *               @OA\Property(property="name", type="text"),
   *               @OA\Property(property="surname", type="text"),
   *               @OA\Property(property="email", type="text"),
   *               @OA\Property(property="password", type="password"),
   *               @OA\Property(property="address", type="text"),
   * *             @OA\Property(property="phone", type="number"),
   * *             @OA\Property(property="dni", type="text"),
   * *             @OA\Property(property="curso", type="text"),
   * *             @OA\Property(property="department_id", type="text"),
   * *             @OA\Property(property="cycle_id", type="text"),

   *            ),
   *        ),
   *    ),
   *      @OA\Response(
   *          response=201,
   *          description="Register Successfully",
   *          @OA\JsonContent()
   *       ),
   *      @OA\Response(
   *          response=200,
   *          description="Register Successfully",
   *          @OA\JsonContent()
   *       ),
   *      @OA\Response(
   *          response=422,
   *          description="Unprocessable Entity",
   *          @OA\JsonContent()
   *       ),
   *      @OA\Response(response=400, description="Bad request"),
   *      @OA\Response(response=404, description="Resource Not Found"),
   * )
   */
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'address' => 'required|string|max:255',
            'phone' => 'required|integer',
            'dni' => 'required|string|max:255',
            'curso' => 'integer',
            'department_id' => 'integer',
            'cycle_id' => 'integer'

        ]);
        $user = User::create([
            'name' => $validatedData['name'],
            'surname' => $validatedData['surname'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'dni' => $validatedData['dni'],
            'curso' => $validatedData['curso'],
            'department_id' => $validatedData['department_id'],
            'cycle_id' => $validatedData['cycle_id'],

        ]);
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
        ])->setStatusCode(Response::HTTP_CREATED);
    }
      /**
     * Realiza el inicio de sesión de un usuario.
     *
     * @OA\Post(
     *     path="/api/login",
     *     operationId="authLogin",
     *     tags={"Auth"},
     *     summary="Inicio de sesión de usuario",
     *     description="Inicia sesión del usuario aquí",
     *     @OA\RequestBody(
     *        
     *         @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *               type="object",
     *               required={"email", "password"},
     *               @OA\Property(property="email", type="email"),
     *               @OA\Property(property="password", type="password")
     *            ),
     *        ),
     *    ),
     *    @OA\Response(
     *        response=201,
     *        description="Inicio de sesión exitoso",
     *        @OA\JsonContent()
     *     ),
     *    @OA\Response(
     *        response=200,
     *        description="Inicio de sesión exitoso",
     *        @OA\JsonContent(
     *            @OA\Property(property="status", type="string", example="success"),
     *            @OA\Property(property="message", type="string", example="Inicio de sesión exitoso"),
     *            @OA\Property(property="name", type="string", example="Nombre del Usuario"),
     *            @OA\Property(property="token", type="string", example="Token generado")
     *        )
     *     ),
     *    @OA\Response(
     *        response=422,
     *        description="Entidad no procesable"
     *     ),
     *    @OA\Response(response=400, description="Solicitud incorrecta"),
     *    @OA\Response(response=404, description="Recurso no encontrado"),
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => ['Username or password incorrect'],
            ])->setStatusCode(Response::HTTP_UNAUTHORIZED);
        }


        // FIXME: queremos dejar más dispositivos?
        // $user->tokens()->delete();
        $token = $user->createToken($request->email)->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'name' => $user->name,
            'token' => $token,
        ])->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully'
        ])->setStatusCode(Response::HTTP_OK);
    }
}
