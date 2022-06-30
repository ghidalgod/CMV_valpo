<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['Successful'] = array(
	//Autentificación
	'AuthLogin' => 'Sesión iniciada con éxito.',
	'AuthLogout' => 'Sesión finalizada con éxito.',
	'AuthActiveSession' => 'Hay una sesión activa.',
	// Ajax
	'Get' => 'Datos obtenidos con éxito.',
	'Remove' => 'Removido con éxito.',
	'Activated' => 'Activado con éxito.',
	'Disabled' => 'Desactivado con éxito.'
);

$lang['Warning'] = array(
	// Generales
	'EmptyText' => 'No se ha ingresado texto.',
	'EmptyIdentifier' => 'El identificador está vacio.',
	'DoesNotExist' => 'No existe.',
	'IncompleteData' => 'No se han ingresado todos los datos requeridos.',
	// Autentificación
	'AuthUserNotFound' => 'El usuario no existe.',
	'AuthIncorrectPassword' => 'La contraseña no coincide con la contraseña del usuario.',
	'AuthUserDisabled' => 'Usuario desactivado.',
	'AuthUnauthorizedUser' => 'El usuario no tiene autorización para iniciar sesión en el sistema.',
	'AuthUnauthorizedGroup' => 'El grupo al que pertenece el usuario no tiene autorización para iniciar sesión en el sistema.',
	'AuthUserAlreadyHasSession' => 'El usuario ya tiene una sesión iniciada.',
	'AuthInactiveSessionSession' => 'No hay ninguna sesión activa.',
	// Ajax
	'NotExist' => 'No existe dato.',
	'Disabled' => 'Dato desactivado.',
	'ActiveReemplazos' => 'No se puede desactivar porque hay Reemplazos activos.'
);

$lang['Error'] = array(
	'MessageDoesNotExist' => 'Mensaje de estado indefinido. Notifique del error al responsable del sistema.',
	//General
	'IncompleteData' => 'No se han ingresado todos los datos requeridos.',
);