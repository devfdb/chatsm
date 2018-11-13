import pika
import json
import Services.service as service

connection = pika.BlockingConnection(pika.ConnectionParameters(
        host='localhost'))
channel = connection.channel()

channel.queue_declare(queue='tasks')

def process(proc, input):
        if proc:
            task = proc['task']
            if task['name'] == 'clean':
                print('Cleaning...')
                output = 'clean_' + str(proc['id']) + '.csv'
        #       c = service.Cleaner(input, output, process['params'])
        #       del c
                task['output'] = output
                input = output
                print(input)
            if task['name'] == 'replace':
                print('Replacing...')
                output = 'replace_' + str(proc['id']) + '.csv'
        #       r = service.Replacer(input, output, process['params'])
        #       del r
                task['output'] = output
                input = output
                print(input)
            if task['name'] == 'spellcheck':
                print('Spellchecking...')
                output = 'spellcheck_' + str(proc['id']) + '.csv'
        #       s = service.SpellChecker(input, output, process['params'])
        #       del s
                task['output'] = output
                input = output
                print(input)
            try:
                for child in proc['children']:
                    process(child, input)
            except KeyError:
                return proc


def callback(ch, method, props, body):
    body = json.loads(body)
    input = body['input']
    print(input)
    for proc in body['processes']:
        process(proc, input)
    print('Listo')
    
    ch.basic_publish(exchange='',
                     routing_key=props.reply_to,
                     properties=pika.BasicProperties(correlation_id = props.correlation_id),
                     body=json.dumps(body))
    ch.basic_ack(delivery_tag = method.delivery_tag)

channel.basic_qos(prefetch_count=1)
channel.basic_consume(callback,
                      queue='tasks')

print(' [*] Waiting for messages. To exit press CTRL+C')
channel.start_consuming()