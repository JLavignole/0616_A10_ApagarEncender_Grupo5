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
            // ── ADMIN (global) ──
            'n.gonzalez@techtrack.com' => ['nombre' => 'Nuria',     'apellidos' => 'González Martín',     'telefono' => '+34 600 121 543',  'cargo' => 'IT Director',              'departamento' => 'Dirección de Sistemas', 'biografia' => 'Responsable de la estrategia tecnológica y del gobierno TI corporativo.'],

            // ── GESTORES ──
            'l.martinez@techtrack.com' => ['nombre' => 'Laura',     'apellidos' => 'Martínez López',      'telefono' => '+34 644 212 778',  'cargo' => 'Service Desk Manager',     'departamento' => 'Soporte',               'biografia' => 'Coordina el ciclo de vida de incidencias y niveles de servicio.'],
            'd.ortega@techtrack.com'   => ['nombre' => 'David',     'apellidos' => 'Ortega Salas',        'telefono' => '+34 611 388 927',  'cargo' => 'Incident Manager',         'departamento' => 'Soporte',               'biografia' => 'Supervisa backlog, asignaciones y cumplimiento de SLA.'],
            'e.muller@techtrack.com'   => ['nombre' => 'Eva',       'apellidos' => 'Müller',              'telefono' => '+49 151 2244 781', 'cargo' => 'IT Service Coordinator',   'departamento' => 'Soporte',               'biografia' => 'Gestiona la cola de incidencias de la sede de Berlín.'],
            's.tremblay@techtrack.com' => ['nombre' => 'Sophie',    'apellidos' => 'Tremblay',            'telefono' => '+1 514 555 0142',  'cargo' => 'Operations Analyst',       'departamento' => 'Operaciones',           'biografia' => 'Analiza métricas de servicio y propone mejoras continuas.'],
            't.santos@techtrack.com'   => ['nombre' => 'Tomás',     'apellidos' => 'Santos Oliveira',     'telefono' => '+351 910 334 891', 'cargo' => 'Support Team Lead',        'departamento' => 'Soporte',               'biografia' => 'Lidera el equipo de soporte N1 en Lisboa.'],
            'm.romano@techtrack.com'   => ['nombre' => 'Marco',     'apellidos' => 'Romano',              'telefono' => '+39 320 445 6712', 'cargo' => 'Service Manager',          'departamento' => 'Soporte',               'biografia' => 'Responsable de calidad del servicio para la sede de Roma.'],
            'j.wilson@techtrack.com'   => ['nombre' => 'James',     'apellidos' => 'Wilson',              'telefono' => '+44 7911 123 456', 'cargo' => 'IT Helpdesk Manager',      'departamento' => 'Soporte',               'biografia' => 'Dirige el helpdesk de la oficina de Londres.'],
            'c.leroy@techtrack.com'    => ['nombre' => 'Claire',    'apellidos' => 'Leroy',               'telefono' => '+33 6 12 34 56 78','cargo' => 'Gestora de Incidencias',   'departamento' => 'Soporte',               'biografia' => 'Coordina incidencias y escalados en París.'],

            // ── TÉCNICOS ──
            'c.ruiz@techtrack.com'       => ['nombre' => 'Carlos',    'apellidos' => 'Ruiz Gómez',        'telefono' => '+34 622 845 120',  'cargo' => 'Network Technician',          'departamento' => 'Infraestructura',  'biografia' => 'Especialista en conectividad, VPN y monitorización de red.'],
            's.navarro@techtrack.com'    => ['nombre' => 'Sergio',    'apellidos' => 'Navarro Díaz',       'telefono' => '+34 655 102 334',  'cargo' => 'Desktop Support',             'departamento' => 'Soporte N2',       'biografia' => 'Soporte presencial de portátiles y periféricos en BCN.'],
            'r.garcia@techtrack.com'     => ['nombre' => 'Raúl',      'apellidos' => 'García Herrero',     'telefono' => '+34 633 789 012',  'cargo' => 'Cloud Engineer',              'departamento' => 'Infraestructura',  'biografia' => 'Administra entornos AWS y pipelines CI/CD.'],
            'a.schmidt@techtrack.com'    => ['nombre' => 'Anna',      'apellidos' => 'Schmidt',            'telefono' => '+49 151 8763 2241','cargo' => 'Systems Technician',          'departamento' => 'Plataforma',       'biografia' => 'Administra entornos Windows, MDM y parque de portátiles.'],
            'k.braun@techtrack.com'      => ['nombre' => 'Klaus',     'apellidos' => 'Braun',              'telefono' => '+49 170 5544 332', 'cargo' => 'Database Administrator',      'departamento' => 'Datos',            'biografia' => 'Gestiona instancias PostgreSQL y SQL Server.'],
            'p.cote@techtrack.com'       => ['nombre' => 'Philippe',  'apellidos' => 'Côté',               'telefono' => '+1 438 555 0199',  'cargo' => 'Infrastructure Technician',   'departamento' => 'Infraestructura',  'biografia' => 'Mantiene servidores on-premise y backups en Montreal.'],
            'j.ferreira@techtrack.com'   => ['nombre' => 'João',      'apellidos' => 'Ferreira',           'telefono' => '+351 913 255 771', 'cargo' => 'Security Technician',         'departamento' => 'Ciberseguridad',   'biografia' => 'Gestiona antivirus corporativo y políticas de hardening.'],
            'b.almeida@techtrack.com'    => ['nombre' => 'Bruno',     'apellidos' => 'Almeida',            'telefono' => '+351 926 110 482', 'cargo' => 'Network Technician',          'departamento' => 'Infraestructura',  'biografia' => 'Monitoriza la red WAN/LAN de la sede Lisboa.'],
            'g.bianchi@techtrack.com'    => ['nombre' => 'Giulia',    'apellidos' => 'Bianchi',            'telefono' => '+39 333 778 2194', 'cargo' => 'Application Support',         'departamento' => 'Aplicaciones',     'biografia' => 'Da soporte funcional y técnico a ERP y herramientas internas.'],
            'f.conti@techtrack.com'      => ['nombre' => 'Fabio',     'apellidos' => 'Conti',              'telefono' => '+39 328 990 4411', 'cargo' => 'Systems Administrator',       'departamento' => 'Plataforma',       'biografia' => 'Administra Active Directory y GPO en la sede Roma.'],
            'd.taylor@techtrack.com'     => ['nombre' => 'Daniel',    'apellidos' => 'Taylor',             'telefono' => '+44 7800 556 231', 'cargo' => 'DevOps Engineer',             'departamento' => 'Plataforma',       'biografia' => 'Automatiza despliegues y mantiene entornos Docker.'],
            'n.petit@techtrack.com'      => ['nombre' => 'Nicolas',   'apellidos' => 'Petit',              'telefono' => '+33 6 98 76 54 32','cargo' => 'Telecom Technician',          'departamento' => 'Comunicaciones',   'biografia' => 'Gestiona centralitas IP y líneas SIP en París.'],
            'j.vandenberg@techtrack.com' => ['nombre' => 'Jan',       'apellidos' => 'van den Berg',       'telefono' => '+31 6 1234 5678',  'cargo' => 'Storage Engineer',            'departamento' => 'Infraestructura',  'biografia' => 'Administra cabinas NAS/SAN y copias de seguridad.'],
            'a.mtz@techtrack.com'        => ['nombre' => 'Alejandro', 'apellidos' => 'Martínez',           'telefono' => '+1 305 555 0177',  'cargo' => 'IT Support Specialist',       'departamento' => 'Soporte N2',       'biografia' => 'Soporte remoto para la oficina de Miami.'],
            'e.fernandez@techtrack.com'  => ['nombre' => 'Emilio',    'apellidos' => 'Fernández',          'telefono' => '+54 11 5555 0188', 'cargo' => 'Linux Administrator',         'departamento' => 'Plataforma',       'biografia' => 'Gestiona servidores Linux y servicios web internos.'],
            'y.tanaka@techtrack.com'     => ['nombre' => 'Yuki',      'apellidos' => 'Tanaka',             'telefono' => '+81 90 1234 5678', 'cargo' => 'IT Technician',               'departamento' => 'Soporte N2',       'biografia' => 'Soporte técnico presencial y remoto en Tokio.'],

            // ── CLIENTES ──
            'j.perez@techtrack.com'     => ['nombre' => 'Juan',      'apellidos' => 'Pérez García',       'telefono' => '+34 633 541 990',  'cargo' => 'Accountant',                  'departamento' => 'Finanzas',            'biografia' => 'Usuario de herramientas contables y reportes financieros.'],
            'a.vidal@techtrack.com'     => ['nombre' => 'Adrià',     'apellidos' => 'Vidal Puig',         'telefono' => '+34 622 334 556',  'cargo' => 'UX Designer',                 'departamento' => 'Producto',            'biografia' => 'Diseña interfaces de usuario para aplicaciones internas.'],
            'i.herrera@techtrack.com'   => ['nombre' => 'Irene',     'apellidos' => 'Herrera Molina',     'telefono' => '+34 688 112 447',  'cargo' => 'Project Manager',             'departamento' => 'PMO',                 'biografia' => 'Coordina proyectos de transformación digital.'],
            'm.lopez@techtrack.com'     => ['nombre' => 'María',     'apellidos' => 'López Fernández',    'telefono' => '+34 655 921 405',  'cargo' => 'HR Specialist',               'departamento' => 'Recursos Humanos',    'biografia' => 'Gestiona procesos de talento y documentación laboral.'],
            'p.jimenez@techtrack.com'   => ['nombre' => 'Pedro',     'apellidos' => 'Jiménez Ruiz',       'telefono' => '+34 611 789 234',  'cargo' => 'Logistics Coordinator',       'departamento' => 'Logística',           'biografia' => 'Gestiona envíos y recepción de equipamiento IT.'],
            'l.sanchez@techtrack.com'   => ['nombre' => 'Lucía',     'apellidos' => 'Sánchez Blanco',     'telefono' => '+34 644 567 890',  'cargo' => 'Legal Advisor',               'departamento' => 'Asesoría Jurídica',   'biografia' => 'Revisa contratos de proveedores tecnológicos.'],
            'r.castro@techtrack.com'    => ['nombre' => 'Roberto',   'apellidos' => 'Castro Morales',     'telefono' => '+34 677 223 114',  'cargo' => 'Financial Analyst',           'departamento' => 'Finanzas',            'biografia' => 'Elabora presupuestos y forecasting de TI.'],
            'h.fischer@techtrack.com'   => ['nombre' => 'Hans',      'apellidos' => 'Fischer',            'telefono' => '+49 162 7712 543', 'cargo' => 'Quality Engineer',            'departamento' => 'Calidad',             'biografia' => 'Valida los entornos de pruebas y automatización QA.'],
            'm.becker@techtrack.com'    => ['nombre' => 'Monika',    'apellidos' => 'Becker',             'telefono' => '+49 171 3345 678', 'cargo' => 'Training Specialist',         'departamento' => 'Formación',           'biografia' => 'Imparte formación sobre herramientas corporativas.'],
            'm.dupont@techtrack.com'    => ['nombre' => 'Marc',      'apellidos' => 'Dupont',             'telefono' => '+1 514 280 6451',  'cargo' => 'Marketing Analyst',           'departamento' => 'Marketing',           'biografia' => 'Trabaja con dashboards de campañas y activos compartidos.'],
            'j.gagnon@techtrack.com'    => ['nombre' => 'Jacques',   'apellidos' => 'Gagnon',             'telefono' => '+1 514 555 0233',  'cargo' => 'Business Analyst',            'departamento' => 'Estrategia',          'biografia' => 'Analiza procesos de negocio y propone mejoras.'],
            'l.bouchard@techtrack.com'  => ['nombre' => 'Léa',       'apellidos' => 'Bouchard',           'telefono' => '+1 438 555 0188',  'cargo' => 'Office Manager',              'departamento' => 'Administración',      'biografia' => 'Gestiona la oficina de Montreal y pedidos de material.'],
            'h.costa@techtrack.com'     => ['nombre' => 'Helena',    'apellidos' => 'Costa',              'telefono' => '+351 927 411 620', 'cargo' => 'Procurement Specialist',      'departamento' => 'Compras',             'biografia' => 'Gestiona pedidos de hardware y renovaciones de licencias.'],
            'r.oliveira@techtrack.com'  => ['nombre' => 'Ricardo',   'apellidos' => 'Oliveira',           'telefono' => '+351 913 778 441', 'cargo' => 'Data Analyst',                'departamento' => 'BI',                  'biografia' => 'Crea dashboards y reportes con Power BI.'],
            's.pereira@techtrack.com'   => ['nombre' => 'Sara',      'apellidos' => 'Pereira',            'telefono' => '+351 926 220 553', 'cargo' => 'Content Editor',              'departamento' => 'Comunicación',        'biografia' => 'Edita contenido para la intranet corporativa.'],
            'l.moretti@techtrack.com'   => ['nombre' => 'Luca',      'apellidos' => 'Moretti',            'telefono' => '+39 347 640 9932', 'cargo' => 'Sales Operations',            'departamento' => 'Ventas',              'biografia' => 'Utiliza CRM y reportes de actividad comercial.'],
            'a.esposito@techtrack.com'  => ['nombre' => 'Andrea',    'apellidos' => 'Esposito',           'telefono' => '+39 338 112 5543', 'cargo' => 'Customer Success Manager',    'departamento' => 'Atención al cliente',  'biografia' => 'Gestiona la relación postventa con grandes cuentas.'],
            'm.ferrari@techtrack.com'   => ['nombre' => 'Matteo',    'apellidos' => 'Ferrari',            'telefono' => '+39 340 998 7726', 'cargo' => 'R&D Engineer',                'departamento' => 'I+D',                 'biografia' => 'Prototipa soluciones IoT y hardware embebido.'],
            'e.jones@techtrack.com'     => ['nombre' => 'Emily',     'apellidos' => 'Jones',              'telefono' => '+44 7456 789 012', 'cargo' => 'Compliance Officer',          'departamento' => 'Cumplimiento',        'biografia' => 'Audita el cumplimiento GDPR en sistemas internos.'],
            's.brown@techtrack.com'     => ['nombre' => 'Sarah',     'apellidos' => 'Brown',              'telefono' => '+44 7911 654 321', 'cargo' => 'Executive Assistant',         'departamento' => 'Dirección',           'biografia' => 'Asiste a la dirección general y gestiona agendas.'],
            't.williams@techtrack.com'  => ['nombre' => 'Thomas',    'apellidos' => 'Williams',           'telefono' => '+44 7700 112 233', 'cargo' => 'Facilities Coordinator',      'departamento' => 'Servicios Generales', 'biografia' => 'Coordina mantenimiento del edificio y puestos de trabajo.'],
            'c.martin@techtrack.com'    => ['nombre' => 'Camille',   'apellidos' => 'Martin',             'telefono' => '+33 6 11 22 33 44','cargo' => 'Event Planner',               'departamento' => 'Marketing',           'biografia' => 'Organiza eventos corporativos y ferias sectoriales.'],
            'l.bernard@techtrack.com'   => ['nombre' => 'Louise',    'apellidos' => 'Bernard',            'telefono' => '+33 6 55 44 33 22','cargo' => 'Recruiter',                   'departamento' => 'Recursos Humanos',    'biografia' => 'Lidera procesos de selección para perfiles tech.'],
            'p.deboer@techtrack.com'    => ['nombre' => 'Pieter',    'apellidos' => 'de Boer',            'telefono' => '+31 6 9876 5432',  'cargo' => 'Supply Chain Analyst',        'departamento' => 'Logística',           'biografia' => 'Optimiza la cadena de suministro de componentes IT.'],
            'k.jansen@techtrack.com'    => ['nombre' => 'Karin',     'apellidos' => 'Jansen',             'telefono' => '+31 6 1122 3344',  'cargo' => 'Office Administrator',        'departamento' => 'Administración',      'biografia' => 'Administra la oficina de Ámsterdam.'],
            'r.devrij@techtrack.com'    => ['nombre' => 'Ruud',      'apellidos' => 'de Vrij',            'telefono' => '+31 6 5566 7788',  'cargo' => 'Product Owner',               'departamento' => 'Producto',            'biografia' => 'Define el backlog y prioriza funcionalidades de producto.'],
            'j.rodriguez@techtrack.com' => ['nombre' => 'José',      'apellidos' => 'Rodríguez',          'telefono' => '+1 305 555 0233',  'cargo' => 'Account Manager',             'departamento' => 'Ventas',              'biografia' => 'Gestiona cuentas comerciales en el mercado LATAM.'],
            'a.hernandez@techtrack.com' => ['nombre' => 'Ana',       'apellidos' => 'Hernández',          'telefono' => '+1 786 555 0144',  'cargo' => 'Operations Coordinator',      'departamento' => 'Operaciones',         'biografia' => 'Coordina operaciones diarias en la sede de Miami.'],
            'd.gutierrez@techtrack.com' => ['nombre' => 'Diego',     'apellidos' => 'Gutiérrez',          'telefono' => '+54 11 4555 8877', 'cargo' => 'Software Developer',          'departamento' => 'Desarrollo',          'biografia' => 'Desarrolla módulos internos del ERP.'],
            'v.romero@techtrack.com'    => ['nombre' => 'Valentina', 'apellidos' => 'Romero',             'telefono' => '+54 11 3333 2211', 'cargo' => 'Accountant',                  'departamento' => 'Finanzas',            'biografia' => 'Contabilidad general y cierre mensual en BUE.'],
            's.yamamoto@techtrack.com'  => ['nombre' => 'Satoshi',   'apellidos' => 'Yamamoto',           'telefono' => '+81 80 5555 1234', 'cargo' => 'Translator',                  'departamento' => 'Localización',        'biografia' => 'Traduce documentación técnica al japonés.'],
            'k.suzuki@techtrack.com'    => ['nombre' => 'Keiko',     'apellidos' => 'Suzuki',             'telefono' => '+81 90 6789 4321', 'cargo' => 'Administrative Assistant',    'departamento' => 'Administración',      'biografia' => 'Apoyo administrativo en la oficina de Tokio.'],
            'p.torres@techtrack.com'    => ['nombre' => 'Pablo',     'apellidos' => 'Torres Rivas',       'telefono' => '+34 611 432 908',  'cargo' => 'CTO',                         'departamento' => 'Dirección Técnica',   'biografia' => 'Lidera la arquitectura global de infraestructura y desarrollo.'],
            'f.weber@techtrack.com'     => ['nombre' => 'Friedrich', 'apellidos' => 'Weber',              'telefono' => '+49 170 9932 114', 'cargo' => 'IT Operations Manager',       'departamento' => 'Operaciones TI',      'biografia' => 'Coordina operaciones TI para la región DACH.'],
            'r.smith@techtrack.com'     => ['nombre' => 'Rachel',    'apellidos' => 'Smith',              'telefono' => '+44 7700 900 321', 'cargo' => 'Head of IT Governance',       'departamento' => 'Gobernanza TI',       'biografia' => 'Define políticas de seguridad y cumplimiento normativo.'],
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
