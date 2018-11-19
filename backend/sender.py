import json

task2 = {
    "project": "proy",
    "input": "algo.csv",
    "processes": [{
        "id": 1,
        "task":
        {
            "name": "clean",
            "params": {
            }
        },
        "children": [
            {
                "id": 2,
                "task": {
                    "name": "spellcheck",
                    "params": {
                        "corpus_path": "V1" # ..//repository//proy//input// tiene que ser manejado por ortografia
                    }
                },
                "children": []
            },
            {
                "id": 3,
                "task": {
                    "name": "replace",
                    "params": {
                        "file_path": "remplazo2.csv" # ..//repository//proy//input//
                    }
                },
                "children": []
            }
        ]
    }]
}

task2 = json.dumps(task2)

import pika
import uuid

class FibonacciRpcClient(object):
    def __init__(self):
        self.user = pika.PlainCredentials('guest', 'guest')

        self.connection = pika.BlockingConnection(pika.ConnectionParameters(host='localhost', credentials=self.user))

        self.channel = self.connection.channel()

        result = self.channel.queue_declare(exclusive=True)
        self.callback_queue = result.method.queue

        self.channel.basic_consume(self.on_response, no_ack=True,
                                   queue=self.callback_queue)

    def on_response(self, ch, method, props, body):
        if self.corr_id == props.correlation_id:
            self.response = body

    def call(self, n):
        self.response = None
        self.corr_id = str(uuid.uuid4())
        self.channel.basic_publish(exchange='',
                                   routing_key='tasks',
                                   properties=pika.BasicProperties(
                                         reply_to = self.callback_queue,
                                         correlation_id = self.corr_id,
                                         ),
                                   body=n)
        while self.response is None:
            self.connection.process_data_events()
        return self.response

fibonacci_rpc = FibonacciRpcClient()

print(" [x] Requesting")
response = json.loads(fibonacci_rpc.call(task2))
print(response)