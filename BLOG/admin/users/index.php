<!-- Veränderungsdatum 10.10.2024
    Diese Datei zeigt den Update-User Formular nachdem man von Manage User index Seite den edit anklickt.
    Mit diesen Formular kann ein user verändert bzw. akualisiert werden.
-->

<?php require("../../path.php"); ?>
<?php require(ROOT_PATH . "/app/controllers/users.php");
adminOnly();    // Sicherstellen, dass nur der Admin Zugriff darauf hat
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- Font Awesome -->
        <link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
            integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr"
            crossorigin="anonymous">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Candal|Lora"
            rel="stylesheet">

        <!-- CSS Styling -->
        <link rel="stylesheet" href="../../assets/css/style.css">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="../../assets/css/admin.css">

        <title>Admin Section - Manage Users</title>
    </head>

    <body>
       <!-- Einfügen des Admin headers aus includes verzeichnis -->
        <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">
           
            <!-- Linke Sidebar mit den Verwaltungsoptionen aus include adminSidebar -->
            <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

            <!-- Admin Content -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Add User</a>
                    <a href="index.php" class="btn btn-big">Manage Users</a>
                </div>

                <div class="content">

                    <h2 class="page-title">Manage Users</h2>
                    
                    <!-- Alle Success/Error Messages werden angezeigt -->
                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th colspan="2">Action</th>
                        </thead>
                        <tbody>
                             <!-- Für jeden User die es in der Datenbank gibt-->
                            <?php foreach ($admin_users as $key => $user): ?>
                                 <!--liste deren username und email. Gebe für jeden auch die Verwaltungsoption ein Benutzer zu Löschen oder verändern -->
                                <tr>
                                    <td><?php echo $key + 1; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td><a href="edit.php?id=<?php echo $user['id']; ?>" class="edit">edit</a></td>
                                    <td><a href="index.php?delete_id=<?php echo $user['id']; ?>" class="delete">delete</a></td>
                                </tr>
                            <?php endforeach; ?>                          
                    </table>
                </div>
            </div>
        </div>

        <!-- JQuery -->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Ckeditor -->
        <script
            src="https://cdn.ckeditor.com/ckeditor5/12.2.0/classic/ckeditor.js"></script>
        <!-- JS Skript -->
        <script src="../../assets/js/scripts.js"></script>

    </body>

</html>