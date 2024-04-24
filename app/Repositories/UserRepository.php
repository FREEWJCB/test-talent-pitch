<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class UserRepository {
     /**
     * @var User $user
     */
    private $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     *  index function
     *  List paginate
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        //paginated list of users
        return $this->user->paginate(env('PAGINATE_LIMIT', 10));
    }

    /**
     * create function
     *
     * @param array $attributes
     * @param array|null $programs
     * @return User
     */
    public function create(array $attributes, array $programs = null): User
    {
        try {
            /**
             * @var User $user
             * Create user
             */
            $user = $this->user->firstOrCreate($attributes);
            if($programs && count($programs) > 0){
                //programs are synchronized
                $user->programParticipants()->syncWithoutDetaching($programs);
            }
                //changes are saved
            $user->save();
            //refresh model
            return $user->refresh();
        } catch (Exception $e) {
            Log::error($e->getMessage(), array('e' => $e));
            throw $e;
        }
    }

    /**
     * read function
     *
     * @param string $id
     * @return User
     */
    public function read(string $id): User
    {
        //search for the model by querying its id
        return $this->user->findOrFail($id);
    }

    /**
     * Update model
     *
     * @param  string  $id
     * @param  array  $attributes
     * @param  array|null  $programs
     * @return User
     */
    public function update(string $id, array $attributes, array $programs = null): User
    {
        try {
            /**
             * @var User $user
             * search for the model by querying its id
             */
            $user = $this->read($id);
            if($programs && count($programs) > 0){
                    //programs are synchronized
                $user->programParticipants()->syncWithoutDetaching($programs);
            }
            //update model data
            $user->update($attributes);
            //refresh model
            return $user->refresh();
        } catch (Exception $e) {
            Log::error($e->getMessage(), array('e' => $e));
            throw $e;
        }
    }

    /**
     * Delete model
     *
     * @param string $id
     * @return bool|null
     */
    public function delete(string $id): bool|null
    {
        /**
         * @var User $user
         * search for the model by querying its id
         */
        $user = $this->read($id);
        //delete user
        return $user->delete();
    }
}