<?php
//metodos para com o banco de dados
    class TarefaService{
        private $conexao;
        private $tarefa;

        public function __construct(Conexao $conexao,Tarefa $tarefa){
            $this -> $conexao = $conexao ->conectar();
            $this -> $tarefa = $tarefa; 

        }
        public function inserir(){
            //C - create
            $query = 'insert into tb_tarefas(tarefa)values(:tarefa)';
            $stmt = $this->conexao -> prepare($query);
            $stmt->bindValue('tarefa',$this->tarefa->__get('tarefa'));
            $stmt ->execute();
        }
        public function recuperar(){
            //R = read
            $query = '
            select
                t.id, s.status, t.tarefa
            from
            tb_tarefas as t 
            left join tb_status as s on (t.id_status = s.id)
            ';
            $stmt = $this->conexao->prepare ($query);
            $stmt-> execute();
            return $stmt->fetchALL(PDO::FETCH_OBJ);
        }

        public function atualizar(){
            //U - Update
            $query = "update tb_tarefa set tarefa = ? where id = ?";
            $stmt = $this->conexao -> prepare($query);
            $stmt ->bindValue(1, $this -> tarefa ->__get('tarefa'));
            $stmt -> bindValue(2, $this -> tarefa ->__get('id'));
            return $stmt ->execute();
    }

    public function remover(){
        //D - delete
        $query = 'dele from tb_tarefa where id = :id';
        $stmt = $this ->conexao-> prepare($query);
        $stmt ->bindValue('id',$this->tarefa->__get('id'));
        $stmt -> execute();
    }

     public function marcarRealizada(){
        $query = "update tb_tarefa set id_status = ? where id = ?";
        $stmt = $this->conexao -> prepare($query);
        $stmt ->bindValue(1, $this -> tarefa ->__get('id_status'));
        $stmt -> bindValue(2, $this -> tarefa ->__get('id'));
        return $stmt ->execute();
}

public function RecuperarTarefasPendentes(){
    $query = 'select t.id, s_status,t.tarefa
    from 
        tb_tarefa as t
        left join tb_status as s on(t.id_status = s.id)
        where
            t.id_status = :id_status    
    ';
    $stmt = $this->conexao -> prepare($query);
    $stmt ->bindValue(':id_status', $this -> tarefa->__get('id_status'));
    $stmt -> execute();
    return $stmt -> fetch(PDO::FETCH_OBJ);
}
}



?>