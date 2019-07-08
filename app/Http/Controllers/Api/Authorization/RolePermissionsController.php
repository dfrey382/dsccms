<?php

namespace Dsc\Http\Controllers\Api\Authorization;

use Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Dsc\Events\Role\PermissionsUpdated;
use Dsc\Http\Controllers\Api\ApiController;
use Dsc\Http\Requests\Role\CreateRoleRequest;
use Dsc\Http\Requests\Role\RemoveRoleRequest;
use Dsc\Http\Requests\Role\UpdateRolePermissionsRequest;
use Dsc\Http\Requests\Role\UpdateRoleRequest;
use Dsc\Repositories\Role\RoleRepository;
use Dsc\Repositories\User\UserRepository;
use Dsc\Role;
use Dsc\Transformers\PermissionTransformer;
use Dsc\Transformers\RoleTransformer;

/**
 * Class RolePermissionsController
 * @package Dsc\Http\Controllers\Api
 */
class RolePermissionsController extends ApiController
{
    /**
     * @var RoleRepository
     */
    private $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
        $this->middleware('auth');
        $this->middleware('permission:permissions.manage');
    }

    public function show(Role $role)
    {
        return $this->respondWithCollection(
            $role->cachedPermissions(),
            new PermissionTransformer
        );
    }

    /**
     * Update specified role.
     * @param Role $role
     * @param UpdateRolePermissionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role, UpdateRolePermissionsRequest $request)
    {
        $this->roles->updatePermissions(
            $role->id,
            $request->permissions
        );

        event(new PermissionsUpdated);

        return $this->respondWithCollection(
            $role->cachedPermissions(),
            new PermissionTransformer
        );
    }
}
