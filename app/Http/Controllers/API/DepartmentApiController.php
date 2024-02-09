<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentApiController extends Controller
{
       //...
    /**
     * @OA\Get(
     * path="/api/departments",
     * tags={"Departamento"},
     * summary="Mostrar departments",
     * @OA\Response(
     * response=200,
     * description="Mostrar todos los departments."
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

    $departments = Department::orderBy('id', 'asc')->paginate($paginationCount);

    return response()->json([
        'departments' => $departments->items(),
        'total' => $departments->total(),
        'per_page' => $paginationCount, // Estableces el número de elementos por página.
        'current_page' => $departments->currentPage(),
        'last_page' => $departments->lastPage(),
    ])->setStatusCode(Response::HTTP_OK);
}


        //...
    /**
    * @OA\Post(
    * path="/api/departments",
    * tags={"Departamento"},
    * summary="Create a departments",
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
            $department = new Department();
            $department->name = $request->name;
            $department->save();
            return response()->json([
                'name' => $request->name
            ], Response::HTTP_ACCEPTED);

    }


    //...
    /**
     * @OA\Get(
     * path="/api/departments/{id}",
     * tags={"Departamento"},
     * summary="Mostrar un department concreto",
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
     * description="Mostrar el departments especificado."
     * ),
     * @OA\Response(
     * response="default",
     * description="Ha ocurrido un error."
     * )
     * )
     */
    public function show(Department $department)
    {
        //
        return response()->json($department);
    }

      //...
    /**
    * @OA\Put(
    *   path="/api/departments/{id}",
    * tags={"Departamento"},
    *   summary="Update a departments",
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
    * description="The title of the departments",
    * required=true,
    * @OA\Schema(
    * type="string"
    * )
    * ),
        * @OA\Response(
        * response=202,
        * description="Aceptado",
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
    public function update(Request $request, Department $department)
    {
        //

            $department->name = $request->name;
            $department->save();
            return response()->json([
                'name' => $request->name
            ], Response::HTTP_ACCEPTED);

    }

       //...
    /**
     * @OA\Delete(
     * path="/api/departments/{id}",
     * tags={"Departamento"},
     * summary="Eliminar un department concreto",
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
     * description="Eliminado."
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
    public function destroy(Department $department)
    {
        //
        try {
            $department->delete();
            return response()->json([
                'Se eliminó con exito'
            ], Response::HTTP_ACCEPTED);
        } catch (\Throwable $th) {
            return response()->setStatusCode(Response::HTTP_NO_CONTENT);
        }
    }
}
