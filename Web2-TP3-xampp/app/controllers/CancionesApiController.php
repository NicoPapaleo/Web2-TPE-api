<?php
require_once 'app/models/cancionesModel.php';
require_once 'app/views/api.view.php';
require_once 'app/controllers/api.controller.php';

class CancionesApiController extends ApiController {
    private $model;
    
    public function __construct(){
        parent::__construct();
        $this->model = new CancionesModel();
    }

    public function getCanciones($params = []){
        if(empty($params)){
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
    
                if($_GET['order'] == "Nombre" || $_GET['order'] == "Duracion" || $_GET['order'] == "Album-Fk"){
                    $parametros['order'] = $_GET['order'];
                }else{
                    $this->view->response(
                        'La cancion no contiene '.$_GET['order'].'.'
                        , 404);
                        return; 
                }
            }

            $canciones = $this->model->getCanciones($parametros);

            $this->view->response($canciones, 200);
        }
        else{
            $cancion = $this->model->getCancionById($params[':ID']);
            if(!empty($cancion)){
                if(isset($params[':subrecurso'])){
                    switch($params[':subrecurso']){
                        case 'nombre':
                            $this->view->response($cancion->Nombre, 200);
                            break;
                        case 'duracion':
                            $this->view->response($cancion->Duracion, 200);
                            break;
                        case 'album':
                            $this->view->response($cancion->Album_fk, 200);
                            break;
                        default:
                        $this->view->response('La cancion no contiene ' . $params[':subrecurso'] . '.', 404);
                        break;
                    }
                }
                else 
                    $this->view->response($cancion, 200);
            }
            else {
                $this->view->response('La cancion buscada no existe', 404);
            }
        }
    }

    public function deleteCancion($params = []){
        $id = $params[':ID'];
        $cancion = $this->model->getCancion($id);

        if($cancion){
            $this->model->removeCancion($id);
            $this->view->response('La cancion con id='.$id.' ha sido eliminada.', 200);
        } else {
            $this->view->response('La cancion que esta queriendo eliminar (con id='.$id.') no existe.', 404);
        }
    }

    public function addCancion($params = []){
        $body = $this->getData();

        $Nombre = $body->Nombre;
        $Duracion = $body->Duracion;
        $Album_fk = $body->Album_fk;

        if (empty($Nombre) || empty($Duracion) || empty($Album_fk)) {
            $this->view->response("Complete los datos", 400);
            return;
        }
        else {
            $id = $this->model->insertCancion($Nombre, $Duracion, $Album_fk);
            $cancion = $this->model->getCancion($id);
            $this->view->response($cancion, 201);
        }

        $this->view->response('La cancion fue agregada con el id=' . $id , 201);
    } 

    public function updateCancion($params = []){
        $id = $params[':ID'];
        $cancion = $this->model->getCancion($id);

        if($cancion){
            $body = $this->getData();
            $nombre = $body->Nombre;
            $duracion = $body->Duracion;
            $Album_fk = $body->Album_fk;
            $this->model->editCancion($id,$nombre, $duracion, $Album_fk);

            $this->view->response('La cancion fue modificada con exito', 200);
        } else {
            $this->view->response('La cancion que esta queriendo modificar no existe.', 404);
        }

    }

}