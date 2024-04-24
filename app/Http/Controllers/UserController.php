<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Models\User;
use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @var UserRepository $userRepository
     */
    private UserRepository $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * index function
     *
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        return $this->userRepository->index();
    }

    /**
     * create function
     *
     * @param CreateUserRequest $request
     * @return User
     */
    public function create(CreateUserRequest $request): User
    {
        return $this->userRepository->create($request->except(['programs']), $request->get('programs'));
    }

    /**
     * read function
     *
     * @param string $id
     * @return User
     */
    public function read(string $id): User
    {
        return $this->userRepository->read($id);
    }

    /**
     * update function
     *
     * @param UpdateUserRequest $request
     * @param string $id
     * @return User
     */
    public function update(UpdateUserRequest $request, string $id): User
    {
        return $this->userRepository->update($id, $request->except(['programs']), $request->get('programs'));
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
            'success' => (bool) $this->userRepository->delete($id),
        ]);
    }
}