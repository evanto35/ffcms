<?php

return [
    'Dashboard' => 'Панель инструментов',
    'Main dashboard' => 'Главная панель инструментов',
    'Server info' => 'Информация о сервере',
    'GA: visits and users' => 'GA: визиты и клиенты',
    'GA: Countries' => 'GA: страны',
    'Base protocol' => 'Основной протокол',
    'Base domain' => 'Основной домен',
    'Base path' => 'Базовый путь',
    'Admin email' => 'Админ. почта',
    'Timezone' => 'Временная зона',
    'User run cron' => 'Запуск cron пользователем',
    'Initialize cron manager when user load website? Enable this option if you are not configured cron tasks in your operation system' => 'Инициализировать запуск менеджера задач при загрузке сайта пользователем? Включайте эту функцию только если вы не сконфигурировали инициацию cron задач в операционной системе',
    'Debug for all' => 'Отладка для всех',
    'Default language' => 'Стандартный язык',
    'Available languages' => 'Доступные языки',
    'Multi-languages' => 'Мульти-язычность',
    'User theme' => 'Пользовательский шаблон',
    'Admin theme' => 'Административный шаблон',
    'Database driver' => 'Драйвер БД',
    'Database host' => 'Хост БД',
    'Database name' => 'Имя БД',
    'Database user' => 'Пользователь БД',
    'Database user pass' => 'Пароль БД',
    'Charset' => 'Кодировка',
    'Collation' => 'Сопоставление',
    'Tables prefix' => 'Префикс таблиц',
    'Debug cookie key' => 'Название cookie отладки',
    'Debug cookie value' => 'Значение cookie отладки',
    'Main domain of website. Use only in console or cron tasks, if domain cannot be defined from request string' => 'Основной домен веб-сайта. Используется только в случае, когда невозможно распознать домен из строки запроса',
    'Main website transfer protocol. Use only if request data is not available in console or cron tasks' => 'Основной протокол передачи данных на сайте. Используется в случае, когда невозможно получить эти данные из запроса, к примеру в консоли или задачах cron',
    'FFCMS installation sub-directory, used if installed not in root. Example: /subdir/' => 'Директория установки FFCMS, используемая при установке не в корень. Пример: /subdir/',
    'Enable debug bar panel for all visitors? Recommended only on development environment' => 'Включить панель отладки для всех? Не рекомендуется в продакшене',
    'Set cookie name(key) for enable debug bar panel' => 'Укажите название ключа cookie для включения панели отладки',
    'Set cookie value for enable debug bar panel' => 'Укажите значение ключа cookie для включения отладки',
    'Default language of website' => 'Язык сайта по умолчанию',
    'Must we use multi language system in site pathway' => 'Использовать систему многоязычности в идентификаторе URI сайта',
    'Website base script language. Do not change it' => 'Базовый язык в приложениях сайта. Не меняйте данное значение',
    'Website available languages' => 'Доступные языковые версии сайта',
    'Do not change any information in this tab if you not sure what you do!' => 'Не меняйте данные в этой вкладке, если вы не уверены в том, что делаете!',
    'Database connection driver' => 'Драйвер подключения к базе данных',
    'Database connection host name' => 'Хост подключения к базе данных',
    'Database name or path to sqlite created file database' => 'Имя базы данных или полный путь к sqlite файлу',
    'User name for database connection' => 'Имя пользователя для подключения к базе данных',
    'Password for user of database connection' => 'Пароль пользователя для подключения к базе данных',
    'Database tables prefix' => 'Префикс таблиц базы данных',
    'Configuration file is not writable! Check /Private/Config/ dir and files' => 'Файл конфигурации не может быть записан! Проверьте права для /Private/Config/ и файлов',
    'Validation of form data is failed!' => 'Проверка данных формы завершилась с ошибкой',
    'The key-value of cookie to enable debugging on website' => 'Параметры cookie для включения отладки на сайте',
    'If user got this cookie he can see debug bar' => 'Если у пользователя установлена данная cookie он сможет видеть отладочную панель',
    'Define administrator email. Used in mailing functions. Other mail settings in /Private/Config/Object.php' => 'Укажите почтовый ящик администрации, используемый при рассылке почты. Тонкая настройка почты: /Private/Config/Object.php',
    'Define website default timezone id' => 'Укажите стандартную временную зону для вашего сайта',
    'Set cookie for me' => 'Установить cookie для меня',
    'Base' => 'Основное',
    'Themes' => 'Шаблоны',
    'Localization' => 'Локализация',
    'Database' => 'База данных',
    'Debug' => 'Отладка',
    'Other' => 'Прочие',
    'Congratulations!' => 'Поздравляем!',
    'Settings are successful saved! Wait 5 second to update configurations' => 'Настройки успешно сохранены! Подождите 5 секунд для обновления',
    'Reload' => 'Перезагрузить',
    'Settings are saved' => 'Настройки сохранены',
    'File management' => 'Управление файлами',
    'Antivirus scan' => 'Антивирусное сканирование',
    'FFCMS 3 provide a simple signature-based antivirus software' => 'FFCMS предоставляет простой алгоритм сигнатурного антивирусного анализа',
    'Remember! This is just an advisory algorithm!' => 'Помните! Это лишь рекомендации, а не призыв к действию!',
    'Files left' => 'Осталось файлов',
    'Detected issues' => 'Обнаружено проблем',
    'Start scan' => 'Начать сканирование',
    'File' => 'Файл',
    'Issues' => 'Проблемы',
    'Descriptions of issues' => 'Описание проблем',
    'Update results' => 'Обновить результаты',
    'Routing scheme' => 'Схемы маршрутизации',
    'Static(alias) routes' => 'Статические(alias) маршруты',
    'Dynamic(callback) routes' => 'Динамические(callback) маршруты',
    'Custom routes is not yet found' => 'Пользовательские маршруты не найдены',
    'Environment' => 'Окружение',
    'Source path' => 'Исходный путь',
    'Target path' => 'Целевой путь',
    'Actions' => 'Действия',
    'Inject controller' => 'Контроллер перехвата',
    'Target class' => 'Целевой класс',
    'New route' => 'Новый маршрут',
    'Add route' => 'Добавление маршрута',
    'Routing type' => 'Тип маршрута',
    'Loader environment' => 'Окружение загрузчика',
    'Source path/controller' => 'Исходный путь/контроллер',
    'Target path/controller' => 'Целевой путь/контроллер',
    'Add new route' => 'Добавить новый маршрут',
    'Specify type of defined rule' => 'Выберите тип правила маршрутизации',
    'Select loader type where be applied rule' => 'Выберите целевое окружение загрузчика для данного правила маршрутизации',
    'Define source path (for static alias) or class name (for dynamic rule) to use it for target query' => 'Задайте исходный путь (для статического алиаса) или имя класса контроллера (для динамического правила) которое будет заменено целевым',
    'Define target path or class path for displayd item on source path' => 'Задайте целевой путь или полный путь класса для отображения содержимого на исходном пути',
    'Static (alias) route' => 'Статический (алиас) маршрут',
    'Dynamic (callback) route' => 'Динамический (callback) маршрут',
    'Deleting route' => 'Удаление маршрута',
    'Delete this route' => 'Удалить этот маршрут',
    'Route removed' => 'Маршрут удален',
    'There you can change specified configs depends of other platforms. GA = google analytics.' => 'Здесь вы можете изменить специфичые конфигурации зависимые от других сервисов. GA = google analytics.',
    'Google oAuth2 client id. This id will be used to display google.analytics info. Client ID looks like: xxxxxx.apps.googleusercontent.com' => 'Google oAuth2 id клиента. Этот ID используется для отображения данных google.analytics. ID клиента выглядит так: xxxxxx.apps.googleusercontent.com',
    'Set google analytics tracking id for your website. Track id looks like: UA-XXXXXX-Y' => 'Установите идентификатор отслеживания, полученный в google analytics для сбора статистики. Идентификатор слежения выглядит как: UA-XXXXXX-Y',
    'Proxy list' => 'Список прокси',
    'Set trusted proxy list to accept X-FORWARDED data. Example: 103.21.244.15,103.22.200.0/22' => 'Укажите список прокси-серверов с которых будут приниматься заголовки X-FORWARDED. Пример: 103.21.244.15,103.22.200.0/22',
    'Route saved' => 'Маршрут сохранен',
    'Route is successful deleted! Wait 5 second to update configurations' => 'Маршрут успешно удален! Подождите 5 секунд для обновления конфигурации',
    'Route are successful saved! Wait 5 second to update configurations' => 'Маршрут успешно сохранен! Подождите 5 секунд для обновления конфигурации',
    'FFCMS version' => 'Версия FFCMS',
    'PHP version' => 'Версия PHP',
    'OS name' => 'Название OS',
    'Files size' => 'Размер файлов',
    'Load average' => 'Нагрузка',
    'Directories and files' => 'Директории и файлы',
    'FFCMS News' => 'Новости FFCMS',
    'All directories and files in this list required to be readable and writable.' => 'Все директории и файлы из этого списка должны иметь права на чтение и запись.',
    'Clear cache' => 'Очистить кэш',
    'Clear sessions' => 'Очистить сессии',
    'Clean cache' => 'Очистка кэша',
    'Clear' => 'Очистить',
    'Are you sure to clear all website cache? Cache size: %size%mb' => 'Вы уверены что хотите очистить весь кэш сайта? Размер кэша: %size%mb',
    'Cache cleared successfully' => 'Кэш успешно очищен',
    'Clean sessions' => 'Очистка сессий',
    'Are you sure to clear all sessions information? All authorization sessions will be dropped down! Sessions count: %count%' => 'Вы уверены что хотите очистить всю информацию о сессиях? Все данные сессий авторизации будут сброшены! Количество сессий: %count%',
    'Official website' => 'Официальный сайт',
    'Updates' => 'Обновления',
    'Update manager' => 'Менеджер обновлений',
    'Scripts version' => 'Версия файлов',
    'Database version' => 'Версия базы данных',
    'Last version' => 'Последняя версия системы',
    'Seems like scripts and database of your website have different versions. You should do update right now or your website can working unstable' => 'Похоже, что версия базы данных и файлов не совпадают для вашего сайта. Вы должны выполнить обновление базы данных немедленно или ваш сайт будет работать с ошибками',
    'This updates for database will be applied:' => 'Будут применены следующие обновления для базы данных:',
    'The newest version: <b>%version%</b> with title &laquo;<em>%title%</em>&raquo; is available to update. You can start update right now' => 'Новая версия: <b>%version%</b> под названием &laquo;<em>%title%</em>&raquo; доступна для обновления. Вы можете начать обновление прямо сейчас',
    'Update database' => 'Обновить базу данных',
    'Download update' => 'Загрузить обновление',
    'Your system is up to date. No updates is available' => 'Установлена последняя версия системы. Обновления не найдены',
    'Database updates are successful installed' => 'Обновления для базы данных успешно установлены',
    'Archive with new update are successful downloaded and extracted. Please refresh this page and update database if required' => 'Архив с обновлением успешно загружен и распакован. Пожалуйста, обновите данную страницу и выполните обновление базы данных',
    'In process of downloading and extracting update archive error is occurred. Something gonna wrong' => 'В процессе загрузки и распаковки архива с обновлениями произошла ошибка. Что то пошло не так :('
];