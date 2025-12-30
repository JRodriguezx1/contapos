<?php

namespace App\Repositories;

abstract class operationRepository extends BaseRepository{

    protected string $table;
    protected string $entityClass;
    protected array $allowedColumns = [];


    public function insert(object $entity): array
    {
        $data = $entity->toArray();
        $cols = implode(', ', array_keys($data));
        $vals = implode("', '", array_map( fn($v)=>$this->escape((string)$v), array_values($data) ));
        $sql = "INSERT INTO {$this->table} ({$cols}) VALUES ('{$vals}');";
        $sql = str_replace("''", 'NULL', $sql);
        $resultado = self::$db->query($sql);
        return [$resultado, self::$db->insert_id];  //insert_id retorna el ultimo registro insertado en la bd
           //  [true/false, id=1,2,3...00] = [0,1] 
    }


    public function crear_varios_reg_arrayobj($arrays = []){  // $arrays = [{'col1':a, 'col2':b}, {'col1':c, 'col2':d}, ...] 
        $string2 = '';

        foreach($arrays as $key => $obj){
            // si viene como stdClass → convertir a array
            if($obj instanceof \stdClass)$array = (array)$obj;
            //crear entidad tipada
            $model = new $this->entityClass($array);
            $row = [];
            //mapeo
            foreach($this->allowedColumns as $colDB)
                $row[$colDB] = $model->$colDB??null;
            
            //tomar el arreglo de valores del objeto instanciado y se sanatiza
            $datos = array_map( fn($v)=>$this->escape((string)$v), array_values($row) );

            if(array_key_last($arrays) == $key){
                $string2 .= "('".join("', '", $datos)."');";
            }else{
                $string2 .= "('".join("', '", $datos)."'), ";
            }
        }
        $string2 = str_replace("'NULL'", 'NULL', $string2);
        $string1 = join(', ', array_keys($row));
        $sql = "INSERT INTO ".$this->table."(".$string1.") VALUES".$string2;
        $resultado = self::$db->query($sql);
        //INSERT INTO empserv(idempleado, idservicio) VALUES('3', '3'), ('3', '1');
        return [$resultado, self::$db->insert_id];
    }




    public function delete(int $id): bool
    {
        return self::$db->query("DELETE FROM {$this->table} WHERE id = {$id} LIMIT 1");
    }

    public function all(): array
    {
        $rows = $this->fetchAll("SELECT * FROM {$this->table}");
        return array_map(fn($r) => new $this->entityClass($r), $rows);
    }


    public function find(int $id): ?object
    {
        $rows = $this->fetchAll(
            "SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1"
        );
        return $rows ? new $this->entityClass($rows[0]) : null;
    }


    public function where(array $array = [], string $orden = "ASC"): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE ";
        foreach($array as $key => $value){
            if(array_key_last($array) == $key){
                $sql.= " {$key} = '{$value}'";
            }else{
                $sql.= " {$key} = '{$value}' AND ";
            }
        }
        $sql .= " ORDER BY id $orden;";
        $rows = $this->fetchAll($sql);
        return array_map(fn($r) => new $this->entityClass($r), $rows);
    }

}