# Miele Support — Руководство по администрированию сайта

## Содержание

1. [Общая структура](#1-общая-структура)
2. [Пользовательские типы записей (CPT)](#2-пользовательские-типы-записей-cpt)
3. [Страницы сайта и шаблоны](#3-страницы-сайта-и-шаблоны)
4. [Меню навигации](#4-меню-навигации)
5. [Настройки темы (Theme Settings)](#5-настройки-темы-theme-settings)
6. [Настройки услуг (Service Settings)](#6-настройки-услуг-service-settings)
7. [Управление услугами (Services)](#7-управление-услугами-services)
8. [Управление новостями/статьями](#8-управление-новостямистатьями)
9. [Страница контактов](#9-страница-контактов)
10. [Страница блога/новостей](#10-страница-блогановостей)
11. [ACF Gutenberg-блок «Services Catalog»](#11-acf-gutenberg-блок-services-catalog)
12. [Формы и AJAX-обработчики](#12-формы-и-ajax-обработчики)
13. [Кэширование мега-меню](#13-кэширование-мега-меню)

---

## 1. Общая структура

Сайт построен на WordPress с темой **Miele Support** и плагином **ACF Pro** (Advanced Custom Fields). Вся конфигурация контента осуществляется через ACF-поля — ни Customizer, ни виджеты не используются.

**Ключевые объекты:**
- **Services** — иерархический CPT (3 уровня: Категория → Тип устройства → Конкретная услуга)
- **Posts (записи)** — новости/статьи блога
- **Страницы** — с шаблонами (Контакты, Блог, Услуги, главная)
- **Theme Settings** — страница опций ACF для глобальных настроек
- **Service Settings** — страница опций ACF для страницы услуг

---

## 2. Пользовательские типы записей (CPT)

### Services (`service`)

| Параметр | Значение |
|---|---|
| **Метка в админке** | Services |
| **Иерархический** | Да (поддерживает родительские/дочерние связи) |
| **Иконка меню** | 🔧 `dashicons-admin-tools` |
| **Поддерживает** | Заголовок, Редактор, Миниатюра, Атрибуты страницы (порядок) |
| **ЧПУ (slug)** | `/services/` |
| **Архив** | Нет (отдельный шаблон `page-services.php`) |
| **Gutenberg** | Включён (show_in_rest) |

**Трёхуровневая иерархия:**

```
Уровень 1 — Категория (parent = 0)
  └─ Уровень 2 — Тип устройства (has parent + has children)
       └─ Уровень 3 — Конкретная услуга (has parent, no children)
```

**Пример:**
```
Kitchen Appliances          ← Уровень 1
  └─ Refrigerator           ← Уровень 2
       └─ Miele Refrigerator Repair  ← Уровень 3
```

> **Важно:** Порядок услуг в меню и на страницах определяется полем **Атрибуты страницы → Порядок** (Order). Чем меньше число, тем выше элемент.

---

## 3. Страницы сайта и шаблоны

| Страница | Шаблон | Описание |
|---|---|---|
| Главная | `front-page.php` | Hero + Преимущества + Каталог + гибкие секции (из Theme Settings) |
| Услуги | `page-services.php` | Каталог услуг и гибкие секции (из Service Settings) |
| Блог/Новости | `page-blog.php` | Листинг новостей с фильтрацией по тегам и AJAX подгрузкой |
| Контакты | `page-contact.php` | Hero + многошаговая форма + контактная информация |
| Контакты (простая) | `page-contacts.php` | Хлебные крошки + контент из редактора |
| Страница услуги | `single-service.php` | Определяет уровень иерархии, рендерит соответствующие секции |
| Статья новости | `single-post.php` | Заголовок, автор, медиа, контент, теги, навигация |
| Архив услуг | `archive-service.php` | Редирект или отображение каталога |

---

## 4. Меню навигации

В админке: **Внешний вид → Меню**

| Расположение | Название | Описание |
|---|---|---|
| `primary` | Primary Menu | Основное верхнее меню |
| `burger_main` | Burger Main | Мобильное бургер-меню |

Мега-меню на десктопе автоматически строится из иерархии Services (Уровень 1 → Уровень 2 → Уровень 3). Кэшируется на 2 часа.

---

## 5. Настройки темы (Theme Settings)

В админке: **Theme Settings** (отдельный пункт меню, ACF Options Page)

### Вкладка: Hero

| Поле | Тип | Описание |
|---|---|---|
| Hero Title | text | Заголовок главного Hero-баннера |
| Hero Subtitle | textarea | Подзаголовок Hero |
| Hero Background | image | Фоновое изображение Hero |

### Вкладка: Advantages (Преимущества)

| Поле | Тип | Описание |
|---|---|---|
| Advantages Title | text | Заголовок блока преимуществ |
| Advantages Subtitle | text | Подзаголовок |
| Advantages Background | image | Фоновое изображение блока |
| Advantages Items | repeater | Повторяющийся блок элементов: |
| — Icon | image | Иконка преимущества |
| — Title | text | Название (макс. 100 символов) |
| — Text | textarea | Описание (макс. 250 символов) |

### Вкладка: Section 3

Блок «Изображение + контент» с кнопкой.

| Поле | Тип | Описание |
|---|---|---|
| Swap Order | toggle | Поменять местами контент и изображение |
| Section 3 Title | text | Заголовок |
| Section 3 Description | wysiwyg | Описание |
| Section 3 Items | repeater | Список элементов: |
| — Icon | image | Иконка (или дефолтный SVG) |
| — Text | text | Текст пункта (макс. 150 символов) |
| Section 3 Button Text | text | Текст кнопки |
| Section 3 Button Link | link | Ссылка кнопки |
| Section 3 Image | image | Изображение |
| Section 3 Background | image | Фоновое изображение |

### Вкладка: Catalog (Каталог)

| Поле | Тип | Описание |
|---|---|---|
| Catalog Title | text | Заголовок каталога (по умолчанию: «What we repair») |
| Catalog Categories | repeater | Категории каталога: |
| — Category Title | text | Название категории |
| — Category Items | repeater | Элементы категории: |
| —— Item Image | image | Изображение (рекомендуется 300×300) |
| —— Item Title | text | Название (обязательное, макс. 100) |
| —— Item Link | link | Ссылка (обязательная) |

### Вкладка: Page Sections (Гибкие секции)

Гибкий контент (flexible content) — можно добавлять секции в любом порядке и количестве.

#### Доступные секции:

**1. Section 5 — Акцентный блок**
- Title, Subtitle, Button Text, Button Link

**2. Home Slider — Слайдер изображений**
- Title, Subtitle
- Slides (repeater): Image + Caption

**3. FAQ — Часто задаваемые вопросы**
- Title, Description
- FAQ Items (repeater): Question (обязательное) + Answer (обязательное)

**4. Section 6 — Онлайн-консультация**
- Image, Title, Description, Button Text, Button Link

**5. Reviews — Отзывы**
- Title, Subtitle
- Reviews (repeater): Avatar, Name (обязательное), City, Review Title, Review Text (обязательное), Rating (1–5, обязательное)

**6. Service Areas — Районы обслуживания**
- Title, Subtitle, Areas List (один район на строку), Map Embed (iframe Google Maps)

**7. Advantages — Альтернативный блок преимуществ**

---

## 6. Настройки услуг (Service Settings)

В админке: **Service Settings** (отдельный пункт меню, ACF Options Page)

Содержит поле **service_sections** (flexible content) — те же 16 макетов секций, что и для отдельных услуг (см. раздел 7 ниже). Эти секции отображаются на странице `/services/`.

---

## 7. Управление услугами (Services)

В админке: **Services** (пункт меню с иконкой 🔧)

### 7.1. Создание услуги Уровня 1 (Категория)

1. **Services → Add New**
2. Ввести заголовок (например, «Kitchen Appliances»)
3. В поле **Page Attributes** (Атрибуты страницы) оставить Parent = None, задать Order
4. Загрузить **миниатюру** (Featured Image)
5. Заполнить поля в боковой панели:

| Поле | Тип | Описание |
|---|---|---|
| Category Icon | image | Иконка для мега-меню |
| Category Description | textarea | Описание категории (макс. 200 символов) |
| Category Banner | image | Баннерное изображение |
| Menu Label | text | Метка в мега-меню (если пусто — используется заголовок) |

6. Заполнить **контентные секции** (flexible content «Build the service page sections») — см. п. 7.4
7. Нажать **Publish**

### 7.2. Создание услуги Уровня 2 (Тип устройства)

1. **Services → Add New**
2. Ввести заголовок (например, «Refrigerator»)
3. В **Page Attributes** выбрать **Parent** = соответствующая категория (Уровень 1), задать Order
4. Загрузить миниатюру
5. Заполнить поля в боковой панели:

| Поле | Тип | Описание |
|---|---|---|
| Short Description | textarea | Краткое описание для мега-меню и карточек (макс. 150) |
| Hero Image | image | Изображение для Hero-секции |
| Brands | repeater | Бренды: |
| — Brand Name | text | Название (например, «Miele») |
| — Brand Logo | image | Логотип бренда |
| Show in Mega Menu | toggle | Показывать ли в мега-меню (по умолчанию — Да) |

6. Заполнить контентные секции (см. п. 7.4)
7. Нажать **Publish**

### 7.3. Создание услуги Уровня 3 (Конкретная услуга)

1. **Services → Add New**
2. Ввести заголовок (например, «Miele Refrigerator Repair»)
3. В **Page Attributes** выбрать **Parent** = соответствующий тип устройства (Уровень 2), задать Order
4. Загрузить миниатюру
5. Заполнить поля:

| Поле | Тип | Описание |
|---|---|---|
| Advantages | repeater | Преимущества (мин. 4, макс. 4): Icon + Title + Text |
| Models | repeater | Модели: Image + Name |
| FAQ | repeater | Вопросы: Question + Answer (wysiwyg) |

6. Заполнить контентные секции (см. п. 7.4)
7. Нажать **Publish**

### 7.4. Контентные секции (Flexible Content)

Доступны на всех уровнях услуг, а также на странице Service Settings. Нажмите **«Add Service Section»** и выберите один из 16 макетов:

#### 1. Service Hero
Hero-баннер услуги. Поля: Eyebrow Text, Custom Title, Show Title (toggle), Intro Text (wysiwyg), Hero Image, Overlay Opacity (0–100%), Content Alignment (Center/Left/Right), Show Booking Button + ссылка, Show Phone Button + номер, Minimum Height (Small 400px / Medium 520px / Large 620px / Full Screen 100vh), Custom CSS Class.

#### 2. Advantages (Преимущества)
Блок 4 преимуществ. Title, Subtitle, Show Title/Show Subtitle (toggles), Advantages (repeater: Icon + Title + Text, мин. 4 макс. 4).

#### 3. Models (Модели)
Каталог моделей. Block Title, Models (repeater: Image + Name + Description).

#### 4. Common Problems (Проблемы)
Список частых проблем. Title, Problems (repeater: Problem + Description + Image).

#### 5. Pricing Table (Прайс-лист)
Таблица цен. Title, Subtitle, Price Items (repeater: Repair/Part + Typical Symptoms + Turnaround + Price from), Footnote.

#### 6. Secondary CTA (Второй призыв к действию)
Title, Subtitle (wysiwyg), Background Image, Show Booking Button + ссылка, Show Phone Button.

#### 7. Error Codes (Коды ошибок)
Таблица кодов ошибок. Title, Error Codes (repeater: Code + Short Description + Instructions (wysiwyg) + If Error Persists (wysiwyg)), Footnote.

#### 8. Reviews (Отзывы)
Title, Subtitle, Reviews (repeater: Avatar + Name (обязательное) + City + Review Title + Review Text (обязательное) + Rating 1–5 (обязательное)).

#### 9. Service Areas (Районы обслуживания)
Title, Subtitle, Areas List (один район на строку), Map Embed (iframe Google Maps).

#### 10. Services Catalog (Каталог услуг)
Catalog Title, Catalog Categories (repeater: Category Title + Category Items (repeater: Item Image + Item Title (обязательное) + Item Link (обязательный))).

#### 11. Catalog Description (Описание каталога)
Title, Description (wysiwyg), Background Image.

#### 12. Trust CTA
Title, Subtitle, Button Text, Button Link.

#### 13. Accent Section
Title, Subtitle (wysiwyg), Button Text, Button Link.

#### 14. Accent Section with Buttons
Title, Subtitle (wysiwyg), Buttons (repeater: Button Text + Button Link + Button Style (Primary/Outline)).

#### 15. Text Block (Текстовый блок)
Title, Description (wysiwyg, полная панель инструментов + загрузка медиа).

#### 16. Section 3 — Combo Block
Комбинированный блок «контент + изображение». Swap Order (toggle), Title, Description (wysiwyg), Items (repeater: Icon + Text), Button Text, Button Link, Image, Background Image.

> **Совет:** Секции можно добавлять в любом порядке и количестве. Порядок секций на странице соответствует порядку в админке.

---

## 8. Управление новостями/статьями

В админке: **Posts** (стандартный раздел WordPress)

### Создание статьи

1. **Posts → Add New**
2. Ввести заголовок
3. Загрузить **миниатюру** (Featured Image) — отображается как основное изображение
4. Выбрать **категории** и **теги** (стандартные WordPress-таксономии)
5. Заполнить ACF-поля:

#### Вкладка: Content

| Поле | Тип | Описание |
|---|---|---|
| Subtitle | text | Подзаголовок статьи (макс. 200) |
| Featured Image Caption | text | Подпись к миниатюре (макс. 200) |
| Content Before Media | wysiwyg | Контент перед медиа-блоком (базовая панель) |
| Secondary Image | image | Второе изображение (рядом с основным на десктопе, скрыто на мобильных) |
| Secondary Image Caption | text | Подпись ко второму изображению (появляется только если выбрано второе изображение) |
| Video | oembed | Видео (YouTube/Vimeo), 1280×720 |
| Data Table | repeater | Таблица данных: Row (repeater) → Cells (repeater: Content + Header Cell toggle) |
| Content After Media | wysiwyg | Контент после медиа-блока |

#### Вкладка: Author

| Поле | Тип | Описание |
|---|---|---|
| Author Name Override | text | Имя автора (переопределяет имя автора WP, макс. 100) |
| Author Avatar | image | Аватар автора (макс. 150×150) |
| Author Description | textarea | Описание автора (макс. 500) |

> Если ACF-поля (Content Before/After Media, Video, Table) не заполнены — шаблон автоматически использует стандартный `the_content()` как fallback.

---

## 9. Страница контактов

В админке: **Страницы → Контакты** (шаблон: Contact)

### ACF-поля (появляются при выборе шаблона Contact):

| Поле | Тип | По умолчанию | Описание |
|---|---|---|---|
| Hero Title | text | «Contact Us» | Заголовок Hero-секции |
| Hero Background Image | image | — | Фон Hero (рекомендуется 1920×600) |
| Service Line | text | «+1 (929) 351 32 30» | Телефонная линия |
| Hours Mon-Fri | text | «8:00 AM - 6:00 PM» | Часы работы Пн–Пт |
| Hours Saturday | text | «9:00 AM - 4:00 PM» | Часы работы Суббота |

#### Вкладка: Form Settings

| Поле | Тип | Описание |
|---|---|---|
| Form Categories | repeater | Категории для выпадающего списка формы: |
| — Value | text (обязательное) | Внутреннее значение (lowercase, без пробелов) |
| — Label | text (обязательное) | Отображаемая метка |
| Admin Email | email | Email для получения заявок (если пусто — email администратора WP) |

### Многошаговая контактная форма

Форма состоит из 3 шагов:

**Шаг 1 — Describe Your Problem:**
- Category (выбор из Form Categories)
- Problem Description (textarea)
- Certificate of Insurance (Yes / No / Not Sure)
- COI File Upload (PDF, JPG, PNG, DOC, DOCX, макс. 5MB)

**Шаг 2 — Schedule Appointment:**
- Preferred Date (date picker)
- Preferred Time (8:00 AM–12:00 PM / 12:00 PM–4:00 PM / 4:00 PM–8:00 PM)

**Шаг 3 — Contact Information:**
- Full Name
- Address, City, Postcode
- Phone, Email

---

## 10. Страница блога/новостей

В админке: **Страницы → Blog** (шаблон: Blog)

| Поле | Тип | По умолчанию | Описание |
|---|---|---|---|
| Hero Title | text | «News» | Заголовок Hero-секции |
| Hero Background Image | image | — | Фон Hero (рекомендуется 1920×600) |

Страница автоматически выводит все записи (Posts) с фильтрацией по тегам и AJAX-подгрузкой (кнопка «Load More»).

---

## 11. ACF Gutenberg-блок «Services Catalog»

Доступен в редакторе Gutenberg как блок **«Services Catalog»** (категория Layout, иконка 📊).

| Поле | Тип | Описание |
|---|---|---|
| Section Title | text | Заголовок (по умолчанию «Our Services») |
| Service Categories | repeater | Категории: |
| — Category Title | text | Название категории |
| — Category Items | repeater | Элементы: |
| —— Item Image | image | Изображение (300×300) |
| —— Item Title | text (обязательное) | Название |
| —— Item Link | link (обязательный) | Ссылка |

---

## 12. Формы и AJAX-обработчики

### Contact Form Submit

- **Endpoint:** `wp_ajax_contact_form_submit` / `wp_ajax_nopriv_contact_form_submit`
- **Nonce:** `contact_form_submit`
- **Метод:** POST
- **Обработка:** Валидация nonce, санитизация полей, проверка обязательных полей, загрузка файла COI, отправка email через `wp_mail()` на адрес из `form_admin_email` (или admin_email)

### Load More Posts (Блог)

- **Endpoint:** `wp_ajax_load_more_posts` / `wp_ajax_nopriv_load_more_posts`
- **Параметр:** `page` (номер страницы)
- **Возвращает:** HTML-карточки постов для бесконечной прокрутки

---

## 13. Кэширование мега-меню

Мега-меню кэшируется в WordPress Transients для производительности:

| Параметр | Значение |
|---|---|
| Ключ кэша | `miele_mega_menu_cache` |
| Время жизни | 2 часа (7200 секунд) |

**Автоматическая очистка кэша** происходит при:
- Сохранении услуги (save_post_service)
- Удалении услуги (delete_post)

Если изменения в мега-меню не отображаются — подождите до 2 часов или пересохраните любую услугу.

---

## Приложение: Быстрые инструкции

### Как добавить новую категорию услуг (Уровень 1)

1. Services → Add New
2. Ввести название (например, «Laundry Appliances»)
3. Parent = None, задать Order
4. Загрузить миниатюру
5. Заполнить: Category Icon, Category Description, Category Banner, Menu Label
6. Добавить контентные секции при необходимости
7. Publish

### Как добавить тип устройства (Уровень 2)

1. Services → Add New
2. Ввести название (например, «Washing Machine»)
3. Parent = выбрать категорию (Уровень 1), задать Order
4. Загрузить миниатюру
5. Заполнить: Short Description, Hero Image, Brands, Show in Mega Menu
6. Добавить контентные секции
7. Publish

### Как добавить конкретную услугу (Уровень 3)

1. Services → Add New
2. Ввести название (например, «Miele Washing Machine Repair»)
3. Parent = выбрать тип устройства (Уровень 2), задать Order
4. Загрузить миниатюру
5. Заполнить: Advantages (4 шт.), Models, FAQ
6. Добавить контентные секции
7. Publish

### Как добавить новость/статью

1. Posts → Add New
2. Ввести заголовок
3. Загрузить миниатюру + выбрать категории/теги
4. Заполнить ACF-поля (Subtitle, Author, Secondary Image, Video и т.д.)
5. Publish

### Как изменить категории контактной формы

1. Страницы → открыть страницу Контакты
2. В блоке «Form Settings» → Form Categories
3. Добавить/изменить/удалить строки (Value + Label)
4. Обновить страницу

### Как изменить контент главной страницы

1. Открыть **Theme Settings** в меню
2. Отредактировать вкладки: Hero, Advantages, Section 3, Catalog
3. На вкладке Page Sections — добавить/удалить/переставить гибкие секции
4. Сохранить

### Как изменить контент страницы услуг

1. Открыть **Service Settings** в меню
2. Добавить/удалить/переставить контентные секции (те же 16 макетов)
3. Сохранить

### Как скрыть тип устройства из мега-меню

1. Открыть услугу Уровня 2
2. В боковой панели снять галочку **Show in Mega Menu**
3. Обновить
