Laraquiz
===

Laraquiz is a personal project I'm takling with the intent of becoming better at testing code. The goal is to experiment and learn what should be tested, what shouldn't, why or why not, and how. Testing has been a major pain point for me personally, but I see and understand the value in it. More importantly I've experienced the dire consequences of _not_ testing.

The primary goal is to improve my understanding and ability to apply testing and the SOLID principles.

Ironically enough, the app I decided to build for this project is a quiz maker for _testing_ yourself.

## Setup

### Laragon users
```
git clone https://github.com/DanJFletcher/laraquiz.git
cd laraquiz
composer install
cp .env.example .env
```
- Create a MySQL database
- Add DB credentials to `.env`
```
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
gulp
```
- Refresh Laragon
- Visit `laraquiz.dev`
