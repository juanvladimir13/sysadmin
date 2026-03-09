<?php
/**
 * Ejemplo de manejo de sesiones seguras
 * Basado en las configuraciones de php.md
 */

// 1. Iniciar la sesión con opciones de seguridad (pueden venir de php.ini o pasarse aquí)
// Estas opciones refuerzan lo configurado en php.ini
$sessionOptions = [
  'use_strict_mode' => 1,
  'use_only_cookies' => 1,
  'cookie_httponly' => 1,
  'cookie_secure' => 1, // Cambiar a 0 si no hay SSL/HTTPS todavía
  'cookie_samesite' => 'Lax',
  'sid_length' => 48,
  'sid_bits_per_character' => 6,
  'name' => 'SECURE_SESSID' // Nombre personalizado de la sesión
];

session_start($sessionOptions);

// 2. Regenerar el ID de sesión para prevenir Session Fixation
// Es recomendable hacerlo después de un login exitoso o periódicamente
if (!isset($_SESSION['last_regeneration'])) {
  session_regenerate_id(true);
  $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 300) { // Cada 5 minutos
  session_regenerate_id(true);
  $_SESSION['last_regeneration'] = time();
}

// 3. Ejemplo de uso: Contador de visitas
if (!isset($_SESSION['visits'])) {
  $_SESSION['visits'] = 1;
} else {
  $_SESSION['visits']++;
}

// 4. Datos del usuario (simulado)
if (!isset($_SESSION['user_id'])) {
  $_SESSION['user_id'] = bin2hex(random_bytes(8));
  $_SESSION['role'] = 'invitado';
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configuración de Sesión Segura</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #0f172a;
      color: #e2e8f0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #1e293b;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);
      max-width: 500px;
      width: 100%;
      border: 1px solid #334155;
    }

    h1 {
      color: #38bdf8;
      margin-top: 0;
    }

    .status {
      background-color: #0369a1;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      font-size: 0.875rem;
      display: inline-block;
      margin-bottom: 1rem;
    }

    pre {
      background-color: #000;
      padding: 1rem;
      border-radius: 0.5rem;
      overflow-x: auto;
      font-size: 0.875rem;
      color: #10b981;
    }

    .info {
      border-top: 1px solid #334155;
      mt: 1rem;
      pt: 1rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="status">Sesión Activa</div>
    <h1>Gestión de Sesión</h1>
    <p>Esta página demuestra el inicio de sesión con configuraciones de seguridad robustas.</p>

    <div class="info">
      <p><strong>ID de Sesión:</strong> <code><?php echo session_id(); ?></code></p>
      <p><strong>Visitas en esta sesión:</strong> <?php echo $_SESSION['visits']; ?></p>
      <p><strong>Usuario ID (Temp):</strong> <?php echo $_SESSION['user_id']; ?></p>
    </div>

    <h3>Datos de $_SESSION:</h3>
    <pre><?php print_r($_SESSION); ?></pre>

    <p><small>Las cookies están configuradas como HttpOnly, Secure y SameSite=Lax.</small></p>
  </div>
</body>

</html>