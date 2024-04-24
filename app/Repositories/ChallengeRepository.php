<?php

namespace App\Repositories;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\Log;

class ChallengeRepository {
     /**
     * @var Challenge $challenge
     */
    private $challenge;

    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    /**
     * ChallengeRepository constructor.
     * @param Challenge $challenge
     * @param UserRepository $userRepository
     */
    public function __construct(Challenge $challenge, UserRepository $userRepository)
    {
        $this->challenge = $challenge;
        $this->userRepository = $userRepository;
    }
    /**
     * index function
     * List paginate
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        //paginated list of programs
        return $this->challenge->newQuery()->with(['user'])->paginate(env('PAGINATE_LIMIT', 10));
    }

    /**
     * create function
     *
     * @param User|int $user
     * @param array $attributes
     * @param array|null $programs
     * @return Challenge
     */
    public function create(User|int $user, array $attributes, array $programs = null): Challenge
    {
        try {
            /**
             * @var Challenge $challenge
             * Create challenge
             */
            $challenge = new Challenge($attributes);
            /**
             * @var User $user
             * find user
             */
            $user = $user instanceof User ? $user : $this->userRepository->read($user);
            //user is associated
            $challenge->user()->associate($user);
            //changes are saved
            $challenge->save();
            if($programs && count($programs) > 0){
                //programs are synchronized
                $challenge->programParticipants()->syncWithoutDetaching($programs);
            }
            //refresh model
            return $challenge->refresh();
        } catch (Exception $e) {
            Log::error($e->getMessage(), array('e' => $e));
            throw $e;
        }

    }

    /**
     * read function
     *
     * @param $id
     * @return Challenge
     */
    public function read(string $id): Challenge
    {
        //search for the model by querying its id
        return $this->challenge->newQuery()->with(['user'])->findOrFail($id);
    }

    /**
     * update function
     *
     * @param  string  $id
     * @param  array  $attributes
     * @param  int|null  $user
     * @param  array|null  $programs
     * @return Challenge
     */
    public function update(string $id, array $attributes, int $user = null, array $programs = null): Challenge
    {

        try {
            /**
             * @var Challenge $challenge
             * search for the model by querying its id
             */
            $challenge = $this->read($id);
            if($user){
                //user is associated
                $challenge->user()->associate($user);
            }
            if($programs && count($programs) > 0){
                //programs are synchronized
                $challenge->programParticipants()->syncWithoutDetaching($programs);
            }
            //update model data
            $challenge->update($attributes);
            //refresh model
            return $challenge->refresh();
        } catch (Exception $e) {
            Log::error($e->getMessage(), array('e' => $e));
            throw $e;
        }
    }

    /**
     * delete function
     *
     * @param string $id
     * @return bool|null
     */
    public function delete(string $id): bool|null
    {
        /**
         * @var Challenge $challenge
         * search for the model by querying its id
         */
        $challenge = $this->read($id);
        //delete challenge
        return $challenge->delete();
    }
}