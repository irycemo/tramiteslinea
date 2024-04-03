<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends SpatieRole implements Auditable
{

    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

}
