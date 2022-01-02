# Prueba técnica final de José Rosendo - Easybroker Internship

[![Tests](https://github.com/Rosendito/easybroker-final-internship-test/actions/workflows/tests.yaml/badge.svg)](https://github.com/Rosendito/easybroker-final-internship-test/actions/workflows/tests.yaml)

## Objetivo

Crear un sitio web para una agencia de bienes raices que vende propiedades de la base de datos de [Easybroker](https://www.easybroker.com/). Crear página de listado de propiedades y página de detalle de propiedad.

## Características del test
* Language: [PHP 8.0](https://www.php.net/)
* Test runner: [PHPUnit](https://phpunit.de/)

## Heroku app

Puedes probar tu aplicación en [Heroku app](https://easybroker-test.herokuapp.com/).

## Correr en local

1. Instalar [PHP 8.0](https://www.php.net/downloads.php)
2. Clonar el repositorio
3. Copiar el archivo .env.example a .env `cp .env.example .env`
4. Instalar dependencias `composer install`
5. Correr los tests con `php artisan test`
6. Iniciar el servidor con `php artisan serve` 

## Notas

### Decisiones de diseño

He optado por organizar mi proyecto en acciones, es una practica que he tomado en mis últimos proyectos de Laravel.

Para mi es una practica satisfactoria, ya que como dice el autor de la librería [Laravel Actions](https://laravelactions.com/) en vez de enfocarme en:

> "What controllers do I need?", "should I make a FormRequest for this?", "should this run asynchronously in a job instead?

me enfoque en:

> "What does my application actually do?"

En lo referente a los tests, he intentado tener el mayor porcetaje de test coverage posible, aislando los tests con mocks para probar únicamente lo que necesito en el momento. Debido a esto tuve varios problemas con el mocking de las peticiones a la API de Easybroker por el hecho de que nunca he realizado esta práctica, sin embargo, he conseguido lograrlo y así tener una mayor cobertura de prueba.

Con respecto al frontend, he utilizado [Bulma](https://bulma.io/) como framework de diseño y he intentado hacer la interfaz lo más amigable posible.

### Puntos mejorables

1. En los tests del servicio `EasyBrokerService` creo que he sido redundante, probablemente debí probar únicamente los métodos `getSuccessRespone`, `getErrorResponse`, `fetch` y `submit` ya que los métodos `getProperties`, `showProperties` y `saveContactRequest` son simples wrappers de estos métodos. Con los otros tests de la aplicación, tanto features y unitarios pude haber obtenido un gran porcentaje de test coverage igualmente.
2. El paginador del listado de propietarios no muestra correctamente los items de las páginas, pero ya por falta de tiempo no pude arreglarlo.
3. Laravel ofrece un gran abánico de herramientas para probar la web (vistas y componentes), creo que hubiese sido innecesario para la prueba agregarlos pero de haberme sobrado tiempo los podría haber incorporado para al menos tener la experiencia.
4. En general creo que los tests pudieron haber sido más simples y menos repetitivos.
## Comentarios respecto a la API de EasyBroker
* Cuando haces una petición a un endpoint no existente devuelve un html con la página 404, si haces la petición como un XHR debería devolver una respuesta json con el código 404, sólo para evitar confusiones al momento de integrar la api con otros servicios.
