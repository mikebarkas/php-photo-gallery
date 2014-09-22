    </div><!-- close .inner -->
  </div><!-- close #content -->
  <div id="footer">
    <div class="inner">
      <p>&copy; <?php echo date('Y');?> Mike Barkas<br/>Photo Gallery Project</p>
    </div>
  </div>
</body>
</html>
<?php if (isset($db)) { $db->close_connection(); } ?>