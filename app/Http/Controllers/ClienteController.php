<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $clientes = Cliente::query()
            ->when($search, function ($query, $search) {
                $query->where('nombres', 'like', "%{$search}%")
                      ->orWhere('apellidos', 'like', "%{$search}%")
                      ->orWhere('documento_identidad', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('clientes.index', compact('clientes', 'search'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        // Transacción para garantizar que si falla el usuario o el cliente, no se guarde nada
        DB::transaction(function () use ($request) {
            // 1. Crear el Registro de Cliente
            $cliente = Cliente::create($request->validated());

            // 2. Crear la Cuenta de Usuario vinculada si se proporciona un correo
            $email = $request->input('correo') ?? ($request->input('documento_identidad') . '@sistema.com');

            User::create([
                'name' => $cliente->nombres . ' ' . $cliente->apellidos,
                'email' => $email,
                // Usamos el número de documento como contraseña inicial
                'password' => Hash::make($request->input('documento_identidad')),
                'role' => 'Cliente',
                'cliente_id' => $cliente->id,
            ]);
        });

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente y cuenta de acceso creados correctamente. Su contraseña inicial es su Documento de Identidad.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('creditos.pagos');

        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        DB::transaction(function () use ($request, $cliente) {
            $cliente->update($request->validated());

            // Si el cliente tiene un usuario asociado, actualizamos sus datos básicos
            $user = User::where('cliente_id', $cliente->id)->first();

            if ($user) {
                $email = $request->input('correo') ?? ($request->input('documento_identidad') . '@sistema.com');
                $user->update([
                    'name' => $cliente->nombres . ' ' . $cliente->apellidos,
                    'email' => $email,
                ]);
            }
        });

        return redirect()->route('clientes.index')
            ->with('success', 'Información del cliente actualizada.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->update(['estado' => 'inactivo']);

        return redirect()->route('clientes.index')
            ->with('success', 'El cliente ha sido desactivado correctamente.');
    }
}