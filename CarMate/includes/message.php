<?php
    if (isset($_GET['message']) && !empty($_GET['message'])) {
        echo '<p>' . htmlspecialchars($_GET['message']) . '</p>';
    }
?>