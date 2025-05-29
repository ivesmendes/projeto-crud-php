# Projeto CRUD de Tarefas em PHP

Um gerenciador de tarefas simples usando PHP, PDO/MySQL e HTML/CSS. Permite criar, editar, excluir, filtrar por status, marcar como concluída e exportar em CSV ou PDF.

---

## Tecnologias

* PHP 7+ com PDO
* MySQL (via XAMPP/MariaDB)
* HTML5, CSS3
* [FPDF](http://www.fpdf.org/) para geração de PDFs

---

## Funcionalidades

1. **CRUD completo** (Create, Read, Update, Delete)
2. **Filtros** (Todas, Pendentes, Concluídas)
3. **Marcar como concluída** com registro de data/hora
4. **Exportação** em CSV e PDF
5. **Layout responsivo básico** e estilização com CSS

---

## Como usar

1. Clone este repositório:

   ```bash
   git clone https://github.com/ivesmendes/projeto-crud-php.git
   cd projeto-crud-php
   ```
2. Instale o XAMPP e inicie os serviços Apache e MySQL.
3. No phpMyAdmin, importe o arquivo `db.sql` para criar o banco de dados e a tabela `tarefas`.
4. Ajuste os parâmetros de conexão no `config.php` conforme suas credenciais.
5. Acesse no navegador:

   ```
   http://localhost/projeto-crud-php/index.php
   ```


