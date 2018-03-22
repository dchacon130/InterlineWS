<?php  
require_once "interlineDB.php";

class interlineAPI {

    public function API(){
        
        header('Content-Type: application/JSON');                
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
        case 'GET'://consultas
            $this->getInformacion();
            break; 
        case 'POST'://inserta
            $this->postInformacion();
            break;                
        case 'PUT'://actualiza
            $this->update();
            break;      
        case 'DELETE'://elimina
            $this->deletePeople();
            break;
        default://metodo NO soportado
            echo 'METODO NO SOPORTADO';
            break;
        }
    }

    /**
     * Respuesta al cliente
     * @param int $code Codigo de respuesta HTTP
     * @param String $status indica el estado de la respuesta puede ser "success" o "error"
     * @param String $message Descripcion de lo ocurrido
     */
     function response($code=200, $status="", $message="") {
        http_response_code($code);
        if( !empty($status) && !empty($message) ){
            $response = array("status" => $status ,"message"=>$message);  
            echo json_encode($response,JSON_PRETTY_PRINT);    
        }            
     }   

     /**
      * función que segun el valor de "action" e "id" y "pid":
      *  - mostrara una array con todos los registros de personas
      *  - mostrara un solo registro 
      *  - mostrara un array vacio
      */
function getInformacion(){
    /*Inicio Consulta*/
    if($_GET['action']=='consultarEjecutivo'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getById($_GET['id'],$_GET['pid']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/

    /*Inicio Consulta*/
    else if($_GET['action']=='consultarCliente'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getClienteById($_GET['id']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/

    /*Inicio Consulta*/
    else if($_GET['action']=='consultarLote'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getLoteById($_GET['id'],$_GET['pid']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/

    /*Inicio Consulta*/
    else if($_GET['action']=='consultarLotes'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getLoteById($_GET['id'],$_GET['pid']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/

        /*Inicio Consulta*/
    else if($_GET['action']=='consultarNumeroPrecinto'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getNumeroPrecinto($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
    /*Inicio Consulta*/
    else if($_GET['action']=='consultarBoletoById'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getconsultarBoletoById($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
        /*Inicio Consulta*/
    else if($_GET['action']=='consultarRecaudoById'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getConsultarRecaudoById($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
    /*Inicio Consulta*/
    else if($_GET['action']=='consultarEmailCC'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getEmailCC($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
    /*Inicio Consulta*/
    else if($_GET['action']=='consultarDatosEmpresa'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getDatosEmpresa($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
    /*Inicio Consulta*/
    else if($_GET['action']=='consultarRecaudoId'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getRecaudoEmpresa($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
        /*Inicio Consulta*/
    else if($_GET['action']=='consultarDocumento'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getConsultarDocumento($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
    /*Inicio Consulta*/
    else if($_GET['action']=='consultarDocumentoPagos'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getConsultarDocumentoPagos($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
            /*Inicio Consulta*/
    else if($_GET['action']=='consultarDocumentosMarcados'){
        $db = new PeopleDB();
        if(isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            $response = $db->getConsultarDocumentosMarcados($_GET['id'],$_GET['pid'], $_GET['cod']);
            echo json_encode($response,JSON_PRETTY_PRINT);
        }else{ //muestra todos los registros     
            $response = $db->getPeoples();
            echo json_encode($response,JSON_PRETTY_PRINT);
        }
    }/*Fin de consulta*/
    else{
        $this->response(400);
    }

}


     /**
      * metodo para guardar un nuevo registro de persona en la base de datos
      */
     function postInformacion(){
        /*GUARDAR DEVOLUCIÓN*/
         if($_GET['action']=='guardarDevolucion'){   
             //Decodifica un string de JSON
             $obj = json_decode( file_get_contents('php://input') );   
             $objArr = (array)$obj;
             if (empty($objArr)){
                 $this->response(421,"error","Nothing to add. Check json"); 
             }else if(isset($obj->observacion_causal)){
                $people = new PeopleDB();    
                $people->saveDevolucion($obj->observacion_causal, 
                                        $obj->documento_contacto,
                                        $obj->nombre_contacto,
                                        $obj->telefono_contacto, 
                                        $obj->email_contacto, 
                                        $obj->cantidad_devolucion, 
                                        $obj->observacion_cantidad, 
                                        $obj->numero_boleto, 
                                        $obj->numero_precinto, 
                                        $obj->estado, 
                                        $obj->ejecutivo_codigo,
                                        $obj->causales_devolucion_id,
                                        $obj->detalle_lotes_lote,
                                        $obj->detalle_lotes_producto,
                                        $obj->proveedores_codigo_cliente,
                                        $obj->proveedores_nif);
                    $this->response(200,"success","new record added"); 
             }else{
                 $this->response(422,"error","The property is not defined");
             }
         }
            /*GUARDAR DOCUMENTOS DE RECAUDO*/
        if($_GET['action']=='guardarRecaudoDocumentos'){   
             $obj = json_decode( file_get_contents('php://input') );   
             $objArr = (array)$obj;
             if (empty($objArr)){
                 $this->response(421,"error","Nothing to add. Check json"); 
             }else if(isset($obj->codigo_cliente)){
                $people = new PeopleDB();    
                $people->saveDocumentosRecaudo(
                            $obj->codigo_cliente,
                            $obj->nif,
                            $obj->recaudo, 
                            $obj->documento, 
                            $obj->factura, 
                            $obj->fecha_documento, 
                            $obj->fecha_vencimiento, 
                            $obj->saldo, 
                            $obj->consecutivo);
                    $this->response(200,"success","new record added",$people); 
             }else{
                 $this->response(422,"error","The property is not defined");
             }

         }

             /*GUARDAR PAGOS DE RECAUDO*/
        if($_GET['action']=='guardarRecaudoPagos'){   
             $obj = json_decode( file_get_contents('php://input') );   
             $objArr = (array)$obj;
             if (empty($objArr)){
                 $this->response(421,"error","Nothing to add. Check json"); 
             }else if(isset($obj->codigo_cliente)){
                $people = new PeopleDB();    
                $people->savePagosRecaudo(
                                        $obj->codigo_cliente,
                                        $obj->nif, 
                                        $obj->tipo_pago_recaudo,
                                        $obj->numero_cuenta,
                                        $obj->tipo_banco_recaudo,
                                        $obj->codigo_cuenta,
                                        $obj->fecha_pago, 
                                        $obj->valor_pago,
                                        $obj->consecutivo);
                    $this->response(200,"success","new record added"); 
             }else{
                 $this->response(422,"error","The property is not defined");
             }
         }
             /*GUARDAR DESCUENTOS DE RECAUDO*/
        if($_GET['action']=='guardarRecaudoDescuentos'){   
             $obj = json_decode( file_get_contents('php://input') );   
             $objArr = (array)$obj;
             if (empty($objArr)){
                 $this->response(421,"error","Nothing to add. Check json"); 
             }else if(isset($obj->codigo_cliente)){
                $people = new PeopleDB();    
                $people->saveDescuentosRecaudo(
                                        $obj->codigo_cliente,
                                        $obj->nif, 
                                        $obj->tipo_descuento_recaudo, 
                                        $obj->valor_descuento, 
                                        $obj->observaciones, 
                                        $obj->consecutivo);
                    $this->response(200,"success","new record added"); 
             }else{
                 $this->response(422,"error","The property is not defined");
             }
         } 
     }
     

     /**
     * Actualiza un recurso
     */
    function update() {
        if( isset($_GET['id']) && isset($_GET['pid']) && isset($_GET['cod'])){
            /*Inicia update*/
            if($_GET['action']=='actualizarBoleto'){
                $obj = json_decode( file_get_contents('php://input') );   
                $objArr = (array)$obj;
                if (empty($objArr)){                        
                    $this->response(422,"error","Nothing to add. Check json");                        
                }else if(isset($obj->consecutivo_boleto)){
                    $db = new PeopleDB();
                    $db->updateBoleto($_GET['id'], $obj->consecutivo_boleto);
                    $this->response(200,"success","Record updated");                             
                }else{
                    $this->response(422,"error","The property is not defined");                        
                }     
                exit;
           }
           /*finaliza update*/
            /*Inicia update*/
            if($_GET['action']=='actualizarPrecinto'){
                $obj = json_decode( file_get_contents('php://input') );   
                $objArr = (array)$obj;
                if (empty($objArr)){                        
                    $this->response(422,"error","Nothing to add. Check json");                        
                }else if(isset($obj->consecutivo_precinto)){
                    $db = new PeopleDB();
                    $db->updatePrecinto($_GET['id'], $obj->consecutivo_precinto);
                    $this->response(200,"success","Record updated");                             
                }else{
                    $this->response(422,"error","The property is not defined");                        
                }     
                exit;
           }
           /*finaliza update*/
           /*Inicia update*/
            if($_GET['action']=='actualizarConsecutivoRecaudo'){
                $obj = json_decode( file_get_contents('php://input') );   
                $objArr = (array)$obj;
                if (empty($objArr)){                        
                    $this->response(422,"error","Nothing to add. Check json");                        
                }else if(isset($obj->consecutivo_recaudo)){
                    $db = new PeopleDB();
                    $db->updateRecaudo($_GET['id'], $obj->consecutivo_recaudo);
                    $this->response(200,"success","Record updated");                             
                }else{
                    $this->response(422,"error","The property is not defined");                        
                }     
                exit;
           }
           /*finaliza update*/
        }
        $this->response(400);
    }
    
    /**
     * elimina persona
     */
    function deletePeople(){
        if( isset($_GET['action']) && isset($_GET['id']) ){
            if($_GET['action']=='peoples'){                   
                $db = new PeopleDB();
                $db->delete($_GET['id']);
                $this->response(204);                   
                exit;
            }
        }
        $this->response(400);
    }
}//end class
?>