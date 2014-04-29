import urllib
import urllib.request
import urllib.parse

#host = 'http://localhost/ci_new'
host = 'http://exam.segrys.ru'

#получение максимального ID
#Запрос к API-функции getMaxUserId, которая возвращает максимальны ID таблицы пользователей
req = urllib.request.urlopen(host + '/api/getMaxUserId')
#декодирование ответа
max_id = int(req.read().decode('utf-8'))
print("MAX ID:",max_id)

#количество обновлённых рейтингов
new_count = 0
#количество полученных индексов
index_count = 0

user_id = 1
#наращивать user_id и обращаться к серверу для получения индекса
while user_id <= max_id:
    #сформировать POST-массив
    values = {'user_id' : user_id}
    data = urllib.parse.urlencode(values)
    data = data.encode('UTF-8')
    req = urllib.request.urlopen(host+'/api/getUserISRZ', data)
    answer = req.read().decode('utf-8')
    print(answer)
    if answer.find("Индекс") >= 0:
        index_count += 1
    user_id += 1

user_id = 1
#наращивать user_id и обращаться к серверу для обновления рейтинга
while user_id <= max_id:
    #сформировать POST-массив
    values = {'user_id' : user_id}
    data = urllib.parse.urlencode(values)
    data = data.encode('UTF-8')
    req = urllib.request.urlopen(host+'/api/getUserReyt', data)
    answer = req.read().decode('utf-8')
    print(answer)
    if answer.find("Теперь") > 0:
        new_count += 1
    user_id += 1

#обновить дату полной пересортировки
req = urllib.request.urlopen(host + '/api/updateRateResortDate')
status = req.read().decode('utf-8')
print(status)

print("Получено индексов:",index_count)
print("Рейтингов обновлено:",new_count)

a = input("PRESS ANY KEY")
