<!-- Veränderungsdatum: 09.10.2024 
    Diese Datei zeigt den Edit-Post Formular, welcher erlaubt den Benutzer/Admin Posts zu bearbeiten.
    Die übliche Felder des Formulars müssen hierbei wieder ausgefüllt werden. 
    Dabei kann der Admin die Posts direkt publishen und der Benutzer muss den Admin benachrichten falls er den Post publishen will nach der Änderung

-->

<?php require("../../path.php"); ?>
<?php require(ROOT_PATH . "/app/controllers/posts.php");
usersOnly(); // Nur User und Admin haben Zugriff auf diese Webseite
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Candal|Lora" rel="stylesheet">

    <!-- CSS Styling -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <!-- Admin Styling -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <title>Admin Section - Edit Post</title>
</head>

<body>
    <!-- admin header aus includes -->
    <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

    <!-- Admin Page Wrapper -->
    <div class="admin-wrapper">

        <!-- // Left Sidebar aus include adminSidebar -->
        <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

        <!-- Admin Content: Einfügen von Schaltflächen für die Navigationen, Error Handling, Input Fields des Edit Posts: Formular um Post zu editen 
         Schleife über alle verfügbaren Topics aus dem Dropdown, Fallunterscheidung von Admin und User publishen -- 
         Action Button zum publish oder für die Email -->
        <div class="admin-content">
            <div class="button-group">
                <a href="create.php" class="btn btn-big">Add Post</a>
                <a href="index.php" class="btn btn-big">Manage Posts</a>
            </div>

            <div class="content">

                <h2 class="page-title">Edit Posts</h2>

                <?php include(ROOT_PATH . "/app/helpers/formErrors.php"); ?>

                <form action="create.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $id ?>">
                    <div>
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo $title ?>" class="text-input">
                    </div>
                    <div>
                        <label>Body</label>
                        <textarea name="body" id="body"><?php echo $body ?></textarea>
                    </div>
                    <div>
                        <label>Image</label>
                        <input type="file" name="image" class="text-input">
                    </div>
                    <div>
                        <label>Topic</label>
                        <select name="topic_id" class="text-input">
                            <option value=""></option>

                            <?php foreach ($topics as $key => $topic): ?>

                                <?php if (!empty($topic_id) && $topic_id == $topic['id']): ?>
                                    <option selected value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>

                                <?php else: ?>
                                    <option selected value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div>

                        <?php if ($_SESSION['admin']): ?>
                            <?php if (empty($published) && $published == 0): ?>
                                <label>
                                    <input type="checkbox" name="published">
                                    Publish
                                </label>
                            <?php else: ?>
                                <label>
                                    <input type="checkbox" name="published" checked>
                                    Publish
                                </label>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if (empty($published) && $published == 0): ?>
                                <label>
                                    <input type="checkbox" name="AdminPublish">
                                    Zum Publishen den Admin senden
                                </label>
                            <?php else: ?>
                                <label>
                                    <input type="checkbox" name="AdminPublish" checked>
                                    Zum Publishen den Admin senden
                                </label>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                    <div>
                        <button type="submit" name="update-post" class="btn btn-big">Update Post</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Ckeditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
    <!-- JS Skript -->
    <script src="../../assets/js/scripts.js"></script>

</body>

</html>