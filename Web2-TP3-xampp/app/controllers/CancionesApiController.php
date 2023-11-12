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

            if(isset($_GET['sort'])){
                $parametros['sort'] = $_GET['sort'];
            }
            if(isset($_GET['order'])){
                $parametros['order'] = $_GET['order'];
            }
            if(isset($_GET['duracion'])){
                $parametros['duracion'] = $_GET['duracion'];
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
                $this->view->response('El album buscado no existe', 404);
            }
        }
    }

    // public function getCanciones($params = []){
    //     if(empty($params)){
    //         $canciones = $this->model->getCanciones();
    //         return $this->view->response($canciones, 200);
    //     }
    //     else{
    //         $cancion = $this->model->getCancion($params[":ID"]);
    //         if(!empty($cancion)){
    //             return $this->view->response($cancion, 200);
    //         }
    //         else{
    //             $this->view->response(['msg' => 'La cancion buscada no existe'], 404);
    //         }
    //     }
    // }

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

        $nombre = $body->Nombre;
        $duracion = $body->Duracion;
        $album_fk = $body->Album_fk;

        $id = $this->model->insertCancion($nombre, $duracion, $album_fk);

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