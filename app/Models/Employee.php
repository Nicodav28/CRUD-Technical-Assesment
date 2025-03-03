<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'nombre',
        'email',
        'sexo',
        'area_id',
        'boletin',
        'descripcion'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'employee_role', 'empleado_id', 'rol_id');
    }

}
