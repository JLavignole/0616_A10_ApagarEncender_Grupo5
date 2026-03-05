<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Incidencia;
use App\Models\Sede;
use App\Models\Subcategoria;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class IncidenciaSeeder extends Seeder
{
    public function run(): void
    {
        // 55 templates: [sede, correo_cliente, categoria, subcategoria, titulo, descripcion, prioridad]
        $templates = [
            // ── SIN_ASIGNAR (8) ──
            ['BCN','a.vidal@techtrack.com','Hardware','Auriculares','Auriculares inalámbricos no se emparejan','Los auriculares Jabra no conectan vía Bluetooth con el portátil asignado.','baja'],
            ['MAD','p.jimenez@techtrack.com','Software','Suite ofimática','Excel se cierra al abrir macros pesadas','Al abrir un libro con macros VBA pesadas, Excel deja de responder y se cierra.','media'],
            ['YUL','m.dupont@techtrack.com','Accesos y permisos','Carpetas compartidas','Acceso denegado al repositorio de marketing','No puedo abrir la carpeta compartida del equipo de marketing en la unidad M:.','media'],
            ['BER','h.fischer@techtrack.com','Redes y conectividad','Wi-Fi','Wi-Fi no disponible en sala de reuniones B3','La red Wi-Fi corporativa no aparece en las redes disponibles de la sala B3.','baja'],
            ['LIS','r.oliveira@techtrack.com','Impresión y escaneado','Impresora de red','Impresora de planta 2 no responde','La impresora HP LaserJet de la segunda planta no acepta trabajos de impresión.','media'],
            ['ROM','a.esposito@techtrack.com','Almacenamiento y backup','Cuota de disco','Cuota de disco agotada en servidor de archivos','Recibo error de espacio insuficiente al guardar documentos en el servidor.','alta'],
            ['MAD','m.lopez@techtrack.com','Software','Correo corporativo','Outlook no sincroniza la bandeja de entrada','No entran correos y la aplicación muestra estado desconectado.','alta'],
            ['LON','e.jones@techtrack.com','Seguridad','Actualizaciones críticas','Aviso persistente de actualización de seguridad','El sistema muestra un aviso de actualización crítica que no se puede instalar.','alta'],

            // ── ASIGNADA (9) ──
            ['MAD','m.lopez@techtrack.com','Software','ERP','Error al generar facturas en el ERP','Al cerrar una factura el sistema devuelve validación y no permite contabilizar.','alta'],
            ['BCN','i.herrera@techtrack.com','Redes y conectividad','DNS','Resolución DNS lenta para servicios internos','Las aplicaciones internas tardan más de 10 s en cargar por problemas DNS.','media'],
            ['PAR','c.martin@techtrack.com','Telefonía y colaboración','Telefonía IP','Teléfono IP no registra en la centralita','El teléfono Yealink del puesto 401 muestra error de registro SIP.','media'],
            ['AMS','p.deboer@techtrack.com','Hardware','Docking station','Docking USB-C no detecta monitores externos','Al conectar el docking Lenovo los dos monitores no reciben señal.','alta'],
            ['MIA','j.rodriguez@techtrack.com','Software','CRM','CRM no carga el módulo de oportunidades','La sección de oportunidades de Salesforce muestra un spinner infinito.','alta'],
            ['BUE','d.gutierrez@techtrack.com','Bases de datos','MySQL','Error de conexión a base de datos de desarrollo','El entorno devuelve Connection refused al conectar a MySQL.','alta'],
            ['LON','s.brown@techtrack.com','Accesos y permisos','Aplicaciones internas','Sin acceso a la intranet tras cambio de contraseña','La intranet pide credenciales continuamente desde que cambié la contraseña.','media'],
            ['BER','m.becker@techtrack.com','Software','Herramientas de diseño','Licencia de Adobe Creative Cloud expirada','Photoshop muestra que la licencia ha expirado y no permite trabajar.','media'],
            ['TOK','s.yamamoto@techtrack.com','Hardware','Portátil','Portátil no arranca tras actualización de BIOS','Tras actualizar firmware el portátil muestra pantalla negra al encender.','alta'],

            // ── EN_PROGRESO (10) ──
            ['BCN','j.perez@techtrack.com','Redes y conectividad','VPN','La VPN corporativa se desconecta cada 10 min','La sesión VPN cae de forma intermitente y obliga a reconectar.','alta'],
            ['BCN','j.perez@techtrack.com','Hardware','Monitor','Monitor externo con parpadeos intermitentes','El monitor parpadea al abrir aplicaciones con uso intensivo de gráficos.','baja'],
            ['MAD','r.castro@techtrack.com','Seguridad','Antivirus','Antivirus bloquea aplicación financiera legítima','El antivirus marca como amenaza la herramienta de reporting y la bloquea.','alta'],
            ['YUL','j.gagnon@techtrack.com','Almacenamiento y backup','Copias de seguridad','Backup nocturno del servidor de archivos falla','El job de backup de las 02:00 falla con timeout desde hace 3 días.','alta'],
            ['LIS','s.pereira@techtrack.com','Software','Suite ofimática','Word no guarda documentos en SharePoint','Al guardar en SharePoint Word muestra error de sincronización.','media'],
            ['ROM','m.ferrari@techtrack.com','Hardware','Portátil','Portátil se sobrecalienta y se apaga solo','El portátil Dell se apaga sin previo aviso tras 30 min de uso intensivo.','alta'],
            ['LON','t.williams@techtrack.com','Impresión y escaneado','Escáner','Escáner produce imágenes borrosas','Las digitalizaciones salen desenfocadas y con líneas horizontales.','baja'],
            ['PAR','l.bernard@techtrack.com','Accesos y permisos','Alta de usuario','Nuevo empleado sin cuenta de dominio','El nuevo empleado de RRHH lleva 3 días sin acceder a ningún sistema.','alta'],
            ['AMS','k.jansen@techtrack.com','Telefonía y colaboración','Microsoft Teams','Compartir pantalla en Teams muestra negro','Los participantes ven pantalla negra al compartir pantalla en Teams.','media'],
            ['MIA','a.hernandez@techtrack.com','Redes y conectividad','Red cableada','Puerto de red del puesto 205 sin conectividad','El puerto Ethernet no establece enlace con el switch.','media'],

            // ── RESUELTA (10) ──
            ['LIS','h.costa@techtrack.com','Seguridad','Phishing','Correo sospechoso solicitando cambio de contraseña','He recibido un email que simula ser del soporte y pide verificar credenciales.','alta'],
            ['LIS','h.costa@techtrack.com','Accesos y permisos','Aplicaciones internas','Sin acceso al módulo de compras','Después de cambiar de puesto no puedo acceder al módulo de aprobaciones.','media'],
            ['BCN','a.vidal@techtrack.com','Software','Herramientas de diseño','Figma no exporta prototipos a PDF','La opción de exportar a PDF genera un archivo vacío de 0 KB.','baja'],
            ['MAD','l.sanchez@techtrack.com','Redes y conectividad','Proxy','Proxy bloquea acceso a portal jurídico','No puedo acceder al BOE ni a bases de datos legales por política del proxy.','media'],
            ['BER','h.fischer@techtrack.com','Hardware','Teclado y ratón','Teclado mecánico con teclas que no responden','Las teclas F5 y Enter del teclado no registran pulsaciones.','baja'],
            ['YUL','l.bouchard@techtrack.com','Impresión y escaneado','Cartuchos y tóner','Tóner bajo pero recién cambiado','Tras sustituir el tóner la impresora sigue indicando nivel bajo.','baja'],
            ['ROM','l.moretti@techtrack.com','Software','CRM','CRM no sincroniza contactos con Outlook','Los contactos del CRM no aparecen en la libreta de Outlook.','media'],
            ['LON','e.jones@techtrack.com','Seguridad','Cifrado de disco','BitLocker pide clave de recuperación al iniciar','Cada arranque BitLocker solicita la clave de recuperación.','alta'],
            ['AMS','r.devrij@techtrack.com','Bases de datos','PostgreSQL','Consultas lentas en base de producción','Las queries del dashboard tardan más de 30 s en responder.','alta'],
            ['BUE','v.romero@techtrack.com','Software','ERP','ERP no genera asientos contables automáticos','Los asientos de amortización mensual no se crean automáticamente.','media'],

            // ── CERRADA (10) ──
            ['ROM','l.moretti@techtrack.com','Telefonía y colaboración','Microsoft Teams','No funciona el audio en llamadas de Teams','El micrófono deja de funcionar tras unos minutos de reunión.','media'],
            ['BCN','j.perez@techtrack.com','Accesos y permisos','Privilegios temporales','Solicitud de permisos de admin temporal','Necesito permisos de administrador local durante 2 horas.','baja'],
            ['MAD','p.jimenez@techtrack.com','Hardware','Impresora','Impresora personal no imprime a doble cara','La opción dúplex no aparece en las propiedades de impresión.','baja'],
            ['BER','m.becker@techtrack.com','Telefonía y colaboración','Videoconferencia','Webcam integrada muestra imagen congelada','La cámara se congela tras 5 minutos de videollamada.','media'],
            ['YUL','m.dupont@techtrack.com','Software','Sistema operativo','Pantalla azul al conectar dispositivo USB','El portátil muestra BSOD al conectar un disco externo USB 3.0.','alta'],
            ['LIS','r.oliveira@techtrack.com','Almacenamiento y backup','Recuperación de archivos','Recuperar archivo borrado accidentalmente','Eliminé por error un informe trimestral del servidor compartido.','alta'],
            ['PAR','c.martin@techtrack.com','Redes y conectividad','Wi-Fi','Wi-Fi del evento corporativo saturada','Durante el evento la red Wi-Fi para invitados se saturó.','media'],
            ['AMS','k.jansen@techtrack.com','Hardware','Monitor','Monitor ultrawide con franja de píxeles muertos','Una franja de 3 px muestra píxeles muertos en el lateral derecho.','media'],
            ['MIA','j.rodriguez@techtrack.com','Seguridad','EDR','Alerta de EDR por proceso sospechoso','El EDR detectó un proceso hijo anómalo desde PowerShell.','alta'],
            ['TOK','k.suzuki@techtrack.com','Accesos y permisos','Baja de usuario','Desactivar cuentas de ex-empleado','Se solicita desactivar todas las cuentas del ex-empleado Taro Ito.','media'],

            // ── REABIERTA (8) ──
            ['BCN','i.herrera@techtrack.com','Software','Correo corporativo','Outlook pierde la firma al responder','La firma desaparece al pulsar Responder, solo aparece al crear correo nuevo.','baja'],
            ['MAD','r.castro@techtrack.com','Hardware','Docking station','Docking station pierde conexión Ethernet','El adaptador de red del docking se desconecta aleatoriamente.','media'],
            ['BER','h.fischer@techtrack.com','Redes y conectividad','VPN','VPN no establece túnel desde Alemania','La conexión VPN falla con error de certificado.','alta'],
            ['LIS','s.pereira@techtrack.com','Impresión y escaneado','Cola de impresión','Trabajos atascados en cola de impresión','La cola muestra 15 trabajos pendientes que no se procesan.','media'],
            ['ROM','a.esposito@techtrack.com','Telefonía y colaboración','Calendario compartido','Calendario no muestra disponibilidad','No veo la disponibilidad de los compañeros al programar reunión.','media'],
            ['LON','s.brown@techtrack.com','Software','Suite ofimática','PowerPoint se cuelga al insertar vídeo','Al insertar un vídeo MP4 de 200 MB PowerPoint deja de responder.','media'],
            ['YUL','j.gagnon@techtrack.com','Seguridad','Antivirus','Antivirus no se actualiza desde hace una semana','Las definiciones están desactualizadas y el servicio no responde.','alta'],
            ['AMS','p.deboer@techtrack.com','Almacenamiento y backup','NAS','NAS departamental inaccesible por red','El NAS Synology dejó de responder y no se puede montar la unidad.','alta'],
        ];

        $estados = array_merge(
            array_fill(0, 8, 'sin_asignar'),
            array_fill(0, 9, 'asignada'),
            array_fill(0, 10, 'en_progreso'),
            array_fill(0, 10, 'resuelta'),
            array_fill(0, 10, 'cerrada'),
            array_fill(0, 8, 'reabierta')
        );

        $comentarios = [
            null, null, null,
            'El problema empezó tras una actualización.',
            'No he hecho cambios recientes.',
            'Urge resolverlo, bloquea mi trabajo.',
            'Ya reinicié el equipo sin éxito.',
        ];

        $numSeq = 100;

        foreach ($templates as $i => $tpl) {
            $sede = Sede::where('codigo', $tpl[0])->firstOrFail();
            $cliente = User::where('correo', $tpl[1])->firstOrFail();
            $categoria = Categoria::where('nombre', $tpl[2])->firstOrFail();
            $subcategoria = Subcategoria::where('categoria_id', $categoria->id)
                ->where('nombre', $tpl[3])->firstOrFail();

            $estado = $estados[$i];
            $numSeq++;
            $codigo = $tpl[0] . '-2026-' . str_pad($numSeq, 6, '0', STR_PAD_LEFT);

            $gestorSede = User::where('sede_id', $sede->id)
                ->whereHas('rol', fn ($q) => $q->where('nombre', 'gestor'))
                ->first();
            $tecnicoSede = User::where('sede_id', $sede->id)
                ->whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))
                ->first();

            if (!$gestorSede) $gestorSede = User::whereHas('rol', fn ($q) => $q->where('nombre', 'gestor'))->first();
            if (!$tecnicoSede) $tecnicoSede = User::whereHas('rol', fn ($q) => $q->where('nombre', 'tecnico'))->first();

            $diasAtras   = rand(1, 30);
            $reportado   = Carbon::now()->subDays($diasAtras);
            $asignado    = null;
            $resuelto    = null;
            $cerrado     = null;
            $gestorId    = null;
            $tecnicoId   = null;

            if (in_array($estado, ['asignada','en_progreso','resuelta','cerrada','reabierta'])) {
                $gestorId  = $gestorSede->id;
                $tecnicoId = $tecnicoSede->id;
                $asignado  = (clone $reportado)->addHours(rand(1, 8));
            }

            if (in_array($estado, ['resuelta','cerrada','reabierta'])) {
                $resuelto = (clone $asignado)->addDays(rand(1, 5));
            }

            if ($estado === 'cerrada') {
                $cerrado = (clone $resuelto)->addDays(rand(1, 3));
            }

            if ($estado === 'reabierta') {
                $resuelto = null;
            }

            Incidencia::create([
                'codigo'             => $codigo,
                'sede_id'            => $sede->id,
                'cliente_id'         => $cliente->id,
                'gestor_id'          => $gestorId,
                'tecnico_id'         => $tecnicoId,
                'categoria_id'       => $categoria->id,
                'subcategoria_id'    => $subcategoria->id,
                'titulo'             => $tpl[4],
                'descripcion'        => $tpl[5],
                'comentario_cliente' => $comentarios[array_rand($comentarios)],
                'prioridad'          => $tpl[6],
                'estado'             => $estado,
                'reportado_en'       => $reportado,
                'asignado_en'        => $asignado,
                'resuelto_en'        => $resuelto,
                'cerrado_en'         => $cerrado,
            ]);
        }
    }
}
