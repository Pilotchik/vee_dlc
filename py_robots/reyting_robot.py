import urllib
import urllib.request
import urllib.parse

#получение максимального ID
#Запрос к API-функции getMaxUserId, которая возвращает максимальны ID таблицы пользователей
req = urllib.request.urlopen('http://localhost/ci_new/api/getMaxUserId')
#декодирование ответа
max_id = int(req.read().decode('utf-8'))
print("MAX ID:",max_id)

#количество обновлённых рейтингов
new_count = 0

user_id = 1
#наращивать user_id и обращаться к серверу для обновления рейтинга
while user_id <= max_id:
    #сформировать POST-массив
    values = {'user_id' : user_id}
    data = urllib.parse.urlencode(values)
    data = data.encode('UTF-8')
    req = urllib.request.urlopen('http://exam.segrys.ru/api/getUserReyt', data)
    answer = req.read().decode('utf-8')
    print(answer)
    if answer.find("место") > 0:
        new_count += 1
    user_id += 1

print("Рейтингов обновлено:",new_count)
