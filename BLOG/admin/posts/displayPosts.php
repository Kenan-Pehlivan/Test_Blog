<!-- Veränderungsdatum: 09.10.2024 
      Diese Datei zeigt für den Manage Post Seite also die index Seite Posts an mit deren Verwaltungsoptionen.
      Es wird hierbei zwischen Admin und normalen User unterschieden
-->

<!-- Wenn der User ein Admin ist -->
<?php if ($_SESSION['admin']): ?>
    <!-- Dann zeige alle Posts und alle extra Verwaltungsoptionen, wie delete und publish -->
    <?php foreach ($posts as $key => $post): ?>
        <tr>
            <td><?php echo $key + 1; ?></td>
            <td><?php echo $post['title']; ?></td>
            <td><?php $use = selectAll('users', ['id' => $post['user_id']]);
            echo $use[0]['username'];
            ?></td>
            <td><a href="edit.php?id=<?php echo $post['id']; ?>" class="edit">edit</a></td>
            <td><a href="edit.php?delete_id=<?php echo $post['id']; ?>" class="delete">delete</a></td>
            <?php if ($post['published']): ?>
                <td><a href="edit.php?published=0&p_id=<?php echo $post['id']; ?>" class="unpublish">unpublish</a></td>
            <?php else: ?>
                <td><a href="edit.php?published=1&p_id=<?php echo $post['id']; ?>" class="publish">publish</a></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <!-- Ansonsten zeige nur die normalen Verwaltungsoptionen an und nur die Posts von den aktuellen User-->
    <?php $anzahlPost = 1; ?>
    <?php foreach ($posts as $key => $post): ?>
        <tr>
            <?php if ($_SESSION['id'] === $post['user_id']): ?>
                <td><?php echo $anzahlPost; ?></td>
                <td><?php echo $post['title']; ?></td>
                <td><?php $use = selectAll('users', ['id' => $post['user_id']]);
                echo $use[0]['username'];
                ?></td>
                <td><a href="edit.php?id=<?php echo $post['id']; ?>" class="edit">edit</a></td>
                <td><a href="edit.php?delete_id=<?php echo $post['id']; ?>" class="delete">delete</a></td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>