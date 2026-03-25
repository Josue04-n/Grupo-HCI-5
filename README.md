# 🧪 UX Lab Analytics: HCI Testing Suite

[![Laravel 11](https://img.shields.io/badge/Framework-Laravel%2011-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Filament v3](https://img.shields.io/badge/Admin-Filament%20v3-EAB308?style=for-the-badge&logo=laravel)](https://filamentphp.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/UI-Tailwind%20CSS-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)
[![Copilot Reviewed](https://img.shields.io/badge/GitHub-Copilot%20Reviewed-24292e?style=for-the-badge&logo=github)](https://github.com/features/copilot)

> **Plataforma avanzada para la gestión de pruebas de usabilidad y análisis de Interacción Humano-Computador (HCI).**

UX Lab Analytics es un ecosistema diseñado para ingenieros y especialistas en UX. Permite gestionar el ciclo de vida completo de una evaluación de interfaces: desde la planificación estratégica hasta la cuantificación de hallazgos técnicos. Optimizado para la comparativa de métricas de eficiencia y eficacia según la norma **ISO 9241-11** (Caso de estudio: Cooperativa JEP vs. Maquita).

---

## 📸 Vista Previa (Preview)

![Dashboard HCI](https://raw.githubusercontent.com/Josue04-n/TowerDefense/main/Captura%20de%20pantalla%202026-03-24%20234248.png)
*Interfaz optimizada con Branding personalizado, navegación agrupada y Widget de Accesibilidad dinámico.*

---

## 🛠️ Características Destacadas

* **Estructura HCI Core:** Gestión integral de planes de prueba, tareas normalizadas y sesiones cronometradas.
* **Panel Administrativo Inteligente:** Interfaz reactiva basada en **Filament PHP**, con menús colapsables y orden lógico de trabajo.
* **Arquitectura de Catálogos:** Control centralizado de Métodos de Evaluación, Severidades y Prioridades de Atención.
* **Filtrado de Alta Precisión:** Segmentación de datos por Participante, Tarea y Aplicativo con lógica de limpieza de duplicados.
* **Inclusión Digital:** Integración nativa del widget **UserWay** mediante Render Hooks para cumplimiento de estándares de accesibilidad.
* **IA Assisted Development:** Código revisado y optimizado mediante **GitHub Copilot** para garantizar las mejores prácticas de arquitectura.

---

## 🏗️ Stack Tecnológico & Arquitectura

El sistema implementa una arquitectura **TALL Stack** de alto rendimiento, ideal para aplicaciones empresariales:

* **Backend:** PHP 8.3 + Laravel 11 (Strict Typing).
* **Frontend:** Filament v3 + Tailwind CSS + Livewire v3.
* **Base de Datos:** MySQL con integridad referencial avanzada y disparadores de catálogos.
* **Análisis de Código:** Revisión asistida por IA (GitHub Copilot) para refactorización y seguridad.

---

## 🚀 Instalación y Despliegue

### Requisitos Técnicos
* **PHP:** `^8.3` (Ruta local: `C:\xampp\php\php.exe`)
* **Composer:** `^2.8.2`
* **Base de Datos:** MySQL / MariaDB

### Guía Paso a Paso
1.  **Clonación del Proyecto:**
    ```bash
    git clone [https://github.com/Josue04-n/Grupo-HCI-5.git](https://github.com/Josue04-n/Grupo-HCI-5.git)
    cd Grupo-HCI-5
    ```

2.  **Gestión de Dependencias:**
    ```bash
    composer install
    ```

3.  **Configuración de Entorno:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Nota: Ajustar las credenciales de base de datos en el archivo `.env`.*

4.  **Despliegue de Esquema y Datos:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Ejecución:**
    ```bash
    php artisan serve
    ```
    🌐 Acceso al Panel: `http://127.0.0.1:8000/admin`

---

## 📈 Roadmap (Próximas Mejoras)
* [ ] **Dashboard Analytics:** Implementación de Gráficos de Eficacia y Eficiencia (Chart Widgets).
* [ ] **Report Engine:** Exportación automatizada de hallazgos en formato PDF/Excel.
* [ ] **Visual Insights:** Módulo de Mapas de Calor (Heatmaps) asociados a Tareas.

---

## 👥 Contribuidores

Agradecemos la dedicación técnica del equipo que ha hecho posible este ecosistema de UX:

* **Josué** - [@Josue04-n](https://github.com/Josue04-n)  
    *Lead Software Architect & HCI Specialist*
* **Alex Reyes** - [@alexJonarey](https://github.com/alexJonarey)  
    *Backend Developer & Database Manager*
* **Bryan Lopez** - [@BryanLopez257](https://github.com/BryanLopez257)  
    *UX/UI Implementation & Frontend Support*
* **Dennis Quisaguano** - [@DennisQuisaguano](https://github.com/DennisQuisaguano)  
    *QA Engineer & HCI Metrics Analyst*
* **GitHub Copilot** - *AI Code Review & Logic Optimization Partner*

---

## 📄 Licencia
Este proyecto se distribuye bajo la licencia **MIT**. Consulte el archivo `LICENSE` para más detalles.

---
Desarrollado con rigor técnico para la optimización de la experiencia de usuario (HCI).
