<?php

//Classe que faz as persisências no BD
class PedidoRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function formarObjeto(array $dados): Pedido
    {
        return new Pedido((int) $dados['id'], $dados['nome'], $dados['pacote'], $dados['descricao'], $dados['saite'] ?? '', $dados['modelo'], $dados['statos'] ?? 'pendente');
    }
    public function contarTotal(): int
    {
        $sql = "SELECT COUNT(*) FROM pedidos";
        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    public function buscarPaginado(int $limite, int $offset, ?string $ordem = null, string $direcao = 'ASC'): array
    {
        $colunasPermitidas = ['nome', 'pacote'];
        $sql = "SELECT * FROM pedidos ";
        if ($ordem !== null && in_array(strtolower($ordem), $colunasPermitidas)) {
            $direcao = strtoupper($direcao) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= "ORDER BY {$ordem} {$direcao} ";
        }
        $sql .= " LIMIT ? OFFSET ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pedidos = [];

        foreach ($dados as $linha) {
            $pedidos[] = $this->formarObjeto($linha);
        }

        return $pedidos;
    }

    public function atualizarStatos(int $id, string $novaStatos): bool
    {
        $sql = "UPDATE pedidos SET statos = :statos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':statos', $novaStatos, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function atualizarSaite(int $id, string $novaSaite): bool
    {
        $sql = "UPDATE pedidos SET saite = :saite WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':saite', $novaSaite, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPornome(string $nome): ?Pedido
    {
        $sql = "SELECT id, nome, pacote, descricao, saite, modelo, statos FROM pedidos WHERE nome =?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $nome);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function salvar(Pedido $modelo): void
    {
        $sql = "INSERT INTO pedidos(nome, pacote, descricao, saite, modelo, statos) VALUES (?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $modelo->getNome());
        $stmt->bindValue(2, $modelo->getPacote());
        $stmt->bindValue(3, $modelo->getDescricao());
        $stmt->bindValue(4, $modelo->getSaite());
        $stmt->execute();
    }

    public function alterar(Pedido $modelo): void
    {
        $sql = "UPDATE pedidos SET nome = ?, pacote = ?, descricao = ?, saite = ?, modelo = ?, statos = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $modelo->getNome());
        $stmt->bindValue(2, $modelo->getPacote());
        $stmt->bindValue(3, $modelo->getDescricao());
        $stmt->bindValue(4, $modelo->getSaite());
        $stmt->bindValue(5, $modelo->getModelo());
        $stmt->bindValue(6, $modelo->getStatos());
        $stmt->bindValue(7, $modelo->getId());
        $stmt->execute();
    }

    public function deletar(string $id): bool
    {
        $st = $this->pdo->prepare("DELETE FROM pedidos WHERE id=?");
        return $st->execute([$id]);
    }

    public function listar(): array
    {
        $sql = "SELECT id, nome, pacote, descricao, saite, modelo FROM pedidos";
        $stmt = $this->pdo->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pedidos = [];
        foreach ($dados as $linha) {
            $pedidos[] = $this->formarObjeto($linha);
        }

        return $pedidos;
    }

}

?>