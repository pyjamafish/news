<?php
/**
 * Allows a user to edit a post.
 */
require_once "sql_queries.php";

$post = null;
$author = null;

function update() {
    global $post;
    update_post($post["post_id"], $_POST["title"], $_POST["body"], $_POST["link"]);
}

function main() {
    global $post;
    global $author;

    session_start();

    if (!isset($_GET["post_id"])) {
        // No post id given
        header("Location: index.php");
        exit();
    }

    $post = get_post($_GET["post_id"]);

    if (empty($post)) {
        // If no post is found by query, redirect.
        header("Location: post_not_found.php");
        exit();
    }

    $author = get_post_author($_GET["post_id"]);

    session_start();
    if ($author["username"] != $_SESSION["username"]) {
        // Username doesn't match
        header("Location: index.php");
        exit();
    }

    if (isset($_POST["title"])) {
        if(!hash_equals($_SESSION['token'], $_POST['token'])){
            die("Request forgery detected");
        }

        update();
        header("Location: post.php?post_id=" . $post["post_id"]);
        exit();
    }
}

main();

include "includes/head.php";
?>

<body>
    <?php include "includes/header.php" ?>
    <main>
        <h1>
            Edit post
        </h1>
        <form action="<?php echo $_SERVER['PHP_SELF'] . "?post_id=" . $post["post_id"];?>" method="POST">
            <p>
                <label for="title" class="required">Title:</label>
                <br>
                <input type="text" name="title" id="title" required value="<?php echo $post["title"];?>">
            </p>
            <p>
                <label for="link">Link:</label>
                <br>
                <input type="text" name="link" id="link" value="<?php echo $post["link"];?>">
            </p>
            <p>
                <label for="body" class="required">Body:</label>
                <br>
                <textarea name="body" id="body" rows="4" cols="50" required><?php echo $post["body"];?></textarea>
            </p>
            <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
            <p>
                <input type="submit" value="Submit">
            </p>
        </form>
    </main>
</body>
