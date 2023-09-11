<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Permission\Contracts\Role as RoleContract;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\Traits\HasPermissions;

class Department extends Model implements RoleContract
{
    use HasPermissions;

    const INACTIVE = 0;

    const ACTIVE = 1;

    const ACTIVE_ALL = 2;

    const ACTIVE_ARR = [
        self::ACTIVE_ALL => 'All',
        self::ACTIVE => 'Active',
        self::INACTIVE => 'Deactive',
    ];

    const ROLE = [
        0 => 'All',
        1 => 'Admin',
        2 => 'Doctor',
        3 => 'Patient',
        4 => 'Nurse',
        5 => 'Receptionist',
        6 => 'Pharmacist',
        7 => 'Accountant',
        8 => 'Case Manager',
        9 => 'Lab Technician',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function (self $department) {
            $department->guard_name = 'web';
        });
    }

    public $fillable = [
        'name',
        'guard_name',
        'is_active',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'guard_name' => 'string',
        'is_active' => 'boolean',
    ];

    public static $rules = [
        'name' => 'required|string',
    ];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            'role_id',
            'permission_id'
        );
    }

    public function users(): MorphToMany
    {
        return $this->morphedByMany(
            getModelForGuard($this->attributes['guard_name']),
            'model',
            config('permission.table_names.model_has_roles'),
            'role_id',
            config('permission.column_names.model_morph_key')
        );
    }

    public static function findByName(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::named($name);
        }

        return $role;
    }

    public static function findById(int $id, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('id', $id)->where('guard_name', $guardName)->first();

        if (! $role) {
            throw RoleDoesNotExist::withId($id);
        }

        return $role;
    }

    public static function findOrCreate(string $name, $guardName = null): RoleContract
    {
        $guardName = $guardName ?? Guard::getDefaultName(static::class);

        $role = static::where('name', $name)->where('guard_name', $guardName)->first();

        if ($role) {
            return $role;
        }

        return static::query()->create(['name' => $name, 'guard_name' => $guardName]);
    }
}
