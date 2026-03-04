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
            // ── Admin ────────────────────────────────────────
            'n.gonzalez@techtrack.com' => ['nombre' => 'Nuria', 'apellidos' => 'González Martín', 'telefono' => '+34 600 121 543', 'cargo' => 'IT Director', 'departamento' => 'Dirección de Sistemas', 'biografia' => 'Responsable de la estrategia tecnológica y del gobierno TI corporativo.'],

            // ── GESTORES ─────────────────────────────────────
            'l.martinez@techtrack.com' => ['nombre' => 'Laura', 'apellidos' => 'Martínez López', 'telefono' => '+34 644 212 778', 'cargo' => 'Service Desk Manager', 'departamento' => 'Soporte', 'biografia' => 'Coordina el ciclo de vida de incidencias y niveles de servicio en BCN.'],
            'd.ortega@techtrack.com'   => ['nombre' => 'David', 'apellidos' => 'Ortega Salas', 'telefono' => '+34 611 388 927', 'cargo' => 'Incident Manager', 'departamento' => 'Soporte', 'biografia' => 'Supervisa backlog, asignaciones y cumplimiento de SLA en Madrid.'],
            'k.weber@techtrack.com'    => ['nombre' => 'Klaus', 'apellidos' => 'Weber', 'telefono' => '+49 170 445 3321', 'cargo' => 'IT Service Manager', 'departamento' => 'Soporte', 'biografia' => 'Responsable de la gestión de servicios TI en la sede de Berlín.'],
            's.tremblay@techtrack.com' => ['nombre' => 'Sophie', 'apellidos' => 'Tremblay', 'telefono' => '+1 514 332 7789', 'cargo' => 'Support Lead', 'departamento' => 'Soporte', 'biografia' => 'Lidera el equipo de soporte técnico en la sede de Montreal.'],
            'r.sousa@techtrack.com'    => ['nombre' => 'Ricardo', 'apellidos' => 'Sousa', 'telefono' => '+351 912 445 680', 'cargo' => 'Operations Manager', 'departamento' => 'Soporte', 'biografia' => 'Gestiona las operaciones de soporte y mantenimiento en Lisboa.'],
            'm.rossi@techtrack.com'    => ['nombre' => 'Marco', 'apellidos' => 'Rossi', 'telefono' => '+39 338 221 4478', 'cargo' => 'Service Coordinator', 'departamento' => 'Soporte', 'biografia' => 'Coordina los servicios de soporte e incidencias en la sede de Roma.'],

            // ── TÉCNICOS ─────────────────────────────────────
            // BCN
            'c.ruiz@techtrack.com'     => ['nombre' => 'Carlos', 'apellidos' => 'Ruiz Gómez', 'telefono' => '+34 622 845 120', 'cargo' => 'Network Technician', 'departamento' => 'Infraestructura', 'biografia' => 'Especialista en conectividad, VPN y monitorización de red.'],
            'e.vidal@techtrack.com'    => ['nombre' => 'Elena', 'apellidos' => 'Vidal Torres', 'telefono' => '+34 637 190 854', 'cargo' => 'Desktop Support', 'departamento' => 'Soporte N1', 'biografia' => 'Soporte de primer nivel para puestos de trabajo y periféricos.'],
            // MAD
            'p.navarro@techtrack.com'  => ['nombre' => 'Pablo', 'apellidos' => 'Navarro Ruiz', 'telefono' => '+34 619 443 712', 'cargo' => 'Systems Administrator', 'departamento' => 'Plataforma', 'biografia' => 'Administración de servidores Windows y Linux en el CPD de Madrid.'],
            's.dominguez@techtrack.com' => ['nombre' => 'Sara', 'apellidos' => 'Domínguez Blanco', 'telefono' => '+34 654 882 310', 'cargo' => 'Cloud Technician', 'departamento' => 'Cloud', 'biografia' => 'Gestión y monitorización de entornos Azure y AWS.'],
            // BER
            'a.schmidt@techtrack.com'  => ['nombre' => 'Anna', 'apellidos' => 'Schmidt', 'telefono' => '+49 151 8763 2241', 'cargo' => 'Systems Technician', 'departamento' => 'Plataforma', 'biografia' => 'Administra entornos Windows, MDM y parque de portátiles.'],
            't.muller@techtrack.com'   => ['nombre' => 'Thomas', 'apellidos' => 'Müller', 'telefono' => '+49 160 773 5589', 'cargo' => 'Network Engineer', 'departamento' => 'Infraestructura', 'biografia' => 'Diseño y mantenimiento de la infraestructura de red en Berlín.'],
            // YUL
            'jp.lavoie@techtrack.com'  => ['nombre' => 'Jean-Pierre', 'apellidos' => 'Lavoie', 'telefono' => '+1 514 991 4427', 'cargo' => 'DevOps Technician', 'departamento' => 'DevOps', 'biografia' => 'Automatización de despliegues y mantenimiento de pipelines CI/CD.'],
            'a.gagnon@techtrack.com'   => ['nombre' => 'Amélie', 'apellidos' => 'Gagnon', 'telefono' => '+1 438 551 2238', 'cargo' => 'Help Desk Analyst', 'departamento' => 'Soporte N1', 'biografia' => 'Primer punto de contacto para incidencias de usuarios en Montreal.'],
            // LIS
            'j.ferreira@techtrack.com' => ['nombre' => 'João', 'apellidos' => 'Ferreira', 'telefono' => '+351 913 255 771', 'cargo' => 'Security Technician', 'departamento' => 'Ciberseguridad', 'biografia' => 'Gestiona antivirus corporativo y políticas de hardening.'],
            'a.oliveira@techtrack.com' => ['nombre' => 'Ana', 'apellidos' => 'Oliveira Santos', 'telefono' => '+351 926 110 443', 'cargo' => 'Database Administrator', 'departamento' => 'Datos', 'biografia' => 'Gestión de bases de datos Oracle y PostgreSQL en Lisboa.'],
            // ROM
            'g.bianchi@techtrack.com'  => ['nombre' => 'Giulia', 'apellidos' => 'Bianchi', 'telefono' => '+39 333 778 2194', 'cargo' => 'Application Support', 'departamento' => 'Aplicaciones', 'biografia' => 'Da soporte funcional y técnico a ERP y herramientas internas.'],
            'a.conti@techtrack.com'    => ['nombre' => 'Alessandro', 'apellidos' => 'Conti', 'telefono' => '+39 345 891 7730', 'cargo' => 'Telecom Technician', 'departamento' => 'Comunicaciones', 'biografia' => 'Mantenimiento de centralitas VoIP y sistemas de videoconferencia.'],

            // ── CLIENTES ─────────────────────────────────────
            // BCN
            'j.perez@techtrack.com'       => ['nombre' => 'Juan', 'apellidos' => 'Pérez García', 'telefono' => '+34 633 541 990', 'cargo' => 'Accountant', 'departamento' => 'Finanzas', 'biografia' => 'Usuario de herramientas contables y reportes financieros.'],
            'marta.sanchez@techtrack.com' => ['nombre' => 'Marta', 'apellidos' => 'Sánchez Romero', 'telefono' => '+34 645 220 113', 'cargo' => 'Project Manager', 'departamento' => 'PMO', 'biografia' => 'Gestiona proyectos internos y coordina equipos multidisciplinares.'],
            'a.molina@techtrack.com'      => ['nombre' => 'Andrés', 'apellidos' => 'Molina Campos', 'telefono' => '+34 611 870 442', 'cargo' => 'Graphic Designer', 'departamento' => 'Comunicación', 'biografia' => 'Diseño gráfico corporativo y material de marketing.'],
            // MAD
            'm.lopez@techtrack.com'    => ['nombre' => 'María', 'apellidos' => 'López Fernández', 'telefono' => '+34 655 921 405', 'cargo' => 'HR Specialist', 'departamento' => 'Recursos Humanos', 'biografia' => 'Gestiona procesos de talento y documentación laboral.'],
            'f.gil@techtrack.com'      => ['nombre' => 'Fernando', 'apellidos' => 'Gil Herrero', 'telefono' => '+34 620 334 567', 'cargo' => 'Legal Advisor', 'departamento' => 'Legal', 'biografia' => 'Asesoría jurídica en contratos TI y protección de datos.'],
            'i.ramos@techtrack.com'    => ['nombre' => 'Isabel', 'apellidos' => 'Ramos Díaz', 'telefono' => '+34 667 115 890', 'cargo' => 'Quality Analyst', 'departamento' => 'Calidad', 'biografia' => 'Control de calidad en procesos internos y auditorías ISO.'],
            // BER
            'p.hoffmann@techtrack.com' => ['nombre' => 'Petra', 'apellidos' => 'Hoffmann', 'telefono' => '+49 176 334 7712', 'cargo' => 'Research Scientist', 'departamento' => 'I+D', 'biografia' => 'Investigación en inteligencia artificial aplicada a procesos industriales.'],
            'l.fischer@techtrack.com'  => ['nombre' => 'Lukas', 'apellidos' => 'Fischer', 'telefono' => '+49 152 665 8843', 'cargo' => 'Product Manager', 'departamento' => 'Producto', 'biografia' => 'Define roadmap de producto y prioriza funcionalidades.'],
            's.braun@techtrack.com'    => ['nombre' => 'Sabine', 'apellidos' => 'Braun', 'telefono' => '+49 163 991 2205', 'cargo' => 'Training Coordinator', 'departamento' => 'Formación', 'biografia' => 'Organiza formaciones técnicas y onboarding de nuevos empleados.'],
            // YUL
            'm.dupont@techtrack.com'   => ['nombre' => 'Marc', 'apellidos' => 'Dupont', 'telefono' => '+1 514 280 6451', 'cargo' => 'Marketing Analyst', 'departamento' => 'Marketing', 'biografia' => 'Trabaja con dashboards de campañas y activos compartidos.'],
            'i.roy@techtrack.com'      => ['nombre' => 'Isabelle', 'apellidos' => 'Roy', 'telefono' => '+1 438 770 1192', 'cargo' => 'Data Analyst', 'departamento' => 'Business Intelligence', 'biografia' => 'Análisis de datos de negocio y generación de informes ejecutivos.'],
            'e.cote@techtrack.com'     => ['nombre' => 'Étienne', 'apellidos' => 'Côté', 'telefono' => '+1 514 558 3345', 'cargo' => 'Sales Representative', 'departamento' => 'Ventas', 'biografia' => 'Gestión de cuentas clave y pipeline comercial en Norteamérica.'],
            // LIS
            'h.costa@techtrack.com'    => ['nombre' => 'Helena', 'apellidos' => 'Costa', 'telefono' => '+351 927 411 620', 'cargo' => 'Procurement Specialist', 'departamento' => 'Compras', 'biografia' => 'Gestiona pedidos de hardware y renovaciones de licencias.'],
            'm.almeida@techtrack.com'  => ['nombre' => 'Miguel', 'apellidos' => 'Almeida', 'telefono' => '+351 916 883 210', 'cargo' => 'Operations Analyst', 'departamento' => 'Operaciones', 'biografia' => 'Monitoriza KPIs operativos y propone mejoras de eficiencia.'],
            'c.silva@techtrack.com'    => ['nombre' => 'Catarina', 'apellidos' => 'Silva', 'telefono' => '+351 934 220 117', 'cargo' => 'Customer Success Manager', 'departamento' => 'Atención al Cliente', 'biografia' => 'Asegura la satisfacción de clientes y gestiona escalaciones.'],
            // ROM
            'l.moretti@techtrack.com'  => ['nombre' => 'Luca', 'apellidos' => 'Moretti', 'telefono' => '+39 347 640 9932', 'cargo' => 'Sales Operations', 'departamento' => 'Ventas', 'biografia' => 'Utiliza CRM y reportes de actividad comercial.'],
            'f.romano@techtrack.com'   => ['nombre' => 'Francesca', 'apellidos' => 'Romano', 'telefono' => '+39 320 554 1187', 'cargo' => 'Event Coordinator', 'departamento' => 'Comunicación', 'biografia' => 'Organiza eventos corporativos y ferias del sector.'],
            'm.deluca@techtrack.com'   => ['nombre' => 'Matteo', 'apellidos' => 'De Luca', 'telefono' => '+39 331 887 4423', 'cargo' => 'Logistics Manager', 'departamento' => 'Logística', 'biografia' => 'Gestión de la cadena de suministro y almacén en Roma.'],
        ];

        foreach ($perfiles as $correo => $perfil) {
            $usuario = User::where('correo', $correo)->firstOrFail();

            PerfilUsuario::create([
                'usuario_id' => $usuario->id,
                'nombre' => $perfil['nombre'],
                'apellidos' => $perfil['apellidos'],
                'telefono' => $perfil['telefono'],
                'ruta_avatar' => null,
                'cargo' => $perfil['cargo'],
                'departamento' => $perfil['departamento'],
                'biografia' => $perfil['biografia'],
                'preferencias' => ['tema' => 'claro', 'idioma' => 'es', 'notificaciones_email' => true],
            ]);
        }
    }
}
