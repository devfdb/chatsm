import csv
import gensim
import logging

# input_path = Ruta del archivo en que se encuentran guardados los datos
# output_path = Nombre con que se guardará el modelo Word2Vec
# params['count'] = Umbral de frecuencia para extracción de palabras (cantidad de veces que se repiten)
# params['epoch'] = Cantidad de épocas que se realizan para el entrenamiento

class Word2Vec:
    
    data = []
    
    def __init__(self, input_path:str, output_path:str, params:dict):
        self._load_csv(input_path, params)
        self._train_model(output_path, params)
    
    def _load_csv(self, path:str, params:dict):
        if 'frequency' not in params:
            params['frequency'] = 300
        if 'epoch' not in params:
            params['epoch'] = 100
        with open(path, 'r', encoding='utf8') as infile:
            reader = csv.reader(infile)
            self.data = list(reader)
    
    def _train_model(self, path:str, params:dict):
        logging.basicConfig(format='%(asctime)s : %(levelname)s : %(message)s', level=logging.INFO)
        model = gensim.models.Word2Vec(self.data, min_count=params['frequency'])
        model.train(self.data, total_examples=len(self.data), epochs=params['epoch'])
        model.save(path + ".model")