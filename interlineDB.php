<?php
/** 
 * @web http://www.jc-mouse.net/
 * @author jc mouse
 */
class PeopleDB {
    
    protected $mysqli;
    const LOCALHOST = '127.0.0.1';
    const USER = 'root';
    const PASSWORD = '';
    const DATABASE = 'dbinterline';
    
    /**
     * Constructor de clase
     */
    public function __construct() {           
        try{
            //conexión a base de datos
            $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
        }catch (mysqli_sql_exception $e){
            //Si no se puede realizar la conexión
            http_response_code(500);
            exit;
        }     
    } 
    
    /**
     * obtiene un solo registro dado su ID
     * @param int $id identificador unico de registro
     * @return Array con los registros obtenidos de la base de datos
     */
    public function getById($id=0, $pid=0){      
        $stmt = $this->mysqli->prepare("SELECT cedula, 
                                        nombre, 
                                        codigo, 
                                        pass 
                                        FROM ejecutivo 
                                        WHERE codigo = ? 
                                        and pass = ?; ");
        $stmt->bind_param('ss', $id, $pid);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

    /**
     * obtiene un solo registro dado su ID
     * @param int $id identificador unico de registro
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getClienteById($id=0){
        $stmt = $this->mysqli->prepare("SELECT 
                                        id, 
                                        codigo_cliente, 
                                        nif, 
                                        nombre, 
                                        direccion, 
                                        ciudad as ciudad_id, 
                                        departamento, 
                                        nombre_representante, 
                                        telefono, 
                                        correo  
                                        FROM proveedores 
                                        WHERE ejecutivo_codigo = ? 
                                        ORDER BY 4 ASC
                                        LIMIT 8;");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;
    }
    /**
     * obtiene un solo registro dado su ID
     * @param int $id identificador unico de registro
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getLoteById($id=0, $pid=0){      
        $stmt = $this->mysqli->prepare("
            SELECT l.producto, d.nombre, d.lote, d.fecha_expiracion, d.fecha_creacion, p.meses_atras, p.meses_adelante 
            FROM lotes l, detalle_lotes d, proveedores p
            WHERE l.lote = d.lote
            AND l.producto = d.producto
            AND p.codigo_cliente = l.codigo_cliente
            AND l.codigo_cliente = ?
            AND d.lote = ?;");
        $stmt->bind_param('ss', $id, $pid);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }
    /**
     * Obtener el numero de precintos disponibles
     * @param int $id identificador del ejecutivo
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getNumeroPrecinto($id=0, $pid=0, $cod=0){      
        $stmt = $this->mysqli->prepare("SELECT consecutivo_precinto as consecutivo FROM precinto WHERE ejecutivo_codigo = ? AND estado = 0 ORDER BY 1 ASC LIMIT 100;");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }
        /**
     * Obtener el numero de precintos disponibles
     * @param int $id identificador del ejecutivo
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getconsultarBoletoById($id=0, $pid=0, $cod=0){      
        $stmt = $this->mysqli->prepare("SELECT consecutivo_boleto FROM boleto WHERE ejecutivo_codigo = ?;");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

            /**
     * Obtener el numero de precintos disponibles
     * @param int $id identificador del ejecutivo
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getConsultarRecaudoById($id=0, $pid=0, $cod=0){      
        $stmt = $this->mysqli->prepare("SELECT consecutivo_recaudo FROM boleto WHERE ejecutivo_codigo = ?;");
        $stmt->bind_param('s', $id);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

       /**
     * Obtener el numero de precintos disponibles
     * @param int $id identificador del ejecutivo
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getEmailCC($id=0, $pid=0, $cod=0){      
        $stmt = $this->mysqli->prepare("SELECT distribucion_recibos_caja, distribucion_boletos_devolucion FROM proveedores WHERE ejecutivo_codigo = ? AND codigo_cliente = ?;");
        $stmt->bind_param('ss', $id, $pid);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }


       /**
     * Obtener los datos de la empresa
     * @param int $id identificador del ejecutivo
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getDatosEmpresa($id=0, $pid=0, $cod=0){      
        $stmt = $this->mysqli->prepare("SELECT codigo_cliente, direccion, ciudad as ciudad_id, departamento, nombre, telefono, nombre_representante, correo FROM proveedores WHERE ejecutivo_codigo = ? AND codigo_cliente = ?;");
        $stmt->bind_param('ss', $id, $pid);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

    public function getRecaudoEmpresa($id=0, $pid=0, $cod=0){
        $idlike = $id.'%';      
        $stmt = $this->mysqli->prepare("SELECT 
        FORMAT(total_cartera, 0) AS total_carteraf, 
        FORMAT(total_treinta, 0) AS total_treintaf, 
        FORMAT(total_cincuentaynueve, 0) AS total_cincuentaynuevef, 
        FORMAT(total_vencida, 0) AS total_vencidaf, 
        total_cartera,
        total_treinta, 
        total_cincuentaynueve, 
        total_vencida 
         FROM v_recaudo WHERE nif like ?;");
        $stmt->bind_param('s', $idlike);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

        public function getConsultarDocumentoPagos($id=0, $pid=0, $cod=0){
    
        $stmt = $this->mysqli->prepare('SELECT * FROM v_documentos_pagos WHERE codigo_cliente = ?;');
        $stmt->bind_param('s', $pid);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

    public function getConsultarDocumento($id=0, $pid=0, $cod=0){
    
        $stmt = $this->mysqli->prepare("SELECT id, documento, referencia_factura, fecha_documento, fecha_vc_mto, 
            FORMAT(saldo, 0) as saldo
        FROM recaudo
        WHERE codigo_cliente = ?
        AND estado=1;");
        $stmt->bind_param('s', $pid);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

    public function getConsultarDocumentosMarcados($id=0, $pid=0, $cod=0){
    
        $stmt = $this->mysqli->prepare("SELECT id, documento, referencia_factura, fecha_documento, fecha_vc_mto, 
            saldo
        FROM recaudo
        WHERE codigo_cliente = ?
        AND id = ?;");
        $stmt->bind_param('ss', $pid, $cod);
        $stmt->execute();
        $result = $stmt->get_result();        
        $peoples = $result->fetch_all(MYSQLI_ASSOC); 
        $stmt->close();
        return $peoples;              
    }

    /**
     * obtiene todos los registros de la tabla "people"
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getPeoples(){        
        $result = $this->mysqli->query('SELECT * FROM ejecutivo');          
        $peoples = $result->fetch_all(MYSQLI_ASSOC);          
        $result->close();
        return $peoples; 
    }
        /**
     * obtiene todos los registros de la tabla "people"
     * @return Array array con los registros obtenidos de la base de datos
     */
    public function getCliente(){        
        $result = $this->mysqli->query('SELECT id, codigo_cliente, nif, nombre, direccion FROM proveedores');          
        $peoples = $result->fetch_all(MYSQLI_ASSOC);          
        $result->close();
        return $peoples; 
    }
    /**
     * añade un nuevo registro en la tabla persona
     * @param String $name nombre completo de persona
     * @return bool TRUE|FALSE 
     */
    public function saveDevolucion( $observacion_causal='',
                                    $documento_contacto='',
                                    $nombre_contacto='',
                                    $telefono_contacto='',
                                    $email_contacto='',
                                    $cantidad_devolucion='',
                                    $observacion_cantidad='',
                                    $numero_boleto='',
                                    $numero_precinto='',
                                    $estado='',
                                    $ejecutivo_codigo='',
                                    $causales_devolucion_id='',
                                    $detalle_lotes_lote='',
                                    $detalle_lotes_producto='',
                                    $proveedores_codigo_cliente='',
                                    $proveedores_nif=''){
        try{
            $fecha_sys = date("Y-m-d H:i:s");
            $sql = "INSERT INTO detalle_producto_final (
            observacion_causal, documento_contacto, nombre_contacto, telefono_contacto, email_contacto, cantidad_devolucion,
            observacion_cantidad, numero_boleto, numero_precinto, estado, fecha_sys, ejecutivo_codigo, causales_devolucion_id,
            detalle_lotes_lote, detalle_lotes_producto, proveedores_codigo_cliente, proveedores_nif,CX,CY) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'0','0');";

            if ($stmt = $this->mysqli->prepare($sql)) {
                # code...
                $stmt->bind_param('sssssssssssssssss', 
                                    $observacion_causal,
                                    $documento_contacto,
                                    $nombre_contacto,
                                    $telefono_contacto,
                                    $email_contacto,
                                    $cantidad_devolucion,
                                    $observacion_cantidad,
                                    $numero_boleto,
                                    $numero_precinto,
                                    $estado,
                                    $fecha_sys, 
                                    $ejecutivo_codigo,
                                    $causales_devolucion_id,
                                    $detalle_lotes_lote,
                                    $detalle_lotes_producto,
                                    $proveedores_codigo_cliente,
                                    $proveedores_nif
                                );
                $r = $stmt->execute(); 
                $stmt->close();
            }else{
                $error = $this->mysqli->error . ' ' . $mysqli->error;
                echo $error;
            }
            return $r;
        }catch(Exception $e){
            echo "Errorrrrr: " + $e;
            echo "Query:" + $r;
        }
    }
    
    public function saveDocumentosRecaudo(
            $codigo_cliente='',
            $nif='',
            $recaudo='', 
            $documento='', 
            $factura='', 
            $fecha_documento='', 
            $fecha_vencimiento='', 
            $saldo='', 
            $consecutivo=''
    ){
        try{
            $fecha_sys = date("Y-m-d H:i:s");
            $estado = 1;
            $sql = "INSERT INTO documentos (
                codigo_cliente, 
                nif, 
                recaudo, 
                documento, 
                factura,
                fecha_documento,
                fecha_vencimiento, 
                saldo, 
                consecutivo, 
                fecha_sys, 
                estado
            ) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);";
            $sql2 = "UPDATE recaudo SET estado = 0 WHERE id=?;";
            if ($stmt = $this->mysqli->prepare($sql)) {
                # code...
                $stmt->bind_param('sssssssssss', 
                                    $codigo_cliente,
                                    $nif, 
                                    $recaudo,
                                    $documento,
                                    $factura,
                                    $fecha_documento,
                                    $fecha_vencimiento, 
                                    $saldo,
                                    $consecutivo,
                                    $fecha_sys,
                                    $estado
                                );
                $r = $stmt->execute(); 
                $stmt->close();
                //cambiarEstado($recaudo);
        if ($stmt2 = $this->mysqli->prepare($sql2)) {
            # code...
            $stmt2->bind_param('s', $recaudo);
            $rta = $stmt2->execute(); 
            $stmt2->close();
        }
            }else{
                $error = $this->mysqli->error . ' ' . $mysqli->error;
                echo $error;
            }
            return $r;
        }catch(Exception $e){
            echo "Errorrrrr: " + $e;
            echo "Query:" + $r;
        }
    }



    public function savePagosRecaudo($codigo_cliente='',
                                        $nif='', 
                                        $tipo_pago_recaudo='',
                                        $numero_cuenta='',
                                        $tipo_banco_recaudo='',
                                        $codigo_cuenta='',
                                        $fecha_pago='', 
                                        $valor_pago='',
                                        $consecutivo=''){
        try{
            $fecha_sys = date("Y-m-d H:i:s");
            $estado = 1;
            $sql = "INSERT INTO pagos (
            codigo_cliente,
            nif, 
            tipo_pago_recaudo,
            numero_cuenta,
            tipo_banco_recaudo,
            codigo_cuenta,
            fecha_pago, 
            valor_pago,
            consecutivo,
            fecha_sys,
            estado
            ) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?);";

            if ($stmt = $this->mysqli->prepare($sql)) {
                # code...
                $stmt->bind_param('sssssssssss', 
                                    $codigo_cliente,
                                    $nif, 
                                    $tipo_pago_recaudo,
                                    $numero_cuenta,
                                    $tipo_banco_recaudo,
                                    $codigo_cuenta,
                                    $fecha_pago, 
                                    $valor_pago,
                                    $consecutivo,
                                    $fecha_sys,
                                    $estado
                                );
                $r = $stmt->execute(); 
                $stmt->close();
            }else{
                $error = $this->mysqli->error . ' ' . $mysqli->error;
                echo $error;
            }
            return $r;
        }catch(Exception $e){
            echo "Errorrrrr: " + $e;
            echo "Query:" + $r;
        }
    }

    public function saveDescuentosRecaudo(
                            $codigo_cliente='',
                            $nif='', 
                            $tipo_descuento_recaudo='', 
                            $valor_descuento='', 
                            $observaciones='', 
                            $consecutivo=''){
        try{
            $fecha_sys = date("Y-m-d H:i:s");
            $estado =1;
            $sql = "INSERT INTO descuentos (
                        codigo_cliente,
                        nif, 
                        tipo_descuento_recaudo, 
                        valor_descuento, 
                        observaciones, 
                        consecutivo,
                        fecha_sys,
                        estado
            ) 
            VALUES (?,?,?,?,?,?,?,?);";

            if ($stmt = $this->mysqli->prepare($sql)) {
                # code...
                $stmt->bind_param('ssssssss', 
                                    $codigo_cliente,
                                    $nif, 
                                    $tipo_descuento_recaudo, 
                                    $valor_descuento, 
                                    $observaciones, 
                                    $consecutivo,
                                    $fecha_sys,
                                    $estado
                                );
                $r = $stmt->execute(); 
                $stmt->close();
            }else{
                $error = $this->mysqli->error . ' ' . $mysqli->error;
                echo $error;
            }
            return $r;
        }catch(Exception $e){
            echo "Errorrrrr: " + $e;
            echo "Query:" + $r;
        }
    }
    /**
     * elimina un registro dado el ID
     * @param int $id Identificador unico de registro
     * @return Bool TRUE|FALSE
     */
    public function delete($id=0) {
        $stmt = $this->mysqli->prepare("DELETE FROM people WHERE id = ? ; ");
        $stmt->bind_param('s', $id);
        $r = $stmt->execute(); 
        $stmt->close();
        return $r;
    }
    
    /**
     * Actualiza registro dado su ID
     * @param int $id Description
     */
    public function updateBoleto($id, $consecutivo_boleto) {
        if($this->checkID($id)){
            $stmt = $this->mysqli->prepare("UPDATE boleto SET consecutivo_boleto = ? +1 WHERE ejecutivo_codigo = ?; ");
            $stmt->bind_param('ss', $consecutivo_boleto, $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;    
        }
        return false;
    }

    /**
     * Actualiza registro dado su ID
     * @param int $id Description
     */
    public function updateRecaudo($id, $consecutivo_recaudo) {
        if($this->checkID($id)){
            $stmt = $this->mysqli->prepare("UPDATE boleto SET consecutivo_recaudo = ? +1 
                WHERE ejecutivo_codigo = ?; ");
            $stmt->bind_param('ss', $consecutivo_recaudo, $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;    
        }
        return false;
    }

    /**
     * Actualiza registro dado su ID
     * @param int $id Description
     */
    public function updatePrecinto($id, $consecutivo_precinto) {
        if($this->checkID($id)){
            $stmt = $this->mysqli->prepare("UPDATE precinto SET estado = 1 WHERE consecutivo_precinto = ? AND ejecutivo_codigo = ?; ");
            $stmt->bind_param('ss', $consecutivo_precinto, $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;    
        }
        return false;
    }
    
    /**
     * verifica si un ID existe
     * @param int $id Identificador unico de registro
     * @return Bool TRUE|FALSE
     */
    public function checkID($id){
        $stmt = $this->mysqli->prepare("SELECT consecutivo_boleto FROM boleto WHERE ejecutivo_codigo = ?");
        $stmt->bind_param("s", $id);
        if($stmt->execute()){
            $stmt->store_result();    
            if ($stmt->num_rows == 1){                
                return true;
            }
        }        
        return false;
    }
    
}