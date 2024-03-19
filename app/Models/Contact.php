<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Contact extends BaseModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'contactID';

    /**
     * @var string
     */
    protected $foreignKey = 'userID';

    protected $fillable = [
        'userID',
        'companyID',
        'firstName',
        'lastName',
        'email',
        'phone',
    ];

    public static function getValidationRules(array $fieldsToValidate): array
    {
        $validationRules =  [
            'firstName' => ['string', 'max:100'],
            'lastName' => ['string', 'max:100'],
            'email' => ['email', 'required', 'max:100'],
            'phone' => ['string', 'max:20'],
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'companyID', 'companyID');
    }
}
