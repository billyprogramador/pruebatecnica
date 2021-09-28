<?php
    @session_start();
    include_once("config.php");

    class Database extends PDO {

        public function __construct($DB_TYPE, $DB_HOST, $DB_NAME, $DB_USER, $DB_PASS) {


            parent::__construct($DB_TYPE . ":host=" . $DB_HOST . ";dbname=" . $DB_NAME, $DB_USER, $DB_PASS);
        }

        /**
         * @param String $sql Consulta SQL
         * @param Array $array Parámetros para el bindValue
         * @param constant $fetchMode Presentación datos. Asociativo por defecto
         * @return mixed
         */
        public function select($sql,$array = array(),$fetchall = true,$fetchMode = PDO::FETCH_ASSOC){
            $sth = $this->prepare($sql);//Formatear SQL : SELECT * FROM users WHERE user = :user

            foreach ( $array as $key => $value ){
                $sth->bindValue($key, $value); //Asociar Valores para SQL : user -> Nombre
            }

            $sth->execute();

            if($fetchall)return $sth->fetchAll($fetchMode);
            return $sth->fetch($fetchMode);
        }

        public function contar($sql){
             $sth = $this->prepare($sql);
             $sth->execute();
             $retorno = $sth->fetchAll();

            return $retorno[0];

        }

        /**
         *
         * @param String $table
         * @param Array $data Arreglo asociativo de Strings
         */
        public function insert($table, $data, $multidata = false){
            ksort($data);

            if($multidata){
                $fieldNames = implode('`, `', $multidata);
                $fieldValues = ':' . implode(', :',  $multidata);

                $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

                $error = false;
                $this->beginTransaction();

                foreach ($data as $key => $value) {
                    foreach ($value as $k => $v) {
                        $sth->bindValue(":$k", $v);
                    }
                    if(!$sth->execute()){
                        $error = true;
                        break;
                    }
                }

                if($error)return $this->rollBack();
                return $this->commit();

            }else{
                $fieldNames = implode('`, `',  array_keys($data));
                $fieldValues = ':' . implode(', :',  array_keys($data));
                // var_dump("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
                $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");

                foreach ($data as $key => $value){
                    $sth->bindValue(":$key", $value);
                }

                return $sth->execute();
            }

        }

        /**
         *
         * @param String $table Nombre tabla
         * @param Array $data Arreglo asociativo de Strings
         * @param String $where Condicion 'WHERE' de la consulta
         */
        public function update($table, $data, $where){
            ksort($data);

            $fieldDetails = NULL;

            foreach ($data as $key => $values){
                $fieldDetails .= "$key=:$key,";
            }

            $fieldDetails = rtrim($fieldDetails,',');

            if($where==NULL){
              $sth = $this->prepare("UPDATE $table SET $fieldDetails");
            }else{
              $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
            }


            foreach ($data as $key => $value){
                $sth->bindValue(":$key", $value);
            }

            return $sth->execute();
        }

        /**
         *
         * @param String $table Nombre tabla
         * @param Array $where Condicion 'WHERE' de la consulta
         * @param String $limit Límite condición
         */
        public function delete($table, $where){
            if($where==NULL){
              return $this->exec("DELETE FROM $table");
            }else{
              return $this->exec("DELETE FROM $table WHERE $where ");
            }
        }

        public function run($exec){
            $sth = $this->prepare($exec);
            return $sth->execute();
        }
    }
