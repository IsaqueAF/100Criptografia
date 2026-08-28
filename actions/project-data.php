<?php
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../config/database.php";

header("Content-Type: application/json; charset=utf-8");

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    echo json_encode(["erro" => "Faça login para usar esta função."]);
    exit();
}

$conn = getDB();
$userId = (int) $_SESSION["user_id"];
$method = $_SERVER["REQUEST_METHOD"];
$payload = json_decode(file_get_contents("php://input"), true) ?: [];
$action = $payload["acao"] ?? $_GET["acao"] ?? "listar";

function resposta($dados, int $status = 200): void {
    http_response_code($status);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    exit();
}

function estruturaValida($estrutura): bool {
    if (!is_array($estrutura) || count($estrutura) > 30) return false;
    foreach ($estrutura as $etapa) {
        if (!is_array($etapa) || !isset($etapa["nome"], $etapa["modo"])) return false;
        if (strlen((string) $etapa["nome"]) > 30 || strlen((string) $etapa["modo"]) > 20) return false;
    }
    return true;
}

try {
    if ($action === "listar") {
        $presets = [];
        $stmt = $conn->prepare("SELECT id, nome, estrutura, data_atualizacao FROM preset WHERE id_conta_usuario = ? AND ativo = 1 ORDER BY nome");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $row["estrutura"] = json_decode($row["estrutura"], true) ?: [];
            $presets[] = $row;
        }
        resposta(["presets" => $presets]);
    }

    if (!in_array($action, ["salvar", "substituir", "deletar", "historico"], true)) {
        resposta(["erro" => "Ação inválida."], 400);
    }

    if ($action === "listar-historico") {
        $historico = [];
        $stmt = $conn->prepare("SELECT id, entrada, saida, estrutura, data_execucao FROM historico WHERE id_conta_usuario = ? AND ativo = 1 ORDER BY data_execucao DESC LIMIT 20");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $row["estrutura"] = json_decode($row["estrutura"], true) ?: [];
            $historico[] = $row;
        }
        resposta(["historico" => $historico]);
    }

    if ($action === "historico") {
        $estrutura = $payload["estrutura"] ?? [];
        if (!estruturaValida($estrutura)) resposta(["erro" => "Estrutura inválida."], 422);
        $entrada = (string) ($payload["entrada"] ?? "");
        $saida = (string) ($payload["saida"] ?? "");
        $json = json_encode($estrutura, JSON_UNESCAPED_UNICODE);
        $stmt = $conn->prepare("INSERT INTO historico (id_conta_usuario, entrada, saida, estrutura) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $userId, $entrada, $saida, $json);
        $stmt->execute();
        resposta(["id" => $conn->insert_id]);
    }

    $id = (int) ($payload["id"] ?? 0);
    if ($action === "deletar") {
        if (!$id) resposta(["erro" => "Preset inválido."], 422);
        $stmt = $conn->prepare("UPDATE preset SET ativo = 0 WHERE id = ? AND id_conta_usuario = ?");
        $stmt->bind_param("ii", $id, $userId);
        $stmt->execute();
        resposta(["ok" => true]);
    }

    $nome = trim((string) ($payload["nome"] ?? ""));
    $estrutura = $payload["estrutura"] ?? [];
    if ($nome === "" || strlen($nome) > 50 || !estruturaValida($estrutura)) {
        resposta(["erro" => "Informe um nome válido e pelo menos uma etapa válida."], 422);
    }
    $json = json_encode($estrutura, JSON_UNESCAPED_UNICODE);

    if ($action === "substituir") {
        if (!$id) resposta(["erro" => "Preset inválido."], 422);
        $stmt = $conn->prepare("UPDATE preset SET nome = ?, estrutura = ? WHERE id = ? AND id_conta_usuario = ? AND ativo = 1");
        $stmt->bind_param("ssii", $nome, $json, $id, $userId);
    } else {
        $stmt = $conn->prepare("INSERT INTO preset (id_conta_usuario, nome, estrutura) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $nome, $json);
    }
    $stmt->execute();
    resposta(["ok" => true, "id" => $id ?: $conn->insert_id]);
} catch (Throwable $error) {
    resposta(["erro" => "Não foi possível concluir a operação."], 500);
}
