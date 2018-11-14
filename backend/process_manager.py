import pika
import json
import Services.services as service
import os
from calendar import timegm
from time import gmtime
connection = None

try:
    # Establece la conexión con el servidor RabbitMQ.
    connection = pika.BlockingConnection(pika.ConnectionParameters(host='localhost'))
except Exception as e:
    print("Error de conexion", e)
    exit(2)
channel = connection.channel()

channel.queue_declare(queue='tasks')


def process(proc, epoch, project, _input, first):
    """
    Función iterativa que invoca todos los procesos solicitados desde el json de entrada.
    :param proc: json con los procesos
    :param epoch: String con la dirección unica para el nuevo directorio de salida
    :param project: String con el nombre del proyecto.
    :param _input: String con la ruta relativa del archivo
    :param first: boolean que confirma la primera ejecución.
    :return: json basado en proc, con los nombres de los archivos generados.
    """
    if proc:
        # Manejo de si es padre, determinando la carpeta de obtencion de archivo.
        if first:
            rout = 'input'
        else:
            rout = 'output'
        # Definicion de la ruta de obtencion del archivo.
        rout = os.path.join('..', 'repository', project, rout, _input)

        # Definicion de la ruta de guardado del archivo.
        output = os.path.join('..', 'repository', project, 'output', epoch, 'clean_' + str(proc['id']) + '.csv')

        # Dado que proc no se None, obtiene la tarea de este.
        task = proc['task']
        # Llama la tarea correspondiente a la tarea especificada.
        if task['name'] == 'clean':
            print('Cleaning...')
            c = service.Cleaner(rout, output, task['params'])
            del c
            # Adjunta el nombre del archivo generado al json, en el campo 'output'
            task['output'] = output
            # Reemplaza la variable _input con el valor de output, en caso de que existiese una tarea hija
            _input = output
            print(_input)
        if task['name'] == 'replace':
            print(os.getcwd())
            print('Replacing...')
            output = 'replace_' + str(proc['id']) + '.csv'
            r = service.Replacer(rout, output, task['params'])
            del r
            task['output'] = output
            _input = output
            print(_input)
        if task['name'] == 'spellcheck':
            print('Spellchecking...')
            output = 'spellcheck_' + str(proc['id']) + '.csv'
            s = service.SpellChecker(rout, output, task['params'])
            del s
            task['output'] = output
            _input = output
            print(_input)
        if 'children' in proc:
            # Si existen hijos, se llama a si misma, con el nuevo _input como _input y con el subjson del hijo como proc
            for child in proc['children']:
                process(child, epoch, project, _input, False)
        return proc


def callback(ch, method, props, body):
    """
    callback se encarga de manejar las entradas y salidas entre el servidor y el cliente.
    :param ch:
    :param method:
    :param props:
    :param body: json recibido del cliente.
    :return: nada
    """
    body = json.loads(body)
    _input = body['input']
    project = body['project']
    print(_input)
    for proc in body['processes']:
        process(proc, timegm(gmtime()), project, _input, True)
    print('Listo')
    
    ch.basic_publish(exchange='',
                     routing_key=props.reply_to,
                     properties=pika.BasicProperties(correlation_id=props.correlation_id),
                     body=json.dumps(body))
    ch.basic_ack(delivery_tag=method.delivery_tag)


channel.basic_qos(prefetch_count=1)
channel.basic_consume(callback,
                      queue='tasks')

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()
