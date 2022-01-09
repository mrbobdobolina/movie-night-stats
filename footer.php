<footer class="text-muted py-5">
  <div class="container">
				Version <?php echoVersionNumber(); ?> <a href="changelog.php">Changelog</a> <small><?php $endtime = microtime(true);
printf("Page loaded in %f seconds", $endtime - $starttime );?></small>
   </div>
</footer>
    <script src="bootstrap5/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
  </body>
</html>