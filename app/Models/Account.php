<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Account extends BaseModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'accountID';
    protected $table = 'accounts';

    protected $fillable = [
        'accountName',
        'licenseType'
    ];

    public function getValidationRules(array $fieldsToValidate): array
    {
        $validationRules =  [
            'accountName' => ['string', 'required', 'max:100'],
            'licenseType' => ['string', 'required', 'in:basic,pro'],
        ];

        if (
            empty($fieldsToValidate)
        ) {
            return $validationRules;
        }

        // Filter the rules based on the posted fields
        $filteredRules = array_intersect_key($validationRules, $fieldsToValidate);

        return $filteredRules;
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'accountID', 'accountID');
    }
}
