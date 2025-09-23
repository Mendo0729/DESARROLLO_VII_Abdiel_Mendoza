Sistema de Gestión de Estudiantes - TALLER 5

Un sistema completo de gestión académica desarrollado en PHP que permite administrar información de estudiantes, sus calificaciones y generar reportes estadísticos.

Características Principales

Gestión de Estudiantes
- Registro completo: ID, nombre, edad, carrera y materias con calificaciones
- Validación automática: Edades entre 16-100 años, calificaciones 0-100
- Sistema de flags: Detección automática de estudiantes en "honor roll" o "en riesgo académico"
- Búsqueda inteligente: Por nombre o carrera (búsqueda parcial e insensible a mayúsculas)

Reportes y Estadísticas
- Promedio general de todos los estudiantes
- Ranking automático ordenado por promedio
- Mejor estudiante del sistema
- Estadísticas por carrera: número de estudiantes, promedio y mejor estudiante
- Reporte por materias: promedio, calificación máxima y mínima por materia
- Sistema de graduación para mover estudiantes a lista de graduados

Persistencia de Datos
- Guardado en JSON: Exporta todos los datos del sistema
- Carga desde JSON: Importa estudiantes previamente guardados
- Formato legible: Archivos JSON con formato pretty-print

