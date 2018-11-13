from nltk.tokenize import ToktokTokenizer
import csv
import os.path

class Replacer:
    
    input = ''
    output = ''
    tokenizer = ToktokTokenizer()
    words_to_replace = {}
    
    def __init__(self, input_path:str, output_path:str, params:dict):
        self.input = input_path
        self.output = output_path
        self._load_files(params['file_path'])
        text = self._load_csv(input_path)
        text = self._process(text)
        self._save(output_path, text)

    def _load_files(self, path:str):
        print('Cargando Archivos')
        with open (path, 'r', encoding='utf8') as csvfile:
            reader = csv.reader(csvfile)
            for row in reader:
                self.words_to_replace[row[0]] = row[1]
                
    def _load_csv(self, path:str):
        print('Cargando Texto')
        ntext = []
        with open(path, 'r', encoding='utf8') as csv_file:
            reader = csv.reader(csv_file)
            for line in reader:
                ntext.append(line[0])
            return ntext

    # replace cambia expresiones regulares como abreviaturas por su expresion
    def _replace(self, text:str):
        if len(self.words_to_replace) == 0:
            print('Carge un archivo')
        text = self.tokenizer.tokenize(text)
        ntext = ''
        for token in text:
            try:
                token = self.words_to_replace[token]
                if ntext == '':
                    ntext = token
                else:
                    ntext = ntext + ' ' + token
            except KeyError:
                if ntext == '':
                    ntext = token
                else:
                    ntext = ntext + ' ' + token

        return ntext
    
    def _process(self, text:list):
        print('Procesando...')
        ntext = []
        for line in text:
            ntext.append(self._replace(line))
        return ntext
    
    def _save(self, path:str, text:list):
        print('Guardando')
        with open(path, 'w', encoding='utf8', newline='\n') as file:
            writer = csv.writer(file)
            for line in text:
                writer.writerow([line])
        print('Listo')
