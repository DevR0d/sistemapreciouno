<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instalacion del Proyecto GestionLogisticaPrecioUno Loreto

Requiere de laravel 12, junto con la libreria NodeJs (npm) para la Ejecucion del Proyecto.
por otro lado, es necesario tener instalado lo Siguiente.
- Instalar [PHP 8.3](https://windows.php.net/download#php-8.3).
- Apache [2.4.63-250207 Win64](https://www.apachelounge.com/download/).
- Node.js [v22.14.0](https://nodejs.org/es) y [Composer ](https://getcomposer.org/).
- 7zip [Descargar](https://7-zip.org/download.htmlt).


### **Paso 1**:
Abrir Git Bash y clonar el repositorio remoto, para ello usa el comando: git clone https://github.com/DevR0d/sistemapreciouno.git 
. Te saldra algo asi en la terminal:
###
![imgitbash.png](imgitbash.png)

### **Paso 2**:
Abrir el Terminal del Editor o IDE (VSCode, PHPStorm, etc) y ejecutar "composer install" ó "composer update" dependiendo el caso, espera
a que se complete, despues ejecutar "npm install". te saldra algo asi en la terminal:
####
![img.png](img.png)

### **Paso 3**:
Crear el archivo de configuracion de Laravel ".env" a nivel de proyecto, 
luego copiamos el contenido del archivo ".env.example" y 
pegamos dentro del ".env". auto

### **Paso 4**:
luego creamos la llave Unica de Laravel, se hace con este comando "php artisan key:generate"

### **Paso 5**:
Ejecutar este comando en la terminal "php artisan migrate" aceptamos en "Yes" 
si les pregunta por la creacion de la BD, al fina les visualizara algo asi:.
####
![img_1.png](img_1.png)

### **Paso 6**:
Ejecutar el comando de Registros Permitidos, esto para poblar las tbalas Independientes.
"php artisan db:seed" tiene que visualizarse asi:

![img_2.png](img_2.png)

### **Paso 7**:
para levantar el Proyecto ejecutar este Comando, comando que nos obtiene del NodeJs "npm run dev"

