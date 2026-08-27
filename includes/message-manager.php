<?php
require_once __DIR__ . "/../config/session.php";

function addMessage($id, $message, $concatenate = true) {
    if ($concatenate) {
        if (!isset($_SESSION["messages"][$id])) {
            $_SESSION["messages"][$id] = "";
        }
        $_SESSION["messages"][$id] .= $message . "<br>";
    } else {
        $_SESSION["messages"][$id] = $message;
    }
}

function getMessage($id) {
    if (isset($_SESSION["messages"][$id])) {
        $message = $_SESSION["messages"][$id];
        unset($_SESSION["messages"][$id]);
        return $message;
    }
    return "";
}

function clearMessages(...$id) {
    foreach ($id as $i) {
        unset($_SESSION["messages"][$i]);
    }
}

function hasMessages(...$ids) {
    if (empty($ids)) {
        return !empty($_SESSION["messages"]);
    }
    foreach ($ids as $id) {
        if (isset($_SESSION["messages"][$id])) {
            return true;
        }
    }
    return false;
}
?>