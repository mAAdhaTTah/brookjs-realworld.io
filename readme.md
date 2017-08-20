# ![RealWorld Example App](logo.png)

> ### [`brookjs`][brookjs] plus [LightNCandy](php-hbs) (PHP) codebase containing real world examples (CRUD, auth, advanced patterns, etc) that adheres to the [RealWorld](https://github.com/gothinkster/realworld) spec and API.


### [Demo](#)&nbsp;&nbsp;&nbsp;&nbsp;[RealWorld](https://github.com/gothinkster/realworld)


This codebase was created to demonstrate a fully fledged fullstack application built with `brookjs` including CRUD operations, authentication, routing, pagination, and more.

We've gone to great lengths to adhere to the `brookjs` community styleguides & best practices.

For more information on how to this works with other frontends/backends, head over to the [RealWorld](https://github.com/gothinkster/realworld) repo.

This app is intended to function as a template and testing ground for brookjs tools, libraries, and paradigms.


# How it works

On the backend, the application is rendered with [LightNCandy](php-hbs), using the same Handlebars templates the front-end uses to render on the client side. The PHP uses PHP-DI & the Slim Framework for the dependency contaienr and routing.

On the frontend, [`brookjs`][brookjs] functions as a single page app, bootstrapping off the HTML provided by the PHP app. The client side app then runs, updating its data from the APIas it needed. The front-end app is thus server-rendered, providing a quick start on pageload.

# Getting started

Coming soon: Vagrant development environment.

For now, here's how to get started:

1. Make sure you have node, php, and composer installed.
2. `npm install && composer install && npm run build && php -S localhost:3000 -t public`

  [php-hbs]: https://github.com/zordius/lightncandy
  [brookjs]: https://valtech-nyc.github.io/brookjs/