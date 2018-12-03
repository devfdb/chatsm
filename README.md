# ChatSM: Chatbot Support Management

Construye flujos de procesamiento, agregando instancias de tareas fácilmente, gracias al gestor de procesos integrado.

Analiza datos para la construcción de bots conversacionales, con esta plataforma de análisis de datos, donde podrás:

- Agrupamiento de datos basado en cercanía de palabras (Agrupamiento basado en jerarquías).
- Crear bolsas de palabras (bag of words).
- Limpiar datos mediante diversas técnicas de preprocesamiento.
- PRONTO! Generación de gráficos para análisis de datos.

## Cambios

### Version 0.5 (Noviembre 23, 2018)

Primera versión alfa funcional
- Considera la ejecución de procesos simples.
- Creación de instancias basadas en tareas.

## Instalación

Requiere PHP 5.6, Python 3.6 y RabbitMQ, con extensiones extras:

### Instalación en Windows

- Prerequisito: instalación de lenguaje [Erlang](http://erlang.org/download/otp_win64_21.1.exe)
- Instalar [RabbitMQ](https://github.com/rabbitmq/rabbitmq-server/releases/download/v3.7.9/rabbitmq-server-3.7.9.exe)

#### Instalación de entorno PHP

- Instalar [PHP versión 5.6](https://windows.php.net/downloads/releases/php-5.6.38-Win32-VC11-x64.zip)
- Descargar el cliente [php-amqplib](https://windows.php.net/downloads/pecl/releases/amqp/1.4.0/php_amqp-1.4.0-5.6-ts-vc11-x64.zip)
- Copiar y pegar en la carpeta `C:\xampp\php\ext` el archivo `php_amqp.dll`
- Hacer lo mismo con el archivo `rabbitmq.1.dll` en la carpeta `C:\Windows\system32` 

#### Instalación de entorno Python

- Instalar [Python versión 3.6](https://www.python.org/ftp/python/3.6.7/python-3.6.7-amd64-webinstall.exe)
- Ejecutar la siguiente línea de comando para instalar Pika via cmd:

```sh
$ python -m pip install pika
```

#### Ejecución en Windows

Para la versión Windows de RabbitMQ el servicio puede iniciarse y detenerse a través de los accesos directos `RabbitMQ Service - start` y `RabbitMQ Service - stop`.

### Instalación en Linux

Actualizar la lista de repositorios:
```sh
# apt-get update
```

Instalar lenguaje Erlang:
```sh
# apt-get install erlang-nox
```

Instalar cliente RabbitMQ Server:
```sh
# apt-get install rabbitmq-server
```

#### Instalación de entorno PHP

- Ejectuar los siguientes comandos para la instalación de PHP 5.6 con Composer:

```sh
$ php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$ php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
$ php composer-setup.php
$ php -r "unlink('composer-setup.php');"
```

- Instalar las librerías `php-mbstring`, `php-bcmath` y `php-amqplib` (via Composer):

```sh
# apt install php-bcmath
# apt-get install php-mbstring
$ composer require php-amqplib/php-amqplib
```

#### Instalación de entorno Python

- Ejecutar el siguiente comando para instalar Pika:

```sh
$ pip install pika
```

#### Ejecución en Linux

- Reiniciar servidor Apache2:

```sh
# service apache2 restart
```
