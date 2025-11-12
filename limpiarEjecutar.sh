#!/bin/bash

echo "🚀 Iniciando limpieza y optimización de Laravel..."

# 1. Limpiar la caché de la aplicación (cache:clear)
echo "🗑️ Limpiando la caché de la aplicación..."
php artisan cache:clear

# 2. Limpiar config
echo "🛠️ Limpiando y regenerando la caché de configuración..."
php artisan config:clear

# 3. Limpiar las rutas
echo "🛣️ Limpiando y regenerando la caché de rutas..."
php artisan route:clear

# 4. Limpiar las vistas
echo "👁️ Limpiando y regenerando la caché de vistas..."
php artisan view:clear

# 5. Optimizar el cargador de clases de Composer (optimize)
# Este comando mejora el rendimiento al mapear las clases
echo "✨ Optimizando el cargador de clases (Autoload)..."
php artisan optimize:clear

#ejecutar npm run dev
npm run dev


