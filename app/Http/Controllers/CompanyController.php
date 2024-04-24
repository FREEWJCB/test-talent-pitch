<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use App\Models\Company;
use App\Http\Requests\Companies\CreateCompanyRequest;
use App\Http\Requests\Companies\UpdateCompanyRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository $companyRepository
     */
    private CompanyRepository $companyRepository;

    /**
     * CompanyController constructor.
     * @param CompanyRepository $companyRepository
     */
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    /**
     * index function
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return $this->companyRepository->index();
    }

    /**
     * create function
     *
     * @param CreateCompanyRequest $request
     * @return Company
     */
    public function create(CreateCompanyRequest $request): Company
    {
        return $this->companyRepository->create($request->get('user_id'), $request->except(['user_id', 'programs']), $request->get('programs'));
    }

    /**
     * read function
     *
     * @param string $id
     * @return Company
     */
    public function read(string $id): Company
    {
        return $this->companyRepository->read($id);
    }

    /**
     * update function
     *
     * @param CreateCompanyRequest $request
     * @param string $id
     * @return Company
     */
    public function update(UpdateCompanyRequest $request, string $id): Company
    {
        return $this->companyRepository->update($id, $request->except(['user_id', 'programs']), $request->get('user_id'), $request->get('programs'));
    }

    /**
     * delete function
     *
     * @param string $id
     * @return JsonResponse
     */
    public function delete(string $id): JsonResponse
    {
        return response()->json([
            'success' => (bool) $this->companyRepository->delete($id),
        ]);
    }
}
