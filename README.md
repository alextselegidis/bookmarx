<h1 align="center">
    <br>
    <a href="https://github.com/alextselegidis/bookmarx">
        <img src="https://raw.githubusercontent.com/alextselegidis/bookmarx/main/logo.png" alt="Bookmarx" width="150">
    </a>
    <br>
    Bookmarx
    <br>
</h1>

<br>

<h4 align="center">
    A simple Bookmark Manager App that can be installed on your server. 
</h4>

<p align="center">
  <img alt="GitHub" src="https://img.shields.io/github/license/alextselegidis/bookmarx?style=for-the-badge">
  <img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/alextselegidis/bookmarx?style=for-the-badge">
  <img alt="GitHub All Releases" src="https://img.shields.io/github/downloads/alextselegidis/bookmarx/total?style=for-the-badge">
</p>

<p align="center">
  <a href="#about">About</a> •
  <a href="#features">Features</a> •
  <a href="#setup">Setup</a> •
  <a href="#installation">Installation</a> •
  <a href="#demo-data">Demo Data</a> •
  <a href="#license">License</a>
</p>

![screenshot](screenshot.png)

## About

**Bookmarx** is a bookmark manager application, designed for simplicity and efficiency. Everyone knows that running 
any software to production requires a lot of care so that everything works according to the plan. With Bookmarx you 
can spectate the current health state of your systems in real time.

## Features

The application will allow you to manage and organize your bookmark links.

## Setup

To clone and run this application, you'll need Docker installed on your computer. From your command line:

```bash
# Clone this repository
$ git clone https://github.com/alextselegidis/bookmarx.git

# Go into the repository
$ cd bookmarx

# Install dependencies
$ docker compose up -d
```

Then you can SSH into the PHP-FPM container and install the dependencies with `composer install`. 

Note: the current setup works with Windows and WSL & Docker.

You can build the files by running `bash build.sh`. This command will bundle everything to a `build.zip` archive.

## Installation

You will need to perform the following steps to install the application on your server:

* Make sure that your server has Apache/Nginx, PHP (8.2+) and MySQL installed.
* Create a new database (or use an existing one).
* Copy the "bookmarx" source folder on your server.
* Make sure that the "storage" directory is writable.
* Rename the ".env.example" file to ".env" and update its contents based on your environment.
* Run the `php artisan migrate:fresh` command from the terminal.
* Open the browser on the Bookmarx URL and log in with admin@example.org and 12345678 as the password.

That's it! You can now use Bookmarx at your will.

You will find the latest release at [github.com/alextselegidis/bookmarx](github.com/alextselegidis/bookmarx).
You can also report problems on the [issues page](https://github.com/alextselegidis/bookmarx/issues)
and help the development progress.

## Demo Data

A dedicated `DemoSeeder` is available to populate the database with realistic
sample content (1 admin, 2 standard users, 50 curated bookmarks with tags,
roughly a third of which are archived). It is **not** wired into
`DatabaseSeeder` and will never run automatically — you have to invoke it
explicitly:

```bash
php artisan db:seed --class=DemoSeeder
```

The seeder is idempotent, so it can be re-run safely without producing
duplicate users, tags or links.

Demo accounts created (password for all: `12345678`):

| Role  | Email               |
|-------|---------------------|
| admin | admin@example.org   |
| user  | alice@example.org   |
| user  | bob@example.org     |

To start from a clean state and reseed everything in one go:

```bash
php artisan migrate:fresh
php artisan db:seed --class=DemoSeeder
```

## License

Code Licensed Under [GPL v3.0](https://www.gnu.org/licenses/gpl-3.0.en.html) | Content Under [CC BY 3.0](https://creativecommons.org/licenses/by/3.0/)

---

Website [alextselegidis.com](https://alextselegidis.com) &nbsp;&middot;&nbsp;
GitHub [alextselegidis](https://github.com/alextselegidis) &nbsp;&middot;&nbsp;
Twitter [@alextselegidis](https://twitter.com/AlexTselegidis)

###### More Projects On Github
###### ⇾ [Plainpad &middot; Self Hosted Note Taking App](https://github.com/alextselegidis/plainpad)
###### ⇾ [Easy!Appointments &middot; Online Appointment Scheduler](https://github.com/alextselegidis/easyappointments)
###### ⇾ [Integravy &middot; Service Orchestration At Your Fingertips](https://github.com/alextselegidis/integravy)
