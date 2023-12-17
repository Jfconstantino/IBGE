<?php
// Carrega as funções para consultar direto na API do IBGE
include __DIR__ . '/_conecta.php';
include __DIR__ . '/_funcoes.php';

function processaEstados()
{
    try {
        global $pdo;

        $pdo->beginTransaction();
        $estados = ibgeEstados();

        if ($estados !== null) {
            foreach ($estados as $estado) {
                $id = $estado['id'];
                $sigla = $estado['sigla'];
                $nome = $estado['nome'];

                $stmt = $pdo->prepare("SELECT * FROM estados WHERE estados_uf = :sigla");
                $stmt->bindValue(':sigla', $sigla, PDO::PARAM_STR);
                $stmt->execute();
                $registroEstados = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($registroEstados) {
                    $stmt = $pdo->prepare("UPDATE estados SET estados_codigo = :id, estados_nome = :nome WHERE estados_uf = :sigla");
                } else {
                    $stmt = $pdo->prepare("INSERT INTO estados (estados_codigo, estados_uf, estados_nome) VALUES (:id, :sigla, :nome)");
                }

                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
                $stmt->bindValue(':sigla', $sigla, PDO::PARAM_STR);
                $stmt->execute();
            }

            $pdo->commit();
            echo "Operação de estados concluída com sucesso!\n";
        } else {
            echo "Nenhum estado foi localizado\n";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Erro ao processar estados: " . $e->getMessage() . "\n");
    }
}

function processaMunicipios()
{
    try {
        global $pdo;

        $pdo->beginTransaction();
        $municipios = ibgeMunicipios();

        if ($municipios !== null) {
            foreach ($municipios as $municipio) {
                $id = $municipio['id'];
                $estado_codigo = $municipio['microrregiao']['mesorregiao']['UF']['id'];
                $estado = $municipio['microrregiao']['mesorregiao']['UF']['sigla'];
                $nome = $municipio['nome'];

                $stmt = $pdo->prepare("SELECT * FROM municipios WHERE municipios_codigo = :id");
                $stmt->bindValue(':id', $id, PDO::PARAM_STR);
                $stmt->execute();
                $registroMunicipios = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($registroMunicipios) {
                    $stmt = $pdo->prepare("UPDATE municipios SET municipios_codigo = :id, municipios_nome = :nome, municipios_uf_codigo = :siglaId, municipios_uf = :sigla WHERE municipios_codigo = :id");
                } else {
                    $stmt = $pdo->prepare("INSERT INTO municipios (municipios_codigo, municipios_nome, municipios_uf_codigo, municipios_uf) VALUES (:id, :nome, :siglaId, :sigla)");
                }

                $stmt->bindValue(':id', $id, PDO::PARAM_STR);
                $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
                $stmt->bindValue(':siglaId', $estado_codigo, PDO::PARAM_STR);
                $stmt->bindValue(':sigla', $estado, PDO::PARAM_STR);
                $stmt->execute();
            }

            $pdo->commit();
            echo "Operação de municípios concluída com sucesso!\n";
        } else {
            echo "Nenhum município foi localizado\n";
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Erro ao processar municípios: " . $e->getMessage() . "\n");
    }
}

// Verifica o argumento passado
if (!empty($argv[1])) {
    if ($argv[1] === "estados") {
        processaEstados();
    } elseif ($argv[1] === "municipios") {
        processaMunicipios();
    } else {
        die("Argumento inválido. Use 'estados' ou 'municipios'.\n");
    }
} else {
    die("Argumento ausente. Use 'estados' ou 'municipios'.\n");
}
