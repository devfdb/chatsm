from cleaner.cleaner import Cleaner as cl
from ortografia.ortografia import SpellChecker as orto
from replacer.word_replacer import Replacer as rp

clean1 = cl('./input/tweets2011-11 (3).csv', './output/clean1.csv', {})
replacer = rp('./output/clean1.csv', './output/replace.csv', {'file_path': './replacer/remplazo2.csv'})
ortografia = orto('./output/replace.csv', './output/ortografia.csv', {'dict_path': './ortografia/books/V2'})
clean2 = cl('./output/ortografia.csv', './clean2.csv', {})
