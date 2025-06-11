# DISTRIBUSI-PRODUK

Streamlining Distribution, Empowering Growth and Innovation

![Last Commit](https://img.shields.io/github/last-commit/username/repo?color=blue&style=flat-square) ![Code Size](https://img.shields.io/github/languages/code-size/username/repo?color=green&style=flat-square) ![Languages](https://img.shields.io/github/languages/count/username/repo?style=flat-square)

Built with the tools and technologies:
![JSON](https://img.shields.io/badge/-JSON-000000?style=flat-square&logo=json&logoColor=white) 
![Markdown](https://img.shields.io/badge/-Markdown-000000?style=flat-square&logo=markdown&logoColor=white) 
![PHP](https://img.shields.io/badge/-PHP-777BB4?style=flat-square&logo=php&logoColor=white) 
![Laravel](https://img.shields.io/badge/-Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white) 
![JavaScript](https://img.shields.io/badge/-JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black) 
![jQuery](https://img.shields.io/badge/-jQuery-0769AD?style=flat-square&logo=jquery&logoColor=white) 
![NPM](https://img.shields.io/badge/-NPM-CB3837?style=flat-square&logo=npm&logoColor=white) 
![Composer](https://img.shields.io/badge/-Composer-885630?style=flat-square&logo=composer&logoColor=white) 
![Vite](https://img.shields.io/badge/-Vite-646CFF?style=flat-square&logo=vite&logoColor=white) 
![Tailwind CSS](https://img.shields.io/badge/-Tailwind_CSS-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white) 
![MySQL](https://img.shields.io/badge/-MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white) 

## Table of Contents

*   [Overview](#overview)
*   [Getting Started](#getting-started)
    *   [Prerequisites](#prerequisites)
    *   [Installation](#installation)
    *   [Usage](#usage)
*   [Features](#features)
*   [Database Structure](#database-structure)
*   [AJAX Endpoints](#ajax-endpoints)
*   [Testing](#testing)

## Overview

Distribusi Produk is a comprehensive web application designed to streamline product distribution management through a modern, scalable architecture. It combines a sleek frontend built with Vite, Tailwind CSS, jQuery, and Axios with a robust Laravel backend that handles complex data transactions and distribution workflows.

### Why `distribusi-produk`?

This project aims to simplify and optimize product distribution processes. The core features include:

*   🚀 **Modern Frontend**: Utilizes Vite, Tailwind CSS, and Axios for fast, responsive interfaces and efficient asset management.
*   📦 **Laravel CLI Integration**: Facilitates seamless execution of backend commands, migrations, and maintenance tasks.
*   📊 **Dynamic Data Handling**: Implements AJAX and DataTables for real-time, server-side data interactions and advanced filtering capabilities.
*   🔒 **Secure & Scalable**: Configurable session, queue, and storage options support growth and security.
*   ✅ **Testing & Seeding**: Includes seeders and factories for reliable testing and initial setup.

## Getting Started

### Prerequisites

This project requires the following dependencies:

*   **Programming Language**: PHP (>= 8.1)
*   **Framework**: Laravel (>= 10.x)
*   **Package Managers**: Npm (Node.js >= 16.x) and Composer
*   **Database**: MySQL (or compatible)

### Installation

To build `distribusi-produk` from the source and install dependencies:

1.  **Clone the repository**:

    ```bash
    git clone https://github.com/username/distribusi-produk.git
    ```
    *Replace `username/distribusi-produk.git` with your actual repository URL.*

2.  **Navigate to the project directory**:

    ```bash
    cd distribusi-produk
    ```

3.  **Install the dependencies**:

    **Using npm (for frontend assets)**:

    ```bash
    npm install
    ```

    **Using Composer (for backend dependencies)**:

    ```bash
    composer install
    ```

4.  **Configure Environment**:
    *   Copy the `.env.example` file to `.env`:
        ```bash
        cp .env.example .env
        ```
    *   Generate an application key:
        ```bash
        php artisan key:generate
        ```
    *   Configure your database credentials in the `.env` file.

5.  **Run Migrations and Seeders**:

    ```bash
    php artisan migrate:fresh --seed
    ```
    This command will run all migrations and seed your database with initial data (admin, barista, products, and sample distributions).

### Usage

To run the project:

1.  **Start the Vite development server (for frontend hot-reloading)**:

    ```bash
    npm run dev
    ```

2.  **Start the Laravel development server**:

    ```bash
    php artisan serve
    ```

    The application will typically be accessible at `http://127.0.0.1:8000` (or `localhost:8000`).

## Features

This application provides the following key features:

1.  **Halaman Index (distributions.index)**
    *   **Tujuan**: Melihat daftar distribusi produk yang sudah pernah dilakukan.
    *   **Fitur**: Menggunakan AJAX dan DataTables server-side dengan kolom Tanggal Distribusi, Barista, Total Quantity, Estimasi Penjualan, Notes, dan Tombol Aksi (Detail, Hapus).
    *   **Detail Modal**: Modal detail muncul saat klik tombol detail untuk melihat produk yang didistribusikan.
    *   **Filter Kustom**: Dilengkapi dengan filter rentang tanggal dan rentang estimasi penjualan untuk pencarian data yang lebih spesifik.

2.  **Halaman Form Tambah Distribusi (distributions.create)**
    *   **Tujuan**: Menambah transaksi distribusi baru.
    *   **Flow User**: Pilih barista, tambahkan produk secara dinamis ke tabel sementara dengan input kuantitas. Total kuantitas dan estimasi penjualan diperbarui secara real-time.
    *   **Penyimpanan Transaksional**: Menyimpan header distribusi dan mengaitkan semua detail produk (sementara) ke distribusi tersebut dalam satu transaksi.

## Database Structure

### `users`
*   `id`
*   `name`
*   `email`
*   `password`
*   `active` (boolean)

### `products`
*   `id`
*   `name`
*   `price`
*   `active` (boolean)

### `distributions`
*   `id`
*   `barista_id` (FK users)
*   `total_qty`
*   `estimated_result`
*   `notes`
*   `created_by` (admin id, FK users)
*   `created_at`
*   `updated_at`

### `distribution_details`
*   `id`
*   `distribution_id` (FK distributions, nullable saat masih sementara)
*   `product_id` (FK products)
*   `qty`
*   `price`
*   `total`
*   `created_by` (admin id, FK users)
*   `created_at`
*   `updated_at`

## AJAX Endpoints

*   `GET /distributions` (DataTable list)
*   `POST /distributions` (simpan distribusi)
*   `GET /distribution-products` (DataTable produk sementara)
*   `POST /distribution-products` (Tambah produk sementara)
*   `DELETE /distribution-products/{id}` (hapus produk dari list sementara)

## Testing

`distribusi-produk` uses PHPUnit for backend testing. Run the test suite with:

```bash
vendor/bin/phpunit
```
