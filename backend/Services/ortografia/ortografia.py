import os
import csv
from .symspell import SymSpell
from nltk.tokenize import ToktokTokenizer


class SpellChecker:
    tokenizer = ToktokTokenizer()
    spell = SymSpell(3)
    
    def __init__(self, input_path: str, output_path: str, project, params: dict):
        self.project = project
        try:
            self._load_files(params['corpus_path'])
        except KeyError:
            self._load_dictionary(params['dict_path'])
        text = self._load_csv(input_path)
        text = self._process(text)
        self._save(output_path, text)
        
        
    def _load_csv(self, path: str):
        print('Cargando Texto')
        ntext = []
        with open(os.path.join("..", "repository", self.project, "input", path), 'r', encoding='utf8') as csvfile:
            reader = csv.reader(csvfile)
            for line in reader:
                ntext.append(line[0])
        return ntext

    def _load_files(self, path: str):
        print(path)
        filelist = os.walk(os.path.join("..", "repository", self.project, "input", path))
        print(filelist)
        for root, dirs, files in filelist:
            for file in files:
                print('Cargando: ',file)
                self.spell.create_dictionary(path + file)
            self.spell.purge_below_threshold_words()
        print('Listo')

    def _load_dictionary(self, path: str):
        filelist = os.walk(os.path.join("..", "repository", self.project, "input", path))

        for root, dirs, files in filelist:
            for file in files:
                print('Cargando: ',file)
                self.spell.load_dictionary(path + file)
        print('Listo')

    def _check(self, text: str):
        text = self.tokenizer.tokenize(text)
        for i, t in enumerate(text):
            if t.isalpha():
                sugestion = self.spell.lookup(t.lower(), 0, 3)
                if sugestion:
                    text[i] = sugestion[0].term
                if not sugestion:
                    text[i] = t

        return ' '.join(text)
    
    def _process(self, text: list):
        print('Procesando...')
        ntext = []
        for line in text:
            try:
                ntext.append(self._check(line))
            except ValueError:
                print(line)
        return ntext
    
    def _save(self, path:str, text: list):
        print('Guardando')
        with open(path, 'w', encoding='utf8', newline='\n') as file:
            writer = csv.writer(file)
            for line in text:
                writer.writerow([line])
        print('Listo')
