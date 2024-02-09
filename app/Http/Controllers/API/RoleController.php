<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
     //...
    /**
     * @OA\Get(
     * path="/api/roles",
     * tags={"Roles"},
     * summary="Mostrar Roles",
     * @OA\Response(
     * response=200,
     * description="Mostrar todos los roles."
     * ),
     * @OA\Response(
     * response="default",
     * description="Ha ocurrido un error."
     * )
     * )
     */
    public function index()
{
    $paginationCount = 50; // Puedes ajustar este valor según tus necesidades.

    $roles = Role::orderBy('id', 'asc')->paginate($paginationCount);

    return response()->json([
        'roles' => $roles->items(),
        'total' => $roles->total(),
        'per_page' => $paginationCount, // Estableces el número de elementos por página.
        'current_page' => $roles->currentPage(),
        'last_page' => $roles->lastPage(),
    ])->setStatusCode(Response::HTTP_OK);
}

 //...
    /**
    * @OA\Post(
    * path="/api/roles",
    * tags={"Roles"},
    * summary="Create a Rol",
    * @OA\Parameter(
    * name="name",
    * in="query",
    * description="The title of the departments",
    * required=true,
    * @OA\Schema(
    * type="string"
    * )
    * ),
    * @OA\Response(
    * response=202,
    * description="Accepted",
    * @OA\JsonContent(
    * type="string"
    * ),
    * ),
    * @OA\Response(
    * response=500,
    * description="Los campos no son validos"
    * ),
    * security={
    * {"bearerAuth": {}}
    * }

    * )
    */
    public function store(Request $request)
    {
        //
        try {
            $request->validate([
                'name' => 'required|string'
            ]);
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            return response()->json([$request->name ], Response::HTTP_ACCEPTED);
        } catch (\Exception  $e) {
            return response()->json(['error' => 'Los campos no son validos', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

        //...
    /**
     * @OA\Get(
     * path="/api/roles/{id}",
     * tags={"Roles"},
     * summary="Mostrar un rol concreto",
     * @OA\Parameter(
     * name="id",
     * description="Project id",
     * required=true,
     * in="path",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Mostrar el rol especificado."
     * ),
     * @OA\Response(
     * response="default",
     * description="Ha ocurrido un error."
     * )
     * )
     */
    public function show(Role $role)
    {
        //
        return response()->json($role);
    }
 //...
    /**
    * @OA\Put(
    *   path="/api/roles/{id}",
    * tags={"Roles"},
    *   summary="Update a Roles",
    * * @OA\Parameter(
     * name="id",
     * description="Project id",
     * required=true,
     * in="path",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
       *@OA\Parameter(
    * name="name",
    * in="query",
    * description="The title of the role",
    * required=true,
    * @OA\Schema(
    * type="string"
    * )
    * ),
        * @OA\Response(
        * response=202,
        * description="Accepted",
        * @OA\JsonContent(
        * type="string"
        * ),
        * ),
        * @OA\Response(
        * response=500,
        * description="Error al procesa la solicitud"
        * ),
        * security={
        * {"bearerAuth": {}}
        * }

    * )
    */
    public function update(Request $request, Role $role)
    {
        //
        try {
            $request->validate([
                'name' => 'required|string'
            ]);
            $role->name = $request->name;
            $role->save();
            return response()->json([$request->name ], Response::HTTP_ACCEPTED);
        } catch (\Exception  $e) {
            return response()->json(['error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

      //...
    /**
     * @OA\Delete(
     * path="/api/roles/{id}",
     * tags={"Roles"},
     * summary="Eliminar un roles concreto",
     * @OA\Parameter(
     * name="id",
     * description="Project id",
     * required=true,
     * in="path",
     * @OA\Schema(
     * type="integer"
     * )
     * ),
     * @OA\Response(
     * response=202,
     * description="Aceppted."
     * ),
     * @OA\Response(
     * response="204",
     * description="No content"
     * ),
     * security={
     * {"bearerAuth": {}}
     * }
     * )
     */
    public function destroy(Role $role)
    {
        //
        try {
            $role->delete();
            return response()->setStatusCode(Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }
}
