<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            // ── Admin global ─────────────────────────────────
            ['nombre' => 'Nuria González',       'correo' => 'n.gonzalez@techtrack.com',    'sede' => 'BCN', 'rol' => 'admin'],

            // ── GESTORES (1 por sede) ────────────────────────
            ['nombre' => 'Laura Martínez',       'correo' => 'l.martinez@techtrack.com',    'sede' => 'BCN', 'rol' => 'gestor'],
            ['nombre' => 'David Ortega',         'correo' => 'd.ortega@techtrack.com',      'sede' => 'MAD', 'rol' => 'gestor'],
            ['nombre' => 'Klaus Weber',          'correo' => 'k.weber@techtrack.com',       'sede' => 'BER', 'rol' => 'gestor'],
            ['nombre' => 'Sophie Tremblay',      'correo' => 's.tremblay@techtrack.com',    'sede' => 'YUL', 'rol' => 'gestor'],
            ['nombre' => 'Ricardo Sousa',        'correo' => 'r.sousa@techtrack.com',       'sede' => 'LIS', 'rol' => 'gestor'],
            ['nombre' => 'Marco Rossi',          'correo' => 'm.rossi@techtrack.com',       'sede' => 'ROM', 'rol' => 'gestor'],

            // ── TÉCNICOS (2 por sede) ────────────────────────
            // BCN
            ['nombre' => 'Carlos Ruiz',          'correo' => 'c.ruiz@techtrack.com',        'sede' => 'BCN', 'rol' => 'tecnico'],
            ['nombre' => 'Elena Vidal',          'correo' => 'e.vidal@techtrack.com',       'sede' => 'BCN', 'rol' => 'tecnico'],
            // MAD
            ['nombre' => 'Pablo Navarro',        'correo' => 'p.navarro@techtrack.com',     'sede' => 'MAD', 'rol' => 'tecnico'],
            ['nombre' => 'Sara Domínguez',       'correo' => 's.dominguez@techtrack.com',   'sede' => 'MAD', 'rol' => 'tecnico'],
            // BER
            ['nombre' => 'Anna Schmidt',         'correo' => 'a.schmidt@techtrack.com',     'sede' => 'BER', 'rol' => 'tecnico'],
            ['nombre' => 'Thomas Müller',        'correo' => 't.muller@techtrack.com',      'sede' => 'BER', 'rol' => 'tecnico'],
            // YUL
            ['nombre' => 'Jean-Pierre Lavoie',   'correo' => 'jp.lavoie@techtrack.com',    'sede' => 'YUL', 'rol' => 'tecnico'],
            ['nombre' => 'Amélie Gagnon',        'correo' => 'a.gagnon@techtrack.com',     'sede' => 'YUL', 'rol' => 'tecnico'],
            // LIS
            ['nombre' => 'João Ferreira',        'correo' => 'j.ferreira@techtrack.com',    'sede' => 'LIS', 'rol' => 'tecnico'],
            ['nombre' => 'Ana Oliveira',         'correo' => 'a.oliveira@techtrack.com',    'sede' => 'LIS', 'rol' => 'tecnico'],
            // ROM
            ['nombre' => 'Giulia Bianchi',       'correo' => 'g.bianchi@techtrack.com',     'sede' => 'ROM', 'rol' => 'tecnico'],
            ['nombre' => 'Alessandro Conti',     'correo' => 'a.conti@techtrack.com',       'sede' => 'ROM', 'rol' => 'tecnico'],

            // ── CLIENTES (3 por sede) ────────────────────────
            // BCN
            ['nombre' => 'Juan Pérez',           'correo' => 'j.perez@techtrack.com',       'sede' => 'BCN', 'rol' => 'cliente'],
            ['nombre' => 'Marta Sánchez',        'correo' => 'marta.sanchez@techtrack.com', 'sede' => 'BCN', 'rol' => 'cliente'],
            ['nombre' => 'Andrés Molina',        'correo' => 'a.molina@techtrack.com',      'sede' => 'BCN', 'rol' => 'cliente'],
            // MAD
            ['nombre' => 'María López',          'correo' => 'm.lopez@techtrack.com',       'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Fernando Gil',         'correo' => 'f.gil@techtrack.com',         'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Isabel Ramos',         'correo' => 'i.ramos@techtrack.com',       'sede' => 'MAD', 'rol' => 'cliente'],
            // BER
            ['nombre' => 'Petra Hoffmann',       'correo' => 'p.hoffmann@techtrack.com',    'sede' => 'BER', 'rol' => 'cliente'],
            ['nombre' => 'Lukas Fischer',        'correo' => 'l.fischer@techtrack.com',     'sede' => 'BER', 'rol' => 'cliente'],
            ['nombre' => 'Sabine Braun',         'correo' => 's.braun@techtrack.com',       'sede' => 'BER', 'rol' => 'cliente'],
            // YUL
            ['nombre' => 'Marc Dupont',          'correo' => 'm.dupont@techtrack.com',      'sede' => 'YUL', 'rol' => 'cliente'],
            ['nombre' => 'Isabelle Roy',         'correo' => 'i.roy@techtrack.com',         'sede' => 'YUL', 'rol' => 'cliente'],
            ['nombre' => 'Étienne Côté',         'correo' => 'e.cote@techtrack.com',        'sede' => 'YUL', 'rol' => 'cliente'],
            // LIS
            ['nombre' => 'Helena Costa',         'correo' => 'h.costa@techtrack.com',       'sede' => 'LIS', 'rol' => 'cliente'],
            ['nombre' => 'Miguel Almeida',       'correo' => 'm.almeida@techtrack.com',     'sede' => 'LIS', 'rol' => 'cliente'],
            ['nombre' => 'Catarina Silva',       'correo' => 'c.silva@techtrack.com',       'sede' => 'LIS', 'rol' => 'cliente'],
            // ROM
            ['nombre' => 'Luca Moretti',         'correo' => 'l.moretti@techtrack.com',     'sede' => 'ROM', 'rol' => 'cliente'],
            ['nombre' => 'Francesca Romano',     'correo' => 'f.romano@techtrack.com',      'sede' => 'ROM', 'rol' => 'cliente'],
            ['nombre' => 'Matteo De Luca',       'correo' => 'm.deluca@techtrack.com',      'sede' => 'ROM', 'rol' => 'cliente'],
        ];

        foreach ($usuarios as $usuario) {
            $sede = Sede::where('codigo', $usuario['sede'])->firstOrFail();
            $rol = Rol::where('nombre', $usuario['rol'])->firstOrFail();

            User::create([
                'sede_id' => $sede->id,
                'rol_id' => $rol->id,
                'nombre' => $usuario['nombre'],
                'correo' => $usuario['correo'],
                'contrasena' => 'password',
                'activo' => true,
                'ultimo_acceso' => Carbon::now()->subHours(rand(1, 96)),
            ]);
        }
    }
}
