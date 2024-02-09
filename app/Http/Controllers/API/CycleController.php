<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        //...
    /**
     * @OA\Get(
     * path="/api/cycles",
     * tags={"Ciclos"},
     * summary="Mostrar ciclos",
     * @OA\Response(
     * response=200,
     * description="Mostrar todos los ciclos."
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
    
        $cycles = Cycle::orderBy('id', 'asc')->paginate($paginationCount);
        
        return response()->json([
            'cycles' => $cycles->items(),
            'total' => $cycles->total(),
            'per_page' => $paginationCount, // Estableces el número de elementos por página.
            'current_page' => $cycles->currentPage(),
            'last_page' => $cycles->lastPage(),
        ])->setStatusCode(Response::HTTP_OK);
    }
    

       //...
    /**
    * @OA\Post(
    * path="/api/cycles",
    * tags={"Ciclos"},
    * summary="Create a cicle",
    * @OA\Parameter(
    * name="name",
    * in="query",
    * description="The title of the departments",
    * required=true,
    * @OA\Schema(
    * type="string"
    * )
    * ),
    * @OA\Parameter(
    * name="department_id",
    * in="query",
    * description="The title of the cicle",
    * required=true,
    * @OA\Schema(
    * type="integer"
    * )
    * ),
    * @OA\Response(
    * response=202,
    * description="Acepted",
    * @OA\JsonContent(
    * type="string"
    * ),
    * ),
    * @OA\Response(
    * response=401,
    * description="Unauthenticated"
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
                'name' => 'required|string',
                'department_id' => 'required|integer'
            ]);
            $cycle = new Cycle();

            $cycle->name = $request->name;
            $cycle->department_id = $request->department_id;
            $cycle->save();
            return response()->json([
                'name' => $request->name,
                'department_id' => $request->department_id
            ], Response::HTTP_ACCEPTED);
        } catch (\Exception  $e) {
            return response()->json(['error' => 'Los campos no son validos', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
     //...
    /**
     * @OA\Get(
     * path="/api/cycles/{id}",
     * tags={"Ciclos"},
     * summary="Mostrar un ciclo concreto",
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
     * description="Mostrar el ciclo especificado."
     * ),
     * @OA\Response(
     * response="default",
     * description="Ha ocurrido un error."
     * )
     * )
     */
    public function show(Cycle $cycle)
    {
        //
        return  response()->json($cycle);
    }

   
    //...
    /**
    * @OA\Put(
    *   path="/api/cycles/{id}",
    * tags={"Ciclos"},
    *   summary="Update a cycle",
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
    * description="The title of the cycle",
    * required=true,
    * @OA\Schema(
    * type="string"
    * )
    * ),
      *@OA\Parameter(
    * name="department_id",
    * in="query",
    * description="Department id ",
    * required=true,
    * @OA\Schema(
    * type="integer"
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
        * response=401,
        * description="Unauthenticated"
        * ),
        * security={
        * {"bearerAuth": {}}
        * }

    * )
    */
    public function update(Request $request, Cycle $cycle)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'department_id' => 'required|integer'
            ]);

            if (!$cycle) {
                return response()->json(['error' => 'Recurso no encontrado'], Response::HTTP_NOT_FOUND);
            }

            $cycle->name = $request->name;
            $cycle->department_id = $request->department_id;
            $cycle->save();

            return response()->json([
                'name' => $request->name,
                'department_id' => $request->department_id
            ], Response::HTTP_ACCEPTED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


   
    //...
    /**
     * @OA\Delete(
     * path="/api/cycles/{id}",
     * tags={"Ciclos"},
     * summary="Eliminar un ciclo concreto",
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
     * description="Eliminado."
     * ),
     * @OA\Response(
     * response="204",
     * description="Ha ocurrido un error."
     * ),
     * security={
     * {"bearerAuth": {}}
     * }
     * )
     */
    public function destroy(Cycle $cycle)
    {
        //
        try {
            $cycle->delete();
            return response()->json([
                'Deleted'
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception  $e) {
            return response()->json([
                'error' => 'Error al procesar la solicitud', 'message' => $e->getMessage()
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
