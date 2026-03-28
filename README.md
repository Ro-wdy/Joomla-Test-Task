# Joomla Content Plugin: `plg_content_joomlaorg`

A Joomla 5 content plugin that automatically pre-fills the **Article Title** when creating a **new** article.

It loads a small JavaScript asset on the article form, calls `com_ajax`, and injects a configurable default title from plugin parameters.

---

##  Features

- Prefills `jform_title` only when the title is empty.
- Applies only to the `com_content.article` form.
- Runs only for **new** articles (`id = 0`).
- Uses Joomla's Web Asset Manager for script loading.
- Fetches default text through `com_ajax`.
- Default title is configurable in plugin settings.

---

##  Tech Stack

- **Joomla 5** plugin architecture
- **PHP** event subscriber (`onContentPrepareForm`, `onAjaxJoomlaorg`)
- **Vanilla JavaScript** (`fetch`) for AJAX interaction
- **Docker Compose** for local Joomla + MariaDB environment

---

## 📁 Project Structure

```text
.
├── docker-compose.yml
├── plg_content_joomlaorg.zip
└── plg_content_joomlaorg/
    ├── joomlaorg.xml
    ├── language/
    │   └── en-GB/
    │       ├── plg_content_joomlaorg.ini
    │       └── plg_content_joomlaorg.sys.ini
    ├── media/
    │   └── js/
    │       └── joomlaorg.js
    ├── services/
    │   └── provider.php
    └── src/
        └── Extension/
            └── Joomlaorg.php
```

---

## 🚀 Quick Start (Docker)

### 1) Start Joomla + MariaDB

```bash
docker compose up -d
```

Joomla will be available at:

- `http://localhost:8080`

### 2) Complete Joomla installation wizard

Use the DB values from `docker-compose.yml`:

- **Host:** `db`
- **Database:** `joomla`
- **User:** `joomla`
- **Password:** `joomla`

---

## Install the Plugin

1. Go to Joomla Administrator.
2. Open **System → Install → Extensions**.
3. Upload `plg_content_joomlaorg.zip`.
4. Enable **Content - Joomlaorg** in Plugin Manager.

---

## ⚙️ Configure

In plugin settings, configure:

- **Default Title Text** (`default_title_text`)

If empty, the plugin falls back to:

- `Default Title`

---

## 🧪 How It Works

1. Open **Content → Articles → New**.
2. If the title field is empty, the JS sends:

```text
index.php?option=com_ajax&plugin=joomlaorg&group=content&format=json
```

3. The plugin returns the configured default title.
4. JS inserts that value into `jform_title` and triggers a `change` event.

---

## Validation Checklist

- Plugin installed and enabled.
- `Default Title Text` configured.
- New article form auto-fills title.
- Existing article edits do **not** overwrite title.

---

## 📜 License

GNU General Public License v2 or later.

---
