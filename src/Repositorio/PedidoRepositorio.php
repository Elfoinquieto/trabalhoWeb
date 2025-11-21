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
        return new Pedido((int) $dados['id'], $dados['nome'], $dados['pacote'], $dados['descricao'], $dados['saite'] ?? '', $dados['modelo'], $dados['statos'] ?? 'pendente', $dados['email']);
    }
    public function listarPorEmail(string $email): array
    {
        $sql = "SELECT * FROM pedidos WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pedidos = [];

        foreach ($dados as $linha) {
            $pedidos[] = $this->formarObjeto($linha);
        }

        return $pedidos;
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

    public function negar(int $id): bool
    {
        $sql = "UPDATE pedidos SET statos = 'Negado' WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

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

    public function salvar(Pedido $pedido): void
    {
        $sql = "INSERT INTO pedidos(nome, pacote, descricao, saite, modelo, statos, email) VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $pedido->getNome());
        $stmt->bindValue(2, $pedido->getPacote());
        $stmt->bindValue(3, $pedido->getDescricao());
        $stmt->bindValue(4, $pedido->getSaite());
        $stmt->bindValue(5, $pedido->getModelo());
        $stmt->bindValue(6, $pedido->getStatos());
        $stmt->bindValue(7, $pedido->getEmail());
        $stmt->execute();
    }

    public function alterar(Pedido $pedido): void
    {
        $sql = "UPDATE pedidos SET nome = ?, pacote = ?, descricao = ?, saite = ?, modelo = ?, statos = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $pedido->getNome());
        $stmt->bindValue(2, $pedido->getPacote());
        $stmt->bindValue(3, $pedido->getDescricao());
        $stmt->bindValue(4, $pedido->getSaite());
        $stmt->bindValue(5, $pedido->getModelo());
        $stmt->bindValue(6, $pedido->getStatos());
        $stmt->bindValue(7, $pedido->getId());
        $stmt->execute();
    }

    public function deletar(string $id): bool
    {
        $st = $this->pdo->prepare("DELETE FROM pedidos WHERE id=?");
        return $st->execute([$id]);
    }

    public function listar(): array
    {
        $sql = "SELECT id, nome, pacote, descricao, saite, email, modelo FROM pedidos";
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