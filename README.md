# 🚀 Projeto Laravel com Docker

Este projeto é um ambiente Laravel containerizado usando **Docker** e **Docker Compose**.  
Você não precisa instalar PHP, Composer ou MySQL localmente — tudo roda em containers.

---

## 📋 Pré-requisitos
- [Docker](https://www.docker.com/get-started) >= 20.x
- [Docker Compose](https://docs.docker.com/compose/install/)

---

## ⚙️ Como rodar o projeto

### 1.Subir os Containers

docker compose up -d --build

### 2.Instalar dependências do Laravel

docker compose exec app composer install

### 3.Rodar as Migrations

docker compose exec app php artisan migrate

### 4.Rodar o Job

docker compose exec app php artisan queue:work --queue=proposalJob
