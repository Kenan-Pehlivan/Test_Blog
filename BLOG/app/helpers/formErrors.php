<!-- Veränderungsdatum: 08.10.2024 
    Gebe alle Errors aus
-->

<?php if (count($errors)>0): ?>   
    <div class="msg error">
      <?php foreach ($errors as $error): ?> 
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>  
    </div> 
<?php endif; ?>


