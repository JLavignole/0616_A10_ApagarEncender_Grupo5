<?php

namespace Database\Seeders;

use App\Models\PerfilUsuario;
use App\Models\User;
use Illuminate\Database\Seeder;

class PerfilUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $perfiles = [
            'n.gonzalez@techtrack.com' => ['nombre' => 'Nuria', 'apellidos' => 'González Martín', 'telefono' => '+34 600 121 543', 'cargo' => 'IT Director', 'departamento' => 'Dirección de Sistemas', 'biografia' => 'Responsable de la estrategia tecnológica y del gobierno TI corporativo.', 'ruta_avatar' => null],
            'l.martinez@techtrack.com' => ['nombre' => 'Laura', 'apellidos' => 'Martínez López', 'telefono' => '+34 644 212 778', 'cargo' => 'Service Desk Manager', 'departamento' => 'Soporte', 'biografia' => 'Coordina el ciclo de vida de incidencias y niveles de servicio.', 'ruta_avatar' => null],
            'd.ortega@techtrack.com' => ['nombre' => 'David', 'apellidos' => 'Ortega Salas', 'telefono' => '+34 611 388 927', 'cargo' => 'Incident Manager', 'departamento' => 'Soporte', 'biografia' => 'Supervisa backlog, asignaciones y cumplimiento de SLA.', 'ruta_avatar' => null],
            'c.ruiz@techtrack.com' => ['nombre' => 'Carlos', 'apellidos' => 'Ruiz Gómez', 'telefono' => '+34 622 845 120', 'cargo' => 'Network Technician', 'departamento' => 'Infraestructura', 'biografia' => 'Especialista en conectividad, VPN y monitorización de red.', 'ruta_avatar' => null],
            'a.schmidt@techtrack.com' => ['nombre' => 'Anna', 'apellidos' => 'Schmidt', 'telefono' => '+49 151 8763 2241', 'cargo' => 'Systems Technician', 'departamento' => 'Plataforma', 'biografia' => 'Administra entornos Windows, MDM y parque de portátiles.', 'ruta_avatar' => null],
            'j.ferreira@techtrack.com' => ['nombre' => 'João', 'apellidos' => 'Ferreira', 'telefono' => '+351 913 255 771', 'cargo' => 'Security Technician', 'departamento' => 'Ciberseguridad', 'biografia' => 'Gestiona antivirus corporativo y políticas de hardening.', 'ruta_avatar' => null],
            'g.bianchi@techtrack.com' => ['nombre' => 'Giulia', 'apellidos' => 'Bianchi', 'telefono' => '+39 333 778 2194', 'cargo' => 'Application Support Technician', 'departamento' => 'Aplicaciones', 'biografia' => 'Da soporte funcional y técnico a ERP y herramientas internas.', 'ruta_avatar' => null],
            'j.perez@techtrack.com' => ['nombre' => 'Juan', 'apellidos' => 'Pérez García', 'telefono' => '+34 633 541 990', 'cargo' => 'Accountant', 'departamento' => 'Finanzas', 'biografia' => 'Usuario de herramientas contables y reportes financieros.', 'ruta_avatar' => null],
            'm.lopez@techtrack.com' => ['nombre' => 'María', 'apellidos' => 'López Fernández', 'telefono' => '+34 655 921 405', 'cargo' => 'HR Specialist', 'departamento' => 'Recursos Humanos', 'biografia' => 'Gestiona procesos de talento y documentación laboral.', 'ruta_avatar' => null],
            'm.dupont@techtrack.com' => ['nombre' => 'Marc', 'apellidos' => 'Dupont', 'telefono' => '+1 514 280 6451', 'cargo' => 'Marketing Analyst', 'departamento' => 'Marketing', 'biografia' => 'Trabaja con dashboards de campañas y activos compartidos.', 'ruta_avatar' => null],
            'h.costa@techtrack.com' => ['nombre' => 'Helena', 'apellidos' => 'Costa', 'telefono' => '+351 927 411 620', 'cargo' => 'Procurement Specialist', 'departamento' => 'Compras', 'biografia' => 'Gestiona pedidos de hardware y renovaciones de licencias.', 'ruta_avatar' => null],
            'l.moretti@techtrack.com' => ['nombre' => 'Luca', 'apellidos' => 'Moretti', 'telefono' => '+39 347 640 9932', 'cargo' => 'Sales Operations', 'departamento' => 'Ventas', 'biografia' => 'Utiliza CRM y reportes de actividad comercial.', 'ruta_avatar' => null],
        ];

        foreach ($perfiles as $correo => $perfil) {
            $usuario = User::where('correo', $correo)->firstOrFail();

            PerfilUsuario::create([
                'usuario_id' => $usuario->id,
                'nombre' => $perfil['nombre'],
                'apellidos' => $perfil['apellidos'],
                'telefono' => $perfil['telefono'],
                'ruta_avatar' => $perfil['ruta_avatar'],
                'cargo' => $perfil['cargo'],
                'departamento' => $perfil['departamento'],
                'biografia' => $perfil['biografia'],
                'preferencias' => ['tema' => 'claro', 'idioma' => 'es', 'notificaciones_email' => true],
            ]);
        }
    }
}
