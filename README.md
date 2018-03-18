# Layanan

[![Join the chat at https://gitter.im/layanan/Lobby](https://badges.gitter.im/layanan/Lobby.svg)](https://gitter.im/layanan/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bantenprov/layanan/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/layanan/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bantenprov/layanan/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bantenprov/layanan/build-status/master)
[![Latest Stable Version](https://poser.pugx.org/bantenprov/layanan/v/stable)](https://packagist.org/packages/bantenprov/layanan)
[![Total Downloads](https://poser.pugx.org/bantenprov/layanan/downloads)](https://packagist.org/packages/bantenprov/layanan)
[![Latest Unstable Version](https://poser.pugx.org/bantenprov/layanan/v/unstable)](https://packagist.org/packages/bantenprov/layanan)
[![License](https://poser.pugx.org/bantenprov/layanan/license)](https://packagist.org/packages/bantenprov/layanan)
[![Monthly Downloads](https://poser.pugx.org/bantenprov/layanan/d/monthly)](https://packagist.org/packages/bantenprov/layanan)
[![Daily Downloads](https://poser.pugx.org/bantenprov/layanan/d/daily)](https://packagist.org/packages/bantenprov/layanan)

Layanan

### Install via composer

- Development snapshot

```bash
$ composer require bantenprov/layanan:dev-master
```

- Latest release:

```bash
$ composer require bantenprov/layanan
```

### Download via github

```bash
$ git clone https://github.com/bantenprov/layanan.git
```

#### Edit `config/app.php` :

```php
'providers' => [

    /*
    * Laravel Framework Service Providers...
    */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    //....
    Bantenprov\Layanan\LayananServiceProvider::class,
```

#### Lakukan migrate :

```bash
$ php artisan migrate
```

#### Publish database seeder :

```bash
$ php artisan vendor:publish --tag=layanan-seeds
```

#### Lakukan auto dump :

```bash
$ composer dump-autoload
```

#### Lakukan seeding :

```bash
$ php artisan db:seed --class=BantenprovLayananSeeder
```

#### Lakukan publish component vue :

```bash
$ php artisan vendor:publish --tag=layanan-assets
$ php artisan vendor:publish --tag=layanan-public
```
#### Tambahkan route di dalam file : `resources/assets/js/routes.js` :

```javascript
{
    path: '/dashboard',
    redirect: '/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
         path: '/dashboard/layanan',
         components: {
            main: resolve => require(['./components/views/bantenprov/layanan/DashboardLayanan.vue'], resolve),
            navbar: resolve => require(['./components/Navbar.vue'], resolve),
            sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
          },
          meta: {
            title: "Layanan"
           }
       },
        //== ...
    ]
},
```

```javascript
{
    path: '/admin',
    redirect: '/admin/dashboard/home',
    component: layout('Default'),
    children: [
        //== ...
        {
            path: '/admin/layanan',
            components: {
                main: resolve => require(['./components/bantenprov/layanan/Layanan.index.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Layanan"
            }
        },
        {
            path: '/admin/layanan/create',
            components: {
                main: resolve => require(['./components/bantenprov/layanan/Layanan.add.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Add Layanan"
            }
        },
        {
            path: '/admin/layanan/:id',
            components: {
                main: resolve => require(['./components/bantenprov/layanan/Layanan.show.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "View Layanan"
            }
        },
        {
            path: '/admin/layanan/:id/edit',
            components: {
                main: resolve => require(['./components/bantenprov/layanan/Layanan.edit.vue'], resolve),
                navbar: resolve => require(['./components/Navbar.vue'], resolve),
                sidebar: resolve => require(['./components/Sidebar.vue'], resolve)
            },
            meta: {
                title: "Edit Layanan"
            }
        },
        //== ...
    ]
},
```
#### Edit menu `resources/assets/js/menu.js`

```javascript
{
    name: 'Dashboard',
    icon: 'fa fa-dashboard',
    childType: 'collapse',
    childItem: [
        //== ...
        {
        name: 'Layanan',
        link: '/dashboard/layanan',
        icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

```javascript
{
    name: 'Admin',
    icon: 'fa fa-lock',
    childType: 'collapse',
    childItem: [
        //== ...
        {
        name: 'Layanan',
        link: '/admin/layanan',
        icon: 'fa fa-angle-double-right'
        },
        //== ...
    ]
},
```

#### Tambahkan components `resources/assets/js/components.js` :

```javascript
//== Layanan

import Layanan from './components/bantenprov/layanan/Layanan.chart.vue';
Vue.component('echarts-layanan', Layanan);

import LayananKota from './components/bantenprov/layanan/LayananKota.chart.vue';
Vue.component('echarts-layanan-kota', LayananKota);

import LayananTahun from './components/bantenprov/layanan/LayananTahun.chart.vue';
Vue.component('echarts-layanan-tahun', LayananTahun);

import LayananAdminShow from './components/bantenprov/layanan/LayananAdmin.show.vue';
Vue.component('admin-view-layanan-tahun', LayananAdminShow);

//== Echarts Group Egoverment

import LayananBar01 from './components/views/bantenprov/layanan/LayananBar01.vue';
Vue.component('layanan-bar-01', LayananBar01);

import LayananBar02 from './components/views/bantenprov/layanan/LayananBar02.vue';
Vue.component('layanan-bar-02', LayananBar02);

//== mini bar charts
import LayananBar03 from './components/views/bantenprov/layanan/LayananBar03.vue';
Vue.component('layanan-bar-03', LayananBar03);

import LayananPie01 from './components/views/bantenprov/layanan/LayananPie01.vue';
Vue.component('layanan-pie-01', LayananPie01);

import LayananPie02 from './components/views/bantenprov/layanan/LayananPie02.vue';
Vue.component('layanan-pie-02', LayananPie02);

//== mini pie charts


import LayananPie03 from './components/views/bantenprov/layanan/LayananPie03.vue';
Vue.component('layanan-pie-03', LayananPie03);

```

