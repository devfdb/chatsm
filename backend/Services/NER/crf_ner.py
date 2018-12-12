import nltk.tokenize
from nltk import UnigramTagger as ut
from nltk.corpus import conll2002 as conll
from sklearn.externals import joblib
import crf_functions

conll_sents = conll.tagged_sents()
uni_tag = ut(conll_sents)


tokenz = nltk.tokenize.TweetTokenizer()
crf = joblib.load('crf.pkl')

def pos_tagger(sentence: str):
    done = []
    sentence = tokenz.tokenize(sentence)
    sentence = uni_tag.tag(sentence)
    for words in sentence:
        line = [words[0], words[1]]
        done.append(line)
    return done


def ner_tagger(s):
    s = pos_tagger(s)

    for word in s:
        if word[1] is None:
            word[1] = 'Unk'

    X = crf_functions.sent2features(s)
    y = crf.predict_single(X)

    ent = ''
    entities = []
    print(y)
    for i, tag in enumerate(y):
        if tag == 'B':
            ent = str(s[i][0])
        if tag == 'I' and ent is not '':
            ent = ent + ' ' + str(s[i][0])
        if tag == 'O' and ent is not '':
            entities.append(ent)
            ent = ''
        if i+1 == len(y) and ent is not '':
            entities.append(ent)
            ent = ''

    return entities

while True:
    print(ner_tagger(input("Oracion: ")))