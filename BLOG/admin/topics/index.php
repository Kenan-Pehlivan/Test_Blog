<!-- Veränderungsdatum: 08.10.2024 
      Diese Datei ist die Homepage Seite für die Topics. Von hier aus wird man weitergeleitet um Topic zu erstellen, bearbeiten und zu löschen.
      Nur dem Admin sichtbar
-->

<?php require("../../path.php"); ?>
<?php require(ROOT_PATH . "/app/controllers/topics.php"); 
adminOnly(); // Nur Admin hat Zugriff auf die "Homepage" der Topic Funktionen
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

        <!-- Custom Styling -->
        <link rel="stylesheet" href="../../assets/css/style.css">

        <!-- Admin Styling -->
        <link rel="stylesheet" href="../../assets/css/admin.css">

        <title>Admin Section - Manage Topics</title>
    </head>

    <body>
       <!-- admin header aus includes -->
        <?php include(ROOT_PATH . "/app/includes/adminHeader.php"); ?>

        <!-- Admin Page Wrapper -->
        <div class="admin-wrapper">
            
            <!-- // Left Sidebar aus include adminSidebar -->
            <?php include(ROOT_PATH . "/app/includes/adminSidebar.php"); ?>

            <!-- Admin Content: Navigationsleiste mit Schaltflächen um Topics zu bearbeiten, hinzuzufügen, und deleten, Messages (Error/Sucess) -->
            <div class="admin-content">
                <div class="button-group">
                    <a href="create.php" class="btn btn-big">Add Topic</a>
                    <a href="index.php" class="btn btn-big">Manage Topics</a>
                </div>

                <div class="content">

                    <h2 class="page-title">Manage Topics</h2>

                    <?php include(ROOT_PATH . "/app/includes/messages.php"); ?>

                    <table>
                        <thead>
                            <th>SN</th>
                            <th>Name</th>
                            <th colspan="2">Action</th>
                        </thead>
                        <tbody>
                           
                            <?php foreach ($topics as $key => $topic): ?>
                        
                                 <tr>
                                      <td><?php echo $key + 1; ?></td>
                                      <td><?php echo $topic['name']; ?></td>
                                     <td><a href="edit.php?id=<?php echo $topic['id']; ?>" class="edit">edit</a></td>
                                     <td><a href="index.php?del_id=<?php echo $topic['id']; ?>" class="delete">delete</a></td>
                                </tr>
                            <?php endforeach; ?>
                           
                        </tbody>
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
        <!-- CSS Skript -->
        <script src="../../assets/js/scripts.js"></script>

    </body>

</html>