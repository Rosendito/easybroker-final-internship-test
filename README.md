# Prueba técnica final de José Rosendo - Easybroker Internship

[![Tests](https://github.com/Rosendito/easybroker-final-internship-test/actions/workflows/tests.yaml/badge.svg)](https://github.com/Rosendito/easybroker-final-internship-test/actions/workflows/tests.yaml)


## Comentarios respecto a la API de EasyBroker
* Cuando haces una petición a un endpoint no existente devuelve un html con la página 404, si haces la petición como un XHR debería devolver una respuesta json con el código 404, sólo para evitar confusiones al momento de integrar la api con otros servicios.
* Al momento de realizar una petición (POST) al endpoint `/contact_request` y no pasas la propiedad `property_id` en el body de la petición devuelve el error "Debes especificar un nombre, correo o número telefónico" en vez de "Debes especificar una propiedad".
