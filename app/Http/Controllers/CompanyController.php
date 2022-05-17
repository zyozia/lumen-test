<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Get companies by user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(
            auth()->user()->companies()->paginate()
        );
    }

    /**
     * Store new company by user
     *
     * @param CompanyStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(CompanyStoreRequest $request): JsonResponse
    {
        $company = auth()->user()
            ->companies()
            ->create($request->validated());
        return response()->json([
            'data' => $company->fresh()
        ]);
    }

    /**
     * Show one company by user and company id
     *
     * @param int $companyId
     *
     * @return JsonResponse
     */
    public function show(int $companyId): JsonResponse
    {
        return response()->json([
            'data' => auth()->user()->companies()->findOrFail($companyId)
        ]);
    }
}
