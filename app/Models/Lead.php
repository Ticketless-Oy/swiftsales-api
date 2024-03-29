<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends BaseModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $primaryKey = 'leadID';

    /**
     * @var string
     */
    protected $foreignKey = 'userID';

    protected $fillable = [
        'userID',
        'companyID',
        'name',
        'description',
    ];

    public static function getValidationRules(array $fieldsToValidate): array
    {
        $validationRules =  [
            'userID' => ['integer', 'required', 'exists:users,userID'],
            'companyID' => ['integer', 'required', 'exists:companies,companyID'],
            'name' => ['string', 'required', 'max:100'],
            'description' => ['string', 'max:1000'],
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

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'companyID', 'companyID');
    }
}
