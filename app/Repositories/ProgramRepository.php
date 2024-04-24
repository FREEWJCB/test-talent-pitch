<?php

namespace App\Repositories;

use App\Enums\ProgramEntityType;
use App\Models\Program;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\Log;

class ProgramRepository {
     /**
     * @var Program $program
     */
    private $program;
     /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    /**
     * ProgramRepository constructor.
     * @param Program $program
     * @param UserRepository $userRepository
     */
    public function __construct(Program $program, UserRepository $userRepository)
    {
        $this->program = $program;
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
        return $this->program->newQuery()->with(['user'])->paginate(env('PAGINATE_LIMIT', 10));
    }

    /**
     * create function
     *
     * @param int $user
     * @param array $attributes
     * @param array|null $entities
     * @return Program
     */
    public function create(int $user, array $attributes, array $entities = null): Program
    {

        try {
            /**
             * @var Program $program
             * Create program
             */
            $program = new Program($attributes);
            /**
             * @var User $user
             * find user
             */
            $user = $user instanceof User ? $user : $this->userRepository->read($user);
            //user is associated
            $program->user()->associate($user);
            //changes are saved
            $program->save();
            if($entities && count($entities) > 0) {
                //synchronize entities to program participants
                $this->syncEntities($program, $entities);
            }
            //changes are saved
            $program->save();
            //refresh model
            return $program->refresh();
        } catch (Exception $e) {
            Log::error($e->getMessage(), array('e' => $e));
            throw $e;
        }
    }

    /**
     * read function
     *
     * @param string $id
     * @return Program
     */
    public function read(string $id): Program
    {
        //search for the model by querying its id
        return $this->program->newQuery()->with(['user'])->findOrFail($id);
    }

    /**
     * update function
     *
     * @param  string  $id
     * @param  array  $attributes
     * @param  int|null  $user
     * @param  array|null  $entities
     * @return Program
     */
    public function update(string $id, array $attributes, int $user = null, array $entities = null): Program
    {

        try {
            /**
             * @var Program $program
             * search for the model by querying its id
             */
            $program = $this->read($id);
            if($user){
                //user is associated
                $program->user()->associate($user);
            }
            if($entities && count($entities) > 0) {
                //synchronize entities to program participants
                $this->syncEntities($program, $entities);
            }
            //update model data
            $program->update($attributes);
            //refresh model
            return $program->refresh();
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
         * @var Program $program
         * search for the model by querying its id
         */
        $program = $this->read($id);
        //delete program
        return $program->delete();
    }

    /**
     * syncEntities function
     * synchronize entities to program participants
     * @param Program $program
     * @param array $entities
     * @return void
     */
    public function syncEntities(Program $program, array $entities)
    {
        $userIds = [];
        $challengeIds = [];
        $companyIds = [];
        // users
        //filter the users
        $users = array_filter($entities, function($k) {
            return $k['type'] === ProgramEntityType::USERS;
        });
        if(count($users) > 0) {
            foreach ($users as $user) {
                // push ids
                array_push($userIds, $user['id']);
            }
            if(count($userIds) > 0) {
                //users are synchronized
                $program->users()->sync($userIds);
            }
        }
        //challenges
        //filter the challenges
        $challenges = array_filter($entities, function($k) {
            return $k['type'] === ProgramEntityType::CHALLENGES;
        });
        if(count($challenges) > 0) {
            foreach ($challenges as $challenge) {
                // push ids
                array_push($challengeIds, $challenge['id']);
            }
            if(count($challengeIds) > 0) {
                //challenges are synchronized
                $program->challenges()->sync($challengeIds);
            }
        }
        //companies
        //filter the companies
        $companies = array_filter($entities, function($k) {
            return $k['type'] === ProgramEntityType::COMPANIES;
        });
        if(count($companies) > 0) {
            foreach ($companies as $company) {
                // push ids
                array_push($companyIds, $company['id']);
            }
            if(count($companyIds) > 0) {
                //companies are synchronized
                $program->companies()->sync($companyIds);
            }
        }
    }
}
