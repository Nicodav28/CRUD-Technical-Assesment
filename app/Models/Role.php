<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [ 'nombre' ];

    public function empleados()
    {
        return $this->belongsToMany(Employee::class, 'empleado_rol', 'rol_id', 'empleado_id');
    }
}
