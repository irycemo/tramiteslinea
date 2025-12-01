<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Entidad;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Traits\ComponentesTrait;
use App\Mail\RegistroUsuarioMail;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class Usuarios extends Component
{
    use WithPagination;
    use ComponentesTrait;

    public $roles;
    public $role;
    public $areas_adscripcion;
    public $oficinas;
    public $modalPermisos = false;
    public $listaDePermisos = [];
    public $permisos;
    public $notarias;
    public $esNotario = false;
    public $esNotarioAdsqcrito = false;
    public $entidadId;
    public $dependencias;

    public User $modelo_editar;

    public $filters = [
        'rol' => '',
    ];
    protected function rules(){
        return [
            'modelo_editar.name' => 'required',
            'modelo_editar.email' => 'required|email|unique:users,email,' . $this->modelo_editar->id,
            'modelo_editar.estado' => 'required|in:activo,inactivo',
            'modelo_editar.entidad_id' => Rule::requiredIf($this->role != 8),
            'role' => 'required',
            'rfc' => [
                'nullable',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/'
            ],
         ];
    }

    protected $validationAttributes  = [
        'role' => 'rol',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar =  User::make();
    }

    public function updatedRole(){

        $this->modelo_editar->entidad_id = null;

    }

    public function abrirModalEditar(User $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        if(isset($modelo['roles'][0]))
            $this->role = $modelo->roles()->first()->id;

        if($this->role == 2){

            $this->esNotario = true;

            $this->entidadId = $this->modelo_editar->entidad_id;

        }

        if($this->role == 2){

            $this->esNotarioAdsqcrito = true;

            $this->entidadId = $this->modelo_editar->entidad_id;

        }

    }

    public function abrirModalPermisos(User $modelo){

        $this->resetearTodo();

        $this->modalPermisos = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        foreach($modelo->getAllPermissions() as $permission)
            array_push($this->listaDePermisos, (string)$permission['id']);


    }

    public function asignar(){

        try {

            DB::transaction(function () {

                $this->modelo_editar->syncPermissions([]);

                foreach ($this->listaDePermisos as $permiso)
                    $this->modelo_editar->givePermissionTo(Permission::find($permiso)->name);


                $this->resetearTodo();

                $this->dispatch('mostrarMensaje', ['success', "Se actualizaron los permisos con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permisos usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function guardar(){

        $this->validate();

        if(User::where('name', $this->modelo_editar->name)->first()){

            $this->dispatch('mostrarMensaje', ['warning', "El usuario " . $this->modelo_editar->name . " ya esta registrado."]);

            $this->resetearTodo();

            return;

        }

        try {

            DB::transaction(function () {

                if(!app()->isProduction()){

                    $this->modelo_editar->email_verified_at = now()->toDateString();

                }

                $this->modelo_editar->password = bcrypt('sistema');
                $this->modelo_editar->creado_por = auth()->id();
                $this->modelo_editar->clave = User::max('clave') + 1;
                $this->modelo_editar->save();

                $this->modelo_editar->auditAttach('roles', $this->role);

                if($this->role == 2){

                    $this->modelo_editar->entidad->update(['notario' => $this->modelo_editar->id]);

                }elseif($this->role == 3){

                    $this->modelo_editar->entidad->update(['adscrito' => $this->modelo_editar->id]);

                }

                Mail::to($this->modelo_editar->email)->send(new RegistroUsuarioMail($this->modelo_editar));

                if(app()->isProduction()){

                    event(new Registered($this->modelo_editar));

                }

                $this->resetearTodo();

                $this->dispatch('mostrarMensaje', ['success', "El usuario se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->actualizado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->modelo_editar->auditSync('roles', $this->role);

                if($this->role == 2){

                    $this->modelo_editar->entidad->update(['notario' => $this->modelo_editar->id]);

                }

                if($this->esNotarioAdsqcrito && $this->entidadId !== $this->modelo_editar->entidad_id){

                    Entidad::find($this->entidadId)->update(['notario' => null]);

                }

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El usuario se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $usuario = User::find($this->selected_id);

            $usuario->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El usuario se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function resetearPassword($id){

        try{

            $usuario = User::find($id);

            $usuario->password = bcrypt('sistema');

            if(app()->isProduction()){

                Mail::to($usuario->email)->send(new RegistroUsuarioMail($usuario));

            }

            $usuario->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La contraseña se reestableció con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al resetear contraseña por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'role', 'listaDePermisos', 'modalPermisos');

        $this->roles = Role::where('id', '!=', 1)->select('id', 'name')->orderBy('name')->get();

        $permisos = Permission::all();

        $this->permisos = $permisos->groupBy(function($permiso) {
            return $permiso->area;
        })->all();

        $this->notarias = Entidad::where('estado', 'activo')
                                    ->whereNotNull('numero_notaria')
                                    ->orderBy('numero_notaria')
                                    ->get();

        $this->dependencias = Entidad::where('estado', 'activo')
                                    ->whereNotNull('dependencia')
                                    ->orderBy('dependencia')
                                    ->get();

    }

    #[Computed]
    public function usuarios(){

        return User::with('creadoPor:id,name', 'actualizadoPor:id,name')
                        ->where(function($q){
                            $q->where('name', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('clave', 'LIKE', '%' . $this->search . '%')
                                ->orWhere('email', 'LIKE', '%' . $this->search . '%');
                        })
                        ->when($this->filters['rol'], fn($q, $rol) => $q->whereHas('roles', function($q) use($rol){ $q->where('name', $rol); }))
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.usuarios')->extends('layouts.admin');

    }

}
