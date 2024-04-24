<?php

namespace App\Http\Controllers;

use App\Repositories\ChallengeRepository;
use App\Models\Challenge;
use App\Http\Requests\Challenges\CreateChallengeRequest;
use App\Http\Requests\Challenges\UpdateChallengeRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class ChallengeController extends Controller
{
    /**
     * @var ChallengeRepository $challengeRepository
     */
    private ChallengeRepository $challengeRepository;

    /**
     * ChallengeController constructor.
     * @param ChallengeRepository $challengeRepository
     */
    public function __construct(ChallengeRepository $challengeRepository)
    {
        $this->challengeRepository = $challengeRepository;
    }
    /**
     * index function
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return $this->challengeRepository->index();
    }

    /**
     * Create model
     *
     * @param CreateChallengeRequest $request
     * @return Challenge
     */
    public function create(CreateChallengeRequest $request): Challenge
    {
        return $this->challengeRepository->create($request->get('user_id'), $request->except(['user_id', 'programs']), $request->get('programs'));
    }

    /**
     * read function
     *
     * @param string $id
     * @return Challenge
     */
    public function read(string $id): Challenge
    {
        return $this->challengeRepository->read($id);
    }

    /**
     * update function
     *
     * @param CreateChallengeRequest $request
     * @param string $id
     * @return Challenge
     */
    public function update(UpdateChallengeRequest $request, string $id): Challenge
    {
        return $this->challengeRepository->update($id, $request->except(['user_id', 'programs']), $request->get('user_id'), $request->get('programs'));
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
            'success' => (bool) $this->challengeRepository->delete($id),
        ]);
    }
}