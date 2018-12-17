from nltk import UnigramTagger as ut
from nltk.tokenize import TweetTokenizer as tokenizer
from nltk.corpus import conll2002 as conll
from sklearn.externals import joblib

class POS_tagger:

    uni_tag = None

    def __init__(self, input_path, output_path, params):
        self.train(input_path)
        self.save(output_path)

    def train(self, input_path):
        if input_path:
            self.uni_tag = ut(input_path)
        else:
            self.uni_tag = ut(conll.tagged_sents())

    def tag(self, sentence: str):
        tokenz = tokenizer.tokenize(sentence)
        return self.uni_tag.tag(tokenz)

    def save(self, output_path):
        joblib.dump(self.uni_tag, output_path)
