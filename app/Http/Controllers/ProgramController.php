<?php

namespace App\Http\Controllers;

use App\Repositories\ProgramRepository;
use App\Models\Program;
use App\Http\Requests\Programs\CreateProgramRequest;
use App\Http\Requests\Programs\UpdateProgramRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class ProgramController extends Controller
{
    /**
     * @var ProgramRepository $programRepository
     */
    private ProgramRepository $programRepository;

    /**
     * ProgramController constructor.
     * @param ProgramRepository $programRepository
     */
    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;
    }
    /**
     * index function
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return $this->programRepository->index();
    }

    /**
     * create function
     *
     * @param CreateProgramRequest $request
     * @return Program
     */
    public function create(CreateProgramRequest $request): Program
    {
        return $this->programRepository->create($request->get('user_id'), $request->except(['user_id', 'entities']), $request->get('entities'));
    }

    /**
     * read function
     *
     * @param string $id
     * @return Program
     */
    public function read(string $id): Program
    {
        return $this->programRepository->read($id);
    }

    /**
     * update function
     *
     * @param UpdateProgramRequest $request
     * @param string $id
     * @return Program
     */
    public function update(UpdateProgramRequest $request, string $id): Program
    {
        return $this->programRepository->update($id, $request->except(['user_id', 'entities']), $request->get('user_id'), $request->get('entities'));
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
            'success' => (bool) $this->programRepository->delete($id),
        ]);
    }
}