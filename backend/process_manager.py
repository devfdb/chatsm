import pika
import json
import Services.services as service
import os
from calendar import timegm
from time import gmtime
import uuid
import time

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
    :param proc: json con un arbol o sub_arbol de tareas. Solo toma el superior en una iteración.
    :param epoch: String con la dirección unica para el nuevo directorio de salida
    :param project: String con el nombre del proyecto.
    :param _input: String con la ruta relativa del archivo
    :param first: boolean que confirma la primera ejecución.
    :return: json basado en proc, con los nombres de los archivos generados.
    """

    base_input_route = ''     # Nominal. Primera ruta esta vacia.
    repository_route = os.path.join('..', 'repository')
    # base_extra_files_route = os.path.join(repository_route, project, 'input')
    # Placeholder. Ruta a usar con parametros
    base_output_route = os.path.join(
        repository_route, project, 'output', str(epoch)
    )
    if proc:
        # Manejo de si es padre, determinando la carpeta de obtencion de archivo.
        if first:
            actual_input_route = base_input_route
        else:
            actual_input_route = os.path.join('output', str(epoch))

        # Creacion del directorio de la ejecución actual.
        # Si no existe la carpeta 'epoch'

        if not os.path.isdir(base_output_route):
            # # Se consulta por la carpeta 'output'
            # # Si no existe, en caso de primera ejecución
            # if not os.path.isdir(os.path.join('..', 'repository', project, 'output')):
            #     os.mkdir(os.path.join('..', 'repository', project, 'output'))
            # Lo anterior es deprecado. Al estar ligada la carpeta output a la base de datos, es creada al crear el
            # proyecto.
            os.mkdir(base_output_route)

        # Definicion de la ruta de obtencion del archivo.
        actual_input_file_location = os.path.join(actual_input_route, _input)

        # Dado que proc no se None, obtiene la tarea de este, el nombre del archivo de salida y su ruta completa.
        task = proc['task']
        output_filename = "Tarea_" + str(proc['id']) + ' - ' + task['name']
        output_file_location = os.path.join(base_output_route, output_filename)

        # Del mismo modo, como se sabe el nombre del archivo se pueden fijar parametros para la siguiente iteracion
        task['output'] = output_filename
        children_input = output_filename

        # Llama la tarea correspondiente a la tarea especificada.
        if task['name'] == 'cleaner':
            task['inicio'] = time.time()
            print("Time:", task['inicio'])
            print('Cleaning...')
            c = service.Cleaner(actual_input_file_location, output_file_location, task['params'])
            del c
            task['termino'] = time.time()
        elif task['name'] == 'replace':
            task['inicio'] = time.time()
            print('Replacing...')
            r = service.Replacer(actual_input_file_location, output_file_location, project, task['params'])
            del r
            task['termino'] = time.time()
            # Adjunta el nombre del archivo generado al json, en el campo 'output'
        elif task['name'] == 'spellcheck':
            task['inicio'] = time.time()
            print('Spellchecking...')
            s = service.SpellChecker(actual_input_file_location, output_file_location, project, task['params'])
            del s
            task['termino'] = time.time()
            # Adjunta el nombre del archivo generado al json, en el campo 'output'
        elif task['name'] == 'word2vec':
            task['inicio'] = time.time()
            print('Creating Word2Vec...')
            s = service.Word2Vec(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'svm_model':
            task['inicio'] = time.time()
            print('Creating SVM model...')
            s = service.SVM(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'mnb_model':
            task['inicio'] = time.time()
            print('Creating Multinomial NB model...')
            s = service.MultinomialNB(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'mlp_model':
            task['inicio'] = time.time()
            print('Creating MLP Network model...')
            s = service.MLPClassifier(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'cluster':
            task['inicio'] = time.time()
            print('Clustering...')
            s = service.HierarchicClustering(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'extract_cluster':
            task['inicio'] = time.time()
            print('Extracting clusters...')
            s = service.ClusterExtractor(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'ner_trainer':
            task['inicio'] = time.time()
            print('Training NER...')
            s = service.NERTrainer(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'ner_training_generator':
            task['inicio'] = time.time()
            print('Generating Training...')
            s = service.NERTrainingGenerator(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()
        elif task['name'] == 'pos_tagger_trainer':
            task['inicio'] = time.time()
            print('Training POS-Tagger ...')
            s = service.POStrainer(actual_input_file_location, output_file_location, task['params'])
            del s
            task['termino'] = time.time()

        print("Generated file:", children_input)

        # Finalmente, si existen hijos, se llama a si misma, con el nuevo _input como _input y con el subjson del hijo
        # como tarea a realizar
        if 'children' in proc:
            children_list = []
            # Recorrido como lista ya que hijos en un mismo nivel estan en una lista.
            for child in proc['children']:
                children_list.append(process(child, epoch, project, children_input, False))
            proc['children'] = children_list
            print(proc)
        # Finalmente, lo que retornado es la misma tarea, con información extra.
        return proc


def send(message, unique_id):
    body = {
        'id': unique_id,
        'message': message
    }
    reply_connection = None     # Asignación para consistencia del código.

    try:
        # Establece la conexión con el servidor RabbitMQ.
        reply_connection = pika.BlockingConnection(pika.ConnectionParameters(host='localhost'))
    except Exception as error:
        print("Error de conexion", error)
        exit(2)

    reply_channel = reply_connection.channel()

    reply_channel.queue_declare(queue='reply')

    reply_channel.basic_publish(
        exchange='',
        routing_key='reply',
        body=json.dumps(body)
    )
    reply_connection.close()


def callback(ch, method, props, bodys):
    """
    callback se encarga de manejar las entradas y salidas entre el servidor y el cliente.
    :param ch:  canal de conexión rabbitMQ
    :param method:
    :param props:
    :param bodys: json recibido del cliente.
    :return: nada
    """
    if bodys:

        unique_id = str(uuid.uuid4())

        response = {
            'result': 'processing',
            'data': {
                'id_execution': unique_id
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
            result_list = []
            for proc in body['processes']:
                # Esto deberia asignarse a una variable
                result_list.append(process(proc, timegm(gmtime()), project, _input, True))
            print('Listo')
            body['processes'] = result_list
            send(body, unique_id)

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
        response = {
            'result': 'error',
            'message': 'Json esta vacio'
        }
        response = json.dumps(response)

        ch.basic_publish(exchange='',
                         routing_key=props.reply_to,
                         properties=pika.BasicProperties(correlation_id=props.correlation_id),
                         body=response)
        ch.basic_ack(delivery_tag=method.delivery_tag)
        print('json esta vacio')


channel.basic_qos(prefetch_count=1)
channel.basic_consume(callback,
                      queue='tasks')

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()
