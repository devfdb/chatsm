from pymongo import MongoClient
import pika
import json
import csv

connection = pika.BlockingConnection(pika.ConnectionParameters(
        host='localhost'))
channel = connection.channel()

channel.queue_declare(queue='db_tasks')


client = MongoClient('localhost',27017)
db = client.proyecto


def load_file(path:str, headers:list, colindex:list):
    collection = db[body['filename']]
    with open(path, 'r', encoding='utf8') as csv_file:
        reader = csv.reader(csv_file)
        for title in headers:



def callback(ch, method, props, body):
    body = json.loads(body)
    input = body['input']
    print(input)
    load_file(body['path'], body['headers'], body['colindex'])

    ch.basic_publish(exchange='',
                     routing_key=props.reply_to,
                     properties=pika.BasicProperties(correlation_id=props.correlation_id),
                     body=json.dumps(body))
    ch.basic_ack(delivery_tag=method.delivery_tag)

channel.basic_qos(prefetch_count=1)
channel.basic_consume(callback,
                      queue='db_tasks')

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()