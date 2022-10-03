<?php
/**
 * Displays a user's profile.
 */

 require_once "sql_queries.php";

 $user = get_user($_GET["username"]);

 if (empty($user)) {
    header("profile_not_found.php");
    exit();
 }

 include "includes/head.php";
 ?>

 <body>
    <?php
    include "includes/header.php";
    ?>

    <main>
        <p>
            Profile found
        </p>
    </main>
</body>

<?php
include  "includes/tail.php";
?>
