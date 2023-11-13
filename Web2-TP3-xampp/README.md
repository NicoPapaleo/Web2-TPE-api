Explicacion de endpoints:

Tanto para las tablas de canciones como de albums se crearon los siguientes endpoints:

El GET de albums/canciones, esta funcion sirve para obtener una lista completa de la tabla que corresponda en el que se pueden añadir los siguientes parametros que se utilizan a continuacion de un signo de pregunta "?":

order="nombreColumna"
sort="ASC/DESC"
perPage="cantidad de objetos recibidos"
page="pagina requerida" (este va SI O SI utilizando el parametro "perPage").
filtroAutor="autor buscado" (el filtro solo se creo para albums y se busca por autor).
Ejemplo: ../api/albums?order=nombre&sort=DESC&filtrarAutor=Divididos&perPage=2&page=1

Todos estos parametros pueden ser concatenados mediante el signo "&".

El POST de albums/canciones, esta funcion sirve para crear una nueva fila en cualquiera de las tablas.
Ejemplo contenido del body albums:
    {
        "nombre": "bla",
        "autor": "Divididos",
        "fecha": "2012"
    } 

Ejemplo contenido del body canciones:
    {
        "Nombre": "Me gusta",
        "Duracion": "00:04:49",
        "Album_fk": 5
    }


El GET de albums/:ID o canciones/:ID, esta funcion sirve para obtener un album o cancion deseada mediante un ID.
Ejemplo: ../api/canciones/5

El DELETE de albums/:ID o canciones/:ID, esta funcion sirve para borrar un album o cancion con un ID especifico.
Ejemplo: ../api/canciones/5

El PUT de albums/:ID o canciones/:ID, esta funcion modifica un album o cancion existente mediante un ID especifico.
Ejemplo: ../api/canciones/5
Ejemplo contenido del body:
    {
        "Nombre": "Me gusta",
        "Duracion": "00:04:49",
        "Album_fk": 5
    }

Ejemplo: ../api/albums/5
Ejemplo contenido del body:
    {
        "nombre": "bla",
        "autor": "Divididos",
        "fecha": "2012"
    } 

El GET de albums/:ID/:subrecurso o canciones/:ID/:subrecurso, esta funcion sirve para acceder a un atributo deseado a partir del ID de un objeto especifico.
Ejemplo: ../api/canciones/5/Nombre
Ejemplo: ../api/albums/5/nombre
