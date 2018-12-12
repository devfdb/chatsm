from cleaner.cleaner import Cleaner as cl
from ortografia.ortografia import SpellChecker as orto
from replacer.word_replacer import Replacer as rp

clean1 = cl('','',{})._clean(input())
replacer = rp('', '', {'file_path': './replacer/remplazo2.csv'})._replace(clean1)
ortografia = orto('','', {'dict_path': './ortografia/books/V2/'})._check(replacer)
clean2 = cl('','', {})._clean(ortografia)

print(clean2)
