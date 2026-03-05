<?php

namespace Database\Seeders;

use App\Models\SancionUsuario;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class SancionUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['advertencia', 'silencio', 'bloqueo'];

        $motivos = [
            'advertencia' => [
                'Uso reiterado de formato inadecuado en mensajes de incidencia.',
                'Lenguaje poco profesional en la comunicación con soporte.',
                'Apertura de incidencias duplicadas de forma recurrente.',
                'Incumplimiento de la política de uso aceptable de TI.',
                'Compartir credenciales con un compañero de departamento.',
                'Envío de información sensible por canales no seguros.',
            ],
            'silencio' => [
                'Reincidencia en lenguaje ofensivo tras advertencia previa.',
                'Mensajes masivos no solicitados en múltiples incidencias.',
                'Insultos dirigidos al técnico asignado.',
                'Spam repetido en el sistema de mensajería de incidencias.',
                'Difusión de rumores falsos sobre interrupciones de servicio.',
                'Acoso a otros usuarios a través del sistema de tickets.',
            ],
            'bloqueo' => [
                'Uso indebido confirmado de credenciales de otro usuario.',
                'Intento de acceso no autorizado a sistemas restringidos.',
                'Instalación de software malicioso de forma deliberada.',
                'Violación grave y repetida de la política de seguridad.',
                'Manipulación de registros de incidencias para ocultar fallos.',
                'Acceso a datos confidenciales sin autorización.',
            ],
        ];

        $admins = User::whereHas('rol', fn ($q) => $q->where('nombre', 'admin'))->pluck('id')->toArray();
        $gestores = User::whereHas('rol', fn ($q) => $q->where('nombre', 'gestor'))->pluck('id')->toArray();
        $creadores = array_merge($admins, $gestores);

        $clientes = User::whereHas('rol', fn ($q) => $q->where('nombre', 'cliente'))->pluck('id')->toArray();
        $tecnicos = User::whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))->pluck('id')->toArray();
        $sancionables = array_merge($clientes, $tecnicos);

        for ($i = 0; $i < 55; $i++) {
            $tipo = $tipos[array_rand($tipos)];
            $motivosTipo = $motivos[$tipo];
            $diasInicio = rand(1, 60);
            $duracion = match ($tipo) {
                'advertencia' => rand(3, 7),
                'silencio'    => rand(7, 30),
                'bloqueo'     => rand(30, 90),
            };

            SancionUsuario::create([
                'usuario_id' => $sancionables[array_rand($sancionables)],
                'tipo'       => $tipo,
                'motivo'     => $motivosTipo[array_rand($motivosTipo)],
                'inicio_en'  => Carbon::now()->subDays($diasInicio),
                'fin_en'     => Carbon::now()->subDays($diasInicio)->addDays($duracion),
                'creado_por' => $creadores[array_rand($creadores)],
            ]);
        }
    }
}
