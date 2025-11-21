<?php

//Classe que faz as persisências no BD
class UsuarioRepositorio
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function alterar(Usuario $usuario): bool
    {
        $sql = "UPDATE usuarios SET nome_completo = :nome, email = :email, telefone = :telefone WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':nome', $usuario->getNomeCompleto(), PDO::PARAM_STR);
        $stmt->bindValue(':email', $usuario->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(':telefone', $usuario->getTelefone(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $usuario->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }
    public function alterarSenha(Usuario $usuario): bool
    {
        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(1, password_hash($usuario->getSenha(), PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(2, $usuario->getId(), PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function contarTotal(): int
    {
        $sql = "SELECT COUNT(*) FROM usuarios";
        return (int) $this->pdo->query($sql)->fetchColumn();
    }

    public function buscarPaginado(int $limite, int $offset, ?string $ordem = null, string $direcao = 'ASC'): array
    {
        $colunasPermitidas = ['email', 'permissao'];
        $sql = "SELECT * FROM usuarios ";
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
        $usuarios = [];

        foreach ($dados as $linha) {
            $usuarios[] = $this->formarObjeto($linha);
        }

        return $usuarios;
    }
    public function formarObjeto(array $dados): Usuario
    {
        $permissao = $dados['permissao'] ?? 'user';
        return new Usuario((int) $dados['id'], $dados['email'], $dados['senha'], $dados['nome_completo'], $dados['telefone'], $permissao);
    }


    public function atualizarPermissao(int $id, string $novaPermissao): bool
    {
        $sql = "UPDATE usuarios SET permissao = :permissao WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':permissao', $novaPermissao, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
    public function buscarPorId(int $id): ?Usuario
    {
        $sql = "SELECT id, email, senha, nome_completo, telefone, permissao FROM usuarios WHERE id =?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }
    public function buscarPorEmail(string $email): ?Usuario
    {
        $sql = "SELECT id, email, senha, nome_completo, telefone, permissao FROM usuarios WHERE email =?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $email);
        $stmt->execute();
        $dados = $stmt->fetch();
        return $dados ? $this->formarObjeto($dados) : null;
    }

    public function autenticar(string $email, string $senha): bool
    {
        $usuario = $this->buscarPorEmail($email);
        return $usuario ? password_verify($senha, $usuario->getSenha()) : false;
    }

    public function salvar(Usuario $usuario): void
    {
        $sql = "INSERT INTO usuarios(email, senha, nome_completo, telefone) VALUES (?,?,?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $usuario->getEmail());
        $stmt->bindValue(2, password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stmt->bindValue(3, $usuario->getNomeCompleto());
        $stmt->bindValue(4, $usuario->getTelefone());
        $stmt->execute();
    }

    public function listar(): array
    {
        $sql = "SELECT id, email, senha, nome_completo, telefone, permissao FROM usuarios";
        $stmt = $this->pdo->query($sql);
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $usuarios = [];
        foreach ($dados as $linha) {
            $usuarios[] = $this->formarObjeto($linha);
        }

        return $usuarios;
    }

    public function deletar(int $id): bool
    {
        $st = $this->pdo->prepare("DELETE FROM usuarios WHERE id=?");
        return $st->execute([$id]);
    }

}

?>