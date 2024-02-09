<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //...
    /**
     * @OA\Get(
     * path="/api/modules",
     * tags={"Modulos"},
     * summary="Mostrar modulos",
     * @OA\Response(
     * response=200,
     * description="Mostrar todos los modulos."
     * ),
     * @OA\Response(
     * response="default",
     * description="Ha ocurrido un error."
     * )
     * )
     * */
    public function index()
    {
        $paginationCount = 50; // Puedes ajustar este valor según tus necesidades.

        $modules = Module::orderBy('id', 'asc')->paginate($paginationCount);

        return response()->json([
            'modules' => $modules->items(),
            'total' => $modules->total(),
            'per_page' => $paginationCount, // Estableces el número de elementos por página.
            'current_page' => $modules->currentPage(),
            'last_page' => $modules->lastPage(),
        ])->setStatusCode(Response::HTTP_OK);
    }


    //...
    /**
    * @OA\Post(
    * path="/api/modules",
    * tags={"Modulos"},
    * summary="Create a module",
    * @OA\Parameter(
    * name="name",
    * in="query",
    * description="The title of the module",
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
    * response=406,
    * description="Los campos no son validos"
    * ),
    * security={
    * {"bearerAuth": {}}
    * }

    * )
    */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string'
            ]);
            $module = new Module();
            $module->name = $request->name;
            $module->save();
            return response()->json([
                'name' => $request->name
            ], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Los campos no son validos', 'message' => $e->getMessage()], Response::HTTP_NOT_ACCEPTABLE);
        }
    }

     //...
    /**
     * @OA\Get(
     * path="/api/modules/{id}",
     * tags={"Modulos"},
     * summary="Mostrar un modulo concreto",
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
     * description="Mostrar el modulo especificado."
     * ),
     * @OA\Response(
     * response="default",
     * description="Error al procesar la solicitud"
     * )
     * )
     */
    public function show(Module $module)
    {
        return response()->json($module);
    }

  
    //...
    /**
    * @OA\Put(
    *   path="/api/modules/{id}",
    * tags={"Modulos"},
    *   summary="Update a modules",
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
    * description="The title of the modules",
    * required=true,
    * @OA\Schema(
    * type="string"
    * )
    * ),
        * @OA\Response(
        * response=202,
        * description="successful operation",
        * @OA\JsonContent(
        * type="string"
        * ),
        * ),
        * @OA\Response(
        * response=500,
        * description="Error al procesar la solicitud', 'message"
        * ),
        * security={
        * {"bearerAuth": {}}
        * }

    * )
    */
    public function update(Request $request, Module $module)
    {
        try {
            $request->validate([
                'name' => 'required|string'
            ]);
            $module->name = $request->name;
            $module->save();
            return response()->json([
                'name' => $request->name
            ], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

   //...
    /**
     * @OA\Delete(
     * path="/api/modules/{id}",
     * tags={"Modulos"},
     * summary="Eliminar un modulo concreto",
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
     * description="Aceptado."
     * ),
     * @OA\Response(
     * response="204",
     * description="No"
     * ),
     * security={
     * {"bearerAuth": {}}
     * }
     * )
     */
    public function destroy(Module $module)
    {
        try {
            $module->delete();
            return response()->json([
                'Se eliminó con exito'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }
}
