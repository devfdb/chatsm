import csv

from nltk.tokenize import ToktokTokenizer

# input_path = Ruta del archivo en que se encuentran guardados los datos
# output_path = Nombre con que se guardarán los tweets extraídos
# params['color_path'] = Ruta del archivo donde se guardó el modelo de colores
# params['color'] = Nombre del color a buscar (ej: 'g')

class ClusterExtractor:
    
    tweet = []
    color = {}
    
    def __init__(self, input_path:str, output_path:str, params:dict):
        self._load_tweet(input_path)
        self._load_color(params['color_path'])
        df = self._create_data(tweet, color, params['color'])
        df.to_csv(output_path, encoding='utf-8', index=False)
        print('Listo.')
    
    def _word_count(self, phrase:str, cluster:list):
        print('Filtrando tweets por cluster...')
        count = 0
        for word in phrase:
            if word in cluster:
                count += 1
        return count
    
    def _cluster_count(self, phrase:str, cluster:list):
        print('Realizando conteo de palabras...')
        numbers = []
        keywords = []
        for i, word in enumerate(cluster):
            if word in phrase:
                numbers.append(i)
                keywords.append(word)
        return numbers, keywords
    
    def _load_tweet(self, path:str):
        print('Cargando tweets...')
        with open(path, 'r', encoding='utf8') as infile:
            reader = csv.reader(infile)
            self.tweets = list(reader)
    
    def _load_color(self, path:str):
        print('Cargando clusters...')
        with open(path, newline='') as infile:
            reader = zip(*csv.reader(infile))
            for row in reader:
                self.color[row[0]] = [cell for cell in row[1:] if cell]
    
    def _create_data(self, tweets:list, color:dict, c:str):
        c_tweet = []
        for t in tweets:
            phrase = tokenizer.tokenize(t)
            count = _word_count(phrase, color[c])
            if count >= 1:
                c_tweet.append(t)
        numb = []
        word = []
        for t in c_tweet:
            phrase = tokenizer.tokenize(t)
            numbers, keywords = _cluster_count(phrase, color[c])
            numb.append(numbers)
            word.append(keywords)
        df = pd.DataFrame()
        df['Tweet'] = c_tweet
        df['Número'] = numb
        df['Palabras'] = word
        return df