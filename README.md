# Trabajo de fin de grado: Desarrollo de Aplicaciones Web
## Javier López Carretero

### Nombre de la aplicación
EventGo

### ¿En que consiste?
Se trata de una aplicación que puede ser usada por cualquier persona o empresa para crear eventos para poder darles visibilidad
a todo el mundo de manera cómoda, rápida y sencilla. Los usuarios podrán ver estos eventos y confirmar si van a asistir al evento
anunciado. Para cada evento se incluyen datos cómo por ejemplo el nombre, que día y a que hora es, una breve descripción y otras
cosas más.

### Arquitectura implementada
El proyecto sigue el patrón modelo vista controlador y trata un poco de acercarse a lo que hace un framework cómo Laravel

### Funcionalidades:
- Buscador de eventos para que el usuario pueda buscar eventos por nombre
- Registro e inicio de sesión
- Listado de eventos con scroll vertical y con filtrado de categorías
- Perfil de usuario donde puede editar sus datos y ver los eventos que ha creado
- El usuario tiene la posibilidad de elegir si va a asistir a un evento, si todavía no lo sabe o si no va a asistir.
- Implementación de un backoffice para controlar las tablas de usuarios y eventos
- Implementación de un sistema de baneo (se pueden desactivar usuarios y eventos)

### Requisitos para ejecutar en local
- PHP 7.4 o superior (recomendado PHP 8.0)
- Servidor de aplicaciones para poder ejecutar código PHP (XAMPP, LAMP o otros)
