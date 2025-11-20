<?php

//Classe que faz as persisências no BD
class ModeloRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Modelo
    {
        return new Modelo((int)$dados['id'],$dados['nome'],$dados['pacote'],$dados['descricao'], $dados['imagem']);
    }

    public function buscarPornome(string $nome): ?Modelo 
    {   
        $sql = "SELECT id, nome, pacote, descricao, imagem FROM modelos WHERE nome =?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1,$nome);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados): null;
    }

    public function salvar(Modelo $modelo): void
    {
        $sql = "INSERT INTO modelos(nome, pacote, descricao, imagem) VALUES (?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $modelo->getNome());
        $stmt->bindValue(2, $modelo->getPacote());
        $stmt->bindValue(3, $modelo->getDescricao());
        $stmt->bindValue(4, $modelo->getImagem());
        $stmt->execute();
    }

    public function alterar(Modelo $modelo): void
    {
        $sql = "UPDATE modelos SET nome = ?, pacote = ?, descricao = ?, imagem = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $modelo->getNome());
        $stmt->bindValue(2, $modelo->getPacote());
        $stmt->bindValue(3, $modelo->getDescricao());
        $stmt->bindValue(4, $modelo->getImagem());
        $stmt->bindValue(5, $modelo->getId());
        $stmt->execute();
    }

    public function deletar(string $id): bool
    {
        $st = $this->pdo->prepare("DELETE FROM modelos WHERE id=?");
        return $st->execute([$id]);
    }

    public function listar(): array
    {
        $sql = "SELECT id, nome, pacote, descricao, imagem FROM modelos";
        $stmt = $this->pdo->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $modelos = [];
        foreach ($dados as $linha) {
            $modelos[] = $this->formarObjeto($linha);
        }

        return $modelos;
    }

}

?>