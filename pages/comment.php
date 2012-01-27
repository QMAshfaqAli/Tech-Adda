<?php

if (!empty($_POST)) {
    App::getRepository('Comment')->create($_POST);
    if ($_POST['talk_id'] != null) {
        header('Location: ' . ViewHelper::url('?page=talk&id=' . $_POST['talk_id'], true));
    } else {
        header('Location: ' . ViewHelper::url('?page=event&id=' . $_POST['event_id'].'#comment', true));
    }
} else {
    header('Location: ' . ViewHelper::url('', true));
}