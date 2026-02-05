<?php

namespace App\Repositories;

abstract class operationRepository extends BaseRepository{

    protected string $table;
    protected string $entityClass;  //entidad o modelo
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


    public function crear_varios_reg_arrayobj(array $arrays = []):array{  // $arrays = [{'col1':a, 'col2':b}, {'col1':c, 'col2':d}, ...] 
        $string2 = '';

        foreach($arrays as $key => $obj){
            // si viene como stdClass → convertir a array
        //if($obj instanceof \stdClass)
            $array = (array)$obj;
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


    public function update(object $entity){
        $data = $entity->toArray();
        $sets = [];
        $id = $entity->id;;
        $query = "UPDATE {$this->table} SET ";
        foreach( $data as $key => $value){
            if($value === null || $value == ''){
                $sets[] = "{$key}=NULL";
                continue;
            }
            if(is_numeric($value)){
                $sets[] = "{$key}={$value}";
                continue;
            }
            $sets[] = "{$key}='{$value}'";
        }
        $query .= implode(', ', $sets);
        $query .= " WHERE id = {$id} LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }


    public function updatemultiregobj(array $array=[], array $colums=[]){
        $query = "UPDATE {$this->table} SET ";
        $in = '';
        foreach($colums as $idx => $col){
            $query .= $col." = CASE ";
            foreach($array as $index => $value){
                if(array_key_first($colums) === $idx){
                    $query .= "WHEN id = $value->id THEN '{$value->$col}' ";
                    if(array_key_last($array) === $index){
                        $in .= "$value->id";
                    }else{
                        $in .= "$value->id, ";
                    }
                }else{
                    $query .= "WHEN id = $value->id THEN '{$value->$col}' ";
                }
            }
            if(array_key_last($colums) === $idx){
                $query .= "ELSE $col END WHERE id IN ($in);";
            }else{
                $query .= "ELSE $col END, ";
            }
        }
        debuguear($query);
    }


    public function delete(int $id): bool
    {
        return self::$db->query("DELETE FROM {$this->table} WHERE id = {$id} LIMIT 1");
    }


    public function delete_regs(string $id, $array = []): bool
    {
        return self::$db->query("DELETE FROM {$this->table} WHERE {$id} IN (".join(', ', $array).")");
    }


    public function all(): array
    {
        $rows = $this->fetchAll("SELECT * FROM {$this->table}");
        return array_map(fn($r) => new $this->entityClass($r), $rows);
    }


    public function find(int $id): ?object
    {
        $rows = $this->fetchAll("SELECT * FROM {$this->table} WHERE id = {$id} LIMIT 1");
        return $rows ? new $this->entityClass($rows[0]) : null;
    }


    public function findAll(string $col, int $id): ?array  //similar a idregistros
    {
        $rows = $this->fetchAll("SELECT * FROM {$this->table} WHERE $col = {$id}");
        return $rows ?  array_map(fn($r) => new $this->entityClass($r), $rows) : [];
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


    public function uniqueWhere(array $array = [], string $orden = "ASC"):object
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
        return new $this->entityClass($rows[0]);
    }


    public function IN_Where(string $colum, array $array = [], array $filter=[]):array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$colum} IN(";
        foreach($array as $key => $value){
            if(array_key_last($array) == $key){
                $sql.= "{$value}) AND $filter[0] = $filter[1];";
            }else{
                 $sql.= "{$value}, ";
            }
        }
        $rows = $this->fetchAll($sql);
        return $rows ? array_map(fn($r) => new $this->entityClass($r), $rows): [];
    }


    public function unJoinWhereArrayObj(string $targetTable, string $fkLocal, string $fkTarget, array $where = []):array{
        $sql = "SELECT {$this->table}.*, {$targetTable}.*, {$this->table}.id AS ID 
                FROM {$this->table} 
                JOIN {$targetTable} ON {$this->table}.{$fkLocal} = {$targetTable}.{$fkTarget}";

        if (!empty($where)) {
            $sql .= " WHERE";
            foreach ($where as $key => $value) {
                if(array_key_last($where) == $key){
                    $sql.= " ${key} = '${value}';";
                }else{
                    $sql.= " ${key} = '${value}' AND ";
                }
            }
        }
        $rows = $this->fetchAllStd($sql);
        return $rows;
    }

}