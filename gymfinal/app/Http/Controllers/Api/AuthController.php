<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function verificarUsuario(Request $request): JsonResponse
    {
        $identificador = $request->input('identificador');

        if (!$identificador) {
            return response()->json(['rol' => 'none']);
        }

        // Si contiene @ es correo y el first me devuelve el 1 resultado o null
        if (filter_var($identificador, FILTER_VALIDATE_EMAIL)) {
            $worker = DB::table('moonshine_users')->where('email', $identificador)->first();
            if ($worker) {
                return response()->json(['rol' => 'worker']);
            }
        } else {
            // Sino dni
            $cliente = DB::table('clientes')
                ->join('cuotas', 'clientes.tipo_cuota', '=', 'cuotas.id')
                ->where('clientes.dni', $identificador)
                ->select(
                    'clientes.nombre',
                    'clientes.apellidos',
                    'clientes.telefono',
                    'clientes.dni',
                    'clientes.fecha_inicio',
                    'clientes.fecha_caducidad',
                    'clientes.foto',
                    'cuotas.tipo as tipo_cuota'

                )
                ->first();
            if ($cliente) {
                return response()->json([
                    'rol' => 'cliente',
                    'cliente' => [
                        'nombre' => $cliente->nombre,
                        'apellidos' => $cliente->apellidos,
                        'telefono' => $cliente->telefono,
                        'dni' => $cliente->dni,
                        'fecha_inicio' => Carbon::parse($cliente->fecha_inicio)->format('d-m-Y'),
                        'fecha_caducidad' => Carbon::parse($cliente->fecha_caducidad)->format('d-m-Y'),
                        'tipo_cuota' => $cliente->tipo_cuota,
                        'foto' => $cliente->foto,
                    ]
                ]);
            }
        }

        // y si ninguno, no es user del sistema
        return response()->json(['rol' => 'none']);
    }
    public function enviarCodigo(Request $request)
    {
        $dni = $request->dni;
        $cliente = Clientes::where('dni', $dni)->first();

        if (!$cliente || !$cliente->email) {
            return response()->json(['error' => 'Cliente no encontrado o sin email'], 404);
        }

        $codigo = rand(100000, 999999);
        Cache::put("codigo_{$dni}", $codigo, now()->addMinutes(10));

        Mail::raw("Tu código de verificación es: $codigo", function ($message) use ($cliente) {
            $message->to($cliente->email)->subject('Código de verificación - FinalGym');
        });

        return response()->json(['message' => 'Código enviado']);
    }

    public function verificarCodigo(Request $request)
    {
        $dni = $request->dni;
        $codigo = $request->codigo;

        $codigoGuardado = Cache::get("codigo_{$dni}");

        if ($codigoGuardado && $codigoGuardado == $codigo) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false], 401);
    }
}
