import pika
import json
import Services.services as service
import os
from calendar import timegm
from time import gmtime
import uuid
import time
connection = None

uid = ''

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
            rout = os.path.join('output', str(epoch))
        # Creacion del directorio objetivo
        # Si no existe la carpeta 'epoch'
        if not os.path.isdir(os.path.join('..', 'repository', project, 'output', str(epoch))):
            # Si no existe la carpeta 'output', en caso de primera ejecución
            if not os.path.isdir(os.path.join('..', 'repository', project, 'output')):
                os.mkdir(os.path.join('..', 'repository', project, 'output'))
            os.mkdir(os.path.join('..', 'repository', project, 'output', str(epoch)))

        # Definicion de la ruta de obtencion del archivo.
        rout = os.path.join('..', 'repository', project, rout, _input)

        # Definicion del nombre y la ruta de guardado del archivo.
        output_route = os.path.join('..', 'repository', project, 'output', str(epoch))
        output_name = 'clean_' + str(proc['id']) + '.csv'

        # Dado que proc no se None, obtiene la tarea de este.
        task = proc['task']
        # Llama la tarea correspondiente a la tarea especificada.
        if task['name'] == 'cleaner':
            task['inicio'] = time.time()
            print('Cleaning...')
            c = service.Cleaner(rout, os.path.join(output_route, output_name), task['params'])
            del c
            task['termino'] = time.time()
            # Adjunta el nombre del archivo generado al json, en el campo 'output'
            task['output'] = output_name
            # Reemplaza la variable _input con el valor de output, en caso de que existiese una tarea hija
            _input = output_name
            print(_input)
        if task['name'] == 'replace':
            task['inicio'] = time.time()
            print('Replacing...')
            output_name = 'replace_' + str(proc['id']) + '.csv'
            r = service.Replacer(rout, os.path.join(output_route, output_name), project, task['params'])
            del r
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if task['name'] == 'spellcheck':
            task['inicio'] = time.time()
            print('Spellchecking...')
            output_name = 'spellcheck_' + str(proc['id']) + '.csv'
            s = service.SpellChecker(rout, os.path.join(output_route, output_name), project, task['params'])
            del s
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if task['name'] == 'word2vec':
            task['inicio'] = time.time()
            print('Creating Word2Vec...')
            output_name = 'word2vec_' + str(proc['id']) + '.csv'
            s = service.Word2Vec(rout, os.path.join(output_route, output_name), task['params'])
            del s
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if task['name'] == 'svm_model':
            task['inicio'] = time.time()
            print('Creating SVM model...')
            output_name = 'svm_' + str(proc['id']) + '.csv'
            s = service.SVM(rout, os.path.join(output_route, output_name), task['params'])
            del s
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if task['name'] == 'mnb_model':
            task['inicio'] = time.time()
            print('Creating Multinomial NB model...')
            output_name = 'mnb_' + str(proc['id']) + '.csv'
            s = service.MultinomialNB(rout, os.path.join(output_route, output_name), task['params'])
            del s
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if task['name'] == 'mlp_model':
            task['inicio'] = time.time()
            print('Creating MLP Network model...')
            output_name = 'mlp_' + str(proc['id']) + '.csv'
            s = service.MLPClassifier(rout, os.path.join(output_route, output_name), task['params'])
            del s
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if task['name'] == 'cluster':
            task['inicio'] = time.time()
            print('Clustering...')
            output_name = 'hcluster_' + str(proc['id']) + '.csv'
            s = service.HierarchicClustering(rout, os.path.join(output_route, output_name), task['params'])
            del s
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if task['name'] == 'extract_cluster':
            task['inicio'] = time.time()
            print('Extracting clusters...')
            output_name = 'clusterextract_' + str(proc['id']) + '.csv'
            s = service.ClusterExtractor(rout, os.path.join(output_route, output_name), task['params'])
            del s
            task['termino'] = time.time()
            task['output'] = output_name
            _input = output_name
            print(_input)
        if 'children' in proc:
            # Si existen hijos, se llama a si misma, con el nuevo _input como _input y con el subjson del hijo como proc
            for child in proc['children']:
                process(child, epoch, project, _input, False)

        return proc


def send(message, uid):
    body = {
        'id': uid,
        'message': message
    }

    try:
        # Establece la conexión con el servidor RabbitMQ.
        reply_connection = pika.BlockingConnection(pika.ConnectionParameters(host='localhost'))
    except Exception as e:
        print("Error de conexion", e)
        exit(2)

    reply_channel = reply_connection.channel()

    reply_channel.queue_declare(queue='reply')

    reply_channel.basic_publish(exchange='',
                          routing_key='reply',
                          body=json.dumps(body))
    reply_connection.close()

def callback(ch, method, props, bodys):
    """
    callback se encarga de manejar las entradas y salidas entre el servidor y el cliente.
    :param ch:
    :param method:
    :param props:
    :param body: json recibido del cliente.
    :return: nada
    """
    if bodys:

        uid = str(uuid.uuid4())

        response = {
            'result': 'processing',
            'data': {
                'id_execution': uid
            }
        }

        try:
            body = json.loads(bodys)
            _input = body['input']
            project = body['project']

            response = json.dumps(response)

            ch.basic_publish(exchange='',
                             routing_key=props.reply_to,
                             properties=pika.BasicProperties(correlation_id=props.correlation_id),
                             body=response)
            ch.basic_ack(delivery_tag=method.delivery_tag)

            for proc in body['processes']:
                process(proc, timegm(gmtime()), project, _input, True)
            print('Listo')

            send(body, uid)

        except json.decoder.JSONDecodeError as err:
            print('ERRRRRRRRROOOOOOOOOOORRRRRRRRRR')
            response = {
                'result': 'error',
                'message': err.msg
            }
            response = json.dumps(response)

            ch.basic_publish(exchange='',
                             routing_key=props.reply_to,
                             properties=pika.BasicProperties(correlation_id=props.correlation_id),
                             body=response)
            ch.basic_ack(delivery_tag=method.delivery_tag)



    else:
        print('json esta vacio')


channel.basic_qos(prefetch_count=1)
channel.basic_consume(callback,
                      queue='tasks')

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()
