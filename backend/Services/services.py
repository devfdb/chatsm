from .cleaner.cleaner import Cleaner
from .ortografia.ortografia import SpellChecker
from .replacer.word_replacer import Replacer
from .word2vec.word2vec import Word2Vec
from .NER.crf_trainer import Trainer as NERtrainer
from .NER.ner_training_generator import TrainingGenerator as NERTrainingGenerator
from .POS_tagger.POS_trainer import POS_tagger as POStrainer
# from .models.svm_model import SVM
# from .models.mnb_model import MultinomialNB
# from .models.mlp_model import MLPClassifier
# from .hclustering.hcluster import HierarchicClustering
# from .hclustering.clusterextractor import ClusterExtractor
