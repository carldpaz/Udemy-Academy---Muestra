# Belle-Academy-Udemy
<h3>Login</h3><br> 
Para el inicio de sesión de los usuarios se debe enviar una petición GET a la url /login/external/.

Con un JWT que debe contener los siguientes parámetros:<br>
first_name (*obligatorio)<br>
last_name<br>
email (*obligatorio)<br>
level (Por defecto 0) A definir

Ejemplo de la URL para la petición:

https://academy.belleoficial.com/login/external?user=eyJ0eXAkljafnljksdolfgbsdgbjloldgbyX2lkIjoiMCIsInJvbGUiOiJhcGkiLCJmaXJzdF9uYW1lIjoiYmFja29mZmljZSJ9.X6qtlfZyjhGsWyQiqj_fwejkltgboogh8Zn-uE

<h3>Consultar Usuario</h3><br>
Para consultar un usuario se debe enviar una petición GET a la url /api/getuserdata/.

Con los siguientes parámetros:<br>
email (*obligatorio)<br>
auth_token (*obligatorio)


Ejemplo de la URL para la petición:

https://academy.belleoficial.com/api/getuserdata?email=prueba2%40correo.com&auth_token=eyJ0eeyJ0eXAkljafnljksdolfgbsdgbjloldgbyX2lkIjoiMCIsInJvbGUiOiJhcGkiLCJmaXJzdF9uYW1lIjoiYmFja29mZmljZSJ9

La respuesta que se devuelve es en formato JSON:

<h5>El usuario existe:</h5>
'{<br>
"result":true,<br>
"id":"26",<br>
"first_name":"Prueba",<br>
"last_name":"dos",<br>
"email":"prueba2@correo.com"<br>
}'

<h5>El usuario no existe:</h5>
'{<br>
"result": false,<br>
"error":"No se encon traron resultados"<br>
}’<br>

<h5>No se envió el token o es incorrecto:</h5>
'{<br>
"result": false,<br>
"error": "El token es incorrecto"<br>
}'


