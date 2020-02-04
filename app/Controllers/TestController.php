<?php

namespace App\Controllers;

use Nur\Http\{Request, Response};

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     * Endpoint: /
     *
     * @return Response|string
     */
    public function main(): Response
    {
        return response()->json([
            'Main Method',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * Endpoint: /create
     *
     * @return Response|string
     */
    public function getCreate(): Response
    {
        return response()->json([
            'Create Method',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * Endpoint: /store
     *
     * @param Request $request
     *
     * @return Response|string
     */
    public function postStore(Request $request): Response
    {
        return response()->json([
            'Store Method',
        ]);
    }

    /**
     * Display the specified resource.
     * Endpoint: /show/:id
     *
     * @param int $id
     *
     * @return Response|string
     */
    public function getShow(int $id): Response
    {
        return response()->json([
            'Show Method',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * Endpoint: /edit/:id
     *
     * @param int $id
     *
     * @return Response|string
     */
    public function getEdit(int $id): Response
    {
        return response()->json([
            'Edit Method',
        ]);
    }

    /**
     * Update the specified resource in storage.
     * Endpoint: /update/:id
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function putUpdate(Request $request, int $id): Response
    {
        return response()->json([
            'Update Method',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * Endpoint: /destroy/:id
     *
     * @param int $id
     *
     * @return Response
     */
    public function deleteDestroy(int $id): Response
    {
        return response()->json([
            'Destroy Method',
        ]);
    }
}
