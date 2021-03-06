<?php

namespace App\Models;

use App\Libraries\BelongsToMorph;
use App\Models\Scopes\AktuellScope;
use App\Models\Traits\Active;
use App\Models\Traits\DefaultOrder;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;

class SEPAMandate extends Model
{
    use Searchable;
    use DefaultOrder;
    use Active;

    public $timestamps = false;
    protected $table = 'SEPA_MANDATE';
    protected $primaryKey = 'M_ID';
    protected $searchableFields = ['NAME', 'IBAN', 'BIC'];
    protected $defaultOrder = ['NAME' => 'asc'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AktuellScope());
    }

    public function getStartDateFieldName()
    {
        return 'M_ADATUM';
    }

    public function getEndDateFieldName()
    {
        return 'M_EDATUM';
    }

    public function debtorRentalContract()
    {
        return BelongsToMorph::build($this, Mietvertraege::class, 'debtorRentalContract', 'M_KOS_TYP', 'M_KOS_ID');
    }

    public function debtorPurchaseContract()
    {
        return BelongsToMorph::build($this, Kaufvertraege::class, 'debtorPurchaseContract', 'M_KOS_TYP', 'M_KOS_ID');
    }


}
