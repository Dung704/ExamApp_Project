<?php
session_start();

if (isset($_SESSION['exam_active'])) {

    unset($_SESSION['exam_active']);
    unset($_SESSION['exam_id']);

}