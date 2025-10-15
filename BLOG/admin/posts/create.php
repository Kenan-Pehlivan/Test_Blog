<!-- Veränderungsdatum: 09.10.2024 
      Diese Datei zeigt den Create-Post Formular, welcher erlaubt den Benutzer Posts zu erstellen. 
      Dabei kann der Admin die Posts direkt publishen und der Benutzer muss den Admin benachrichten falls er den Post publishen will.
-->

<?php require("../../path.php"); ?>
<?php require(ROOT_PATH . "/app/controllers/posts.php");
usersOnly();
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

    <!-- CSS Stil -->
    <link rel="stylesheet" href="../../assets/css/style.css">

    <!-- Admin CSS Stil -->
    <link rel="stylesheet" href="../../assets/css/admin.css">

    <title>Admin Section - Add Post</title>
</head>

<body>
    <!-- Einfügen des Admin headers aus includes -->
    <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

    <!-- Admin Page Wrapper -->
    <div class="admin-wrapper">

        <!-- Linke Sidebar aus include adminSidebar mit verschieden Verwaltungsoptionen -->
        <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

        <!-- Admin Content -->
        <div class="admin-content">
            <div class="button-group">
                <a href="create.php" class="btn btn-big">Add Post</a>
                <a href="index.php" class="btn btn-big">Manage Posts</a>
            </div>
            <div class="content">
                <h2 class="page-title">Create Posts</h2>

                <?php include(ROOT_PATH . '/app/helpers/formErrors.php'); ?>

                <form action="create.php" method="post" enctype="multipart/form-data">
                    <div>
                        <label>Title</label>
                        <input type="text" name="title" value="<?php echo $title ?>" class="text-input">
                    </div>
                    <div>
                        <label>Body</label>
                        <textarea name="body" id="body"><?php echo $title ?></textarea>
                    </div>
                    <div>
                        <label>Image</label>
                        <input type="file" name="image" class="text-input">
                    </div>
                    <div>
                        <label>Topic</label>
                        <select name="topic_id" class="text-input">
                            <option value=""></option>
                            <!-- Dürchlaufe alle Topics-->
                            <?php foreach ($topics as $key => $topic): ?>
                                <!-- Wenn der Topic feld nicht leer ist und den Wert der aktuellen Topic hat, dann zeige den Topic als ausgewählten an -->
                                <?php if (!empty($topic_id) && $topic_id == $topic['id']): ?>
                                    <option selected value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                                <?php else: ?>
                                    <!-- ansonten zeige den aktuellen topic normal an-->
                                    <option selected value="<?php echo $topic['id'] ?>"><?php echo $topic['name'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <!-- Ist der User ein Admin?-->
                        <?php if ($_SESSION['admin']): ?>
                            <!-- wenn ja, dann zeige den Publish checkbox-->

                            <!-- Ist der checkbox nicht gestezt, dann zeige diese als nicht angestzt-->
                            <?php if (empty($published)): ?>
                                <label>
                                    <input type="checkbox" name="published">
                                    Publish
                                </label>
                            <?php else: ?>
                                <!-- ansonsten zeige diese als gesetzt-->
                                <label>
                                    <input type="checkbox" name="published" checked>
                                    Publish
                                </label>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- wenn nicht, dann zeige den checkbox Zum publishen an Admin senden -->

                            <!-- Ist der checkbox nicht gestezt, dann zeige diese als nicht angestzt-->
                            <?php if (empty($published)): ?>
                                <label>
                                    <input type="checkbox" name="AdminPublish">
                                    Zum Publishen an Admin senden
                                </label>
                            <?php else: ?>
                                <!-- ansonsten zeige diese als gesetzt-->
                                <label>
                                    <input type="checkbox" name="AdminPublish" checked>
                                    Zum Publishen an Admin senden
                                </label>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div>
                        <button type="submit" name="add-post" class="btn btn-big">Add Post</button>
                    </div>
                </form>

            </div>
        </div>
        <!-- // Admin Content -->
    </div>
    <!-- // Page Wrapper -->

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Ckeditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
    <!-- Custom Script -->
    <script src="../../assets/js/scripts.js"></script>

</body>

</html>