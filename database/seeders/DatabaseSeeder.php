<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\MensajeIncidencia;
use App\Models\Rol;
use App\Models\Sede;
use App\Models\Subcategoria;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // ══════════════════════════════════════════════════
        // 1. Sedes
        // ══════════════════════════════════════════════════
        $sedes = collect([
            ['codigo' => 'BCN', 'nombre' => 'Barcelona',  'zona_horaria' => 'Europe/Madrid'],
            ['codigo' => 'MAD', 'nombre' => 'Madrid',     'zona_horaria' => 'Europe/Madrid'],
            ['codigo' => 'BER', 'nombre' => 'Berlín',     'zona_horaria' => 'Europe/Berlin'],
            ['codigo' => 'YUL', 'nombre' => 'Montreal',   'zona_horaria' => 'America/Montreal'],
        ])->map(fn ($s) => Sede::create($s));

        // ══════════════════════════════════════════════════
        // 2. Roles
        // ══════════════════════════════════════════════════
        $rolAdmin   = Rol::create(['nombre' => 'admin',   'descripcion' => 'Administrador del sistema']);
        $rolGestor  = Rol::create(['nombre' => 'gestor',  'descripcion' => 'Gestor de incidencias']);
        $rolTecnico = Rol::create(['nombre' => 'tecnico', 'descripcion' => 'Técnico de soporte']);
        $rolCliente = Rol::create(['nombre' => 'cliente', 'descripcion' => 'Usuario cliente']);

        // ══════════════════════════════════════════════════
        // 3. Usuarios  (contraseña: "password" para todos)
        // ══════════════════════════════════════════════════
        $admin = User::create([
            'sede_id'    => $sedes[0]->id,
            'rol_id'     => $rolAdmin->id,
            'nombre'     => 'Admin Principal',
            'correo'     => 'admin@incitech.com',
            'contrasena' => 'password',
            'activo'     => true,
        ]);
        $admin->perfil()->create(['nombre' => 'Admin', 'apellidos' => 'Principal', 'cargo' => 'Administrador']);

        $gestor = User::create([
            'sede_id'    => $sedes[0]->id,
            'rol_id'     => $rolGestor->id,
            'nombre'     => 'Laura Martínez',
            'correo'     => 'l.martinez@incitech.com',
            'contrasena' => 'password',
            'activo'     => true,
        ]);
        $gestor->perfil()->create(['nombre' => 'Laura', 'apellidos' => 'Martínez López', 'cargo' => 'Gestora de incidencias', 'departamento' => 'Soporte']);

        $tecnico1 = User::create([
            'sede_id'    => $sedes[0]->id,
            'rol_id'     => $rolTecnico->id,
            'nombre'     => 'Carlos Ruiz',
            'correo'     => 'c.ruiz@incitech.com',
            'contrasena' => 'password',
            'activo'     => true,
        ]);
        $tecnico1->perfil()->create(['nombre' => 'Carlos', 'apellidos' => 'Ruiz Gómez', 'cargo' => 'Técnico de redes', 'departamento' => 'Infraestructura']);

        $tecnico2 = User::create([
            'sede_id'    => $sedes[2]->id,
            'rol_id'     => $rolTecnico->id,
            'nombre'     => 'Anna Schmidt',
            'correo'     => 'a.schmidt@incitech.com',
            'contrasena' => 'password',
            'activo'     => true,
        ]);
        $tecnico2->perfil()->create(['nombre' => 'Anna', 'apellidos' => 'Schmidt', 'cargo' => 'Técnica de software', 'departamento' => 'Desarrollo']);

        $cliente1 = User::create([
            'sede_id'    => $sedes[0]->id,
            'rol_id'     => $rolCliente->id,
            'nombre'     => 'Juan Pérez',
            'correo'     => 'j.perez@incitech.com',
            'contrasena' => 'password',
            'activo'     => true,
        ]);
        $cliente1->perfil()->create(['nombre' => 'Juan', 'apellidos' => 'Pérez García', 'departamento' => 'Contabilidad']);

        $cliente2 = User::create([
            'sede_id'    => $sedes[1]->id,
            'rol_id'     => $rolCliente->id,
            'nombre'     => 'María López',
            'correo'     => 'm.lopez@incitech.com',
            'contrasena' => 'password',
            'activo'     => true,
        ]);
        $cliente2->perfil()->create(['nombre' => 'María', 'apellidos' => 'López Fernández', 'departamento' => 'Recursos Humanos']);

        $cliente3 = User::create([
            'sede_id'    => $sedes[3]->id,
            'rol_id'     => $rolCliente->id,
            'nombre'     => 'Marc Dupont',
            'correo'     => 'm.dupont@incitech.com',
            'contrasena' => 'password',
            'activo'     => true,
        ]);
        $cliente3->perfil()->create(['nombre' => 'Marc', 'apellidos' => 'Dupont', 'departamento' => 'Marketing']);

        // ══════════════════════════════════════════════════
        // 4. Categorías y subcategorías
        // ══════════════════════════════════════════════════
        $catHardware = Categoria::create(['nombre' => 'Hardware']);
        Subcategoria::create(['categoria_id' => $catHardware->id, 'nombre' => 'Ordenador de sobremesa']);
        Subcategoria::create(['categoria_id' => $catHardware->id, 'nombre' => 'Portátil']);
        Subcategoria::create(['categoria_id' => $catHardware->id, 'nombre' => 'Impresora']);
        $subMonitor = Subcategoria::create(['categoria_id' => $catHardware->id, 'nombre' => 'Monitor / Pantalla']);

        $catSoftware = Categoria::create(['nombre' => 'Software']);
        $subSO = Subcategoria::create(['categoria_id' => $catSoftware->id, 'nombre' => 'Sistema operativo']);
        $subCorreo = Subcategoria::create(['categoria_id' => $catSoftware->id, 'nombre' => 'Correo electrónico']);
        Subcategoria::create(['categoria_id' => $catSoftware->id, 'nombre' => 'Suite ofimática']);
        $subERP = Subcategoria::create(['categoria_id' => $catSoftware->id, 'nombre' => 'ERP / Aplicación interna']);

        $catRed = Categoria::create(['nombre' => 'Redes y conectividad']);
        $subVPN = Subcategoria::create(['categoria_id' => $catRed->id, 'nombre' => 'VPN']);
        $subWifi = Subcategoria::create(['categoria_id' => $catRed->id, 'nombre' => 'Wi-Fi']);
        Subcategoria::create(['categoria_id' => $catRed->id, 'nombre' => 'Acceso a recursos compartidos']);

        $catSeguridad = Categoria::create(['nombre' => 'Seguridad']);
        Subcategoria::create(['categoria_id' => $catSeguridad->id, 'nombre' => 'Antivirus']);
        $subPermisos = Subcategoria::create(['categoria_id' => $catSeguridad->id, 'nombre' => 'Permisos de acceso']);

        $catOtros = Categoria::create(['nombre' => 'Otros']);
        $subOtros = Subcategoria::create(['categoria_id' => $catOtros->id, 'nombre' => 'Consulta general']);

        // ══════════════════════════════════════════════════
        // 5. Incidencias  (7 incidencias variadas)
        // ══════════════════════════════════════════════════
        $ahora = Carbon::now();

        // INC-1: Cerrada
        $inc1 = Incidencia::create([
            'codigo'           => 'BCN-2026-000001',
            'sede_id'          => $sedes[0]->id,
            'cliente_id'       => $cliente1->id,
            'gestor_id'        => $gestor->id,
            'tecnico_id'       => $tecnico1->id,
            'categoria_id'     => $catRed->id,
            'subcategoria_id'  => $subVPN->id,
            'titulo'           => 'No puedo conectar a la VPN desde casa',
            'descripcion'      => 'Desde ayer por la tarde la VPN corporativa da error de timeout al intentar conectar. He reiniciado el router y el problema persiste.',
            'prioridad'        => 'alta',
            'estado'           => 'cerrada',
            'reportado_en'     => $ahora->copy()->subDays(10),
            'asignado_en'      => $ahora->copy()->subDays(10)->addHours(2),
            'resuelto_en'      => $ahora->copy()->subDays(9),
            'cerrado_en'       => $ahora->copy()->subDays(8),
        ]);

        // INC-2: En progreso
        $inc2 = Incidencia::create([
            'codigo'           => 'BCN-2026-000002',
            'sede_id'          => $sedes[0]->id,
            'cliente_id'       => $cliente1->id,
            'gestor_id'        => $gestor->id,
            'tecnico_id'       => $tecnico1->id,
            'categoria_id'     => $catHardware->id,
            'subcategoria_id'  => $subMonitor->id,
            'titulo'           => 'Monitor secundario parpadea',
            'descripcion'      => 'El monitor de la derecha parpadea cada pocos segundos. Modelo Dell U2723QE. Ya he probado con otro cable HDMI.',
            'prioridad'        => 'media',
            'estado'           => 'en_progreso',
            'reportado_en'     => $ahora->copy()->subDays(3),
            'asignado_en'      => $ahora->copy()->subDays(3)->addHours(4),
        ]);

        // INC-3: Sin asignar
        $inc3 = Incidencia::create([
            'codigo'           => 'MAD-2026-000001',
            'sede_id'          => $sedes[1]->id,
            'cliente_id'       => $cliente2->id,
            'gestor_id'        => null,
            'tecnico_id'       => null,
            'categoria_id'     => $catSoftware->id,
            'subcategoria_id'  => $subCorreo->id,
            'titulo'           => 'Outlook no sincroniza la bandeja de entrada',
            'descripcion'      => 'Desde esta mañana Outlook muestra "desconectado" y no recibo correos nuevos. Mis compañeros sí los reciben.',
            'prioridad'        => 'alta',
            'estado'           => 'sin_asignar',
            'reportado_en'     => $ahora->copy()->subHours(5),
        ]);

        // INC-4: Asignada
        $inc4 = Incidencia::create([
            'codigo'           => 'BER-2026-000001',
            'sede_id'          => $sedes[2]->id,
            'cliente_id'       => $tecnico2->id, // un técnico también puede ser cliente
            'gestor_id'        => $gestor->id,
            'tecnico_id'       => $tecnico1->id,
            'categoria_id'     => $catSoftware->id,
            'subcategoria_id'  => $subERP->id,
            'titulo'           => 'Error 500 al generar informes en el ERP',
            'descripcion'      => 'Al pulsar en Informes > Trimestral, la aplicación devuelve un error 500. Adjunto captura de pantalla.',
            'prioridad'        => 'alta',
            'estado'           => 'asignada',
            'reportado_en'     => $ahora->copy()->subDays(1),
            'asignado_en'      => $ahora->copy()->subDays(1)->addHours(1),
        ]);

        // INC-5: Resuelta
        $inc5 = Incidencia::create([
            'codigo'           => 'BCN-2026-000003',
            'sede_id'          => $sedes[0]->id,
            'cliente_id'       => $cliente1->id,
            'gestor_id'        => $gestor->id,
            'tecnico_id'       => $tecnico1->id,
            'categoria_id'     => $catRed->id,
            'subcategoria_id'  => $subWifi->id,
            'titulo'           => 'Wi-Fi de la sala de reuniones no funciona',
            'descripcion'      => 'La red Wi-Fi "InciTech-Guest" de la sala B3 no tiene conexión a Internet.',
            'prioridad'        => 'baja',
            'estado'           => 'resuelta',
            'reportado_en'     => $ahora->copy()->subDays(5),
            'asignado_en'      => $ahora->copy()->subDays(5)->addHours(1),
            'resuelto_en'      => $ahora->copy()->subDays(4),
        ]);

        // INC-6: Sin asignar, prioridad baja
        $inc6 = Incidencia::create([
            'codigo'           => 'YUL-2026-000001',
            'sede_id'          => $sedes[3]->id,
            'cliente_id'       => $cliente3->id,
            'gestor_id'        => null,
            'tecnico_id'       => null,
            'categoria_id'     => $catSeguridad->id,
            'subcategoria_id'  => $subPermisos->id,
            'titulo'           => 'Necesito acceso a la carpeta compartida de Marketing',
            'descripcion'      => 'Me han trasladado al departamento de Marketing y necesito permisos de lectura/escritura en \\\\server\\marketing.',
            'prioridad'        => 'baja',
            'estado'           => 'sin_asignar',
            'reportado_en'     => $ahora->copy()->subHours(2),
        ]);

        // INC-7: En progreso
        $inc7 = Incidencia::create([
            'codigo'           => 'MAD-2026-000002',
            'sede_id'          => $sedes[1]->id,
            'cliente_id'       => $cliente2->id,
            'gestor_id'        => $gestor->id,
            'tecnico_id'       => $tecnico2->id,
            'categoria_id'     => $catSoftware->id,
            'subcategoria_id'  => $subSO->id,
            'titulo'           => 'Pantalla azul aleatoria (BSOD)',
            'descripcion'      => 'Mi portátil muestra pantalla azul 2-3 veces al día. Error: KERNEL_DATA_INPAGE_ERROR. Modelo Lenovo ThinkPad T14s.',
            'prioridad'        => 'alta',
            'estado'           => 'en_progreso',
            'reportado_en'     => $ahora->copy()->subDays(2),
            'asignado_en'      => $ahora->copy()->subDays(2)->addHours(3),
        ]);

        // ══════════════════════════════════════════════════
        // 6. Mensajes en incidencias
        // ══════════════════════════════════════════════════

        // Mensajes en INC-1 (cerrada, conversación completa)
        MensajeIncidencia::create([
            'incidencia_id' => $inc1->id,
            'usuario_id'    => $tecnico1->id,
            'cuerpo'        => 'Hola Juan, voy a revisar la configuración del servidor VPN. ¿Puedes indicarme qué cliente VPN utilizas y la versión?',
            'created_at'    => $ahora->copy()->subDays(10)->addHours(3),
        ]);
        MensajeIncidencia::create([
            'incidencia_id' => $inc1->id,
            'usuario_id'    => $cliente1->id,
            'cuerpo'        => 'Uso FortiClient versión 7.2.3 en Windows 11.',
            'created_at'    => $ahora->copy()->subDays(10)->addHours(4),
        ]);
        MensajeIncidencia::create([
            'incidencia_id' => $inc1->id,
            'usuario_id'    => $tecnico1->id,
            'cuerpo'        => 'Encontré el problema: había una regla de firewall que bloqueaba las conexiones desde tu subred. Ya está corregido. ¿Puedes probar ahora?',
            'created_at'    => $ahora->copy()->subDays(9)->addHours(1),
        ]);
        MensajeIncidencia::create([
            'incidencia_id' => $inc1->id,
            'usuario_id'    => $cliente1->id,
            'cuerpo'        => '¡Funciona perfectamente! Muchas gracias, Carlos.',
            'created_at'    => $ahora->copy()->subDays(9)->addHours(3),
        ]);

        // Mensajes en INC-2 (en progreso)
        MensajeIncidencia::create([
            'incidencia_id' => $inc2->id,
            'usuario_id'    => $tecnico1->id,
            'cuerpo'        => 'He solicitado un monitor de repuesto al almacén. En cuanto llegue, pasaré a sustituirlo.',
            'created_at'    => $ahora->copy()->subDays(2),
        ]);

        // Mensajes en INC-4 (asignada)
        MensajeIncidencia::create([
            'incidencia_id' => $inc4->id,
            'usuario_id'    => $gestor->id,
            'cuerpo'        => 'He asignado esta incidencia a Carlos. Es un error del módulo de informes del ERP, puede requerir actualización.',
            'created_at'    => $ahora->copy()->subDays(1)->addHours(1),
        ]);

        // Mensajes en INC-7 (en progreso)
        MensajeIncidencia::create([
            'incidencia_id' => $inc7->id,
            'usuario_id'    => $tecnico2->id,
            'cuerpo'        => 'El error KERNEL_DATA_INPAGE_ERROR suele estar relacionado con el disco duro. Voy a ejecutar un diagnóstico remoto.',
            'created_at'    => $ahora->copy()->subDays(1)->addHours(5),
        ]);
        MensajeIncidencia::create([
            'incidencia_id' => $inc7->id,
            'usuario_id'    => $cliente2->id,
            'cuerpo'        => 'De acuerdo, ¿necesitas que deje el portátil encendido esta noche?',
            'created_at'    => $ahora->copy()->subDays(1)->addHours(6),
        ]);
        MensajeIncidencia::create([
            'incidencia_id' => $inc7->id,
            'usuario_id'    => $tecnico2->id,
            'cuerpo'        => 'Sí, por favor. Déjalo conectado a la red y encendido. Lanzaré el diagnóstico a las 22:00.',
            'created_at'    => $ahora->copy()->subDays(1)->addHours(7),
        ]);
    }
}
