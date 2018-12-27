import pandas as pd
from sklearn_crfsuite import CRF
from sklearn.externals import joblib
from . import functions

# input_path = ruta del archivo de entrenamiento
# output_path = ruta donde se guardara el modelo entrenado

# c1 = parametro de modelo crf
# c2 = parametro del modelo crf
# max_iterations = cantidad de iteraciones de entrenamiento

class Trainer:

    data = pd.DataFrame
    getter = None
    sentences = None
    X = None
    y = None
    crf = None

    def __init__(self, input_path: str, output_path: str, params: dict):
        self._load_files(input_path)
        self._train(params)
        self.save(output_path)

    def _load_files(self, input_path:str):

        self.data = pd.read_csv(input_path, encoding='utf8')
        self.data = self.data.fillna('Unk')
        self.getter = functions.SentenceGetter(self.data)
        self.sentences = self.getter.sentences
        self.X = [functions.sent2features(s) for s in self.sentences]
        self.y = [functions.sent2labels(s) for s in self.sentences]

    def _train(self, params: dict):
        try:
            c1 = params['c1']
        except KeyError:
            c1 = 10
        try:
            c2 = params['c2']
        except KeyError:
            c2 = 0.1
        try:
            max_iterations = params['max_iterations']
        except KeyError:
            max_iterations = 100

        self.crf = CRF(algorithm='lbfgs',
                  c1=c1,
                  c2=c2,
                  max_iterations=max_iterations,
                  all_possible_transitions=False)

        self.crf.fit(self.X, self.y)

    def save(self, output_path:str):
        joblib.dump(self.crf, output_path)


