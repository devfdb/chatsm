import nltk.tokenize
from nltk import UnigramTagger as ut
from nltk.corpus import conll2002 as conll
from sklearn.externals import joblib
import csv

# input_path = ruta de entrada que contiene las oraciones a utilizar en el modelo
# output_path = ruta de salida del archivo de entrenamiento
# pos_training = ruta del modelo de pos_tagger a utlizar
# entities = ruta dek archivo que contiene las entidades a detectar

class TrainingGenerator:

    tokenz = nltk.tokenize.TweetTokenizer()
    var = []
    uni_tag = None
    totales = []
    done = []
    var_tokens = []  # var_tokens contendra listas de tokens de las entidades

    def __init__(self, input_path, output_path, params):
        self._load_words(params)
        self._load_pos_tagger(params)
        self.tag(input_path)
        self.save(output_path)

    def _load_pos_tagger(self, params):
        self.uni_tag = joblib.load(params['pos_training'])

    def _load_words(self, params):
        with open(params['entities'], 'r', encoding='utf8') as entities:
            reader = csv.reader(entities)
            for entity in reader:
                self.var.append(entity)
            for i in range(0, len(self.var)):  # Instanciado de la lista de contadores
                self.totales.append(0)
            for entity in self.var:  # Instanciado de var_tokens
                entity_tokens = self.tokenz.tokenize(str(entity))
                self.var_tokens.append(entity_tokens)

    def tag(self, input_path):

        sentence = ''
        cont = 0
        nsent = ''

        with open(input_path, 'r', encoding='utf8') as file_csv:
            data_set = csv.reader(file_csv)
            current_intent = "null"
            for idx, row in enumerate(data_set):
                cont += 1
                nsent = 'Sentence: ' + str(cont)
                sentence = self.tokenz.tokenize(row[0])
                sentence = self.uni_tag.tag(sentence)
                for words in sentence:
                    line = [nsent, words[0], words[1], "O"]  # La letra base es O, de "out"
                    self.done.append(line)
                    for i in range(0, len(self.var)):  # Ciclo entre las entidades a detectar
                        if len(self.var_tokens[i]) > self.totales[i]:  # Si se han encontrado algunas palabras de una entidad
                            if words[0].lower().startswith(
                                    self.var_tokens[i][self.totales[i]]):  # comparar la palabra actual con la una de la entidad,
                                self.totales[i] = self.totales[i] + 1  # continuar la lectura de la entidad si concuerda
                            else:
                                self.totales[i] = 0  # o reiniciar la lectura de la entidad si no concuerda
                                continue
                        if len(self.var_tokens[i]) == self.totales[i]:  # Si se han encontrado todas las palabras de una ent.
                            for j in range(0, self.totales[i] + 1):  # se asignan letras "I" de inner o "B" de begin a las
                                if j < self.totales[i] and j != 0:  # ultimas "totales[i]" listas en done
                                    self.done[-j][3] = "I"
                                if j == self.totales[i]:
                                    self.done[-j][3] = "B"
                            self.totales[i] = 0

    def save(self, output_path):

        with open(output_path, 'w', encoding='utf8', newline='\n') as file:
            writer = csv.writer(file, quoting=csv.QUOTE_MINIMAL)
            writer.writerow(['Sentence: #', 'Word', 'POS', 'tag'])
            for words in self.done:
                writer.writerow([words[0], words[1], words[2], words[3]])
        file.close()











