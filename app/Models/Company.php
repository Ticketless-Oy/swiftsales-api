<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Company extends BaseModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'companyID';

    /**
     * @var string
     */
    protected $foreignKey = 'userID';

    protected $fillable = [
        'userID',
        'companyName',
        'businessID',
    ];

    public static function getValidationRules(array $fieldsToValidate): array
    {
        $validationRules =  [
            'companyName' => ['string', 'required', 'max:100'],
            'businessID' => ['string', 'max:100'],
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

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'companyID', 'companyID');
    }
}
