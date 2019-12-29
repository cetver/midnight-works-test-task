<?php

use Api\V1\Entities\ApiUserEntity;
use Api\V1\Repositories\ApiUserRepository;
use Illuminate\Database\Migrations\Migration;

class InsertUsersTable extends Migration
{
    /**
     * @var ApiUserRepository
     */
    private $apiUserRepository;

    public function __construct()
    {
        $this->apiUserRepository = app(ApiUserRepository::class);
    }

    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        $apiUser = new ApiUserEntity([
            'login' => 'admin',
            'password' => 'admin',
        ]);
        $apiUser->saveOrFail();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->apiUserRepository->findByLogin('admin')->delete();
    }
}
