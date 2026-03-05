<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            // ── ADMIN (1 — global, puede ver todas las sedes) ──
            ['nombre' => 'Nuria González',     'correo' => 'n.gonzalez@techtrack.com',   'sede' => 'BCN', 'rol' => 'admin'],

            // ── GESTORES (8) ──
            ['nombre' => 'Laura Martínez',     'correo' => 'l.martinez@techtrack.com',   'sede' => 'BCN', 'rol' => 'gestor'],
            ['nombre' => 'David Ortega',       'correo' => 'd.ortega@techtrack.com',     'sede' => 'MAD', 'rol' => 'gestor'],
            ['nombre' => 'Eva Müller',         'correo' => 'e.muller@techtrack.com',     'sede' => 'BER', 'rol' => 'gestor'],
            ['nombre' => 'Sophie Tremblay',    'correo' => 's.tremblay@techtrack.com',   'sede' => 'YUL', 'rol' => 'gestor'],
            ['nombre' => 'Tomás Santos',       'correo' => 't.santos@techtrack.com',     'sede' => 'LIS', 'rol' => 'gestor'],
            ['nombre' => 'Marco Romano',       'correo' => 'm.romano@techtrack.com',     'sede' => 'ROM', 'rol' => 'gestor'],
            ['nombre' => 'James Wilson',       'correo' => 'j.wilson@techtrack.com',     'sede' => 'LON', 'rol' => 'gestor'],
            ['nombre' => 'Claire Leroy',       'correo' => 'c.leroy@techtrack.com',      'sede' => 'PAR', 'rol' => 'gestor'],

            // ── TÉCNICOS (16) ──
            ['nombre' => 'Carlos Ruiz',        'correo' => 'c.ruiz@techtrack.com',       'sede' => 'BCN', 'rol' => 'tecnico'],
            ['nombre' => 'Sergio Navarro',     'correo' => 's.navarro@techtrack.com',    'sede' => 'BCN', 'rol' => 'tecnico'],
            ['nombre' => 'Raúl García',        'correo' => 'r.garcia@techtrack.com',     'sede' => 'MAD', 'rol' => 'tecnico'],
            ['nombre' => 'Anna Schmidt',       'correo' => 'a.schmidt@techtrack.com',    'sede' => 'BER', 'rol' => 'tecnico'],
            ['nombre' => 'Klaus Braun',        'correo' => 'k.braun@techtrack.com',      'sede' => 'BER', 'rol' => 'tecnico'],
            ['nombre' => 'Philippe Côté',      'correo' => 'p.cote@techtrack.com',       'sede' => 'YUL', 'rol' => 'tecnico'],
            ['nombre' => 'João Ferreira',      'correo' => 'j.ferreira@techtrack.com',   'sede' => 'LIS', 'rol' => 'tecnico'],
            ['nombre' => 'Bruno Almeida',      'correo' => 'b.almeida@techtrack.com',    'sede' => 'LIS', 'rol' => 'tecnico'],
            ['nombre' => 'Giulia Bianchi',     'correo' => 'g.bianchi@techtrack.com',    'sede' => 'ROM', 'rol' => 'tecnico'],
            ['nombre' => 'Fabio Conti',        'correo' => 'f.conti@techtrack.com',      'sede' => 'ROM', 'rol' => 'tecnico'],
            ['nombre' => 'Daniel Taylor',      'correo' => 'd.taylor@techtrack.com',     'sede' => 'LON', 'rol' => 'tecnico'],
            ['nombre' => 'Nicolas Petit',      'correo' => 'n.petit@techtrack.com',      'sede' => 'PAR', 'rol' => 'tecnico'],
            ['nombre' => 'Jan van den Berg',   'correo' => 'j.vandenberg@techtrack.com', 'sede' => 'AMS', 'rol' => 'tecnico'],
            ['nombre' => 'Alejandro Martínez', 'correo' => 'a.mtz@techtrack.com',        'sede' => 'MIA', 'rol' => 'tecnico'],
            ['nombre' => 'Emilio Fernández',   'correo' => 'e.fernandez@techtrack.com',  'sede' => 'BUE', 'rol' => 'tecnico'],
            ['nombre' => 'Yuki Tanaka',        'correo' => 'y.tanaka@techtrack.com',     'sede' => 'TOK', 'rol' => 'tecnico'],

            // ── CLIENTES (32) ──
            ['nombre' => 'Juan Pérez',         'correo' => 'j.perez@techtrack.com',      'sede' => 'BCN', 'rol' => 'cliente'],
            ['nombre' => 'Adrià Vidal',        'correo' => 'a.vidal@techtrack.com',      'sede' => 'BCN', 'rol' => 'cliente'],
            ['nombre' => 'Irene Herrera',      'correo' => 'i.herrera@techtrack.com',    'sede' => 'BCN', 'rol' => 'cliente'],
            ['nombre' => 'María López',        'correo' => 'm.lopez@techtrack.com',      'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Pedro Jiménez',      'correo' => 'p.jimenez@techtrack.com',    'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Lucía Sánchez',      'correo' => 'l.sanchez@techtrack.com',    'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Roberto Castro',     'correo' => 'r.castro@techtrack.com',     'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Hans Fischer',       'correo' => 'h.fischer@techtrack.com',    'sede' => 'BER', 'rol' => 'cliente'],
            ['nombre' => 'Monika Becker',      'correo' => 'm.becker@techtrack.com',     'sede' => 'BER', 'rol' => 'cliente'],
            ['nombre' => 'Marc Dupont',        'correo' => 'm.dupont@techtrack.com',     'sede' => 'YUL', 'rol' => 'cliente'],
            ['nombre' => 'Jacques Gagnon',     'correo' => 'j.gagnon@techtrack.com',     'sede' => 'YUL', 'rol' => 'cliente'],
            ['nombre' => 'Léa Bouchard',       'correo' => 'l.bouchard@techtrack.com',   'sede' => 'YUL', 'rol' => 'cliente'],
            ['nombre' => 'Helena Costa',       'correo' => 'h.costa@techtrack.com',      'sede' => 'LIS', 'rol' => 'cliente'],
            ['nombre' => 'Ricardo Oliveira',   'correo' => 'r.oliveira@techtrack.com',   'sede' => 'LIS', 'rol' => 'cliente'],
            ['nombre' => 'Sara Pereira',       'correo' => 's.pereira@techtrack.com',    'sede' => 'LIS', 'rol' => 'cliente'],
            ['nombre' => 'Luca Moretti',       'correo' => 'l.moretti@techtrack.com',    'sede' => 'ROM', 'rol' => 'cliente'],
            ['nombre' => 'Andrea Esposito',    'correo' => 'a.esposito@techtrack.com',   'sede' => 'ROM', 'rol' => 'cliente'],
            ['nombre' => 'Matteo Ferrari',     'correo' => 'm.ferrari@techtrack.com',    'sede' => 'ROM', 'rol' => 'cliente'],
            ['nombre' => 'Emily Jones',        'correo' => 'e.jones@techtrack.com',      'sede' => 'LON', 'rol' => 'cliente'],
            ['nombre' => 'Sarah Brown',        'correo' => 's.brown@techtrack.com',      'sede' => 'LON', 'rol' => 'cliente'],
            ['nombre' => 'Thomas Williams',    'correo' => 't.williams@techtrack.com',   'sede' => 'LON', 'rol' => 'cliente'],
            ['nombre' => 'Camille Martin',     'correo' => 'c.martin@techtrack.com',     'sede' => 'PAR', 'rol' => 'cliente'],
            ['nombre' => 'Louise Bernard',     'correo' => 'l.bernard@techtrack.com',    'sede' => 'PAR', 'rol' => 'cliente'],
            ['nombre' => 'Pieter de Boer',     'correo' => 'p.deboer@techtrack.com',     'sede' => 'AMS', 'rol' => 'cliente'],
            ['nombre' => 'Karin Jansen',       'correo' => 'k.jansen@techtrack.com',     'sede' => 'AMS', 'rol' => 'cliente'],
            ['nombre' => 'Ruud de Vrij',       'correo' => 'r.devrij@techtrack.com',     'sede' => 'AMS', 'rol' => 'cliente'],
            ['nombre' => 'José Rodríguez',     'correo' => 'j.rodriguez@techtrack.com',  'sede' => 'MIA', 'rol' => 'cliente'],
            ['nombre' => 'Ana Hernández',      'correo' => 'a.hernandez@techtrack.com',  'sede' => 'MIA', 'rol' => 'cliente'],
            ['nombre' => 'Diego Gutiérrez',    'correo' => 'd.gutierrez@techtrack.com',  'sede' => 'BUE', 'rol' => 'cliente'],
            ['nombre' => 'Valentina Romero',   'correo' => 'v.romero@techtrack.com',     'sede' => 'BUE', 'rol' => 'cliente'],
            ['nombre' => 'Satoshi Yamamoto',   'correo' => 's.yamamoto@techtrack.com',   'sede' => 'TOK', 'rol' => 'cliente'],
            ['nombre' => 'Keiko Suzuki',       'correo' => 'k.suzuki@techtrack.com',     'sede' => 'TOK', 'rol' => 'cliente'],
            ['nombre' => 'Pablo Torres',       'correo' => 'p.torres@techtrack.com',     'sede' => 'MAD', 'rol' => 'cliente'],
            ['nombre' => 'Friedrich Weber',    'correo' => 'f.weber@techtrack.com',      'sede' => 'BER', 'rol' => 'cliente'],
            ['nombre' => 'Rachel Smith',       'correo' => 'r.smith@techtrack.com',      'sede' => 'LON', 'rol' => 'cliente'],
        ];

        foreach ($usuarios as $usuario) {
            $sede = Sede::where('codigo', $usuario['sede'])->firstOrFail();
            $rol = Rol::where('nombre', $usuario['rol'])->firstOrFail();

            User::create([
                'sede_id' => $sede->id,
                'rol_id' => $rol->id,
                'nombre' => $usuario['nombre'],
                'correo' => $usuario['correo'],
                'contrasena' => Hash::make('password'),
                'activo' => true,
                'ultimo_acceso' => Carbon::now()->subHours(rand(1, 96)),
            ]);
        }
    }
}
