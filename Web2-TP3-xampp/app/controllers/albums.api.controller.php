<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/views/api.view.php';
    require_once 'app/models/album.model.php';


class AlbumApiController extends ApiController {
    private $model;

    function __construct() {
        parent::__construct();
        $this->model = new AlbumModel();
    }

    function get($params = []) {
        if (empty($params)){
            $parametros = [];

            
            if(isset($_GET['perPage'])){
                $perPage = (INT)$_GET['perPage'];
            if(isset($_GET['page'])){
                $page = (INT)$_GET['page'];
                $offset = ($page - 1) * $perPage;
            }else{
                $offset = 0;
            }
            $parametros["perPage"] = $perPage;
            $parametros["offset"] = $offset;
            }
            
            if(isset($_GET['sort'])){
                $parametros['sort'] = $_GET['sort'];
            }
            if(isset($_GET['order'])){
    
                if($_GET['order'] == "nombre" || $_GET['order'] == "autor" || $_GET['order'] == "fecha"){
                    $parametros['order'] = $_GET['order'];
                }else{
                    $this->view->response(
                        'el album no contiene '.$_GET['order'].'.'
                        , 404);
                        return; 
                    }
                }
            
                    
            if(isset($_GET['filtrarAutor'])){
                $parametros['filtrarAutor'] = $_GET['filtrarAutor'];
            }


            $albums = $this->model->getAlbums($parametros);

            $this->view->response($albums, 200);
        } else {
            $album = $this->model->getAlbumById($params[':ID']);
            if(!empty($album)) {
                if(isset($params[':subrecurso'])) {
                    switch ($params[':subrecurso']) {
                        case 'nombre':
                            $this->view->response($album->nombre, 200);
                            break;
                        case 'autor':
                            $this->view->response($album->autor, 200);
                            break;
                        case 'fecha':
                            $this->view->response($album->fecha, 200);
                            break;
                        default:
                        $this->view->response(
                            'el album no contiene '.$params[':subrecurso'].'.'
                            , 404);
                            break;
                    }
                } else
                    $this->view->response($album, 200);
            } else {
                $this->view->response(
                    'el album con el id='.$params[':ID'].' no existe.'
                    , 404);
            }
        }
    }

    function delete($params = []) {
        $id = $params[':ID'];
        $album = $this->model->getAlbumById($id);

        if($album) {
            $this->model->removeAlbum($id);
            $this->view->response('el album con id='.$id.' ha sido borrado.', 200);
        } else {
            $this->view->response('el album con id='.$id.' no existe.', 404);
        }
    }
    function create($params = []) {
        $body = $this->getData();
        $nombre = $body->nombre;
        $autor = $body->autor;
        $fecha = $body->fecha;

        if (empty($nombre) || empty($autor) || empty($fecha)) {
            $this->view->response("Complete los datos", 400);
        } else {
            $id = $this->model->insertAlbum($nombre, $autor, $fecha);

            // en una API REST es buena práctica es devolver el recurso creado
            $album = $this->model->getAlbumById($id);
            $this->view->response($album, 201);
        }

    }

    function update($params = []) {
        $id = $params[':ID'];
        $album = $this->model->getAlbumById($id);

        if($album) {
            $body = $this->getData();
            $nombre = $body->nombre;
            $autor = $body->autor;
            $fecha = $body->fecha;
            $this->model->editAlbum($id, $nombre, $autor, $fecha);

            $this->view->response('El album con id='.$id.' ha sido modificada.', 200);
        } else {
            $this->view->response('El album con id='.$id.' no existe.', 404);
        }
    }
}



