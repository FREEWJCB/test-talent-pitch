<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Support\Facades\Log;

class CompanyRepository {
     /**
     * @var Company $company
     */
    private $company;

    /**
     * @var UserRepository $userRepository
     */
    private $userRepository;

    /**
     * CompanyRepository constructor.
     * @param Company $company
     * @param UserRepository $userRepository
     */
    public function __construct(Company $company, UserRepository $userRepository)
    {
        $this->company = $company;
        $this->userRepository = $userRepository;
    }
    /**
     * index function
     * List paginate
     * @return LengthAwarePaginator
     */
    public function index(): LengthAwarePaginator
    {
        //paginated list of companies
        return $this->company->newQuery()->with(['user'])->paginate(env('PAGINATE_LIMIT', 10));
    }

    /**
     * create function
     *
     * @param int $user
     * @param array $attributes
     * @param array|null $programs
     * @return Company
     */
    public function create(int $user, array $attributes, array $programs = null): Company
    {
        try {
            /**
             * @var Company $company
             * Create company
             */
                $company = new Company($attributes);
                /**
             * @var User $user
             * find user
             */
                $user = $user instanceof User ? $user : $this->userRepository->read($user);
                //user is associated
                $company->user()->associate($user);
                //changes are saved
                $company->save();
                if($programs && count($programs) > 0){
                //programs are synchronized
                    $company->programParticipants()->syncWithoutDetaching($programs);
                }
                //refresh model
                return $company->refresh();
        } catch (Exception $e) {
            Log::error($e->getMessage(), array('e' => $e));
            throw $e;
        }
    }

    /**
     * Find model
     *
     * @param string $id
     * @return Company
     */
    public function read(string $id): Company
    {
        //search for the model by querying its id
        return $this->company->newQuery()->with(['user'])->findOrFail($id);
    }

    /**
     * update function
     *
     * @param  string  $id
     * @param  array  $attributes
     * @param  int|null  $user
     * @param  array|null  $programs
     * @return Company
     */
    public function update(string $id, array $attributes, int $user = null, array $programs = null): Company
    {

        try {
            /**
             * @var Company $company
             * search for the model by querying its id
             */
            $company = $this->read($id);
            if($user){
                //user is associated
                $company->user()->associate($user);
            }
            if($programs && count($programs) > 0){
                //programs are synchronized
                $company->programParticipants()->syncWithoutDetaching($programs);
            }
            //update model data
            $company->update($attributes);
            //refresh model
            return $company->refresh();
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
         * @var Company $company
         * search for the model by querying its id
         */
        $company = $this->read($id);
        //delete company
        return $company->delete();
    }
}